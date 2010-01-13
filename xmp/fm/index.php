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
$_SESSION['fm_entry']=true;

require_once("config.php");
require_once("lib/func.php");
$lang=$_SESSION['lang']=$default_lang;
$theme=$_SESSION['theme']=$default_theme;

include("lang/$lang.lang.php");

$modules=@glob("modules/*",GLOB_ONLYDIR);
if(!empty($modules)) foreach($modules as $m) @include("$m/lang/$lang.lang.php");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>		
    <title>File Manager</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Script-Type" content="text/javascript"/>
    <meta name="MSSmartTagsPreventParsing" content="TRUE"/>
    <link rel="stylesheet" type="text/css" media="all" href="themes/<?=$theme?>/style.css"/>
    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript" src="js/scriptaculous.js?load=effects"></script>
    <script type="text/javascript" src="windows/window.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="windows/themes/default.css"/>    
    <link rel="stylesheet" type="text/css" media="all" href="windows/themes/alert_lite.css"/>    
    <script type="text/javascript" src="js/func.js"></script>
    <script type="text/javascript" src="js/toolbar.js"></script>
    <script type="text/javascript" src="js/filemanager.js"></script>
    <script type="text/javascript" src="js/Sound.js"></script>
    <script type="text/javascript" src="js/player.js"></script>
    <?
    if(!empty($modules)) foreach($modules as $m)  
	    if (file_exists($m."/".basename($m).".js")) echo "<script type=\"text/javascript\" src=\"$m/".basename($m).".js\"></script>"; 
    ?>
</head>
<body id="MainBody">

<script type="text/javascript">

fm.httpTimeout=fm.ajaxTimeout=<?=$httpTimeout?>;
fm.uploadFileTimeout=<?=$uploadFileTimeout?>;
fm.shellTimeout=<?=$shellTimeout?>;
fm.www_dir='<?=$www_dir?>';

fm.strHide='<?=$strHide?>';
fm.strHttpTimeout='<?=$strHttpTimeout?>';
fm.strHttpLoading='<?=$strHttpLoading?>';
fm.strLoadError='<?=$strLoadError?>';
fm.strSwitchOff='<?=$strSwitcjOff?>';
fm.strConfirmDelete='<?=$strConfirmDelete?>';
fm.strConfirmDeleteDir='<?=$strConfirmDeleteDir?>';
fm.strNotValidDir='<?=$strNotValidDir?>';
fm.strSelectionHelp='<?=$strSelectionHelp?>';
fm.strFileInfo='<?=$strFileInfo?>';
fm.strCut='<?=$strCut?>';
fm.strCopy='<?=$strCopy?>';
fm.strPaste='<?=$strPaste?>';
fm.strDelete='<?=$strDelete?>';
fm.strMakeDir='<?=$strMakeDir?>';
fm.strDeleteDir='<?=$strDeleteDir?>';
fm.strUploadFile='<?=$strUploadFile?>';
fm.strDownload='<?=$strDownload?>';
fm.strRefresh='<?=$strRefresh?>';
fm.strPlay='<?=$strPlay?>';
fm.strRename='<?=$strRename?>';
fm.strQuickView='<?=$strQuickView?>';
fm.strEdit='<?=$strEdit?>';
fm.strExtract='<?=$strExtractFiles?>';
fm.strSelectAll='<?=$strSelectAll?>';
<? if(!empty($modules)) foreach($modules as $m) @include("$m/menu.js"); ?>
fm.modal=false;
Ajax.Responders.register(globalHandler);

</script>
<div id="frame-module" align="center">
    <div id="frame-module-content" style="zoom: 1;" align="left">
    <?    include("fm/filemanager.php"); ?>

	<br/><br/><br/><br/><br/>
	<div align="center" style="font-size: 9px; font-family: arial;margin-bottom: 3px;font-style: italic; color: #aaaaaa;">
	    <div nowrap="nowrap" style="width: 30%;" onmouseout="this.style.color='#aaaaaa'"  onmouseover="this.style.color='#444444'">
	    Copyright &copy;2007-2008 West-Web Limited. All Rights Reserved
	    </div>
	</div>
    </div>
</div>
</body>
</html>


