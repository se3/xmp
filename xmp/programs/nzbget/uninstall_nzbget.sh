#!/bin/sh

echo "NZBGet uninstall started."
/opt/bin/ipkg remove nzbget
echo "NZBGet uninstall done."
echo ""

rm /opt/etc/nzbget.conf