<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
$ip = $_POST['ip'];

$data = "127.0.0.1\tlocalhost\n". $ip."\tlive.mvix.net";

$command ="wget -P/tmp http://".$ip. "/x_live/WAN_OK";

exec($command, $output, $result);

if ($result == 1){
	echo "<script>alert('Failed! Please check your network connection or script path!');</script>";
	echo "<script>parent.window.location.href='setup_live_keyword.php'; </script>";
}else{
  
  $file = fopen("/etc/hosts", "w");
  if (!fwrite($file, $data)) {
	echo "<script>alert('Network Error! Please try again.');</script>";
  }  
  fclose($file);
  echo "<script>parent.window.location.href='setup_live_keyword.php'; </script>";
}
	//echo "<script>parent.window.location.href='setup_live_keyword.php'; </script>";
?>
