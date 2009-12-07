<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('common.php');

// Blunt deny if config doesn't allow server access
if ($config['allow_server'] != true) {
	exit;
}

// Set dir to posted value if available, otherwise set to home if requested
if (isset($_GET['home']) && $_GET['home'] == 'true') {
	$_SESSION['server_pwd'] = $config['home_dir'];
}
else if (isset($_POST['server_pwd'])) {
	$_SESSION['server_pwd'] = str_replace('+', ' ', $_POST['server_pwd']);
}

// Reset the current directory if there isn't one, or if it's the temp (from an upload etc)
if (!isset($_SESSION['server_pwd']) || $_SESSION['server_pwd'] == '' || $_SESSION['server_pwd'] == './temp/') {
	$_SESSION['server_pwd'] = $config['home_dir'];
}
?>
<html>
<head>
<title>webpad: server browse</title>
<link rel="stylesheet" href="../css/files.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/server.js"></script>
</head>

<body onkeypress="if (event.keyCode==27) { window.close(); }">
<?php
if ($_SESSION['server_pwd'] != $config['home_dir']) {
	echo '<a href="javascript:cdup(document.server.server_pwd.value);" title="Parent Directory"><img src="../images/files_up.gif" width="19" height="18" alt="" border="0" align="absmiddle" /> Parent Directory</a>';
}

// Get all entries in this dir to an array
$files = read_dir_to_array($_SESSION['server_pwd']);

// Now if we have some entries, check them all and build the file listing
if ($files !== false) {
	$file_list = array();
	foreach($files as $file) {
		if (is_dir(addslashes($_SESSION['server_pwd'] . $file))) {
			if (is_readable($_SESSION['server_pwd'] . '/' . $file) && is_writable($_SESSION['server_pwd'] . '/' . $file)) {
				echo '<a href="javascript:cd(\'' . urlencode($file . '/') . '\');" id="' . $file . '_" title="' . $file . '"><img src="../images/files_dir.gif" width="19" height="18" border="0" align="absmiddle" /> ' . $file . '</a>';
			}
			else {
				echo '<div class="disabled"><img src="../images/files_dir_locked.gif" width="19" height="18" alt="Access Denied" border="0" align="absmiddle" /> ' . $file . '</div>';
			}
		}
		else {
			// Add to listing of files in this dir.
			$file_list[] = $file;
			if (!in_array(substr($file, strrpos($file, '.') + 1), $config['restrict_files'])) {
				echo '<a href="javascript:select(\'' . $file . '\');" ondblclick="select(\'' . $file . '\'); if (confirm_open()) {parent.document.file.submit();}" id="' . $file . '" title="' . $file . '"><img src="../images/files_file.gif" width="19" height="18" border="0" align="absmiddle" /> ' . $file . '</a>';
			}
			else {
				echo '<div class="disabled"><img src="../images/files_file.gif" width="19" height="18" title="File format restricted" border="0" align="absmiddle" /> ' . $file . '</div>';
			}
		}
	}
}
else {
	echo "Could not access directory '" . $_SESSION['server_pwd'] . "'.";
}

?>

<script language="JavaScript" type="text/javascript">
<!--
parent.document.file.server_pwd.value  = '<?php echo $_SESSION['server_pwd']; ?>';
parent.document.file.current_dir.value = '<?php echo str_replace($config['home_dir'], '~/', $_SESSION['server_pwd']); ?>';

file_list = new Array('<?php 
if ($file_list) {
	foreach ($file_list as $file) {
		echo addslashes($file) . "', '";
	}
}
?>');
// -->
</script>

<form name="server" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="server_pwd" value="<?php echo $_SESSION['server_pwd']; ?>" />
<input type="hidden" name="selected_element" value="" />
</form>

</body>
</html>