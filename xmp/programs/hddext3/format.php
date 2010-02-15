<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Format HDD</title>
<link rel="stylesheet" type="text/css" href="../../xmp.css" />
<body>
<pre>
<?php

$retval = 1;

$fs_sda1 = exec("mount | grep /dev/scsi/host0");
if( $fs_sda1 ){
   echo "Format internal HDD in ext3 file system started....";
   echo "Please wait until procedure is finished. Do not reset or unpower the device!";
   echo "Do not reload page! The page reloads automatically!";
   echo "";
  
   flush();
   system('./format.sh', $retval);
   ?>
   <script language="javascript" type="text/javascript">
       alert("Done. System will reboot. Please wait the page reloads automatically.");
       var auto_reload = setInterval(
                           function (){
                              window.location.href = "../../index.php"; 
                           }, 30000);     
   </script>
   <?
   system("reboot");
}else
   echo "internal HDD not found !?";


if ( $retval == "0") echo 'Done. System will reboot'; else echo 'Failed! Please reboot and try again!';
?>

<pre>
</body>
</html>