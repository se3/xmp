#!/bin/sh

echo "Transmission install started."
/opt/bin/ipkg install transmission
echo "Transmission install done."
echo ""
cp -R /tmp/usbmounts/sda1/xmp/programs/transmission/preconf/* /
/bin/chmod 644 /etc/init.d/S227transmission