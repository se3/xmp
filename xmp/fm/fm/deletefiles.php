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

extract(stripslashes_r($_POST));

if(empty($files)) exit();


if(!is_array($files)) $files=array($files);
setenvlang();
$com=which("rm");
if($com) {
    foreach($files as $f) {
	if(is_dir($f)) {
	    exec($com." -r -f ".escapeshellarg($f)." 2>&1",$out);
	    if(!empty($out)) {
		echo "$strRmDirFailed ".hc($f)."<br>".hs($out[0])."...";
		exit();
	    }
	}else {
	    exec($com." -f ".escapeshellarg($f)." 2>&1",$out);
	    if(!empty($out)) {
		echo "$strDeleteFileError ".hc($f)."<br>".hs($out[0])."...";
		exit();
	    }
	}
    }
    echo "success";
    exit();
}
foreach($files as $f) {
	if(is_dir($f)) { 
	    rm_dir($f);
	    if(is_dir($f)) { echo "$strRmDirFailed ".hc($f)."..."; exit();   }
	}elseif(!@unlink($f)) {	echo "$strDeleteFileError ".hc($f)."..."; exit(); }
}
echo "success";
exit();
