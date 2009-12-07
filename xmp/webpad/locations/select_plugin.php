<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');

// Allow clearing the stored blog to select a new one
if (isset($_REQUEST['clear']) && $_REQUEST['clear'] == 'true') {
	unset($_SESSION['plugin']);
}

// If there's only one plugin configured, use that
if (sizeof($config['plugins']) == 1) {
	$_SESSION['plugin'] = 0;
}

// Fork off to a different location if a plugin is already selected
if (strlen($_SESSION['plugin'])) {
	header('Location: browse_plugin.php?t=' . urlencode($config['plugins'][$_SESSION['plugin']]['type']) . '&p=' . $_SESSION['plugin']);
	exit;
}
?>
<html>
<head>
<title>webpad: select blog</title>
<link rel="stylesheet" href="../css/files.css" type="text/css">
<script language="JavaScript" type="text/javascript" src="../js/plugins.js"></script>
</head>

<body onload="parent.document.file.current_dir.value = ''; parent.document.file.filename.value = '';" onkeypress="if (event.keyCode==27) { window.close(); }">
<?php
// Only run if there are plugins configured
if (sizeof($config['plugins'])) {
	foreach ($config['plugins'] as $id=>$plugin) {
		$title = '';
		// Confirm the existence of the code-base for this plugin
		if (is_readable('../plugins/' . $plugin['type'] . '/code.php')) {
			// Include the plugin code, and execute its get_title function
			include_once('../plugins/' . $plugin['type'] . '/code.php');
			eval('if (' . $plugin['type'] . '_validate_plugin($plugin)) { 
					$title = ' . $plugin['type'] . '_get_title($plugin);
					echo "<a href=\"browse_plugin.php?t=' . urlencode($plugin['type']) . '&p=' . $id . '\" title=\"Open $title\"><img src=\"../plugins/' . $plugin['type'] . '/icon.gif\" alt=\"\" width=\"18\" height=\"18\" border=\"0\" align=\"absmiddle\" /> " . $title . "</a>";
			
			}');
		}
	}
}
else {
	echo '<fieldset>';
	echo '<p>You don\'t appear to have any plugins installed and configured yet. Please consult the help manual to find out how to install and configure plugins in webpad properly</p>';
	echo '</fieldset>';
}
?>
<script language="JavaScript" type="text/javascript">
<!--
clear_plugin_tools();
// -->
</script>
</body>
</html>