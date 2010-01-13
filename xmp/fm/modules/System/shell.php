<?php
/*
 * Asterisk Management System - An open source toolkit for Asterisk PBX.
 * See http://www.asterisk.org for more information about
 * the Asterisk project.
 *
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
include_once("../../lib/func.php");
include_once("../../lib/sysfunc.php");
$action=trim(stripslashes_r($_POST['action']));
$dir=stripslashes_r($_POST['dir']);
$ind=$_POST['ind'];
//echo $action ; exit();
if(empty($action)) { echo "<br/>"; exit();}

if(substr($action,0,2) == "cd") $cd=1;

function prepareCmd($cmd) {

    //return str_replace("\\;",";",escapeshellcmd($cmd));
    //return $cmd;
    $newcmd=$cmd;
    $c=count_chars($cmd);
    $c[ord("\"")] % 2 ? $newcmd=substr($newcmd,0,strrpos($newcmd,"\""))."\\".substr($newcmd,strrpos($newcmd,"\"")):0;
    $c[ord("'")] % 2 ? $newcmd=substr($newcmd,0,strrpos($newcmd,"'"))."\\".substr($newcmd,strrpos($newcmd,"'")):0;
    return $newcmd;
}

setenvlang();
if(is_dir($dir)) @chdir($dir);
$res = execute(prepareCmd($action)." 2>&1");
//$res = system(prepareCmd($action)." 2>&1");

if(!empty($res)) {
    $arr = explode("\n",$res);
    echo "<table width='90%' border='0' cellspacing='0' cellpadding='1' style='margin: 5px; font-size: 12px; font-family: courier new,monospace;'><tr><td>";

    foreach($arr as $o) {
	echo "&nbsp;&nbsp;&nbsp;".str_replace(" ","&nbsp;",hs($o))."<br>";
    }	
    echo "</td></tr></table>";
} else echo "&nbsp;";
 
if(empty($res) && $cd) {
    $path=trim(substr($action,2));
    if(strpos($path,".") !== false) $newpath=realpath($dir."/".$path);
    elseif(strpos($path,"/") !== false) $newpath=realpath($path);
    else $newpath=realpath($dir."/".$path);
    if(is_dir($newpath))
	echo "<script> sys.wins[$ind].cd='".addslashes($newpath)."' ;</script>";

}
