<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
//This file will remove selected items from Music Play List
$data = $_POST['mylist'];
$dir = $_GET['dir'];

$filename = "/usr/local/etc/mylist.Music";
if (file_exists($filename)) {
	$fp = fopen($filename, 'r');
	if (filesize($filename)>0){
		$fileData = fread($fp, filesize($filename));
	}
	fclose($fp);
}

$line = explode("\n", $fileData);

	$countdata = count($data);	
//	echo "<script>alert('$countdata');</script>";
	$countline = count($line);
//	echo "<script>alert('$countline');</script>";
	
	for ($i=0; $i<$countdata; $i++){
		for ($j=0; $j<$countline-1; $j++){
			//	echo "<script>alert('$data[$i]');</script>";
			//	echo "<script>alert('$line[$j]');</script>";
			if ($data[$i] == $line[$j]){
				unset($line[$j]);
			}
		}
	}


	$m3ufile = fopen($filename, "w");
	for ($j=0; $j<$countline; $j++){
		if ($line[$j] != "")
	  	   fwrite($m3ufile, $line[$j]."\n");
	}
		   fclose($m3ufile);
?>
<script language=javascript>
	parent.document.location.href = 'm3uMusic.php?dir=<?echo $dir;?>';
</script>