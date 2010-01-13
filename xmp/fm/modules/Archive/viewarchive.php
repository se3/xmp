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
include_once("../../config.php");
include_once("../../lang/".$_SESSION['lang'].".lang.php");
include_once("../../lib/func.php");
include_once("../../lib/sysfunc.php");
include_once("func.php");

extract(stripslashes_r($_POST));
$theme=$_SESSION['theme'];

if(empty($archive)) exit();

list($ar_basename,$bname,$type)=get_ar_type($archive);
if(empty($type)) exit();

setenvlang();
$dir=$tmp_dir."/fm_archive_tmp";

if(!is_dir($dir) && !@mkdir($dir)) { 
    echo $strErrorLookingArchive; exit();  
}



clear_ar_tmp_dir($dir);
$r=glob($dir.'/*');
if(!empty($r)) { echo $strErrorLookingArchive; exit();  }

$res=extract_files($archive,$dir,$type);

include("../../fm/showdir.php");





