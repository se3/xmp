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

// We've been asked to delete something, confirm it's allowed, then proceed
if (isset($_POST['delete_file']) && $_POST['delete_file'] != '') {
	$_POST['delete_file'] = str_replace('../', '', $_POST['delete_file']);
	if (stristr($_POST['delete_file'], $config['home_dir'])) {
		@unlink($_POST['delete_file']);
	}
	else {
		// Attempted security violation - outside home directory!
		javascript_close_window();
	}
}

// Handle request for a file
if ((isset($_POST['filename']) && $_POST['filename'] != '') && (!isset($_POST['delete_file']) || $_POST['delete_file'] == '')) {
	$_SESSION['display_filename'] =  basename($_POST['filename']);
	$_SESSION['server_pwd'] = $_POST['server_pwd'];
	$_SESSION['operation']  = 'save';
	
	// If an upload took place, then we need to know to transfer the file
	if ($_REQUEST['upload'] != '') {
		$_SESSION['save_type']  = 'upload';
		$_SESSION['filename']   = './temp/' . $_REQUEST['upload'];
	}
	else {
		$_SESSION['save_type']  = 'server';
		$_SESSION['filename']   = $_POST['server_pwd'] . basename($_POST['filename']);
	}
	
	// Reset the session var for uploads
	$_SESSION['upload'] = false;
	
	// Modify the open type, used for save operations
	$_SESSION['open_type'] = 'server';
	
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
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="file" onSubmit="return handle_save();">
<input type="text" name="current_dir" value="" id="current_dir" disabled="disabled" title="Current Directory" />
<iframe src="browse_server.php" id="files_iframe" name="files_iframe"></iframe>
<input type="hidden" name="server_pwd" value="<?php echo $_SESSION['server_pwd']; ?>" />
<input type="hidden" name="delete_file" value="" />
<input type="hidden" name="upload" value="<?php echo (isset($_REQUEST['upload']) && $_REQUEST['upload'] == 'true' ? $_REQUEST['file'] : ''); ?>" />
<p><label for="filename">File name:</label> <input type="text" name="filename" id="filename" value="<?php echo $_REQUEST['name']; ?>" class="file" /></p>
<div id="controls">
<p><input type="submit" name="save" value="Save" class="control" /><br />
<input type="button" name="cancel" value="Cancel" onclick="top.window.close();" class="control" /></p>
</div>
</form>
</body>
</html>