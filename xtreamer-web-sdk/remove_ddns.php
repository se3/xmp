<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';



	$filename = "/usr/local/etc/setup.php";
	$fp = fopen($filename, 'r');
	$fileData = fread($fp, filesize($filename));
	fclose($fp);

	$line = explode("\n", $fileData);
	$i = 0;
	while ($i <= 7) {
		$dataPair = explode('=', $line[$i]);
		if ($dataPair[0] == DDNS) {
			$dataPair[1] = "";
			$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
		}else if ($dataPair[0] == Port){
			$port = $dataPair[1];
			$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
		}else{
			$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
		}
	$i++;
	}

	// Remove DDNS:
	  $cmd = "/sbin/www/ddns_client .RM.";
	  exec($cmd);

	  $ddnsfile = "/tmp/ddns.result";
      $fp1 = fopen($ddnsfile, 'r');
      $fileData1 = fgets($fp1);
      fclose($fp1);
	  if(!strncmp($fileData1, "NS_DELETE_PASS", strlen($fileData1)-1)){
		  $file = fopen("/usr/local/etc/setup.php", "w");
		  if (fwrite($file, $data)) {
			    exec('killall ushare');
			    exec('/sbin/www/ushare -f ushare.conf -D');
				echo "<script>alert('DDNS removed successfully.');</script>";
			    $direction = "http://".$_SERVER["SERVER_ADDR"].":".$port."/setup_ddns.php";
			 	echo "<script>parent.document.location.href='$direction'</script>";
		  }else{
				echo "<script>alert('$STR_UnknownError');</script>";
		  }
		  fclose($file);
	  }else{
			echo "<script>alert('$STR_NetworkError');</script>";
	  }

?>
