<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';
$file1 = "http://".$_SERVER["SERVER_NAME"].'/'. "media" . $_GET["dir"] .'/'. $_GET["file"];
$file = str_replace(" ", "%20", $file1);
//echo $file;
//if (!file_exists($_GET["file"])) {
//symlink($_GET["dir"].'/'.$_GET["file"],$_GET["file"]);
//}
?>

<HTML>
<TITLE><?echo $_GET["file"];?></TITLE>
<!--meta http-equiv="Content-Type" content="text/html; charset=utf-8"-->
<link rel="stylesheet" type="text/css" href="dlf/styles.css" />
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu="return false;">


<TABLE ID="Table1" border="0" cellspacing="0" cellpadding="0" align="center">
<TR><TD colspan="2">
<!--
Insert VideoLAN.VLCPlugin.2 activex control
codebase="http://downloads.videolan.org/pub/videolan/vlc/0.8.6h/win32/vlc-0.8.6h-win32.exe"
codebase="http://61.39.153.34:81/Mvix media player"
codebase="http://live.mvix.net/mvix_vlc/Mvix_media_player.cab"
-->
<OBJECT classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921"

	width="100%"
        height="480"
        id="vlc"
        events="True" VIEWASTEXT>
<param name="Src" value="<?=$file?>" />
<param name="ShowDisplay" value="True" />
<param name="AutoLoop" value="False" />
<param name="AutoPlay" value="False" />

<param name="Volume" value="50" />
<param name="StartTime" value="0" />
</OBJECT>
</TD></TR>
<TR><TD>
<!--
Insert MSComctlLib.Slider.2 activex control
-->
<OBJECT classid="clsid:F08DF954-8592-11D1-B16A-00C0F0283628"
        width="540"
        height="20"
        id="slider"
        events="True">
<param name="TickStyle" value="3" />
<param name="Min" value="0" />
<param name="Max" value="100%" />
<param name="Value" value="0" />
<param name="Enabled" value="True" />
<!---
for Mozila Firefox
--->
<embed type="application/x-vlc-plugin"
         pluginspage="http://downloads.videolan.org/pub/videolan/vlc/0.8.6h/win32/vlc-0.8.6h-win32.exe" version="VideoLAN.VLCPlugin.2"
         name="video1"
         autoplay="yes" loop="no" width="700" height="535"
         target="<?=$file?>" />
<br />

</OBJECT>
</TD><TD width="19%">
<font color="white">
<DIV id="INfo" style="text-align:center">-:--:--/-:--:--</DIV>
</TD></TR>
<TR><TD height="5" colspan="2"></TD></TR>
<TR><TD colspan="2">
<INPUT type=button class='btn_2' id="PlayOrPause" value="<?echo $STR_Play;?>" onClick='doPlayOrPause();' NAME="PlayOrPause">
<INPUT type=button class='btn_2' value="<?echo $STR_StopPlaying;?>" onClick='doStop();' ID="Button1" NAME="Button1">
&nbsp;
<INPUT type=button class='btn_2' value=" << " onClick='doPlaySlower();' ID="Button2" NAME="Button2">
<font color="white">
<SPAN id="playSlowFast" style="text-align: center">x1</SPAN>
<INPUT type=button class='btn_2' value=" >> " onClick='doPlayFaster();' ID="Button3" NAME="Button3">
&nbsp;
<INPUT type=button class='btn_2' id="VersionBut" value="<?echo $STR_Version;?>" onClick='alert(document.getElementById("vlc").VersionInfo);' NAME="VersionBut">
<font color="white">
<SPAN style="text-align:center" ><?echo $STR_Volume;?></SPAN>
<INPUT type=button class='btn_2' value=" - " onClick='updateVolume1(-10)' ID="Button6" NAME="Button6">
<SPAN id="volumeTextField" style="text-align: center">--</SPAN>
<INPUT type=button class='btn_2' value=" + " onClick='updateVolume(+10)' ID="Button7" NAME="Button7">

<INPUT type=button class='btn_2' value="<?echo $STR_Mute;?>" onClick='document.getElementById("vlc").audio.toggleMute();' ID="Button8" NAME="Button8">
</TD>
</TR>
</TABLE>

