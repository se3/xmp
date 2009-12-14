<?

$cmd = "./busybox httpd -c /etc/httpd.conf -p 8080 -h /mnt/usbmounts/sda1/xmp";
$success = @exec( $cmd );

$loadsite = "xtreaminfo.cgi";

$loadsitetext = "Xtreamer Info";

$ipkg = $_GET[ipkg];
if( 1 == $ipkg )
{
   $loadsitetext = "The ipkg web frontend";
   $loadsite = "package.cgi";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Main page</title>
<link rel="stylesheet" type="text/css" href="xmp.css">
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT">
function loadipkg()
{
   document.location.href="http://<?echo $_SERVER["SERVER_ADDR"]; ?>:8080/cgi-bin/<? echo $loadsite; ?>";
}
</SCRIPT> 
<body onload="window.setTimeout('loadipkg()', 2000)">

<p><? echo $loadsitetext ; ?> is loading...</p>

</table>
</body>
</html>