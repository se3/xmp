<?
header('Content-Type: text/html; charset=utf-8');
session_start();
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
//error_reporting(0);
//include "../chooselang.php";
//include '/tmp/lang.php';

$file = "/usr/local/etc/setup.php";
$fp = fopen($file, 'r');
$fileData = fread($fp, filesize($file));
fclose($fp);

$line = explode("\n", $fileData);
$i = 1;
while ($i <= 5) {
	$dataPair = explode('=', $line[$i]);
	if ($dataPair[0] == "Login" && $dataPair[1] == "true") {
			if ($_SESSION['loggedIn'] != 1) {
				   header("Location:../login_form.php");
					exit;
			}
	}
	$i++;
}
?>


<html>
<head>
<title>Remocon</title>
<!--link rel="stylesheet" type="text/css" href="dlf/styles.css" /-->

<script language="JavaScript">
function newwindow(w,h,webaddress){
	var viewimageWin = window.open(webaddress,"New_Window","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width="+w+",height="+h);
	viewimageWin.moveTo(screen.availWidth/2-(w/2),screen.availHeight/2-(h/2));
	window.resizeTo(w, h+80);
}
</script>

</head>
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu='return false' ondragstart='return false' bgcolor="black">

<center>
<table cellspacing="0" cellpadding="0" border="0" bgcolor="black">
<tr><td valign=top>
	<table cellspacing="0" cellpadding="0" border="0" valign=top>
	<tr height=23><td></td></tr>
	<tr>
		<td><input type="button" name="vertical"  value=" " style="background: url('vertical.png');background-color:Transparent; height:35px; width:35px; border:none; cursor:hand" onclick="newwindow(250, 680, 'index.php');"></td>
	</tr>
	<tr>
		<td><input type="button" name="horizontal"  value=" " style="background: url('horizontal.png');background-color:Transparent; height:35px; width:35px; border:none; cursor:hand" onclick="newwindow(550, 270, 'index1.php');"></td>
	</tr>
	</table>
</td>

