<? 
	error_reporting(0);
	

	exec('killall stupid-ftpd > /dev/null &');
	rename("/usr/local/etc/stupid-ftpd.conf", "/usr/local/etc/stupid-ftpd.conf_stop");

?>