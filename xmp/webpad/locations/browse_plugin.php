<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');

// Blunt deny if config doesn't enable plugins
if ($config['allow_plugins'] !== true) {
	exit;
}

// Set the selected plugin details to the session
if (isset($_REQUEST['p']) && $_REQUEST['p'] != '') {
	$_SESSION['plugin'] = $_REQUEST['p'];
}
else {
	header('Location: select_plugin.php?clear=true');
	exit;
}

if (is_readable('../plugins/' . $config['plugins'][$_SESSION['plugin']]['type'] . '/code.php')) {
	include_once('../plugins/' . $config['plugins'][$_SESSION['plugin']]['type'] . '/code.php');
	eval('$title = ' . $config['plugins'][$_SESSION['plugin']]['type'] . '_get_title($config[\'plugins\'][$_SESSION[\'plugin\']]);');
	eval('$listing = ' . $config['plugins'][$_SESSION['plugin']]['type'] . '_listing($config[\'plugins\'][$_SESSION[\'plugin\']], $_SESSION[\'plugin\']);');
}
else {
	$_SESSION['plugin'] = false;
	header('Location: select_plugin.php?clear=true');
	exit;
}
?>
<html>
<head>
<title>webpad: plugin browser</title>
<link rel="stylesheet" href="../css/files.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/plugins.js"></script>
</head>

<body onkeypress="if (event.keyCode==27) { window.close(); }">

<?php echo $listing; ?>

<script language="JavaScript" type="text/javascript">
<!--
parent.document.file.filename.readOnly = false;
parent.document.file.current_dir.value = '<?php echo addslashes($title); ?>';
parent.document.file.plugin.value = <?php echo $_REQUEST['p']; ?>;
// -->
</script>
</body>
</html>