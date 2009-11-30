<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);

$data = "127.0.0.1\tlocalhost\n210.109.97.109\tlive.mvix.net";
  //echo $data;

  $file = fopen("/etc/hosts", "w");
  if (!fwrite($file, $data)) {
	echo "<script>alert('Network Error! Please try again.');</script>";
  }  
  fclose($file);

  echo "<script>parent.window.location.href='setup_live_keyword.php'; </script>";
?>
