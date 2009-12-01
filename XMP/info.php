<html>

<head>
<title>drive info</title>
<link rel="stylesheet" type="text/css" href="xmp.css">
</head>
<META HTTP-EQUIV=Refresh CONTENT="120; URL=info.php">
<body>

<?php
echo '<pre>';
if (file_exists('/tmp/ntpdate.log')) {
echo 'System time: ';
system('date');
} else echo 'System time: Not syncronized yet! </br>';
system('df -h');
echo '</pre>';
?>

</body>

</html>