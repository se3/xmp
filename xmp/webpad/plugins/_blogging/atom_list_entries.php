<?php
require_once(dirname(__FILE__) . '/../../admin/configuration.php');
require_once(dirname(__FILE__) . '/../../admin/authentication.php');
require_once(dirname(__FILE__) . '/class.atomapi.php');
require_once(dirname(__FILE__) . '/blog_configuration.php');
?>
<html>
<head>
<title>webpad: blogging browse posts</title>
<link rel="stylesheet" href="../../css/files.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../../js/tools.js"></script>
<script language="JavaScript" type="text/javascript" src="../../js/plugins.js"></script>
<script language="JavaScript" type="text/javascript" src="blogging.js"></script>
</head>

<body onkeypress="if (event.keyCode==27) { window.close(); }">
<?php
echo '<a href="../../locations/browse_plugin.php?t=' . $config['plugins'][$_REQUEST['p']]['type'] . '&p=' . $_REQUEST['p'] . '" title="Back to Blog List"><img src="../../images/files_up.gif" width="19" height="18" alt="" border="0" align="absmiddle" /> Back to Blog List</a>' . "\n";

// Create Auth Object
if ($config['plugins'][$_REQUEST['p']]['type'] == 'blogger') {
	require_once(dirname(__FILE__) . '/class.basicauth.php');
	$auth = new BasicAuth($config['plugins'][$_REQUEST['p']]['username'], $config['plugins'][$_REQUEST['p']]['password']);
}
else  {
	require_once(dirname(__FILE__) . '/class.wsse.php');
	$auth = new WSSE($config['plugins'][$_REQUEST['p']]['username'], $config['plugins'][$_REQUEST['p']]['password']);
}

// Handle request to delete an entry before we load them all
if (isset($_POST['delete_entry']) && strlen($_POST['delete_entry'])) {
	$del = $_POST['delete_entry'];
	$dr = new AtomRequest('DELETE', $del, $auth);
	$dr->exec();
	$code = $dr->get_httpcode();
	if ($code != 200 && $code != 204) {
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "<!--\n";
		echo "alert('Can\'t delete that post - you might not have permission to do so.');\n";
		echo "// -->\n";
		echo "</script>\n";
	}
}

$af = new AtomFeed(urldecode($_REQUEST['f']), $auth);
$entries = $af->get_entries();
if (is_array($entries)) {
	foreach ($entries as $e=>$entry) {
		$link = $entry->get_links('rel', 'service.edit');
		$link = $link[0]['href'];
		$title = trim($entry->get_title('title'));
		$title = preg_replace('/(<[^>]*>)/is', '', $title);
		$title = preg_replace('/(&lt;.*&gt;)/sUi', '', $title);
		$title = preg_replace('/(\n)/sUi', '', $title);
		$title_short = substr($title, 0, 45) . (strlen($title) > 45 ? '...' : '');
		if ($title == '') {
			$title = 'No Title (Created: ' . $entry->get_created() . ')';
		}
		echo "<a href=\"javascript:select(" . $e . ", '" . addslashes($title) . "', '" . urlencode($link) . "', '" . urlencode($_REQUEST['f']) . "');\" ondblclick=\"select(" . $e . ", '" . addslashes($title) . "', '" . urlencode($link) . "', '" . urlencode($_REQUEST['f']) . "'); if (confirm_open()) {parent.document.file.submit();}\" id=\"entry" . $e . "\" title=\"" . $title . "\"><img src=\"../../images/files_file.gif\" width=\"19\" height=\"18\" border=\"0\" align=\"absmiddle\" /> " . $title_short . "</a>\n";
	}
}
else {
	echo '<p>There was a problem loading your blog entries (' . $ATOMAPI_ERROR_STRINGS[$af->error()] . ').</p>';
}
?>

<form name="blog" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="f" value="<?php echo $_REQUEST['f']; ?>" />
<input type="hidden" name="p" value="<?php echo $_REQUEST['p']; ?>" />
<input type="hidden" name="selected_element" value="" />
<input type="hidden" name="label" value="" />
<input type="hidden" name="entry" value="" />
<input type="hidden" name="delete_entry" value="" />
</form>

<script language="JavaScript" type="text/javascript">
<!--
add_plugin_tool('../images/delete.gif', 'javascript:files_iframe.delete_entry();', 'Delete Selected Entry', 1);
parent.document.file.current_dir.value = '<?php echo addslashes($af->get_title('title')); ?>';
parent.document.file.identifier.value = '[@<?php echo urlencode($_REQUEST['f']); ?>]';
parent.document.file.plugin.value = <?php echo $_REQUEST['p']; ?>;
parent.document.file.filename.readOnly = true;
if (parent.parent.frames.saveas_locations) {
	parent.document.file.filename.value = get_title();
}
// -->
</script>
</body>
</html>