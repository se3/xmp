<?php
function getFilePerms($perms) {
    //$perms = fileperms($file);
    if (($perms & 0xC000) == 0xC000) {$info = 's'; } // Socket
    elseif (($perms & 0xA000) == 0xA000) {$info = 'l'; } // Symbolic Link
    elseif (($perms & 0x8000) == 0x8000) {$info = '-'; } // Regular
    elseif (($perms & 0x6000) == 0x6000) {$info = 'b'; } // Block special
    elseif (($perms & 0x4000) == 0x4000) {$info = 'd'; } // Directory
    elseif (($perms & 0x2000) == 0x2000) {$info = 'c'; } // Character special
    elseif (($perms & 0x1000) == 0x1000) {$info = 'p'; } // FIFO pipe
    else {$info = '?';} // Unknown
    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
       (($perms & 0x0800) ? 's' : 'x' ) :
       (($perms & 0x0800) ? 'S' : '-'));
    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
          (($perms & 0x0400) ? 's' : 'x' ) :
          (($perms & 0x0400) ? 'S' : '-'));
    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
       (($perms & 0x0200) ? 't' : 'x' ) :
       (($perms & 0x0200) ? 'T' : '-'));
  return $info;
}

function dirSize($dir)
{
    $handle = opendir($dir);
    
    while ($file = readdir($handle)) {
        if ($file != '..' && $file != '.' && !is_dir($dir.'/'.$file)) {
            $mas += filesize($dir.'/'.$file);
            } else if (is_dir($dir.'/'.$file) && $file != '..' && $file != '.') {
            $mas += dir_size($dir.'/'.$file);
        }
    }
    return $mas;
}

function execute($cmd) {
    if (empty($cmd)) return "";
    $res = '';
    $df = @ini_get('disable_functions');
    if($df == '') $df=array('');
    if(function_exists('exec') && !in_array('exec',$df)) {
	@exec($cmd,$res);
	$res = join("\n",$res);
    } elseif(function_exists('shell_exec') && !in_array('shell_exec',$df)) {
	$res = @shell_exec($cmd);
    } elseif(function_exists('system') && !in_array('system',$df)) {
	@ob_start();
	@system($cmd);
	$res = @ob_get_contents();
	@ob_end_clean();
    } elseif(function_exists('passthru') && !in_array('passthru',$df)) {
	@ob_start();
	@passthru($cmd);
	$res = @ob_get_contents();
	@ob_end_clean();
    }
    return $res;
}

function which($prog) {
    $path = execute("which $prog");
    if(!empty($path)) return $path; 
    return '';
}
function setenvlang() {
    $lang=$_SESSION['lang'];
    putenv("LANG=".substr($lang,0,2)."_".strtoupper(substr($lang,3,2)).".UTF-8");
}

function rm_dir($dir){
	$cont=glob($dir.'/*');
	foreach($cont as $file) {
	    if(is_dir($file) && !is_link($file)) rm_dir($file);
	    else @unlink($file);
	}
	@rmdir($dir);
}
