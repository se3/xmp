<?
error_reporting(0);
	$cmd = "ps -aux | grep DvdPlayer";
	exec($cmd, $output, $result); 
	if (count($output) > 2){ 
?>
		<script language=javascript>
			parent.document.write_form.Button1.disabled=false;
			//parent.document.write_form.Button2.disabled=true;
		</script>
<? }else{ ?>
		<script language=javascript>
			parent.document.write_form.Button1.disabled=true;
			//parent.document.write_form.Button2.disabled=false;
		</script>
<?}
?>