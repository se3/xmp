#!/bin/sh

echo "Transmission install started."

if [ ! -f /opt/bin/transmission-daemon ]; then
   /opt/bin/ipkg install ./transmission_1.76-1_mipsel.ipk
   cp -R preconf/* /
   cp -R .transmissionconfig /sbin/www/xmproot/
   echo "*/5 * * * * root /root/transmission/transmission-queue" >> /opt/var/cron/crontabs/root
   /bin/chmod 755 /sbin/www/xmproot/.transmissionconfig/transmission-queue
else
   cp -R /sbin/www/xmp/programs/transmission/preconf/etc/* /etc
fi

/bin/chmod 644 /etc/init.d/S227transmission

echo "Transmission install done."
