<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('common.php');

// Blunt deny if config doesn't enable plugins
if ($config['allow_plugins'] !== true) {
	exit;
}

// Update last used file type
$_SESSION['last_type'] = 'plugin';

// Handle request for a post
if (isset($_POST['plugin']) && $_POST['plugin'] != '' && isset($_POST['identifier']) && $_POST['identifier'] != '') {
	$_SESSION['display_filename'] = stripslashes($_POST['filename']);
	$_SESSION['filename'] = $_POST['filename'];
	$_SESSION['plugin_identifier'] = $_POST['identifier'];
	
	$_SESSION['operation'] = 'open';
	$_SESSION['open_type'] = 'plugin';
	$_SESSION['plugin'] = $_POST['plugin'];
	
	// Reload webpad and get out
	reload_webpad_and_close();
}
?>
<html>
<head>
<title>webpad: plugins</title>
<link rel="stylesheet" href="../css/toolbar.css" type="text/css" />
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/plugins.js"></script>
</head>

<body onkeypress="if (event.keyCode==27) { window.close(); }">

<div id="file_tools">
<fieldset>
<span class="toolbarcontrol"></span>
<?php
if (sizeof($config['plugins']) > 1) {
	echo '<a href="select_plugin.php?clear=true" target="files_iframe" title="Change Active Plugin"><img src="../images/change_selection.gif" width="25" height="25" border="0" border="0" /></a>';
}
?>
<span id="tool1"></span>
<span id="tool2"></span>
<span id="tool3"></span>
</fieldset>
</div>

<h1>My Plugins</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="file" onsubmit="return confirm_open();">
<input type="hidden" name="plugin" value="<?php echo $_SESSION['plugin']; ?>" />
<input type="hidden" name="identifier" value="" />

<input type="text" name="current_dir" value="" id="current_dir" disabled="disabled" title="Current Location" />
<iframe src="select_plugin.php" id="files_iframe" name="files_iframe"></iframe>

<p>Open: <input type="text" name="filename" value="" class="file" /></p>

<div id="controls">
<p><input type="submit" name="open" value="Open" class="control" /><br />
<input type="button" name="cancel" value="Cancel" onclick="top.window.close();" class="control" /></p>
</div>

</form>

</body>
</html>