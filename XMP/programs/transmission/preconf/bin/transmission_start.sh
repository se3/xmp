#!/bin/sh

PATH=/opt/bin:/opt/bin:$PATH
/opt/bin/transmission-daemon -g /root/transmission/
echo "Transmisssion-daemon started"
sleep 2
ps | grep transmission-daemon