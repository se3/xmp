#!/bin/sh

rm -R /opt/etc/openssh

echo "OpenSSH install started. Be patient..."
/opt/bin/ipkg install openssh
echo "OpenSSH install done."
cp -R /sbin/www/xmp/programs/openssh/preconf/* /

# Trying to cp source opt/ to / fails as dest /opt is a symlink.
# Must use the following trick to make it work :
cp -R /sbin/www/xmp/programs/openssh/preconf/opt/* /opt/

/bin/chmod 644 /etc/init.d/S40sshd
sleep 2
killall sshd