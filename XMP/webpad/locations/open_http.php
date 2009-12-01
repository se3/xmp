<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('common.php');

// Update last used file type
$_SESSION['last_type'] = 'http';

// Handle request for external document, into temp file
if (isset($_POST['url'])) {
	$temp_name = date('YmdHis') . '.wp';

	// Attempt to parse remote file into a string
	if ($string = parse_remote_file($_POST['url'])) {
		// If possible, open a handle to a temp file and write the string to it.
		$th = fopen('../temp/' . $temp_name, 'w');
		if ($th) {
			fwrite($th, $string);
			fclose($th);
			
			// Trigger webpad to load the file from the server temp dir
			$_SESSION['display_filename'] = $_POST['url'];
			$_SESSION['filename']   = './temp/' . $temp_name;
			$_SESSION['server_pwd'] = './temp/';
			$_SESSION['operation']  = 'open';
			$_SESSION['open_type']  = 'server';
			
			// Reload webpad and get out
			reload_webpad_and_close();
		}
		else {
			$msg = 'Could not create temporary file on the server, check permissions on the temp directory.';
		}
	}
	else {
		$msg = 'Could not retrieve remote file. It may be secured, dynamically generated or the URL is wrong.';
	}
}
	
?>
<html>
<head>
<title>webpad: http</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
</head>

<body onload="document.url.url.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Web Page</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="url" method="post" onsubmit="return confirm_open();">

<table cellpadding="3" cellspacing="0" border="0">

<tr>
<td colspan="2"><p>&nbsp;</p></td>
</tr>

<tr>
<td colspan="2"><p>Enter a web address (URL) in the box below and click 'Open' to retrieve the source code for that page.</p></td>
</tr>

<tr>
<td colspan="2"><p>&nbsp;</p><p class="small">HINT: You can copy-paste a URL in from another page if you like.</p><p>&nbsp;</p></td>
</tr>

<tr>
<td><label for="file">URL:</label></td>
<td><input type="text" id="url" name="url" value="http://" class="file" /></td>
</tr>

<tr>
<td colspan="2"><p>&nbsp;</p><p><strong><?php
// If there's a  message for the user, display it here
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
<p><input type="submit" name="submit" value="Open" class="control" /><br />
<input type="button" name="cancel" value="Cancel" onclick="top.window.close();" class="control" /></p>
</div>

</form>
</body>
</html>