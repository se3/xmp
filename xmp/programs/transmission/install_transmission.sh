#!/bin/sh

echo "Transmission install started."
/opt/bin/ipkg install transmission
echo "Transmission install done."
echo ""
cp -R /tmp/usbmounts/sda1/xmp/programs/transmission/preconf/* /
if [ ! -f /tmp/usbmounts/sda1/.transmissionconfig/settings.json ]; then cp -R /tmp/usbmounts/sda1/xmp/programs/transmission/config/* /tmp/usbmounts/sda1/.transmissionconfig/; fi
/bin/chmod 644 /etc/init.d/S227transmission