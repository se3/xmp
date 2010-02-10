<?php
echo '<pre>';
system('/opt/local/bin/dctcs -c /opt/etc/dctcs.conf & ', $retval);
echo '</pre>';
if ( $retval == "0") echo 'Done.'; else echo 'Failed!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
