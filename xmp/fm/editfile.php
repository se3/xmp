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
include_once("../config.php");
include_once("../lib/func.php");
include_once("../lang/".$_SESSION['lang'].".lang.php");

$file=stripslashes_r($_GET['file']);

$theme=$_SESSION['theme'];
if(empty($file) || !is_file($file)) exit();
$fp=@fopen($file,"rb");
if(!$fp) { echo $strCantOpenFile; exit(); }
$bn=substr(strrchr($file,'/'),1);
?>
<html>
<head>		
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta name="MSSmartTagsPreventParsing" content="TRUE">
    <link rel="stylesheet" type="text/css" media="all" href="../themes/<?=$theme?>/style.css"/>
    <script src="../js/prototype.js"></script>
</head>

<body style="margin-left: 10px; margin-right: 10px; margin-top: 20px;background-color: #eeeeee;">
<div id='editor-body'>
<div align="right" class="module-note" style="width: 96%">
<a href="javascript:close()"><?=$strCloseWindow?></a></div>
<div id="frame-module-header" style="margin-left: 0px;" nowrap>
<?=$strEditFile.": ".$bn?>
</div>
<br>
<div id="module-note" class="module-note" style="display: none;">
</div>
<div id="editor-menu" style="width: 100%;">
</div>
<script>

<?
include("../js/toolbar.js");
?>

editor = new Object();

editor.find = function(){
    Try.these(
	function() {
	    var str;
	    if(editor.trange == null) editor.trange=editor.tArea.createTextRange();
	    str=editor.trange.findText($('ftext').value);
	    if(str) {
		editor.trange.scrollIntoView();
		editor.trange.select();
		editor.trange.collapse(false);
	    } 
	    else editor.trange=null;
	},
	function() {
	    editor.win.find($('ftext').value,false,false,false,false,false,true);
	}
    );
}

editor.print = function(){
    if(!editor.win) return;
    $('editor-form').target="print-file";
    $('editor-form').action="<?=$www_dir?>/lib/printfile.php";
    $('editor-form').content.value=editor.tArea.value;
    $('editor-form').file.value=editor.file;
    $('editor-form').submit();
}

editor.save = function() {
    var url="<?=$www_dir?>/lib/savefile.php";
    alert(editor.file);
    alert(editor.tArea.value);
    var pb="file="+encodeURIComponent(editor.file)+"&content="+encodeURIComponent(editor.tArea.value);
    new parent.Ajax.Request(url,
	    {postBody: pb,
	     onComplete: function(t){
		    $('module-note').innerHTML=t.responseText+"<br><br>";
		    $('module-note').show();
		    setTimeout("$('module-note').hide()",2500);
		    
		}
	    });	
}

var cfmenu = new Array('/','save','print','/','undo','find','/');
editor.menuitems = new Array();

editor.menuitems['save'] = Array('<?=$strSave?>','editor.save()','true','save_off.gif','save_on.gif');
editor.menuitems['print'] = Array('<?=$strPrint?>','editor.print()','true','print_off.gif','print_on.gif');
editor.menuitems['find'] = Array('<?=$strFind?>','editor.find()','$("ftext").value.length','find_off.gif','find_on.gif');
editor.menuitems['find'][5]='<input type="text" size="25" name="ftext" id="ftext" value="<?=$ftext?>">';


editor.menu = new _Toolbar('editor-menu',{className: 'menu-panel', panelBg: '#d9d9d9', imgdir: '../themes/<?=$theme?>/images'});
editor.menu.items=editor.menuitems;
editor.menu.create(cfmenu);

</script>

<textarea name="editor-ta" id="editor-ta"  rows="30" wrap="off" style="border-style: solid; width: 100%;
 height: 500px; overflow: auto; border-color: #aaaaaa; border-width: 1px; margin: 0px;">
<?
while(!feof($fp)) {
    echo fgets($fp);
}
fclose($fp);
?>
</textarea>
<script>
  editor.win=window;
  editor.tArea=$('editor-ta');
  editor.file='<?=addslashes($file)?>';
</script>
<form name="editor-form" id="editor-form" method="post">
<input type="hidden" name="file" id="file" value="">
<input type="hidden" name="content" id="content" value="">
</form>
<iframe name="print-file" id="print-file" frameborder="0" scrolling="no" height="0" width="0">
</iframe> 
</div>
</body>
</html>