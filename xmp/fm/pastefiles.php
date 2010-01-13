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
include_once("../config.php");
include_once("../lib/func.php");
include_once("../lib/sysfunc.php");

extract(stripslashes_r($_POST));

if(empty($dir) || empty($files) || empty($action)) exit();

if($action=="copy") $com=which("cp");
else $com=which("mv");

$ind=0;

$script="<script>";
setenvlang();

foreach($files as $src) {

    $dest=$dir."/".substr(strrchr($src,'/'),1);
    if(($action=="cut") && ($src == $dest)) continue;
    $isdest=is_file($dest);
    if($action == "cut" && $isdest) {
	echo $script."</script>";
    	echo "$strMoveError: $strFileExists - <font color='red'>".hc($dest)."</font>";
	exit();
    }
    if($action=="copy" && $isdest) {
	$n=2;
	if($i=strrpos($dest,'.')) {
	    $first=substr($dest,0,$i);
	    $last=substr($dest,$i);
	} else {
	    $first=$dest; $last="";
	}
	while(is_file($first."_".$n.$last)) $n++;
	$dest=$first."_".$n.$last;
    }
    if($com) {
	$cmd=$com." -f ";
	if(is_dir($src) && $action=="copy") $cmd=$com." -R ";
	exec("$cmd ".escapeshellarg($src)." ".escapeshellarg($dest)." 2>&1",$out);
	if(!empty($out)) {
	    echo $script."</script>";
	    if($action="copy") echo "$strCopyError: ";
	    else echo "$strMoveError: ";
	    echo "<font color='green'>".hc($src)."</font> -> <font color='red'>".hc($dest)."</font><br>".hs($out[0]);
	    exit();
	}
    }else {
	if($action == "copy" && !@copy($src,$dest)) { echo $script."</script>$strCopyError: <font color='green'>".hc($src)."</font> -> <font color='red'>".hc($dest)."</font>"; exit(); }
	elseif(!@rename($src,$dest)) { echo $script."</script>$strMoveError: <font color='green'>".hc($src)."</font> -> <font color='red'>".hc($dest)."</font>"; exit(); }	
    }
    $script.=" fm.hlfiles[$ind]='".addslashes($dest)."'; ";
 $ind++;
}
echo $script."</script>";
echo "success";
exit();
?>