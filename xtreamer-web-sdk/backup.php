<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
	//copy("/usr/local/etc/setup.php", "/tmp/usbmounts/sda1/.MVIXLive/setup_bak.php" );
	//copy("/usr/local/etc/stupid-ftpd.conf", "/tmp/usbmounts/sda1/.MVIXLive/stupid-ftpd.conf" );
	copy("/usr/local/etc/setup.php", "/usr/local/etc/setup_bak.php" );
	copy("/usr/local/etc/stupid-ftpd.conf", "/usr/local/etc/stupid-ftpd_back.conf" );
	copy("/etc/hosts", "/etc/hosts_back" );
	copy("/usr/local/etc/nfs", "/usr/local/etc/nfs_back" );
	
	echo "<script>alert('$STR_BackupSuccess');</script>";
?>