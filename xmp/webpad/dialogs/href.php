<html>
<head>
<title>Insert a Link</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function insertHref() {
	// Make sure they entered something
	if (document.link.url.value == '') {
		alert('You have to at least enter a URL.');
		return;
	}
	
	// Build up the HREF
	hrefOpen = '<a href="' + document.link.prefix.options[document.link.prefix.selectedIndex].value + document.link.url.value + '"';
	if (document.link.target.value != '') {
		hrefOpen += ' target="' + document.link.target.value + '"';
	}
	if (document.link.title.value != "") {
		hrefOpen += ' title="' + document.link.title.value + '"';
	}
	hrefOpen += '>';

	hrefClose = '</a>';

	// And insert it and bail
	html_tag(hrefOpen, hrefClose, 'opener.parent.frames.wp_edit.document');
	self.close();
}
// -->
</script>
</head>

<body onload="this.focus(); document.link.url.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Insert a Link</h1>
<form name="link">

<table cellpadding="3" cellspacing="0" border="0" width="100%">

<tr>
<td><label for="prefix">Link:</label></td>
<td>
<select name="prefix" id="prefix" style="width: 60px">
<option value="" selected="selected"></option>
<option value="http://">http://</option>
<option vale="mailto:">mailto:</option>
<option value="https://">https://</option>
<option value="ftp://">ftp://</option>
<option value="news://">news://</option>
</select>&nbsp;<input type="text" name="url" value="" style="width: 220px;" />
</td>
</tr>

<tr>
<td><label for="title">Title/tooltip:</label></td>
<td><input type="text" name="title" id="title" style="width: 100%;" /></td>
</tr>

<tr>
<td><label for="target">Target:</label></td>
<td><input type="text" name="target" id="target" style="width: 100%;" /></td>
</tr>

<tr>
<td align="center" colspan="2">
<input type="submit" name="insert" value="   Insert   " onclick="insertHref();" />
<input type="button" name="cancel" value=" Cancel " onclick="self.close();" />
</td>
</tr>

</table>

</form>
</body>
</html>