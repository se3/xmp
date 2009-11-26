<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);

$file= "/tmp/usbmounts" . stripslashes($_GET['dir']) . "/" . stripslashes($_GET['file']);

$name="/tmp/usbmounts" . stripslashes($_GET['dir']) . "/" . stripslashes($_GET['file']);

// required for IE, otherwise Content-disposition is ignored
if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');

$known_mime_types=array(
 	"pdf" => "application/pdf",
 	"txt" => "text/plain",
 	"html" => "text/html",
 	"htm" => "text/html",
	"exe" => "application/octet-stream",
	"zip" => "application/zip",
	"doc" => "application/msword",
	"xls" => "application/vnd.ms-excel",
	"ppt" => "application/vnd.ms-powerpoint",
	"gif" => "image/gif",
	"png" => "image/png",
	"jpeg"=> "image/jpg",
	"jpg" => "image/jpg",
	"php" => "text/plain",
	"wmv" => "video/x-ms-wmv",
	"avi" => "video/x-msvideo",
	"mp3" => "audio/mpeg");


header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: private", false); // required for certain browsers

// force download dialog
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ){
	header("Content-Disposition: attachment; filename=\"".urlencode(basename($name))."\";");
}else{
	header("Content-Disposition: attachment; filename=\"".basename($name)."\";");
}
header("Content-length: ".filesize($name));
header('Content-Type: ' . $known_mime_types);
//header('Content-Length: ' . filesize("$file"));
header("Content-Transfer-Encoding: binary");

ob_clean();
flush();
readfile("$file");
exit();
?>
