<?
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
include_once("../../lib/func.php");
include_once("../../lib/sysfunc.php");
extract(stripslashes_r($_POST));
//$theme=$_SESSION['theme'];
if(empty($dir) || !is_dir($dir)) exit();
include_once("../../config.php");

if(!isset($pattern) || $pattern=="") $pattern="*";

$dirs=array();
$files=array();

function search($dir) {
    global $pattern,$dirs,$files;
    if($dh=@opendir($dir)) {
	if($dir =="/") $dir="";
	while(false !== ($file = @readdir($dh))) {
	    $f=$dir.'/'.$file;
	    if(is_dir($f)) { if($file{0} != ".") { if(fnmatch($pattern,$file)) $dirs[]=$f; search($f); }}
	    elseif(fnmatch($pattern,$file)) $files[]=$f;	
	}
    
	@closedir($dh);
    }

}
if(empty($content)) search($dir);
else {

    if(empty($case)) $case="-i";
    else $case="";
    exec(which("grep")." -R $case -l ".escapeshellarg($content)." ".escapeshellarg($dir)."/".$pattern,$files);
}

if(empty($dirs) && empty($files)) echo "<i>$strNotFound</i>";

include("../../fm/showdir.php");
exit();
