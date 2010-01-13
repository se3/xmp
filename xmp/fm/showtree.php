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
 
//echo "test"; exit(); 
 
session_start();
if(!$_SESSION['fm_entry']) die('Not a Valid Entry');
$theme=$_SESSION['theme'];
include_once("../config.php");
include_once("../lib/func.php");

$dir=stripslashes_r($_POST['dir']);

if(empty($dir)) exit();
if(!is_dir($dir) && $dir != '/ROOT') exit();

$dirs=array();
s_glob($dir,$dirs);
sort($dirs);

$num=count($dirs);

$i=1;
$s=uniqid(true);
foreach($dirs as $d){

    if(in_array($d,$filemanager_dirs)) {$num--; continue;} 
    //if(is_link($d)) continue;
    $id=$s.$i;
?><table border=0 width="90%" cellpadding=0 cellspacing=0 style="margin-bottom: 0px;">
    <tr><td width="16" align="center" valign="center" style="padding-bottom: 2px;"><?
    $ds=(is_link($d) ? "~" : "").htmlspecialchars(substr(strrchr($d,'/'),1));
    $b=addslashes($d);
    $d=addslashes(htmlspecialchars($d));
    if(is_dir_tree($d)) {
 ?><a id='<?=$id?>-treelink' href="javascript:fm.showTree('<?=$d?>')" oncontextmenu="Event.stop(event); return false;">
<img id='<?=$id?>-tree' align='absmiddle' src='themes/<?=$theme?>/images/plus.gif'>&nbsp;
</a><?
    } else {
    ?><a id='<?=$id?>-treelink' href="javascript:fm.showTree('<?=$d?>')" oncontextmenu="Event.stop(event); return false;"></a><?
    }
?></td><td width="16" valign="center">
<a href="javascript:fm.showDir('<?=$d?>')" oncontextmenu="return fm.contextMenuLeft('<?=$d?>',event);">
<img id="<?=$id?>-folder" align="absmiddle" src="themes/<?=$theme?>/images/folder_closed3.gif"></a>
</td><td id="<?=$id?>-cell">
<a id="<?=$id?>" href="javascript:fm.showDir('<?=$d?>')" style="color: black;" oncontextmenu="return fm.contextMenuLeft('<?=$d?>',event);">&nbsp;<?=$ds;?></a>
</td></tr>
</table>
<script>
    if(!fm.tree['<?=$b?>']) fm.tree['<?=$b?>']= new Object();
    fm.tree['<?=$b?>'].open=false;
    fm.leftId['<?=$b?>']='<?=$id?>'; 
</script>
<div id="<?=$id?>-div" style="display: none; margin-left: 16px; margin-top: 0px;"></div><?
$i++;
}
if(empty($dirs)) echo "&nbsp;";
exit();