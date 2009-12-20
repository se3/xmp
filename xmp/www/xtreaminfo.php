<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="generator" content="sh" />
  <meta name="version" content="\$Id$" />
  <title>xtreaminfo</title>
  
  
<style type="text/css">

h3, h2, h1 {
  font-family: Arial, Helvetica, sans-serif;
  color: #FFF;
}

table {
  border-top: 1px solid #eee;
  border-right: 1px solid #eee;
  width: 100%;
}

th, td {
  padding: 2px 4px;
  border-left: 1px solid #eee;
  border-bottom: 1px solid #eee;
}

table a {
  background: #ddd;
  color: #004;
  text-decoration: none;
  margin: 1px;
  padding: 2px 4px;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 75%;
}

table a.ins {
  background: #dfd;
  border-left: 1px solid #cec;
  border-bottom: 1px solid #cec;
}

table a.upd {
  background: #ddf;
  border-left: 1px solid #cce;
  border-bottom: 1px solid #cce;
}

table a.del {
  background: #fdd;
  border-left: 1px solid #ecc;
  border-bottom: 1px solid #ecc;
}

input {
 background-color: #999;
 color: DfD;
 cursor: pointer;
}

input[disabled='disabled'] {
  background: #888;
  color: #AAA;
  cursor:default;
}

body,td,th {
	background-color: #000;
	font-size: 14px;
	color: #BBB;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
}
a {
	font-size: 14px;
	color: #00FF00;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #00FF00;
}
a:hover {
	text-decoration: none;
	color: #00FF00;
}
a:active {
	text-decoration: none;
}

#leftFrame {
 background-color: #200;
}
#mainFrame {
 background-color: #000;
}
#bottomFrame {
 background-color: #100;
}


#borderFrame {
 background-color: #333;
}

#border2Frame {
 background-color: #333;
}

</style>

</head>
<body>
<h1>Xtreamer info</h1>
<ol>
<li><a href="#sys">System</a></li>
<li><a href="#soft">Installed software</a></li>
<li><a href="#disk">Disks</a></li>
<li><a href="#network">Network</a></li>
<li><a href="#samba">samba</a></li>
</ol>
<?
echo '<h2>System</h2> <a id="sys" />';
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


echo '<h2>Installed software</h2> <a id="soft" />';
echo "<pre>";
system ("/opt/bin/ipkg list_installed");
echo "</pre>";

echo '<h2>Disks</h2> <a id="disk" />';
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

echo '<h2>Network</h2> <a id="network" />';
echo "<pre>";
system ("/sbin/ifconfig");
system ("/sbin/route");
system ("cat /etc/resolv.conf");
system ("wget http://ipkg.nslu2-linux.org");

#runprog /opt/bin/host ipkg.nslu2-linux.org
#runprog /bin/ping -c 2 ipkg.nslu2-linux.org
echo "</pre>";

echo '<a id="samba" /><h2>Samba</h2> ';
echo "<pre>";

system ("cat /usr/local/daemon/samba/lib/smb.conf");
# showfile /etc/samba/user_smb.conf
#showfile /var/log/samba/log.smbd
#showfile /var/log/samba/log.nmbd

echo "</pre>";

echo '</body></html>';
