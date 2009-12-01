<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('../locations/common.php');
?>
<html>
<head>
<title>Create New File</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<?php
if (isset($_POST['type'])) {
	echo '<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>';
	if ($_POST['type'] == 'blank') {
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "<!--\n";
		echo "opener.parent.frames.wp_toolbar.file_new(true);\n";
		echo "window.close();\n";
		echo "// -->\n";
		echo "</script>\n";
	}
	else {
		// If a template has been requested (New -> From Template), then load it.
		if ($_POST['template'] != '') {
			$_SESSION['filename'] = '../templates/' . $_POST['template'];
			$_SESSION['display_filename'] = '';
			$_SESSION['operation'] = 'open';
			$_SESSION['open_type'] = 'template';
			
			// Reload webpad with that template and close this window
			reload_webpad_and_close();
		}
	}
}
?>
</head>

<body onload="this.focus(); document.dialog.newfile.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">
<form name="dialog" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<h1>Create New File</h1>
<p><input type="radio" name="type" value="blank" id="new" checked="checked" />&nbsp;<label for="new">Blank File</label></p>
<?php
// Get a listing of templates in the template directory
if (is_dir('../templates/')) {
	$templates = read_dir_to_array('../templates/', array('wpt'));
	sort($templates);
}

// Now output options to select a templae if there are any
if (sizeof($templates) && $config['use_templates'] == true) {
	echo '<p><input type="radio" name="type" value="template" id="url" />&nbsp;<select name="template" onchange="document.dialog.type[1].checked = true;">';
	echo '<option value="" selected="true">Select Template</option>';
	foreach ($templates as $template) {
		echo '<option value="' . $template . '">' . str_replace(array('_', '.wpt'), array(' ', ''), $template) . '</option>';
	}
	echo '</select></p>';
}
else {
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	echo "<!--\n";
	echo "document.dialog.submit();\n";
	echo "// --!>\n";
	echo "</script>\n";
}
?>

<div align="center">
<input type="submit" name="newfile" value="  New  " />
<input type="button" name="cancel" value="Cancel" onclick="window.close();" />
</div>

</form>

</body>
</html>