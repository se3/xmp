<?php

session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';

//$root = "/tmp/hdd/volumes"; 
$root = "/tmp/usbmounts";

$filetypes = array (
                'mpg' => 'video.gif',
                'mkv' => 'video.gif',
                'mpeg' => 'video.gif',
                'mov' => 'video.gif',
                'wmv' => 'video.gif',
                'avi' => 'video.gif',
);


if ((substr($_GET['dir'],0,2) != '/.') and (substr($_GET['dir'],0,1) != '.') and ($_GET['dir'] != '')) {
    $mydir =  $root . $_GET['dir'];
    $mediapath =  stripslashes($_GET['dir']);} 
else {
    $mydir = $root;
}

$uplink = substr_replace($_GET['dir'],'',strlen($_GET['dir'])-strlen(strrchr( $_GET['dir'],'/')));

$files = myscan($mydir);
sort($files);

function myscan($dir) {
    $arrfiles = array();
    $arrfiles = opendir(stripslashes($dir));
    while (false !== ($filename = readdir($arrfiles))) {
           $files[] = $filename;
    }   

    return $files;
}
$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);
?>


<HTML>
<head>

<script language=javascript>
function goto(form){
	var index=form.File_Manager.selectedIndex
	if (form.File_Manager.options[index].value != "") {
		if (form.File_Manager.options[index].value == "creatfolder.php?dir=<?echo $mediapath;?>") {
			window.open(form.File_Manager.options[index].value,'FileManager','height=200,width=550,left=150,top=200');
		}else if (form.File_Manager.options[index].value == "copy.php?dir=<?echo $mediapath;?>") {
			window.open(form.File_Manager.options[index].value,'FileManager','height=635,width=987,left=50,top=50');
		}else{
			window.open(form.File_Manager.options[index].value,'FileManager','height=630,width=550,left=220,top=50');

		}
	}
}

function newwindow(w,h,webaddress){
	var viewimageWin = window.open(webaddress,"New_Window","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width="+w+",height="+h);
	viewimageWin.moveTo(screen.availWidth/2-(w/2),screen.availHeight/2-(h/2));
}

/*function MM_controlSound(x, _sndObj, sndFile) { //v3.0
var i, method = "", sndObj = eval(_sndObj);
if (sndObj != null) {
if (navigator.appName == 'Netscape') method = "play";
else {
if (window.MM_WMP == null) {
window.MM_WMP = false;
for(i in sndObj) if (i == "ActiveMovie") {
window.MM_WMP = true; break;
} }
if (window.MM_WMP) method = "play";
else if (sndObj.FileName) method = "run";
} }
if (method) eval(_sndObj+"."+method+"()");
else window.location = sndFile;
}*/
</script>


<!--embed name='CS1022563046202' src='dlf/click.wav' loop=false
autostart=false MASTERSOUND hidden=true width=0 height=0>
</embed-->


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?echo $STR_Title;?></title>
    <link rel="stylesheet" type="text/css" href="dlf/styles.css" />
