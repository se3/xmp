#!/bin/sh

sda1endblock=`fdisk -l | grep /dev/sda1 | grep -v Disk  | awk '{ print $3 }'`
sda2startblock=`expr $sda1endblock + 1`

if [ $sda1endblock -lt $sda2startblock -a $sda1endblock -gt 1 ]; then
   
   umount /tmp/usbmounts/sda1/   
   dd if=/dev/zero of=/dev/sda bs=1M count=100
   
   echo -e "n\np\n1\n2\n${sda1endblock}\nn\np\n2\n${sda2startblock}\n\nt\n1\n83\nt\n2\n82\nw\n" > /tmp/create_sda
   #cat /tmp/create_sda
   fdisk /dev/sda < /tmp/create_sda
   
   mke2fs -j /dev/sda1
fi