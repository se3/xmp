<html>
<head>
<title>Insert a Table</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function insertTheTable() {
	t = document.customtable;
	
	// Building the HTML for the table, excluding undefined attributes
	theTable = '<table';
	
	// CELLPADDING
	if (t.cellpaddingTag.value != '') {
		theTable += ' cellpadding="' + t.cellpaddingTag.value + '"';
	}
	// CELLSPACING
	if (t.cellspacingTag.value != '') {
		theTable += ' cellspacing="' + t.cellspacingTag.value + '"';
	}
	// BORDER
	if (t.borderTag.value != '') {
		theTable += ' border="' + t.borderTag.value + '"';
	}
	// WIDTH
	if (t.widthTag.value != '') {
		theTable += ' width="' + t.widthTag.value + t.widthType.value + '"';
	}
	// ALIGN
	if (t.alignTag.value != '') {
		theTable += ' align="' + t.alignTag.value + '"';
	}
	// STYLE
	if (t.styleTag.value != '') {
		theTable += ' style="' + t.styleTag.value + '"';
	}
	// CLASS
	if (t.classTag.value != '') {
		theTable += ' class="' + t.classTag.value + '"';
	}
	// finish the opening table tag
	theTable += ">\n\n";
	
	// This loop creates the required <TR> and <TD> tags for the table's size
	for (r = 0; r < t.rows.value; r++) {
		theTable += "  <tr>\n";
		for (c = 0; c < t.cols.value; c++) {
			theTable += "    <td></td>\n";
		}
		theTable += "  </tr>\n\n";
	}
	// Then finish off the table ready to insert to the current document.
	theTable += "</table>\n";
	
	// And insert it and bail
	html_tag(theTable, '', 'opener.parent.frames.wp_edit.document');
	self.close();
}
// -->
</script>
</head>

<body onload="this.focus(); document.customtable.rows.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Insert a Table</h1>

<table cellpadding="3" cellspacing="0" border="0" width="100%">

<form name="customtable">

<tr>
<td><label for="rows">Rows:</label></td>
<td><input type="text" name="rows" id="rows" value="2" size="5" /></td>
</tr>

<tr>
<td><label for="cols">Columns:</label></td>
<td><input type="text" name="cols" id="cols" value="2" size="5" /></td>
</tr>

<tr>
<td><label for="cellpaddingTag">Cell Padding:</label></td>
<td><input type="text" name="cellpaddingTag" id="cellpaddingTag" value="0" size="5" /></td>
</tr>

<tr>
<td><label for="cellspacingTag">Cell Spacing:</label></td>
<td><input type="text" name="cellspacingTag" id="cellspacingTag" value="0" size="5" /></td>
</tr>

<tr>
<td><label for="borderTag">Border:</label></td>
<td><input type="text" name="borderTag" id="borderTag" value="0" size="5" /></td>
</tr>

<tr>
<td><label for="widthTag">Width:</label></td>
<td><input type="text" name="widthTag" id="widthTag" value="" size="5" />
<select name="widthType">
<option value="">Pixels</option>
<option value="%">Percent</option>
</select>
</td>
</tr>

<tr>
<td><label for="alignTag">Align:</label></td>
<td>
<select name="alignTag" id="alignTag" style="width: 100%;">
<option value="">Default</option>
<option value="left">Left</option>
<option value="center">Center</option>
<option value="right">Right</option>
</select>
</td>
</tr>

<tr>
<td><label for="classTag">Class Tag:</label></td>
<td><input type="text" name="classTag" id="classTag" value="" style="width: 100%;" /></td>
</tr>

<tr>
<td><label for="styleTag">Style Tag:</label></td>
<td><input type="text" name="styleTag" id="styleTag" value="" style="width: 100%;" /></td>
</tr>

<tr>
<td align="center" colspan="2">
<input type="submit" name="insert" value="   Insert   " onclick="insertTheTable();" />
<input type="button" name="cancel" value=" Cancel " onclick="self.close();" />
</td>
</tr>

</form>

</table>

</body>
</html>