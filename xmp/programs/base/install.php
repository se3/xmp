<?php
$installpath  = $_GET[installpath];
echo '<pre>';
system('./install_base.sh '. $installpath, $retval);
echo '</pre>';
if ( $retval == "0") echo 'Done.'; else echo 'Failed!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
