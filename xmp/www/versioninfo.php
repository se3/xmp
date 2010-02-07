<?

###########################
# add the application version here
# new proginfo( 'ProgrammName', 'Program Location',  'Version Call', 'pipe for filter version information' );

$program[] = new proginfo( 'Linux Kernel Version', '/proc/version', 'cat /proc/version' );
$program[] = new proginfo( 'BusyBox', '/bin/busybox', '/bin/busybox', "grep 'BusyBox v' ");
if( file_exists( '/opt/bin/busybox' ) )
   $program[] = new proginfo( 'BusyBox', '/opt/bin/busybox', '/opt/bin/busybox', "grep 'BusyBox v' ");
if( file_exists( '/sbin/www/xmp/busybox' ) )
   $program[] = new proginfo( 'BusyBox', '/sbin/www/xmp/busybox', '/sbin/www/xmp/busybox', "grep 'BusyBox v' ");

//$program[] = new proginfo( 'PHP', '/sbin/www/php', '/sbin/www/php -v', "grep built:" ); // php info not possible, php hangs after this call
$program[] = new proginfo( 'a light and fast webserver', '/sbin/www/lighttpd', '/sbin/www/lighttpd -v');


###########################












echo "\n<table border=\"3\" frame=\"box\" style=\"font-size: 10px; padding:0px; margin:15px;\" >\n";
echo "<tr><th>Progname</th><th>Location</th><th>Versioninfo</th></tr>\n";
$i = 0;
while( $i < count($program) )
{
   echo "<tr><td style=\"padding:5px; font-size: 10px;\">".$program[$i]->pname()."<td style=\"padding:5px; font-size: 10px;\">".$program[$i]->ppath()."</td><td style=\"padding:5px; font-size: 10px;width:200px\" >".$program[$i]->pversion()."</td></tr>\n";
   $i++;   
}
echo "</table>\n";






class proginfo
{
   var $progname;
   var $path;
   var $version;
   function proginfo($n, $p, $versioncall, $pipe = "")   {
      
      $this ->progname = $n;
      $this ->path = $p;
      
      if ("" == $pipe){
         @exec( $versioncall, $tmp );
         $this ->version = implode("<br>", $tmp);
      }
      else {
         @exec( "$versioncall | $pipe", $tmp );
         $this ->version = implode("<br>", $tmp);
      }
      //echo "\ncreation proginfo $n, $p, $versioncall, $pipe\n#". $this ->progname." \n#".  $this ->path ." \n#".  $this ->version ."\n<br>\n";
   }
   
   function pname( )  { return $this ->progname; }   
   function ppath( )    { return $this ->path;         }   
   function pversion( ){ return $this ->version;    }    
}

?>

<p><a href="?page=package.php&typefilter=installed&submit=submit" title="call IPKG package installer">list installed optware applications</a></p>
