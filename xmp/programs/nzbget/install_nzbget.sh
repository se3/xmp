#!/bin/sh


echo "NZBGet install started."
/opt/bin/ipkg install nzbget
echo "NZBGet install done."
echo ""

cp -R /sbin/www/xmp/programs/nzbget/preconf/* /