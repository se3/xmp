<h1>Xtreamer info</h1>
<ol>
<li><a href="#sys">System</a></li>
<li><a href="#soft">Installed software</a></li>
<li><a href="#disk">Disks</a></li>
<li><a href="#network">Network</a></li>
<li><a href="#samba">Samba</a></li>
</ol>
<?
echo '<a id="sys"><h2>System</h2></a>';
echo "<pre>";
system ("cat /etc/motd ");
system ("/opt/bin/uname -a");
system ("cat /proc/cpuinfo");
system ("cat /proc/meminfo");
system ("cat /proc/bus/usb/devices");
system ("/sbin/lsmod");
system ("/bin/ps");
system ("/bin/dmesg");
echo "</pre>";


echo '<a id="soft"><h2>Installed software</h2></a>';
echo "<pre>";
system ("/opt/bin/ipkg list_installed");
echo "</pre>";

echo '<a id="disk"><h2>Disks</h2></a>';
echo "<pre>";
system ("cat /proc/mounts");
system ("/bin/df");
echo "</pre>";
echo "<h3>sda</h3>";
echo "<pre>";
system ("/sbin/fdisk -l /dev/sda");
echo "</pre>";
echo "<h3>sdb</h3>";
echo "<pre>";
system ("/sbin/fdisk -l /dev/sdb");
echo "</pre>";
echo "<h3>sdc</h3>";
echo "<pre>";
system ("/sbin/fdisk -l /dev/sdc");
echo "</pre>";
echo "<h3>sdd</h3>";
echo "<pre>";
system ("/sbin/fdisk -l /dev/sdd");
echo "</pre>";

echo '<a id="network"><h2>Network</h2></a>';
echo "<pre>";
system ("/sbin/ifconfig");
system ("/sbin/route");
system ("cat /etc/resolv.conf");
system ("wget http://ipkg.nslu2-linux.org");

#runprog /opt/bin/host ipkg.nslu2-linux.org
#runprog /bin/ping -c 2 ipkg.nslu2-linux.org
echo "</pre>";

echo '<a id="samba"><h2>Samba</h2></a>';
echo "<pre>";

system ("cat /usr/local/daemon/samba/lib/smb.conf");
# showfile /etc/samba/user_smb.conf
#showfile /var/log/samba/log.smbd
#showfile /var/log/samba/log.nmbd

echo "</pre>";

?>

