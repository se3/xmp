<?php 
   //$xmp_root = getcwd();
   $optdir = file_exists('/opt'); 
   $xlive = file_exists('/sbin/www/x_live/WAN_OK'); 
      
   $userid = "12345678@N06";
   $useridpath = "x_live/userid";
   $pwd = exec("pwd | awk 'match($0,/\/sd[a-d][0-9]?\//){print substr($0,RSTART+1,RLENGTH-2)}'");
   $ext3 = exec("mount | grep $pwd | awk '{ print $5 }'");
   $busyboxbin = "/tmp/usbmounts/$pwd/xmp/busybox";
   
   
   function plot_prog_all( $optdir, $progname, $prognamefull, $installmsg, $xmpsubpath, $progbinary,  $psname, $bootscript, $editmsg, $editconfig, $runcheck )
   {
      echo "<tr><td align=\"left\">\n";
      plot_prog_install( $progname, $xmpsubpath, $progbinary, $optdir );
      echo "</td><td align=\"center\">\n";
      plot_prog_start( $prognamefull, $xmpsubpath, $psname, $progbinary );
      echo "</td><td align=\"center\">\n";
      plot_running_status( $psname );
      echo "</td><td align=\"center\">\n";
      plot_boot_status( $bootscript );
      echo "</td><td align=\"center\">\n";
      plot_enable( $bootscript, $xmpsubpath );
      echo "</td><td align=\"center\">\n";
      plot_edit_config( $editmsg , $editconfig, $runcheck );
      echo "</td></tr>\n";
   }
   
   function plot_prog_install( $progname, $progpath, $progcheck, $optdir )
   {
      $progexist = file_exists($progcheck);         
      echo $progname.'</td><td align="center">'; 
      if($optdir) {
         $style = "xmpgreen";
         if (!$progexist) { 
            $job="Install"; $cmd="programs/$progpath/install.php"; 
         }else { 
            $job="Uninstall"; $cmd="programs/$progpath/uninstall.php"; $style = "xmpred";
         }
         echo "<a class=\"small $style awesome\" title=\"$job $progname\" onclick=\"$('#bottomFrame').load('$cmd'); document.getElementById('ptable').className='transparent';\">$job</a>\n";
      }
   }
   
   function plot_enable( $enableprog, $progpath )
   {
      $exist = is_file($enableprog);
      
      if ($exist) {
         $style = "xmpgreen";
         $permission = substr( sprintf('%o', fileperms($enableprog) ), -4 );
          if ($permission != "755") { $job = "Enable"; $cmd="programs/$progpath/bt_start.php"; }
                                     else  { $job = "Disable"; $cmd="programs/$progpath/bt_stop.php"; $style = "xmpred"; }
                            
          echo "<a class=\"small $style awesome\" title=\"$job $progpath daemon at boot\" onclick=\"$('#bottomFrame').load('$cmd'); $('#mainFrame').load('www/programs.php'); document.getElementById('ptable').className='transparent';\" >$job</a>\n";
       } 
   }

   function plot_running_status( $progcheck )
   {
      echo ( "" == exec('ps | grep '.$progcheck.' | grep -v grep')) ? "-" : "Run";
   }
   
   function plot_boot_status( $bootprog )
   {
      $status = "Not installed";
      $exist = is_file($bootprog);
      if ($exist) {
         $permission = substr( sprintf('%o', fileperms($bootprog) ), -4 );
         $status = ($permission == "755") ? "+" : "-" ;
      }
      echo $status; 
   }
   
   function plot_prog_start( $progname, $progpath, $progcheck, $progbin )
   {
      $style = "xmpgreen";
      $exist = is_file( $progbin );
      if ( $exist && '' != $progcheck ) {
         $running = ( "" != exec('ps | grep '.$progcheck.' | grep -v grep') );
         if ($running == "1") { 
            $job="Stop"; $cmd="programs/$progpath/stop.php"; 
            $style = "xmpred";
         }else { 
            $job="Start"; $cmd="programs/$progpath/start.php"; 
         }
         echo "<a class=\"small $style awesome\" title=\"$job $progname\" onclick=\"$('#bottomFrame').load('$cmd'); document.getElementById('ptable').className='transparent'; \">$job</a>\n";
      }
      else {
         //echo "$progbin not found";
      }
   }
   
   function plot_edit_config( $editmessage, $config, $progcheck )
   {
      if ('' != $config){
         $exist = file_exists( $config );
         $running = false;
         
         if ( "" != $progcheck ){
            $running = exec('ps | grep '.$progcheck.' | grep -v grep');
         }
         
         if (!$running && $exist) {
            echo "<a class=\"small awesome\"  title=\"$editmessage\" href=\"webpad/?t=server&f=$config\" target=\"_new\">Edit</a>\n";
         }
      }
   }
   
   if(file_exists($useridpath)) 
   {
      $userid = rtrim( file_get_contents( $useridpath ) );
   }
