<?php
echo '<pre>';
system('unzip -o original.zip -d /sbin/', $retval);
echo '</pre>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Xtreamer Mod Pack - Skin</title>
<link rel="stylesheet" type="text/css" href="../../xmp.css">
<body>
<META HTTP-EQUIV=Refresh CONTENT="30; URL=../../info.php">
<?

if ( $retval == "0") echo 'Hotpug restore done.'; else echo 'Hotplug restore failed!';

?>
</body>
</html>