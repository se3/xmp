#!/bin/sh

echo "Transmission install started."
/opt/bin/ipkg install transmission
echo "Transmission install done."
echo ""
cp -R /sbin/www/xmp/programs/transmission/preconf/* /
echo "*/5 * * * * root /root/transmission/transmission-queue" >> /opt/var/cron/crontabs/root
/bin/chmod 644 /etc/init.d/S227transmission
/bin/chmod 755 /sbin/www/xmproot/.transmissionconfig/transmission-queue