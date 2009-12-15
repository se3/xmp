<?
$streameripper = "/opt/bin/streamripper";
$stream = "http://213.251.169.142:8000";
$savedir = "-d /tmp/usbmounts/sda1/download";
$filemax = "-M 500";

$streamlog = $_POST[streamlog];
if ( "" == $streamlog ) { $streamlog = "/tmp/usbmounts/sda1/streamer.txt"; }


if ( file_exists( $streamlog ) )
{
   $stack = explode("\n", file_get_contents($streamlog) );
       
   # empty the debug output file
   @exec('echo "\n" > '.$streamlog );
   
   $ripstatus = array_pop($stack);
}
else
{
   $ripstatus = "[-] waiting... [-]";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Main page</title>
<META HTTP-EQUIV=Refresh CONTENT="3; URL=streamlog.php">
<link rel="stylesheet" type="text/css" href="xmp.css">
<body bgcolor=black style="margin: 0px;">
 
<pre style="margin:auto; color:#00FF00;">
<?  
if ( 4 == substr_count($ripstatus, "[") )
{
   echo $ripstatus[ strlen($ripstatus)/2 ];
}
else if ( 2 == substr_count($ripstatus, "[") )
{
   echo $ripstatus;
}
else
{
   echo "please wait......";
}
?>
</pre>

</body>
</html>
