<p><a href="?page=programs.php" title="Start &amp; stop programs">PROGRAMS</a></p>

<p><a href="?page=fakeshell.php" title="Mavvys original fakeshell">MAVVY FS</a></p>

<p><a href="fm/index.php" title="File manager GUI">FILE MANAGER</a></p>

<?
if ( file_exists( "/opt/bin/ipkg" )  )
{ 
?>
   <p><a href="?page=package.php" title="IPKG package installer">IPKG WEB</a></p>
<?
}

if ( file_exists( "/opt/bin/streamripper" ) )
{ 
?>
   <p><a href="?page=streamripper.php" title="Streamripper">STREAMRIPPER</a></p>
<?
}

if ( file_exists( "/opt/bin/transmission-daemon" ) )
{ 
?>
   <p><a href="http://<? echo $_SERVER["SERVER_ADDR"]; ?>:9091/transmission/web/" title="Transmission web">TRANSMISSION WEB</a></p>
<?
}
?>

<p><a href="?page=backup.php" title="Backup configuration files">BACKUP</a></p>
<p>&nbsp;</p>

<p><a href="?page=skins.php" title="Skin installer">SKINS</a></p>

<p><a href="?page=fontinstaller.php" title="Font installer">FONTS</a></p>

<p>&nbsp;</p>

<p><a href="?page=help.php" title="Help">READ ME</a></p>

<p><a href="?page=contributors.php">CONTRIBUTORS</a></p>

<p>&nbsp;</p>

<p><a href="www/phpinfo.php" target="_new" title="PHP info">PHP INFO</a></p>

<p><a href="?page=xtreaminfo.php" title="Xtreamer Information">XTREAMER INFO</a></p>

<p><a href="/" title="Xtreamer Web GUI">Xt WEB GUI</a></p>

<p>&nbsp;</p>

<p><a href="?page=logout.php" title="Logout">Logout</a></p>
