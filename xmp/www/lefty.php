<p>
<a href="?page=main.php" title="Main page">MAIN</a><br />

<a href="?page=programs.php" title="Start &amp; stop programs">PROGRAMS</a><br />

<a href="?page=fakeshell.php" title="Mavvys original fakeshell">MAVVY FS</a><br />

<a href="fm/index.php" title="File manager GUI">FILE MANAGER</a><br />

<?
if ( file_exists( "/opt/bin/ipkg" )  )
{ 
?>
   <a href="?page=package.php" title="IPKG package installer">IPKG WEB</a><br />
<?
}

?>

<a href="?page=backup.php" title="Backup configuration files">BACKUP</a><br />
<br />

<a href="?page=skins.php" title="Skin installer">SKINS</a><br />
<!-- <a href="?page=plsx_maker.php" title="PLSX MAKER">PLSX MAKER</a><br /> -->

<a href="?page=fontinstaller.php" title="Font installer">FONTS</a><br />

<br />

<a href="?page=help.php" title="Help">READ ME</a><br />

<a href="?page=contributors.php">CONTRIBUTORS</a><br />

<br />
<?
if ( file_exists( "/opt/bin/streamripper" ) )
{ 
?>
   <a href="?page=streamripper.php" title="Streamripper">STREAMRIPPER</a><br />
<?
}
if ( file_exists( "/opt/bin/transmission-daemon" ) )
{ 
?>
   <a href="http://<? echo $_SERVER["SERVER_ADDR"]; ?>:9091/transmission/web/" title="Transmission web">TRANSMISSION</a><br />
<?
}
?>
<a href="www/phpinfo.php" target="_new" title="PHP info">PHP INFO</a><br />

<a href="?page=xtreaminfo.php" title="Xtreamer Information">XTREAMER INFO</a><br />

<a href="?page=versioninfo.php" title="Xtreamer Information">VERSION INFO</a><br />

<a href="/" title="Xtreamer Web GUI">Xt WEB GUI</a><br />

<?
if ($_SESSION['loggedIn'] == 1) {
?>
<br />
   <a href="?page=logout.php" title="Logout">Logout</a>
<?
}
?>

</p>
