<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
include '/tmp/lang.php';
?>
<html>
<title><?echo $STR_LoginTitle;?></title>
<link href="dlf/styles.css" rel="stylesheet" type="text/css">
<body  oncontextmenu="return false;">
<center>
<table cellspacing="0" cellpadding="0" border="0" align="center" height="50" width="500">
	<tr><td></td>
	<td height="155" width="300" align="right" valign="middle"><Img src="dlf/mvix_logo.png" width="300" height="72"></td>
	</tr>
<?
if($_SESSION['loggedIn'] == 1){
?>
	<tr><td></td><td><font face="Arial" color="white">
<?
//	echo $STR_AlreadyLogedIn ." " . $_SESSION['user'];
	echo $STR_AlreadyLogedIn;
//	echo '<br>'. $STR_GoTo;
	echo "<a href=index.php>". $STR_HomePage;
	exit();
}
//if password file dont exists create it with admin auth...
$data = "Mvix=UPnP\n"."Login=false\n"."User=admin".':'.crypt(md5("pass"), md5("admin"))."\n"."Port=80\n"."DDNS=\n"."Lang=english\n"."Region=0\n"."DST=0\n";
$file = "/usr/local/etc/setup.php";
if (!file_exists($file)) {
	$passfile = fopen($file, "w");
	fwrite($passfile, $data);
	fclose($passfile);
?>
        <tr><td></td><td><font face="Arial" color="white">
<?
	echo $STR_AdminID. '<a href="login_form.php">' .$STR_LoginTitle. '</a>';
}else{
	$username = $_POST['username'];
	$rawpass = $_POST['password'];
	$password = crypt(md5($rawpass), md5($username));
//	$password = crypt(md5($rawpass));
//echo "<script>alert('$password');</script>";
	$fp = fopen($file, 'r');
	$fileData = fread($fp, filesize($file));
	fclose($fp);

	$line = explode("\n", $fileData);
	if($line[0]!= "Mvix=UPnP")
	{
        	$passfile = fopen($file, "w");
       		fwrite($passfile, $data);
        	fclose($passfile);
	?>
        	<tr><td></td><td><font face="Arial" color="white">
	<?
        	echo $STR_AdminID. '<a href="login_form.php">' .$STR_LoginTitle. '</a>';
	}else{
		$i = 0;
		while ($i <= sizeof($line)) {
			$dataPair = explode('=', $line[$i]);
			if ($dataPair[0] == "User"){
				$user = explode(':', $dataPair[1]);
				if ($user[0] == $username && $user[1] == $password) {
					$authed = 1;
				}
			}
			$i++;
		}

		if ($authed == 1) {
			$_SESSION['loggedIn'] = 1;
			$_SESSION['user'] = $username;
			//echo "<script>document.location.href='index.php'</script>";
			echo "<script>document.location.href='".$_SESSION['redirect']."'</script>";			
			//header("Location:index.php");
			exit;
		}else {
		?>
			<tr><td></td><td><font face="Arial" color="white">
		<?
			echo $STR_InvalidUsername . '<br>';
			echo '<a href="login_form.php">' . $STR_TryLoginAgain . '</a> ';
		}
	}
}
?>
</body>
</html>
