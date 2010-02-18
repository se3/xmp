#!/bin/sh

echo "Transmission uninstall started."
/opt/bin/ipkg remove transmission
echo "Transmission uninstall done."
echo ""
rm /bin/transmission*
rm /sbin/www/xmproot/.transmissionconfig/settings.json
rm /etc/init.d/S227transmission