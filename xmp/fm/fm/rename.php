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

$oldname=stripslashes_r($_POST['oldname']);
$newname=stripslashes_r($_POST['newname']);

if(is_file($newname) || is_dir($newname)) {
    echo $strRenameFailed.": ".$strFileExists.": ".hc($newname);
    exit();
}
setenvlang();
$com = which("mv");
if($com) {
    exec($com." -f ".escapeshellarg($oldname)." ".escapeshellarg($newname)." 2>&1",$out);
    if(!empty($out)) echo $strRenameFailed."...<br>".hs($out[0])."...";
    else echo "success";
    exit();
}
if(@rename($oldname,$newname)) echo "success";
else echo $strRenameFailed;
exit();
?>	
