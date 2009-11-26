<?
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$file = "/usr/local/etc/setup.php";
$fp = fopen($file, 'r');
$fileData = fread($fp, filesize($file));
fclose($fp);
$line = explode("\n", $fileData);
$i = 1;
while ($i <= 5) {
	$dataPair = explode('=', $line[$i]);
	
	if ($dataPair[0] == "Lang") {
			if (strcmp($dataPair[1], 'arabic')== 0){
				copy("arabic.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'czech')== 0){
				copy("czech.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'danish')== 0){
				copy("danish.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'english')== 0){
				copy("eng.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'estonia')== 0){
				copy("estonia.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'france')== 0){
				copy("france.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'german')== 0){
				copy("german.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'greek')== 0){
				copy("greek.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'hungarian')== 0){
				copy("hungarian.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'hebrew')== 0){
				copy("hebrew.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'italy')== 0){
				copy("italy.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'kr')== 0){
				copy("kr.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'neder')== 0){
				copy("neder.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'polish')== 0){
				copy("polish.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'portu')== 0){
				copy("portu.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'brazil')== 0){
				copy("bra.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'russia')== 0){
				copy("russia.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'spain')== 0){
				copy("spain.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'slovenia')== 0){
				copy("slovenian.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'thai')== 0){
				copy("thai.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'turkish')== 0){
				copy("turkish.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'vietname')== 0){
				copy("vietnamese.php", "/tmp/lang.php");
			}else{
				copy("eng.php", "/tmp/lang.php");	
			}
	}
	$i++;
}

include '/tmp/lang.php';
shell_exec('rm -rf /tmp/hdd/volumes/HDD1/.cached/*');
?>

<html>
<head>
<title><?echo $STR_LoginTitle;?></title>
<link href="dlf/styles.css" rel="stylesheet" type="text/css">
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#012436" oncontextmenu="return false;" onLoad="document.forms.login.username.focus()">

<script language="javascript">
function newwindow(w,h,webaddress){
	var viewimageWin = window.open(webaddress,'New_Window','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width='+w+',height='+h);

	viewimageWin.moveTo(screen.availWidth/2-(w/2),screen.availHeight/2-(h/2));
}
</script>

<center>
<table cellspacing="0" cellpadding="0" border="0" align="center" height="400" width="830">
 
<tr>
  <td colspan=2><font face="Arial" color="white" size="+2"><b>Welcome</b></font></td>
  
  <td height="140" align="right" valign="middle"><img src="dlf/logo_black.png" width="300" height="72"></td>
</tr>

<tr>
	<td width=60></td>
	<td width=400 valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<!--td><font face="Arial" color="white" size="+2"><b>Welcome</b></font></td-->
		  </tr>
		  <tr>
			<td><font face="Arial" color="#ff0000" size="3"><b>Overview</b></font></td>
		  </tr>

		  <tr>
			<td height=10></td>
		  </tr>
		  <tr>
			<td><font face="Arial" color="#000000" size="2">With</font><font face="Arial" color="white" size="2"> XtreamerUPnP</font><font face="Arial" color="#000000" size="2"> Server your typical living room experience can be truly extended beyond the boundaries of your home.Once logged in you will be able to access all the multimedia content on your <br>
			</font><font face="Arial" color="white" size="2">Xtreamer </font><font face="Arial" color="#000000" size="2">unit anytime anywhere with a click. Staying connected on the go has never been easier. Your music, movies and photos will be waiting for you in a flexible navigation structure.</font></td>
		  </tr>
		  
		</table>

		<form name="login" method="post" action="login.php">
		<table cellspacing="0" cellpadding="0" border="0">
			<tr>
			  <td><font face="Arial" color="#ff0000" size="3"><b>Login</b></font></td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr><td width="90" align=right><font face="Arial" color="#000000" size="2"><b><?echo $STR_UserID;?></td>
			<td>&nbsp;&nbsp;<input type="text" name="username" size="20" class="textbox"><br></td></tr>
			<tr><td width="90" align=right><font face="Arial" color="#000000" size="2"><b><?echo $STR_Password;?></td>
			<td>&nbsp;&nbsp;<input type="password" name="password" size="20" class="textbox"></td></tr><br><br>
			<tr><td height="10"></td></tr>
			<tr><td></td><td>&nbsp;&nbsp<input type="submit" class='btn_2' value="<?echo $STR_LoginTitle;?>"></td></tr>
		</table>
		</form>
	</td>
	<td width="340" align="right" valign="bottom"><img src="dlf/pvr_img.png" width="337" height="250"></td>
</tr>
</table>  



<table width="700"  border="0" cellspacing="0" cellpadding="0">
	<tr height="105"><td></td></tr>
	<tr>
		<td align="center" valign="top" style="border-top:solid 1px; border-top-color:#FFFFFF">
		<table width="900" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="middle" width='52%'><!--font face="Arial" color="#748e94" size="2"><a href="index.php"><?echo $STR_Home;?> | <a href="register_form.php"><?echo $STR_Setup;?></a> | <a href="logout.php"><?echo $STR_Logout;?></a></font--></td>
			<td align=right>
				<table border="0" cellspacing="0" cellpadding="0">
						<tr><!--td align=right><font face="Arial" color="#000000" size="1"><b><?echo date('M, d Y | h:i A');?></td--></tr>
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
