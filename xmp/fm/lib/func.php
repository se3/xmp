<?php

function stripslashes_arr($arr) {

    $newArr = array();
    foreach($arr as $key => $value) {
	$newArr[$key] = (is_array($value)) ? stripslashes_r($value) : stripslashes($value);
    }
    return $newArr;
}
function is_empty($val) {

    return (!isset($val) || $val == "");
}

function stripslashes_r($val) {
    if(!get_magic_quotes_gpc()) return $val;
    if(is_array($val)) return stripslashes_arr($val);
    return stripslashes($val);
}

function dt_to_dbformat($dt,$sec) {
    switch ($_SESSION['dateformat']) {
	case "21-12-2006":
	case "21/12/2006":
	case "21.12.2006":
	    return (substr($dt,6,4)."-".substr($dt,3,2)."-".substr($dt,0,2)." ".substr($dt,11,2).":".substr($dt,14,2).":$sec");
	case "2006-12-21":
	    return ($dt.":$sec");	    
	case "12-21-2006":
	    return (substr($dt,6,4)."-".substr($dt,0,2)."-".substr($dt,3,2)." ".substr($dt,11,2).":".substr($dt,14,2).":$sec");
	default: return ($dt.":$sec");	    

    }
}

function dbformat_to_dt($dt) {
    switch ($_SESSION['dateformat']) {
	case "21-12-2006":
	    return (substr($dt,8,2)."-".substr($dt,5,2)."-".substr($dt,0,4)." ".substr($dt,11,5));
	case "21/12/2006":
	    return (substr($dt,8,2)."/".substr($dt,5,2)."/".substr($dt,0,4)." ".substr($dt,11,5));
	case "21.12.2006":
	    return (substr($dt,8,2).".".substr($dt,5,2).".".substr($dt,0,4)." ".substr($dt,11,5));
	case "2006-12-21":
	    return substr($dt,0,16);	    
	case "12-21-2006":
	    return (substr($dt,5,2)."-".substr($dt,8,2)."-".substr($dt,0,4)." ".substr($dt,11,5));
	default: return substr($dt,0,16);	    

    }
}

function showMsg($str,$container="",$hide=0,$img="",$style="") {
    if(empty($container)) {
	if($style) $style="style=\"$style\"";
	echo "<div class='module-warning' $style>";
	if($img) echo "<img align='absmiddle' src='images/note.gif' alt='' />&nbsp;";
	echo "$str</div>"; return;
    }
    echo "<script> ams.showMessage('".addslashes($str)."','$container',$hide,'$img'); </script>";
}

function ah($var) {
    return addslashes(htmlspecialchars($var));
}

function hc($var) {
    return htmlspecialchars($var);
}

function hs($var) {
    return htmlspecialchars(stripslashes($var));
}

function getStr($val) {
    global ${"str".$val};
    $str = ${"str".$val};
    return $str ? $str : $val;
}

function formatSize($bytes) {
    
    if($bytes > 10485760) return (int) ($bytes/1048576)." M";
    else if($bytes > 10240) return (int) ($bytes/1024)." K";
    return $bytes;
}

function find_path($files,$path) {
    if($path=='/') return '/';
    foreach($files as $f) {
	if(strpos(dirname($f),$path) === 0) continue;
	return find_path($files,dirname($path));
    }
    return $path;
}

function top_dir($path) {
    global $filemanager_dirs;
    foreach($filemanager_dirs as $f) {
	if($path == $f) return true;
	if(strpos($path,$f) === 0) return false;
    }
    return true;
}
function s_glob( $dir, &$dirs, $files=false, $p=false ) {
    if($dh=@opendir($dir)) {
	if($dir=='/') $dir="";
	while(false !== ($file = @readdir($dh))) {
	    if($p && !fnmatch($p,$file)) continue;
	    $f=$dir.'/'.$file;
	    if(is_dir($f)) { if($file{0} != ".")  $dirs[]=$f; }
	    elseif($files !== false) 	$files[]=$f; 
	}
	@closedir($dh);
    }
}
function is_dir_tree($dir) {
    if($dh=@opendir($dir)) {
    	if($dir=='/') $dir="";
	while(false !== ($file = @readdir($dh))) {
	    if(is_dir($dir.'/'.$file) && $file{0} != ".") { @closedir($dh); return true; }
	}
    }
    @closedir($dh);
    return false;
}
