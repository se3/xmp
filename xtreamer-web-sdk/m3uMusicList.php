<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
//This file will write selected data to My Music Play list
$data = $_POST['playlist'];
$dir = $_GET['dir'];

$filename = "/usr/local/etc/mylist.Music";

if (file_exists($filename)) {
	$fp = fopen($filename, 'r');
	if (filesize($filename)>0){
		$fileData = fread($fp, filesize($filename));
	}
	fclose($fp);
}

if (substr($dir,0,5) == "/sda1"){
	$path = "C:" . substr($dir,5);
}else if (substr($dir,0,5) == "/sda2"){
	$path = "D:" . substr($dir,5);;
}else if (substr($dir,0,5) == "/sda3"){
	$path = "E:" . substr($dir,5);;
}else if (substr($dir,0,5) == "/sda4"){
	$path = "F:" . substr($dir,5);;
}

	$countdata = count($data);	
	$countline = count($line);

	

//	for ($i=0; $i<$countdata; $i++){
//		for ($j=1; $j<$countline-1; $j++){
//			echo "<script>alert('$data[$i]');</script>";
//			echo "<script>alert('$line[$j]');</script>";
//			if (($countline > 2)and $data[$i] == substr(strrchr($line[$j], '/'),1)){
//				echo "<script>alert('$data[$i] file already exists!');</script>";
//
//			}else{
//					
//					$m3ufile = fopen($filename, "a");
//					fwrite($m3ufile, $dir ."/". $data[$i]."\n");
//					fclose($m3ufile);
//					break;
//
//			}
//		}
//	}


$list = array();
$list = explode("\n",$fileData);
$list = array_map("trim", $list);

for ($i=0; $i<$countdata; $i++){
	if (in_array($dir ."/". $data[$i],$list)){ 
		echo "<script>alert('$data[$i] $STR_FileExists');</script>";
    }else{
		$fd = fopen ($filename, "a") or die ("$STR_CantOpen $filename");
		$fout = fwrite ($fd, $path ."/". $data[$i]."\n");	
		fclose($fd);
	}
}
		echo "<script>parent.document.location.href = 'm3uMusic.php?dir=$dir';</script>";

//	foreach ($update as $this) {
//		$m3ufile = fopen($filename, "a");
//		   fwrite($m3ufile, $dir ."/". $this."\n");
//		   fclose($m3ufile);
//		}
?>