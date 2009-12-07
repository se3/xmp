#!/bin/sh

echo "Midnight Commander install started. Be patient..."
/opt/bin/ipkg install mc
echo "Midnight Commander install done."
cp -R /tmp/usbmounts/sda1/xmp/programs/mc/preconf/* /
