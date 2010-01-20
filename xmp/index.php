<?
//if login option is true check login status
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "www/login_test.php";
define('OK_INC',1);
php?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Xtreamer Mod Pack</title>
<link rel="stylesheet" type="text/css" href="xmp.css" />
<script type="text/javascript" src="jquery.js"></script>

<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#bottomFrame').load('www/info.php');
}, 120000);
</script>

</head>

<body>
  <div id="leftFrame">
    <? include('www/lefty.php'); ?>
  </div>
  <div id="mainFrame">
    <? 
    if (isset($_GET["page"])) $page = $_GET["page"];
    else $page = 'main.php';
    include("www/$page"); 
    ?>
  </div>
  <div id="bottomFrame">
    <? 
    if (isset($_GET["info"])) $info = $_GET["info"];
    else $info = 'info.php';
    include("www/$info"); 
    ?>
  </div>
</body>

</html>
