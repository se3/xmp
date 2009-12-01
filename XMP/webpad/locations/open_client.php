<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('common.php');

// Update last used file type
$_SESSION['last_type'] = 'client';

// Handle upload and transfer the file into webpad's temp directory.
if ($_POST['uploading'] == 'true') {
	$temp_name = date('YmdHis') . '.wp';
	// Make sure the file isn't one of the restricted formats
	if (in_array(substr($_FILES['upload']['name'], strrpos($_FILES['upload']['name'], '.') + 1), $config['restrict_files'])) {
		$msg = 'The format of this file is restricted, so it cannot be edited, please try another one.';
	}
	else {
		if (move_uploaded_file($_FILES['upload']['tmp_name'], '../temp/' . $temp_name)) {
			// Trigger webpad to load the file from the server temp dir
			$_SESSION['filename'] = $temp_name;
			$_SESSION['display_filename'] = $_FILES['upload']['name'];
			$_SESSION['operation'] = 'open';
			$_SESSION['open_type'] = 'client';
			
			// Reload webpad and get out
			reload_webpad_and_close();
		}
		else {
			$msg = 'Failed to upload file, please check permissions on your temp directory and try again.';
		}
	}
}
	
?>
<html>
<head>
<title>webpad: client</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
</head>

<body onload="document.upload.upload.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>My Computer</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="upload" enctype="multipart/form-data" method="post" onsubmit="return confirm_open();">
<input type="hidden" name="MAX_FILE_SIZE" value="921600" />
<input type="hidden" name="uploading" value="true" />

<table cellpadding="3" cellspacing="0" border="0" id="uploadform">

<tr>
<td colspan="2"><p>&nbsp;</p></td>
</tr>

<tr>
<td colspan="2"><p>Click the Browse button to locate a file on your computer, then click Open to open it in webpad.</p></td>
</tr>

<tr>
<td colspan="2"><p>&nbsp;</p><p>&nbsp;</p></td>
</tr>

<tr>
<td><label for="file">File:</label></td>
<td><input type="file" id="file" name="upload" value="" size="35" /></td>
</tr>

<tr>
<td colspan="2"><p>&nbsp;</p><p><?php
// Display message for the user
if ($msg) {
	echo '<strong>' . $msg . '</strong>';
}
else {
	echo '&nbsp;';
}
?></p></td>
</tr>

</table>

<div id="controls">
<p><input type="submit" name="submit" value="Open" class="control" /><br />
<input type="button" name="cancel" value="Cancel" onclick="top.window.close();" class="control" /></p>
</div>

</form>
</body>
</html>