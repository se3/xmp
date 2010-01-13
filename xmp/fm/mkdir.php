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

$dir=stripslashes_r($_POST['dir']);
setenvlang();
$com=which("mkdir");

if($com) {
    exec($com." -p ".escapeshellarg($dir)." 2>&1",$out);
    if(!empty($out)) echo $strMkDirFailed.": ".hc($dir)."<br>".hs($out[0]);
    else  echo "success";
    exit();
}
if(@mkdir($dir)) echo "success";
else echo $strMkDirFailed.": ".hc($dir);
exit();