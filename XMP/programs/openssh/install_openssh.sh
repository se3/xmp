#!/bin/sh

rm -R /opt/etc/openssh

echo "OpenSSH install started. Be patient..."
/opt/bin/ipkg install openssh
echo "OpenSSH install done."
cp -R /tmp/usbmounts/sda1/xmp/programs/openssh/preconf/* /
/bin/chmod 644 /etc/init.d/S40sshd
sleep 2
killall sshd