<!--script type="text/javascript">
//if(document.getElementById("vlc").VersionInfo== null)
//{
//window.open('http://downloads.videolan.org/pub/videolan/vlc/0.8.6h/win32/vlc-0.8.6h-win32.exe','MyVideo','height=545,width=700,left=350,top=200');
//}
</SCRIPT-->

<SCRIPT language="javascript">
<!--
//if(document.getElementById("vlc").VersionInfo== null)
//{
//  window.open('http://downloads.videolan.org/pub/videolan/vlc/0.8.6h/win32/vlc-0.8.6h-win32.exe','MyVideo','height=545,width=700,left=350,top=200');
//}

var prevState = 0;
var monitorTimerId = 0;
var sliderScrolling = false;
var ignoreSliderChange = false;


   if(document.getElementById("vlc").VersionInfo==null)
    {
		if(confirm('You need to setup VLC player. Do you want to continue?')){
			//top.location ="http://downloads.videolan.org/pub/videolan/vlc/0.8.6h/win32/vlc-0.8.6h-win32.exe";
			//window.open('vlcsetup.php','vlc','height=500,width=550,left=100,top=100, toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no');
			this.location.href="vlcsetup.php";
		}
    }

//function isInstalledActiveX() {
//        var isInstall = false;
//        try {
//            var obj = new ActiveXObject("VideoLAN.VLCPlugin.2");

//            if(obj)
//                isInstall = true;
//            else
//                isInstall = false;
 //       } catch(e) {
//            isInstall = false;
//        }              
//      
//        if(isInstall)
//            alert("ActiveX Control installed");
 //       else
 //           alert("ActiveX Control not installed");
 //   }  


function updateVolume(deltaVol)
{
    var vlc = document.getElementById("vlc");
	if (vlc.audio.volume < 100){
	    vlc.audio.volume += deltaVol;
		document.getElementById("volumeTextField").innerHTML = vlc.audio.volume+"%";
	}
};

function updateVolume1(deltaVol)
{
    var vlc = document.getElementById("vlc");
	if (vlc.audio.volume > 0){
	    vlc.audio.volume += deltaVol;
		document.getElementById("volumeTextField").innerHTML = vlc.audio.volume+"%";
	}
};
function formatTime(timeVal)
{
    var timeHour = Math.round(timeVal / 1000);
    var timeSec = timeHour % 60;
    if( timeSec < 10 )
	timeSec = '0'+timeSec;
    timeHour = (timeHour - timeSec)/60;
    var timeMin = timeHour % 60;
    if( timeMin < 10 )
	timeMin = '0'+timeMin;
    timeHour = (timeHour - timeMin)/60;
    if( timeHour > 0 )
	return timeHour+":"+timeMin+":"+timeSec;
    else
	return timeMin+":"+timeSec;
};
function monitor()
{
    var vlc = document.getElementById("vlc");
    var newState = vlc.input.state;
    if( prevState != newState )
    {
	if( newState == 0 )
	{
	    // current media has stopped 
	    onStop();
	}
	else if( newState == 1 )
	{
	    // current media is openning/connecting
	    onOpen();
	}
	else if( newState == 2 )
	{
	    // current media is buffering data
	    onBuffer();
	}
	else if( newState == 3 )
	{
	    // current media is now playing
	    onPlay();
	}
	else if( vlc.input.state == 4 )
	{
	    // current media is now paused
	    onPause();
	}
	prevState = newState;
    }
    else if( newState == 3 )
    {
	// current media is playing
	onPlaying();
    }
    monitorTimerId = setTimeout("monitor()", 1000);
};

/* actions */

