<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
	if(isset($_POST['login']))
	{	$login = "true";}
	else
	{	$login = "false";}


  $username = $_POST['username'];
  $password = $_POST['password'];
  $passwordConfirm = $_POST['passwordConfirm'];
  $error = null;


  if (md5($password) != md5($passwordConfirm)) {
	$error = $error . $STR_PasswordMismatch . '<br>';
  }
  ?>
  <html>
  <head>
  <title><?echo $STR_ChangeUserInfo;?></title>
  <link href="dlf/styles.css" rel="stylesheet" type="text/css">
  </head>
  <body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#012436" oncontextmenu="return false;">
  <center>
  <table cellspacing="0" cellpadding="0" border="0" align="center" height="50" width="500">
        <tr><td></td>
        <td height="155" width="300" align="right" valign="middle"><Img src="dlf/mvix_logo.png" width="300" height="72"></td>
        </tr>
  <?
  // Display errors if any:
  if ($error) {
  ?>
        <tr><td></td><td><font face="Arial" color="white">
  <?
	echo $error;
	echo '<a href="register_form.php">' . $STR_TryAgain . '</a>.';
	exit;
  }

  // Change user info:
  $file = "/usr/local/etc/setup.php";
  $fp = fopen($file, 'r');
  $fileData = fread($fp, filesize($file));
  fclose($fp);
  $line = explode("\n", $fileData);
  $data = "";
  $i = 0;
  while ($i <= 7) {
        $dataPair = explode('=', $line[$i]);
	if ($dataPair[0] == "Login") {
		$dataPair[1]= $login;
		$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
	}elseif ($dataPair[0] == "User") {
        $dataPair[1]= $username . ':' . crypt(md5($password), md5($username));
		$data = $data. $dataPair[0].'='.$dataPair[1]."\n";	
        }
	else{
		$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
	}
        $i++;
  }


  $fp = fopen($file, 'w');
  if (fwrite($fp, $data)) {
        session_start();
        $_SESSION['loggedIn'] = 0;

		//change ftp user id and pass
		$filename = "/usr/local/etc/stupid-ftpd.conf";
        $fd = fopen($filename, 'r');
        $fileData = fread($fd, filesize($filename));
        fclose($fd);

        $line = explode("\n", $fileData);
		$i = 0;
		while ($i <= 6) {
			$dataPair = explode('=', $line[$i]);
			if ($dataPair[0] == user) {
				$details = explode("\t", $dataPair[1]);
				$details[0] = $username;
				if($password){
					$details[1] = $password;
				}else{
					$details[1] = "*";
				}
				$dataPair[1] = implode("\t", $details);

				$data1 = $data1. $dataPair[0].'='.$dataPair[1]."\n";
			}else{
				$data1 = $data1. $dataPair[0].'='.$dataPair[1]."\n";
			}
			$i++;
		}

		$fd = fopen($filename, 'w');
		if (fwrite($fd, $data1)){
			exec('killall stupid-ftpd > /dev/null &');
			sleep(5);
			exec('./stupid-ftpd -f /usr/local/etc/stupid-ftpd.conf > /dev/null &');
		}


  ?>
        <tr><td></td><td><font face="Arial" color="white">
  <?
        echo $STR_UserInfoChanged;
        echo '<a href="login_form.php">' . $STR_TryLogin . '</a>';
		echo "<script>document.location.href='register_form.php';</script>";
  }
  else{
  ?>
        <tr><td></td><td><font face="Arial" color="white">
  <?
        echo $STR_UnknownError;
	}
  fclose($fp);
?>
</body>
</html>

