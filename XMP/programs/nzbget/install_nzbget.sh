#!/bin/sh


echo "NZBGet install started."
/opt/bin/ipkg install nzbget
echo "NZBGet install done."
echo ""

cp -R /tmp/usbmounts/sda1/xmp/programs/nzbget/preconf/* /