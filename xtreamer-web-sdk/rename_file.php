<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
$mediapath = "/tmp/usbmounts" . $_GET['dir'];
$newname = $mediapath . "/" .$_POST['new_name'];
$oldname = $_POST['filelist']; 
$dir = $_GET['dir'];

$countdata = count($oldname);

for ($i=0; $i<$countdata; $i++){
		$oldname[$i] = stripslashes($oldname[$i]);
}

//echo "<script>alert('$countdata');</script>";
//echo "<script>alert('new = $newname');</script>";
//echo "<script>alert('old = $oldname');</script>";

$root = "/tmp/usbmounts";  // this will the the root position of this script

//Set our root position and make sure the URL input is not manually manipulated
if ((substr($_GET['dir'],0,2) != '/.') and (substr($_GET['dir'],0,1) != '.') and ($_GET['dir'] != '')) {
    $mydir = $root . $_GET['dir'];
}else {
    $mydir = $root;
}

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


$exist = 0;
for ($x=0; $x<sizeof($files); $x++) {
	if (($files[$x] != '.') and ($files[$x] != "..") and ($files[$x] != "Recycled") and ($files[$x] != "System Volume Information") and (substr($files[$x],0,1) != ".") and ($files[$x] != "lost+found")) {
		if (strtolower($mediapath . "/" . $files[$x]) == strtolower($newname)){
			$exist = 1;
			break;
		}
	}
}


if($countdata == 0){
	echo "<script>alert('$STR_CheckFileToRename');</script>";
}else if ($countdata > 1){
	echo "<script>alert('$STR_CheckOnlyOne');</script>";
}else{
	for ($i=0; $i<$countdata; $i++){
		//echo "<script>alert('old = $oldname[$i]');</script>";
		//echo "<script>alert('new = $newname');</script>";
		if ($exist == 1){
			echo "<script>alert('$STR_FileAlreadyExists');</script>";
			break;
		}else{
			if(rename($mediapath . "/" . $oldname[$i] ,  $newname)){
				echo "<script>alert('$STR_RenameSuccess');</script>";
				echo "<script>parent.document.location.href = 'rename.php?dir=$dir';</script>";
				break;
			}else{
				echo "<script>alert('$STR_EnterValidName');</script>";
				break;
			}
		}
	}
}
?>