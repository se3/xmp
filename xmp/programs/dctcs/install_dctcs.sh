#!/bin/sh
   
   echo "install enhanced-ctorrent"
   /opt/bin/ipkg install enhanced-ctorrent
   
   echo "Copy dctcs preconfig."
   cp -R preconf/* /
   
   /bin/chmod 644 /etc/init.d/S228dctcs
   
   echo ""
   echo "ALL INSTALL DONE"