<td>
	<form name="remocon" target='gframe' action="rc_action.php" method="post">
	<input type="submit" style="height:0px; width:0px; visibility:hidden" name="search"  value=" ">
	<table width=480 height=234 cellspacing="0" cellpadding="0" border="1" bordercolor="#808080" bgcolor="black">
	<tr><td>
		<center>
		<table cellspacing="0" cellpadding="0" border="0">
		<tr height=10><td></td></tr>
		<tr valign=top >
			<td align=center width="44" ><input type="submit" style="background: url('power.png');background-color:Transparent; height:41px; width:41px; border:none; cursor:hand" name="power"  value=" "></td>
			<td width=60 align=center>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td align=center>
				<input type="submit" class='btn_2' style="background: url('btn.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="subt"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">Sub-t/ID3</font></td></tr>
				</table>
			</td>
			<td width="44" align=center valign=middle>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" style="background: url('home.png');background-color:Transparent; height:32px; width:32px; border:none; cursor:hand" name="home"  value=" "></td></tr>
				<tr><td align=top><font face="arial" color="white" size="1">HOME</font></td></tr>
				</table>
			</td>

		</tr>
		<tr>
			<td width="44">
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('1.png');background-color:Transparent; height:28px; width:44px; border:none; cursor:hand" name="1"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">ADD</font></td></tr>
				</table>
			</td>
			<td align=center valign=top>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('2.png');background-color:Transparent; height:27px; width:48px; border:none; cursor:hand" name="2"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">EJECT</font></td></tr>
				</table>
			</td>
			<td width="44" align=right>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('3.png');background-color:Transparent; height:29px; width:43px; border:none; cursor:hand" name="3"  value=" "></td><tr>
				<tr><td align=center><font face="arial" color="white" size="1">DELETE</font></td></tr>
				</table>
			</td>
			
		</tr>
		<tr>
			<td width="44">
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('4.png');background-color:Transparent; height:29px; width:44px; border:none; cursor:hand" name="4"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">ZOOM</font></td></tr>
				</table>
			</td>
			<td align=center valign=top>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('5.png');background-color:Transparent; height:28px; width:48px; border:none; cursor:hand" name="5"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">GOTO</font></td></tr>
				</table>
			</td>
			<td width="44" align=right>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('6.png');background-color:Transparent; height:29px; width:43px; border:none; cursor:hand" name="6"  value=" "></td><tr>
				<tr><td align=center><font face="arial" color="white" size="1">MENU</font></td></tr>
				</table>
			</td>
			
		</tr>
		<tr>
			<td width="44">
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('7.png');background-color:Transparent; height:28px; width:44px; border:none; cursor:hand" name="7"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="red" size="1">SETUP</font></td></tr>
				</table>
			</td>
			<td align=center valign=top>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('8.png');background-color:Transparent; height:28px; width:48px; border:none; cursor:hand" name="8"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">FUNC</font></td></tr>
				</table>
			</td>
			<td width="44" align=right>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('9.png');background-color:Transparent; height:29px; width:43px; border:none; cursor:hand" name="9"  value=" "></td><tr>
				<tr><td align=center><font face="arial" color="red" size="1">TVOUT</font></td></tr>
				</table>
			</td>
			
		</tr>
		<tr>
			<td width="44">
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('info.png');background-color:Transparent; height:29px; width:44px; border:none; cursor:hand" name="info"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">INFO</font></td></tr>
				</table>
			</td>
			<td align=center valign=top>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('0.png');background-color:Transparent; height:27px; width:48px; border:none; cursor:hand" name="0"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">PREVIEW</font></td></tr>
				</table>
			</td>
			<td width="44" align=right>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('return.png');background-color:Transparent; height:28px; width:43px; border:none; cursor:hand" name="return"  value=" "></td><tr>
				<tr><td align=center><font face="arial" color="white" size="1">RETURN</font></td></tr>
				</table>
			</td>
			
		</tr>
		</table>
	</td>
	<td>
		<table cellspacing="0" cellpadding="0" border="0" align=center>
		<tr><td></td><td align=center><input type="submit" class='btn_2' style="background: url('navi_up.png');background-color:Transparent; height:32px; width:85px; border:none; cursor:hand" name="up"  value=" "></td></tr>

		<tr><td valign=middle align=center>
			<input type="submit" class='btn_2' style="background: url('navi_left.png');background-color:Transparent;		
			height:87px;width:34px; border:none; cursor:hand" name="left" value=" "></td>
		<td valign=middle align=center>
			<input type="submit" class='btn_2' valign=top style="background: url('enter.png');background-color:Transparent; height:53px; width:54px; border:none; cursor:hand; background-repeat: no-repeat; background-position: center center;" name="enter" value=" "></td>
		<td valign=middle align=center>
			<input type="submit" class='btn_2' style="background: url('navi_right.png');background-color:Transparent; height:87px; width:34px; border:none; cursor:hand" name="right" value=" "></td>
		</tr>

		<tr><td></td><td align=center><input type="submit" class='btn_2' style="background: url('navi_down.png');background-color:Transparent; height:33px; width:85px; border:none; cursor:hand" name="down" value=" "></td></tr>
		</table>

		<table cellspacing="0" cellpadding="0" border="0" width=160 align=center>
		<tr height=45>
			<td valign=top align=center width=40>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('pgup.png');background-color:Transparent; height:35px; width:35px; border:none; cursor:hand" name="pgup"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">PGUP</font></td></tr>
				</table>
			</td>
			<td valign=bottom align=center width=40><input type="submit" class='btn_2' style="background: url('play_pause.png');background-color:Transparent; height:35px; width:35px; border:none; cursor:hand" name="play_pause"  value=" "></td>
			<td valign=bottom align=center width=40><input type="submit" class='btn_2' style="background: url('stop.png');background-color:Transparent; height:35px; width:35px; border:none; cursor:hand" name="stop"  value=" "></td>
			<td valign=top align=center width=40>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('pgdn.png');background-color:Transparent; height:35px; width:35px; border:none; cursor:hand" name="pgdn"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">PGDN</font></td></tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
	<td>
		<table cellspacing="0" cellpadding="0" border="0" width=150 align=center>
		<tr height=15><td></td></tr>
		<tr height=40>
			<td width="50" valign=top align=center><input type="submit" class='btn_2' style="background: url('FB.png');background-color:Transparent; height:25px; width:37px; border:none; cursor:hand" name="FB"  value=" "></td>
			<td valign=top align=center><input type="submit" class='btn_2' style="background: url('FF.png');background-color:Transparent; height:25px; width:37px; border:none; cursor:hand" name="FF"  value=" "></td>
			<td width="50" align=center>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('vol_up.png');background-color:Transparent; height:25px; width:37px; border:none; cursor:hand" name="vol_up"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="red" size="1">VOL</font></td></tr>
				</table>
			</td>
		</tr>
		<tr height=40>
			<td width="50" align=center>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('btn.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="audio"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">AUDIO</font></td></tr>
				</table>
			</td>
			<td align=center>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('btn.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="a-b"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">A-B</font></td></tr>
				</table>
			</td>
			<td width="50" align=center valign=top><input type="submit" class='btn_2' style="background: url('vol_down.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="vol_down"  value=" "></td>
		</tr>
		<tr height=40>
			<td width="50" align=center>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td align=center>
				<input type="submit" class='btn_2' style="background: url('shufl.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="shufl"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">SHUFFLE</font></td></tr>
				</table>
			</td>
			<td align=center>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td align=center>
				<input type="submit" class='btn_2' style="background: url('repeat.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="repeat"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">REPEAT</font></td></tr>
				</table>
			</td>
			<td width="50" align=center>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('mute.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="mute"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">MUTE</font></td></tr>
				</table>
			</td>
		</tr>
		<tr height=40>
			<td width="50" valign=top align=center>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td align=center>
				<input type="submit" class='btn_2' style="background: url('btn.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="subtitle"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">SUBTITLE</font></td></tr>
				</table>
			</td>
			<td align=center colspan=2>
				<table cellspacing="0" cellpadding="0" border="0"><tr><td>
				<input type="submit" class='btn_2' style="background: url('sync_left.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="sync_left"  value=" ">&nbsp&nbsp
				<input type="submit" class='btn_2' style="background: url('sync_right.png');background-color:Transparent; height:24px; width:37px; border:none; cursor:hand" name="sync_right"  value=" "></td></tr>
				<tr><td align=center><font face="arial" color="white" size="1">- &nbsp&nbsp SYNC &nbsp&nbsp +</font></td></tr>
				</table>
			</td>
		</tr>
		</table>
		
		<table cellspacing="0" cellpadding="0" border="0" width=150 align=center>
		<tr height=40>
			<td width="35"><input type="text" name="command" size="14" value=" "></td>
			<td align=center><input type="submit" class='btn_2' name="search"  value="Go"></td>

		</tr>
		</table>
		</center>

	</td></tr>
	</table>
	</form>
</td></tr>
</table>
</center>

<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
<div id="loadDiv" name="loadDiv" style="position:absolute; visibility:hidden; left:30;top:120;width:200; height:100; z-index:1;">
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
</body>
</html>
