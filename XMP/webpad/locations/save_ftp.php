<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('common.php');

// Blunt deny if config doesn't allow ftp
if ($config['allow_ftp'] != true) {
	exit;
}

// Update last used file type
$_SESSION['last_type'] = 'ftp';

// Handle request for a file
if (isset($_POST['filename']) && $_POST['filename'] != '') {
	$_SESSION['display_filename'] =  basename($_POST['filename']);
	$_SESSION['filename']  = $_POST['ftp_pwd'] . basename($_POST['filename']);
	$_SESSION['ftp_pwd']   = $_POST['ftp_pwd'];
	$_SESSION['operation'] = 'save';
	$_SESSION['save_type'] = 'ftp';
	
	// Modify the open type, used for save operations
	$_SESSION['open_type'] = 'ftp';
	
	// Reload webpad and get out
	reload_webpad_and_close();
}
?>
<html>
<head>
<title>webpad: ftp</title>
<link rel="stylesheet" href="../css/toolbar.css" type="text/css" />
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ftp.js"></script>
</head>

<body onkeypress="if (event.keyCode==27) { window.close(); }">

<div id="file_tools">
<fieldset>
<span class="toolbarcontrol"></span>
<?php
if (sizeof($config['ftp_servers']) > 1) {
	echo '<a href="select_ftp.php?clear=true" target="files_iframe" title="Change Active Server"><img src="../images/change_selection.gif" width="25" height="25" border="0" /></a>';
}
?>
</fieldset>
</div>

<h1>FTP Server</h1>

<form name="file" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return handle_save();">

<input type="text" name="current_dir" value="" id="current_dir" disabled="disabled" title="Current Directory" />
<iframe src="select_ftp.php" id="files_iframe" name="files_iframe"></iframe>
<p><label for="filename">File name:</label> <input type="text" name="filename" id="filename" value="" class="file" /></p>

<div id="controls">
<input type="hidden" name="ftp_pwd" value="<?php echo $_SESSION['ftp_pwd']; ?>" />
<p><input type="submit" name="save" value="Save" class="control" /><br />
<input type="button" name="cancel" value="Cancel" onclick="top.window.close();" class="control" /></p>
</div>

</form>
</body>
</html>