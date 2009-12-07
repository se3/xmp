<?php
require_once('admin/configuration.php');
?>
<html>
<head>
<title>webpad: the web-based text editor</title>
<link rel="stylesheet" type="text/css" href="css/toolbar.css" />
<script language="JavaScript" type="text/javascript" src="js/tools.js"></script>
<script language="JavaScript" type="text/javascript" src="js/shortcuts.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
// Used in the 'About' dialog
webpad_version = '<?php echo $config['webpad_version']; ?>';

// Whether or not webpad should look for templates for File -> New
use_templates  = <?php echo ($config['use_templates'] ? 'true' : 'false'); ?>;
// -->
</script>
</head>

<body onkeypress="return check_shortcuts();">
<div id="toolbar">

<!-- File Management Tools -->
<span class="toolbarcontrol"></span>
<a href="javascript:file_new(false);" onmouseover="window.status='Create a new text file.'; return true;" onmouseout="window.status=''; return true;" title="New File (ctrl/opt-shift-n)"><img src="images/new.gif" align="middle"></a>
<a href="javascript:file_open();" onmouseover="window.status='Open existing text file from My Computer, My Server, FTP Server, My Blog or Website.'; return true;" onmouseout="window.status=''; return true;" title="Open File... (ctrl/opt-shift-o)"><img src="images/open.gif" align="middle"></a>
<a href="javascript:file_save();" onmouseover="window.status='Save this file to My Computer, My Server, FTP Server, or My Blog.'; return true;" onmouseout="window.status=''; return true;" title="Save File (ctrl/opt-shift-s)"><img src="images/save.gif" align="middle"></a>
<a href="javascript:file_save_as();" onmouseover="window.status='Save this file under a new filename or in a new location.'; return true;" onmouseout="window.status=''; return true;" title="Save File As..."><img src="images/saveas.gif" align="middle"></a>
<?php
// Uploading files is dependant upon a configuration directive
if ($config['allow_upload'] == true) {
	echo "<a href=\"javascript:file_upload();\" onmouseover=\"window.status='Upload any file to My Server or FTP Server.'; return true;\" onmouseout=\"window.status=''; return true;\" title=\"Upload A File To " . $config['myserver_label'] . "\"><img src=\"images/upload.gif\" align=\"middle\"></a>\n";
}
// Can suppress access to email in the config file
if ($config['allow_email'] == true) {
	echo "<a href=\"javascript:email();\" onmouseover=\"window.status='Send this file as email.'; return true;\" onmouseout=\"window.status=''; return true;\" title=\"Send File As Email\"><img src=\"images/email.gif\" align=\"middle\"></a>\n";
}
?>
<a href="javascript:print();" onmouseover="window.status='Print this file (new window).'; return true;" onmouseout="window.status=''; return true;" title="Print File"><img src="images/print.gif" align="middle"></a>

<!-- Text Functions -->
<span class="separator"></span>
<!-- <a href="javascript:word_wrap();" onmouseover="window.status='Toggle word-wrap on/off'; return true;" onmouseout="window.status=''; return true;" title="Word-wrap"><img src="images/goto.gif" align="middle"></a> -->
<a href="javascript:go_to();" onmouseover="window.status='Go to a line in this file.'; return true;" onmouseout="window.status=''; return true;" title="Go To Line (ctrl/opt-shift-g)"><img src="images/goto.gif" align="middle"></a>
<a href="javascript:find_str('');" onmouseover="window.status='Search for text in this file.'; return true;" onmouseout="window.status=''; return true;" title="Find (ctrl/opt-shift-f)"><img src="images/find.gif" align="middle"></a>
<a href="javascript:find_next();" onmouseover="window.status='Find the next occurrence of previously searched text.'; return true;" onmouseout="window.status=''; return true;" title="Find Next"><img src="images/findnext.gif" align="middle"></a>
<a href="javascript:find_replace();" onmouseover="window.status='Find a text string in your file and replace it with another text string.'; return true;" onmouseout="window.status=''; return true;" title="Find and Replace (ctrl/opt-shift-h)"><img src="images/findreplace.gif" align="middle"></a>

<!-- HTML Tools -->
<span class="toolbarcontrol"></span>
<a href="javascript:html_tag('<strong>', '</strong>');" onmouseover="window.status='Insert HTML STRONG tags.'; return true;" onmouseout="window.status=''; return true;" title="Bold (ctrl/opt-shift-b)"><img src="images/bold.gif" align="middle"></a>
<a href="javascript:html_tag('<em>', '</em>');" onmouseover="window.status='Insert HTML EM tags.'; return true;" onmouseout="window.status=''; return true;" title="Italic (ctrl/opt-shift-i)"><img src="images/italic.gif" align="middle"></a>

