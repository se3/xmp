<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');

// Blunt deny if config doesn't allow ftp
if ($config['allow_ftp'] != true) {
	exit;
}

// If a clear request is passed, then wipe the session details
if (isset($_REQUEST['clear']) && $_REQUEST['clear'] == 'true') {
	unset($_SESSION['ftp']);
	unset($_SESSION['ftp_pwd']);
}

// If there's only one FTP Server configured, use that
if (sizeof($config['ftp_servers']) == 1) {
	$_SESSION['ftp'] = 0;
	header('Location: browse_ftp.php?ftp=0');
	exit;
}

// If we already have a server specified in the session, go to that
if (isset($_SESSION['ftp']) && strlen($_SESSION['ftp'])) {
	header('Location: browse_ftp.php?ftp=' . $_SESSION['ftp']);
	exit;
}
?>
<html>
<head>
<title>webpad: select ftp</title>
<link rel="stylesheet" href="../css/files.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/ftp.js"></script>
</head>

<body onload="parent.document.file.current_dir.value = ''; parent.document.file.filename.value = '';" onkeypress="if (event.keyCode==27) { window.close(); }">
<?php
// Check that there's some servers available in the config
if (sizeof($config['ftp_servers'])) {
	foreach ($config['ftp_servers'] as $id=>$ftp) {
		echo '<a href="browse_ftp.php?ftp=' . $id . '"><img src="../images/files_ftp.gif" width="18" height="19" border="0" align="absmiddle" /> \'' . $ftp['username'] . '\' on host ' . $ftp['host'] . '</a>';
	}
}
else {
	echo '<p>&nbsp;</p><p>You don\'t appear to have any FTP Servers configured yet.</p><p>Please consult the help manual to find out how to configure FTP Servers in webpad properly</p>';
}
?>
</body>
</html>