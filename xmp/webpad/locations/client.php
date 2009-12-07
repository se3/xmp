<?php

/**
 * @return String/FALSE on error
 * @desc Writes and uploaded file into a temp file and returns the name of that file for future
 *       use. Returns false if there is an error.
 */
function open_from_client() {
	global $javascript_msg;
	
	// Create a temporary file where we will copy the uploaded one to
	$temp_file = 'temp/' . date('YmdHis') . '.wp';
	if ($local_file = @fopen($temp_file, 'w')) {
		// Make sure that the file parsing function exists, or grab code for it
		if (!function_exists('parse_file')) {
			require_once('common.php');
		}
		// Get the uploaded file, open it, then write it into the temp file
		if ($uploaded = parse_file($_FILES['file']['tmp_name'])) {
			@fwrite($local_file, $uploaded);
			fclose($local_file);
			// Return the name of the temp file for use in opening (from server now)
			return $temp_file;
		}
		else {
			$javascript_msg = '@Could not read \'' . $temp_file . '\' or it is empty.';
			return false;
		}
	}
	else {
		$javascript_msg = '@Could not create temporary file. Check the permissions on webpad\'s temporary folder.';
		return false;
	}
}

/**
 * @return void/FALSE on error
 * @param String $filename
 * @param String $string
 * @desc Write string to a file, then force a download of that file to the client.
 */
function save_to_client($filename, $string) {
	global $javascript_msg, $output;
	
	// Create temp file and write string to it.
	$temp_name = date('YmdHis') . '.wp';
	$temp_file = 'temp/' . $temp_name;
	if ($local_file = @fopen($temp_file, 'w')) {
		// Standardizing to Unix line breaks
		$string = str_replace("\r\n", "\n", $string);
		$string = str_replace("\r", "\n", $string);
		
		// Write to server temp
		@fwrite($local_file, $string);
		fclose($local_file);
		$javascript_msg = "File download initiated.";
		
		// Attempt to force download of the file, by redirecting (handles headers etc for clean download)
		//$output = '<meta http-equiv="refresh" content="10;./download.php?f=' . urlencode($filename) . '&t=' . urlencode($temp_name) . '" />';
		$output = '<iframe src="./download.php?f=' . urlencode($filename) . '&t=' . urlencode($temp_name) . '" border="0" width="0" height="0" style="border: 0;" />';
		return true;
	}
	else {
		$javascript_msg = '@Could not create temporary file. Check the permissions on webpad\'s temporary folder.';
		return false;
	}
}

?>