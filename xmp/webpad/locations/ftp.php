<?php

/**
 * @return String/FALSE on error
 * @param String $server
 * @param String $port
 * @param String $pasv
 * @param String $username
 * @param String $password
 * @param String $file
 * @desc Connects to an FTP server, requests the specified file, writes it to
 *       a temporary location and then loads it into a string.
 */
function open_from_ftp($server, $port = '', $pasv, $username, $password, $file) {
	global $javascript_msg;
	
	// Set the port we're using
	$port = (isset($port) && $port != '' ? $port : 0);
	
	// Connect to FTP Server
	if ($ftp = @ftp_connect($server, $port)) {
		// Log in using details provided
		if ($logged_in = @ftp_login($ftp, $username, $password)) {
			// Set PASV mode
			ftp_pasv($ftp, $pasv);
			
			// Create a temporary file, and get the remote file contents into it.
			$temp_file = 'temp/' . date('YmdHis') . '.wp';
			if ($local_file = @fopen($temp_file, 'wt')) {
				if (@ftp_fget($ftp, $local_file, $file, FTP_ASCII)) {
					@ftp_quit($ftp);
					fclose($local_file);
					// Make sure that the file parsing function exists, or grab code for it
					if (!function_exists('parse_file')) {
						require_once('common.php');
					}
					$string = parse_file($temp_file);
					return $string;
				}
				else {
					$javascript_msg = '@Could not get the file from the FTP Server.';
					return false;
				}
			}
			else {
				$javascript_msg = '@Could not create temporary file. Check the permissions on webpad\'s temporary folder.';
				return false;
			}
		}
		else {
			$javascript_msg = '@Authentication failed on FTP Server \'' . $server . '\'.';
			return false;
		}
	}
	else {
		$javascript_msg = '@Could not connect to FTP Server \'' . $server . '\'.';
		return false;
	}
}


/**
 * @return boolean
 * @param String $server
 * @param String $port
 * @param String $pasv
 * @param String $username
 * @param String $password
 * @param String $file
 * @param String $string
 * @desc Connects to the FTP server and writes the string to the file specified.
 */
function save_to_ftp($server, $port, $pasv, $username, $password, $file, $string) {
	global $javascript_msg;
	
	// Write the string that we're working with to a temp file locally.
	$temp_file = 'temp/' . date('YmdHis') . '.wp';
	if ($local_file = @fopen( $temp_file, 'wt')) {
		@fwrite($local_file, $string);
		fclose($local_file);
	}
	else {
		$javascript_msg = '@Could not create temporary file. Check the permissions on webpad\'s temporary folder.';
		return false;
	}
	
	// Set the port we're using
	$port = (isset($port) && $port != '' ? $port : 0);
	
	// Connect to the FTP server
	if ($ftp = @ftp_connect($server, $port)) {
		// Log in
		if ($logged_in = @ftp_login($ftp, $username, $password)) {
			// Set PASV mode
			ftp_pasv($ftp, $pasv);
			
			// Transfer the temp file we created before
			if (@ftp_put($ftp, $file, $temp_file, FTP_ASCII)) {
				ftp_quit($ftp);
				$javascript_msg = 'File saved successfully.';
				return true;
			}
			else {
				$javascript_msg = '@Could not save the file \'' . $file . '\' on the FTP server.';
				return false;
			}
		}
		else {
			$javascript_msg = '@Authentication failed on FTP server \'' . $server . '\'.';
			return false;
		}
	}
	else {
		$javascript_msg = '@Could not connect to FTP Server \'' . $server . '\'.';
		return false;
	}
}

/**
 * @return void
 * @param $msg string ErrorMessage
 * @desc Dump an error message for the FTP dialog box and exit;
 */
function output_ftp_error($msg) {
	echo '<html><head><title>webpad: ftp</title><link rel="stylesheet" href="../css/files.css" type="text/css" /></head><body>';
	echo '<a href="select_ftp.php?clear=true" title="Change Active Server"><img src="../images/files_up.gif" width="19" height="18" border="0" align="absmiddle" /> Change Active Server</a>';
	echo '<p>' . $msg . '</p>';
	echo '</body></html>';
	exit;
}

?>