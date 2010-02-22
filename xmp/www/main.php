<h2>Welcome to the Xtreamer Mod Pack.</h2>
<p>You can customize your mediabox, and can do lots of more things.</p>
<p>Enjoy it! :)</p>
<?
$xmppath =  getcwd();
chdir("..");
$xmproot =  getcwd();

if( file_exists("/sbin/www/xmp") && file_exists("/sbin/www/xmproot") ){
   if ( $xmproot == readlink("/sbin/www/xmproot") ){
      echo"<p>XMP is installed on $xmproot and reachable on address http://myxtreamer/xmp</p>\n";
   }else{
      echo "$xmproot - ".readlink("/sbin/www/xmproot") ;
      
      echo"<p>XMP is already installed on ".readlink("/sbin/www/xmproot")." and reachable on address http://myxtreamer/xmp</p>\n";
      echo"<p>Please perform base uninstall if you want use XMP on this drive</p>\n";
   }
}else{
   echo"<p>XMP without base install detected. You can use Fakeshell and skins without base install.</p>\n";
}

?>
