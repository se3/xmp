<?
	session_start();
	error_reporting(0);

	include '/tmp/lang.php';

	$l_mount = $_POST['l_mount'];
	$r_mount = $_POST['rmount'];
	$m_option = $_POST['opt'];

	$l_mount = str_replace(" ","\ ", $l_mount);
	$r_mount = str_replace(" ","\ ", $r_mount);

	//if (substr($l_mount, 0, 13) == "/tmp/nfsmount"){
	//	$l_mount1 = str_replace("/tmp/nfsmount", "", $l_mount);
	//}else{
	//	$l_mount1 = $l_mount;
	//}

	$data = $l_mount."->".$r_mount." -o ".$m_option;
	
	$command = "mount -t nfs ".$r_mount ." ".$l_mount." -o nolock,".$m_option;
	//echo "<script>alert('$command');</script>";
	
	$filename = "/usr/local/etc/nfs";
	$fp = fopen($filename, 'r');
	$fileData = fread($fp, filesize($filename));
	fclose($fp);

	$line = explode("\n", $fileData);
	$count = count($line);
	
	$count1 = 0;
	for ($i=0; $i<$count; $i++)
	{
		if ($line[$i] != "")
			$count1 += 1;
	}

	//echo "<script>alert('$count1');</script>";

	if($count1 <10){
		exec("$command",$result,$output);
		if($output == 0){
			$fp = fopen($filename, 'a');
			fwrite($fp,$data."\n");
			fclose($fp);

			$_SESSION['NFS'] = "";
			$_SESSION['NFS_show'] = "";
			echo "<script>parent.window.location.href='setup_nfs.php'; </script>";
		}else{
			echo "<script>alert('$STR_mount_failed');</script>";
			echo "<script>loadDivEl = parent.document.getElementById('loadDiv');
					loadDivEl.style.visibility = 'hidden';</script>";
		}
	}else{
		echo "<script>alert('$STR_mount_Max');</script>";
		echo "<script>loadDivEl = parent.document.getElementById('loadDiv');
					loadDivEl.style.visibility = 'hidden';</script>";
	}
?>
