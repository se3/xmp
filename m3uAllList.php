<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
//This file will write selected data to My All Play list
$data = $_POST['playlist'];
$dir = $_GET['dir'];

$filename = "/usr/local/etc/mylist.All";

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
		echo "<script>parent.document.location.href = 'm3uAll.php?dir=$dir';</script>";

?>