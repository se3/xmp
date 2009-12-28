#!/bin/sh

PATH=/opt/bin:/opt/bin:$PATH
/opt/bin/transmission-daemon -g /tmp/usbmounts/sda1/xmp/programs/transmission/config/
echo "Transmisssion-daemon started"
sleep 2
ps | grep transmission-daemon