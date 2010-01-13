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

if(!$_SESSION['fm_entry']) die('Not a Valid Entry');

$fmHeight=400;
?>

<div id="fileManager-body" onclick="fm.cMenu.hide();" style="zoom: 1;">
<div id="frame-module-header">
<?=$strFileManager?>
</div>
<div id="filemanager-message" class="module-warning" style="display: none;">
</div>
<br/>
<script type="text/javascript">

fm.setContainer('fileManager-body');
fm.initMenu();

var contextMenu1=Array('cut','copy','paste','delete','selectall');
var contextMenu2=Array('mkdir','rmdir','upload');
var contextMenu3=Array('selectall');

</script>


<table border="0" cellpadding="0" cellspacing="0" width="95%">
<tr><td align="center" id='top-menu-left' width="30%" oncontextmenu="return false;">
</td><td>&nbsp;</td>
<td align="left" id='top-menu-right' oncontextmenu="return false;">
</td></tr>
</table>
<script type="text/javascript">

    fm.createLeftToolbar();
    fm.createRightToolbar();
</script>


<table border="0" width="95%" id="table_fm_left">
<tr>
<td width="30%" valign="top" id="td_fm_left">

<div id="fm_left" oncontextmenu="return fm.contextMenuLeft('',event);" class="filemanager-left"
style="border: 1px solid #dddddd;">


<?
$i=0;
foreach($filemanager_dirs as $d=>$dir) {

    $dir_name = $d ? $d : $dir;
    $id='a'.uniqid(true);
?>
    <script type="text/javascript">
      fm.topDirs[<?=$i?>]='<?=addslashes($dir)?>';
      fm.leftId['<?=addslashes($dir)?>']='<?=$id?>';
    </script>
    <table border="0" width="90%" cellspacing="0" cellpadding="0">
    <tr style="height: 20px;">
    <td width="16" align="center" valign="middle" style="padding-bottom: 1px;">
    <a id="<?=$id?>-treelink" href="javascript:fm.showTree('<?=$dir?>');" oncontextmenu="Event.stop(event); return false;">
    <img id="<?=$id?>-tree" src="themes/<?=$theme?>/images/plus.gif" alt="" />
    </a>
    </td><td align="center" valign="middle" width="16">
    <a href="javascript:fm.showDir('<?=$dir?>')" oncontextmenu="return fm.contextMenuLeft('<?=$dir?>',event);" >
    <img id="<?=$id?>-folder" src="themes/<?=$theme?>/images/folder_closed3.gif" alt="" />
    </a>
    </td><td align="left">
    <a id="<?=$id?>" href="javascript:fm.showDir('<?=ah($dir)?>')" style="color: black;" oncontextmenu="return fm.contextMenuLeft('<?=$dir?>',event);">
    &nbsp;<?=hc($dir_name)?>
    </a>
    </td></tr>
    </table>
    <div id="<?=$id?>-div" style="display: none; margin-left: 16px; margin-top: 0px; "></div>
<?$i++;
}
?>
</div>


</td>

<td style="width: 1px;"></td>
<td valign="top">

<div id="fm_right"  oncontextmenu="return fm.contextMenuRight(event);" onclick="fm.unSelectAll();"
 style="height: <?=$fmHeight?>px;border: 1px solid #dddddd;" class="filemanager-right">
</div>

</td>
</tr><tr>
<td></td><td></td>
<td align="right" id="fm-right-sub" class="module-note">
</td></tr>
</table>
<br/>

<center>

<div id="_mp3player_" style="display: none; background-color: #92b8d8; font-size: 10px; color: black; height: 60px ;width: 230px;  
    font-family: verdana, sans; ">

    <table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-style: italic;">
      <tr><td align="left" id="_mp3player_display_" >&nbsp;</td>
      <td align="left" id="_mp3player_time_" width="15%" nowrap="nowrap">&nbsp;</td>
      </tr>
    </table>
    <div style="width: 100%; overflow: hidden;">
      <div id="_mp3player_info_" nowrap="nowrap" style="overflow: hidden;color: #7f0000; font-style: italic;">
      &nbsp;
      </div>
   </div>
   <div style="position: absolute; bottom: 0px;width: 230px;">
      <div id="_mp3player_progressbar_" style="width: 1%;">
      <table border="0" width="100%" style="background-color: #842e51; height: 5px;">
      <tr><td></td></tr></table>
      </div>
      <table border="0" width="100%" cellspacing="0" cellpadding="0" style="height: 18px;">
      <tr>
      <td><img align="absmiddle" onmouseover="fm.player.onMouseOver(this,'play')" onmouseout="fm.player.onMouseOut(this,'play')" id="_mp3player_play_" onclick="fm.player.play()"  src="themes/<?=$theme?>/images/play_on.gif" alt="" />
      </td><td><img align="absmiddle" onmouseover="fm.player.onMouseOver(this,'pause')" onmouseout="fm.player.onMouseOut(this,'pause')" id="_mp3player_pause_" onclick="fm.player.pause()" src="themes/<?=$theme?>/images/pause_off.gif" alt="" />
      </td><td><img align="absmiddle" onmouseover="fm.player.onMouseOver(this,'stop')" onmouseout="fm.player.onMouseOut(this,'stop')" id="_mp3player_stop_"  onclick="fm.player.stop()" src="themes/<?=$theme?>/images/stop_off.gif"  alt="" />
      </td><td><img align="absmiddle" onmouseover="fm.player.onMouseOver(this,'prev')" onmouseout="fm.player.onMouseOut(this,'prev')" id="_mp3player_prev_" onclick="fm.player.prevTrack()" src="themes/<?=$theme?>/images/prev_on.gif" alt="" />
      </td><td><img align="absmiddle" onmouseover="fm.player.onMouseOver(this,'next')" onmouseout="fm.player.onMouseOut(this,'next')" id="_mp3player_next_" onclick="fm.player.nextTrack()"  src="themes/<?=$theme?>/images/next_on.gif" alt="" />
      </td><td id="_mp3player_msg_" align="center" width="80%"
      style="color: white; background-color: #34548f; font-style: italic;">
      </td><td title="<?=$strPlayList?>" width="10%" align="center" onclick="fm.player.onClickPlayList(event)" style="background-color: #34548f;">
      <img id="_mp3player_pl_button_"  align="absmiddle" src="themes/<?=$theme?>/images/pld_w.gif" alt="" />      
      </td></tr>
      </table>
    </div>
    <div align="left" id="_mp3player_pl_" style="position: absolute; top: 89px; left: 0px;
      display: none; border: 1px solid #555555; background-color: #92b8d8; width: 230px;
      scrollbar-base-color: #92b8d8f; scrollbar-highlight-color: #92b8d8;
      scrollbar-darkshadow-color: #92b8d8; ">
    </div>
</div>


</center>


<form name="fm-service-form" id="fm-service-form" method="post" target="fm-service-frame" action="">
<input type="hidden" name="par" id="par" value=""/>
</form>
<iframe name="fm-service-frame" id="fm-service-frame" width="0" height="0" scrolling="yes" frameborder="0"
 style="display: none;">
</iframe>

<br/>
</div>

<script type="text/javascript">

    fm.player = new Player({container: 'fileManager-body'});
    fm.cMenu = new _contextMenu('fileManager-body',{imgdir: 'themes/<?=$theme?>/images'});
    fm.cMenu.items=fm.menuRight;
    Object.extend(fm.cMenu.items,fm.menuLeft);
</script>



