<?php
echo '<pre>';
system('chmod 755 /etc/init.d/S228dctcs', $retval);
echo '</pre>';
if ( $retval == "0") echo 'Done.'; else echo 'Failed!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