</head>
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu="return false;">

    <div id="container">
	<center>
	<table width="996" cellspacing="0" cellpadding="0" border="0"> 
		<!--tr>
			<td width="940" align="right" valign="middle"><font face="Arial" color="#748e94" size="1"><a href="logout.php"><font face="Arial" color="#748e94" size="1"><?echo $STR_Logout;?></a> | <a href="register_form.php"><font face="Arial" color="#748e94" size="1"><?echo $STR_Setup;?></a> </font></td>
		</tr-->

		<tr>
			<td align="center"><table height="94" background="dlf/top_menu.jpg" width="996" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="189"><img src="dlf/icon_video.jpg" width="189" height="94" /><td>
					<td valign="bottom">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">

						<tr>
							<td width="5" valign="middle">&nbsp;</td>
							<td colspan="9" valign="middle"><font face="arial" color="#ff0000"><h2><?echo $STR_Video_title;?></h2></font></td>
						</tr>

					

						<tr>
							<td width="5" valign="bottom">&nbsp;</td>
							<!--td height="30" width="40" valign="bottom"><font face="arial" color="white" size="2">
								<a href="index.php"><?echo $STR_Home;?></a></td-->
							<td height="30" width="40" valign="bottom">
								<a href="videolist.php?dir=<?echo $mediapath;?>">
								<font face="arial" color="#ff0000" size="2"><u><?echo $STR_Video;?></u></font></a></td>
							<td height="30" width="40" valign="bottom"><font face="arial" color="white" size="2">
								<a href="audiolist.php?dir=<?echo $mediapath;?>"><?echo $STR_Audio;?></a></td>
							<td height="30" width="40" valign="bottom"><font face="arial" color="white" size="2">
								<a href ="imagelist.php?dir=<?echo $mediapath;?>"><?echo $STR_Photo;?></a></td>
							<td height="30" width="65" valign="bottom"><font face="arial" color="white" size="2">
								<a href="otherlist.php?dir=<?echo $mediapath;?>"><?echo $STR_All;?></a>&nbsp&nbsp|

							<td height="30" width="40" valign="bottom">
								<?
								 //Mylist
								 //if (strncmp($mediapath, '/Media_Library', 14)){
									echo"<input type='button' class='btn_1' onMouseOver='this.style.color= \"#ff0000\"' onMouseOut='this.style.color=\"#FFFFFF\"' name='add' value='".$STR_Mylist."'	onclick=\"newwindow(987, 675, 'm3uVideo.php');\";>";
								 //}
							echo '</td><td height="30" width="40" valign="bottom">';
								 //Upload
								 //if (($mediapath != '') and (strncmp($mediapath, '/Media_Library', 14))){
								if ($mediapath != ''){
									echo"<input type='button' class='btn_1' onMouseOver='this.style.color= \"#ff0000\"' onMouseOut='this.style.color=\"#FFFFFF\"' name='upload' value='".$STR_Upload."' onclick=\"newwindow(467, 600, 'upload.php?dir=$mediapath');\";>";
								 }
							echo '</td><td height="30" width="40" valign="bottom">';
								 //Filemanager
								 //if (($mediapath != '') and (strncmp($mediapath, '/Media_Library', 14))){ 
								 if ($mediapath != ''){ ?>
									<FORM NAME="FileManager">
									<select name="File_Manager" class="listbox" ONCHANGE="goto(this.form)" >
										<option value=""><?echo $STR_Filemanager;?></option>
										<option value="creatfolder.php?dir=<?echo $mediapath;?>"><?echo $STR_NewFolder;?></option>
										<option value="rename.php?dir=<?echo $mediapath;?>"><?echo $STR_Rename;?></option>
										<option value="copy.php?dir=<?echo $mediapath;?>"><?echo $STR_CopyMove;?></option>
										<option value="delete.php?dir=<?echo $mediapath;?>"><?echo $STR_Delete;?></option>
									</select>
									</FORM>
								<?
								  }

								?>
								
							</font></td>
						</tr>
						</table>
					</td>


					<td width="300" valign="bottom"><a href="index.php"><img src="dlf/mvix_logo.png" width="300" height="72"></td>
				
				</tr></table>
			</td>
	   </tr>
	
		<tr height="12"><td></td></tr>


		<tr>
		<td height=100% align='center' valign='bottom'>

           <div id="listingcontainer">
			<table><tr height=12><td></td></tr></table>
            <div id="listing">
                <?
echo "<div>";
if(!$_GET["dir"]==''){
echo '<table width="846" height="27" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'" style="border-bottom:1px solid #000000;"><tr><td>';
echo "<table><tr><td><img src='dlf/dirup.png' align='center'>";
echo "<td colspan='250'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $uplink ."'>" . $STR_ParentDirectory . "</a></td></tr></table>";
echo "</td></tr></table>";
}

$mydir = str_replace("(", "\(", $mydir);
$mydir = str_replace(")", "\)", $mydir);

$command = 'cd ' .str_replace(" ", "\ ", $mydir).';ls -alh > /tmp/aaa' ;
shell_exec($command);


$file1 = "/tmp/aaa";
$fp1 = fopen($file1, 'r');
//$fileData1 = fread($fp1, filesize($file1));

$i=0;

while (!feof($fp1)) {
    $line1[$i++] = fgets($fp1, 4096);
}
fclose($fp1);
//$line1 = preg_split("/\n/", $fileData1);


