<?php
session_start();
error_reporting(0);
?>

<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="../xmp.css">
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" oncontextmenu="return false;" onLoad="document.forms.login.username.focus()">

<div id="mainFrame">
<center>
<table cellspacing="0" cellpadding="0" border="0" align="center" height="400" width="800">

<tr>
  <td colspan=2><h2>Welcome to the Xtreamer Mod Pack.</h2></td>
</tr>

<tr>
	<td width=60></td>
	<td width=400 valign="top">
		<form name="login" method="post" action="login.php">
		<table cellspacing="0" cellpadding="0" border="0">
			<tr>
			  <td colspan=2><font face="Arial" color="#ff0000" size="3"><b>Login</b></font></td>
			</tr>
			<tr>
			  <td colspan=2>&nbsp;</td>
			</tr>
			<tr>
			  <td colspan=2>The username and password are the same as the Xtreamer Web Gui.</td>
			</tr>
			<tr>
			  <td colspan=2>&nbsp;</td>
                        </tr>
			<tr><td width="90" align=right>User Name</td>
			<td>&nbsp;&nbsp;<input type="text" name="username" size="20" style="color: black"><br></td></tr>
			<tr><td width="90" align=right>Password</td>
			<td>&nbsp;&nbsp;<input type="password" name="password" size="20" style="color: black"></td></tr><br><br>
			<tr><td height="10"></td></tr>
			<tr><td></td><td>&nbsp;&nbsp<input type="submit" value="Login"></td></tr>
		</table>
		</form>
	</td>
</tr>
</table>
</center>
</div>
</body>
</html>

