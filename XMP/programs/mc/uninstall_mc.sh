#!/bin/sh

echo "Midnight Commander uninstall started. Be patient..."
/opt/bin/ipkg remove mc
echo "Midnight Commander uninstall done."

rm /bin/mc