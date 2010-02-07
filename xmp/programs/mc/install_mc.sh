#!/bin/sh

echo "Midnight Commander install started. Be patient..."
/opt/bin/ipkg install mc
echo "Midnight Commander install done."
cp -R /sbin/www/xmp/programs/mc/preconf/* /
