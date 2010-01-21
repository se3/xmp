<?

$ripstatus = "";

$streamlog = $_POST[streamlog];
if ( "" == $streamlog ) { $streamlog = "/tmp/usbmounts/sda1/streamer.txt"; 


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
