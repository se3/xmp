<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>xmp Programs</title>
<link rel="stylesheet" type="text/css" href="../xmp.css">

<? 
   //$xmp_root = getcwd();
   $optdir = file_exists('/opt'); 
   $sshdfile = file_exists('/opt/sbin/sshd');
   $transfile = file_exists('/opt/bin/transmission-daemon');
   $dctcs = file_exists('/usr/local/bin/dctcs');
   $nzbgetfile = file_exists('/opt/bin/nzbget');
   $mcfile = file_exists('/bin/mc');
?>

<!-- Table head -->

<table border="0" width=80% align="center">
  <tr>
    <td rowspan=2 align="center">Package name</td>
    <td colspan=2 align="center">Install</td>
    <td colspan=3 align="center">Status</td>
    <td colspan=3 align="center">Boot</td>
    <td rowspan=2 align="center">More</td>
  </tr>
  <tr>
    <td align="center">Install</td>
    <td align="center">Uninstall</td>
    <td colspan=2 align="center">Start / Stop</td>
    <td align="center">Runing status</td>
    <td align="center">Boot status</td>
    <td colspan=2 align="center">Start / Stop</td>
  </tr>

<!-- Table horisontal line -->  

  <tr>
    <td colspan=10 align="center"><hr />
</td>
  </tr>

<!-- Table Base Install -->  
  <tr>
    <td align="center">Base install</td>
    <td align="center"><form action="../programs/base/install.php" method="get" target="bottomFrame" title="Start the base install: IPKG, cron, NTP, hdparm, busybox">
  <input type="submit" value="Install" <? if ($optdir) echo 'disabled="disabled"'; ?> >
</form>
</td>
    <td align="center"><form action="../programs/base/uninstall.php" method="get" target="bottomFrame" title="Full uninstall">
  <input type="submit" value="Uninstall" <? if (!$optdir) echo 'disabled="disabled"'; ?> >
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
    <td colspan=10 align="center"><hr />
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
    <td align="center"><form action="../programs/cron/bt_start.php" method="get" target="bottomFrame" title="Enable cCron daemon at boot">
  <input type="submit" value="Enable" <?  if ($filen == "755") echo 'disabled="disabled"'; if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form action="../programs/cron/bt_stop.php" method="get" target="bottomFrame" title="Disable cron daemon at boot">
  <input type="submit" value="Disable" <?  if ($filen == "644") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>

    <td align="center"><form action="../webpad" method="get" title="Edit crontab." >
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
    <td colspan=2 align="center"><form action="../programs/ntp/sync.php" method="get" target="bottomFrame" title="Manual time synchronize.">
  <input type="submit" value="Manual sync" <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"></td>
  </tr>

