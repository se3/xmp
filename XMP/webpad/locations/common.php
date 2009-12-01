<?php

// Global variable used to determine what to output to the user (errors/messages)
$javascript_msg = false;

/**
 * @return String/FALSE on error
 * @param String $file
 * @desc Parses a local file and returns it as a string.
 */
function parse_file($file) {
	global $javascript_msg;
	$data = '';
	
	// Open a connection to the file requested
	$handle = @fopen($file, 'rt');
	if ($handle) {
		// Get all lines of the file (into our string)
		while (!feof($handle)) {
			$buffer = fgets($handle, 4096);
			$data .= $buffer;
		}
		fclose($handle);
		return $data;
	}
	else {
		$javascript_msg = '@Could not open file or file is empty.';
		return false;
	}
}


/**
 * @return String/FALSE on error
 * @param String $url
 * @desc Parses a remote url and returns it as a string.
 */
function parse_remote_file($url) {
	global $javascript_msg;
	$data = '';
	
	$ch = @curl_init();
	if ($ch) {
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "webpad: the web-based text editor <http://www.dentedreality.com.au/webpad>");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Don't stress about SSL validity
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the response, don't output it
		$data = curl_exec($ch);
		
		if (trim($data) == '' || curl_errno($ch)) {
			curl_close($ch);
			$javascript_msg = '@Could not open file or file is empty.';
			return false;
		}
		else {
			curl_close($ch);
			return $data;
		}
	}
	else {
		$javascript_msg = '@cURL doesn\'t appear to be installed.';
		return false;
	}
}


/**
 * @return void
 * @desc Checks the global variable ($javascript_alert) and either displays an error dialog, 
 *       or sets the window status (or both) based on it's value
 */
function check_messages() {
	global $javascript_msg;
	
	if (isset($javascript_msg) && $javascript_msg != false) {
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "<!--\n";
		// If the msg is prefixed with a @, then it's an error, so open an alert dialog
		// as well as setting the window status, otherwise just set the status
		if (substr($javascript_msg, 0, 1) == '@') {
			echo "alert('" . addslashes(substr($javascript_msg, 1)) . "');\n";
			echo "window.status = '" . addslashes(htmlspecialchars(substr($javascript_msg, 1))) . "';\n";
		}
		else {
			echo "window.status = '" . addslashes(htmlspecialchars($javascript_msg)) . "';\n";
		}
		echo "// -->\n";
		echo "</script>\n";
	}
}


/**
 * @return Array
 * @param String $dir
 * @param Array $filter
 * @desc Reads all entries in a directory into an array, sorted alpha, dirs then files.
 *       If $filter is supplied, it should be an array of the only extensions to return
 */
function read_dir_to_array($dir, $filter = false) { 
	$file_list = array();
	$files = array();
	$dirs = array();
	
	// Read all the entries in the directory specified
	$handle = @opendir($dir);
	if (!$handle) {
		return false;
	}
	// Ignore self and parent references
	while ($file = @readdir($handle)) {
		if ($file != '.' && $file != '..') {
			$file_list[count($file_list)] = $file;
		}
	}
	@closedir($handle);
	
	// Loop through entries and sort them into files and directories
	for ($count = 0; $count < sizeof($file_list); $count++) {
		if (is_dir($dir . $file_list[$count])) {
			$dirs[] = $file_list[$count];
		}
		else {
			// For files, only include those requested if $filter is set
			if (is_array($filter)) {
				 if (in_array(substr($file_list[$count], strrpos($file_list[$count], '.') + 1), $filter)) {
					$files[] = $file_list[$count];
				 }
			}
			else {
				$files[] = $file_list[$count];
			}
		}
	}
	
	// Sort anything found alphabetically and combine the results (dirs->files)
	if (sizeof($dirs) > 0) {
		sort($dirs, SORT_STRING);
	}
	if (sizeof($files) > 0) {
		sort($files, SORT_STRING);
	}
	
	// Put the directories and files back together and return them
	$file_list = array_merge($dirs, $files);
	return $file_list;
}

/**
 * @return void
 * @desc Checks temp dir for files older than 1 hr and deletes them.
 */
function cleanup_files() {
	// Date string for one hour ago (old files)
	$date = date('Ymd') . (date('H') - 1) . date('is');
	$temp_files = array();
	$temp_files = read_dir_to_array('../temp/') ;
	foreach ($temp_files as $this_one) {
		$test = str_replace('.wp', '', $this_one);
		if ($test < $date) {
			@unlink('../temp/' . $this_one);
		}
	}
}

/**
 * @return void
 * @desc Dumps the HTML/JS required to refresh the main window of webpad and close the current window.
 */
function reload_webpad_and_close() {
	echo '<html><head><title>webpad: the web-based text editor</title></head><body>';
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	echo "<!--\n";
	echo "parent.opener.parent.frames.wp_edit.document.edit.submit();\n";
	echo 'top.window.close();';
	echo "// -->\n";
	echo '</script></body></html>';
	exit;
}

/**
 * @return void
 * @desc Dumps the HTML/JS required to close the current window and exit cleanly
 */
function javascript_close_window() {
	echo '<html><head><title>webpad: the web-based text editor</title></head><body>';
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	echo "<!--\n";
	echo "top.window.close();\n";
	echo "// -->\n";
	echo '</script></body></html>';
	exit;
}


/**
 * @return String
 * @param String $name
 * @param Array $options
 * @param String $value
 * @param Array $misc
 * @desc Compiles an HTML string representing a SELECT form element and returns it.
 */
function display_select($name, $options, $value = false, $misc = false) {
	$select = '<select';
	if (strlen($name)) {
		$select .= ' name="' . $name . '"';
	}
	
	// Add extra attributes from the $extra array
	if (is_array($misc)) {
		while (list($id, $val) = each($misc)) {
			$select .= ' ' . $id . '="' . $val . '"';
		}
	}
	$select .= ">\r\n";
	
	// Add all the options to the select
	if (is_array($options)) {
		while (list($id, $val) = each($options)) {
			$select .= "\n<option";
			$select .= ' value="' . $id . '"';
			if (strcmp($id, $value)) {
				$select .= '>';
			}
			else {
				$select .= ' selected="selected">';
			}
			$select .= htmlspecialchars($val) . "</option>\r\n";
		}
	}
	$select .= "</select>\r\n";
	return $select;
}

/**
 * @return void
 * @param String $filename
 * @param String $home
 * @desc Confirms that the file being operated on is valid, given a home directory.
 */
function verify_secure_file($filename, $home) {
	if (substr($filename, 0, 10) == 'templates/' || substr($filename, 0, 5) == 'temp/') {
		return true;
	}
	else if (stristr($filename, $home) === false && $_SESSION['last_type'] != 'http') {
		$msg_title = 'Security Violation';
		$msg_body = 'You have attempted to access a file which you do not have permission to access. webpad has ceased operation and you must close your browser and open a new one to continue.';
		include('admin/message.php');
		exit;
	}
}

?>