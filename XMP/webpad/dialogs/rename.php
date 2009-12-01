<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
$msg = false;

// Handle the reqest to rename the selected file.
if (isset($_POST['old'])) {
	// Validate file name (no special characters)
	if (preg_match('/^[a-z0-9\-_\+!\(\)\.~]+$/i', $_POST['filename'])) {
		$old_file = $_POST['pwd'] . $_POST['old'];
		$new_file = $_POST['pwd'] . $_POST['filename'];
		
		// Move the file to its new name and force a reload of the opening dialog
		if (@rename($old_file, $new_file)) {
			echo '<html><head><title>Rename Selected File</title></head><body>';
			echo '<script language="JavaScript" type="text/javascript">';
			echo 'opener.document.location.href = opener.document.location.href;';
			echo 'self.close();';
			echo '</script></body></html>';
			exit;
		}
	}
	else {
		$msg = 'The new filename contained special characters.';
	}
}
?>
<html>
<head>
<title>Rename Selected File</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
</head>

<body onload="this.focus(); document.rename.filename.select(); document.rename.filename.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Rename Selected File</h1>

<form name="rename" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="pwd" value="<?php echo urldecode($_REQUEST['pwd']); ?>" />
<input type="hidden" name="old" value="<?php echo urldecode($_REQUEST['file']); ?>" />

<table cellpadding="3" cellspacing="0" border="0" width="100%">

<tr>
<td width="25%">Rename To:</td>
<td><input type="text" name="filename" value="<?php echo urldecode($_REQUEST['file']); ?>" style="width: 100%;" /></td>
</tr>

<?php
// Output an additional message if there is one
if ($msg) {
	echo '<tr>';
	echo '<td colspan="2" class="small" align="center">' . $msg . '</td>';
	echo '</tr>';
}
?>

<tr>
<td align="center" colspan="2">
<input type="submit" name="create" value=" Rename " />
<input type="button" name="cancel" value=" Cancel " onclick="self.close();" />
</td>
</tr>

</table>

</form>
</body>
</html>