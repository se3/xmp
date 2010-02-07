<?
$streameripper = "/opt/bin/streamripper";
$savedir = "-d /sbin/www/xmproot/download ";
$filemax = "-M 500 ";
$streamlog = $_POST[streamlog];
if ( "" == $streamlog ) { $streamlog = "/sbin/www/xmproot/streamer.txt"; }
$url = $_POST[streamurl];
$param= $_POST[streamripparam];
$plspath= $_POST[playlist];
$streamname= $_POST[streamname];
if ( "" == $streamname ) { $streamname = "Welcome to my personal streamripper station (note: Y! mediaplayer work only with mp3 streams, streamripper works with most media streams)"; }
if ( ! file_exists( $streameripper ) )
{
   $streamname = "Install streamripper with IPKG Web";   
}

$stop = $_POST[stop];

if( ! is_dir( $plspath) )
{
   $plspath = "/usr/local/Live_Radio";   
}

if( "stop" == $stop )
{
   @exec("killall streamripper");
}
else if ( file_exists( $streameripper ) )
{
   # stream rip is ongoing?
   if( "" != $url)
   {
      if( "" == $param)
      {
         $param = $savedir.$filemax;
      }
      @exec("killall streamripper");
      
      system("$streameripper $url $param > $streamlog &");
   }
}

?>

<script type="text/javascript" src="simpletreemenu.js">

/***********************************************
* Simple Tree Menu- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<script type="text/javascript">
   
   function selectstream( stream, name )
   {
      <? 
      if ( ! file_exists( $streameripper ) )
      {
         echo 'alert(" Install streamripper \'/opt/bin install streamripper\' if you want rip this stream");';         
      }
      ?>
      if( "" == stream || '' == name )
      {
         alert("empty stream, select another...!");
         return false;
      }
      else
      {
         document.getElementById("streamname").firstChild.nodeValue = name;
         document.forms[0].streamurl.value = stream;
         document.forms[0].streamname.value = name;
         return true;
      }
   }

</script>
<link rel="stylesheet" type="text/css" href="simpletree.css" />

<script type="text/javascript" src="http://mediaplayer.yahoo.com/js"></script>

<form name="streamrip" method="post" action="<? echo $PHP_SELF; ?>">
   <span style="width:6600px;font-size:10px;">Stream URL ( e.g.: http://XXX.XXX.XXX.XXX:8000 )</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="width:300px;font-size:10px;">- streamripper [OPTIONS] see below(leave empty for default: "-d /sbin/www/xmproot/download -M 500")</span>
   <br><input type=text name="streamurl" size=50 value="http://scfire-dtc-aa05.stream.aol.com:80/stream/1035"/> - <input type=text name="streamripparam" size=50 value=""/>
   <input type="hidden" name="streamname" value="<? echo $streamname ; ?>">
   <input type="hidden" name="streamlog" value="<? echo $streamlog ; ?>">
   <input type="submit" value=" rip stream ">
</form>
<div id="streamname" style="color:#00FF00;"><? echo $streamname; ?></div>
<iframe style="-moz-border-radius:6px;border:3px #00FF00 groove;margin:5px;" src="streamlog.php?streamlog=<? echo $streamlog ; ?>" name="myiframe" scrolling="no" frameborder="0" align=left marginheight="1px" marginwidth="1px" height="20" width="600"></iframe>
<form  style="-moz-border-radius:6px;border:0px #00FF00 groove;margin:6px;" name="streamrip2" method="post" action="<? echo $PHP_SELF; ?>">
   <input type=hidden name="stop" size=15 value="stop"/>
   <input type="submit" value=" abort rip ">
</form>
<form name="plsxpath" method="post" action="<? echo $PHP_SELF; ?>">
   <input type=text name="playlist" size=50 value="<? echo $plspath; ?>"/> 
    <input type="submit" value=" change playlist root ">

</form><br>
<table >
<tr align=left><td valign=top>

<a href="javascript:ddtreemenu.flatten('treemenu1', 'expand')">Expand All</a> | <a href="javascript:ddtreemenu.flatten('treemenu1', 'contact')">Contact All</a>
<ul id="treemenu1" class="treeview">
<?

//using the opendir function
$dir_handle = @opendir($plspath) or die("Unable to open $plspath");

function getStreamAndName( $file )
{
   //[playlist]
   //numberofentries=1
   //File1=http://mp3uplink.duplexfx.com:8000/
   //Title1=181.FM - Awesome 80's (128)
   //Length1=-1

   $filecontent = explode("\n", @file_get_contents( $file ) );
   
   $stream = "";
   $title = "";
   
   foreach( $filecontent as $line ){
      list($key, $val) = explode("=", $line );
      if( $key != "" && $val ){
         if( "File1" == $key ){
            $stream = $val;
         }
         if( "Title1" == $key ){
            $title = $val;      
         }
         if ( $stream != "" &&   $title != ""){
            return '"'.$stream.'","'.$title.'"';
         }
      }
   }
   
   if( "" != $stream ){
      return '"'.$stream.'","'.basename($file).'';
   }
   
   return "";
}

function list_dir($dir_handle,$path)
{
    while (false !== ($file = readdir($dir_handle))) {
        $dir =$path.'/'.$file;
        if(is_dir($dir) && $file != '.' && $file !='..' )
        {
            $handle = @opendir($dir) or die("undable to open file $file");            
            echo "<li>$file<ul>\n";
            list_dir($handle, $dir);
            echo "</ul></li>\n";
        }elseif($file != '.' && $file !='..')
        {
            $selectstream = getStreamAndName("$path/$file");
            if( "" != $selectstream )
            {
               $musicfiles = explode(",", $selectstream );
               echo '<li><a type="audio/mpeg" onclick=\'selectstream('. $selectstream .');\' href='.trim( $musicfiles[0]).' >'.$file.'</a></li>'."\n";          
            }
        }
    }    
    //closing the directory
    closedir($dir_handle);   
}



//echo "Directory Listing of $path<br/>";

list_dir($dir_handle,$plspath);

?>
</ul>

<script type="text/javascript">

//ddtreemenu.createTree(treeid, enablepersist, opt_persist_in_days (default is 1))

ddtreemenu.createTree("treemenu1", false)
ddtreemenu.createTree("treemenu2", false)

</script>

</td>
<td valign=top>
   
<pre>
   <? echo system("/opt/bin/streamripper"); ?>
</pre>
</td></tr></table>
