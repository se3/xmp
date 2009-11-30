<?php
//This file will allow to create Play List (mylist.Video).
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include '/tmp/lang.php';
//if login option is true check login status
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
                       header("Location:login_form.php");
                        exit;
                }
        }
        $i++;
}

//$root = "/tmp/hddmedia/HDD1";  // this will the the root position of this script
//$root = "/tmp/hdd/volumes";  // this will the the root position of this script
$root = "/tmp/usbmounts";

//Set our root position and make sure the URL input is not manually manipulated
if ((substr($_GET['dir'],0,2) != '/.') and (substr($_GET['dir'],0,1) != '.') and ($_GET['dir'] != '')) {
    $mydir = $root . $_GET['dir'];
    $mediapath =  $_GET['dir']; }
else {
    $mydir = $root;
}

$uplink = substr_replace($_GET['dir'],'',strlen($_GET['dir'])-strlen(strrchr( $_GET['dir'],'/')));

//Get and sort the directory listing
$files = myscan($mydir);
sort($files);

//Common functions used
function myscan($dir) {
    $arrfiles = array();
    $arrfiles = opendir($dir);
    while (false !== ($filename = readdir($arrfiles))) {
           $files[] = $filename;
    }
    return $files;
}

$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);
?>

<script language=javascript>

checked=false;
function checkedAll(playlist) {
	var aa= document.getElementById('playlist');
	 if (checked == false)
          {
			checked = true
          }else{
	        checked = false
          }
	for (var i =0; i < aa.elements.length; i++){
		 aa.elements[i].checked = checked;
	}
}

function checkAllmylist(mylist) {
	var aa= document.getElementById('mylist');
	 if (checked == false)
          {
	           checked = true
          }else{
	           checked = false
          }
	for (var i =0; i < aa.elements.length; i++){
		 aa.elements[i].checked = checked;
	}
}


function addlist(){
flg = 0;
for(i=0;i<document.playlist.length;i++){
	if(document.playlist[i].checked == true){
	flg = 1;
	break;
	}else{
	flg = 0;
	}
}

if(flg == 0){
alert("<?echo $STR_NoFileToAdd;?>");
return false;
}
	document.playlist.target = 'gframe';
	document.playlist.action="./m3uVideoList.php?dir=<? echo $mediapath;?>";
	document.playlist.submit();
}

function removelist(){

flg = 0;
for(i=0;i<document.mylist.length;i++){
	if(document.mylist[i].checked == true){
	flg = 1;
	break;
	}else{
	flg = 0;
	}
}

if(flg == 0){
alert("<?echo $STR_NoFileToRemove;?>");
return false;
}

	document.mylist.target = 'gframe';
	document.mylist.action="./m3uVideoListremove.php?dir=<? echo $mediapath;?>";
	document.mylist.submit();
}

function goto(form){
	var index=form.select_media.selectedIndex
	if (form.select_media.options[index].value != "0") {
		location=form.select_media.options[index].value;
	}
}

</script>


<HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> <?echo $STR_MyListTitle;?></title>
    <link href="dlf/styles.css" rel="stylesheet" type="text/css">
</head>
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu="return false;">
	<table width="987" height="94" background="dlf/top_menu.jpg" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width=30%><img src="dlf/icon_video.jpg" height="94" width="189" /></td>
          	<td width=40% align="center"><font face="arial" color="#ff0000"><h2><?echo $STR_MyListVideoTitle;?></h2></font></td>
			<td width=28% align="right" valign=bottom>
				<FORM NAME="form1">
				<font color="white" face="Arial" size="2"><?echo $STR_SelectMyList;?></font>
				<select name="select_media"  class="listbox" ONCHANGE="goto(this.form)">
					<option value="m3uVideo.php?dir=<?echo $mediapath;?>"><?echo $STR_Video;?></option>
					<option value="m3uMusic.php?dir=<?echo $mediapath;?>"><?echo $STR_Audio;?></option>
					<option value="m3uPhoto.php?dir=<?echo $mediapath;?>"><?echo $STR_Photo;?></option>
					<option value="m3uAll.php?dir=<?echo $mediapath;?>"><?echo $STR_All;?></option>
				</select>
				</FORM>
			</td>
			<td width=2%></td>

	    </tr>
	</table>

	<center>
    <table cellspacing="0" cellpadding="0" border="0" width=950 height=500>

		<tr>
			<td align=center><font face='Arial' size='2' color='white'><?echo $STR_FileList;?></td>
			<td></td>
			<td align=center><font face='Arial' size='2' color='white'><?echo $STR_MyListTitle;?></td>
			<td ></td>
		</tr>

		<tr><td cellspacing="0" cellpadding="0" border="0" height=500 width=500 valign="top">
			<div id="listingcontainer1">

			<table cellspacing="0" cellpadding="0" border="0">
			<tr height=18><td></td></tr>
			<tr><td width=10></td>

			<td>
			<div id="listing1">

<?
echo "<form id='playlist' name='playlist' method='post' enctype='multipart/form-data'>";
if ($mediapath != ''){
	echo "<input type='checkbox' name='selectall' onclick='checkedAll(playlist);'><font color= 'white' face='Arial' size='2'>".$STR_SelectAll;
}

//echo "<div>";
if(!$_GET["dir"]==''){
echo '<table width="500" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'"><tr><td>';
echo "<table><tr><td><img src='dlf/dirup.png' align='center'>";
echo "<td colspan='200'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $uplink ."'>" . $STR_ParentDirectory . "</a></td></tr></table>";
echo "</td></tr></table>";
}


