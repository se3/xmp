<? 
error_reporting(0);
	sleep(10);
	$cmd = "ps -aux | grep DvdPlayer";
	exec($cmd, $output, $result); 

	if (count($output) <= 2){
		exec('/usr/local/etc/rcS > /dev/null &');
	}
?>