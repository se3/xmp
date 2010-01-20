<?php
echo '<pre>';
system('killall sshd', $retval);
echo '</pre>';
if ( $retval == "0") echo 'SSHD stop done.'; else echo 'Failed!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