?>

<!--
<a class="large awesome">Button &raquo;</a> <br /><br />
<a class="large blue awesome">Awesome Blue Button &raquo;</a> <br /><br />
<a class="large magenta awesome">Awesome Magenta Button &raquo;</a> <br /><br />

<a class="large red awesome">Awesome Red Button &raquo;</a> <br /><br />
<a class="large orange awesome">Awesome Orange Button &raquo;</a> <br /><br />
<a class="large yellow awesome">Awesome Yellow Button &raquo;</a> 
<a class="medium awesome">Super Awesome Button &raquo;</a> <br /><br />
<a class="medium blue awesome">Awesome Blue Button &raquo;</a> <br /><br />
<a class="medium magenta awesome">Awesome Magenta Button &raquo;</a> <br /><br />
<a class="medium red awesome">Awesome Red Button &raquo;</a> <br /><br />
<a class="medium orange awesome">Awesome Orange Button &raquo;</a> <br /><br />
<a class="medium yellow awesome">Awesome Yellow Button &raquo;</a> 
<a class="small awesome">Super Awesome Button &raquo;</a> <br /><br />
<a class="small blue awesome">Awesome Blue Button &raquo;</a> <br /><br />
<a class="small magenta awesome">Awesome Magenta Button &raquo;</a> <br /><br />
<a class="small red awesome">Awesome Red Button &raquo;</a> <br /><br />
<a class="small orange awesome">Awesome Orange Button &raquo;</a> <br /><br />
<a class="small yellow awesome">Awesome Yellow Button &raquo;</a> 

<a class="small xmpgreen awesome">Awesome xmp Button &raquo;</a> 
<a class="small xmpred awesome">Awesome xmp Button &raquo;</a> 
-->
<div id="ptable" class="" >
<table class="programs" valign="middle" border="0" width="800px" >
  <tr>
   <td align="left">Package name</td><td align="center">Install/Uninstall</td><td align="center">Start / Stop</td><td align="center">Running status</td><td align="center">Boot status</td><td align="center">Enable/Disable</td><td align="center">More</td>
  </tr>
    
  <tr><td colspan="7" align="center"><hr /></td></tr> <!-- Table horisontal line -->

<!-- Table Base Install -->  
  <tr>
   <td align="left">Base install</td>
   <td align="center"> 
<?  if (!$optdir) {      
          echo '<input type="radio" name="installpath" value="root" checked>root<br />';
          if ($ext3 == "ext3" ) {  echo '<input type="radio" name="installpath" value="'.$pwd.'">'.$pwd.'<br />';  } 
?>
          <a class="small xmpgreen awesome" onclick="$('#bottomFrame').load('programs/base/install.php?installpath=' + $('input:radio[name=installpath]:checked').val()); document.getElementById('ptable').className='transparent';" >Install &raquo;</a>

<?  }else {  ?>
         <a class="small xmpred awesome" title="Full uninstall" onclick="$('#bottomFrame').load('programs/base/uninstall.php'); document.getElementById('ptable').className='transparent';">Uninstall</a>      
<?  } ?>
   </td>
   <td colspan=5 align="center"></td>
  </tr>

<!-- Table horisontal line -->
  <tr><td colspan="7" align="center"><hr /></td></tr>

<!-- Table Cron -->
  <tr>
   <td align="left">Cron</td>
   <td align="center"></td><td align="center"></td>
   <td align="center"><? plot_running_status('cron');  ?></td>
   <td align="center">      
      <?  plot_boot_status( '/etc/init.d/S10cron', 'cron' ); ?>
   </td>
   <td align="center">
      <? plot_enable( '/etc/init.d/S10cron', 'cron' ); ?>
   </td>
   <td align="center">
      <? plot_edit_config( "Edit crontab" , "/opt/var/cron/crontabs/root", "" ); ?>
   </td>
  </tr>
  

<!-- Table NTP date -->

  <tr>
   <td align="left">Time sync</td>
   <td colspan=3 align="center"></td>
   <td align="center">      <?  plot_boot_status('/etc/init.d/S77ntp'); ?>   </td>
   <td align="center">
      <? if ('true' == file_exists('/opt/bin/ntpdate') ) { ?>
         <a class="small awesome" title="Manual time synchronize." onclick="$('#bottomFrame').load('programs/ntp/sync.php'); $('#mainFrame').load('www/programs.php'); " >Manual sync</a>
      <? } ?>
   </td>
   <td align="center"></td>
  </tr>

