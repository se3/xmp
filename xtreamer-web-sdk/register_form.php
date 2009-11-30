<?
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';

//read user name...
$filename = "/usr/local/etc/setup.php";
$fp = fopen($filename, 'r');
$fileData = fread($fp, filesize($filename));
fclose($fp);

$line = explode("\n", $fileData);
$i = 0;
while ($i <= 5) {
	   $dataPair = explode('=', $line[$i]);
	   if ($dataPair[0] == Login) {
			$loginoption = $dataPair[1];
	   }elseif ($dataPair[0] == User) {
			$data = explode(':', $dataPair[1]);
			$user = $data[0];
		}
	$i++;
}
?>

<html>
<head>
<title><?echo $STR_Setup;?></title>
<link href="dlf/styles.css" rel="stylesheet" type="text/css">
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#012436" oncontextmenu="return false;" onload="document.forms.register.username.focus()">

<script language="javascript">
	function disableAll()
	{
		if(document.register.login.checked)
		{
	//		document.register.username.disabled=false;
	//		document.register.password.disabled=false;
	//		document.register.passwordConfirm.disabled=false;
	//		document.register.submit.disabled=false;
		}else{
	//		document.register.username.disabled=true;
	//		document.register.password.disabled=true;
	//		document.register.passwordConfirm.disabled=true;
	//		document.register.submit.disabled=true;
		}
	}
</script>

<center>
<table cellspacing="0" cellpadding="0" border="0" height="500" width="996">

	<tr><td width=300>&nbsp</td>
		<td width=620>&nbsp</td>
        <td height="100" align="right" valign="bottom"><a href="index.php"><Img src="dlf/mvix_logo.png" width="300" height="72"></td>
    </tr>


<tr><td width=350>&nbsp</td>
	<td width=620 valign="top">

<?
//function checklogin(){
//	if ($loginoption == true){
//		echo "<script>document.getElementById('chkbox').chaked = true;</script>";
//	}else{
//		echo "<script>document.getElementById('chkbox').chaked = false;</script>";
//	}
//}
?>

	
	<table width=540 height="100"  cellspacing="0" cellpadding="0" border="0">
	<tr><td height=40></td></tr>
	<tr><td>
		<table cellspacing="0" cellpadding="0" border="0"><tr>
			<td><a href="register_form.php">
				<font face="arial" color="#ff0000" size="2"><b><u><?echo $STR_Login_Head;?></u> </b></font>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_ddns.php"><b><?echo $STR_DDNS_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_http.php"><b><?echo $STR_HTTP_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_ftp.php"><b><?echo $STR_FTP_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_live_keyword.php"><b><?echo $STR_LiveKeyword_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_backup.php"><b><?echo $STR_Backup_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
		</tr></table>
	</td></tr>
	
	<tr><td>
		<table cellspacing="0" cellpadding="0" border="0"><tr>
			<td width="150"></td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_language.php"><b><?echo $STR_Language_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_upnp_boost.php"><b><?echo $STR_NAS_Mode;?></b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<!--td><font face="arial" color="white" size="2">
				<a href="setup_time.php"><b>Time Server</b>
				<font face="arial" color="white" size="2">|&nbsp</td-->
			<td><font face="arial" color="white" size="2">
				<a href="setup_nfs.php"><b><?echo $STR_NFS_Client;?></b></td>
		</tr></table>
	</td></tr>
	</table>
	
	
	

	<table cellspacing="0" cellpadding="0" border="0">
	<tr><td height=50 width=100></td><td></td></tr>
	
	<tr><td width=100></td>
		<td>
		<form name="register" action="register.php" method="post">
			<table border="0">
			  <tr><td width="140"><font face="Arial" color="white" size="2"><?echo $STR_LoginOption;?></td>
			  <td><input type="checkbox" id="chkbox" class='btn_2' name="login" <?php if ($loginoption =="true") { echo 'checked'; }?> onclick='disableAll();'>
			  <tr><td width="140"><font face="Arial" color="white" size="2"><?echo $STR_Username;?></td>
			  <td><input type="text" name="username" class="textbox" size="20" maxlength="16" value=<?echo $user;?> ><br></td></tr>
			  <tr><td width="140"><font face="Arial" color="white" size="2"><?echo $STR_Password;?></td>
			  <td><input type="password" name="password" class="textbox" size="20" maxlength="16" ><br></td></tr>
			  <tr><td width="140"><font face="Arial" color="white" size="2"><?echo $STR_ConfirmPassword;?></td>
			  <td><input type="password" name="passwordConfirm" class="textbox" size="20" maxlength="16"><br></td></tr>
			  <tr><td height="5"></td></tr>
			  <tr><td></td><td><input type="submit" class='btn_2' name="submit" value="<?echo $STR_Apply;?>"></td></tr>
			</table>
		</form>
		</td>
	</tr>
	</table>

	</td>

	<td width="337" align="right" valign="middle"><img src="dlf/pvr_img.png" width="337" height="250"></td>
</tr>
</table>

<iframe name='gframe' width=0 height=0 style="display:none"></iframe>

<table width="700"  border="0" cellspacing="0" cellpadding="0">
  <tr height=4><td></td></tr>	
  <tr>
    <td align="right" valign="top" style="border-top:solid 1px; border-top-color:#FFFFFF"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr><td width=20></td>
        <td width=440 valign="middle"><font face="Arial" color="#748e94" size="2"><a href="index.php"><?echo $STR_Home;?></a> | <a href="register_form.php"><?echo $STR_Setup;?></a> | <a href="logout.php"><?echo $STR_Logout;?></a></font></td>

		<td align=right>
			<table><tr><!--td align=right><font face="Arial" color="#000000" size="1"><b><?echo date('M, d Y | h:i A');?></td--></tr>
				   <tr><td align=right><font face="Arial" color="#000000" size="1"><b>Copyright ⓒ 2009 Xtreamer.net, All right reserved.</td></tr>
			</table>
		</td>

        <td align=right><img src="dlf/footer.png" width="175" height="51" usemap="#planetmap">
		<map name="planetmap">
		  <area shape="rect" coords="05,100,135,2" href='#' onclick="window.open('http://xtreamer.net/','MyVideo','height=675,width=987,left=100,top=100, toolbar=yes,location=yes,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no');";/>
		</map>
		</td>
      </tr>
    </table>
      </td>
  </tr>
</table>
</center>

</body>
</html>
