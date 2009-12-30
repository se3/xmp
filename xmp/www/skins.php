<?
$skinpath = "../skins";
$versionfile ="$skinpath/original/version.txt";
$extractpath = "/usr/local/bin/Resource/bmp/";

$skin = $_GET[skin];
$original = $_GET[original];
$online = $_GET[online];
$skinpage = "http://xtreamer-web-sdk.googlecode.com/svn/trunk/xmp/skins";

function getNewSkins()
{
   @exec("ping google.de", $retval);
   
   //echo "------ ". substr_count( $retval[0] , "is alive!") . "-- $retval[0] ----";

   if ( substr_count( $retval[0] , "is alive!") == 1) 
   {  
      global $skinpage, $skinpath;
      $filecontent = explode("\n", @file_get_contents( $skinpage ) );
      
      foreach( $filecontent as $line ){
         list($key, $val) = explode("<li><a href=\"", $line );
         if( $key != "" && $val ){
            list($skin, $val) = explode("/\"", $val );
            $skin =str_replace("%20", " ", $skin);
            if( "" != $skin && ".." != $skin && ! file_exists( "$skinpath/$skin/$skin.zip" ) ) 
            {
               echo "***  $skin *** \n<br>";
               echo "<a href=\"skins.php?skin=$skin&online=y\" target=\"bottomFrame\"><img src=\"$skinpage/$skin/$skin.jpg\" align=\"absmiddle\" /></a>\n<br>\n";
            }
         }
      }
   }
}

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
      system("./zip $skinpath/original/original.zip /usr/local/bin/Resource/bmp/*.bmp ", $retval );
      if ( $retval == "0") system("echo $version > $skinpath/original/version.txt");
      else  echo " cmd (\"zip $skinpath/original/original.zip /usr/local/bin/Resource/bmp/*.bmp \"\ failed<br>\n"; 
      echo "</pre>";
       
   }
}


if ( "" != $skin  )
{
   $retval = "0";
   if ( "y" == $online )
   {
      system("mkdir $skinpath/$skin", $retval );
      system("wget '$skinpage/$skin/$skin.zip' -O $skinpath/$skin/$skin.zip", $retval);
   }

   if ( $retval == "0") 
   {  
      echo ' <META HTTP-EQUIV=Refresh CONTENT="10; URL=../info.php">';
      if ( file_exists( "$skinpath/$skin/$skin.zip" ) )
      {
         echo '<pre>';
         echo "perform : unzip -o $skinpath/$skin/$skin.zip -d $extractpath<br>\n";
         system("unzip -o '$skinpath/$skin/$skin.zip' -d $extractpath", $retval);
         echo '</pre>';
         if ( $retval == "0") { echo 'Install done.'; }else{ echo 'Install failed!'; }
      }
      else
      {
         echo "file $skinpath/$skin/$skin.zip not found";
      }
   }
   else
   {
      echo "file download wget -o '$skinpage/$skin/$skin.zip' -O $skinpath/$skin/$skin.zip failed - $retval";
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
      
   if ( 1 == $backup && "backup" != $original  )
   {
      if ( file_exists( "zip" ) )
      {
         echo ' <META HTTP-EQUIV=Refresh CONTENT="2; URL=skins.php?original=backup">';
         echo "Please wait, original skin backup running...it take about 20 seconds<br>\n";  
      }
      else
      {
         echo "zip application not found in xmp/www !";
      }
   }
   else
   {   
      ?>  
      <table align="center">
      <tr>
      <td  align="center"><h1>Skin Browser</h1><br>
      <?
      getNewSkins();
      $dir = @ dir("../skins/");
      while (($file = $dir->read()) !== false)
      {
        if ($file != "." && $file != ".." && file_exists( "../skins/$file/$file.zip" ) )
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