<span class="separator"></span>
<a href="javascript:insert_href();" onmouseover="window.status='Insert an HTML hyperlink.'; return true;" onmouseout="window.status=''; return true;" title="Insert Hyperlink (ctrl/opt-shift-a)"><img src="images/href.gif" align="middle"></a>
<a href="javascript:insert_img();" onmouseover="window.status='Insert an HTML image tag.'; return true;" onmouseout="window.status=''; return true;" title="Insert Image"><img src="images/img.gif" align="middle"></a>
<a href="javascript:html_tag('<div style=&quot;margin-left: 2em;&quot;>', '</div>');" onmouseover="window.status='Indent selected text with HTML div, or insert blank tags.'; return true;" onmouseout="window.status=''; return true;" title="Indent Text Block"><img src="images/indent.gif" align="middle"></a>
<a href="javascript:html_tag('<blockquote>', '</blockquote>');" onmouseover="window.status='BLOCKQUOTE selected text, or insert blank tags.'; return true;" onmouseout="window.status=''; return true;" title="Blockquote"><img src="images/blockquote.gif" align="middle"></a>

<span class="separator"></span>
<a href="javascript:html_tag('<p align=&quot;left&quot;>', '</p>');" onmouseover="window.status='Align selected text to the left using HTML tags, or insert blank align tags.'; return true;" onmouseout="window.status=''; return true;" title="Align: Left (ctrl/opt-shift-l)"><img src="images/left.gif" align="middle"></a>
<a href="javascript:html_tag('<p align=&quot;center&quot;>', '</p>');" onmouseover="window.status='Center align selected text with HTML tags, or insert blank align tags.'; return true;" onmouseout="window.status=''; return true;" title="Align: Center (ctrl/opt-shift-e)"><img src="images/center.gif" align="middle"></a>
<a href="javascript:html_tag('<p align=&quot;right&quot;>', '</p>');" onmouseover="window.status='Align selected text to the right using HTML tags, or insert blank align tags.'; return true;" onmouseout="window.status=''; return true;" title="Align: Right (ctrl/opt-shift-r)"><img src="images/right.gif" align="middle"></a>
<a href="javascript:html_tag('<p align=&quot;justify&quot;>', '</p>');" onmouseover="window.status='Justify selected text in HTML, or insert blank justify tags.'; return true;" onmouseout="window.status=''; return true;" title="Align: Justify (ctrl/opt-shift-j)"><img src="images/justify.gif" align="middle"></a>

<span class="separator"></span>
<a href="javascript:insert_hex();" onmouseover="window.status='Select a color from the color-palette.'; return true;" onmouseout="window.status=''; return true;" title="Insert a Hex Color Code"><img src="images/palette.gif" align="middle"></a>
<a href="javascript:insert_table();" onmouseover="window.status='Insert a custom table.'; return true;" onmouseout="window.status=''; return true;" title="Insert Table"><img src="images/table.gif" align="middle"></a>
<a href="javascript:insert_list();" onmouseover="window.status='Create a numbered or bulleted list.'; return true;" onmouseout="window.status=''; return true;" title="Insert List"><img src="images/list.gif" align="middle"></a>

<!-- Preview/About/Help -->
<span class="toolbarcontrol"></span>
<a href="javascript:preview();" onmouseover="window.status='Preview this file in a new browser window (HTML only).'; return true;" onmouseout="window.status=''; return true;" title="Preview As HTML (ctrl/opt-shift-p)"><img src="images/preview.gif" align="middle"></a>

<span class="separator"></span>
<a href="javascript:about();" onmouseover="window.status='About webpad.'; return true;" onmouseout="window.status=''; return true;" title="About webpad"><img src="images/about.gif" align="middle"></a>
<a href="javascript:help();" onmouseover="window.status='webpad online help manual.'; return true;" onmouseout="window.status=''; return true;" title="Help Manual"><img src="images/help.gif" align="middle"></a>

<a href="javascript:logout();" id="logout" onmouseover="window.status='Log out of webpad.'; return true;" onmouseout="window.status=''; return true;" title="Log out of webpad"><img src="images/logout.gif" align="middle"></a>
<a href="javascript:settings();" id="configuration" onmouseover="window.status='Configure webpad settings'; return true;" onmouseout="window.status=''; return true;" title="webpad Settings"><img src="images/settings.gif" align="middle"></a>
</div>

</body>
</html>