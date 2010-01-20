<?php
echo '<pre>';
system('./init_ssh.sh', $retval);
echo '</pre>';
if ( $retval == "0") echo 'SSHD start done. Login: root without password.'; else echo 'Failed!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
