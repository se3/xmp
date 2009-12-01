<?php
require_once('admin/configuration.php');
require_once('admin/authentication.php');
require_once('locations/common.php');

// Send headers to force a named file download
header('Content-disposition: attachment; filename="' . urldecode($_REQUEST['f']) . '"');

// If the file exists, dump the contents
if (is_file('temp/' . urldecode($_REQUEST['t']))) {
	// Get temp file
	$str = parse_file('temp/' . urldecode($_REQUEST['t']));
	
	// Fix linebreaks for destination
	// Windows
	if (stristr($_SERVER['HTTP_USER_AGENT'], 'win') !== false) {
		$str = str_replace("\n", "\r\n", $str);
	}
	// Mac
	else if (stristr($_SERVER['HTTP_USER_AGENT'], 'mac') !== false) {
		$str = str_replace("\n", "\r", $str);
	}
	// Others can stay with \n
	
	echo $str;
}
exit;
?>