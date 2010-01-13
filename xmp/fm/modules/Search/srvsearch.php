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
extract(stripslashes_r($_POST));

$fromdir=$dir;
$name_pattern='*';


?>
<script>
sch = new Object();

sch.search = function(){

    var url="modules/Search/search.php";
    var pb="dir="+encodeURIComponent('<?=addslashes($dir)?>')+"&pattern="+encodeURIComponent($F('name_pattern'))+
    "&content="+encodeURIComponent($F('search_text'));
    if($('case').checked) pb+="&case=1";
        new Ajax.Request(url,{ postBody: pb, 
	 onComplete: function(t) {
		    //alert(t.responseText);
		    Element.update('fm_right',t.responseText);


		}});
}
</script>
<div align="center" class="srv-div">&nbsp;
<div align="left" style="width: 85%;margin-top: 10px;">
<?

$tbl = new DataTbl("100%",0,0,0);
//$p=$tbl->addElement("fromdir","text",$strFromDir,1,$fromdir,"","i_readonly");
//$p->setOptions(55); $p->readonly=1; $p->width2="30%"; $p->width1="15%"; 

$p=$tbl->addElement("name_pattern","text",$strNamePattern,1,$name_pattern,"padding: 8px;");
$p->setOptions(55,0); $p->width2="30%"; $p->width1="15%"; 

$p=$tbl->addElement("","button","",1,$strSearch,"padding: 8px;");
//$p=$tbl->addElement("","button","",1,"Search","","but_search");
$p->setOptions("sch.search()",true,"<img title=\"$strSearch\" align=\"absmiddle\" src=\"themes/$theme/images/search.gif\"/>"); $p->align2="left";
//->setOptions("sch.search()"); 
$p->align2="left"; $p->rowspan=2; $p->valign2="top";
$p->colspan=2;

$p=$tbl->addElement("search_text","text",$strSearchText,3,$search_text,"padding-left: 8px;");
$p->setOptions(55); 
$p=$tbl->addElement("case","checkbox",$strCase,4,$case,"padding: 8px;");
$p->width1="5%";
$tbl->show();
?>
</div>
</div>
<script>
fm.srvWin.setTitle('<?=addslashes("$strSearchFiles $strAtDirectory $fromdir")?>');
fm.srvWin.setSize(600,140);
</script>