function doGo(targetURL)
{
    var vlc = document.getElementById("vlc");
    var options = new Array(":vout-filter=deinterlace", ":deinterlace-mode=linear");
    vlc.playlist.clear();
    //vlc.playlist.add(targetURL, null, options);
    vlc.playlist.add(targetURL);
    vlc.playlist.play();
    if( monitorTimerId == 0 )
    {
	monitor();
    }
};
function doPlayOrPause()
{
    var vlc = document.getElementById("vlc");
    
    if(document.getElementById("vlc").VersionInfo!="0.8.6f Janus")
    {
     alert("<?echo $STR_VersionError;?>");
    }
    if( vlc.playlist.isPlaying )
    {
	vlc.playlist.togglePause();
    }
    else
    {
	vlc.playlist.play();
	if( monitorTimerId == 0 )
	{
	    monitor();
	}
    }
};
function doStop()
{
    document.getElementById("vlc").playlist.stop();
    document.getElementById("playSlowFast").innerHTML = "x1";
    if( monitorTimerId != 0 )
    {
	clearTimeout(monitorTimerId);
	monitorTimerId = 0;
    }
    onStop();
};
function doPlaySlower()
{
    var vlc = document.getElementById("vlc");
    if(vlc.input.rate>0.125)
    {
       vlc.input.rate = vlc.input.rate / 2;
    }
      document.getElementById("playSlowFast").innerHTML = "x"+vlc.input.rate;
};
function doPlayFaster()
{
    var vlc = document.getElementById("vlc");
    if(vlc.input.rate<8)
    {
       vlc.input.rate = vlc.input.rate * 2;
    }
      document.getElementById("playSlowFast").innerHTML = "x"+vlc.input.rate;
};

/* events */

function onOpen()
{
    document.getElementById("info").innerHTML = "<?echo $STR_Opening;?>";
    document.getElementById("PlayOrPause").value = "<?echo $STR_Pause;?>";
};
function onBuffer()
{
    document.getElementById("info").innerHTML = "<?echo $STR_Buffering;?>";
    document.getElementById("PlayOrPause").value = "<?echo $STR_Pause;?>";
};
function onPlay()
{
    onPlaying();
    document.getElementById("PlayOrPause").value = "<?echo $STR_Pause;?>";
};
var liveFeedText = new Array("Live", "((Live))", "(( Live ))", "((  Live  ))");
var liveFeedRoll = 0;
function onPlaying()
{
    if( ! sliderScrolling )
    {
	var slider = document.getElementById("slider");
	if( vlc.input.length > 0 )
	{
	    // seekable media
	    slider.Enabled = true;
	    slider.Max = slider.width;
	    ignoreSliderChange = true;
	    slider.Value = vlc.input.position*slider.width;
	    ignoreSliderChange = false;
	    document.getElementById("info").innerHTML = formatTime(vlc.input.time)+"/"+formatTime(vlc.input.length);
	}
	else
	{
	    // non-seekable "live" media
	    if( slider.Enabled )
	    {
		slider.Value = slider.Min;
		slider.Enabled = false;
	    }
            liveFeedRoll = liveFeedRoll & 3;
            document.getElementById("info").innerHTML = liveFeedText[liveFeedRoll++];
	}
    }
};
function onPause()
{
    document.getElementById("PlayOrPause").value = "<?echo $STR_Play;?>";
};
function onStop()
{
    if( slider.Enabled )
    {
        slider.Value = slider.Min;
        slider.Enabled = false;
    }
    document.getElementById("info").innerHTML = "-:--:--/-:--:--";
    document.getElementById("PlayOrPause").value = "<?echo $STR_Play;?>";
};
//-->
</SCRIPT>
<SCRIPT language="JScript">
<!--

document.onreadystatechange=onVLCStateChange;
function onVLCStateChange()
{
    if( document.readyState == 'complete' )
    {
        updateVolume(0);
    }
};
function slider::Scroll()
{
    var vlc = document.getElementById("vlc");
    var slider = document.getElementById("slider");
    var oldPos = vlc.input.position;
    var newPos = slider.Value/slider.width;
    if( (vlc.input.state == 3) && (oldPos != newPos) )
    {
        vlc.input.position = newPos;
	slider.Text = formatTime(vlc.input.time);
	document.getElementById("info").innerHTML = slider.Text+"/"+formatTime(vlc.input.length);
    }
    sliderScrolling = true;
};
function slider::Change()
{
    var vlc = document.getElementById("vlc");
    var slider = document.getElementById("slider");
    var oldPos = vlc.input.position;
    var newPos = slider.Value/slider.width;
    if( sliderScrolling )
    {
        sliderScrolling = false;
    }
    else if( !ignoreSliderChange && (vlc.input.state == 3) && (oldPos != newPos) )
    {
        vlc.input.position = newPos;
    }
};
//-->
</SCRIPT>
</BODY>
</HTML>

