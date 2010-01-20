<?php
echo '<pre>';
system('/opt/sbin/hdparm -E 1 /dev/dvd', $retval);
echo '</pre>';
if ( $retval == "0") echo 'Done.'; else echo 'Failed!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
