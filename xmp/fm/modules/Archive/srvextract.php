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
include_once("../../lang/".$_SESSION['lang'].".lang.php");
include_once("../../lib/func.php");
include_once("func.php");

extract(stripslashes_r($_POST));
$theme=$_SESSION['theme'];
$archive=$par[0];


list($ar_basename,$bname,$type)=get_ar_type($archive);
/*
$ar_basename=substr(strrchr($archive,'/'),1);

$ext = strtolower(substr(strrchr($archive,'.'),1));
$bname=substr($archive,0,strrpos($archive,'.'));
$ext2 = strtolower(substr(strrchr($bname,'.'),1));

if($ext2 == "tar") {
    if($ext == "gz") $type="targz";
    elseif($ext == "bz2") $type="tarbz2";
    $bname=substr($archive,0,strrpos($bname,'.'));

}else {
    if($ext == "gz") $type="gz";
    elseif($ext == "tgz") $type="targz";
    elseif($ext == "bz2") $type="bz2";
    elseif($ext == "tar") $type="tar";
    elseif($ext == "zip") $type="zip";
}
*/
if(empty($type)) exit();

?>
<script>

fm.unzip = function() {

 var ar_dir=$('archive_dir_div_input').value;
 var url='modules/Archive/extract.php';
 var pb="dir="+encodeURIComponent(ar_dir)+"&type=<?=$type?>&archive="+encodeURIComponent('<?=addslashes($archive)?>');
    new Ajax.Request(url,{
	postBody: pb,
	onComplete: function(t) {
	    //alert(t.responseText);
	    if(t.responseText == "success") {
		fm.hideSrv();
	    	fm.showDir(fm.folder);
	    
	    }else fm.showMessage(t.responseText,'filemanager-message',1,'warning.gif');	    

	}
    });
}
</script>
<div class="srv-div" align="center">&nbsp;
<div style="width: 90%;margin-top: 10px;" align="left">
<table width="100%" border="0" class="input-data-tbl" >
    <tr>
    <td width="30%" nowrap="nowrap" style="padding: 10px;" >
    <? echo "&nbsp;$strExtractFiles $strToDir";?>&nbsp;
    </td><td>
    <input type="text" size="45" id='archive_dir_div_input' value="<?=hc($bname)?>" style="font-style: normal;">
    </td><td nowrap="nowrap" align="left" width="15%" style="padding: 2px;">
    <a href="javascript:fm.unzip();"><img src="themes/<?=$theme?>/images/run.gif" align="absmiddle"></a>&nbsp;
    </td>
    </tr>
</table>
</div>
</div>
<script>
fm.srvWin.setSize(550,90);
fm.srvWin.setTitle('<?echo "$strExtractFiles $strFromArchive $ar_basename";?>');
</script>
