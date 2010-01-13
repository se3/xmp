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

$dir=stripslashes_r($_POST['upload_dir']);
$type=$_POST['type'];
$new_name = stripslashes_r($_POST['new_name']);


if($type == 'remote') {
 $prog = $_POST['prog'];
 $remote_file = stripslashes_r($_POST['remote_file']);
 $progtype = $_POST['progtype'];
 if($new_name) $local_file=$dir."/".$new_name;
 else $local_file=$dir."/".substr(strrchr($remote_file,'/'),1);

 //echo "type=$progtype dir=$dir type=$type remote_file=$remote_file  local=$local_file"; exit();

 if($progtype=="copy") {
	@copy($remote_file,$local_file);
 }else {
    $remote_file=escapeshellarg($remote_file);
    $local_file=escapeshellarg($local_file);
    switch ($progtype) {
	case 'wget': $cmd=$prog." ".$remote_file." -O ".$local_file; break;
	case 'curl': $cmd=$prog." ".$remote_file." -o ".$local_file; break;
	case 'links': $cmd=$prog." -source ".$remote_file." > ".$local_file; break;
	case 'lynx':  $cmd=$prog." -source ".$remote_file." > ".$local_file; break;
    }
    //echo hc($cmd); exit();
    execute($cmd); 
 }
 
 if(!file_exists($local_file)) 
    echo "fm.showMessage('$strErrorUploadFile','filemanager-message',0,'warning.gif');";
 else echo "fm.hlfiles.push('".addslashes($local_file)."'); fm.showDir('".addslashes($dir)."'); ";
 
 exit();
} 
echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'></head><body>";

$file=$_FILES['upload_local_file']['tmp_name'];
  if(!file_exists($file)) {
    echo "<script type='text/javascript'>parent.fm.showMessage('$strErrorUploadFile','filemanager-message',1,'warning.gif');</script></body></html>";
    exit();
  }

  $file_name=$_FILES['upload_local_file']['name'];
  $file_size=$_FILES['upload_local_file']['size'];
  $error=$_FILES['upload_file']['error'];
  if($new_name) $full_file_name=$dir."/".$new_name;
  else $full_file_name=$dir."/".$file_name;
  $res = move_uploaded_file($file,$full_file_name);

  echo "<script type='text/javascript'>";
  echo "parent.fm.hideSrv(); ";
  if(!$res) echo "parent.fm.showMessage('$strErrorUploadFile : ".addslashes($full_file_name)."','filemanager-message',1,'warning.gif');";
  else echo " parent.fm.hlfiles.push('".addslashes($full_file_name)."'); parent.fm.showDir('".addslashes($dir)."');";

echo "</script></body></html>";
