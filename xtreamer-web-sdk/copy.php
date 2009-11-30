<?php
header('Content-Type: text/html; charset=utf-8');
//This file will allow to copy/Move file.
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


if ($_SESSION['newpath'] == ""){
	$newpath = "";
}else{
	$newpath = $_SESSION['newpath'];
}


$root = "/tmp/usbmounts";  // this will the the root position of this script

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

//to deetct internal HDD exists or not
$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);
?>



<script language=javascript>

checked=false;
function checkedAll(filelist) {
	var aa= document.getElementById('filelist');
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


function copyfile(){
	flg = 0;
	for(i=0;i<document.filelist.length;i++){
		if(document.filelist[i].checked == true){
			flg = 1;
			break;
		}else{
			flg = 0;
		}
	}

	if(flg == 0){
		alert('<? echo $STR_NoFileSelected;?>');
	}else if(!document.filelist.new_path.value){
		alert('<? echo $STR_SpecifyDestination;?>');
	}else{
		loadDivEl = document.getElementById("loadDiv");
		loadDivEl.style.visibility = 'visible';
		document.filelist.target = 'gframe';
		document.filelist.action="./copy_file.php?dir=<? echo $mediapath;?>";
		document.filelist.submit();
	}
}


function movefile(){
	flg = 0;
	for(i=0;i<document.filelist.length;i++){
		if(document.filelist[i].checked == true){
			flg = 1;
			break;
		}else{
			flg = 0;
		}
	}

	if(flg == 0){
		alert('<? echo $STR_NoFileSelected;?>');
	}else if(!document.filelist.new_path.value){
		alert('<? echo $STR_SpecifyDestination;?>');
	}else{
		loadDivEl = document.getElementById("loadDiv");
		loadDivEl.style.visibility = 'visible';
		document.filelist.target = 'gframe';
		document.filelist.action="./move_file.php?dir=<? echo $mediapath;?>";
		document.filelist.submit();
	}
}

</script>


<HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><? echo $STR_CopyTitle;?> </title>
	<link href="dlf/styles.css" rel="stylesheet" type="text/css">
</head>
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu="return false;">

<table width="987" height="60" background="dlf/top_menu.jpg" border="0" cellspacing="0" cellpadding="0">
	<tr> <td width=25%></td> 
		<td width=40% align=middle><font face="arial" color="#ff0000"><h2>&nbsp&nbsp&nbsp&nbsp <? echo $STR_CopyTitle;?></h2></font></td>
		<td width=30%></td>
	</tr>
</table>

<center>
<table cellspacing="0" cellpadding="0" border="0" width="880" height="500">
	<tr><td height="5"></td></tr>
	<tr>
		<td align=center><font face='Arial' size='2' color='#FFFFFF'><? echo $STR_CopySource;?></td>
		<td></td>
		<td align=center><font face='Arial' size='2' color='#FFFFFF'><? echo $STR_CopyDestination;?></td>
	</tr>

	<tr><td cellspacing="0" cellpadding="0" border="0" height=500 width=500 valign="top">
		<div id="listingcontainer1">
			<table cellspacing="0" cellpadding="0" border="0">
			<tr height=18><td></td></tr>
			<tr><td width=10></td>

			<td>
			<div id="listing1">

<?
echo "<form id='filelist' name='filelist' method='post' enctype='multipart/form-data'>";
if ($mediapath != ''){
	echo "<input type='checkbox' name='selectall' onclick='checkedAll(filelist);'><font face='Arial' color='white' size='2'>" . $STR_SelectAll;
}

if(!$_GET["dir"]==''){
	echo '<table width="500" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'"><tr><td>';
	echo "<table><tr><td><img src='dlf/dirup.png' align='center'>";
	echo "<td colspan='200'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $uplink ."'>" . $STR_ParentDirectory . "</a></td></tr></table>";
	echo "</td></tr></table>";
}



for ($x=0; $x<sizeof($files); $x++) {
	if (($files[$x] != '.') and ($files[$x] != "..") and ($files[$x] != "Recycled") and ($files[$x] != "System Volume Information") and (substr($files[$x],0,1) != ".") and ($files[$x] != "lost+found")) {
		if(is_dir($mydir . "/" . $files[$x])) {
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

			echo '<table width="500" height="3" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
			echo "<tr><td>";
			echo "<table cellspacing='1' cellpadding='0' border='0'><tr>";
			if(!$_GET["dir"]==''){
			echo "<td><input type='checkbox' name='filelist[]' value=\"$files[$x]\">";}
			echo "<td><img src='dlf/folder.png' align='center'>";
			echo "<td colspan='200'><font face='Arial'><a href=\"" . $_SERVER['PHP_SELF'] . "?dir=" . $mediapath . "/" . $files[$x] . "\">" . $files1[$x] . "</td>";
			echo "</tr></table>";
			echo "</td></tr></table>";
		}
	}
}

for ($x=0; $x<sizeof($files); $x++) {
	if (($files[$x] != '.') and ($files[$x] != "..")) {
		//echo "<div>";
		if(!is_dir($mydir . "/" . $files[$x])) {
			 if (($files[$x] != "mylist.All") and ($files[$x] != "mylist.Music") and ($files[$x] != "mylist.Picture") and ($files[$x] != "mylist.Video") and ($files[$x] != "keyword.data")){
				echo '<table width="500" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
				echo "<tr> <td>";
				echo "<table cellspacing='1' cellpadding='0' border='0'><tr><td><input type='checkbox' name='filelist[]' value=\"$files[$x]\">";
				echo "<td colspan='200'><font face='Arial' color='white' size='2'>" . $files[$x] . "</font></td>";
				echo "</tr></table>";
				echo "</td></tr></table>";
			}
		}
	}
}
	echo "</div>";
?>
			</td></tr></table>
        </td>
		<td height=500 align=middle>
			<font face='Arial' size='2' color='#FFFFFF'><? echo $STR_Copy;?>
		    <input type="button" name="copy" class='btn_2' value=" => " onclick='javascript:copyfile();';>
			<? echo $STR_Move;?></font>
		    <input type="button" class='btn_2' name="move" value=" => " onclick='javascript:movefile();';>
		</td>

		<td height=500 valign='top'>
			<div id="listingcontainer1">
			<table cellspacing="0" cellpadding="0" border="0">
			<tr height=18><td></td></tr>
			<tr><td width=10></td>
			<td>
				<!--div id="listing1"-->
				<iframe frameborder="0" framespacing="0" marginheight="0" marginwidth="0" name="tree" id="tree" scrolling="auto" vspace="0" width=430 height=472 src="destination.php?dir=<? echo $newpath;?>" ></iframe>
				</div>
			</td></tr></table>
		</td>

     </tr>
</table>

<table border=0 width=940>
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

	if (strlen($mediapath) > 55){
		$currentpath = "..." . substr($mediapath1, -51);
	}else{
		$currentpath = $mediapath1;
	}

	//session_destroy();
	$_SESSION['newpath'] = "";

?>

	<tr><td width=440>&nbsp <font color=white face='Arial' size=2><?echo $currentpath; ?></td>
		<td width=45></td>
		<td><input style="background-color:transparent; color: #FFFFFF; border:0px; font-size:10pt; font-family:Arial;" type='text' name='new_path' id='new_path' size=53 value="" readonly>
		<input type='hidden' name='new_path1' id='new_path1' size=53 value="" readonly></td>
		<td align=right><input type=button class='btn_2' onclick="window.close()" class="web-button" value="<? echo $STR_Close;?>"></td>
	</tr>
</table>
</form>

<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
<div id="loadDiv" name="loadDiv" style="position:absolute; visibility:hidden; left:290;top:140;width:200; height:100; z-index:1;">
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
</HTML>