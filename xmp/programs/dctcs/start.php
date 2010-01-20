<?php
echo '<pre>';
system('/usr/local/bin/dctcs & ', $retval);
echo '</pre>';
if ( $retval == "0") echo 'Done.'; else echo 'Failed!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
