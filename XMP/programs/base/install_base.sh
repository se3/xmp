#!/bin/sh

cd /
tar -xvf /tmp/usbmounts/sda1/xmp/programs/base/install.tar
/opt/bin/ipkg update

echo "Copy preconfig."

cp -R /tmp/usbmounts/sda1/xmp/programs/base/preconf/* /
/bin/chmod 644 /etc/init.d/S45telnet
/bin/chmod 644 /etc/init.d/S55mount
echo "Copy done."
echo ""

echo ""
echo "ALL INSTALL DONE"
echo ""
echo "Installed programs:"
echo "- IPKG - package managger (updated package list)"
echo "- ntp"
echo "- cron"
echo "- unrar"
echo "- busybox"
echo ""
echo "- preconfig files"