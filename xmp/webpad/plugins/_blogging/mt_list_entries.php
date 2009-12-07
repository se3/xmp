<?php
require_once(dirname(__FILE__) . '/../../admin/configuration.php');
require_once(dirname(__FILE__) . '/../../admin/authentication.php');
require_once(dirname(__FILE__) . '/blog_configuration.php');
require_once(dirname(__FILE__) . '/class.mtclient.php');
require_once(dirname(__FILE__) . '/../' . $_REQUEST['t'] . '/code.php');
eval('$current_dir = ' . $_REQUEST['t'] . '_get_title($config[\'plugins\'][$_SESSION[\'plugin\']]);');
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

if ($_REQUEST['t'] == 'livejournal') {
	$mt = new bloggerclient($config['plugins'][$_REQUEST['p']]['username'], $config['plugins'][$_REQUEST['p']]['password'], $livejournal_host, $livejournal_path);
}
else {
	$host = $config['plugins'][$_REQUEST['p']]['host'];
	$path = $config['plugins'][$_REQUEST['p']]['path'];
	$mt = new mtclient($config['plugins'][$_REQUEST['p']]['username'], $config['plugins'][$_REQUEST['p']]['password'], $host, $path);
}

// Handle a request to delete an entry before loading the others
if (isset($_POST['delete_entry']) && strlen($_POST['delete_entry'])) {
	$del = $_POST['delete_entry'];
	$good = $mt->deletePost($del, true);
	if (!$good) {
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "<!--\n";
		echo "alert('Can\'t delete that post - you might not have permission to do so.');\n";
		echo "// -->\n";
		echo "</script>\n";
	}
}

$blogs = $mt->getUsersBlogs();
$entries = $mt->getRecentPosts($blogs[$_REQUEST['b']]['blogid'], 15);

// Now list out the entries available
if (is_array($entries) && sizeof($entries)) {
	foreach ($entries as $e=>$entry) {
		$post_id = urlencode((isset($entry['postId']) ? $entry['postId'] : $entry['postid']));
		$title = $entry['title'];
		if ($title == '') {
			preg_match('/^<title>(.*)<\/title>/sUi', $entry['content'], $title);
			$title = $title[1];
		}
		$title = preg_replace('/(<[^>]*>)/is', '', $title);
		$title = htmlspecialchars($title);
		$title_short = substr($title, 0, 45) . (strlen($title) > 45 ? '...' : '');
		if ($title_short == '') {
			$title_short = 'No Title (Created: ' . $entry['dateCreated'] . ')';
			$title = $title_short;
		}
		echo "<a href=\"javascript:select(" . $e . ", '" . addslashes($title) . "', '" . $post_id . "', '" . urlencode($blogs[$_REQUEST['b']]['blogid']) . "');\" ondblclick=\"select(" . $e . ", '" . addslashes($title) . "', '" . $post_id . "', '" . urlencode($blogs[$_REQUEST['b']]['blogid']) . "'); if (confirm_open()) {parent.document.file.submit();}\" id=\"entry" . $e . "\" title=\"" . $title . "\"><img src=\"../../images/files_file.gif\" width=\"19\" height=\"18\" border=\"0\" align=\"absmiddle\" /> " . $title_short . "</a>\n";
	}
}
else {
	echo '<p>There was a problem loading your blog entries.</p><p>Please check your username/password in your webpad configuration.</p>';
}
?>

<form name="blog" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="b" value="<?php echo $_REQUEST['b']; ?>" />
<input type="hidden" name="p" value="<?php echo $_REQUEST['p']; ?>" />
<input type="hidden" name="t" value="<?php echo $_REQUEST['t']; ?>" />
<input type="hidden" name="selected_element" value="" />
<input type="hidden" name="label" value="" />
<input type="hidden" name="entry" value="" />
<input type="hidden" name="delete_entry" value="" />
</form>

<script language="JavaScript" type="text/javascript">
<!--
add_plugin_tool('../images/delete.gif', 'javascript:files_iframe.delete_entry();', 'Delete Selected Entry', 1);
parent.document.file.current_dir.value = '<?php echo addslashes($current_dir); ?>';
parent.document.file.identifier.value = '[@<?php echo urlencode($blogs[$_REQUEST['b']]['blogid']); ?>]';
parent.document.file.plugin.value = <?php echo $_REQUEST['p']; ?>;
parent.document.file.filename.readOnly = true;
if (parent.parent.frames.saveas_locations) {
	parent.document.file.filename.value = get_title();
}
// -->
</script>
</body>
</html>