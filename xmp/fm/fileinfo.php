<?php
/*
 * Copyright (C) 2006 - 2007, West-Web Limited.
 *
 * Nickolay Shestakov <ns@ampex.ru>
 *
 * This program is free software, distributed under the terms of
 * the GNU General Public License Version 2. See the LICENSE file
 * at the top of the source tree.
 */
session_start();
if(!$_SESSION['fm_entry']) die('Not a Valid Entry');
include_once("../lang/".$_SESSION['lang'].".lang.php");
include_once("../lib/func.php");
include_once("../lib/sysfunc.php");

$file=stripslashes_r($_POST['file']);

$isfile=is_file($file);
$isdir=is_dir($file);

if(!$isfile && !$isdir) { 

    echo "<center><br><font color=red>$strCantGetFileInfo...</font><br><br></center>"; exit(); 

}

echo "<table  cellspacing=1 cellpadding=0 style=\"margin: 3px;font-size: 10px; font-family: verdana,sans;\">";
if($isdir) {
    echo "<tr><td>".$strFileType.":</td><td> Directory </td></tr>";

} else {
    $res = execute(which("file")." ".escapeshellarg($file));
    $res = explode(":",$res);
    echo "<tr><td valign=\"top\">".$strFileType.":</td><td> ".array_pop($res)."</td></tr>";
}
    $stat=@stat($file);
    $perms=@fileperms($file);
    $dsize=@disk_total_space($file);
    $fsize=@disk_free_space($file);
    echo "<tr><td>$strFileRights:</td><td> ".getFilePerms($perms)." (".substr(sprintf('%o',$perms),-4).")</td></tr>";
    $owner=posix_getpwuid($stat[4]);
    $group=posix_getpwuid($stat[5]);
    if(empty($group['name'])) $group['name']="-1";
    echo "<tr><td>$strFileOwner:</td><td>  ".$owner['name']."/".$group['name']."</td></tr>";
    echo "<tr><td>$strFileSize:</td><td>  ".$stat[7]."</td></tr>";
    echo "<tr><td>$strFileLastAccess:</td><td> ".dbformat_to_dt(date("Y-m-d H:i:s",$stat[8]))."</td></tr>";
    echo "<tr><td>$strFileLastModified:</td><td> ".dbformat_to_dt(date("Y-m-d H:i:s",$stat[9]))."</td></tr>";
    echo "<tr><td nowrap>$strTotalSpace:</td><td> ".formatSize($dsize)."</td></tr>";
    echo "<tr><td nowrap>$strFreeSpace:</td><td> ".formatSize($fsize)."</td></tr>";
    echo "</table>";
    exit();

echo "</div>";
exit();
?>