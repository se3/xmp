<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('common.php');

// Update last used file type
$_SESSION['last_type'] = 'client';

// Handle upload and transfer the file into webpad's temp directory.
if (isset($_POST['filename']) && $_POST['filename'] != '') {
	$_SESSION['display_filename'] =  basename($_POST['filename']);
	$_SESSION['filename']   = basename($_POST['filename']);
	$_SESSION['operation']  = 'save';
	$_SESSION['save_type']  = 'client';
	
	// Modify the open type, used for save operations
	$_SESSION['open_type'] = 'client';

	// Reload webpad and get out
	reload_webpad_and_close();
}
	
?>
<html>
<head>
<title>webpad: client</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript">
<!--
// This function alters the filename to make sure it has the right extension before saving it.
// If they have an extension on there that matches the one they have selected, then nothing
// happens, otherwise it adds the extension on the end.
function verify_filename(filename, extension) {
	lowerCaseFilename = filename.toLowerCase();
	ext_in_filename = lowerCaseFilename.lastIndexOf(extension);
	if (extension == lowerCaseFilename.substr(ext_in_filename) || extension == 'all_files') {
		return filename;
	}
	else {
		return filename + '.' + extension;
	}
}
// -->
</script>
</head>

<body onload="document.file.filename.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>My Computer</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="file" method="post" onsubmit="document.file.filename.value=verify_filename(document.file.filename.value, document.file.extension.value); return true;">

<table cellpadding="3" cellspacing="0" border="0" id="uploadform">

<tr>
<td colspan="2"><p>&nbsp;</p></td>
</tr>

<tr>
<td colspan="2"><p>Enter the filename that you wish to save the file under, then click Save. When prompted, browse to the directory where you want to save the file and then click Save again.</p></td>
</tr>

<tr>
<td colspan="2"><p>&nbsp;</p></td>
</tr>

<tr>
<td align="right"><label for="filename">File name:</label></td>
<td><input type="text" name="filename" id="filename" size="30" value=""></td>
</tr>

<tr>
<td align="right" nowrap="nowrap"><label for="type">Save as type:</label></td>
<td><?php
echo display_select("extension", $file_types, "txt", array('id'=>'type'));
?></td>
</tr>

<tr>
<td colspan="2"><p>&nbsp;</p><p><strong><?php
// Message for the user
if ($msg) {
	echo $msg;
}
else {
	echo '&nbsp;';
}
?></strong></p></td>
</tr>

</table>

<div id="controls">
<p><input type="submit" name="save" value="Save" class="control" /><br />
<input type="button" name="cancel" value="Cancel" onclick="top.window.close();" class="control" /></p>
</div>

</form>
</body>
</html>