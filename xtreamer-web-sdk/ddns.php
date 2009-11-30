<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
	$ddnsInput = $_POST['ddns'];
	$error = null;

//check input is alphanumeric or not?
if (ctype_alnum($ddnsInput)){
	$filename = "/usr/local/etc/setup.php";
	$fp = fopen($filename, 'r');
	$fileData = fread($fp, filesize($filename));
	fclose($fp);

	$line = explode("\n", $fileData);
	$i = 0;
	while ($i <= 7) {
		$dataPair = explode('=', $line[$i]);
		if ($dataPair[0] == DDNS) {
			$dataPair[1] = $ddnsInput.".myxtreamer.net";
			$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
		}else if ($dataPair[0] == Port){
			$port = $dataPair[1];
			$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
		}else{
			$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
		}
	$i++;
	}

	// Add new DDNS:
	  $cmd = "./ddns_client " . $ddnsInput.".myxtreamer.net";
	  //$cmd = "/sbin/www/ddns_client " . $ddnsInput.".mvix.net";
	  exec($cmd);

	  $ddnsfile = "/tmp/ddns.result";
      $fp1 = fopen($ddnsfile, 'r');
      $fileData1 = fgets($fp1);
      fclose($fp1);
	  //echo strlen($fileData1)-1;
	  if((!strncmp($fileData1, "NS_UPDATE_PASS", strlen($fileData1)-1)) || (!strncmp($fileData1, "NS_REGISTER_PASS", strlen($fileData1)-1)) || (!strncmp($fileData1, $ddnsInput.".myxtreamer.net", strlen($fileData1)-1))){
		  $file = fopen("/usr/local/etc/setup.php", "w");
		  if (fwrite($file, $data)) {
			    exec('killall ushare');
			    exec('./ushare -f ushare.conf -D');
				echo "<script>alert('$STR_DDNSChanged');</script>";
			    $direction = "http://". $ddnsInput.".myxtreamer.net:".$port."/setup_ddns.php";
			 	echo "<script>parent.document.location.href='$direction'</script>";
		  }else{
				echo "<script>alert('$STR_UnknownError');</script>";
		  }
		  fclose($file);
	  }else if(!strncmp($fileData1, "NS_NAMEXIST", strlen($fileData1)-1)){
		    echo "<script>alert('$STR_DDNSExists');</script>";
			//echo "<script>parent.document.location.href='register_form.php'</script>";
			echo "<script>parent.document.forms.ddns.ddns.focus();</script>";
	  }else{
			echo "<script>alert('$STR_NetworkError');</script>";
	  }
}else{
		echo "<script>alert('$STR_DDNSinvalid');</script>";
}
?>
