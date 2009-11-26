#!/bin/sh
count=0
while [ $count -lt 10 ]; do

#date
#echo ./ddns_client `tail -2 /usr/local/etc/setup.php | cut -c 6-`
/sbin/www/ddns_client `grep DDNS /usr/local/etc/setup.php |cut -c 6-`
sleep 300
done
