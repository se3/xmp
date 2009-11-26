<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
include '/tmp/lang.php';
$mediapath = "/tmp/usbmounts" . $_GET['dir'];
$newpath = "/tmp/usbmounts" . $_POST['new_path1'];
$source = $_POST['filelist']; 
$dir = $_GET['dir'];
$link = $_POST['new_path1'];

$countdata = count($source);

for ($i=0; $i<$countdata; $i++){
		$source[$i] = stripslashes($source[$i]);
}

function copydir($source,$destination,$temp)
{
	mkdir("$destination/$temp");
	if ($dir = opendir($source)) {
		while (($file = readdir($dir))!==false) {
			//echo "<script>alert('$file');</script>";
			if(is_dir("{$source}/{$file}" )){
				if (($file != '.') && ($file != '..')) {
					copydir("$source/$file","$destination/$temp","$file");
				}
			}else{
				copy("$source/$file","$destination/$temp/$file");
			}
		} 
	closedir($dir);
	}
}

if($mediapath == $newpath){
	echo "<script>alert('$STR_SourceDestNotSame');</script>";
	echo "<script>parent.document.location.href = 'copy.php?dir=$dir';</script>";
}else{
	for ($i=0; $i<$countdata; $i++){
		if (!is_dir($mediapath . "/" . $source[$i])){		
			copy($mediapath . "/" . $source[$i], $newpath . "/" . $source[$i]);
		}else{
			copydir($mediapath . "/" . $source[$i],$newpath,$source[$i]);
		}
	}

	echo "<script>alert('$STR_CopySuccess');</script>";

	$_SESSION['newpath'] = $link;
	echo "<script>parent.document.location.href = 'copy.php?dir=$dir';</script>";

	
}
?> 
