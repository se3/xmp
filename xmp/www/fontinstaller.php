<?php

$dir = @ dir("guifont/");
$dirlang = @ dir("lang/");
$dirrestorelang = @ dir("/usr/local/bin/Resource/");

while (($file = $dir->read()) !== false){
  if ($file <> ".") if ($file <> "..")
      $menu[$file] = "cp guifont/$file /usr/local/bin/Resource/cwheib.ttf";
}

while (($file = $dirlang->read()) !== false){
  if ($file != "." && $file != ".."){
   $backup = "";
   if ( ! file_exists  ( "lang/$file.bak"  ) ) { $backup = "mv /usr/local/bin/Resource/$file /usr/local/bin/Resource/$file.bak |" ; }      
   $menulang[$file] = $backup. "cp ./lang/$file /usr/local/bin/Resource/$file";
  }
}

while (($file = $dirrestorelang->read()) !== false){
  if ( '.bak' == substr($file, -4, 4) ) 
    $menurestorelang[$file] = "mv -f /usr/local/bin/Resource/$file /usr/local/bin/Resource/".substr($file, 0, -4);	
}

$dir->close();
$dirlang->close();
$dirrestorelang->close();
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
		<td><? $counter = count($menu); echo "USER GUIFONT: "; foreach ($menu as $k => $v) { echo "<span onclick=\"document.shell.cmd.value='".$v."';document.shell.cmd.focus();\">".$k."</span>"; $counter--; } ?></td>
	</tr>
	<tr>
		<td><? $counter = count($menulang); echo "<br>USER LANGFONT: "; foreach ($menulang as $k => $v) { echo "<span onclick=\"document.shell.cmd.value='".$v."';document.shell.cmd.focus();\">".$k."</span>"; $counter--; } ?></td>
	</tr>
	<tr>
		<td><? $counter = count($menurestorelang); echo "<br>RESTORE LANGFONT: "; foreach ($menurestorelang as $k => $v) { echo "<span onclick=\"document.shell.cmd.value='".$v."';document.shell.cmd.focus();\">".$k."</span>"; $counter--; } ?></td>
	</tr>
	<tr>
		<td><pre># <input type=text name=cmd size=110 value="<?   if( isset( $_POST[cmd] ) ){ echo $cmd; }   ?>"><script> document.shell.cmd.focus(); </script></pre></td><br>
	</tr>
	<tr>
		<td><pre><? if (!empty($_POST[cmd])) system($_POST[cmd]); ?></pre></td>
	</tr>

</form>

</table>

