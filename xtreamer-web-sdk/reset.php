<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
	copy("/sbin/www/setup.php", "/usr/local/etc/setup.php");
	copy("/sbin/www/stupid-ftpd.conf", "/usr/local/etc/stupid-ftpd.conf");
	unlink("/usr/local/etc/nfs");
	
	$data1 = "127.0.0.1\tlocalhost\n210.109.97.109\tlive.mvix.net";
	$file1 = fopen("/etc/hosts", "w");
	fwrite($file1, $data1);
	fclose($file1);

		echo "<script>alert('$STR_ResetSuccess');</script>";
		shell_exec('reboot');
		echo "<script>parent.window.location.href='register_form.php';</script>";
	
?>