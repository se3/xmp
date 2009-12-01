<html>
<head>
<title>File Open...</title>
<link rel="stylesheet" href="css/dialog.css" type="text/css" />
<?php
// If this is posted back on itself, or accessed (no URL)
if (isset($_POST['what']) || !isset($_REQUEST['u'])) {
	// Opening something? or new document?
	if (!isset($_POST['what']) || $_POST['what'] == 'new') {
		$f = '';
	}
	else {
		$f = 'f=' . urldecode($_POST['u']);
	}
	
	if (isset($_REQUEST['t']) && in_array($_REQUEST['t'], array('http', 'server'))) {
		$type = $_REQUEST['t'];
	}
	else {
		$type = 'http';
	}
	
	echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"js/tools.js\"></script>\n";
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	echo "<!--\n";
	echo "open_window('index.php?" . $f . "&t=" . $type . "', 930, 600);\n";
	echo "window.close();\n";
	if (!isset($_REQUEST['u'])) {
		echo "history.back();\n";
	}
	echo "// -->\n";
	echo "</script>\n";
	echo "</head>\n\n<body></body>\n</html>\n";
	exit;
}
?>
</head>

<body onload="document.file.open.focus();" onkeypress="if (event.keyCode == 27) { window.close(); }">

<h1>Open in webpad</h1>

<form name="file" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

<p><input type="radio" name="what" value="new" id="new" checked="checked" />&nbsp;<label for="new">New File</label></p>
<p><input type="radio" name="what" value="url" id="url" />&nbsp;<label for="url"><?php echo substr(urldecode($_REQUEST['u']), 0, 40) . (strlen(urldecode($_REQUEST['u'])) > 40 ? '...' : ''); ?></label></p>
<input type="hidden" name="u" value="<?php echo urldecode($_REQUEST['u']); ?>" />

<div align="center">
<input type="submit" name="open" value="  Open  " />
<input type="button" name="cancel" value="Cancel" onclick="top.window.close();" />
</div>

</form>

</body>
</html>