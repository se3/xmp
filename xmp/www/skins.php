<?
$skinpath = "../skins";
if( ! file_exists( "/opt/bin/zip" ) )
{
   system("/opt/bin/ipkg install zip");
}
$versionfile ="$skinpath/original/version.txt";
$extractpath = "/usr/local/bin/Resource/bmp/";

$skin = $_GET[skin];
$original = $_GET[original];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Skin browser</title>
<link rel="stylesheet" type="text/css" href="../xmp.css">
</head>
<body>
<?


if ( "backup" == $original ) 
{
   // check if original backup is too old:
   // cat /usr/local/etc/dvdplayer/XTR_setup.dat
   // // ♥ý VER 2.1.2☺☺dddddddddddd¶☺☺☺☺☺d☺☺☺☺/tmp/usbmounts/sda1/xmp/www
   $versionstring = file_get_contents("/usr/local/etc/dvdplayer/XTR_setup.dat");
   $version = substr($versionstring, strpos($versionstring, "VER")+4, 5);
   
   $backup = 0;
   if ( file_exists( $versionfile ) )
   {
      if ( $version != file_get_contents("$skinpath/original/version.txt") )
      {
         $backup = 1;      
      } 
   }
   else
   {
      $backup = 1; 
   }
      
   if ( 1 == $backup )
   {
      echo ' <META HTTP-EQUIV=Refresh CONTENT="2; URL=skins.php">';
      echo "<pre>";
      system("rm $skinpath/original/original.zip" );
      system("/opt/bin/zip $skinpath/original/original.zip /usr/local/bin/Resource/bmp/*.bmp ", $retval );
      if ( $retval == "0") system("echo $version > $skinpath/original/version.txt");
      echo "</pre>";
       
   }
}


if ( "" != $skin  )
{
   echo ' <META HTTP-EQUIV=Refresh CONTENT="10; URL=skins.php">';
   if ( file_exists( "$skinpath/$skin/$skin.zip" ) )
   {
      echo '<pre>';
      echo "perform : unzip -o $skinpath/$skin/$skin.zip -d $extractpath<br>\n";
      system("unzip -o $skinpath/$skin/$skin.zip -d $extractpath", $retval);
      echo '</pre>';
      if ( $retval == "0") echo 'Install done.'; else echo 'Install failed!';
   }
   else
   {
      echo "file $skinpath/$skin/$skin.zip not found";
   }
}
else
{

// check if original backup is too old:
// cat /usr/local/etc/dvdplayer/XTR_setup.dat
// // ♥ý VER 2.1.2☺☺dddddddddddd¶☺☺☺☺☺d☺☺☺☺/tmp/usbmounts/sda1/xmp/www
$versionstring = file_get_contents("/usr/local/etc/dvdplayer/XTR_setup.dat");
$version = substr($versionstring, strpos($versionstring, "VER")+4, 5);

$backup = 0;
if ( file_exists( $versionfile ) )
{
   $foundversion = rtrim( file_get_contents($versionfile) );
   if ( $version != $foundversion )
   {
      echo "New Version found : $foundversion, expected: $version<br>\n";
      $backup = 1;      
   } 
}
else
{
   echo "versionfile: $versionfile not found!<br>\n";
   $backup = 1; 
}
   
if ( 1 == $backup && "backup" != $original )
{
   echo ' <META HTTP-EQUIV=Refresh CONTENT="2; URL=skins.php?original=backup">';
   echo "Please wait, original skin backup running...it take about 30 seconds<br>\n";  
}
else
{   
   ?>  
      <table align="center">
      <tr>
      <td  align="center"><h1>Skin Browser</h1><br>
      <?
      $dir = @ dir("../skins/");
      while (($file = $dir->read()) !== false)
      {
        if ($file <> ".") if ($file <> "..")
        {
           echo "<h1>$file</h1>\n<br>\n";
           echo "<a href=\"skins.php?skin=$file\" target=\"bottomFrame\"><img src=\"$skinpath/$file/$file.jpg\" align=\"absmiddle\" /></a>\n<br>\n";
        }
      }
      $dir->close();
      ?>
      </td>
      </tr>
      </table>
   <?
   }
} // 

?>
</body>
</html>