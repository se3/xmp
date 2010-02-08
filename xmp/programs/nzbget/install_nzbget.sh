#!/bin/sh


echo "NZBGet install started."
/opt/bin/ipkg install nzbget
echo "NZBGet install done."
echo ""

# Trying to cp source opt/ to / fails as dest /opt is a symlink.
# Must use the following trick to make it work :
cp -R /sbin/www/xmp/programs/nzbget/preconf/opt/* /opt