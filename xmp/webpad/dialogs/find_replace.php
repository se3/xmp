<html>
<head>
<title>Find and Replace</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript">
<!--
function make_regexp_safe(str) {
	str = str.replace(/\\/gi, '\\\\');
	str = str.replace(/\./gi, '\\\.');
	str = str.replace(/\[/gi, '\\\[');
	str = str.replace(/\]/gi, '\\\]');
	str = str.replace(/\{/gi, '\\\{');
	str = str.replace(/\}/gi, '\\\}');
	str = str.replace(/\*/gi, '\\\*');
	str = str.replace(/\?/gi, '\\\?');
	str = str.replace(/\+/gi, '\\\+');
	str = str.replace(/\$/gi, '\\\$');
	str = str.replace(/\^/gi, '\\\^');
	str = str.replace(/\|/gi, '\\\|');
	return str;
}

function do_replace() {
	d = document.dialog;
	r = d.replaceTxt.value;
	f = d.findTxt.value;
	f = make_regexp_safe(f);
	
	if (d.matchCase.checked == true) {
		flags = 'g';
	}
	else {
		flags = 'gi';
	}
	opener.parent.frames.wp_toolbar._find_replace(f, r, flags);
	opener.parent.frames.wp_edit.document.edit.modified.value = true;
	opener.parent.frames.wp_edit.document.edit.wp_document.focus();
	self.close();
}
// -->
</script>
</head>

<body onload="this.focus(); document.dialog.findTxt.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Find and Replace</h1>

<form name="dialog">

<table cellpadding="3" cellspacing="0" border="0" width="100%">

<tr>
<td><label for="find">Find:</label></td>
<td><input type="text" name="findTxt" id="find" style="width: 100%;" value="" /></td>
</tr>

<tr>
<td><label for="replace">Replace With:</label></td>
<td><input type="text" name="replaceTxt" id="replace" style="width: 100%;" value="" /></td>
</tr>

<tr>
<td><label for="case">Match Case?</label></td>
<td><input type="checkbox" name="matchCase" id="case" value="i" /></td>
</tr>

<tr>
<td></td>
<td align="center" colspan="2">
<input type="submit" name="submit" value=" Replace All " onclick="do_replace();" />
<input type="button" name="cancel" value="    Cancel    " onclick="self.close();" />
</td>
</tr>

</table>

</form>

</body>
</html>