for ($x=0; $x<($i-1); $x++) {
	if (($files[$x] != '.') and ($files[$x] != "..") and ($files[$x] != "Recycled") and ($files[$x] != "System Volume Information") and (substr($files[$x],0,1) != ".") and ($files[$x] != "lost+found")){
		//echo "<div>";
        //if(is_dir($mydir . "/" . $files[$x])) {
		 // $path = $mydir . "/" . $files[$x];
		 //if(substr(exec("ls -dl '$path'"),0,1) == 'd'){

		if (substr($line1[$x],0,1) == 'd'){
			$files1[$x] = $files[$x];
			if ($aaa!= ""){
				$files1[$x] = str_replace("sda", "HDD", $files1[$x]);
				$files1[$x] = str_replace("sdb1", "USB1", $files1[$x]);
				$files1[$x] = str_replace("sdc1", "USB2", $files1[$x]);
				$files1[$x] = str_replace("sdd1", "USB3", $files1[$x]);
				$files1[$x] = str_replace("sdb", "USB", $files1[$x]);
				$files1[$x] = str_replace("sdc", "USB", $files1[$x]);
			}else{
				$files1[$x] = str_replace("sda1", "USB1", $files1[$x]);
				$files1[$x] = str_replace("sdb1", "USB2", $files1[$x]);
				$files1[$x] = str_replace("sdc1", "USB3", $files1[$x]);
				$files1[$x] = str_replace("sdd1", "USB4", $files1[$x]);
				$files1[$x] = str_replace("sdb", "USB", $files1[$x]);
				$files1[$x] = str_replace("sdc", "USB", $files1[$x]);
			}

			//echo '<table width="846" height="3" cellspacing="0" cellpadding="0" border="0" onMouseOver="MM_controlSound(\'play\',\'document.CS1022563046202\',\'dlf/click.wav\')" onMouseOut="MM_controlSound(\'play\',\'document.CS1022563046202\',\'dlf/click.wav\')">';
			echo '<table width="846" height="27" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'" style="border-bottom:1px solid #000000;">';
			echo '<tr><td>';
			echo "<table><tr><td><img src='dlf/folder.png' align='center'>";
			echo "<td colspan='250'><a href=\"" . $_SERVER['PHP_SELF'] . "?dir=" . $mediapath . "/" . $files[$x] . "\"   class='rollover'>" . $files1[$x] . "</td>";
			echo "</tr></table>";
			echo "</td></tr></table>";
			$line1[$x] = NULL;
        }
	}
}

