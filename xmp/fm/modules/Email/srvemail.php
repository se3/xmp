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
include_once("lang/".$_SESSION['lang'].".lang.php");
include_once("../../config.php");
include_once("../../lib/func.php");
include_once("../../lib/Class.datatbl.php");

$theme=$_SESSION['theme'];
//$files=stripslashes_r($_POST['files']);

//if(empty($files)) exit();
/*
$f=explode(",",$files);
$ar_file=date("Y-m-d_H-i")."_archive.zip";
foreach($f as $ff) {
    $f_size+=filesize($ff);
}
$f_size *= 0.85;
*/
if(!isset($subject)) $subject=$strDefaultSubject; 
if(!isset($message)) $message=$strDefaultMessage; 

?>


<script>

email = new Object();

email.attachFiles = function () {
    var len=fm.select.length;
    if(!len) return;
    email.attachment = fm.select;
    var s="<a style='color: black;' title='<?=$strDelete?>' href='javascript:email.deleteAttachment()'>";
    if(len > 1 || fm.isDir(fm.select[0])) {
	var date = new Date();
	var m=date.getMonth()+1; if(m < 10) m='0'+m;
	var h=date.getHours(); if(h < 10) h='0'+h;
	var d=date.getDate(); if(d < 10) d='0'+d;
	var min=date.getMinutes(); if(min < 10) min='0'+min;
	var ds = date.getYear()+'-'+m+'-'+d+'_'+h+'-'+min+'_archive.zip';
	s+="<img align='absmiddle' src='themes/<?=$theme?>/images/rar_fm.gif' >&nbsp;"+ds+" ("+email.attachment.length+")</a>";
    
    }else s+=$(fm.rightId[fm.select[0]]+'-icon').innerHTML+fm.baseName(email.attachment[0])+"</a>";
    $('email_attachment').innerHTML=s;
}
email.deleteAttachment = function() {
    $('email_attachment').innerHTML='&nbsp;';
}
email.validateAndSend = function(){

    var addr=$F('address_to');
    if(!addr) return;
    var url='<?=$www_dir?>/lib/sendemail.php';
    var pb = "address="+encodeURIComponent(addr)+"&subject="+encodeURIComponent($F('subject'))+
    "&body="+encodeURIComponent($F('message'))+getQueryString(email.attachment,'files');
    new Ajax.Request(url,{ postBody: pb, 
			   method: 'post',
			   onComplete: function(t) {
			        if(t.responseText.indexOf("success") == -1) 
					fm.showMessage(t.responseText,'filemanager-message',1,'warning.gif');
				else {
				    fm.showMessage('<?=$strSuccessfullySent?>','filemanager-message');
				    setTimeout("fm.hideSrv()",1000);
				}
			   }    
			 });
}
</script>
<div  align="center" class="srv-div" style="height: 100%; border: 0;">&nbsp;
 <div align="left" style="margin-top: 10px;width: 90%;">
 <form method="post" action="">
<?
$tbl = new DataTbl("100%",0,0,0,"","srv-div");
$str="<img align=\"absmiddle\" src=\"themes/$theme/images/mail_to.gif\"/>&nbsp;$strAddressTo";

$p=$tbl->addElement("address_to","text",$str,1,$address_to,"padding: 5px;");
$p->setOptions(80,1,"","email"); $p->hc=false; $p->width1="20%";
$p=$tbl->addElement("","button","",1,$strSendEmail,"padding: 7px;"); 
//$p->width2="15%";
$p->setOptions("email.validateAndSend()",true,"<img title=\"$strSendEmail\" align=\"absmiddle\" src=\"themes/$theme/images/sendemail.gif\"/>"); $p->align2="left";
$p->submit=false; $p->valign2="top"; $p->rowspan=2;

$str="&nbsp;<img align=\"absmiddle\" src=\"themes/$theme/images/mail_to.gif\"/>&nbsp;$strCopyTo";
$p=$tbl->addElement("copy_to","text",$str,2,$copy_to,"padding-left: 5px;");
$p->setOptions(80,0,"","email"); $p->hc=false;

$str="<img align=\"absmiddle\" src=\"themes/$theme/images/mail_to.gif\"/>&nbsp;$strSubject";
$p=$tbl->addElement("subject","text",$str,3,$subject,"padding: 5px;"); $p->hc=false;
$p->setOptions(80,1); $p->width2="30%";

$p=$tbl->addElement("","button","",3,$strAttachFiles,"padding: 5px;"); 
//$p->width2="15%";
$p->setOptions("email.attachFiles()",true,"<img title=\"$strAttachFiles\" align=\"absmiddle\" src=\"themes/$theme/images/attach.gif\"/>"); $p->align2="center";
$p->submit=false; $p->valign2="top"; $p->rowspan=3;

//$p=$tbl->addElement("attachment","text",$strAttachment,4,$attachment,"padding-left: 5px;","i_readonly");
//$p->setOptions(80); $p->readonly=1;
$p=$tbl->addElement("","simple","",4,"&nbsp;&nbsp;$strAttachment","padding-left: 5px;");
$p->hc=false;
$p=$tbl->addElement("","simple","",4,"<div id='email_attachment' style='padding: 1px;border: 1px solid #a0a0a0; background-color: #dddddd;'>&nbsp;</div>","padding-left: 5px;padding-right: 6px;"); //$p->hc=true;
$p->hc=false;
$p=$tbl->addElement("message","textarea",$strMessage,5,$message,"padding: 5px;");
$p->setOptions(79,12); $p->valign1="top"; $p->valign2="top";

$tbl->show();

?>

</form>
 </div>
</div>
<script>
 fm.srvWin.setSize(700,350);
 fm.srvWin.setTitle("<?=$strSendEmail?>");

</script>
