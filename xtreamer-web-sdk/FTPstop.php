<? 
	error_reporting(0);
	
	//$cmd = "ps -aux | grep stupid-ftpd";
	//exec($cmd, $output, $result); 
	
	
	//if (count($output) <= 2){
	//	exec('./stupid-ftpd -f /usr/local/etc/stupid-ftpd.conf > /dev/null &');
	//}else{
		exec('killall stupid-ftpd > /dev/null &');
		rename("/usr/local/etc/stupid-ftpd.conf", "/usr/local/etc/stupid-ftpd.conf_stop");
	//}
?>