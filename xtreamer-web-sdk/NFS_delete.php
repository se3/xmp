<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
$data = $_POST['mylist'];
$dir = $_GET['dir'];

$filename = "/usr/local/etc/nfs";
if (file_exists($filename)) {
	$fp = fopen($filename, 'r');
	if (filesize($filename)>0){
		$fileData = fread($fp, filesize($filename));
	}
	fclose($fp);
}

$line = explode("\n", $fileData);

	$countdata = count($data);	
	$countline = count($line);
	
	for ($i=0; $i<$countdata; $i++){
		$data[$i] = stripslashes($data[$i]);
		for ($j=0; $j<$countline; $j++){
			if ($data[$i] == $line[$j]){
				$dataset = explode("->", $line[$j]);
				
				$command = "umount -f ".$dataset[0];
				exec($command,$output,$result);

				//if (substr($dataset[0], 0, 13) == "/tmp/nfsmount"){
				//	rmdir(str_replace("\ "," ", $dataset[0]));
				//	if ($files = @scandir('/tmp/nfsmount') && (count($files) < 3))  
				//		rmdir('/tmp/nfsmount');
				//}

				rmdir(str_replace("\ "," ", $dataset[0]));
				rmdir('/tmp/nfsmount');

				//if($result == 0){
					unset($line[$j]);
				//}else{
				//	echo "<script>alert('$STR_delete_failed');</script>";
				//}
				
			}
		}
	}


	$nfsfile = fopen($filename, "w");
	for ($j=0; $j<$countline; $j++){
		if ($line[$j] != "")
	  	   fwrite($nfsfile, $line[$j]."\n");
	}
		   fclose($nfsfile);
?>
<script language=javascript>
	parent.document.location.href = 'setup_nfs.php';
</script>