<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Xtreamer Mod Pack - Skin</title>
<link rel="stylesheet" type="text/css" href="../xmp.css">
<body onload="parent.mainFrame.location.reload();">
   <pre>
<?php
$ip = "127.0.0.1";

system('ln -s /mnt/usbmounts/sda1/xmp/x_live /sbin/www/x_live', $result);

$data = "127.0.0.1\tlocalhost\n". $ip."\tlive.mvix.net";
$command ="wget -P /tmp http://".$ip. "/x_live/WAN_OK";

exec($command, $output, $result);

if ($result == 1){
	echo "<script>alert('Failed! Please check your network connection or script path!');</script>";
}else{
     $file = fopen("/etc/hosts", "w");
     if (!fwrite($file, $data)) {
   	   echo "<script>alert('Network Error! Please try again.');</script>";
     }
     fclose($file);
}
if ( $result == "0") echo 'Done.'; else echo 'Failed!';

?>
</pre>
<META HTTP-EQUIV=Refresh CONTENT="30; URL=../info.php">
</body>
</html>
