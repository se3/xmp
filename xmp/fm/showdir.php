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
@include_once("../config.php");
@include_once("../lib/func.php");

extract(stripslashes_r($_POST));
$theme=$_SESSION['theme'];
if(empty($dir) || !is_dir($dir)) exit();


function fileIcon($ext) {
    global $audio_exts,$theme;
    switch ($ext) {
	case 'mp3': $img="audio_fm.gif"; break; 
	case 'ini': case 'conf': case 'cfg': case 'txt': case 'cnf':
	case 'pl': case 'conf' : $img="txt_fm.gif"; break; 
	case 'pdf' : $img="pdf_fm.gif"; break; 
	case 'doc' : $img="doc_fm.gif"; break; 
	case 'gif' : case 'jpeg': case 'jpg': case 'tif': 
	case 'tiff': case 'png': case 'bmp': case 'ico' : $img="img_fm.gif"; break; 
	case 'html': case 'htm' : $img="html_fm.gif"; break; 
	case 'tar': case 'tgz': case 'bz2': case 'gz': case 'rar': case 'zip' : $img="rar_fm.gif"; break; 
	case 'css': case 'js': case 'php': $img="web_fm.gif"; break; 
	default: if(in_array($ext,$audio_exts)) $img="audio_fm.gif"; else return "";
    }
    return "<img align='absmiddle' src='themes/$theme/images/$img'>";
}

if(!isset($pattern) || $pattern=="*") $pattern=false;

$top=true;


if(!isset($files)) {
    $top = (in_array($dir,$filemanager_dirs) || $dir == '/');
    $dirs=array(); $files=array();
    s_glob($dir,&$dirs,&$files,$pattern);
    sort($dirs); sort($files);
}
$num_files = count($files);
$num_dirs=count($dirs);

$total_num=$num_files+$num_dirs;

if($total_num > 25) $lines=(int) ($total_num/2);
else $lines=25;


?>
<script>
 fm.totalNum=<?=$total_num?>;
 fm.right.clear();
 fm.rightId = new Object();
</script>
<table border="0" width="95%" cellpadding="0" cellspacing="0" style="margin-top: 2px;">
<tr><td width="50%" valign="top">
<table border="0" width="100%" cellpadding="0" cellspacing="0" ><?
  if(!$top) {
    $dd = addslashes(htmlspecialchars(substr($dir,0,strrpos($dir,'/'))));
    if($dd=="") $dd="/";
    ?>
    <tr><td width="14" align="center" nowrap>
    <a href="javascript:fm.showDir('<?=$dd?>')">
    <img align="absmiddle" src="themes/<?=$theme?>/images/folder_closed3.gif">
    </a></td>
    <td><a href="javascript:fm.showDir('<?=$dd?>')">..</a>
    </td><td>&nbsp;</td>
    </tr><?  $lines--;
}   
$id=0;
for($ind=0,$i=0;$i < $num_dirs;$i++){
	$d=$dirs[$i];

	if(in_array($d,$filemanager_dirs)) continue;
	if(is_link($d)) $d_bn="~".htmlspecialchars(substr(strrchr($d,'/'),1));
	else $d_bn=htmlspecialchars(substr(strrchr($d,'/'),1));
        $id++; 
	$b=addslashes($d);
	$d=addslashes(htmlspecialchars($d));
	?><script>
	    fm.right[<?=$ind?>]='<?=$b?>';
	    fm.rightId['<?=$b?>']='<?=$id?>';
	    if(!fm.tree['<?=$b?>']) fm.createTree('<?=$b?>');
	</script>
	<tr>
	<td align="center" width="14" height="16" nowrap>
	<a href="javascript:fm.showDir('<?=$d?>')">
	<img align="absmiddle" src="themes/<?=$theme?>/images/folder_closed3.gif">
	</a></td>
	<td id="<?=$id?>-cell" valign="top">
	<a href="javascript:void(0)" id="<?=$id?>" 
	 ondblclick="fm.showDir('<?=$d?>')" onclick="fm.onClick('<?=$d?>',event);" 
	 oncontextmenu="fm.onContextMenu(this,'<?=$d?>',event);" 
	 onmouseover="fm.onMouseOver(this,'<?=$d?>',event);"  onmouseout="fm.onMouseOut(this,'<?=$d?>',event);"
	 style="color: black;"><?=$d_bn?></a>
	</td><td>&nbsp;</td></tr><?      
    if($ind == $lines) {
       $cols2 = true;
    ?></table>
    </td><td width="50%" valign="top"> 
    <table border="0" width="100%" cellpadding="0" cellspacing="0" ><?   
    }   
  $ind++;
}

$color1=""; $color2="bgcolor='#e3e3e3'";
for($i=0,$j=0; $i < $num_files;$i++){
	$f=$files[$i];
	$type=@filetype($f);
	//$isexe=is_executable($f);
	$pref="";
	//if(is_dir($f)) continue;
	if($type == "fifo") continue;
	elseif($type=="link") $pref="~";
	$size=@filesize($f);
	if($size > 10485760) $size=(int) ($size/1048576)." M";
	else if($size > 10240) $size=(int) ($size/1024)." K";
	$bn=$pref.htmlspecialchars(substr(strrchr($f,'/'),1));
	$b=addslashes($f);
	$f=addslashes(htmlspecialchars($f));
	$id++;
	$j % 2 ? $bg=$color1 : $bg=$color2;
	?><script>
	    fm.right[<?=($ind+$j)?>]='<?=$b?>';
	    fm.rightId['<?=$b?>']='<?=$id?>';
	</script>
	<tr  height="16">
	<td width="14" align="center">
	<a id="<?=$id?>-icon" href='javascript:void(0)' ondblclick="fm.onDblClick('<?=$f?>');" 
	 onclick="fm.onClick('<?=$f?>',event);" oncontextmenu="fm.onContextMenu(this,'<?=$f?>',event);">
	<?=fileIcon(strtolower(substr(strrchr($f,'.'),1)))?></a>
	</td>
	<td id="<?=$id?>-cell" <?=$bg?>>
	<a id="<?=$id?>" href="javascript:void(0)" ondblclick="fm.onDblClick('<?=$f?>');"
	 onclick="fm.onClick('<?=$f?>',event);" 
	 oncontextmenu="fm.onContextMenu(this,'<?=$f?>',event);"
	 onmouseover="fm.onMouseOver(this,'<?=$f?>',event);"  onmouseout="fm.onMouseOut(this,'<?=$f?>',event);"
	 style="color: black;"><?=$bn?></a></td>
	<td  align="right" width="20%" <?=$bg?>>
	<?=$size?>&nbsp;
	</td>
        </tr><?
	if(!$cols2 && ($j==($lines-$ind))) {
	    $cols2=true;
	?></table>
</td><td width="50%" valign="top"> 
<table border="0" width="100%" cellpadding="0" cellspacing="0" ><?     
	    if(($top ? $ind+$j+1 : $ind+$j) % 2) {  $color2=""; $color1="bgcolor='#e3e3e3'"; }
	}
	$j++;
}
?></table><?
if(!$cols2) echo "</td><td valign='top'>&nbsp;";
?></td></tr>
</table>
&nbsp;