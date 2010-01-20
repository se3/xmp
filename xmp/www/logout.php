<center>
<table cellspacing="0" cellpadding="0" border="0" align="center" height="50" width="500">
<? 
// Check to see if user is logged in.
if ($_SESSION['loggedIn'] != 1) {
?>
	<tr><td>
<?
	echo "Error: You cannot logout because you are not <a href=www/login_form.php>logged in</a>.";
	exit();
}
	
// Logout:
$_SESSION['loggedIn'] = 0;
$_SESSION['user'] = null;
session_destroy();
?>
<tr><td>
<?
echo "You have been logged out of the system.<br>";
echo "<a href=login_form.php>Go back to login page</a>.";
echo "<script>document.location.href='www/login_form.php';</script>";
?>
</td></tr></table></center>
