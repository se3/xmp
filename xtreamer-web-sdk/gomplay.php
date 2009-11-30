<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';
$file = "http://".$_SERVER["SERVER_NAME"].'/'. "media" . $_GET["dir"] .'/'.$_GET["file"]; 
#if (!file_exists($_GET["file"])) {
#symlink($_GET["dir"].'/'.$_GET["file"],$_GET["file"]);
#}
?>
<HTML>

 <HEAD>

             <title><? echo $_GET["file"];?></title>

                <meta http-equiv="content-type" content="text/html; charset=euc-kr"/>

             <style type="text/css">

                           body { margin:0px; padding:0px; }

             </style>

 </HEAD>

 <BODY bgcolor="#7B68EE">

<OBJECT ID="GomX1" WIDTH=600 HEIGHT=600 CLASSID="CLSID:632CC9D6-5602-4854-AFD2-6EFC59177DE5" CODEBASE="http://app.gomlab.com/eng/gom/GOMPLAYERENSETUP.EXE">

<!--OBJECT ID="GomX1" WIDTH=600 HEIGHT=400 CLASSID="CLSID:632CC9D6-5602-4854-AFD2-6EFC59177DE5" CODEBASE="http://app.ipop.co.kr/gom/GOMPLAYERSETUP.EXE"-->

<PARAM NAME="AutoStart" VALUE="1">

<PARAM NAME="Balance" VALUE="50">

<PARAM NAME="Enabled" value="1">

<PARAM NAME="EnableContextMenu" value="1">

<PARAM NAME="EnableMessage" value="1">

<PARAM NAME="EnableSubtitle" value="1">

<PARAM NAME="LogoUrl" VALUE="http://gom.ipop.co.kr/files/logo/MAE2-0.jpg">

<PARAM NAME="Mute" value="0">

<PARAM NAME="Rate" value="1">

<PARAM NAME="RenderMode" value="1">

<PARAM NAME="StretchToFit" value="0">

<PARAM NAME="SpeakerMode" value="2">

<PARAM NAME="UiMode" value="-mode:normal">

<PARAM NAME="Url" VALUE="<?=$file?>">

<PARAM name="SubUrl" value="">

<PARAM NAME="Volume" value="100">

</OBJECT> 

 </BODY>

</HTML>