<!-- Table Telnet -->

  <tr>
    <td align="center">Telnet</td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><form action="../programs/telnet/start.php" method="get" target="bottomFrame" title="Start telnet daemon">
  <input type="submit" value="Start" <? $trfa = exec('ps | grep telnetd | grep -v grep'); if (!$trfa == "") echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form action="../programs/telnet/stop.php" method="get" target="bottomFrame" title="Stop telnet daemon">
  <input type="submit" value="Stop" <? if ($trfa == "") echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><? if ("" == @exec('ps | grep telnetd | grep -v grep')) echo "-"; else echo "Run"; ?></td>

    <td align="center"><? $fn = '/etc/init.d/S45telnet';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4);
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed";
	?></td>
    <td align="center"><form action="../programs/telnet/bt_start.php" method="get" target="bottomFrame" title="Enable telnet daemon at boot">
  <input type="submit" value="Enable" <?  if ($filen == "755") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/telnet/bt_stop.php" method="get" target="bottomFrame" title="Disable telnet daemon at boot">
  <input type="submit" value="Disable" <? if ($filen == "644") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
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
    <td align="center"><form action="../programs/mc/install.php" method="get" target="bottomFrame" title="Midnight Commander install.">
  <input type="submit" value="Install" <?  if ($mcfile) echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/mc/uninstall.php" method="get" target="bottomFrame" title="Midnight Commander Uninstall">
  <input type="submit" value="Uninstall" <? if (!$mcfile) echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> >
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
    <td align="center"><form action="../programs/openssh/install.php" method="get" target="bottomFrame" title="OpenSSH install">
  <input type="submit" value="Install" <?  if ($sshdfile) echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/openssh/uninstall.php" method="get" target="bottomFrame" title="OpenSSH Uninstall">
  <input type="submit" value="Uninstall" <? if (!$sshdfile) echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form action="../programs/openssh/start.php" method="get" target="bottomFrame" title="Start sshd daemon">
  <input type="submit" value="Start" <? $trfi = exec('ps | grep sshd | grep -v grep'); if (!$trfi == "" || !$sshdfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form action="../programs/openssh/stop.php" method="get" target="bottomFrame" title="Stop sshd daemon">
  <input type="submit" value="Stop" <? if ($trfi == "" || !$sshdfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><? if ("" == @exec('ps | grep sshd | grep -v grep')) echo "-"; else echo "Run"; ?></td>
    <td align="center"><? $fn = '/etc/init.d/S40sshd';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4); 
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed";
	?></td>
    <td align="center"><form action="../programs/openssh/bt_start.php" method="get" target="bottomFrame" title="Enable OpenSSH daemon at boot">
  <input type="submit" value="Enable" <?  if ($filen == "755") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$sshdfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/openssh/bt_stop.php" method="get" target="bottomFrame" title="Disable OpenSSH daemon at boot">
  <input type="submit" value="Disable" <? if ($filen == "644") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$sshdfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../webpad" method="get" title="Edit OpenSSH config. Need to restart the SSH daemon after save your edit." >
    	 <input type="hidden" name="t" value="server"/>
	 <input type="hidden" name="f" value="/opt/etc/openssh/sshd_config"/>
      <input type="submit" value="Edit config" <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$sshdfile) echo 'disabled="disabled"'; ?>>
    </form></td>
  </tr>


