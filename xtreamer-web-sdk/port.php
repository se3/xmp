<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
  include '/tmp/lang.php';
  $port = $_POST['port'];
  $error = null;
  $path = "http://".$_ENV["SERVER_ADDR"].':'.$port;

  // Check for blank fields:
  if ($port == null || $port == ''){
	$error = $STR_ValidPort . '<br>';
  }
  else{
	//modify Port no
	$filename = "/usr/local/etc/setup.php";
        	$fp = fopen($filename, 'r');
        	$fileData = fread($fp, filesize($filename));
        	fclose($fp);

        $line = explode("\n", $fileData);
	$i = 0;
	while ($i <= 7) {
        	$dataPair = explode('=', $line[$i]);
        	if ($dataPair[0] == Port) {
		    $dataPair[1] = $port;
		    $data = $data. $dataPair[0].'='.$dataPair[1]."\n";
		}else{
			$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
		}
        $i++;
	}
  }
?>
  <html>
  <head>
  <title>Port</title>
  </head>
  <body bgcolor="black" oncontextmenu="return false;" onLoad="redirect();">
  <center>
  <table cellspacing="0" cellpadding="0" border="0" align="center" height="50" width="500">
        <tr><td></td>
        <td height="155" width="400" align="right" valign="middle"><Img src="dlf/mvix_logo.png" width="300" height="72"></td>
        </tr>
  <?
  // Display errors if any:
  if ($error) {
  ?>
        <tr><td></td><td><font color="white">
  <?
	echo $error;
	echo '<a href="register_form.php">' . $STR_TryAgain . '</a>.';
	exit;
  }

  // Modify Port of system:
  $file = fopen("/usr/local/etc/setup.php", "w");
  if (fwrite($file, $data)) {
	echo "<script>alert('$STR_Restart');</script>";
	sleep(5);
	shell_exec('reboot');
//	shell_exec('./restart.sh');
  ?>
        <tr><td></td><td><font color="white">
  <?
	echo $STR_Restart . "\n";
	echo $STR_AfterReeboot . " <a href=$path>".$path;
  }
  else{
  ?>
        <tr><td></td><td><font color="white">
  <?
	echo $STR_UnknownError;
  }
  fclose($file);

//restart lighttpd
//echo `./restart.sh`;
//shell_exec(`./restart.sh`);
?>
</body>
</html>
