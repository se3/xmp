#!/bin/sh

echo "The uninstall started. Be patient, no press the uninstall button again!"
echo "Kill all runing process"

killall dctcs
killall ctorrent

sleep 2

echo "Remove all installed files."

rm /etc/dctcs.conf
rm /etc/dctcs.stat
rm /etc/init.d/S228dctsc
rm -R /usr/local/torrentgui
rm /usr/local/bin/ctorrent
rm /usr/local/bin/dctcs
rm /usr/local/bin/dctsc

echo "Uninstall done."