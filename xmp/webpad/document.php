<?php
require_once('admin/configuration.php');
require_once('admin/authentication.php');
require_once('locations/common.php');

// Fix for magic quotes, if they're turned on
if (get_magic_quotes_gpc()) {
	$_POST['wp_document'] = stripslashes($_POST['wp_document']);
}

// Start with a clean slate
$wp_document = false;
$output = false;

// 'override' is set to 'true' for a 'save', so we need to
// switch to a save operation, and set the save_type appropriately (last open type)
if ($_POST['override'] == 'true') {
	$_SESSION['operation'] = $_POST['operation'];
	if ($_SESSION['open_type'] != 'new') {
		$_SESSION['save_type'] = $_SESSION['open_type'];
	}
}

// Set the filename to defaults if there isn't one
if (!isset($_SESSION['filename']) || $_SESSION['filename'] == '') {
	$_SESSION['operation'] = 'new';
	$_SESSION['filename']  = 'new_webpad_document';
}

// If the incoming request operation is a 'new', then update the session
if ($_REQUEST['operation'] == 'new' && $_REQUEST['filename'] == 'new') {
	$_SESSION['operation'] = 'new';
	$_SESSION['filename']  = 'new_webpad_document';
	$_SESSION['open_type'] = 'new';
}

// If incoming is 'save' and last was 'http', then force to http as the save type and trigger a
// better save operation.
if ($_SESSION['operation'] == 'save' && $_SESSION['last_type'] == 'http') {
	$_SESSION['save_type'] = 'http';
}

// If incoming request is a save, but there's no POST array, then
// switch to new instead
if ($_SESSION['operation'] == 'save' && $_POST['wp_document'] == '' && $_SESSION['save_type'] != 'upload') {
        $_SESSION['operation'] = 'new';
        $_SESSION['filename'] = 'new_webpad_document';
        $_SESSION['display_filename'] = 'new_webpad_document';
}

