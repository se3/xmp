<html>
<head>
<title>Click To Insert Color HEX Code</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css">
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function showColor(val) {
	document.colorform.hexval.value = val;
	document.body.style.background  = val;
}

function insertColor() {
	hex = document.colorform.hexval.value;
	html_tag(hex, '', 'opener.parent.frames.wp_edit.document');
	self.close();
}
// -->
</script>
</head>

<body onload="this.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Click To Insert Color HEX Code</h1>

<div align="center">
<form name="colorform">
<p><img usemap="#colmap" src="../images/colortable.gif" border="0" width="289" height="67" /></p>
<p><input type="text" name="hexval" size="10" value="" readonly style="text-align: center;" /></p>
<p><input type="button" name="cancel" value=" Cancel " onclick="self.close();"></p>
</form>
</div>

<map name="colmap">
<area shape="rect" coords="1,1,7,10" href="javascript:insertColor('#00FF00')" onmouseover="javascript:showColor('#00FF00')">
<area shape="rect" coords="9,1,15,10" href="javascript:insertColor('#00FF33')" onmouseover="javascript:showColor('#00FF33')">
<area shape="rect" coords="17,1,23,10" href="javascript:insertColor('#00FF66')" onmouseover="javascript:showColor('#00FF66')">
<area shape="rect" coords="25,1,31,10" href="javascript:insertColor('#00FF99')" onmouseover="javascript:showColor('#00FF99')">
<area shape="rect" coords="33,1,39,10" href="javascript:insertColor('#00FFCC')" onmouseover="javascript:showColor('#00FFCC')">
<area shape="rect" coords="41,1,47,10" href="javascript:insertColor('#00FFFF')" onmouseover="javascript:showColor('#00FFFF')">
<area shape="rect" coords="49,1,55,10" href="javascript:insertColor('#33FF00')" onmouseover="javascript:showColor('#33FF00')">
<area shape="rect" coords="57,1,63,10" href="javascript:insertColor('#33FF33')" onmouseover="javascript:showColor('#33FF33')">
<area shape="rect" coords="65,1,71,10" href="javascript:insertColor('#33FF66')" onmouseover="javascript:showColor('#33FF66')">
<area shape="rect" coords="73,1,79,10" href="javascript:insertColor('#33FF99')" onmouseover="javascript:showColor('#33FF99')">
<area shape="rect" coords="81,1,87,10" href="javascript:insertColor('#33FFCC')" onmouseover="javascript:showColor('#33FFCC')">
<area shape="rect" coords="89,1,95,10" href="javascript:insertColor('#33FFFF')" onmouseover="javascript:showColor('#33FFFF')">
<area shape="rect" coords="97,1,103,10" href="javascript:insertColor('#66FF00')" onmouseover="javascript:showColor('#66FF00')">
<area shape="rect" coords="105,1,111,10" href="javascript:insertColor('#66FF33')" onmouseover="javascript:showColor('#66FF33')">
<area shape="rect" coords="113,1,119,10" href="javascript:insertColor('#66FF66')" onmouseover="javascript:showColor('#66FF66')">
<area shape="rect" coords="121,1,127,10" href="javascript:insertColor('#66FF99')" onmouseover="javascript:showColor('#66FF99')">
<area shape="rect" coords="129,1,135,10" href="javascript:insertColor('#66FFCC')" onmouseover="javascript:showColor('#66FFCC')">
<area shape="rect" coords="137,1,143,10" href="javascript:insertColor('#66FFFF')" onmouseover="javascript:showColor('#66FFFF')">
<area shape="rect" coords="145,1,151,10" href="javascript:insertColor('#99FF00')" onmouseover="javascript:showColor('#99FF00')">
<area shape="rect" coords="153,1,159,10" href="javascript:insertColor('#99FF33')" onmouseover="javascript:showColor('#99FF33')">
<area shape="rect" coords="161,1,167,10" href="javascript:insertColor('#99FF66')" onmouseover="javascript:showColor('#99FF66')">
<area shape="rect" coords="169,1,175,10" href="javascript:insertColor('#99FF99')" onmouseover="javascript:showColor('#99FF99')">
<area shape="rect" coords="177,1,183,10" href="javascript:insertColor('#99FFCC')" onmouseover="javascript:showColor('#99FFCC')">
<area shape="rect" coords="185,1,191,10" href="javascript:insertColor('#99FFFF')" onmouseover="javascript:showColor('#99FFFF')">
<area shape="rect" coords="193,1,199,10" href="javascript:insertColor('#CCFF00')" onmouseover="javascript:showColor('#CCFF00')">
<area shape="rect" coords="201,1,207,10" href="javascript:insertColor('#CCFF33')" onmouseover="javascript:showColor('#CCFF33')">
<area shape="rect" coords="209,1,215,10" href="javascript:insertColor('#CCFF66')" onmouseover="javascript:showColor('#CCFF66')">
<area shape="rect" coords="217,1,223,10" href="javascript:insertColor('#CCFF99')" onmouseover="javascript:showColor('#CCFF99')">
<area shape="rect" coords="225,1,231,10" href="javascript:insertColor('#CCFFCC')" onmouseover="javascript:showColor('#CCFFCC')">
<area shape="rect" coords="233,1,239,10" href="javascript:insertColor('#CCFFFF')" onmouseover="javascript:showColor('#CCFFFF')">
<area shape="rect" coords="241,1,247,10" href="javascript:insertColor('#FFFF00')" onmouseover="javascript:showColor('#FFFF00')">
<area shape="rect" coords="249,1,255,10" href="javascript:insertColor('#FFFF33')" onmouseover="javascript:showColor('#FFFF33')">
<area shape="rect" coords="257,1,263,10" href="javascript:insertColor('#FFFF66')" onmouseover="javascript:showColor('#FFFF66')">
<area shape="rect" coords="265,1,271,10" href="javascript:insertColor('#FFFF99')" onmouseover="javascript:showColor('#FFFF99')">
<area shape="rect" coords="273,1,279,10" href="javascript:insertColor('#FFFFCC')" onmouseover="javascript:showColor('#FFFFCC')">
<area shape="rect" coords="281,1,287,10" href="javascript:insertColor('#FFFFFF')" onmouseover="javascript:showColor('#FFFFFF')">
<area shape="rect" coords="1,12,7,21" href="javascript:insertColor('#00CC00')" onmouseover="javascript:showColor('#00CC00')">
<area shape="rect" coords="9,12,15,21" href="javascript:insertColor('#00CC33')" onmouseover="javascript:showColor('#00CC33')">
<area shape="rect" coords="17,12,23,21" href="javascript:insertColor('#00CC66')" onmouseover="javascript:showColor('#00CC66')">
<area shape="rect" coords="25,12,31,21" href="javascript:insertColor('#00CC99')" onmouseover="javascript:showColor('#00CC99')">
<area shape="rect" coords="33,12,39,21" href="javascript:insertColor('#00CCCC')" onmouseover="javascript:showColor('#00CCCC')">
<area shape="rect" coords="41,12,47,21" href="javascript:insertColor('#00CCFF')" onmouseover="javascript:showColor('#00CCFF')">
<area shape="rect" coords="49,12,55,21" href="javascript:insertColor('#33CC00')" onmouseover="javascript:showColor('#33CC00')">
<area shape="rect" coords="57,12,63,21" href="javascript:insertColor('#33CC33')" onmouseover="javascript:showColor('#33CC33')">
<area shape="rect" coords="65,12,71,21" href="javascript:insertColor('#33CC66')" onmouseover="javascript:showColor('#33CC66')">
<area shape="rect" coords="73,12,79,21" href="javascript:insertColor('#33CC99')" onmouseover="javascript:showColor('#33CC99')">
<area shape="rect" coords="81,12,87,21" href="javascript:insertColor('#33CCCC')" onmouseover="javascript:showColor('#33CCCC')">
<area shape="rect" coords="89,12,95,21" href="javascript:insertColor('#33CCFF')" onmouseover="javascript:showColor('#33CCFF')">
<area shape="rect" coords="97,12,103,21" href="javascript:insertColor('#66CC00')" onmouseover="javascript:showColor('#66CC00')">
<area shape="rect" coords="105,12,111,21" href="javascript:insertColor('#66CC33')" onmouseover="javascript:showColor('#66CC33')">
<area shape="rect" coords="113,12,119,21" href="javascript:insertColor('#66CC66')" onmouseover="javascript:showColor('#66CC66')">
<area shape="rect" coords="121,12,127,21" href="javascript:insertColor('#66CC99')" onmouseover="javascript:showColor('#66CC99')">
<area shape="rect" coords="129,12,135,21" href="javascript:insertColor('#66CCCC')" onmouseover="javascript:showColor('#66CCCC')">
<area shape="rect" coords="137,12,143,21" href="javascript:insertColor('#66CCFF')" onmouseover="javascript:showColor('#66CCFF')">
<area shape="rect" coords="145,12,151,21" href="javascript:insertColor('#99CC00')" onmouseover="javascript:showColor('#99CC00')">
<area shape="rect" coords="153,12,159,21" href="javascript:insertColor('#99CC33')" onmouseover="javascript:showColor('#99CC33')">
<area shape="rect" coords="161,12,167,21" href="javascript:insertColor('#99CC66')" onmouseover="javascript:showColor('#99CC66')">
<area shape="rect" coords="169,12,175,21" href="javascript:insertColor('#99CC99')" onmouseover="javascript:showColor('#99CC99')">
<area shape="rect" coords="177,12,183,21" href="javascript:insertColor('#99CCCC')" onmouseover="javascript:showColor('#99CCCC')">
<area shape="rect" coords="185,12,191,21" href="javascript:insertColor('#99CCFF')" onmouseover="javascript:showColor('#99CCFF')">
<area shape="rect" coords="193,12,199,21" href="javascript:insertColor('#CCCC00')" onmouseover="javascript:showColor('#CCCC00')">
<area shape="rect" coords="201,12,207,21" href="javascript:insertColor('#CCCC33')" onmouseover="javascript:showColor('#CCCC33')">
<area shape="rect" coords="209,12,215,21" href="javascript:insertColor('#CCCC66')" onmouseover="javascript:showColor('#CCCC66')">
<area shape="rect" coords="217,12,223,21" href="javascript:insertColor('#CCCC99')" onmouseover="javascript:showColor('#CCCC99')">
<area shape="rect" coords="225,12,231,21" href="javascript:insertColor('#CCCCCC')" onmouseover="javascript:showColor('#CCCCCC')">
<area shape="rect" coords="233,12,239,21" href="javascript:insertColor('#CCCCFF')" onmouseover="javascript:showColor('#CCCCFF')">
<area shape="rect" coords="241,12,247,21" href="javascript:insertColor('#FFCC00')" onmouseover="javascript:showColor('#FFCC00')">
<area shape="rect" coords="249,12,255,21" href="javascript:insertColor('#FFCC33')" onmouseover="javascript:showColor('#FFCC33')">
<area shape="rect" coords="257,12,263,21" href="javascript:insertColor('#FFCC66')" onmouseover="javascript:showColor('#FFCC66')">
<area shape="rect" coords="265,12,271,21" href="javascript:insertColor('#FFCC99')" onmouseover="javascript:showColor('#FFCC99')">
<area shape="rect" coords="273,12,279,21" href="javascript:insertColor('#FFCCCC')" onmouseover="javascript:showColor('#FFCCCC')">
<area shape="rect" coords="281,12,287,21" href="javascript:insertColor('#FFCCFF')" onmouseover="javascript:showColor('#FFCCFF')">
<area shape="rect" coords="1,23,7,32" href="javascript:insertColor('#009900')" onmouseover="javascript:showColor('#009900')">
<area shape="rect" coords="9,23,15,32" href="javascript:insertColor('#009933')" onmouseover="javascript:showColor('#009933')">
<area shape="rect" coords="17,23,23,32" href="javascript:insertColor('#009966')" onmouseover="javascript:showColor('#009966')">
<area shape="rect" coords="25,23,31,32" href="javascript:insertColor('#009999')" onmouseover="javascript:showColor('#009999')">
<area shape="rect" coords="33,23,39,32" href="javascript:insertColor('#0099CC')" onmouseover="javascript:showColor('#0099CC')">
<area shape="rect" coords="41,23,47,32" href="javascript:insertColor('#0099FF')" onmouseover="javascript:showColor('#0099FF')">
<area shape="rect" coords="49,23,55,32" href="javascript:insertColor('#339900')" onmouseover="javascript:showColor('#339900')">
<area shape="rect" coords="57,23,63,32" href="javascript:insertColor('#339933')" onmouseover="javascript:showColor('#339933')">
<area shape="rect" coords="65,23,71,32" href="javascript:insertColor('#339966')" onmouseover="javascript:showColor('#339966')">
<area shape="rect" coords="73,23,79,32" href="javascript:insertColor('#339999')" onmouseover="javascript:showColor('#339999')">
<area shape="rect" coords="81,23,87,32" href="javascript:insertColor('#3399CC')" onmouseover="javascript:showColor('#3399CC')">
<area shape="rect" coords="89,23,95,32" href="javascript:insertColor('#3399FF')" onmouseover="javascript:showColor('#3399FF')">
<area shape="rect" coords="97,23,103,32" href="javascript:insertColor('#669900')" onmouseover="javascript:showColor('#669900')">
<area shape="rect" coords="105,23,111,32" href="javascript:insertColor('#669933')" onmouseover="javascript:showColor('#669933')">
<area shape="rect" coords="113,23,119,32" href="javascript:insertColor('#669966')" onmouseover="javascript:showColor('#669966')">
<area shape="rect" coords="121,23,127,32" href="javascript:insertColor('#669999')" onmouseover="javascript:showColor('#669999')">
<area shape="rect" coords="129,23,135,32" href="javascript:insertColor('#6699CC')" onmouseover="javascript:showColor('#6699CC')">
<area shape="rect" coords="137,23,143,32" href="javascript:insertColor('#6699FF')" onmouseover="javascript:showColor('#6699FF')">
<area shape="rect" coords="145,23,151,32" href="javascript:insertColor('#999900')" onmouseover="javascript:showColor('#999900')">
<area shape="rect" coords="153,23,159,32" href="javascript:insertColor('#999933')" onmouseover="javascript:showColor('#999933')">
<area shape="rect" coords="161,23,167,32" href="javascript:insertColor('#999966')" onmouseover="javascript:showColor('#999966')">
<area shape="rect" coords="169,23,175,32" href="javascript:insertColor('#999999')" onmouseover="javascript:showColor('#999999')">
<area shape="rect" coords="177,23,183,32" href="javascript:insertColor('#9999CC')" onmouseover="javascript:showColor('#9999CC')">
<area shape="rect" coords="185,23,191,32" href="javascript:insertColor('#9999FF')" onmouseover="javascript:showColor('#9999FF')">
<area shape="rect" coords="193,23,199,32" href="javascript:insertColor('#CC9900')" onmouseover="javascript:showColor('#CC9900')">
<area shape="rect" coords="201,23,207,32" href="javascript:insertColor('#CC9933')" onmouseover="javascript:showColor('#CC9933')">
<area shape="rect" coords="209,23,215,32" href="javascript:insertColor('#CC9966')" onmouseover="javascript:showColor('#CC9966')">
<area shape="rect" coords="217,23,223,32" href="javascript:insertColor('#CC9999')" onmouseover="javascript:showColor('#CC9999')">
<area shape="rect" coords="225,23,231,32" href="javascript:insertColor('#CC99CC')" onmouseover="javascript:showColor('#CC99CC')">
<area shape="rect" coords="233,23,239,32" href="javascript:insertColor('#CC99FF')" onmouseover="javascript:showColor('#CC99FF')">
<area shape="rect" coords="241,23,247,32" href="javascript:insertColor('#FF9900')" onmouseover="javascript:showColor('#FF9900')">
<area shape="rect" coords="249,23,255,32" href="javascript:insertColor('#FF9933')" onmouseover="javascript:showColor('#FF9933')">
<area shape="rect" coords="257,23,263,32" href="javascript:insertColor('#FF9966')" onmouseover="javascript:showColor('#FF9966')">
<area shape="rect" coords="265,23,271,32" href="javascript:insertColor('#FF9999')" onmouseover="javascript:showColor('#FF9999')">
<area shape="rect" coords="273,23,279,32" href="javascript:insertColor('#FF99CC')" onmouseover="javascript:showColor('#FF99CC')">
<area shape="rect" coords="281,23,287,32" href="javascript:insertColor('#FF99FF')" onmouseover="javascript:showColor('#FF99FF')">
<area shape="rect" coords="1,34,7,43" href="javascript:insertColor('#006600')" onmouseover="javascript:showColor('#006600')">
<area shape="rect" coords="9,34,15,43" href="javascript:insertColor('#006633')" onmouseover="javascript:showColor('#006633')">
<area shape="rect" coords="17,34,23,43" href="javascript:insertColor('#006666')" onmouseover="javascript:showColor('#006666')">
<area shape="rect" coords="25,34,31,43" href="javascript:insertColor('#006699')" onmouseover="javascript:showColor('#006699')">
<area shape="rect" coords="33,34,39,43" href="javascript:insertColor('#0066CC')" onmouseover="javascript:showColor('#0066CC')">
<area shape="rect" coords="41,34,47,43" href="javascript:insertColor('#0066FF')" onmouseover="javascript:showColor('#0066FF')">
<area shape="rect" coords="49,34,55,43" href="javascript:insertColor('#336600')" onmouseover="javascript:showColor('#336600')">
<area shape="rect" coords="57,34,63,43" href="javascript:insertColor('#336633')" onmouseover="javascript:showColor('#336633')">
<area shape="rect" coords="65,34,71,43" href="javascript:insertColor('#336666')" onmouseover="javascript:showColor('#336666')">
<area shape="rect" coords="73,34,79,43" href="javascript:insertColor('#336699')" onmouseover="javascript:showColor('#336699')">
<area shape="rect" coords="81,34,87,43" href="javascript:insertColor('#3366CC')" onmouseover="javascript:showColor('#3366CC')">
<area shape="rect" coords="89,34,95,43" href="javascript:insertColor('#3366FF')" onmouseover="javascript:showColor('#3366FF')">
<area shape="rect" coords="97,34,103,43" href="javascript:insertColor('#666600')" onmouseover="javascript:showColor('#666600')">
<area shape="rect" coords="105,34,111,43" href="javascript:insertColor('#666633')" onmouseover="javascript:showColor('#666633')">
<area shape="rect" coords="113,34,119,43" href="javascript:insertColor('#666666')" onmouseover="javascript:showColor('#666666')">
<area shape="rect" coords="121,34,127,43" href="javascript:insertColor('#666699')" onmouseover="javascript:showColor('#666699')">
<area shape="rect" coords="129,34,135,43" href="javascript:insertColor('#6666CC')" onmouseover="javascript:showColor('#6666CC')">
<area shape="rect" coords="137,34,143,43" href="javascript:insertColor('#6666FF')" onmouseover="javascript:showColor('#6666FF')">
<area shape="rect" coords="145,34,151,43" href="javascript:insertColor('#996600')" onmouseover="javascript:showColor('#996600')">
<area shape="rect" coords="153,34,159,43" href="javascript:insertColor('#996633')" onmouseover="javascript:showColor('#996633')">
<area shape="rect" coords="161,34,167,43" href="javascript:insertColor('#996666')" onmouseover="javascript:showColor('#996666')">
<area shape="rect" coords="169,34,175,43" href="javascript:insertColor('#996699')" onmouseover="javascript:showColor('#996699')">
<area shape="rect" coords="177,34,183,43" href="javascript:insertColor('#9966CC')" onmouseover="javascript:showColor('#9966CC')">
<area shape="rect" coords="185,34,191,43" href="javascript:insertColor('#9966FF')" onmouseover="javascript:showColor('#9966FF')">
<area shape="rect" coords="193,34,199,43" href="javascript:insertColor('#CC6600')" onmouseover="javascript:showColor('#CC6600')">
<area shape="rect" coords="201,34,207,43" href="javascript:insertColor('#CC6633')" onmouseover="javascript:showColor('#CC6633')">
<area shape="rect" coords="209,34,215,43" href="javascript:insertColor('#CC6666')" onmouseover="javascript:showColor('#CC6666')">
<area shape="rect" coords="217,34,223,43" href="javascript:insertColor('#CC6699')" onmouseover="javascript:showColor('#CC6699')">
<area shape="rect" coords="225,34,231,43" href="javascript:insertColor('#CC66CC')" onmouseover="javascript:showColor('#CC66CC')">
<area shape="rect" coords="233,34,239,43" href="javascript:insertColor('#CC66FF')" onmouseover="javascript:showColor('#CC66FF')">
<area shape="rect" coords="241,34,247,43" href="javascript:insertColor('#FF6600')" onmouseover="javascript:showColor('#FF6600')">
<area shape="rect" coords="249,34,255,43" href="javascript:insertColor('#FF6633')" onmouseover="javascript:showColor('#FF6633')">
<area shape="rect" coords="257,34,263,43" href="javascript:insertColor('#FF6666')" onmouseover="javascript:showColor('#FF6666')">
<area shape="rect" coords="265,34,271,43" href="javascript:insertColor('#FF6699')" onmouseover="javascript:showColor('#FF6699')">
<area shape="rect" coords="273,34,279,43" href="javascript:insertColor('#FF66CC')" onmouseover="javascript:showColor('#FF66CC')">
<area shape="rect" coords="281,34,287,43" href="javascript:insertColor('#FF66FF')" onmouseover="javascript:showColor('#FF66FF')">
<area shape="rect" coords="1,45,7,54" href="javascript:insertColor('#003300')" onmouseover="javascript:showColor('#003300')">
<area shape="rect" coords="9,45,15,54" href="javascript:insertColor('#003333')" onmouseover="javascript:showColor('#003333')">
<area shape="rect" coords="17,45,23,54" href="javascript:insertColor('#003366')" onmouseover="javascript:showColor('#003366')">
<area shape="rect" coords="25,45,31,54" href="javascript:insertColor('#003399')" onmouseover="javascript:showColor('#003399')">
<area shape="rect" coords="33,45,39,54" href="javascript:insertColor('#0033CC')" onmouseover="javascript:showColor('#0033CC')">
<area shape="rect" coords="41,45,47,54" href="javascript:insertColor('#0033FF')" onmouseover="javascript:showColor('#0033FF')">
<area shape="rect" coords="49,45,55,54" href="javascript:insertColor('#333300')" onmouseover="javascript:showColor('#333300')">
<area shape="rect" coords="57,45,63,54" href="javascript:insertColor('#333333')" onmouseover="javascript:showColor('#333333')">
<area shape="rect" coords="65,45,71,54" href="javascript:insertColor('#333366')" onmouseover="javascript:showColor('#333366')">
<area shape="rect" coords="73,45,79,54" href="javascript:insertColor('#333399')" onmouseover="javascript:showColor('#333399')">
<area shape="rect" coords="81,45,87,54" href="javascript:insertColor('#3333CC')" onmouseover="javascript:showColor('#3333CC')">
<area shape="rect" coords="89,45,95,54" href="javascript:insertColor('#3333FF')" onmouseover="javascript:showColor('#3333FF')">
<area shape="rect" coords="97,45,103,54" href="javascript:insertColor('#663300')" onmouseover="javascript:showColor('#663300')">
<area shape="rect" coords="105,45,111,54" href="javascript:insertColor('#663333')" onmouseover="javascript:showColor('#663333')">
<area shape="rect" coords="113,45,119,54" href="javascript:insertColor('#663366')" onmouseover="javascript:showColor('#663366')">
<area shape="rect" coords="121,45,127,54" href="javascript:insertColor('#663399')" onmouseover="javascript:showColor('#663399')">
<area shape="rect" coords="129,45,135,54" href="javascript:insertColor('#6633CC')" onmouseover="javascript:showColor('#6633CC')">
<area shape="rect" coords="137,45,143,54" href="javascript:insertColor('#6633FF')" onmouseover="javascript:showColor('#6633FF')">
<area shape="rect" coords="145,45,151,54" href="javascript:insertColor('#993300')" onmouseover="javascript:showColor('#993300')">
<area shape="rect" coords="153,45,159,54" href="javascript:insertColor('#993333')" onmouseover="javascript:showColor('#993333')">
<area shape="rect" coords="161,45,167,54" href="javascript:insertColor('#993366')" onmouseover="javascript:showColor('#993366')">
<area shape="rect" coords="169,45,175,54" href="javascript:insertColor('#993399')" onmouseover="javascript:showColor('#993399')">
<area shape="rect" coords="177,45,183,54" href="javascript:insertColor('#9933CC')" onmouseover="javascript:showColor('#9933CC')">
<area shape="rect" coords="185,45,191,54" href="javascript:insertColor('#9933FF')" onmouseover="javascript:showColor('#9933FF')">
<area shape="rect" coords="193,45,199,54" href="javascript:insertColor('#CC3300')" onmouseover="javascript:showColor('#CC3300')">
<area shape="rect" coords="201,45,207,54" href="javascript:insertColor('#CC3333')" onmouseover="javascript:showColor('#CC3333')">
<area shape="rect" coords="209,45,215,54" href="javascript:insertColor('#CC3366')" onmouseover="javascript:showColor('#CC3366')">
<area shape="rect" coords="217,45,223,54" href="javascript:insertColor('#CC3399')" onmouseover="javascript:showColor('#CC3399')">
<area shape="rect" coords="225,45,231,54" href="javascript:insertColor('#CC33CC')" onmouseover="javascript:showColor('#CC33CC')">
<area shape="rect" coords="233,45,239,54" href="javascript:insertColor('#CC33FF')" onmouseover="javascript:showColor('#CC33FF')">
<area shape="rect" coords="241,45,247,54" href="javascript:insertColor('#FF3300')" onmouseover="javascript:showColor('#FF3300')">
<area shape="rect" coords="249,45,255,54" href="javascript:insertColor('#FF3333')" onmouseover="javascript:showColor('#FF3333')">
<area shape="rect" coords="257,45,263,54" href="javascript:insertColor('#FF3366')" onmouseover="javascript:showColor('#FF3366')">
<area shape="rect" coords="265,45,271,54" href="javascript:insertColor('#FF3399')" onmouseover="javascript:showColor('#FF3399')">
<area shape="rect" coords="273,45,279,54" href="javascript:insertColor('#FF33CC')" onmouseover="javascript:showColor('#FF33CC')">
<area shape="rect" coords="281,45,287,54" href="javascript:insertColor('#FF33FF')" onmouseover="javascript:showColor('#FF33FF')">
<area shape="rect" coords="1,56,7,65" href="javascript:insertColor('#000000')" onmouseover="javascript:showColor('#000000')">
<area shape="rect" coords="9,56,15,65" href="javascript:insertColor('#000033')" onmouseover="javascript:showColor('#000033')">
<area shape="rect" coords="17,56,23,65" href="javascript:insertColor('#000066')" onmouseover="javascript:showColor('#000066')">
<area shape="rect" coords="25,56,31,65" href="javascript:insertColor('#000099')" onmouseover="javascript:showColor('#000099')">
<area shape="rect" coords="33,56,39,65" href="javascript:insertColor('#0000CC')" onmouseover="javascript:showColor('#0000CC')">
<area shape="rect" coords="41,56,47,65" href="javascript:insertColor('#0000FF')" onmouseover="javascript:showColor('#0000FF')">
<area shape="rect" coords="49,56,55,65" href="javascript:insertColor('#330000')" onmouseover="javascript:showColor('#330000')">
<area shape="rect" coords="57,56,63,65" href="javascript:insertColor('#330033')" onmouseover="javascript:showColor('#330033')">
<area shape="rect" coords="65,56,71,65" href="javascript:insertColor('#330066')" onmouseover="javascript:showColor('#330066')">
<area shape="rect" coords="73,56,79,65" href="javascript:insertColor('#330099')" onmouseover="javascript:showColor('#330099')">
<area shape="rect" coords="81,56,87,65" href="javascript:insertColor('#3300CC')" onmouseover="javascript:showColor('#3300CC')">
<area shape="rect" coords="89,56,95,65" href="javascript:insertColor('#3300FF')" onmouseover="javascript:showColor('#3300FF')">
<area shape="rect" coords="97,56,103,65" href="javascript:insertColor('#660000')" onmouseover="javascript:showColor('#660000')">
<area shape="rect" coords="105,56,111,65" href="javascript:insertColor('#660033')" onmouseover="javascript:showColor('#660033')">
<area shape="rect" coords="113,56,119,65" href="javascript:insertColor('#660066')" onmouseover="javascript:showColor('#660066')">
<area shape="rect" coords="121,56,127,65" href="javascript:insertColor('#660099')" onmouseover="javascript:showColor('#660099')">
<area shape="rect" coords="129,56,135,65" href="javascript:insertColor('#6600CC')" onmouseover="javascript:showColor('#6600CC')">
<area shape="rect" coords="137,56,143,65" href="javascript:insertColor('#6600FF')" onmouseover="javascript:showColor('#6600FF')">
<area shape="rect" coords="145,56,151,65" href="javascript:insertColor('#990000')" onmouseover="javascript:showColor('#990000')">
<area shape="rect" coords="153,56,159,65" href="javascript:insertColor('#990033')" onmouseover="javascript:showColor('#990033')">
<area shape="rect" coords="161,56,167,65" href="javascript:insertColor('#990066')" onmouseover="javascript:showColor('#990066')">
<area shape="rect" coords="169,56,175,65" href="javascript:insertColor('#990099')" onmouseover="javascript:showColor('#990099')">
<area shape="rect" coords="177,56,183,65" href="javascript:insertColor('#9900CC')" onmouseover="javascript:showColor('#9900CC')">
<area shape="rect" coords="185,56,191,65" href="javascript:insertColor('#9900FF')" onmouseover="javascript:showColor('#9900FF')">
<area shape="rect" coords="193,56,199,65" href="javascript:insertColor('#CC0000')" onmouseover="javascript:showColor('#CC0000')">
<area shape="rect" coords="201,56,207,65" href="javascript:insertColor('#CC0033')" onmouseover="javascript:showColor('#CC0033')">
<area shape="rect" coords="209,56,215,65" href="javascript:insertColor('#CC0066')" onmouseover="javascript:showColor('#CC0066')">
<area shape="rect" coords="217,56,223,65" href="javascript:insertColor('#CC0099')" onmouseover="javascript:showColor('#CC0099')">
<area shape="rect" coords="225,56,231,65" href="javascript:insertColor('#CC00CC')" onmouseover="javascript:showColor('#CC00CC')">
<area shape="rect" coords="233,56,239,65" href="javascript:insertColor('#CC00FF')" onmouseover="javascript:showColor('#CC00FF')">
<area shape="rect" coords="241,56,247,65" href="javascript:insertColor('#FF0000')" onmouseover="javascript:showColor('#FF0000')">
<area shape="rect" coords="249,56,255,65" href="javascript:insertColor('#FF0033')" onmouseover="javascript:showColor('#FF0033')">
<area shape="rect" coords="257,56,263,65" href="javascript:insertColor('#FF0066')" onmouseover="javascript:showColor('#FF0066')">
<area shape="rect" coords="265,56,271,65" href="javascript:insertColor('#FF0099')" onmouseover="javascript:showColor('#FF0099')">
<area shape="rect" coords="273,56,279,65" href="javascript:insertColor('#FF00CC')" onmouseover="javascript:showColor('#FF00CC')">
<area shape="rect" coords="281,56,287,65" href="javascript:insertColor('#FF00FF')" onmouseover="javascript:showColor('#FF00FF')">
</map>

</body>
</html>