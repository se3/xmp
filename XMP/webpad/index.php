<?php
// If the system config file isn't there; die
if (!file_exists('admin/webpad_conf.php') || !is_readable('admin/webpad_conf.php')) {
	$msg_title = 'System Configuration Missing';
	$msg_body  = '<p>The system configuration file (&quot;admin/webpad_conf.php&quot;) appears to be missing. webpad cannot load without these settings. Please download a new copy of webpad, or replace the file and try again.</p>';
	include('admin/message.php');
	exit;
}

// Make sure that the config file is there, otherwise trigger install process
if (!file_exists('admin/configuration.php') || !is_readable('admin/configuration.php')) {
	$msg_title = 'Welcome to webpad';
	$msg_body  = '<p>You don\'t appear to have configured webpad yet, so let\'s go ahead and do that now.</p><p align="center" id="settings_js">Please enable JavaScript to continue.</p>' . "<script language=\"JavaScript\" type=\"text/javascript\">document.getElementById('settings_js').innerHTML = '<a href=\"admin/\">Configure webpad</a>';</script>";
	include('admin/message.php');
	exit;
}

// Make sure that the authentication file is available
// It controls user access to webpad
if (!file_exists('admin/authentication.php') || !is_readable('admin/authentication.php')) {
	$msg_title = 'Authentication System Failed';
	$msg_body  = '<p>Could not load the authentication system for webpad, so as a precaution, webpad will not load. You should download the latest version of webpad from <a href="http://www.dentedreality.com.au/webpad/">http://www.dentedreality.com.au/webpad/</a> to ensure that you have a complete installation package.</p>';
	include('admin/message.php');
	exit;
}

// Make sure that the temp directory is available and writeable
if (!is_writeable('temp/')) {
	$msg_title = 'Permissions Error';
	$msg_body  = '<p>webpad\'s temporary directory does not appear to be writable by webpad. You must ensure that webpad (the web server process) can write to the temp directory before you can use webpad.</p>';
	include('admin/message.php');
	exit;
}

// Get the files to control our configuration and authentication to webpad.
require_once('admin/configuration.php');
require_once('admin/authentication.php');


// Confirm that the specified home directory exists and is at least readable
if (!is_dir($config['home_dir']) || !is_readable($config['home_dir'])) {
	$msg_title = 'Invalid Home Directory';
	$msg_body  = '<p>The home directory specified for webpad (' . $config['home_dir'] . ') either doesn\'t exist or is not accessible. Please ensure that it is correct, and that permissions allow webpad to access the directory.</p>';
	include('admin/message.php');
	exit;
}

// If a file is passed to this page, then pass it along to webpad to open
// f = filename, t = type (http, server)
if (isset($_REQUEST['f']) && isset($_REQUEST['t'])) {
	$_SESSION['operation'] = 'open';
	$_SESSION['filename']  = urldecode($_REQUEST['f']);
	$_SESSION['open_type'] = $_REQUEST['t'];
}
else {
	$_SESSION['operation'] = 'new';
	$_SESSION['open_type'] = 'new';
	$_SESSION['filename']  = 'new_webpad_document';
}
?>
<html>
<head>
<title>webpad: the web-based text editor</title>
</head>

<frameset rows="35,*" style="border: 0;" framespacing="1" frameborder="1" border="1">
	<frame src="toolbar.php" scrolling="no" name="wp_toolbar">
	<frame src="document.php" scrolling="no" name="wp_edit">
</frameset>

<noframes>Please upgrade to a browser that supports frames to use webpad. Try <a href="http://www.mozilla.org/products/firefox/">Firefox</a>.</noframes>

</html>