// Forking to handle all the permutations of requests/saves etc available.
/////////////////////////////////////////////////////////////////////////////////////////////
// NEW FILE OPERATION
/////////////////////////////////////////////////////////////////////////////////////////////
if ($_SESSION['operation'] == 'new') {
	$_SESSION['filename'] = 'new_webpad_document';
	$_SESSION['display_filename'] = '';
	$wp_document = '';
}
/////////////////////////////////////////////////////////////////////////////////////////////
// FILE OPEN OPERATION
/////////////////////////////////////////////////////////////////////////////////////////////
else if ($_SESSION['operation'] == 'open') {
	switch ($_SESSION['open_type']) {
		case 'client' :
			require_once('locations/server.php');
			$wp_document = open_from_server('temp/' . $_SESSION['filename']);
			break;
		case 'server' :
			require_once('locations/server.php');
			verify_secure_file($_SESSION['filename'], $config['home_dir']);
			$wp_document = open_from_server($_SESSION['filename']);
			break;
		case 'ftp' :
			require_once('locations/ftp.php');
			$server = $config['ftp_servers'][$_SESSION['ftp']];
			$wp_document = open_from_ftp($server['host'], $server['port'], $server['pasv'], $server['username'], $server['password'], $_SESSION['filename']);
			break;
		case 'plugin' :
			if (is_readable('plugins/' . $config['plugins'][$_SESSION['plugin']]['type'] . '/code.php')) {
				require_once('plugins/' . $config['plugins'][$_SESSION['plugin']]['type'] . '/code.php');
				eval('$wp_document = ' . $config['plugins'][$_SESSION['plugin']]['type'] . '_open();');
			}
			break;
		case 'http' :
			$wp_document = parse_remote_file($_SESSION['filename']);
			$_SESSION['display_filename'] = $_SESSION['filename'];
			break;
		case 'template' :
			require_once('locations/server.php');
			$wp_document = open_from_server('templates/' . $_SESSION['filename']);
			$javascript_msg = 'New file created from template.';
			$_SESSION['filename'] = 'new_webpad_document';
			$_SESSION['operation'] = 'new';
			break;
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////
// FILE SAVE OPERATION (Existing Details)
/////////////////////////////////////////////////////////////////////////////////////////////
else if ($_SESSION['operation'] == 'save') {
	switch ($_SESSION['save_type']) {
		case 'client' :
			require_once('locations/server.php');
			require_once('locations/client.php');
			save_to_client($_SESSION['display_filename'], $_POST['wp_document']);
			$wp_document = $_POST['wp_document'];
			break;
		case 'server' :
			require_once('locations/server.php');
			verify_secure_file($_SESSION['filename'], $config['home_dir']);
			save_to_server($_SESSION['filename'], $_POST['wp_document']);
			$wp_document = $_POST['wp_document'];
			break;
		case 'ftp' :
			require_once('locations/ftp.php');
			$server = $config['ftp_servers'][$_SESSION['ftp']];
			save_to_ftp($server['host'], $server['port'], $server['pasv'], $server['username'], $server['password'], $_SESSION['filename'], $_POST['wp_document']);
			$wp_document = $_POST['wp_document'];
			break;
		case 'plugin' :
			if (is_readable('plugins/' . $config['plugins'][$_SESSION['plugin']]['type'] . '/code.php')) {
				require_once('plugins/' . $config['plugins'][$_SESSION['plugin']]['type'] . '/code.php');
				eval($config['plugins'][$_SESSION['plugin']]['type'] . '_save($_POST[\'filename\'], $_POST[\'wp_document\']);');
			}
			$wp_document = $_POST['wp_document'];
			break;
		case 'http' :
			$output  = '<script language="JavaScript" type="text/javascript">';
			$output .= 'parent.frames.wp_toolbar.file_save_as();';
			$output .= '</script>';
			break;
		case 'upload' :
			if (!@rename($_SESSION['filename'], $_SESSION['server_pwd'] . $_SESSION['display_filename'])) {
				$javascript_msg = '@Failed to save uploaded file to server, please try again.';
			}
			else {
				$javascript_msg = 'File uploaded successfully.';
			}
			$_SESSION['filename'] = 'new_webpad_document';
			$_SESSION['display_filename'] = '';
			$wp_document = '';
			break;
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////
// SEND EMAIL OPERATION
/////////////////////////////////////////////////////////////////////////////////////////////
else if ($_SESSION['operation'] == 'email' && $config['allow_email'] == true) {
	// Send an HTML email if the document contains am <html> tag, otherwise it's plain text
	if (preg_match('/<html[^>]*>/is', $_POST['wp_document'])) {
		$html_mail = "\r\nContent-type: text/html";
	}
	else {
		$html_mail = '';
	}
	if (@mail($_SESSION['email_to'], $_SESSION['email_subject'], $_POST['wp_document'], 'From: ' . $_SESSION['email_from'] . $html_mail)) {
		$javascript_msg = "Document emailed to '" . substr($_SESSION['email_to'], 0, -2) . "' successfully.";
	}
	else {
		$javascript_msg = '@Couldn\'t send email, something might be wrong with your mail server configuration.';
	}
}

// If nothing else has set this document body yet, and something was posted back
// to this page, then use that to set the doc body.
if ($wp_document === false && isset($_POST['wp_document'])) {
	$wp_document = $_POST['wp_document'];
}
?>
<html>
<head>
<title>webpad: the web-based text editor</title>
<?php check_messages(); ?>
<script language="JavaScript" type="text/javascript" src="js/tools.js"></script>
<script language="JavaScript" type="text/javascript" src="js/shortcuts.js"></script>
<style type="text/css">
BODY, FORM, TEXTAREA { background: #FFFFFF; border: 0; margin: 0; padding: 0; width: 100%; height: 100%; }
TEXTAREA { font-family: <?php echo ($config['editor_font_face'] != '' ? $config['editor_font_face'] . ', ' : ''); ?>Fixedsys, Monaco, Andale, Courier, Fixed-width; font-weight: normal; font-size: <?php echo ($config['editor_font_size'] != '' ? $config['editor_font_size'] : 10); ?>pt; color: #000000; background: #FFFFFF; padding: 3px; margin: 0; border: 0; position: absolute; top: 0px; left: 0px; right: 0px; }
</style>
</head>

<body onload="window.focus(); document.edit.wp_document.focus();">

<form name="edit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="override" value="false" />
<input type="hidden" name="modified" value="false" />
<input type="hidden" name="filename" value="<?php echo $_SESSION['filename']; ?>" />
<input type="hidden" name="display_filename" value="<?php echo $_SESSION['display_filename']; ?>" />
<input type="hidden" name="operation" value="<?php echo $_SESSION['operation']; ?>" />
<textarea name="wp_document" id="wp_document" <?php echo ($config['editor_wordwrap'] === false ? 'wrap="off"' : 'wrap="virtual"'); ?> taborder="1" onkeypress="return check_shortcuts(event);"><?php echo htmlspecialchars($wp_document); ?></textarea>
</form>

<script language="JavaScript" type="text/javascript">
<!--
update_window_title();
// -->
</script>
<?php 
// If there's something to output, then spit it out, otherwise we're done
echo ($output === false ? '' : $output);
?>
</body>
</html>