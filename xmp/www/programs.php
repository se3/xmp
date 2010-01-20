<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<? 
   //$xmp_root = getcwd();
   $optdir = file_exists('/opt'); 
   $xlive = file_exists('/sbin/www/x_live/WAN_OK'); 
   $sshdfile = file_exists('/opt/sbin/sshd');
   $transfile = file_exists('/opt/bin/transmission-daemon');
   $dctcs = file_exists('/usr/local/bin/dctcs');
   $nzbgetfile = file_exists('/opt/bin/nzbget');
   $mcfile = file_exists('/bin/mc');
   $userid = "12345678@N06";
   $useridpath = "x_live/userid";
   $pwd = exec("pwd | awk 'match($0,/\/sd[a-d][0-9]?\//){print substr($0,RSTART+1,RLENGTH-2)}'");
   $ext3 = exec("mount | grep $pwd | awk '{ print $5 }'");
   
   if(file_exists($useridpath))
   {
      $userid = rtrim( file_get_contents( $useridpath ) );
   }
?>

<!-- Table head -->

<table border="0" width="80%" align="center" >
  <tr>
    <td rowspan="2" align="center">Package name</td>
    <td colspan="2" align="center">Install</td>
    <td colspan="3" align="center">Status</td>
    <td colspan="3" align="center">Boot</td>
    <td rowspan="2" align="center">More</td>
  </tr>
  <tr>
    <td align="center">Install</td>
    <td align="center">Uninstall</td>
    <td colspan="2" align="center">Start / Stop</td>
    <td align="center">Running status</td>
    <td align="center">Boot status</td>
    <td colspan="2" align="center">Start / Stop</td>
  </tr>

<!-- Table horisontal line -->  

  <tr>
    <td colspan="10" align="center"><hr />
</td>
  </tr>

<!-- Table Base Install -->  
  <tr>
    <td align="center">Base install</td>
    <td align="center">
      <form title="Start the base install: IPKG, cron, NTP, hdparm, busybox">
        <input type="radio" name="installpath" value="root" checked>root<br />
        <input type="radio" name="installpath" <? if ($ext3 != "ext3" ) { echo 'disabled="disabled"'; echo 'title="Disabled: Not an ext3 filesystem"'; } ?> 
               value="<? echo $pwd; ?>"><? echo $pwd; ?><br /><br />
        <input type="button" value="Install" 
               onclick="$('#bottomFrame').load('programs/base/install.php?installpath=' + $('input:radio[name=installpath]:checked').val());" 
               <? if ($optdir) echo 'disabled="disabled"'; ?> ><br />
      </form>
    </td>
    <td align="center">
    <form title="Full uninstall">
     <input type="button" value="Uninstall" 
            onclick="$('#bottomFrame').load('programs/base/uninstall.php');" 
            <? if (!$optdir) echo 'disabled="disabled"'; ?> >
    </form>
</td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>

<!-- Table horisontal line -->  

  <tr>
    <td colspan="10" align="center"><hr />
</td>
  </tr>

<!-- Table Cron -->

  <tr>
    <td align="center">Cron</td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><? if ("" == @exec('ps | grep cron | grep -v grep')) echo "-"; else echo "Run"; ?></td>
    <td align="center"><? $fn = '/etc/init.d/S10cron';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4);
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed"; ?></td>
    <td align="center"><form title="Enable cron daemon at boot">
  <input type="button" value="Enable" 
         onclick="$('#bottomFrame').load('programs/cron/bt_start.php');" 
         <?  if ($filen == "755") echo 'disabled="disabled"'; if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form title="Disable cron daemon at boot">
  <input type="button" value="Disable" 
         onclick="$('#bottomFrame').load('programs/cron/bt_stop.php');" 
         <?  if ($filen == "644") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>

    <td align="center"><form action="webpad" method="get" title="Edit crontab." >
	  <input type="hidden" name="t" value="server"/>
	  <input type="hidden" name="f" value="/opt/var/cron/crontabs/root"/>
       <input type="submit" value="Edit crontab" <? if (!$optdir) echo 'disabled="disabled"'; ?>/>
      </form></td>
  </tr>
  

