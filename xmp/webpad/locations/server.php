<?php

/**
 * @return String/FALSE on error
 * @param String $file
 * @desc Parses a file and returns it as a string.
 */
function open_from_server($file) {
	global $javascript_msg, $config;
	
	// Confirm we should be opening this, or die
	verify_secure_file($file, $config['home_dir']);
	
	// Make sure that the file parsing function exists, or grab code for it
	if (!function_exists('parse_file')) {
		require_once('common.php');
	}
	// Get the file and return it if we can
	$contents = parse_file($file);
	
	// If there's something there (even if it's an empty string)
	if ($contents !== false) {
		$javascript_msg = 'File opened successfully.';
		return $contents;
	}
	else {
		$javascript_msg = '@Could not open file \'' . stripslashes(basename($file)) . '\'.';
		$_SESSION['filename'] = '';
		$_SESSION['display_filename'] = '';
		return false;
	}
}

/**
 * @return boolean
 * @param String $fullpath
 * @param String $string
 * @desc Creates a file on the server and saves the string into it.
 */
function save_to_server($fullpath, $string) {
	global $javascript_msg, $config;
	
	// Set up a connection to where the file will be saved.
	if ($server_file = @fopen($fullpath, 'wt')) {
		// Standardizing to Unix line breaks
		$string = str_replace("\r\n", "\n", $string);
		$string = str_replace("\r", "\n", $string);
		
		// Write the contents to the file pointer
		@fwrite($server_file, $string);
		// Then close the file and...
		if (@fclose($server_file)) {
			// If required, change permissions on the file
			if ($config['change_permissions'] == true) {
				@chmod($fullpath, 0777);
			}
			$javascript_msg = 'File saved successfully.';
			return true;
		}
		else {
			$javascript_msg = '@Could not save the file. Check the permissions on webpad\'s server.';
			return false;
		}
	}
	else {
		$javascript_msg = '@Could not save the file. Check the permissions on webpad\'s server.';
		return false;
	}
}

?>