#!/bin/sh

echo "install enhanced-ctorrent"
/opt/bin/ipkg install enhanced-ctorrent

echo "Copy dctcs preconfig."
cp -R preconf/* /
cp -R preconf/opt/* /opt/
chmod +x /opt/local/bin/dctcs
mkdir /sbin/www/xmproot/torrent
mkdir /sbin/www/xmproot/download
/bin/chmod 644 /etc/init.d/S228dctcs

echo ""
echo "ALL INSTALL DONE"
