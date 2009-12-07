<?php
require_once('admin/configuration.php');
require_once('admin/authentication.php');

// If there's a specified type, then use that, or go for a session val, or default to client
if (isset($_REQUEST['type']) && $_REQUEST['type'] != 'http') {
	$type = $_REQUEST['type'];
}
else if (isset($_SESSION['last_type']) && strlen($_SESSION['last_type'])) {
	// If the save type is http, that doesn't make any sense, so switch to client
	// otherwise use the session value here
	if ($_SESSION['save_type'] == 'http' || $_SESSION['last_type'] == 'http') {
		$type = 'client';
	}
	else {
		$type = $_SESSION['last_type'];
	}
}
// Always default to client as the preferred method (safest)
else {
	$type = 'client';
}

// Pass thru a file if specified on request and default back to server type.
if ($_REQUEST['file'] != '') {
	$file = '?file=' . $_REQUEST['file'];
	$type = 'server';
	
	// If this is an upload save, then force some settings, otherwise
	// blank out the upload details to avoid conflicts
	if ($_REQUEST['upload'] == 'true') {
		$upload_str = '&upload=true&name=' . $_REQUEST['name'];
		$_SESSION['filename'] = '../temp/' . $_REQUEST['file'];
		$_SESSION['upload']   = true;
	}
	else {
		$upload_str = '';
		$_SESSION['upload'] = false;
	}
}
?>
<html>
<head>
<title>Save File As...</title>
</head>

<frameset cols="105,*" onload="this.focus();" onkeypress="if (event.keyCode==27) { window.close(); }" border="0" style="border: 0;" frameborder="0">
	<frame src="locations/locations.php?operation=save&type=<?php echo $type . $upload_str; ?>" scrolling="no" name="saveas_locations">
	<frame src="locations/save_<?php echo $type ?>.php<?php echo $file . $upload_str; ?>" scrolling="no" name="wp_file_detail">
</frameset>

</html>