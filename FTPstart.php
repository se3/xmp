<? 
	error_reporting(0);
	
   	rename("/usr/local/etc/stupid-ftpd.conf_stop", "/usr/local/etc/stupid-ftpd.conf");
	exec('./stupid-ftpd -f /usr/local/etc/stupid-ftpd.conf > /dev/null &');
	
?>