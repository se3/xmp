#!/bin/sh

echo "installing uclibc-opt "
if [ ! -f uclibc-opt_0.9.28-13_mipsel.ipk ]; then wget http://ipkg.nslu2-linux.org/feeds/optware/oleg/cross/stable/uclibc-opt_0.9.28-13_mipsel.ipk; fi
./ipkg-cl install uclibc-opt_0.9.28-13_mipsel.ipk 

echo "installing ipkg-opt"
if [ ! -f ipkg-opt_0.99.163-10_mipsel.ipk ]; then wget http://ipkg.nslu2-linux.org/feeds/optware/oleg/cross/stable/ipkg-opt_0.99.163-10_mipsel.ipk; fi
./ipkg-cl install ipkg-opt_0.99.163-10_mipsel.ipk

# check if /opt/bin/ipkg installed properly
if [ -f /opt/bin/ipkg ]; then

   echo "update opt package"
   /opt/bin/ipkg update
   
   echo "installing cron for timer jobs"
   /opt/bin/ipkg install cron
   
   echo "installing ntp for time synchronization"
   /opt/bin/ipkg install ntp
   
   echo "installing unrar for unpack rar files"
   /opt/bin/ipkg install unrar
   
   echo "Copy preconfig."
   cp -R preconf/* /
   
   /bin/chmod 644 /etc/init.d/S45telnet
   /bin/chmod 644 /etc/init.d/S55mount
   
   echo ""
   echo "ALL INSTALL DONE"
   echo "INSTALLED OPTWARE PROGRAMS:"
   /opt/bin/ipkg list_installed
   echo ""
   echo "- preconfig files"
   
else

   echo "INSTALL FAILED - missing internet connection?"
fi
