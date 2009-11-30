<?
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
//include '/tmp/lang.php';
$mediapath = "/tmp/usbmounts" . $_GET['dir'];
$m_dir = $_POST['filelist']; 
$dir = $_GET['dir'];

$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);

$countdata = count($m_dir);

for ($i=0; $i<$countdata; $i++){
		$m_dir[$i] = stripslashes($m_dir[$i]);
}

for ($i=0; $i<$countdata; $i++){
	$_SESSION['NFS'] = $mediapath."/".$m_dir[$i];

	$dir1 = $dir."/".$m_dir[$i];
	if ($aaa!= ""){
		$dir1 = str_replace("sda", "HDD", $dir1);
		$dir1 = str_replace("sdb", "USB", $dir1);
		$dir1 = str_replace("sdc", "USB", $dir1);
		$dir1 = str_replace("sdd", "USB", $dir1);
	}else{
		$dir1 = str_replace("sda", "USB", $dir1);
		$dir1 = str_replace("sdb", "USB", $dir1);
		$dir1 = str_replace("sdc", "USB", $dir1);
		$dir1 = str_replace("sdd", "USB", $dir1);
	}
	$_SESSION['NFS_show'] = $dir1;
	echo "<script>parent.window.close();</script>";
	break;
}
?>