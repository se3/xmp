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
include_once("../../lang/".$_SESSION['lang'].".lang.php");
include_once("../../lib/func.php");
include_once("../../lib/sysfunc.php");
include_once("func.php");


extract(stripslashes_r($_POST));

setenvlang();

if(!is_dir($dir) && !@mkdir($dir)) { echo "$strMkDirFailed ".hc($dir); exit();  }

$res=extract_files($archive,$dir,$type);

if($type != "zip") {
    if(!empty($res)) { echo $strExtractFailed." ".hc($archive)."<br>".hs($res[0]); exit(); }
    if($type == "gz" || $type == "bz2") {
	$bn=substr($archive,0,strrpos($archive,'.'));
	@rename($bn,$dir."/".basename($bn));
    }
    echo "success";
    exit();    
}else {
    if(!$res) { echo $strExtractFailed." ".hc($archive)."<br>".hc($ar->errorInfo(true)); exit(); }
    echo "success";
}
exit();

