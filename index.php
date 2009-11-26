<?
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';


//if upload temp directory not exists create it.
$tempfile = "/tmp/hdd/volumes/HDD1/.cached";
if (!file_exists($tempfile)) {
	echo `mkdir /tmp/hdd/volumes/HDD1/.cached`;
}
//remove all temporary files
	shell_exec('rm -rf /tmp/hdd/volumes/HDD1/.cached/*');
?>


<html>
<head>
<title><? echo $STR_Title;?></title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

<script language="JavaScript">
function newwindow(w,h,webaddress){
	var viewimageWin = window.open(webaddress,"New_Window","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width="+w+",height="+h);
	viewimageWin.moveTo(screen.availWidth/2-(w/2),screen.availHeight/2-(h/2));
}

<!--
	var jsRes = "PC1024";
	if (window.screen.width >= 1024)
		jsRes = "PC1024";
	if (jsRes != "PC1024")
		window.location="/?bRes=" + jsRes + "&rU=%2Fapp%2Fplayer%2Fwelcome%2Faction%2Fwelcome.php";
-->
</script>
<link rel="stylesheet" type="text/css" href="dlf/styles.css" />
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" border="0" bgcolor="black" oncontextmenu="return false;">
<center>
<table cellspacing="0" cellpadding="0" border="0" align="center" height="300" width=996>
	<tr>
		<td >
			<table cellspacing="0" cellpadding="0" border="0">
				<tr><td width=5%></td>
					<td height="180" width="62%" align="left" valign="middle"><Img src="dlf/main_title.png" width="356" height="91"></td>
					<td align="right"><Img src="dlf/logo_black.png" width="300" height="72"></td>
				</tr>
			</table>
		</td>
	</tr>


	<tr align="middle">
		<td colspan="500"><table style="color:#FFFFFF; font-family:arial; font-size:9pt" align="center" width="756" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="189"><div id="movie" align="center">Movies, TV shows &amp; Clips</div></td>
			<td width="189"><div id="music" align="center">Music &amp; Audio CD's</div></td>
			<td width="189"><div id="photo" align="center">Pictures &amp; Images</div></td>
			<td width="189"><div id="all" align="center">All</div></td>
		  </tr>
		</table></td>
	</tr>
		
	<tr align="middle">
		<td colspan="500">
		  <table bgcolor="#000000" cellspacing="0" cellpadding="0" border="0" align="center" width=100%>
		    <tr><td>
			<table cellspacing="0" cellpadding="0" border="0" align="center" width=760><tr>
		        <td ><a href="videolist.php" tvid="1"></a>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>	
					<table cellspacing="0" cellpadding="0" border="0"><tr><td width=""><a onMouseOver="document.getElementById('movie').style.color='#FF0000';" onMouseOut="document.getElementById('movie').style.color='#FFFFFF';" href="videolist.php">
					<img src="dlf/icon_video.jpg" width="189" height="94" border="0"></a></td></tr>
					</table>
				</td></tr></table>
				</td>

				<td width="6"></td>
				<td><a href="audiolist.php" tvid="2"></a><table cellspacing="0" cellpadding="0" border="0"><tr><td>
					<table cellspacing="0" cellpadding="0" border="0"><tr><td width=""><a onMouseOver="document.getElementById('music').style.color='#ff0000';" onMouseOut="document.getElementById('music').style.color='#FFFFFF';" href="audiolist.php">
					<img src="dlf/icon_music.jpg" width="189" height="94" border="0"></a></td></tr>
					</table>
				</td></tr></table>
				</td>

				<td width="6"></td>
				<td><a href="imagelist.php" tvid="3"></a><table cellspacing="0" cellpadding="0" border="0"><tr><td>
					<table cellspacing="0" cellpadding="0" border="0"><tr><td width=""><a onMouseOver="document.getElementById('photo').style.color='#ff0000';" onMouseOut="document.getElementById('photo').style.color='#FFFFFF';" href="imagelist.php">
					<img src="dlf/icon_photo.jpg" width="189" height="94" border="0"></a></td></tr>
					</table>
				</td></tr></table>
				</td>
				
				<td width="6"></td>
				<td><a href="otherlist.php" tvid="4"></a><table cellspacing="0" cellpadding="0" border="0"><tr><td>
					<table cellspacing="0" cellpadding="0" border="0"><tr><td width=""><a onMouseOver="document.getElementById('all').style.color='#ff0000';" onMouseOut="document.getElementById('all').style.color='#FFFFFF';" href="otherlist.php">
					<img src="dlf/icon_other.jpg" width="189" height="94" border="0"></a></td></tr>
					</table>
				</td></tr></table>
				</td>

			  </td></tr>
			  </table>	
				
			<td></tr>
			</table>
		</td>
	</tr>

	<tr>

			<td width="50%" align="right" valign="top"><Img src="dlf/pvr_img.png" width="337" height="250"></td>
		
	</tr>
	
</table>
</center>


<center>
<table width="700"  border="0" cellspacing="0" cellpadding="0">
  <tr height=4><td></td></tr>	
  <tr>
    <td align="right" valign="top" style="border-top:solid 1px; border-top-color:#FFFFFF"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr><td width=20></td>
        <td width=440 valign="middle"><font face="Arial" color="#748e94" size="2"><a href="index.php"><?echo $STR_Home;?></a> | <a href="register_form.php"><?echo $STR_Setup;?></a> | <a href="#" onclick="newwindow(318, 356, 'rc');";>RC</a> | <a href="#" onclick="newwindow(250, 680, 'rc2');";>RC2</a> | <a href="logout.php"><?echo $STR_Logout;?></a></font></td>

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
