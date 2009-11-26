<?
error_reporting(0);
session_start();
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
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
				   //header("Location:../login_form.php");
				   echo "<script>document.location.href='../login_form.php'</script>";
					exit;
			}
	}
	$i++;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Xtreamer</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="statics/styles/general.css" rel="stylesheet" type="text/css" />
    <script src="statics/scripts/panel_funcs.js"></script>    
    <script src="statics/scripts/global.js"></script> 
</head>
<body>
    <img id="progressImg" src="statics/images/wifi_icon.png" />
    <map name="subPage">        
        <area shape="rect" coords="112,1,2,63" title="Main" href="#" onclick="goTo('fShowMainControl')">
        <area shape="rect" coords="317,2,205,65" title="Now playing" href="#" onclick="goTo('fShowNowPlaying')">                        
        <area shape="rect" coords="199,3,117,112" title="Main" href="#" onclick="goTo('fShowMainControl')">
        <area shape="rect" coords="43,70,0,113" title="All" href="#" onclick="goTo('fAll')">
        <area shape="rect" coords="49,70,105,112" title="Movies" href="#" onclick="goTo('fMovies')">
        <area shape="rect" coords="210,72,262,112" title="Music" href="#" onclick="goTo('fMusic')">
        <area shape="rect" coords="268,71,319,112" title="Pictures" href="#" onclick="goTo('fPictures')">
        <area shape="rect" coords="0,118,76,180" title="Mute" href="#" onclick="goTo('fMute')">
        <area shape="rect" coords="75,182,1,231" title="A-B" href="#" onclick="goTo('fAB')">
        <area shape="rect" coords="75,233,1,295" title="Audio" href="#" onclick="goTo('fAudio')">
        <area shape="rect" coords="254,119,317,178" title="Shuffle" href="#" onclick="goTo('fShuffle')">
        <area shape="rect" coords="316,181,254,232" title="Repeat" href="#" onclick="goTo('fRepeat')">
        <area shape="rect" coords="316,236,254,288" title="Sync +" href="#" onclick="goTo('fSyncplus')">
        <area shape="rect" coords="317,291,255,343" title="Sync -" href="#" onclick="goTo('fSyncminus')">
        <area shape="rect" coords="133,121,80,175" title="1-Add" href="#" onclick="goTo('fOneAdd')">
        <area shape="rect" coords="186,122,135,176" title="2-Eject" href="#" onclick="goTo('fTwoEject')">
        <area shape="rect" coords="240,121,190,177" title="3-Delete" href="#" onclick="goTo('fThreeDelete')">
        <area shape="rect" coords="132,178,79,231" title="4-Zoom" href="#" onclick="goTo('fFourZoom')">
        <area shape="rect" coords="186,178,135,231" title="5-GoTo" href="#" onclick="goTo('fFiveGoto')">
        <area shape="rect" coords="239,179,188,232" title="6-Menu" href="#" onclick="goTo('fSixMenu')">
        <area shape="rect" coords="239,235,188,284" title="9-TvOut" href="#" onclick="goTo('fNineTvout')">
        <area shape="rect" coords="184,234,135,285" title="8-Func" href="#" onclick="goTo('fEightFunc')">
        <area shape="rect" coords="130,233,80,291" title="Setup" href="#" onclick="goTo('fSevenSetup')">
        <area shape="rect" coords="247,288,183,357" title="0-Preview" href="#" onclick="goTo('fZeroPreview')">
        <area shape="rect" coords="45,297,1,355" title="Search" href="#" onclick="goTo('fSearch')">        
    </map>
    <img src="statics/images/sub.png" border="0" usemap="#subPage"/> 
    
    <div id="searchbox">
        <input id="searchtext" type="text" maxlength="20" size="14" />
    </div>
<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
</body>
</html>
