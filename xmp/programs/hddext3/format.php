<?php

$retval = 1;

echo '<pre>';
echo "format internal HDD in ext3 file system started....";
flush();
sleep(1);
$fs_sda1 = exec("mount | grep /dev/scsi/host0");
if( $fs_sda1 )
   system('umount /tmp/usbmounts/sda1', $retval);
else
   $retval = 0;
   
if (0 == $retval) {
   echo "umount /tmp/usbmounts/sda1 was successfull, now 'mkfs.ext3 /dev/sda1 -L xtreamerhdd' will be processed!\n";
   flush();
   flush();
   system('mkfs.ext3 /dev/sda1 -L xtreamerhdd', $retval );
   if (0 == $retval) {
      echo "HDD format in ext3 fs was successfull, now mount hdd will be processed!\n";
      flush();
      system('mount /dev/scsi/host0/bus0/target0/lun0/part1 /tmp/usbmounts/sda1', $retval);
      if (0 == $retval) {
        echo "mount of internal HDD was successfull, now reboot system!\n";
      }else {
        echo "mount of internal HDD failed, but after reboot system it is available!\n";
      }
   }
   else {
      echo "HDD format in ext3 fs failed or aborted, please try again !\n";
   }
}else{
   echo "umount /tmp/usbmounts/sda1 failed !\n";
}
echo '</pre>';
if ( $retval == "0") echo 'Done.'; else echo 'Failed! Please reboot and try again!';
?>
<script type="text/javascript">
$('#mainFrame').load('www/programs.php');
</script>
