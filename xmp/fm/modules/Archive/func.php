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

function extract_files($archive,$dir,$type) {
    if($type != "zip") {
	switch ($type) {
	    case "targz": case "tgz": $cmd=which("tar")." xfz ".escapeshellarg($archive)." -C ".escapeshellarg($dir); break;
	    case "tarbz2": $cmd=which("tar")." xfj ".escapeshellarg($archive)." -C ".escapeshellarg($dir); break;    
	    case "tar": $cmd=which("tar")." xf ".escapeshellarg($archive)." -C ".escapeshellarg($dir); break;
	    case "gz": $cmd=which("gzip")." -dq ".escapeshellarg($archive); break;
	    case "bz2": $cmd=which("bzip2")." -dq ".escapeshellarg($archive); break;
	    default: exit();
	}
	exec($cmd." 2>&1",$res);    
	return $res;
    }
    if($type == "zip") {
	require_once("../../lib/pclzip/pclzip.lib.php");
	$ar = new PclZip($archive);
	return $ar->extract(PCLZIP_OPT_PATH,$dir);
    }
}
function get_ar_type($archive) {
    $ar_basename=substr(strrchr($archive,'/'),1);
    $ext = strtolower(substr(strrchr($archive,'.'),1));
    $bname=substr($archive,0,strrpos($archive,'.'));
    $ext2 = strtolower(substr(strrchr($bname,'.'),1));
    if($ext2 == "tar") {
	if($ext == "gz") $type="targz";
	elseif($ext == "bz2") $type="tarbz2";
	$bname=substr($archive,0,strrpos($bname,'.'));
    }else {
	if($ext == "gz") $type="gz";
	elseif($ext == "tgz") $type="targz";
	elseif($ext == "bz2") $type="bz2";
	elseif($ext == "tar") $type="tar";
	elseif($ext == "zip") $type="zip";
    }
    return array($ar_basename,$bname,$type);
}
function clear_ar_tmp_dir($dir){
    foreach(glob($dir.'/*') as $file) {
	execute(which("rm")." -r -f ".escapeshellarg($file));
    }
}
