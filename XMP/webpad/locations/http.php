<?php

/**
 * @return String/FALSE on error
 * @param String $url
 * @desc Attempts to request a URL and parse the response into a string, which is opened as a file.
 */
function open_from_http($url) {
	global $javascript_msg;
	
	// Make sure this is a valid URL
	if (strpos($url, 'http://') === false) {
		$javascript_msg = '@Invalid URL. Please enter a full web address, starting with http://';
		return false;
	}
	
	// Make sure that the file parsing function exists, or grab code for it
	if (!function_exists('parse_file')) {
		require_once('common.php');
	}
	// Now parse the URL and get it as a string
	if ($contents = parse_file($url)) {
		return $contents;
	}
	else {
		$javascript_msg = '@Could not load \'' . stripslashes($url) . '\'.';
		return false;
	}
}

?>