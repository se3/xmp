#!/bin/sh

PATH=/opt/bin:/opt/bin:$PATH
nice -n 19 /opt/bin/transmission-daemon -g /root/transmission/
echo "Transmisssion-daemon started"
sleep 2
ps | grep transmission-daemon