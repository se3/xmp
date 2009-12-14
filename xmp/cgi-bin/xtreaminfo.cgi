#!/bin/sh
#
# $Id$
#

PATH="/opt/bin:/opt/sbin:$PATH"

if [ "${BASH_CHECK}" != 1 -a -f /opt/bin/bash ]
then
	BASH_CHECK=1; export BASH_CHECK
	/opt/bin/bash $0
	exit $$
fi

showcommand() {
	NAME=$1
	shift
	PROG=$1
	shift
	if [ -f ${PROG} ]
	then
		echo "<h3>${NAME}</h3>"
		echo "<pre>"
		${PROG} "$@"
		echo "</pre>"
	fi
}

showfile() {
	FILE=$1;
	BASE=${FILE##*/}
	shift
	if [ -f "${FILE}" ]
	then
		showcommand "${BASE}" "/bin/cat" "${FILE}"
	fi
}

runprog() {
	PROG=$1;
	BASE=${PROG##*/}
	shift
	showcommand "${BASE}" "${PROG}" "$@"
}

cd /tmp
cat << EOF
Content-type: text/html

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="generator" content="sh" />
  <meta name="version" content="\$Id$" />
  <title>xtreaminfo</title>
  
  
<style type="text/css">

h2, h1 {
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
EOF
echo '<h2>System</h2> <a id="sys" />'
showfile /etc/motd 
runprog /opt/bin/uname -a
showfile /proc/cpuinfo
showfile /proc/meminfo
showfile /proc/bus/usb/devices
runprog /sbin/lsmod
runprog /bin/ps
runprog /bin/dmesg
echo '<h2>Installed software</h2> <a id="soft" />'
runprog /opt/bin/ipkg list_installed
echo '<h2>Disks</h2> <a id="disk" />'
showfile /proc/mounts
runprog /bin/df
showcommand "sda" /sbin/fdisk -l /dev/sda
showcommand "sdb" /sbin/fdisk -l /dev/sdb
showcommand "sdc" /sbin/fdisk -l /dev/sdc
showcommand "sdd" /sbin/fdisk -l /dev/sdd
echo '<h2>Network</h2> <a id="network" />'
runprog /sbin/ifconfig
runprog /sbin/route
showfile /etc/resolv.conf
#runprog /opt/bin/host ipkg.nslu2-linux.org
#runprog /bin/ping -c 2 ipkg.nslu2-linux.org
runprog /usr/bin/wget http://ipkg.nslu2-linux.org
echo '<h2>Samba</h2> <a id="samba" />'
showfile /usr/local/daemon/samba/lib/smb.conf
# showfile /etc/samba/user_smb.conf
#showfile /var/log/samba/log.smbd
#showfile /var/log/samba/log.nmbd
echo '</body>'
echo '</html>'
