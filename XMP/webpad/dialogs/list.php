<html>
<head>
<title>Insert a List</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
bulletedVal = ['', 'circle', 'square'];
bulletedTxt = ['Filled Circles', 'Outlined Circles', 'Squares'];

numberedVal = ['1', 'a', 'A', 'i', 'I'];
numberedTxt = ['1, 2, 3...', 'a, b, c...', 'A, B, C...', 'i, ii, iii...', 'I, II, III...'];

// Populate the 'type' select box with values available for this format of list
function getListTypes(listStyle) {
	target = document.insertList.listType;

	sourceVal = eval(listStyle + 'Val');
	sourceTxt = eval(listStyle + 'Txt');
	
	if (sourceVal.length != sourceTxt.length) {
		alert("Error in list type arrays!\nPlease download a new copy of webpad.");
		return;
	}
	
	// Clear the select box out to start fresh
	emptySelect(document.insertList.listType);
	
	// Now loop along and re-create the select box using the values we want :)
	for (o = 0; o < sourceVal.length; o++) {
		target.options[o] = new Option(sourceTxt[o], sourceVal[o]);
	}
}


// Clean out all options in a select list
function emptySelect(selectName) {
	for (i = selectName.length; i > 0; i--) {
		selectName.options[i-1] = null;
	}
}

// Loop through the items in order and build up the HTML for the list,
// based on list type selections etc as well.
function buildTheList() {
	d = document.insertList;
	
	if (d.listContents.value == '') {
		alert('You haven\'t entered any list items!');
		return false;
	}
	
	// Start the list off according to the style selected
	if (d.listStyle[0].checked == true) {
		theList = '<ul';
		if (d.listType.value != '') {
			theList += ' type="' + d.listType.value + '"';
		}
		theList += ">\n";
	}
	else {
		theList = '<ol';
		if (d.listType.value != '') {
			theList += ' type="' + d.listType.value + '"';
		}
		theList += ">\n";
	}
	
	// This is the body of the list, with a <li> tag per element
	// Need to split up the contents of the TEXTAREA to get each line for this
	lines = d.listContents.value.split("\n");
	for (i = 0; i < lines.length; i++) {
		bits = lines[i].split("\r");
		theList += '  <li>' + bits[0] + "</li>\n";
	}
	
	// And close the list according to the style
	if (d.listStyle[0].checked == true) {
		theList += '</ul>';
	}
	else {
		theList += '</ol>';
	}
	
	// And send the list back to the caller
	return theList;
}

// Build the list HTML, then insert it into the calling document
function insertTheList() {
	theList = buildTheList();
	if (theList != false) {
		html_tag(theList, '', 'opener.parent.frames.wp_edit.document');
		self.close();
	}
}

// Build the list HTML, then present it in a new window as a preview.
function previewTheList() {
	theList = buildTheList();
	if (theList != false) {
		list_preview = window.open('', 'list_preview');
		list_preview.document.open();
		list_preview.document.write("<html>\n<head>\n<title>Previewing List...</title>\n</head>\n\n<body>\n<font face=\"Verdana, Andale, Sans-serif;\">\n");
		list_preview.document.write(theList);
		list_preview.document.write("\n</font>\n</body>\n</html>");
		list_preview.document.close();
	}
}
// -->
</script>
</head>

<body onload="getListTypes('bulleted'); this.focus(); document.insertList.listContents.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Insert a List</h1>
<form name="insertList">

<table cellpadding="3" cellspacing="0" border="0" width="100%">

<tr>
<td colspan="3"><hr></td>
</tr>

<tr>
<td valign="top">Style:</td>
<td><input type="radio" name="listStyle" id="bullet" value="bulleted" checked="checked" onclick="getListTypes(this.value);" /> <label for="bullet">Bulleted List</label><br>
<input type="radio" name="listStyle" id="number" value="numbered" onclick="getListTypes(this.value);" /> <label for="number">Numbered List</label></td>
</tr>

<tr>
<td><label for="type">Type:</label></td>
<td>
<select name="listType" id="type">
<option value="">Select list style...</option>
</select>
</td>
</tr>

<tr>
<td colspan="3"><hr></td>
</tr>

<tr>
<td align="center" colspan="2">
<textarea name="listContents" style="width: 90%; height: 120px"></textarea><br />
<small>Enter one list item per line.</small>
</td>
</tr>

<tr>
<td colspan="3"><hr></td>
</tr>

<tr>
<td align="center" colspan="3">
<input type="button" name="insert" value="   Insert   " onclick="insertTheList();" />
<input type="button" name="insert" value="  Preview  " onclick="previewTheList();" />
<input type="button" name="cancel" value=" Cancel " onclick="self.close();" />
</td>
</tr>

</table>
</form>

</body>
</html>