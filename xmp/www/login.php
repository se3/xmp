<?php
session_start();
error_reporting(0);
?>

<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="../xmp.css">
</head>
<body oncontextmenu="return false;">

<div id="mainFrame">
<center>
<table cellspacing="0" cellpadding="0" border="0" align="center" height="50" width="500">
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
<?
if($_SESSION['loggedIn'] == 1){
?>
	<tr><td>
<?
	echo "You are already logged in.";
	echo "<a href=main.php>Go to Home Page</a></td></tr>";
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
        <tr><td></td><td>
<?
	echo "Enter admin ID and Password to <a href=login_form.php>Login</a></td></tr>";
}else{
	$username = $_POST['username'];
	$rawpass = $_POST['password'];
	$password = crypt(md5($rawpass), md5($username));
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
        	<tr><td></td><td>
	<?
        	echo "Enter admin ID and Password to <a href=login_form.php>Login</a></td></tr>";
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
			echo "<script>document.location.href='".$_SESSION['redirect']."'</script>";			
			exit;
		}else {
		?>
			<tr><td></td><td>
		<?
			echo "Invalid username/password<br>";
			echo "<a href=login_form.php>Try Login again</a></td></tr>";
		}
	}
}
?>
</table>
</center>
</div>
</body>
</html>
