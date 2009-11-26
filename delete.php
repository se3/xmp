<?php
//This file will allow to create Play List (mylist.All).
header('Content-Type: text/html; charset=utf-8');
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

$root = "/tmp/usbmounts";  // this will the the root position of this script

//Set our root position and make sure the URL input is not manually manipulated
if ((substr($_GET['dir'],0,2) != '/.') and (substr($_GET['dir'],0,1) != '.') and ($_GET['dir'] != '')) {
    $mydir = $root . $_GET['dir'];
    $mediapath =  $_GET['dir']; }
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

function change(){
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
		alert("<?echo $STR_NoFileToDel;?>");
		return false;
	}

	var ok = confirm('<?echo $STR_ReallyDelete;?>');
	if(ok){
		document.filelist.target = 'gframe';
		document.filelist.action = 'delete_file.php?dir=<? echo $mediapath;?>';
		document.filelist.submit();
	}
}

</script>


<HTML>
<head>
    <title> <?echo $STR_DeleteTitle;?></title>
	<link rel="stylesheet" type="text/css" href="dlf/styles.css" />
</head>
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu="return false;" onunLoad="window.opener.location.reload();">
	<table width="100%" height="50" background="dlf/top_menu.jpg" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width=850 height="50" align=middle><font face="arial" color="#ff0000"><h2><?echo $STR_DeleteTitle;?></h2></font></td>
	    </tr>
	</table>

<center>
<table cellspacing="0" cellpadding="0" border="0" width=450 height=500>
	<tr><td height="10"></td><tr>
	<tr><td cellspacing="0" cellpadding="0" border="0" height=500 width=500 valign="top">
	<div id="listingcontainer1">

	<table cellspacing="0" cellpadding="0" border="0">
	<tr height=18><td></td></tr>
	<tr><td width=10></td>

	<td>
	<div id="listing1">

<?
if(!$_GET["dir"]==''){
	echo '<table width="500" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'"><tr><td>';
	echo "<table><tr><td><img src='dlf/dirup.png' align='center'>";
	echo "<td colspan='200'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $uplink ."'>" . $STR_ParentDirectory . "</a></td></tr></table>";
	echo "</td></tr></table>";
}

echo "<form id='filelist' name='filelist' method='post' action='javascript:change();'>";
if ($mediapath != ''){
	echo "<input type='checkbox' name='selectall' onclick='checkedAll(filelist);'><font face='Arial' color='white' size='2'>" . $STR_SelectAll;
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
			echo "<tr> <td>";
			echo "<table cellspacing='1' cellpadding='0'><tr><td><input type='checkbox' name='filelist[]' value=\"$files[$x]\">";
			echo "<td><img src='dlf/folder.png' align='center'>";
			echo "<td colspan='200'><font face='Arial'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $mediapath . "/" . $files[$x] . "'>" . $files1[$x] . "</td>";
			echo "</tr></table>";
			echo "</td></tr></table>";
		}
	}
}

for ($x=0; $x<sizeof($files); $x++) {
	if (($files[$x] != '.') and ($files[$x] != "..")) {
		if(!is_dir($mydir . "/" . $files[$x])) {
			 if (($files[$x] != "mylist.All") and ($files[$x] != "mylist.Music") and ($files[$x] != "mylist.Picture") and ($files[$x] != "mylist.Video") and ($files[$x] != "keyword.data")){

				echo '<table width="500" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
				echo "<tr> <td>";
				echo "<table cellspacing='1' cellpadding='0'><tr><td><input type='checkbox' name='filelist[]' value=\"$files[$x]\">";
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

     </tr>
</table>

	
<table width="450" border="0" cellspacing="0" cellpadding="0">
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
	
	if (strlen($mediapath) > 40){
		$currentpath = "..." . substr($mediapath1, -36);
	}else{
		$currentpath = $mediapath1;
	}
?>

	<tr><td width=340>&nbsp <font color=white face='Arial' size='2'><?echo $currentpath; ?>/</td>
		<td><input type=button class='btn_2' onclick="javascript:change()" class="web-button" value="<?echo $STR_Delete;?>"> </td>
		&nbsp<td ><input type=button class='btn_2' onclick="window.close()" class="web-button" value="<?echo $STR_Close;?>"></td>
	</tr>

</table>
</form>
<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
</body>
</HTML>