for ($x=0; $x<($i-1); $x++) {
	//if (($files[$x] != '.') and ($files[$x] != "..")) {
	//	echo "<div>";
		//if(!is_dir($mydir . "/" . $files[$x])) {
			if($line1[$x] == NULL)
				continue;
		if (substr($line1[$x],0,1) != 'd'){
			 if ((strtolower(strrchr($files[$x],'.')) == ".wmv")||(strtolower(strrchr($files[$x],'.')) == ".mpg")|| (strtolower(strrchr($files[$x],'.')) == ".avi") ||(strtolower(strrchr($files[$x],'.')) == ".dat")||(strtolower(strrchr($files[$x],'.')) == ".mpeg")||(strtolower(strrchr($files[$x],'.')) == ".divx")||(strtolower(strrchr($files[$x],'.')) == ".xvid")||(strtolower(strrchr($files[$x],'.')) == ".mkv")||(strtolower(strrchr($files[$x],'.')) == ".mov")||(strtolower(strrchr($files[$x],'.')) == ".asf")||(strtolower(strrchr($files[$x],'.')) == ".ts")||(strtolower(strrchr($files[$x],'.')) == ".ogm")||(strtolower(strrchr($files[$x],'.')) == ".mp4") ||(strtolower(strrchr($files[$x],'.')) == ".vob")||(strtolower(strrchr($files[$x],'.')) == ".flv") ||(strtolower(strrchr($files[$x],'.')) == ".m4v"))
			 {


				$file = "http://".$_SERVER["SERVER_NAME"].'/'. "media" . $mediapath .'/'.$files[$x];
				$ext = strtolower(substr($files[$x], strrpos($files[$x], '.')+1));
                if($filetypes[$ext]) {
					$icon = $filetypes[$ext];
                } else {
					$icon = 'unknown.png';
                }

				echo '<table width="846" height="27" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'" style="border-bottom:1px solid #000000;">';
				echo '<tr><td>';

					echo "<table width='390' cellspacing='0' cellpadding='0' border='0'> <tr>";
					if (strlen($files[$x]) > 40) {
						echo "<table><tr><td > <img src='dlf/video.png' align='center'>";
                        echo "<td width='380'><a href='$file'><font color= 'white' face='Arial' size='2'>" . substr($files[$x],0,40) . "...</td>";}
						//echo "<td width='380'><a href='$file'>" . substr($files[$x],0,40) . "...</td>";}
                    else {
						echo "<table><tr><td> <img src='dlf/video.png' align='center'></td>";
				  		echo "<td width='380'><a href='$file'><font color= 'white' face='Arial' size='2'>" . $files[$x] . "</td>";
						//echo "<td width='380'><a href='$file'>" . $files[$x] . "</td>";
					}
					echo "</tr></table>";

	
				echo "<td>";
				echo "<table  width='15' height='2' cellspacing='0' cellpadding='0' border='0'> <tr>";
				echo "<td><a onClick=\"newwindow(600, 600, 'gomplay.php?dir=$mediapath&file=$files[$x]');\"; class='g' href='#'><img src='dlf/gom.png' width='18' height='17' alt='Gom Player'></td>";
				echo "</tr></table>";
				echo "</td>";

				echo "<td>";
				echo "<table  width='15' height='2' align='left' cellspacing='0' cellpadding='0' border='0'> <tr>";
				echo "<td><a onClick=\"newwindow(707, 545, 'vlc.php?dir=$mediapath&file=$files[$x]');\"; href='#'>&nbsp&nbsp<img src='dlf/vlc.png' width='15' height='17' alt='VLC Player'></td>";
				
				
				echo "</tr></table>";
				echo "</td>";

				echo "<td>";
				echo "<table width='35' height='2' cellspacing='0' cellpadding='0' border='0'> <tr>";
				if ((strtolower(strrchr($files[$x],'.')) == ".wmv")||(strtolower(strrchr($files[$x],'.')) == ".mpg")|| (strtolower(strrchr($files[$x],'.')) == ".dat")||(strtolower(strrchr($files[$x],'.')) == ".mpeg")||(strtolower(strrchr($files[$x],'.')) == ".asf") ||(strtolower(strrchr($files[$x],'.')) == ".m4v"))
				{
					echo "<td><a onClick=\"newwindow(600, 600, 'winplay.php?dir=$mediapath&file=$files[$x]');\"; href='#'>&nbsp&nbsp<img src='dlf/winmedia.png' width='16' height='17' alt='Windows Media Player'></td>";
				}
				echo "</tr></table>";
				echo "</td>";



			echo "</a>";


			        echo "<td>";
			        echo "<table width='90' height='2' cellspacing='0' cellpadding='0' border='0' > <tr><td>";

						?>
						<font color= "white" face="Arial" size="2">
						<?
						//$i = 0;
						
						//while ($i < sizeof($line1)) {
						//	if($line1[$i] == NULL) {
						//		$i++;
						//		continue;
						//	}

							sscanf($line1[$x],"%s %s %s %s %s %s %s %s", $a,$b, $c, $d, $Size, $mnth, $day, $time);
						//	$Name = substr(strstr($line1[$i],$time),strlen($time)+1);
						//	if ($Name == $files[$x]) {
								echo $Size;

								echo "</td></tr> </table>";
								echo "</td>";

								echo "<td>";
								echo "<table width='170' height='2' cellspacing='0' cellpadding='0' border='0'> <tr><td>";
								echo '<font color= "white" face="Arial" size="2">';
								echo $mnth. ' ' .$day. ' ' .$time;
								//$line1[$i] = NULL;
								//break;
						//	}
						//	$i++;
						//}	

//					echo "</td></tr> </table>";
//					echo "</td>";

//					echo "<td>";
//					echo "<table width='170' height='2' cellspacing='0' cellpadding='0' border='0'> <tr><td>";

				
				//			$date= date("M d Y h:i:s A", filemtime($mydir . "/" . $files[$x]));
				//			printf("%s", $date);
							//echo "<td colspan=\"25\">" . date("M d Y h:i:s A", filemtime($mydir . "/" . $files[$x])) . "</td>";

					echo "</td></tr> </table>";
					echo "</td>";

					echo "<td>";
					echo '<table width="80" height="3" cellspacing="0" cellpadding="0" border="0">';
					echo '<tr><td>';
					echo "<table cellspacing='0' cellpadding='0' cellspacing='0' cellpadding='0' border='0'><tr><td width='20'>
					<a href=\"download.php?dir=$mediapath&file=$files[$x]\";><img src='dlf/download_icon.png' align='center'>$nsbp$nsbp";
					echo "<td><a href=\"download.php?dir=$mediapath&file=$files[$x]\"; class='g'>Download</td></tr></table>";
					echo "</td></tr></table>";



					echo "</font>";
					echo "</td>";
					echo "</tr>";
					echo "</table>";

			     }
			}
    //    echo "</div>";
	//}
}
                 ?>
	</td>
  </tr>
</table>
          </div>
        </div>
    </div>

