<?
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
include '/tmp/lang.php';
$dirname = $_POST['dir_name'];
$mediapath = $_GET['dir'];

$root = "/tmp/usbmounts";

$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);

if ((substr($_GET['dir'],0,2) != '/.') and (substr($_GET['dir'],0,1) != '.') and ($_GET['dir'] != '')) {
    $mydir = $root . $_GET['dir'];
}else {
    $mydir = $root;
}

$files = myscan($mydir);
sort($files);

function myscan($dir) {
    $arrfiles = array();
    $arrfiles = opendir($dir);
    while (false !== ($filename = readdir($arrfiles))) {
           $files[] = $filename;
    }
    return $files;
}


$exist = 0;
for ($x=0; $x<sizeof($files); $x++) {
	if (($files[$x] != '.') and ($files[$x] != "..") and ($files[$x] != "Recycled") and ($files[$x] != "System Volume Information") and (substr($files[$x],0,1) != ".") and ($files[$x] != "lost+found")) {
		if ((strtolower($files[$x]) == strtolower($dirname))){
			$exist = 1;
			break;
		}
	}
}

if ($exist == 1){
			echo "<script>alert('$STR_FolderAlreadyExists');</script>";
}else{
	if($dirname != ""){
		if($mediapath!= ""){
			if(mkdir("/tmp/usbmounts" . $mediapath . "/" . $dirname, 0777)){
				echo "<script>parent.document.location.reload();</script>";
			}else{
				echo "<script>alert('$STR_FolderNameInvalid')</script>";
			}
		}else{
			if(!file_exists("/tmp/nfsmount")){
				mkdir("/tmp/nfsmount", 0777);
			}
			if(file_exists("/tmp/nfsmount/". $dirname)){
				echo "<script>alert('$STR_FolderAlreadyExists');</script>";
			}else{
				mkdir("/tmp/nfsmount/". $dirname, 0777);
				$_SESSION['NFS'] = "/tmp/nfsmount/".$dirname;
				$_SESSION['NFS_show'] = "/NFS Shortcut/".$dirname;
				echo "<script>parent.window.close();</script>";
			}
		}
	}else{
		echo "<script>alert('$STR_EnterFolderName')</script>";
	}
}
?>