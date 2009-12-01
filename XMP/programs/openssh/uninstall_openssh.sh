#!/bin/sh

echo "OpenSSH uninstall started. Be patient..."
/opt/bin/ipkg remove openssh
echo "OpenSSH uninstall done."

rm /usr/local/bin/mc
rm -R /opt/etc/openssh
rm /etc/init.d/S40sshd