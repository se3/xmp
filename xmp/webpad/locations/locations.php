<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('common.php');

// Delete old temporary files in the temp dir
cleanup_files();
?>
<html>
<head>
<title>webpad: locations</title>
<style type="text/css">
BODY {
	padding: 0;
	margin: 0;
	border: 0;
	background: #265997;
}

IMG {
	margin: 0;
	padding: 0;
	border: 0;
}

A.option {
	display: block;
	width: 75px;
	height: 65px;
	margin: 0;
	padding: 3px;
	border: 0;
	text-align: center;
	font-family: Tahoma, Arial Narrow, Arial, Verdana, Sans-serif;
	font-size: 8pt;
	font-weight: normal;
	color: #FFFFFF;
	text-decoration: none;
}

A:hover.option {
	text-decoration: underline;
	padding: 0;
	margin: 0;
	border: 0;
	padding: 3px;
}

#locations {
	border: solid 2px;
	border-color: #00264C #D1E5FF #D1E5FF #00264C;
	padding: 10px;
	height: 100%;
	text-align: center;
}
</style>
</head>

<body onkeypress="if (event.keyCode==27) { window.close(); }">

<div id="locations">
<?php

// My Computer
if (!isset($_REQUEST['upload']) || $_REQUEST['upload'] == 'false') {
	echo '<a href="' . $_REQUEST['operation'] . '_client.php" target="wp_file_detail" class="option">';
	echo '<img src="../images/' . $config['mycomputer_icon'] . '" width="35" height="35" border="0" alt="" /><br />';
	echo $config['mycomputer_label'];
	echo '</a>';
}

// My Server
if ($config['allow_server'] == true) {
	echo '<a href="' . $_REQUEST['operation'] . '_server.php" target="wp_file_detail" class="option">';
	echo '<img src="../images/' . $config['myserver_icon'] . '" width="35" height="35" border="0" alt="" /><br />';
	echo $config['myserver_label'];
	echo '</a>';
}

// FTP Server
if ($config['allow_ftp'] == true && sizeof($config['ftp_servers']) && (!isset($_REQUEST['upload']) || $_REQUEST['upload'] == 'false')) {
	echo '<a href="' . $_REQUEST['operation'] . '_ftp.php" target="wp_file_detail" class="option">';
	echo '<img src="../images/' . $config['ftpserver_icon'] . '" width="35" height="35" border="0" alt="" /><br />';
	echo $config['ftpserver_label'];
	echo '</a>';
}

// Plugins
if ($config['allow_plugins'] == true && sizeof($config['plugins']) && (!isset($_REQUEST['upload']) || $_REQUEST['upload'] == 'false')) {
	echo '<a href="' . $_REQUEST['operation'] . '_plugin.php" target="wp_file_detail" class="option">';
	echo '<img src="../images/' . $config['plugins_icon'] . '" width="35" height="35" border="0" alt="" /><br />';
	echo $config['plugins_label'];
	echo '</a>';
}

// Webpage
if ($_REQUEST['operation'] == 'open' && (!isset($_REQUEST['upload']) || $_REQUEST['upload'] == 'false')) {
	echo '<a href="' . $_REQUEST['operation'] . '_http.php" target="wp_file_detail" class="option">';
	echo '<img src="../images/' . $config['webpage_icon'] . '" width="35" height="35" border="0" alt="" /><br />';
	echo $config['webpage_label'];
	echo '</a>';
}

?>
</div>

</body>
</html>