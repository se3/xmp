<?
error_reporting(0);
include '/tmp/lang.php';
	$cmd = "ps -aux | grep stupid-ftpd";
	exec($cmd, $output, $result); 
	if (count($output) > 2){ 
		//already running....
?>
		<script language=javascript>
			parent.document.FTPservice.start.disabled=true;
			parent.document.FTPservice.stop.disabled=false;
			parent.document.ftpport.ftpport.disabled=false;
			parent.document.ftpport.saveftpport.disabled=false;
			
		</script>
<? }else{ ?>
		<script language=javascript>
			parent.document.FTPservice.start.disabled=false;
			parent.document.FTPservice.stop.disabled=true;
			parent.document.ftpport.ftpport.disabled=true;
			parent.document.ftpport.saveftpport.disabled=true;
			
		</script>
<?
	}
?>