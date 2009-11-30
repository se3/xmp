<? 
	error_reporting(0);
	
	//$cmd = "ps -aux | grep stupid-ftpd";
	//exec($cmd, $output, $result); 
		
	//if (count($output) <= 2){
		rename("/usr/local/etc/stupid-ftpd.conf_stop", "/usr/local/etc/stupid-ftpd.conf");
		exec('./stupid-ftpd -f /usr/local/etc/stupid-ftpd.conf > /dev/null &');
	//}else{
	//	exec('killall stupid-ftpd > /dev/null &');
	//}
?>