for ($x=0; $x<sizeof($files); $x++) {
	if (($files[$x] != '.') and ($files[$x] != "..") and ($files[$x] != "Recycled") and ($files[$x] != "System Volume Information") and (substr($files[$x],0,1) != ".") and ($files[$x] != "lost+found")){
		//echo "<div>";
		if(is_dir($mydir . "/" . $files[$x])) {
			$files1[$x] = $files[$x];
			if (($aaa!= "") && ($mediapath == "") && (substr($files1[$x],0, 3) == "sda")){
				$files1[$x] = str_replace("sda", "HDD", $files1[$x]);
			
				echo '<table width="500" height="3" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
				echo '<tr><td>';
				echo "<table cellspacing='1' cellpadding='0' border='0'><tr><td><img src='dlf/folder.png' align='center'>";
				echo "<td colspan='200'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $mediapath . "/" . $files[$x] . "'   class='rollover'>" . $files1[$x] . "</td>";
				//echo "It works only for Internal HDD.";
				echo "</tr></table>";
				echo "</td></tr></table>";
			}
			else if (($aaa!= "") && (substr($mediapath,0, 4) == "/sda")){
				$files1[$x] = str_replace("sda", "HDD", $files1[$x]);
			
				echo '<table width="500" height="3" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
				echo '<tr><td>';
				echo "<table cellspacing='1' cellpadding='0' border='0'><tr><td><img src='dlf/folder.png' align='center'>";
				echo "<td colspan='200'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $mediapath . "/" . $files[$x] . "'   class='rollover'>" . $files1[$x] . "</td>";
				//echo "It works only for Internal HDD.";
				echo "</tr></table>";
				echo "</td></tr></table>";
			}
        }
	}
}


for ($x=0; $x<sizeof($files); $x++) {
	if (($files[$x] != '.') and ($files[$x] != "..")) {
		//echo "<div>";
		if(!is_dir($mydir . "/" . $files[$x])) {
			 if ((strtolower(strrchr($files[$x],'.')) == ".wmv")||(strtolower(strrchr($files[$x],'.')) == ".mpg")|| (strtolower(strrchr($files[$x],'.')) == ".avi") ||(strtolower(strrchr($files[$x],'.')) == ".dat")||(strtolower(strrchr($files[$x],'.')) == ".mpeg")||(strtolower(strrchr($files[$x],'.')) == ".divx")||(strtolower(strrchr($files[$x],'.')) == ".xvid")||(strtolower(strrchr($files[$x],'.')) == ".mkv")||(strtolower(strrchr($files[$x],'.')) == ".mov")||(strtolower(strrchr($files[$x],'.')) == ".asf")||(strtolower(strrchr($files[$x],'.')) == ".ts")||(strtolower(strrchr($files[$x],'.')) == ".ogm")||(strtolower(strrchr($files[$x],'.')) == ".mp4")||(strtolower(strrchr($files[$x],'.')) == ".flv")||(strtolower(strrchr($files[$x],'.')) == ".m4v")){

				echo '<table width="500" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
				echo "<tr> <td>";
				echo "<table><tr><td><input type='checkbox' name='playlist[]' value='$files[$x]'>";
				echo "<td colspan='200'><font color= 'white' face='Arial' size='2'>" . $files[$x] . "</font></td>";
				echo "</tr></table>";
				echo "</td></tr></table>";
			}
		}
		//echo "</div>";
	}

}
	echo "</div>";
?>
			</td></tr></table>
        </td>

		<td align=middle>
				<font color= 'white' face='Arial' size='2'><?echo $STR_Add;?>
		      <input type="button" class='btn_2' name="add" value=" => " onclick='javascript:addlist();';>
			  </form>
			  <?
			  echo "<form id='mylist' name='form_mylist' method='post' enctype='multipart/form-data'>";
			  ?>
				<?echo $STR_Remove;?></font>

		      <input type="button" class='btn_2' name="remove" value=" <= " onclick='javascript:removelist();';>

		</td>

		<td valign='top'>
		<div id="listingcontainer1">
		<table cellspacing="0" cellpadding="0" border="0">
		<tr height=18><td></td></tr>
		<tr><td width=10></td>
			<td>

	<?
	echo '<div id="listing1">';
//	echo "<div style='width: 450; height: 500; overflow: scroll; border: 1px solid #A7C5FF; background: transparent ;'>";

	echo "<input type='checkbox' name='selectall' onclick='checkAllmylist(playlist);'><font color=white>" . $STR_SelectAll;

					$filename = "/usr/local/etc/mylist.Video";
					if (file_exists($filename)) {
						$fp = fopen($filename, 'r');
						$fileData = fread($fp, filesize($filename));
						fclose($fp);
					}else{
						$fp = fopen($filename, 'w');
						//fwrite($fp, "#My List\n");
						$fileData = fread($fp, filesize($filename));
						fclose($fp);
					}

					$line = explode("\n", $fileData);
					$count = count($line);
					for ($i=0; $i<$count-1; $i++){
						echo '<table width=600 cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
							echo "<tr><td>";
							echo "<input type='checkbox' name='mylist[]' value='$line[$i]'>";
							echo "<font color='white' face='Arial' size='2'>";
							echo $line[$i];
						echo "</td></tr></table>";
					}
				?>
						</div>
			</td></tr></table>

		</td>
     </tr>
</table>


<table border=0 width=955><tr><td width=850>&nbsp
	<font color='white' face='Arial' size='2'>
			<?
			$mediapath1 = $mediapath;
			if ($aaa!= ""){
				$mediapath1 = str_replace("sda", "HDD", $mediapath1);
			}
			echo $mediapath1; 
			?>

	</td>
	<td align=right><input type=button class='btn_2' onclick="window.close()" class="web-button" value="<?echo $STR_Close;?>"></td>
	</tr>
</table>
</center>

<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
</body>
</HTML>