<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
$msg = false;

// Handle the reqest to create a new folder in the current one.
if (isset($_POST['pwd'])) {
	// Validate the requested folder name
	if (preg_match('/^[a-z0-9 \-_\+!\(\)\.~]+$/i', $_POST['folder'])) {
		$fulldir = $_POST['pwd'] . $_POST['folder'];
		$done = false;
		
		// Create the directory, with 777 if required
		if ($config['change_permissions'] == true) {
			if (@mkdir($fulldir, 0777)) {
				$done = true;
			}
		}
		else {
			if (@mkdir($fulldir)) {
				$done = true;
			}
		}
		if ($done) {
			// Force a reload of the opening dialog
			echo '<html><head><title>Create New Folder</title></head><body>';
			echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
			echo "<!--\n";
			echo "opener.document.location.href = opener.document.location.href;\n";
			echo "self.close();\n";
			echo "// -->\n";
			echo '</script></body></html>';
			exit;
		}
		else {
			$msg = 'The directory could not be created. Check your server permissions.';
		}
	}
	else {
		$msg = 'Could not create folder - name contained special characters.';
	}
}
?>
<html>
<head>
<title>Create New Directory</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
</head>

<body onload="this.focus(); document.folder.folder.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Create New Directory</h1>

<form name="folder" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="pwd" value="<?php echo urldecode($_REQUEST['pwd']); ?>" />

<table cellpadding="3" cellspacing="0" border="0" width="100%">

<tr>
<td width="15%">Directory:</td>
<td><input type="text" name="folder" style="width: 100%;" /></td>
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
<input type="submit" name="create" value=" Create " />
<input type="button" name="cancel" value=" Cancel " onclick="self.close();" />
</td>
</tr>

</table>

</form>
</body>
</html>