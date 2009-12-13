#!/bin/sh

PATH="/opt/bin:/opt/sbin:$PATH"

echo "Be patient the unrar process maybe need lot fo time!"
echo "You can close this windows, the unrar will done in background."

if [ ! -f /opt/bin/busybox ]; then
   /opt/bin/ipkg install busybox
fi

if [ $# -ne 1 ]
then
  echo "U forgot to enter directory where i should work!"
  exit
fi


#for f in `find $1 -path *.r01 -or -path *.part1.rar -or -path *.part01.rar -or -path *.part001.rar | sed -e 's/ /[SPACE]/g'`
for f in `find $1 -path *.rar | sed -e 's/ /[SPACE]/g'`
do

f=`echo $f | sed -e 's/\[SPACE\]/ /g'`
echo "Start unpacking ("`date`"): " $f 
#" to " `dirname "$f"`
echo " to " `dirname "$f"`
echo "Start unpacking ("`date`"): " $f " to " `dirname "$f"` > `dirname "$f"`/unpack.log
echo "" >> `dirname "$f"`/unpack.log
/opt/bin/unrar e -o- -inul "$f" `dirname "$f"`
err=$?

if [ $err = 0 ]
then
# A kvetkezo par sor, ha kiveszed a #-eket akkor torli a rar fileokat, egyelore kikomenteztem, nem tudom benne hagyjam-e.
# A kovetkezo "echo "Delet option disabled"" sor suintaktikai hiba miatt van csak beszurva.
echo "Delet option disabled"
#echo "Unpack completed ("`date`"), deleting rar files in " `dirname "$f"`
#echo "Unpack completed ("`date`"), deleting rar files in " `dirname "$f"` >> `dirname "$f"`/unpack.log
#echo "" >> `dirname "$f"`/unpack.log
#rm `dirname "$f"`/*.sfv
#rm `dirname "$f"`/*.nfo
#rm `dirname "$f"`/*.r??
#rm -r `dirname $f`/Sample/
else

echo "[ERROR] ("`date`") Unrar failed on $f "
echo "[ERROR] ("`date`") Unrar failed on $f " >> `dirname "$f"`/unpack.log
fi


if [ $err = 255  ]
then
echo "[ERROR] ("`date`") User stopped the process (exit code 255)"
echo "[ERROR] ("`date`") User stopped the process (exit code 255)" >> `dirname "$f"`/unpack.log
fi
if [ $err = 9  ]
then
echo "[ERROR] ("`date`") Create file error (exit code 9)"
echo "[ERROR] ("`date`") Create file error (exit code 9)" >> `dirname "$f"`/unpack.log
fi
if [ $err = 8  ]
then
echo "[ERROR] ("`date`") Not enough memory for operation (exit code 8)"
echo "[ERROR] ("`date`") Not enough memory for operation (exit code 8)" >> `dirname "$f"`/unpack.log
fi
if [ $err = 7  ]
then
echo "[ERROR] ("`date`") Command line option error (exit code 7)"
echo "[ERROR] ("`date`") Command line option error (exit code 7)" >> `dirname "$f"`/unpack.log
fi
if [ $err = 6  ]
then
echo "[ERROR] ("`date`") Open file error (exit code 6)"
echo "[ERROR] ("`date`") Open file error (exit code 6)" >> `dirname "$f"`/unpack.log
fi
if [ $err = 5  ]
then
echo "[ERROR] ("`date`") Write to disk error (exit code 5)"
echo "[ERROR] ("`date`") Write to disk error (exit code 5)" >> `dirname "$f"`/unpack.log
fi
if [ $err = 4  ]
then
echo "[ERROR] ("`date`") Attempt to modify an archive previously locked by the 'k' command (exit code 4)"
echo "[ERROR] ("`date`") Attempt to modify an archive previously locked by the 'k' command (exit code 4)" >> `dirname "$f"`/unpack.log
fi
if [ $err = 3  ]
then
echo "[ERROR] ("`date`") A CRC error occurred when unpacking (exit code 3)"
echo "[ERROR] ("`date`") A CRC error occurred when unpacking (exit code 3)" >> `dirname "$f"`/unpack.log
fi
if [ $err = 2  ]
then
echo "[ERROR] ("`date`") A fatal error occurred (exit code 2)"
echo "[ERROR] ("`date`") A fatal error occurred (exit code 2)" >> `dirname "$f"`/unpack.log
fi
if [ $err = 1  ]
then
echo "[ERROR] ("`date`") Non fatal error(s) occurred (exit code 1)"
echo "[ERROR] ("`date`") Non fatal error(s) occurred (exit code 1)"  >> `dirname "$f"`/unpack.log
fi
if [ $err = 0  ]
then
echo "[OK] ("`date`") Successful operation (exit code 0)"
echo "[OK] ("`date`") Successful operation (exit code 0)" >> `dirname "$f"`/unpack.log
fi


done

echo "All unrar process DONE!"