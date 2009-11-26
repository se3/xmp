<?
error_reporting(0);
	$cmd = "ps -aux | grep DvdPlayer";
	exec($cmd, $output, $result); 
	if (count($output) > 2){ 
?>
		<script language=javascript>
			parent.document.write_form.Button1.disabled=false;
		</script>
<? }else{ ?>
		<script language=javascript>
			parent.document.write_form.Button1.disabled=true;
		</script>
<?}
?>