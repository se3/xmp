#!/bin/sh

if [ ! $1 = "root" ]; then
   echo "make symbolic link from /opt to /tmp/usbmounts/"$1"/opt"
   if [ -d /tmp/usbmounts/$1 ]; then 
      rm -R /opt
      mkdir /tmp/usbmounts/$1/opt
      ln -s /tmp/usbmounts/$1/opt /opt
   else
      echo "make symbolic link failed => /tmp/usbmounts/$1 does not exist. Restart system and try again."
   fi
fi

if [ ! -f /opt/bin/ipkg ]; then

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
      
      # Trying to cp source opt/ to / fails as dest /opt is a symlink.
      # Must use the following trick to make it work :
      cp -R preconf/opt/* /opt/
      
      /bin/chmod 644 /etc/init.d/S45telnet
      
      echo ""
      echo "ALL INSTALL DONE"
      echo "INSTALLED OPTWARE PROGRAMS:"
      /opt/bin/ipkg list_installed
      echo ""
      echo "- preconfig files"
      
   else   

      echo "INSTALL FAILED - missing internet connection?"
   fi
else
   echo "Copy preconfig."
   cp -R preconf/* /
          
   /bin/chmod 644 /etc/init.d/S45telnet
      
   echo "INSTALLATION already exist"
   echo "INSTALLED OPTWARE PROGRAMS:"
   /opt/bin/ipkg update
   /opt/bin/ipkg list_installed
fi

# Move transmission config
if [ -d /root/transmission ]; then
   echo "Move transmission config to new location. Please reinstall transmission"
   if [ ! -d /sbin/www/xmproot/.transmissionconfig ]; then
      mkdir /sbin/www/xmproot/.transmissionconfig
   fi
   cp -R /root/transmission/* /sbin/www/xmproot/.transmissionconfig
   rm -R /root/transmission
fi