<!-- Table NTP date -->

  <tr>
    <td align="center">Time sync</td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><? $fn = '/etc/init.d/S77ntp';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4);
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed";
	?></td>
    <td colspan=2 align="center"><form title="Manual time synchronize.">
  <input type="button" value="Manual sync" 
         onclick="$('#bottomFrame').load('programs/ntp/sync.php');" 
         <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"></td>
  </tr>

<!-- Table Telnet -->

  <tr>
    <td align="center">Telnet</td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><form title="Start telnet daemon">
  <input type="button" value="Start" 
         onclick="$('#bottomFrame').load('programs/telnet/start.php');" 
         <? $trfa = exec('ps | grep telnetd | grep -v grep'); if (!$trfa == "") echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form title="Stop telnet daemon">
  <input type="button" value="Stop" 
         onclick="$('#bottomFrame').load('programs/telnet/stop.php');" 
         <? if ($trfa == "") echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><? if ("" == @exec('ps | grep telnetd | grep -v grep')) echo "-"; else echo "Run"; ?></td>

    <td align="center"><? $fn = '/etc/init.d/S45telnet';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4);
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed";
	?></td>
    <td align="center"><form title="Enable telnet daemon at boot">
  <input type="button" value="Enable" 
         onclick="$('#bottomFrame').load('programs/telnet/bt_start.php');"
         <?  if ($filen == "755") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="Disable telnet daemon at boot">
  <input type="button" value="Disable" 
         onclick="$('#bottomFrame').load('programs/telnet/bt_stop.php');"
         <? if ($filen == "644") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"></td>
  </tr>


<!-- Table horisontal line -->  

  <tr>
    <td colspan=10 align="center"><hr />
</td>
  </tr>

<!-- Table Midnight Commander -->
  
  <tr>
    <td align="center">MC</td>
    <td align="center"><form title="Midnight Commander install.">
  <input type="button" value="Install" 
         onclick="$('#bottomFrame').load('programs/mc/install.php');"
         <? if ($mcfile) echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="Midnight Commander Uninstall">
  <input type="button" value="Uninstall" 
         onclick="$('#bottomFrame').load('programs/mc/uninstall.php');"
         <? if (!$mcfile) echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><? if ($mcfile) echo "Installed"; else echo "Not installed";?></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>

<!-- Table Open SSH -->
  
  <tr>
    <td align="center">Openssh</td>
    <td align="center"><form title="OpenSSH install">
  <input type="button" value="Install" 
         onclick="$('#bottomFrame').load('programs/openssh/install.php');"
         <? if ($sshdfile) echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="OpenSSH Uninstall">
  <input type="button" value="Uninstall" 
         onclick="$('#bottomFrame').load('programs/openssh/uninstall.php');"
         <? if (!$sshdfile) echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form title="Start sshd daemon">
  <input type="button" value="Start" 
         onclick="$('#bottomFrame').load('programs/openssh/start.php');"
         <? $trfi = exec('ps | grep sshd | grep -v grep'); if (!$trfi == "" || !$sshdfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form title="Stop sshd daemon">
  <input type="button" value="Stop" 
         onclick="$('#bottomFrame').load('programs/openssh/stop.php');"
         <? if ($trfi == "" || !$sshdfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><? if ("" == @exec('ps | grep sshd | grep -v grep')) echo "-"; else echo "Run"; ?></td>
    <td align="center"><? $fn = '/etc/init.d/S40sshd';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4); 
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed";
	?></td>
    <td align="center"><form title="Enable OpenSSH daemon at boot">
  <input type="button" value="Enable" 
         onclick="$('#bottomFrame').load('programs/openssh/bt_start.php');"
         <? if ($filen == "755") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$sshdfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="Disable OpenSSH daemon at boot">
  <input type="button" value="Disable" 
         onclick="$('#bottomFrame').load('programs/openssh/bt_stop.php');"
         <? if ($filen == "644") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$sshdfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="webpad" method="get" title="Edit OpenSSH config. Need to restart the SSH daemon after save your edit." >
    	 <input type="hidden" name="t" value="server"/>
	 <input type="hidden" name="f" value="/opt/etc/openssh/sshd_config"/>
      <input type="submit" value="Edit config" <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$sshdfile) echo 'disabled="disabled"'; ?>>
    </form></td>
  </tr>


