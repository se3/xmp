<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('common.php');

// Blunt deny if config doesn't allow server access
if ($config['allow_server'] != true) {
	exit;
}

// Update last used file type
$_SESSION['last_type'] = 'server';

// We've been asked to delete something, so do it!
if ($_POST['delete_file'] != '') {
	if (stristr($_POST['delete_file'], $config['home_dir'])) {
		@unlink($_POST['delete_file']);
	}
	else {
		exit;
		// Attempted security violation - outside home directory!
		javascript_close_window();
	}
}

// Handle a direct request for a file
if (isset($_POST['filename']) && $_POST['filename'] != '' && $_POST['delete_file'] == '') {
	$_SESSION['display_filename'] =  basename($_POST['filename']);
	$_SESSION['filename']   = $_POST['server_pwd'] . basename($_POST['filename']);
	$_SESSION['server_pwd'] = $_POST['server_pwd'];
	$_SESSION['operation']  = 'open';
	$_SESSION['open_type']  = 'server';
	
	// Reload webpad and get out
	reload_webpad_and_close();
}
?>
<html>
<head>
<title>webpad: server</title>
<link rel="stylesheet" href="../css/toolbar.css" type="text/css" />
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/server.js"></script>
</head>

<body onkeypress="if (event.keyCode==27) { window.close(); }">

<div id="file_tools">
<fieldset>
<span class="toolbarcontrol"></span>
<a href="browse_server.php?home=true" target="files_iframe" title="Home Directory"><img src="../images/home.gif" width="25" height="25" border="0" border="0" /></a>
<a href="javascript:new_directory();" title="New Directory"><img src="../images/new_dir.gif" width="25" height="25" border="0" border="0" /></a>
<a href="javascript:delete_file();" title="Delete Selected File"><img src="../images/delete.gif" width="25" height="25" border="0" border="0" /></a>
<a href="javascript:rename();" title="Rename Selected File"><img src="../images/rename.gif" width="25" height="25" border="0" border="0" /></a>
</fieldset>
</div>

<h1><?php echo ($config['server_name'] ? $config['server_name'] : 'My Server'); ?></h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="file" onsubmit="return confirm_open();">

<input type="text" name="current_dir" value="" id="current_dir" readonly="true" title="Current Directory" />
<iframe src="browse_server.php" id="files_iframe" name="files_iframe"></iframe>
<input type="hidden" name="server_pwd" value="<?php echo $_SESSION['server_pwd']; ?>" />
<input type="hidden" name="delete_file" value="" />
<p><label for="filename">File name:</label> <input type="text" name="filename" id="filename" value="" class="file" /></p>

<div id="controls">
<p><input type="submit" name="open" value="Open" class="control" /><br />
<input type="button" name="cancel" value="Cancel" onclick="top.window.close();" class="control" /></p>
</div>
</form>

<script language="JavaScript" type="text/javascript">
<!--
document.file.filename.focus();
// -->
</script>
</body>
</html>