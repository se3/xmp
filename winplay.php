<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';
$file = "http://".$_SERVER["SERVER_NAME"].'/'. "media" . $_GET["dir"] .'/'.stripslashes($_GET["file"]);
//if (!file_exists($_GET["file"])) {
//symlink($_GET["dir"].'/'.$_GET["file"],$_GET["file"]);
//}
?>

<HTML>

 <HEAD>

             <title><? echo $_GET["file"];?></title>

                <meta http-equiv="content-type" content="text/html; charset=utf-8" />

             <style type="text/css">

                           body { margin:0px; padding:0px; }

             </style>

 </HEAD>

 <BODY bgcolor="#7B68EE">


<!--embed src="<?=$file?>" CONTROLS="imagewindow" CONSOLE="VIDEO" width="500" height="500" autostArt="TRUE"
type="application/x-oleobject" showstatusbar=true>
</embed-->



<object id="MediaPlayer1" width=600 height=600
classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95"
codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"
standby="Loading Microsoft® Windows® Media Player components..."
type="application/x-oleobject" align="middle">
<param name="FileName" value="<?=$file?>">
<param name="AutoStart" value="True">
<param name="ShowStatusBar" value="True">
<param name="DefaultFrame" value="mainFrame">


<embed type="application/x-mplayer2"
pluginspage = "http://www.microsoft.com/Windows/MediaPlayer/"
src="<?=$file?>" align="middle"
width=600
height=600
defaultframe="rightFrame"
showstatusbar=true>
</embed>


<PARAM NAME="AutoStart" VALUE="1">

<PARAM NAME="Balance" VALUE="100">

<PARAM NAME="Enabled" value="1">

<PARAM NAME="EnableContextMenu" value="1">

<PARAM NAME="EnableMessage" value="1">

<PARAM NAME="EnableSubtitle" value="1">

<PARAM NAME="LogoUrl" VALUE="">

<PARAM NAME="Mute" value="0">

<PARAM NAME="Rate" value="1">

<PARAM NAME="RenderMode" value="1">

<PARAM NAME="StretchToFit" value="0">

<PARAM NAME="SpeakerMode" value="2">

<PARAM NAME="UiMode" value="-mode:normal">

<!--PARAM NAME="URL" VALUE="<?=$file?>"-->

<PARAM NAME="Volume" value="100">

</OBJECT>

 </BODY>

</HTML>

