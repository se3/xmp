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
if(!$_SESSION['ams_entry']) die('Not a Valid Entry');
//include_once("lang/".$_SESSION['lang'].".lang.php");
include_once("func.php");
include_once("sysfunc.php");

extract(stripslashes_r($_POST));

if(empty($files)) exit();
if(!is_array($files)) $files=array($files);

setenvlang();
foreach($files as $f) {
    if(is_dir($f)) {
	exec("rm -r -f ".escapeshellarg($f)." 2>&1",$out);
	if(!empty($out)) {
	    echo hs($out[0])."...";
	    exit();
	}
    }
    else {
	exec("rm -f ".escapeshellarg($f)." 2>&1",$out);
	if(!empty($out)) {
	    echo hs($out[0])."...";
	    exit();
	}
    }
}
echo "success";
exit();
?>

