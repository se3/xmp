<?php 
   //$xmp_root = getcwd();
   $optdir = file_exists('/opt'); 
   $xlive = file_exists('/sbin/www/x_live/WAN_OK'); 
      
   $userid = "12345678@N06";
   $useridpath = "x_live/userid";
   $pwd = exec("pwd | awk 'match($0,/\/sd[a-d][0-9]?\//){print substr($0,RSTART+1,RLENGTH-2)}'");
   $ext3 = exec("mount | grep $pwd | awk '{ print $5 }'");
   $busyboxbin = "/tmp/usbmounts/$pwd/xmp/busybox";
   
   function plot_prog_install( $progname, $progpath, $progcheck )
   {
      global $optdir;
      $progexist = file_exists($progcheck);         
      echo $progname.'</td><td align="center">'; 
      if($optdir) {
         if (!$progexist) { 
            $job="Install"; $cmd="programs/$progpath/install.php"; 
         }else { 
            $job="Uninstall"; $cmd="programs/$progpath/uninstall.php"; 
         }
         echo "<a class=\"small awesome\" title=\"$job $progname\" onclick=\"$('#bottomFrame').load('$cmd');\">$job</a>\n";
      }
   }
   
   function plot_enable( $enableprog, $progpath )
   {
      $exist = is_file($enableprog);
      
      if ($exist) {
         $permission = substr( sprintf('%o', fileperms($enableprog) ), -4 );
          if ($permission != "755") { $job = "Enable"; $cmd="programs/$progpath/bt_start.php"; }
                                     else  { $job = "Disable"; $cmd="programs/$progpath/bt_stop.php"; }
                            
          echo "<a class=\"small awesome\" title=\"$job $progpath daemon at boot\" onclick=\"$('#bottomFrame').load('$cmd'); $('#mainFrame').load('www/programs.php');\" >$job</a>\n";
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
      $exist = is_file( $progbin );
      if ( $exist ) {
         $running = ( "" != exec('ps | grep '.$progcheck.' | grep -v grep') );
         if ($running == "1") { 
            $job="Stop"; $cmd="programs/$progpath/stop.php"; 
         }else { 
            $job="Start"; $cmd="programs/$progpath/start.php"; 
         }
         echo "<a class=\"small awesome\" title=\"$job $progname\" onclick=\"$('#bottomFrame').load('$cmd'); \">$job</a>\n";
      }
      else {
         //echo "$progbin not found";
      }
   }
   
   function plot_edit_config( $editmessage, $config, $progcheck )
   { 
      $exist = file_exists( $config );
      $running = 'false';
      
      if ("" != $progcheck ){
         $running = exec('ps | grep '.$progcheck.' | grep -v grep');
      }
      
      if (!$running && $exist) {
         echo "<a class=\"small awesome\"  title=\"$editmessage\" href=\"webpad/?t=server&f=$config\" target=\"_new\">Edit</a>\n";
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
-->

<table border="0" width="80%" align="center" >
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
          <a class="small awesome" onclick="$('#bottomFrame').load('programs/base/install.php?installpath=' + $('input:radio[name=installpath]:checked').val());" >Install &raquo;</a>

<?  }else {  ?>
         <a class="small awesome" title="Full uninstall" onclick="$('#bottomFrame').load('programs/base/uninstall.php'); ">Uninstall</a>      
<?  } ?>
   </td>
   <td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td><td align="center"></td>
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
   <td align="center"></td>
   <td align="center"></td>
   <td align="center"></td>
   <td align="center">
      <?  plot_boot_status('/etc/init.d/S77ntp'); ?>
   </td>
   <td align="center">
      <? if ('true' == file_exists('/opt/bin/ntpdate') ) { ?>
      <a class="small awesome" title="Manual time synchronize." onclick="$('#bottomFrame').load('programs/ntp/sync.php'); $('#mainFrame').load('www/programs.php');" >Manual sync</a>
      <? } ?>
   </td>
   <td align="center"></td>
  </tr>

<!-- Table Telnet -->

  <tr>
   <td align="left">Telnet</td>
   <td align="center"></td>
   <td align="center">
      <?  plot_prog_start("telnet daemon", "telnet", 'telnetd', $busyboxbin  ); ?>
   </td>
   <td align="center">
      <? plot_running_status(  'telnetd'  );  ?>
   </td>
   <td align="center">
      <? plot_boot_status('/etc/init.d/S45telnet'); ?>
   </td>
   <td align="center">
      <?  plot_enable( '/etc/init.d/S45telnet', 'telnet'); ?>
   </td>
   <td align="center"></td>
  </tr>


<!-- Table horisontal line -->  

  <tr>
   <td colspan=7 align="center"><hr />
</td>
  </tr>

<!-- Table Midnight Commander -->
  
  <tr>
   <td align="left">
      <? plot_prog_install('Midnight Commander', 'mc', '/bin/mc'); ?>
   </td>   
   <td align="center"></td>
   <td align="center"></td>
   <td align="center"></td>
   <td align="center"></td>
   <td align="center"></td>
  </tr>

<!-- Table Open SSH -->
  
  <tr>
   <td align="left">
      <?  plot_prog_install('Openssh', 'openssh', '/opt/sbin/sshd' );  ?>
   </td>
   <td align="center">
      <?  plot_prog_start("sshd daemon", "openssh", "sshd", '/opt/sbin/sshd'  );  ?>
   </td>
   <td align="center">
      <? plot_running_status( "sshd" ); ?>
   </td>
   <td align="center">      
      <? plot_boot_status( '/etc/init.d/S40sshd' ); ?>
   </td>
   <td align="center">
      <?  plot_enable( '/etc/init.d/S40sshd', 'openssh'); ?>
   </td>
   <td align="center">
      <? plot_edit_config( "Edit OpenSSH config. Need to restart the SSH daemon after save your edit." , "/opt/etc/openssh/sshd_config", "" ); ?>
   </td>
  </tr>


<!-- Table Transmission -->
  
  <tr>
   <td align="left">
      <?  plot_prog_install('Transmission', 'transmission', '/opt/bin/transmission-daemon' );  ?>
   </td>   
   <td align="center">
      <?  plot_prog_start("transmission daemon", "transmission", "transmission" , '/opt/bin/transmission-daemon'  );  ?>
   </td>
   <td align="center">
      <? plot_running_status( "transmission" ); ?>
   </td>
   <td align="center">
      <? plot_boot_status( '/etc/init.d/S227transmission' ); ?>
   </td>
   <td align="center">
      <?  plot_enable( '/etc/init.d/S227transmission', 'transmission'); ?>
   </td>
   <td align="center">
      <? plot_edit_config( "Edit Transmission daemon config" , "/root/transmission/settings.json", "" ); ?>      
   </td>
  </tr>
  
<!-- Table DCTCS -->
  
  <tr>
   <td align="left">
       <?  plot_prog_install('DCTCS', 'dctcs', '/usr/local/bin/dctcs' );  ?>
   </td>
   <td align="center">
      <?  plot_prog_start("DCTCS daemon", "dctcs", "dctcs" , '/usr/local/bin/dctcs' );  ?>
   </td>
   <td align="center"> 
      <? plot_running_status( "dctcs" ); ?>
   </td>
   <td align="center">
      <? plot_boot_status( '/etc/init.d/S228dctcs' ); ?>
   </td>
   <td align="center">
      <?  plot_enable( '/etc/init.d/S228dctcs', 'dctcs'); ?>
   </td>
   <td align="center">
      <? plot_edit_config( "Edit DCTCS daemon config" , "/etc/dctcs.conf", "dctcs" ); ?>
	</td>
  </tr>

 
<!-- Table NZBGet -->
  <tr>
   <td align="left">
      <?  plot_prog_install('NZBGet', 'nzbget', '/opt/bin/nzbget' );  ?>
   </td>
   <td align="center"></td>
   <td align="center"></td>
   <td align="center"><? plot_boot_status( '/opt/bin/nzbget' ); ?></td>
   <td align="center"></td>
   <td align="center">
      <? plot_edit_config( "Edit NZBGet config" , "/opt/etc/nzbget.conf'", "nzbget" ); ?>
    </td>
  </tr>

<!-- Table horisontal line -->

  <tr>   <td colspan=7 align="center"><hr /></td>  </tr>

<!-- Table DVD speed -->

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

  <tr>
   <td colspan=7 align="center"><hr />
</td>
  </tr>
<tr>
<td align="left">Use own RSS</td>
<? if ($xlive ) { ?>
<td align="center"><a class="small awesome" title="Restore X_LIVE" onclick="$('#bottomFrame').load('x_live/symlink_xlive.php?restore=true'); $('#mainFrame').load('www/programs.php');" >Restore x_live</a></td>
<?}else { ?>
<td align="center"><a class="small awesome" title="Use local X_LIVE" onclick="$('#bottomFrame').load('x_live/symlink_xlive.php'); $('#mainFrame').load('www/programs.php');" >Hack x_live</a></td>
<?} ?>
<td align="center" colspan=3>
   My Flickr USER_ID<br/><input name="userid" size="12" value="<? echo $userid; ?>">
   <a class="small awesome" title="12345678@N06"  onclick="$('#bottomFrame').load('x_live/myflickr.php?userid=' + $('[name=userid]').val()); $('#mainFrame').load('www/programs.php');" >Change</a></td>
<td colspan=2 align="center"></td>
</tr>

<!-- Table horisontal line -->

  <tr>   <td colspan=7 align="center"><hr /></td>  </tr>

</table>
