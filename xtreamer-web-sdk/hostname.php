<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';

$hostInput = $_POST['host'];
$firstchar = substr($hostInput, 0, 1);


if (ctype_alnum($hostInput)){
	if (!is_numeric($firstchar)){
		exec('hostname '.$hostInput);

		$filename = "/etc/hostname";
		$fp = fopen($filename, 'w');
		fwrite($fp, $hostInput);
		fclose($fp);

		exec('/usr/local/daemon/script/samba restart');
		
		echo "<script>alert('Hostname changed successfully.');</script>";
		echo "<script>parent.window.location.reload();</script>";
	}else{
		echo "<script>alert('First character should not be a number!');</script>";
		echo "<script>loadDivEl = parent.document.getElementById('loadDiv');
					loadDivEl.style.visibility = 'hidden';</script>";
		echo "<script>parent.document.ddns.host.focus();</script>";
	}

}else{
		echo "<script>alert('Please insert only alphanumeric characters!');</script>";
		echo "<script>loadDivEl = parent.document.getElementById('loadDiv');
					loadDivEl.style.visibility = 'hidden';</script>";		
		echo "<script>parent.document.ddns.host.focus();</script>";
}

?>
