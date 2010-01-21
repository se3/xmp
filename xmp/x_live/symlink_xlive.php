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
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
