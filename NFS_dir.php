<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include '/tmp/lang.php';
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

$root = "/tmp/usbmounts";

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

$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);
?>

<script language=javascript>
function change(){
	count = 0;

	for(i=0;i<document.filelist.length;i++){
		if(document.filelist[i].checked == true){
			count++;
			if(count > 1)
				break;
		}
	}

	if(count == 0){
		alert("<?echo $STR_No_dir_selected;?>");
		return false;
	}else if(count > 1){
		alert("<?echo $STR_One_dir_only;?>");
		return false;
	}else{
		document.filelist.target = 'gframe';
		document.filelist.action = 'NFS_dir_local.php?dir=<? echo $mediapath;?>';
		document.filelist.submit();
	}
}

function makefolder(){
	document.makedir.target = 'gframe';
	document.makedir.action="./newfolder_nfs.php?dir=<?echo $mediapath;?>";
	document.makedir.submit();
}
</script>


<HTML>
<head>
    <title>NFS Mount</title>
	<link rel="stylesheet" type="text/css" href="dlf/styles.css" />
</head>
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu="return false;" onunLoad="window.opener.location.reload();">
	<table width="100%" height="50" background="dlf/top_menu.jpg" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width=850 height="50" align=middle><font face="arial" color="#ff0000"><h2>NFS</h2></font></td>
	    </tr>
	</table>

<center>
<table cellspacing="0" cellpadding="0" border="0" width=450 height=500>
	<tr height=32><td>
	<?if ($mediapath == ''){
		$STR_NewFolderName = "NFS Shortcut:";
		}
	?>
		
			<form name="makedir" action='javascript:makefolder();' method="post" enctype="multipart/form-data">
				<table width=455 cellspacing="0" cellpadding="0" border="0">
				<tr height=5><td></td></tr>
				<tr><td><font face='Arial' color='white' size='2'><?echo $STR_NewFolderName;?></font>&nbsp
					<input type="text" name="dir_name" class="textbox" size="25" maxlength="255"> 
					<input type=button class='btn_2' name=create value="<?echo $STR_Create;?>" onclick='javascript:makefolder();';>
				</td></tr>
				<tr height=5><td></td></tr>
				</table>		
			</form>
	</td><tr>
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

echo "<form name='filelist' method='post' action='javascript:change();'>";

for ($x=0; $x<sizeof($files); $x++) {
	if (($files[$x] != '.') and ($files[$x] != "..") and ($files[$x] != "Recycled") and ($files[$x] != "System Volume Information") and (substr($files[$x],0,1) != ".") and ($files[$x] != "lost+found")) {
		if(is_dir($mydir . "/" . $files[$x])) {
			$files1[$x] = $files[$x];
			if (($aaa!= "") && ($mediapath == "") && (substr($files1[$x],0, 3) == "sda")){
				$files1[$x] = str_replace("sda", "HDD", $files1[$x]);
			
			echo '<table width="500" height="3" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
				echo "<tr> <td>";
				echo "<table cellspacing='1' cellpadding='0'><tr><td>";
				if($_GET["dir"]!=''){
				echo "<input type='checkbox' name='filelist[]' value=\"$files[$x]\">";}
				echo "<td><img src='dlf/folder.png' align='center'>";
				echo "<td colspan='200'><font face='Arial'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $mediapath . "/" . $files[$x] . "'>" . $files1[$x] . "</td>";
				echo "</tr></table>";
				echo "</td></tr></table>";
			}
			else if (($aaa!= "") && (substr($mediapath,0, 4) == "/sda")){
				$files1[$x] = str_replace("sda", "HDD", $files1[$x]);
				
				echo '<table width="500" height="3" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
				echo "<tr> <td>";
				echo "<table cellspacing='1' cellpadding='0'><tr><td>";
				if($_GET["dir"]!=''){
				echo "<input type='checkbox' name='filelist[]' value=\"$files[$x]\">";}
				echo "<td><img src='dlf/folder.png' align='center'>";
				echo "<td colspan='200'><font face='Arial'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $mediapath . "/" . $files[$x] . "'>" . $files1[$x] . "</td>";
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
	
	if($mediapath==""){
		$currentpath = "/NFS Shortcut";
	}elseif (strlen($mediapath) > 40){
		$currentpath = "..." . substr($mediapath1, -36);
	}else{
		$currentpath = $mediapath1;
	}
?>

	<tr>
		<td width=340>&nbsp <font color=white face='Arial' size='2'><?echo $currentpath; ?>/</td>
		<?if($_GET["dir"]!=''){?>
		<td align=right><input type=button class='btn_2' onclick="javascript:change()" class="web-button" value="<?echo $STR_Apply;?>"> </td>
		<?}?>
		&nbsp<td align=right><input type=button class='btn_2' onclick="window.close()" class="web-button" value="<?echo $STR_Close;?>"></td>
	</tr>

</table>
</form>
<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
</body>
</HTML>