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
include_once("func.php");

extract(stripslashes_r($_REQUEST));

if(empty($file)) exit();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>		
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body onload="
if(parent.isIE || parent.isOpera){
     try {document.execCommand('print',false);} catch (e) {};
}else {
    try {window.print()} catch (e) {};
}" style="font-size: 11px; font-family: verdana,sans;">

<?
echo str_replace("\r\n","<br>",$content);
?>
</body>
</html>

