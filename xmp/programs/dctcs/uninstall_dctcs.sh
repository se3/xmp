#!/bin/sh

echo "The uninstall started. Be patient, no press the uninstall button again!"
echo "Kill all runing process"

killall dctcs
killall ctorrent

sleep 2

echo "Remove all installed files."

rm /opt/etc/dctcs.conf
rm /opt/etc/dctcs.stat
rm /etc/init.d/S228dctcs
rm -R /opt/local/torrentgui
rm /opt/local/bin/dctcs
rm -R /sbin/www/xmproot/torrent

/opt/bin/ipkg remove enhanced-ctorrent

echo "Uninstall done."