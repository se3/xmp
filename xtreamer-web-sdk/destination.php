<HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> </title>
	<link rel="stylesheet" type="text/css" href="dlf/styles.css" />
</head>
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu="return false;">
<?
error_reporting(0);
include '/tmp/lang.php';
$root = "/tmp/usbmounts";  // this will the the root position of this script
$filetypes = array (
                'zip' => 'archive.png', 
                'rar' => 'archive.png',
				'tar' => 'archive.png',
                'exe' => 'exe.gif', 
                'setup' => 'setup.gif', 
                'txt' => 'text.png', 
                'htm' => 'html.gif', 
                'html' => 'html.gif', 
                'fla' => 'fla.gif',
                'bin' => 'binary.png',				
                'xls' => 'xls.gif', 
                'doc' => 'doc.gif', 
                'ppt' => 'ppt.gif', 
                'sig' => 'sig.gif', 
                'pdf' => 'pdf.gif', 
                'psd' => 'psd.gif', 
                'gz' => 'archive.png', 
                'asc' => 'sig.gif', 
				'wmv' => 'video.png',
				'mpg' => 'video.png',
				'avi' => 'video.png',
				'dat' => 'video.png',
				'mpeg' => 'video.png',
				'divx' => 'video.png',
				'xvid' => 'video.png',
				'mkv' => 'video.png',
				'm4v' => 'video.png',
				'mov' => 'video.png',
				'asf' => 'video.png',
				'ts' => 'video.png',
				'ogm' => 'video.png',
				'vob' => 'video.png',
				'mp4' => 'video.png',
				'wma' => 'audio.png',
				'mp3' => 'audio.png',
				'flac' => 'audio.png',
				'wav' => 'audio.png',
				'mp2' => 'audio.png',
				'aac' => 'audio.png',
				'ac3' => 'audio.png',
				'dts' => 'audio.png',
				'png' => 'photo.png',
				'jpeg' => 'photo.png',
				'jpg' => 'photo.png',
				'png' => 'photo.png',
				'bmp' => 'photo.png',
				'gif' => 'photo.png',
				'tif' => 'photo.png',
            );


//to deetct internal HDD exists or not
$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);

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

//echo "<div style='width: 450; height: 500; overflow: scroll; border: 1px solid #A7C5FF; background: transparent ;'>";

//echo '<div id="listingcontainer1">';

echo '<div id="listing1">';

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
			echo '<tr><td>';
			echo "<table cellspacing='1' cellpadding='0' border='0'><tr><td><img src='dlf/folder.png' align='center'>";
			echo "<td colspan='200'><a href='" . $_SERVER['PHP_SELF'] . "?dir=" . $mediapath . "/" . $files[$x] . "'>" . $files1[$x] . "</td>";
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
				$ext = strtolower(substr($files[$x], strrpos($files[$x], '.')+1));
				if($filetypes[$ext]) {
					$icon = $filetypes[$ext];
				} else {
					$icon = 'unknown.png';
				}
				echo '<table width="500" cellspacing="0" cellpadding="0" border="0" onMouseOver="this.style.backgroundImage= \'url(dlf/rollover_bar.png)\'" onMouseOut="this.style.backgroundImage=\'none\'">';
				echo "<tr> <td>";
				echo "<table cellspacing='1' cellpadding='0' border='0'><tr><td><img src='dlf/" . $icon . "' align='center'>";
				echo "<td colspan='200'><font face='Arial' color='white' size='2'>" . $files[$x] . "</font></td>";
				echo "</tr></table>";
				echo "</td></tr></table>";
			}
		}
	}
}


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
?>
<script language=javascript>
	parent.document.filelist.new_path.value='<?echo $mediapath1;?>';
	parent.document.filelist.new_path1.value='<?echo $mediapath;?>';
</script>
</body>
</HTML>