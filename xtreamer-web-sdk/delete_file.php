<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
$mediapath = "/tmp/usbmounts" . $_GET['dir'];
$filename = $_POST['filelist']; 
$dir = $_GET['dir'];

$countdata = count($filename);
//echo "<script>alert('$countdata');</script>";

for ($i=0; $i<$countdata; $i++){
		$filename[$i] = stripslashes($filename[$i]);
}

//even delets non-empty dir
function deleteDir($dir) {
   $dhandle = opendir($dir);

   if ($dhandle) {
      while (false !== ($fname = readdir($dhandle))) {
         if (is_dir( "{$dir}/{$fname}" )) {
            if (($fname != '.') && ($fname != '..')) {
             //  echo "<u>Deleting Files in the Directory</u>: {$dir}/{$fname} <br />";
               deleteDir("$dir/$fname");
            }
         } else {
           // echo "Deleting File: {$dir}/{$fname} <br />";
            unlink("{$dir}/{$fname}");
         }
      }
      closedir($dhandle);
    }
//   echo "<u>Deleting Directory</u>: {$dir} <br />";
   rmdir($dir);
}


if($countdata == 0){
	echo "<script>alert('$STR_NoFileToDel');</script>";
}else{
	for ($i=0; $i<$countdata; $i++){
		if (!is_dir($mediapath . "/" . $filename[$i])){			
			unlink($mediapath . "/" . $filename[$i]);
			//echo "<u>Deleting Files: {$mediapath}/{$filename[$i]} <br />";
		}else{
			deleteDir($mediapath . "/" . $filename[$i]);
		}
	}
	echo "<script>parent.document.location.href = 'delete.php?dir=$dir';</script>";
}
?>