<!-- Table Transmission -->
  
  <tr>
    <td align="center">Transmission</td>
    <td align="center"><form title="Transmission torrent client install. Please use it only with ext3 partition.">
  <input type="button" value="Install" 
         onclick="$('#bottomFrame').load('programs/transmission/install.php');"
         <? if ($transfile) echo 'disabled="disabled"'; ?><? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="Transmission uninstall">
  <input type="button" value="Uninstall" 
         onclick="$('#bottomFrame').load('programs/transmission/uninstall.php');"
         <? if (!$transfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="Start transmission daemon">
  <input type="button" value="Start" 
         onclick="$('#bottomFrame').load('programs/transmission/start.php');"
         <? $trfi = exec('ps | grep transmission | grep -v grep'); if (!$trfi == "" || !$transfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form title="Stop transmission daemon">
  <input type="button" value="Stop" 
         onclick="$('#bottomFrame').load('programs/transmission/stop.php');"
         <? if ($trfi == "" || !$transfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><? if ("" == @exec('ps | grep transmission | grep -v grep')) echo "-"; else echo "Run"; ?></td>
    <td align="center"><? $fn = '/etc/init.d/S227transmission';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4);
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed";
	?></td>
    <td align="center"><form title="Enable Transmission daemon at boot">
  <input type="button" value="Enable" 
         onclick="$('#bottomFrame').load('programs/transmission/bt_start.php');"
         <? if ($filen == "755") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$transfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="Disable Transmission daemon at boot">
  <input type="button" value="Disable" 
         onclick="$('#bottomFrame').load('programs/transmission/bt_stop.php');"
         <? if ($filen == "644") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$transfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center">
	<form action="webpad" method="get" title="Edit Transmission daemon config.">
	  <input type="hidden" name="t" value="server"/>
	  <input type="hidden" name="f" value="/root/transmission/settings.json"/>
  <input type="submit" value="Edit config" <? $trfi = exec('ps | grep transmission | grep -v grep'); if (!$trfi == "" || !$transfile) echo 'disabled="disabled"'; ?>>
</form>
	</td>
  </tr>
  
<!-- Table DCTCS -->
  
  <tr>
    <td align="center">DCTCS</td>
    <td align="center"><form title="DCTCS torrent client install. Please use it only with ext3 partition.">
      <input type="button" value="Install" 
         onclick="$('#bottomFrame').load('programs/dctcs/install.php');"
         <? if ($dctcs) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="DCTCS uninstall">
  <input type="button" value="Uninstall" 
         onclick="$('#bottomFrame').load('programs/dctcs/uninstall.php');"
         <? if (!$dctcs) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="Start DCTCS daemon">
  <input type="button" value="Start" 
         onclick="$('#bottomFrame').load('programs/dctcs/start.php');"
         <? $trfi = exec('ps | grep dctcs | grep -v grep'); if (!$trfi == "" || !$dctcs) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form title="Stop DCTCS daemon">
  <input type="button" value="Stop" 
         onclick="$('#bottomFrame').load('programs/dctcs/stop.php');"
         <? if ($trfi == "" || !$dctcs) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><? if ("" == @exec('ps | grep dctcs | grep -v grep')) echo "-"; else echo "Run"; ?></td>
    <td align="center"><? $fn = '/etc/init.d/S228dctcs';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4);
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed";
	?></td>
    <td align="center"><form title="Enable DCTCS daemon at boot">
  <input type="button" value="Enable" 
         onclick="$('#bottomFrame').load('programs/dctcs/bt_start.php');"
         <? if ($filen == "755") echo 'disabled="disabled"'; ?>  <? if (!$dctcs) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form title="Disable DCTCS daemon at boot">
  <input type="button" value="Disable" 
         onclick="$('#bottomFrame').load('programs/dctcs/bt_stop.php');"
         <? if ($filen == "644") echo 'disabled="disabled"'; ?>  <? if (!$dctcs) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center">
	<form action="webpad" method="get" title="Edit dctcs daemon config.">
	  <input type="hidden" name="t" value="server"/>
	  <input type="hidden" name="f" value="/etc/dctcs.conf"/>
  <input type="submit" value="Edit config" <? $trfi = exec('ps | grep dctcs | grep -v grep'); if (!$trfi == "" || !$dctcs) echo 'disabled="disabled"'; ?>>
</form>
	</td>
  </tr>

 
<!-- Table NZBGet -->

  <tr>
    <td align="center">NZBGet</td>
    <td align="center"><form title="NZBGet install">
  <input type="button" value="Install" 
         onclick="$('#bottomFrame').load('programs/nzbget/install.php');"
         <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if ($nzbgetfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form title="NZBGet uninstall">
  <input type="button" value="Uninstall" 
         onclick="$('#bottomFrame').load('programs/nzbget/uninstall.php');"
         <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$nzbgetfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><? if ($nzbgetfile) echo "Installed"; else echo "Not installed";?></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><form action="webpad" method="get" title="Edit NZBGet config." >
    	  <input type="hidden" name="t" value="server"/>
	  <input type="hidden" name="f" value="/opt/etc/nzbget.conf"/>
       <input type="submit" value="Edit config" <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$nzbgetfile) echo 'disabled="disabled"'; ?>>
</form></td>
  </tr>

<!-- Table horisontal line -->

  <tr>
    <td colspan=10 align="center"><hr />
</td>
  </tr>

<!-- Table DVD speed -->

<tr>
<td align="center">DVD speed</td>
<td align="center"><form title="Set DVD speed 1x">
  <input type="button" value="1x" 
         onclick="$('#bottomFrame').load('programs/hdparm/1.php');"
         <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
<td align="center"><form title="Set DVD speed 2x">
  <input type="button" value="2x" 
         onclick="$('#bottomFrame').load('programs/hdparm/2.php');"
         <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
<td align="center"><form title="Set DVD speed 4x">
  <input type="button" value="4x" 
         onclick="$('#bottomFrame').load('programs/hdparm/4.php');"
         <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
</tr>


  <tr>
    <td colspan=10 align="center"><hr />
</td>
  </tr>
<tr>
<td align="center">Use own RSS</td>
<td align="center"><form title="Make X_LIVE local">
  <input type="button" 
         onclick="$('#bottomFrame').load('x_live/symlink_xlive.php');"
         <? if (!$xlive) { echo 'value="Hack x_live"'; } else{ echo 'value="x_live hacked"'; echo 'disabled="disabled"'; } ?>>
</form></td>
<td align="center">My Flickr USER_ID<form title="12345678@N06">
   <input name="userid" size="12" value="<? echo $userid; ?>">
   <input type="button" 
         onclick="$('#bottomFrame').load('x_live/myflickr.php?userid=' + $('[name=userid]').val());"
         <? if (!$xlive) { echo 'value="Activate x_live"'; echo 'disabled="disabled"'; } else{ echo 'value="Change"';  } ?>>
</form></td>
<td align="center"></td>
</tr>

<!-- Table horisontal line -->

  <tr>
    <td colspan=10 align="center"><hr />
</td>
  </tr>

</table>
