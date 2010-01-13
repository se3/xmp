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
include_once("func.php");
include_once("pclzip/pclzip.lib.php");
include_once("phpmailer/class.phpmailer.php");

extract(stripslashes_r($_POST));

if(empty($client_charset)) $client_charset="UTF-8";
elseif($client_charset != "UTF-8") {
    $subject = iconv("UTF-8",$client_charset,$subject);
    $body = iconv("UTF-8",$client_charset,$body);
}
$from = $from ? $from : $defaultFromAddress;;
$from_name = $from_name ? $from_name : $defaultFromName;


$mail = new PHPMailer();
if(!empty($files)) {
    //$files = explode(",",$files);
    if(count($files) > 1 || is_dir($files[0])) {
	
        if($zip_name) $file=$tmp_dir."/".$zip_name;
        else $file=$tmp_dir."/".date("Y-m-d_H-i")."_archive.zip";
	$archive = new PclZip($file);
	$path=find_path($files,dirname($files[0]));
	if($path == '/') $res=$archive->create($files,PCLZIP_OPT_REMOVE_ALL_PATH);
	else $res=$archive->create($files,PCLZIP_OPT_REMOVE_PATH,$path);
	if(!$res) {
	    echo $strErrorCreatingZip; exit();
	}
	$zip=1;
    }else $file=$files[0];
    $mail->AddAttachment($file);

}

$mail->From = $from; 
$mail->FromName = $from_name;
$mail->Host=$mail_host;
$mail->Mailer=$mailer;
$mail->Body=$body;
$mail->CharSet=$client_charset;
//$mail->AltBody=$body;
$mail->AddAddress($address);
$mail->Subject=$subject;


if(!$mail->Send()) echo $strMailError;
else echo "success";
if($zip) @unlink($file);
exit();

