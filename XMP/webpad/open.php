<?php
require_once('admin/configuration.php');
require_once('admin/authentication.php');

// If a type is passed, then force that type to be selected automatically,
// otherwise default to 'client'
if (isset($_REQUEST['type']) && strlen($_REQUEST['type'])) {
	$type = $_REQUEST['type'];
}
else if (isset($_SESSION['last_type']) && strlen($_SESSION['last_type'])) {
	$type = $_SESSION['last_type'];
}
else {
	$type = 'client';
}
?>
<html>
<head>
<title>Open File...</title>
</head>

<frameset cols="105,*" onload="this.focus();" onkeypress="if (event.keyCode==27) { window.close(); }" border="0" style="border: 0;" frameborder="0">
	<frame src="locations/locations.php?operation=open&type=<?php echo $type ?>" scrolling="no" name="open_locations">
	<frame src="locations/open_<?php echo $type ?>.php" scrolling="no" name="wp_file_detail">
</frameset>

</html>