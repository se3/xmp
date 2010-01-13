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
include_once("../lang/".$_SESSION['lang'].".lang.php");
include_once("func.php");

extract(stripslashes_r($_POST));

if(!is_file($file)) {
    echo $strWrongFile.": ".$file;
    exit();
}
$bn=substr(strrchr($file,'/'),1);
if(!($fp=@fopen($file,"wb"))) {
    echo $strCantWriteFile." ".$bn."..."; exit();
}
$content=str_replace("\r\n","\n",$content);
if(!@fwrite($fp,$content)) {
    @fclose($fp);
    echo $strCantWriteFile." ".$bn."..."; exit();
}
@fclose($fp);
echo $strFileSaved."...";
