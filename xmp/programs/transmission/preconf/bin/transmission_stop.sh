#!/bin/sh

echo "Wait a moment please! The script will stop all torrents up & downloads."
/opt/bin/transmission-remote -t all -S
sleep 10
killall transmission-daemon
echo "Transmission-daemon stopped. Configuration saved to /sbin/www/xmproot/.transmissionconfig/settings.json"

sleep 5
ps | grep transmission-daemon | grep -v grep
