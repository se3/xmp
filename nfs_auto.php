<?
session_start();
error_reporting(0);
//sleep(30);

$filename = "/usr/local/etc/nfs";
if(file_exists($filename)){
	$fp = fopen($filename, 'r');
	$fileData = fread($fp, filesize($filename));
	fclose($fp);

	$line = explode("\n", $fileData);
	$count = count($line);
	
	for($i=0; $i<$count-1; $i++){
		$datapair = explode("->", $line[$i]);
		$l_mount = $datapair[0];
		$subpair = explode(" ", $datapair[1]);
		$r_mount = $subpair[0];
		$m_option = $subpair[2];
		
		if (substr($l_mount, 0, 13) == "/tmp/nfsmount"){
			if(!file_exists("/tmp/nfsmount")){
				mkdir("/tmp/nfsmount", 0777);
			}
			mkdir(str_replace("\ "," ", $l_mount), 0777);
		}

		$command = "mount -t nfs ".$r_mount ." ".$l_mount." -o nolock,".$m_option;
		$j = 0;
		while($j < 3){
			exec("$command",$result,$output);
			if($output == 0)
				break;
		$j++;
		}
	}
}
?>