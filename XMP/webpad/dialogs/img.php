<html>
<head>
<title>Insert an Image</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function insertImg() {
	// Make sure they entered something
	if (document.img.img.value == '') {
		alert('You have to at least enter a path to the image.');
		return;
	}
	
	// Build up the IMG tag
	imgTag = '<img src="' + document.img.img.value + '"';
	if (document.img.imgAlt.value != "") {
		imgTag += ' alt="' + document.img.imgAlt.value + '"';
	}
	if (document.img.imgBorder.value != "") {
		imgTag += ' border="' + document.img.imgBorder.value + '"';
	}
	if (document.img.imgWidth.value != "") {
		imgTag += ' width="' + document.img.imgWidth.value + '"';
	}
	if (document.img.imgHeight.value != "") {
		imgTag += ' height="' + document.img.imgHeight.value + '"';
	}
	if (document.img.imgAlign.options[document.img.imgAlign.selectedIndex].value != "") {
		imgTag += ' align="' + document.img.imgAlign.options[document.img.imgAlign.selectedIndex].value + '"';
	}
	if (document.img.imgClass.value != '') {
		imgTag += ' class="' + document.img.imgClass.value + '"';
	}
	if (document.img.imgStyle.value != "") {
		imgTag += ' style="' + document.img.imgStyle.value + '"';
	}
	imgTag += ' />';

	// And insert it and bail
	html_tag(imgTag, '', 'opener.parent.frames.wp_edit.document');
	self.close();
}
// -->
</script>
</head>

<body onload="this.focus(); document.img.img.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Insert an Image</h1>

<form name="img">

<table cellpadding="3" cellspacing="0" border="0" width="100%">

<tr>
<td width="30%" nowrap="nowrap"><label for="img">Path To Image:</label></td>
<td><input type="text" name="img" id="img" style="width: 100%;" /></td>
</tr>

<tr>
<td><label for="imgAlt">ALT Text:</label></td>
<td><input type="text" name="imgAlt" id="imgAlt" style="width: 100%;" /></td>
</tr>

<tr>
<td><label for="imgBorder">Border:</label></td>
<td><input type="text" name="imgBorder" id="imgBorder" style="width: 100%;" value="0" /></td>
</tr>

<tr>
<td><label for="imgWidth">Width:</label></td>
<td><input type="text" name="imgWidth" id="imgWidth" style="width: 100%;" /></td>
</tr>

<tr>
<td><label for="imgHeight">Height:</label></td>
<td><input type="text" name="imgHeight" id="imgHeight" style="width: 100%;" /></td>
</tr>

<tr>
<td><label for="imgAlign">Align:</label></td>
<td>
<select name="imgAlign" id="imgAlign" style="width: 100%;">
<option value="">Default</option>
<option value="left">Left</option>
<option value="center">Center</option>
<option value="right">Right</option>
<option value="top">Top of Line</option>
<option value="bottom">Bottom of Line</option>
<option value="absmiddle">Absolute Middle</option>
</select>
</td>
</tr>

<tr>
<td><label for="imgClass">Class:</label></td>
<td><input type="text" name="imgClass" id="imgClass" style="width: 100%;" /></td>
</tr>

<tr>
<td><label for="imgStyle">Style:</label></td>
<td><input type="text" name="imgStyle" id="imgStyle" style="width: 100%;" /></td>
</tr>

<tr>
<td align="center" colspan="2">
<input type="submit" name="insert" value="   Insert   " onclick="insertImg();" />
<input type="button" name="cancel" value=" Cancel " onclick="self.close();" />
</td>
</tr>

</table>
</form>
</body>
</html>