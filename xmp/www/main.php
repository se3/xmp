<?
$result = 1;
if ( file_exists( "/sbin/www/xmproot/xmp" ) ){
   $result = 0;
}
else if ( chdir("..") ) {
   $xmppath =  getcwd();
   
   system("rm /sbin/www/xmproot", $result);
   system("rm /sbin/www/xmp", $result);
   system("ln -s $xmppath /sbin/www/xmproot", $result);
   system("ln -s /sbin/www/xmproot/xmp /sbin/www/xmp", $result);
}
?>
<h2>Welcome to the Xtreamer Mod Pack.</h2>
<p>You can customize your mediabox, and can do lots of more things.</p>
<p>Enjoy it! :)</p>
<?
if ($result == 0){
   echo"<p>XMP is now reachable on address http://myxtreamer/xmp</p>\n";
}
?>