<center>
<table cellspacing='0' cellpadding='0' border='0' width=996 valign="center">

	<tr height="5"><td></td></tr>
	<tr><td width=70></td><td width=700>
	<?
		$mediapath1 = $mediapath;
		if ($aaa!= ""){
			$mediapath1 = str_replace("sda", "HDD", $mediapath1);
			$mediapath1 = str_replace("sdb1", "USB1", $mediapath1);
			$mediapath1 = str_replace("sdc1", "USB2", $mediapath1);
			$mediapath1 = str_replace("sdd1", "USB3", $mediapath1);
			$mediapath1 = str_replace("sdb", "USB", $mediapath1);
			$mediapath1 = str_replace("sdc", "USB", $mediapath1);
		}else{
			$mediapath1 = str_replace("sda1", "USB1", $mediapath1);
			$mediapath1 = str_replace("sdb1", "USB2", $mediapath1);
			$mediapath1 = str_replace("sdc1", "USB3", $mediapath1);
			$mediapath1 = str_replace("sdd1", "USB4", $mediapath1);
			$mediapath1 = str_replace("sdb", "USB", $mediapath1);
			$mediapath1 = str_replace("sdc", "USB", $mediapath1);
		}

		if (strlen($mediapath) > 90) {
				echo "<font face='Arial' color='white' size='2'>" . substr($mediapath1,0,90)."...</font>";
		}else{
				echo "<font face='Arial' color='white' size='2'>$mediapath1</font>";

		}
	?>
	
	</td>

	<td>
	<? if (($mediapath != '') && ($aaa!= "") && (substr($mediapath, 0, 4) == "/sda")){ 
			echo '<table cellspacing="0" cellpadding="0" border="0"><tr>';
			echo '<td width=25><font face="Arial" color="White" size="1">HDD</font></td>';
			echo '<td width=50><font face="Arial" color="White" size="1">'. $STR_HDDUsed .'</font></td>';
			echo '<td width=50><font face="Arial" color="White" size="1">'. $STR_HDDFree .'</font></td>';
			echo '<td width=50><font face="Arial" color="White" size="1">'. $STR_HDDTotal .'</font></td>';
			echo '</tr>';
	
			echo '<tr>';
				echo '<td width=25></td>';
				echo '<td ><font face="Arial" color="White" size="1">';
					//$HDDInfo = shell_exec("df -h|grep /dev/ide/host0/bus0/target0/lun0/part1");
					//$HDDInfo = shell_exec("df -h|grep /dev/scsi/host1/bus0/target0/lun0/part1");
					//$HDDUsed = strstr($HDDUsed, ' ');
					//sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);
					echo "$HDDUsed";
				echo '</td>';

				echo '<td><font face="Arial" color="White" size="1">';
	//				$HDDFree = shell_exec("df -h|grep /dev/ide/host0/bus0/target0/lun0/part1|cut -f15 -d' '");
					echo "$HDDFree";
				echo '</td>';
				
				echo '<td><font face="Arial" color="White" size="1">';
	//				$HDDTotal = shell_exec("df -h|grep /dev/ide/host0/bus0/target0/lun0/part1|cut -f5 -d' '");
					echo "$HDDTotal";
				echo '</td>';
			echo '</tr>';
			echo '</table>';
/*			}else if($mediapath != ''){
				echo '<table cellspacing="0" cellpadding="0" border="0"><tr>';
			echo '<td width=25><font face="Arial" color="#748e94" size="1">HDD</font></td>';
				echo '<td width=50><font face="Arial" color="#748e94" size="1">'. $STR_HDDUsed .'</font></td>';
				echo '<td width=50><font face="Arial" color="#748e94" size="1">'. $STR_HDDFree .'</font></td>';
				echo '<td width=50><font face="Arial" color="#748e94" size="1">'. $STR_HDDTotal .'</font></td>';
				echo '</tr>';
		
				echo '<tr>';
					echo '<td width=25></td>';
					echo '<td ><font face="Arial" color="#748e94" size="1">';
						$HDDInfo = shell_exec("df -h|grep /dev/ide/host0/bus0/target0/lun0/part7");
						sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);
						echo "$HDDUsed";
					echo '</td>';

					echo '<td><font face="Arial" color="#748e94" size="1">';
	//					$HDDFree = shell_exec("df -h|grep /dev/ide/host0/bus0/target0/lun0/part7|cut -f15 -d' '");
						echo "$HDDFree";
					echo '</td>';
					
					echo '<td><font face="Arial" color="#748e94" size="1">';
	//					$HDDTotal = shell_exec("df -h|grep /dev/ide/host0/bus0/target0/lun0/part7|cut -f5 -d' '");
						echo "$HDDTotal";
					echo '</td>';
			echo '</tr>';
			echo '</table>';  */
			}
			?>
			
	</td>

	</tr>
</table>

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
</HTML>
