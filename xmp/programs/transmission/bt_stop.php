<?php
echo '<pre>';
system('chmod 644 /etc/init.d/S227transmission', $retval);
echo '</pre>';
if ( $retval == "0") echo 'Done.'; else echo 'Failed!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
