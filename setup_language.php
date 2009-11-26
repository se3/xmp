<?
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';
?>

<html>
<head>
<title><?echo $STR_Setup;?></title>
<link href="dlf/styles.css" rel="stylesheet" type="text/css">
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#012436" oncontextmenu="return false;" onload="document.forms.language.language.focus()">

<script language="javascript">

function goto(form){
		document.language.target = 'gframe';
		document.language.action = 'language.php';
		document.language.submit();
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

	<table width=540 height="100"  cellspacing="0" cellpadding="0" border="0">
	<tr><td height=40></td></tr>
	<tr><td>
		<table cellspacing="0" cellpadding="0" border="0"><tr>
			<td><a href="register_form.php">
				<font face="arial" color="white" size="2"><b><?echo $STR_Login_Head;?> </b></font>
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
			<td><a href="setup_language.php">
				<font face="arial" color="#ff0000" size="2"><b><u><?echo $STR_Language_Head;?></u> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_upnp_boost.php"><b><?echo $STR_NAS_Mode;?></b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_nfs.php"><b><?echo $STR_NFS_Client;?></b></td>
		</tr></table>
	</td></tr>	
	</table>
	
	
	

	<table cellspacing="0" cellpadding="0" border="0">
	<tr><td height=50 width=100></td><td></td></tr>

	<tr><td width=100></td>
		<td>
		<FORM NAME="language" method="post">
			<table border="0" >
              <tr><td><font face="Arial" color="white" size="2"><?echo $STR_SelectLanguage;?></td>
				  <td valign="top"><select name="language" class="listbox" ONCHANGE="goto(this.form)" size="1" style="FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; position: absolute;" onmousedown="if(this.options.length>12){this.size=12;}" onblur="this.size=0;" >
							<option value=""><?echo $STR_SelectLang;?></option>
							<option value="arabic"><?echo $STR_Arabic;?></option>
							<option value="brazil"><?echo $STR_Brazil;?></option>
							<option value="czech"><?echo $STR_Czech;?></option>
							<option value="danish"><?echo $STR_Danish;?></option>
							<option value="german"><?echo $STR_German;?></option>
							<option value="english"><?echo $STR_English;?></option>
							<option value="spain"><?echo $STR_Spain;?></option>
							<option value="estonia"><?echo $STR_Estonia;?></option>
							<option value="greek"><?echo $STR_Greek;?></option>
							<option value="france"><?echo $STR_France;?></option>
							<option value="hungarian"><?echo $STR_Hungarian;?></option>
							<option value="hebrew"><?echo $STR_Hebrew;?></option>
							<option value="italy"><?echo $STR_Italy;?></option>
							<option value="kr"><?echo $STR_Korean;?></option>
							<option value="neder"><?echo $STR_Neder;?></option>
							<option value="polish"><?echo $STR_Polish;?></option>
							<option value="portu"><?echo $STR_Portu;?></option>
							<option value="russia"><?echo $STR_Russia;?></option>
							<option value="slovenia"><?echo $STR_Solvenia;?></option>
							<option value="thai"><?echo $STR_Thai;?></option>
							<option value="turkish"><?echo $STR_Turkish;?></option>
							<option value="vietname"><?echo $STR_Vietname;?></option>
					   </select></td>
              </tr>
           </table>
		</FORM>
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
