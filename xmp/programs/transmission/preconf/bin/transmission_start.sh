#!/bin/sh

PATH=/opt/bin:/opt/bin:$PATH
nice -n 19 /opt/bin/transmission-daemon -g /sbin/www/xmproot/.transmissionconfig/
echo "Transmission-daemon started"
sleep 2
ps | grep transmission-daemon | grep -v grep
