<?php
require_once('admin/configuration.php');

// Destroy this session and make sure pertinent details are killed
session_name('webpad');
session_start();
unset($_SESSION);
session_destroy();

// If there is a logout_url specified, go there, otherwise display message
if (isset($config['logout_url']) && strlen($config['logout_url'])) {
	header('Location: ' . $config['logout_url']);
}
else {
	$msg_title = 'Logged Out';
	$msg_body  = '<p>You have logged out of webpad successfully.</p><p><a href="../">Click here to go back to XMP</a>, or you may safely close this window.</p>';
	include('admin/message.php');
	exit;
}
?>