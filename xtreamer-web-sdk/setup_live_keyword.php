<?
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';

//read ip no ...
$filename = "/etc/hosts";
$fp = fopen($filename, 'r');
$fileData = fread($fp, filesize($filename));
fclose($fp);

$line = explode("\n", $fileData);
$dataPair = explode("\t", $line[1]);
$live_ip = $dataPair[0];
//echo "<script>alert('$live_ip');</script>";
if($live_ip == "210.109.97.109")
	$live_ip = "";	
?>

<html>
<head>
<title><?echo $STR_Setup;?></title>
<link href="dlf/styles.css" rel="stylesheet" type="text/css">
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#012436" oncontextmenu="return false;">

<script language="javascript">
function defaultip(){
	if(confirm('Do you really want to set default http server as Live server?')){
		document.live.target = 'gframe';
		document.live.action = 'default_ip.php';
		document.live.submit();
	}
}

function changeip(){
/*errorString = "";
theName = "IPaddress";
IPvalue = document.live.ip.value;

var ipPattern = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/;
var ipArray = IPvalue.match(ipPattern);

if (IPvalue == "0.0.0.0")
	errorString = errorString + theName + ': '+IPvalue+' is a special IP address and cannot be used here.';
else if (IPvalue == "255.255.255.255")
	errorString = errorString + theName + ': '+IPvalue+' is a special IP address and cannot be used here.';
if (ipArray == null)
	errorString = errorString + theName + ': '+IPvalue+' is not a valid IP address.';
else {
	for (i = 0; i < 5; i++) {
		//alert(ipArray[i]);
		thisSegment = ipArray[i];
		if (thisSegment > 255) {
			errorString = errorString + theName + ': '+IPvalue+' is not a valid IP address.';
		i = 5;
		}
		if ((i == 0) && (thisSegment > 255)) {
			errorString = errorString + theName + ': '+IPvalue+' is a special IP address and cannot be used here.';
			i = 5;
	    }
    }
}
extensionLength = 3;
if (errorString != "")
	alert (errorString);
else{*/

	if(!document.live.ip.value){
		alert('Please enter your live server URL');
		document.live.ip.focus();
	}else if(document.live.ip.value.substring(0,7) == "http://"){
		alert('Please enter only server IP or DNS without "http://"');
		document.live.ip.focus();
	}else if(confirm('Do you really want to use your personal http server as Live server?')){
		loadDivEl = document.getElementById("loadDiv");
		loadDivEl.style.visibility = 'visible';
		document.live.target = 'gframe';
		document.live.action = 'live_ip.php';
		document.live.submit();
	}
 //}
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
			<td><a href="setup_live_keyword.php">
				<font face="arial" color="#ff0000" size="2"><b><u><?echo $STR_LiveKeyword_Head;?></u> </b>
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
	<tr><td height=100 width=80></td><td></td></tr>

	<tr><td width=80></td>
		<td>
        <form name="live" method="post">
          <table border="0">
			  <tr>
				  <td><font face="Arial" color="white" size="2"><?echo $STR_Live_Server_IP;?> http://</td>
				  <td width="170"><input type="text" name="ip" class="textbox" size="20" maxlength="250" value=<?echo $live_ip;?> ></td>
				  <td><input type="button" class='btn_2' name="saveip" id="saveip" value="<?echo $STR_Apply;?>" onClick="javascript:changeip();"></td>
				  <td><input type="button" class='btn_2' name="default" id="default" value="<?echo $STR_Set_Default;?>" onClick="javascript:defaultip();"></td>
			  </tr>	
			  <tr>
				  <td></td>
				  <td colspan=3><font face="Arial" color="white" size="2">(Enter URL[without port no],default port 80 supported only)</td>
			  </tr>
              <tr><td><font face="Arial" color="white" size="2"><?echo $STR_LiveKey;?></td>
                  <td><input type="button" class='btn_2' value="<?echo $STR_Make;?>" onClick="window.open('url.php','InputURL','height=460,width=600,left=280,top=200')"></td>
              </tr>
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
<div id="loadDiv" name="loadDiv" style="position:absolute; visibility:hidden; left:340;top:190;width:200; height:100; z-index:1;">
	<table cellspacing="0" cellpadding="0" border="0" width=100% height=100%>
		<td valign=middle align=center>
			<table borde=0 align=center>
				<td align=center>			
					<img src="dlf/upload.gif">
				</td>
			</table>
		</td>
	</table>
</div>

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
