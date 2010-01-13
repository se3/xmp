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
include_once("../config.php");
include_once("../lib/func.php");
include_once("../lib/sysfunc.php");

$dir=stripslashes_r($_POST['dir']);
$theme=$_SESSION['theme'];

if($prog = which('wget')) $progtype="wget";
elseif($prog = which('curl')) $progtype="curl";
elseif(@ini_get('allow_url_fopen')) $progtype="copy";
elseif($prog = which('links')) $progtype="links";
elseif($prog = which('lynx')) $progtype="lynx";

?>
<script>
fm.uploadRemoteFile = function() {
 var file=$('upload_remote_file').value;
 if(!file) return;
 var url = "fm/uploadfile.php";
 var pb = "upload_dir="+encodeURIComponent('<?=addslashes($dir)?>')+"&remote_file="+encodeURIComponent(file)+"&new_name="+encodeURIComponent($('new_name').value)+
 "&type=remote&prog=<?=$prog?>&progtype=<?=$progtype?>";
 fm.ajaxTimeout=fm.uploadFileTimeout;
 new Ajax.Request(url,
	    { postBody : pb,
	      onComplete: function(t) {
	        //alert(t.responseText);return;
	        eval(t.responseText);
	      }
	     });

}


</script>


<div align="center" class="srv-div">&nbsp;
<div align="left" style="width: 85%; margin-top: 10px; ">
<form name="__upload_form__" id="upload_file_form" method="post"   
 enctype="multipart/form-data" action="fm/uploadfile.php" 
 target="fm-service-frame">
 <input type="hidden" name="upload_dir" id="upload_dir" value="<?=$dir?>">
 <input type="hidden" name="type" id="type" value="">
 <input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_file_size?>">



 <table width="100%" border="0" class="input-data-tbl" >
 <tr>
 <td nowrap="nowrap" width="10%" style="padding: 8px;">
 &nbsp;<?=$strUploadLocalFile?>&nbsp;
 </td>
 <td >
 <input type="file" size="70" name="upload_local_file" id="upload_local_file"  
  value="" >
 </td><td align="left" width="15%" style="padding: 2px;">
 <a href="javascript:void(0)" onclick="$('__upload_form__').type.value='local';$('__upload_form__').submit();">
 <img title="<?=$strUpload?>" src="themes/<?=$theme?>/images/run.gif" align="absmiddle">
 </a>
 </td> 
 </tr>
 <?if($progtype) {?>
 <tr>
 <td nowrap="nowrap" style="padding-left: 8px;">
 &nbsp;<?=$strUploadRemoteFile?>&nbsp;
 </td><td width="50%" nowrap>
 <input type="text" size="70" name="upload_remote_file" id="upload_remote_file"  value="" >
 </td><td style="padding: 2px;">
 <a href="javascript:void(0)" onclick="fm.uploadRemoteFile();">
 <img title="<?=$strUpload?>" src="themes/<?=$theme?>/images/run.gif" align="absmiddle">
 </a>
 </td>
 </tr>
 <?}?>
 <tr>
 <td style="padding: 8px;">&nbsp;<?=$strRenameTo?></td>
 <td colspan=3>
 <input type="text" size="40" name="new_name" id="new_name" value="" > 
 </td>
 </tr>
 <tr style="height: 1px;"><td></td></tr>
 </table>

</form>
</div>
</div>

<script>
    fm.srvWin.setSize(770,140);
    fm.srvWin.setTitle('<?=addslashes("$strUploadFile $strToDir $dir")?>');
</script>