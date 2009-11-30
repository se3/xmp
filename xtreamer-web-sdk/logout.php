<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
include '/tmp/lang.php';
?>
<html>
<head>
<title>Logout</title>
<link href="dlf/styles.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="black" oncontextmenu="return false;">
<center>
<table cellspacing="0" cellpadding="0" border="0" align="center" height="50" width="500">
        <tr><td></td>
        <td height="155" width="300" align="right" valign="middle"><Img src="dlf/mvix_logo.png" width="300" height="72"></td>
        </tr>
<? 
// Check to see if user is logged in.
if ($_SESSION['loggedIn'] != 1) {
?>
	<tr><td></td><td><font face="Arial" color="white">
<?
	echo  $STR_LogoutError . '  <a href="login_form.php">' .$STR_loggedin. '</a>.';
	exit();
}
	
// Logout:
$_SESSION['loggedIn'] = 0;
$_SESSION['user'] = null;
session_destroy();
?>
<tr><td></td><td><font face="Arial" color="white">
<?
echo $STR_loggedOut. ' <br>';
//echo $STR_GoBack . ' <a href="login_form.php">'. $STR_LoginPage . '</a>.';
echo '<a href="login_form.php">'. $STR_LoginPage . '</a>.';
echo "<script>document.location.href='login_form.php';</script>";
?>
</body>
</html>
