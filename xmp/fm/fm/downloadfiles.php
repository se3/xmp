<?php
/*
 * Copyright (C) 2006 - 2007, West-Web Limited.
 *
 * Nickolay Shestakov <ns@ampex.ru>
 *
 * This program is free software, distributed under the terms of
 * the GNU General Public License Version 2. See the LICENSE file
 * at the top of the source tree.
 */

session_start();
if(!$_SESSION['fm_entry']) die('Not a Valid Entry');
include_once("../lang/".$_SESSION['lang'].".lang.php");
include_once("../config.php");
include_once("../lib/func.php");
include_once("../lib/pclzip/pclzip.lib.php");

$files=stripslashes_r($_POST['par']);

if(empty($files)) exit();

$files=explode(",",$files);

function send_file($path) {
   session_write_close();
   ob_end_clean();
   if (!is_file($path) || connection_status()!=0)
       return false;

   //to prevent long file from getting cut off from    //max_execution_time

   set_time_limit(0);

   $name=basename($path);
   
   //filenames in IE containing dots will screw up the
   //filename unless we add this

   if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
       $name = preg_replace('/\./', '%2e', $name, substr_count($name, '.') - 1);
   //required, or it might try to send the serving    //document instead of the file
	$name = str_replace(array("\"","<",">","?",":"),array('%22','%3c','%3e','%3f','_'),$name);
   }else $name = str_replace(array("\"",":"),array("'","_"),$name);
   
   header("Cache-Control: ");
   header("Pragma: ");
   header("Content-Type: application/octet-stream");
   header("Content-Length: " .(string)(filesize($path)) );
   header('Content-Disposition: attachment; filename="'.$name.'"');
   header("Content-Transfer-Encoding: binary\n");

   if($file = fopen($path, 'rb')){
       while( (!feof($file)) && (connection_status()==0) ){
           print(fread($file, 1024*8));
           flush();
       }
       fclose($file);
   }
   return((connection_status()==0) and !connection_aborted());
}
if(count($files) > 1 || is_dir($files[0])) {
    $d=date("Y-m-d_H-i");
    $ar_file=$tmp_dir."/".$d."_archive.zip";
    
    $archive = new PclZip($ar_file);
    $path=find_path($files,dirname($files[0]));
    if($path=='/') $res=$archive->create($files,PCLZIP_OPT_REMOVE_ALL_PATH);
    else $res=$archive->create($files,PCLZIP_OPT_REMOVE_PATH,$path);
    if(!$res) {?>
	<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
	<body>
	<script type="text/javascript">
    	    parent.fm.showMessage('<?=$strErrorCreatingZip?>','filemanager-message',0,'warning.gif');
	</script>
	</body></html>
<?      exit();
    }
    send_file($ar_file);
    @unlink($ar_file);
    exit();
}  
send_file($files[0]);

?>