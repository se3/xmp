#!/bin/sh

echo "Transmission install started."

if [ ! -f /sbin/www/xmproot/.transmissionconfig/settings.json ]; then
   /opt/bin/ipkg install transmission
   cp -R /sbin/www/xmp/programs/transmission/preconf/* /
   echo "*/5 * * * * root /root/transmission/transmission-queue" >> /opt/var/cron/crontabs/root
   /bin/chmod 755 /sbin/www/xmproot/.transmissionconfig/transmission-queue
else
   cp -R /sbin/www/xmp/programs/transmission/preconf/etc/* /etc
fi

/bin/chmod 644 /etc/init.d/S227transmission

echo "Transmission install done."