<!-- Table Transmission -->
  
  <tr>
    <td align="center">Transmission</td>
    <td align="center"><form action="../programs/transmission/install.php" method="get" target="bottomFrame" title="Transmission torrent client install. Please use it only with ext3 particion.">
  <input type="submit" value="Install" <? if ($transfile) echo 'disabled="disabled"'; ?><? if (!$optdir) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/transmission/uninstall.php" method="get" target="bottomFrame" title="Transmission uninstall">
  <input type="submit" value="Uninstall" <? if (!$transfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/transmission/start.php" method="get" target="bottomFrame" title="Start transmission daemon">
  <input type="submit" value="Start" <? $trfi = exec('ps | grep transmission | grep -v grep'); if (!$trfi == "" || !$transfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form action="../programs/transmission/stop.php" method="get" target="bottomFrame" title="Stop transmission daemon">
  <input type="submit" value="Stop" <? if ($trfi == "" || !$transfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><? if ("" == @exec('ps | grep transmission | grep -v grep')) echo "-"; else echo "Run"; ?></td>
    <td align="center"><? $fn = '/etc/init.d/S227transmission';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4);
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed";
	?></td>
    <td align="center"><form action="../programs/transmission/bt_start.php" method="get" target="bottomFrame" title="Enable Transmission daemon at boot">
  <input type="submit" value="Enable" <?  if ($filen == "755") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$transfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/transmission/bt_stop.php" method="get" target="bottomFrame" title="Disable Transmission daemon at boot">
  <input type="submit" value="Disable" <? if ($filen == "644") echo 'disabled="disabled"'; ?> <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$transfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center">
	<form action="../webpad" method="get" title="Edit Transmission daemon config.">
	  <input type="hidden" name="t" value="server"/>
	  <input type="hidden" name="f" value="/root/transmission/settings.json"/>
  <input type="submit" value="Edit config" <? $trfi = exec('ps | grep transmission | grep -v grep'); if (!$trfi == "" || !$transfile) echo 'disabled="disabled"'; ?>>
</form>
	</td>
  </tr>
  
<!-- Table DCTCS -->
  
  <tr>
    <td align="center">DCTCS</td>
    <td align="center"><form action="../programs/dctcs/install.php" method="get" target="bottomFrame" title="DCTCS torrent client install.">
  <input type="submit" value="Install" <? if ($dctcs) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/dctcs/uninstall.php" method="get" target="bottomFrame" title="DCTCS uninstall">
  <input type="submit" value="Uninstall" <? if (!$dctcs) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/dctcs/start.php" method="get" target="bottomFrame" title="Start DCTCS daemon">
  <input type="submit" value="Start" <? $trfi = exec('ps | grep dctcs | grep -v grep'); if (!$trfi == "" || !$dctcs) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form action="../programs/dctcs/stop.php" method="get" target="bottomFrame" title="Stop DCTCS daemon">
  <input type="submit" value="Stop" <? if ($trfi == "" || !$dctcs) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><? if ("" == @exec('ps | grep dctcs | grep -v grep')) echo "-"; else echo "Run"; ?></td>
    <td align="center"><? $fn = '/etc/init.d/S228dctcs';
    if (file_exists($fn) == 'true') {
	$filen = substr(sprintf('%o', fileperms($fn)), -4);
	if ($filen == "0755") echo "+";
	if ($filen == "0644") echo "-";
	} else echo "Not installed";
	?></td>
    <td align="center"><form action="../programs/dctcs/bt_start.php" method="get" target="bottomFrame" title="Enable DCTCS daemon at boot">
  <input type="submit" value="Enable" <?  if ($filen == "755") echo 'disabled="disabled"'; ?>  <? if (!$dctcs) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"><form action="../programs/dctcs/bt_stop.php" method="get" target="bottomFrame" title="Disable DCTCS daemon at boot">
  <input type="submit" value="Disable" <? if ($filen == "644") echo 'disabled="disabled"'; ?>  <? if (!$dctcs) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center">
	<form action="../webpad" method="get" title="Edit dctcs daemon config.">
	  <input type="hidden" name="t" value="server"/>
	  <input type="hidden" name="f" value="/etc/dctcs.conf"/>
  <input type="submit" value="Edit config" <? $trfi = exec('ps | grep dctcs | grep -v grep'); if (!$trfi == "" || !$dctcs) echo 'disabled="disabled"'; ?>>
</form>
	</td>
  </tr>

 
<!-- Table NZBGet -->

  <tr>
    <td align="center">NZBGet</td>
    <td align="center"><form action="../programs/nzbget/install.php" method="get" target="bottomFrame" title="NZBGet install">
  <input type="submit" value="Install" <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if ($nzbgetfile) echo 'disabled="disabled"'; ?> >
</form></td>
    <td align="center"><form action="../programs/nzbget/uninstall.php" method="get" target="bottomFrame" title="NZBGet uninstall">
  <input type="submit" value="Uninstall" <? if (!$optdir) echo 'disabled="disabled"'; ?> <? if (!$nzbgetfile) echo 'disabled="disabled"'; ?>>
</form></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><? if ($nzbgetfile) echo "Installed"; else echo "Not installed";?></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><form action="../webpad" method="get" title="Edit NZBGet config." >
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
<td align="center"><form action="../programs/hdparm/1.php" method="get" target="bottomFrame" title="Set DVD speed 1x">
  <input type="submit" value="1x" <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
<td align="center"><form action="../programs/hdparm/2.php" method="get" target="bottomFrame" title="Set DVD speed 2x">
  <input type="submit" value="2x" <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
<td align="center"><form action="../programs/hdparm/4.php" method="get" target="bottomFrame" title="Set DVD speed 4x">
  <input type="submit" value="4x" <? if (!$optdir) echo 'disabled="disabled"'; ?> >
</form></td>
</tr>


<!-- Table horisontal line -->

  <tr>
    <td colspan=10 align="center"><hr />
</td>
  </tr>

<!-- Table reflesh -->
  
  <tr>
    <td colspan=10 align="center">
    <form action="" method="get" target="mainFrame" title="Reload this page.">
    <input type="submit" value="Allways need a Refresh after an operation">
	</td>
  </tr>

</table>

<table border="0" align="center">

</table>

<body>
</body>
</html>