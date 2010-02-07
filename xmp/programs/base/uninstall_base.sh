#!/bin/sh

echo "The uninstall started. Be patient, no press the uninstall button again!"
echo "Kill all runing process"

killall cron
killall telnetd
killall transmission-daemon

sleep 15

echo "Remove all installed files."

rm -R /opt
rm /opt
rm /bin/mc
rm /bin/unrar.sh
rm /etc/init.d/S10cron
rm /etc/init.d/S45telnet
rm /etc/init.d/S77ntp
rm /etc/init.d/S40sshd
rm /etc/init.d/S227transmission
rm /usr/local/bin/mc
rm /bin/transmission_start.sh
rm /bin/transmission_stop.sh
rm -R /root


echo "Uninstall done."