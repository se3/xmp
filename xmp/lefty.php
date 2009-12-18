<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lefty</title>
<link rel="stylesheet" type="text/css" href="xmp.css">
</head>

<body>

<p><a href="programs.php" target="mainFrame" title="Start & stop programs">PROGRAMS</a></p>

<p><a href="fakeshell.php" target="mainFrame" title="Mavvys original fakeshell">MAVVY FS</a></p>

<p><a href="backup.php" target="mainFrame" title="Backup configuration files">BACKUP</a></p>

<?
if ( file_exists( "/opt/bin/ipkg" ) && file_exists( "./busybox" )  )
{ 
?>
   <p><a href="package.php?ipkg=1" target="mainFrame" title="IPKG package installer">IPKG WEB</a></p>
<?
}

if ( file_exists( "/opt/bin/streamripper" ) )
{ 
?>
   <p><a href="streamripper.php" target="mainFrame" title="Streamripper">STREAMRIPPER</a></p>
<?
}

if ( file_exists( "/opt/bin/transmission-daemon" ) )
{ 
?>
   <p><a href="http://<? echo $_SERVER["SERVER_ADDR"]; ?>:9091/transmission/web/" target="mainFrame" title="Transmission web">TRANSMISSION WEB</a></p>
<?
}
?>

<p>&nbsp;</p>

<p><a href="skins.php" target="mainFrame" title="Skin installer">SKINS</a></p>

<p><a href="fontinstaller.php" target="mainFrame" title="Font installer" >FONTS</a></p>

<p>&nbsp;</p>

<p><a href="help.html" title="Help" target="mainFrame">READ ME</a></p>

<p><a href="contributors.html" target="mainFrame">CONTRIBUTORS</a></p>

<p>&nbsp;</p>

<p><a href="phpinfo.php" title="PHP info" target="mainFrame">PHP INFO</a></p>
<?
if ( file_exists( "./busybox" ) )
{ 
?>
   <p><a href="package.php" title="Xtreamer Information" target="mainFrame" >XTREAMER INFO</a></p>
<?
}
?>

<p><a href="../../../" title="Xtreamer Web GUI" target="mainFrame">Xt WEB GUI</a></p>


</body>
</html>
