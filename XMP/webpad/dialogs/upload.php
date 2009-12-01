<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
$msg = false;

// Blunt deny if configuration doesn't allow uploads
if ($config['allow_upload'] != true) {
	exit;
}

// Handle upload and transfer the file into webpad's temp directory.
if ($_POST['uploading'] == 'true') {
	// 20 minutes for upload to complete.
	set_time_limit(1200);
	// Temporary file name (stored in ../temp/)
	$temp_name = date('YmdHis') . '.wp';
	if (@move_uploaded_file($_FILES['upload']['tmp_name'], '../temp/' . $temp_name)) {
		// Force the File Save dialog to save the uploaded file to the server
		echo '<html><head><title>Upload File...</title></head><body>';
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "<!--\n";
		echo 'opener.parent.frames.wp_toolbar.open_console("../save.php?upload=true&type=server&file=' . urlencode($temp_name) . '&name=' . basename($_FILES['upload']['name']) . "\", 550, 370);\n";
		echo "self.close();\n";
		echo "// -->\n";
		echo '</script></body></html>';
		exit;
	}
	else {
		$msg = '<p>Failed to upload your file, it may have been too large, or the permissions may be incorrect on webpad\'s temporary directory.</p><p align="center"><a href="upload.php">Try Again</a></p>';
	}
}
?>
<html>
<head>
<title>Upload File...</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript">
<!--
function upload_animate() {
	document.getElementById('uploadform').style.display = 'none';
	document.getElementById('uploading').style.display  = 'block';
	return true;
}
// -->
</script>
</head>

<body onload="this.focus(); document.upload.file.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Upload File</h1>

<?php
// If there is no message, then display the upload form
if (!$msg) {
	?>
	<div id="uploading">
	<img src="../images/loading.gif" alt="Uploading..." border="0" />
	<p>Uploading file, please wait...</p>
	</div>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="upload" enctype="multipart/form-data" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="921600" />
	<input type="hidden" name="uploading" value="true" />
	
	<table cellpadding="3" cellspacing="0" border="0" width="100%" id="uploadform">
	
	<tr>
	<td><label for="file">File:</label></td>
	<td><input type="file" id="file" name="upload" value="" size="30" /></td>
	</tr>
	
	<tr>
	<td align="center" class="small" colspan="2">Once uploaded, you will select where to save your file on the server.</td>
	</tr>
	
	<tr>
	<td align="center" colspan="2"><input type="submit" name="submit" value="Upload" onclick="upload_animate();" /> <input type="button" name="cancel" value="Cancel" onclick="self.close();" /></td>
	</tr>
	
	</table>
	
	</form>
	<?php
}
// If there is a message, display that instead
else {
	echo $msg;
}
?>
</body>
</html>