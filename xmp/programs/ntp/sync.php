<?php
$installpath = $_GET[installpath];
echo '<pre>';
echo $installpath;
system('/opt/bin/ntpdate -t 25 pool.ntp.org', $retval);
echo '</pre>';
if ( $retval == "0") echo 'Done.'; else echo 'Failed!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