<!-- Table Telnet -->
<?
//plot_prog_all( $progname, $prognamefull, $installmsg, $xmpsubpath, $progbinary,  $psname, $bootscript, $editmsg, $editconfig, $runcheck )

plot_prog_all( 0, 'Telnet' , "telnet daemon", "telnet deamon",  'telnet', $busyboxbin,  "telnetd", '/etc/init.d/S45telnet', "", "", "" );  
?>
<!-- Table horisontal line -->
  <tr> <td colspan=7 align="center"><hr /></td></tr>

<!-- Table Midnight Commander -->  
  <tr>
   <td align="left"><? plot_prog_install('Midnight Commander', 'mc', '/bin/mc', $optdir ); ?></td>   
   <td colspan=5 align="center"></td>
  </tr>

  <?
  //   function plot_prog_all( $optdir, $progname, $prognamefull, $installmsg, $xmpsubpath, $progbinary,  $psname, $bootscript, $editmsg, $editconfig, $runcheck )

  plot_prog_all( $optdir, 'Openssh' , "sshd daemon", "secure your xtreamer",  'openssh', '/opt/sbin/sshd',  "sshd", '/etc/init.d/S40sshd', "Edit OpenSSH config. Need to restart the SSH daemon after save your edit.", "/opt/etc/openssh/sshd_config", "" );  
  plot_prog_all( $optdir, 'Transmission' , "transmission daemon", "ext3 file system needed on sda1",  'transmission', '/opt/bin/transmission-daemon',  "transmission", '/etc/init.d/S227transmission', "Edit Transmission daemon config.", "/root/transmission/settings.json", 'transmission' );  
  plot_prog_all( $optdir, 'DCTCS' , "DCTCS daemon", "Yet another torrent client",  'dctcs', '/usr/local/bin/dctcs',  "dctcs", '/etc/init.d/S228dctcs', "Edit DCTCS daemon config", "/etc/dctcs.conf", "dctcs" );  
  plot_prog_all( $optdir, 'NZBGet' , "NZBGet application", "Yet another torrent client",  'nzbget', '/opt/bin/nzbget',  "", '', "Edit DCTCS daemon config", "/opt/etc/nzbget.conf'", "nzbget" );
  echo '<tr>   <td colspan="7" align="center"><hr /></td>  </tr>';
  ?>

<tr>
 <td align="left">DVD speed</td>
   <? if ($optdir) { ?>
   <td align="center"><a class="small awesome" title="Set DVD speed 1x" onclick="$('#bottomFrame').load('programs/hdparm/1.php'); $('#mainFrame').load('www/programs.php');" >1x</a></td>
   <td align="center"><a class="small awesome" title="Set DVD speed 2x" onclick="$('#bottomFrame').load('programs/hdparm/2.php'); $('#mainFrame').load('www/programs.php');" >2x</a></td>
   <td align="center"><a class="small awesome" title="Set DVD speed 4x" onclick="$('#bottomFrame').load('programs/hdparm/4.php'); $('#mainFrame').load('www/programs.php');" >4x</a></td>
   <td colspan=3 align="center"></td>
<? }else { echo '<td colspan=7 align="center"></td>'; } ?>
</tr>

<!-- Table horisontal line -->
 <tr><td colspan=7 align="center"><hr /></td></tr>
 <tr>
 <td align="left">Use own RSS</td>
<? if ($xlive ) { ?>
<td align="center"><a class="small awesome" title="Restore X_LIVE" onclick="$('#bottomFrame').load('x_live/symlink_xlive.php?restore=true'); $('#mainFrame').load('www/programs.php'); document.getElementById('ptable').className='transparent';" >Restore x_live</a></td>
<?}else { ?>
<td align="center"><a class="small awesome" title="Use local X_LIVE" onclick="$('#bottomFrame').load('x_live/symlink_xlive.php'); $('#mainFrame').load('www/programs.php'); document.getElementById('ptable').className='transparent';" >Hack x_live</a></td>
<?} ?>
<td align="center" colspan=3>
   My Flickr USER_ID<br/><input name="userid" size="12" value="<? echo $userid; ?>">
   <a class="small awesome" title="12345678@N06"  onclick="$('#bottomFrame').load('x_live/myflickr.php?userid=' + $('[name=userid]').val()); $('#mainFrame').load('www/programs.php'); document.getElementById('ptable').className='transparent';" >Change</a></td>
<td colspan=2 align="center"></td>
</tr>

<!-- Table horisontal line -->
 <tr><td colspan=7 align="center"><hr /></td></tr>

</table>
</div>