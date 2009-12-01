<?php

/***********************************************************\
                 Basic HTTP Authentication
                      version 1.0

               Written by Beau Lebens, 2005
                beau@dentedreality.com.au
          http://www.dentedreality.com.au/basicauth/

      - Created to support an Atom API Implementation -

  More Info;
     http://www.w3.org/Protocols/HTTP/1.0/draft-ietf-http-spec.html
    
\***********************************************************/

class BasicAuth {
	var $username;
	var $password;
	
	/**
	* @return BasicAuth
	* @param String $username
	* @param String $password
	* @desc Constructor - sets variables only
	*/
	function BasicAuth($username, $password) {
		if (strlen($username)) {
			$this->username = $username;
		}
		
		if (strlen($password)) {
			$this->password = $password;
		}
	}
	
	/**
	* @return String or Array
	* @param Boolean $array TRUE to return an array suitable for cURL, FALSE/NULL for a string 
	* @desc Returns the HTTP headers required for sending Basic Authentication information
	*/
	function get_header($array = false) {
		// Array for use in CURLOPT_HTTPHEADER
		if ($array) {
			return array("Authorization: Basic " . base64_encode($this->username . ':' . $this->password));
		}
		// String for manual request construction
		else {
			return 'Authorization: Basic ' . base64_encode($this->username . ':' . $this->password) . "\r\n";
		}
	}
	
	/**
	* @return String/FALSE
	* @desc Returns username if set, or FALSE
	*/
	function get_username() {
		if (isset($this->username)) {
			return $this->username;
		}
		else {
			return false;
		}
	}
	
	/**
	* @return String/FALSE
	* @desc Returns password if set, or FALSE
	*/
	function get_password() {
		if (isset($this->password)) {
			return $this->password;
		}
		else {
			return false;
		}
	}
}

?>