<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
  include '/tmp/lang.php';
  $ftpport = $_POST['ftpport'];
  $error = null;

  // Check for blank fields:
  if ($ftpport == null || $ftpport == ''){
	$error = $STR_ValidPort . '<br>';
  }
  else{
	//modify Port no
	$filename = "/usr/local/etc/stupid-ftpd.conf";
        	$fp = fopen($filename, 'r');
        	$fileData = fread($fp, filesize($filename));
        	fclose($fp);

        $line = explode("\n", $fileData);
	$i = 0;
	while ($i <= 6) {
        	$dataPair = explode('=', $line[$i]);
        	if ($dataPair[0] == port) {
		    $dataPair[1] = $ftpport;
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
  <title>FTPPort</title>
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
  $file = fopen("/usr/local/etc/stupid-ftpd.conf", "w");
  if (fwrite($file, $data)) {
	exec('killall stupid-ftpd > /dev/null &');
	sleep(5);
	exec('./stupid-ftpd -f /usr/local/etc/stupid-ftpd.conf > /dev/null &');
	echo "<script>alert('$STR_FTPPortChangeSuccess');</script>";
  }else{
  ?>
        <tr><td></td><td><font color="white">
  <?
	  echo "<script>alert('$STR_UnknownError');</script>";
	//echo $STR_UnknownError;
  }
  fclose($file);

?>
</body>
</html>