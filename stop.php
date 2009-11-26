<?
error_reporting(0);
	$cmd = "ps -aux | grep DvdPlayer";
	exec($cmd, $output, $result); 

	if (count($output) > 2){
		exec('/usr/local/bin/NAS_Mode_App > /dev/null &');
	}
?>