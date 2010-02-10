<?
$skinpath = "skins";
$versionfile ="$skinpath/original/version.txt";
//$versionfile ="skins/original/version.txt";
$extractpath = "/usr/local/bin/Resource/bmp/";

$skin = $_GET[skin];
$urlskin = rawurlencode($skin);
$mdskin = str_replace(" ", "\ ", $skin);
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
      $counter = 0;
      echo "<tr>";
      foreach( $filecontent as $line ){
         list($key, $val) = explode("<li><a href=\"", $line );
         if( $key != "" && $val ){
            list($skin, $val) = explode("/\"", $val );
            $skin =str_replace("%20", " ", $skin);
            if( "" != $skin && ".." != $skin && ! file_exists( "$skinpath/$skin/$skin.zip" ) && ! file_exists( "$skinpath/$skin/$skin.tar.gz" ) ) 
            {
               echo "<td align=\"center\">***  $skin *** \n<br>\n"; // the online skin name format should differ to local skin name format <h1> is too big
               echo "<a href=\"?page=skins&info=skins.php&skin=$skin&online=y\"><img src=\"$skinpage/$skin/$skin.jpg\" width=\"500\" /></a></td>\n";
               if ( $counter++ %2 )
               {
                  echo "</tr><tr>\n";
               }
            }
         }         
      } // end foreach
      echo "</tr>";
   }
}

?>

<?

if ( "" != $skin  )
{
   $retval = "0";
   if ( "y" == $online )
   {
      system("mkdir $skinpath/$mdskin", $retval );
      system("wget '$skinpage/$urlskin/$urlskin.zip' -O $skinpath/$mdskin/$mdskin.zip", $retval);
      system("wget '$skinpage/$urlskin/$urlskin.jpg' -O $skinpath/$mdskin/$mdskin.jpg", $retval);
   }

   if ( $retval == "0") 
   {  
      if ( file_exists( "$skinpath/$skin/$skin.zip" ) )
      {
         echo '<pre>';
         echo "perform : unzip -o $skinpath/$skin/$skin.zip -d $extractpath<br>\n";
         system("unzip -o '$skinpath/$skin/$skin.zip' -d $extractpath", $retval);
         echo '</pre>';
         if ( $retval == "0") { echo 'Install done.'; }else{ echo 'Install failed!'; }
      }
      else if ( file_exists( "$skinpath/$skin/$skin.tar.gz" ) )
      {
         echo '<pre>';
         echo "perform : ./busybox tar -xzvf '$skinpath/$skin/$skin.tar.gz' -C /<br>\n";
         system("./busybox tar -xzvf '$skinpath/$skin/$skin.tar.gz' -C /", $retval);
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
      echo "file download wget '$skinpage/$urlskin/$urlskin.zip' -O $skinpath/$mdskin/$mdskin.zip failed - $retval";
   }
}
else
{

   // check if original backup is too old:
   // cat /usr/local/etc/dvdplayer/XTR_setup.dat
   // content of XTR_setup.dat: ♥ý VER 2.1.2☺☺dddddddddddd¶☺☺☺☺☺d☺☺☺☺/tmp/usbmounts/sda1/xmp/www
   $versionstring = file_get_contents("/usr/local/etc/dvdplayer/XTR_setup.dat");
   $version = substr($versionstring, strpos($versionstring, "VER")+4, 3);
   
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
      
   if ( 1 == $backup )
   {
      if ( file_exists( "./busybox" ) )
      {
         echo "Please wait, original skin backup will start... It takes about 2 minutes<br>\n";        
         flush();
         echo "<pre>";
         if (! file_exists("$skinpath/original") )  {
            system("mkdir $skinpath/original" );        
            system("wget '$skinpage/original/original.jpg' -O $skinpath/original/original.jpg");    
         }
         if (! file_exists("$skinpath/original/original.jpg") )  {    
            system("wget '$skinpage/original/original.jpg' -O $skinpath/original/original.jpg");    
         }
         
         if (! file_exists("$skinpath/original/original.tar.gz") )  {
            system("rm -f $skinpath/original/original.tar.gz" );
         }

         system("./busybox tar -czvf $skinpath/original/original.tar.gz $extractpath*.bmp", $retval );
         if ( $retval == "0") system("echo $version > $skinpath/original/version.txt");
         else  echo " cmd (\"./busybox tar -czvf $skinpath/original/original.tar.gz $extractpath*.bmp \" failed<br>\n";
         echo '<META HTTP-EQUIV=Refresh CONTENT="1; URL=?page=skins.php">';
         flush();
         echo "</pre>";
      }
      else
      {
         echo "busybox application not found in xmp !";
      }
   }
   else
   {   
      ?>  
      <table align="left">
      <tr>
      <th colspan="2" align="center"><h1>Skin Browser</h1></th>
      </tr>
      <?
      getNewSkins();
      $dir = @ dir("skins/");
      $counter = 0;
      echo "<tr>";
      while (($file = $dir->read() ) !== false)
      {
        if ($file != "." && $file != ".." && (file_exists( "$skinpath/$file/$file.zip") || file_exists( "$skinpath/$file/$file.tar.gz" ) ) )        {
           echo "<td align=\"center\"><h1>$file</h1>\n<br>\n";
           echo "<a href=\"?page=skins&info=skins.php&skin=$file\"><img src=\"$skinpath/$file/$file.jpg\" width=\"500\" align=\"absmiddle\" /></a>\n</td>\n";
        }
        if ($counter %2)        {
         echo "</tr><tr>";
        }
        $counter ++;
      }      
      $dir->close();
      ?>
      </tr>
      </table>
   <?
  }
} // 

?>
