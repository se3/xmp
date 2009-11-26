<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';

	if (copy("/usr/local/etc/setup_bak.php", "/usr/local/etc/setup.php")){
		copy("/usr/local/etc/stupid-ftpd_back.conf", "/usr/local/etc/stupid-ftpd.conf");

		$filename = "/etc/hosts_back";
		$fp = fopen($filename, 'r');
		$fileData = fread($fp, filesize($filename));
		fclose($fp);

		$file1 = fopen("/etc/hosts", "w");
		fwrite($file1, $fileData);
		fclose($file1);
		
		
		copy("/usr/local/etc/nfs_back", "/usr/local/etc/nfs" );
		echo "<script>alert('$STR_RestoreSuccess');</script>";
		shell_exec('reboot');
		echo "<script>parent.window.location.href='register_form.php';</script>";
	}
?>