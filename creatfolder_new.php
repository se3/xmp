<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
$dirname = $_POST['dir_name'];
$mediapath = $_GET['dir'];

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
		if ((strtolower($files[$x]) == strtolower($dirname))){
			$exist = 1;
			break;
		}
	}
}

if ($exist == 1){
			echo "<script>alert('$STR_FileAlreadyExists');</script>";
}else{
	if($dirname != ""){
		if(mkdir("/tmp/usbmounts" . $mediapath . "/" . $dirname, 0777)){
			echo "<script>alert('$dirname  $STR_FolderCreated ')</script>";
			echo "<script>parent.document.location.href='creatfolder.php?dir=$mediapath'</script>";
		}else{
			echo "<script>alert('$STR_FolderNameInvalid')</script>";
		}
	}else{
		echo "<script>alert('$STR_EnterFolderName')</script>";
	}
}
?>