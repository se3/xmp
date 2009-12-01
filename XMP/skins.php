<?php
$wfile = fopen('dinamic.html','w');
$dir = @ dir("./skins/");
$startfile = fopen('dinamic_start','r');
$startcontents = fread($startfile, 426);
$stopfile = fopen('dinamic_stop','r');
$stopcontents = fread($stopfile, 40);

fwrite($wfile,"$startcontents");

while (($file = $dir->read()) !== false)
  {
  if ($file <> ".") if ($file <> "..")
  {
  fwrite($wfile,'<h1>'."$file".'</h1>'."\n");
  fwrite($wfile,'<br>'."\n");
  fwrite($wfile,'<a href="skins/'."$file".'/skininstall.php" target="bottomFrame">'.'<img src="skins/'."$file".'/'."$file".'.jpg"'.' align="absmiddle" />'.'</a>'."\n");
    fwrite($wfile,'<br>'."\n");
  }}

$dir->close();
fwrite($wfile,"$stopcontents");
fclose($wfile);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="xmp.css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV=Refresh CONTENT="2; URL=dinamic.html">
<title>Skin browser</title>

<body>
<table align="center">
<tr>
<td align="center"><h1>Skin Browser</h1><p>Loading...</p></td>
</tr>
</table>
</body>
</html>