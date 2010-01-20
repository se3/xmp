<?php
echo '<pre>';
if (file_exists('/tmp/ntpdate.log')) {
echo 'System time: ';
system('date');
} else echo 'System time: Not syncronized yet! </br>';
system('df -h');
echo '</pre>';
?>

