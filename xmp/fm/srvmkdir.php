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
include_once("../lib/func.php");

$dir=stripslashes_r($_POST['dir']);
$theme=$_SESSION['theme'];
?>
<script>

fm.makeDir = function() {

 var newdir='<?=addslashes($dir)?>'+'/'+$('make_dir_div_input').value;
 var url='fm/mkdir.php';
 var pb="dir="+encodeURIComponent(newdir);
    new Ajax.Request(url,{
	postBody: pb,
	onComplete: function(t) {
	    //if(t.responseText == "success") fm.postMkDir(newdir);
	    if(t.responseText == "success") fm.postMkDir(newdir);
	    else fm.showMessage(t.responseText,'filemanager-message',1,'warning.gif');	    
	}
    });
}
</script>
<div class="srv-div" align="center">&nbsp;
<div style="width: 80%;margin-top: 10px;" align="left">
<table border="0" class="input-data-tbl" >
    <tr>
    <td width="20%" nowrap="nowrap" style="padding: 10px;">
    <?=$strNewDir?>&nbsp;
    </td><td>
    <input type="text" size="45" id='make_dir_div_input' value="" style="font-style: normal;">
    </td><td width="15%" style="padding: 2px;">
    <a href="javascript:fm.makeDir();">
    <img src="themes/<?=$theme?>/images/run.gif" align="absmiddle"></a>
    </td>
    </tr>
</table>
</div>
</div>
<script>
fm.srvWin.setSize(500,80);
fm.srvWin.setTitle('<?echo "$strMakeDir $strAt ".addslashes($dir);?>');
</script>
