#!/bin/sh

echo "Transmission install started."
/opt/bin/ipkg install transmission
echo "Transmission install done."
echo ""
cp -R /tmp/usbmounts/sda1/xmp/programs/transmission/preconf/* /
echo "*/5 * * * * root /root/transmission/transmission-queue" >> /opt/var/cron/crontabs/root
/bin/chmod 644 /etc/init.d/S227transmission
/bin/chmod 755 /root/transmission/transmission-queue