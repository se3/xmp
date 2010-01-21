   <pre>
<?php
$userid = $_GET[userid];
// http://gdata.youtube.com/feeds/api/videos?vq=%s&amp;orderby=relevance&amp;format=5&amp;start-index=1&amp;max-results=20";
 // http://gdata.youtube.com/feeds/api/videos?vq=HD&orderby=relevance&format=5&start-index=1&max-results=20
$result = 1;
$rss = "/sbin/www/x_live/scripts/flickr_personal.rss";
$rss_content = file_get_contents( $rss );
$userid_old = '12345678@N06';

if ( 12 == strlen( $userid ) && 1 == substr_count( $userid, 'N06' ) )
{
   
   if(file_exists("userid"))
   {
      exec("cat userid" , $userid_old, $result);
      system( "echo $userid > userid", $result);
   }
   else
   {
      system( "echo \"$userid\" > userid", $result);
   }
   
   $search = $userid_old[0];
   $replace = $userid;
   $new_rss_content = str_replace( $search, $replace, $rss_content );
   
    $file = fopen($rss, "w");
   if (!fwrite($file, $new_rss_content)) {
      echo "<script>alert('Network Error! Please try again.');</script>";
   }
   else
   {
      $result = 0;
   }
   fclose($file);
}
else
{
   echo "Invalid string Flickr user id has format: 12345678@N06 - count: ".substr_count( $userid, 'N06' ) ."\n";
}
if ( $result == "0") echo "Done: userid = $userid"; else echo 'Failed!';

?>
</pre>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
