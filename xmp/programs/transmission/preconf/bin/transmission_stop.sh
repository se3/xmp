#!/bin/sh

echo "Wait a moment please! The script will stop all toretn up & download."
/opt/bin/transmission-remote -t all -S
sleep 10
killall transmission-daemon
echo "Transmission-daemon stoped. Configuration saved to /root/.transmission/settings.json"

sleep 5
ps | grep transmission-daemon