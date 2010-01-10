<?

$task  = $_GET[task];
$installed  = $_GET[installed];
$submit = $_GET[submit];
$package = $_GET[package];
$updatedb = $_GET[updatedb];
$namefilter = $_GET[namefilter];
$typefilter = $_GET[typefilter];
			//<option selected value="none">NONE</option>
			//<option value="update">Updates</option>
			//<option value="installed">Installed</option>
			//<option value="not">Not installed</option>

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ipkg web</title>
<link rel="stylesheet" type="text/css" href="../xmp.css">


<style type="text/css">
h1, h2 {
  font-family: Arial, Helvetica, sans-serif;
  color: #900;
}

table {
  border-top: 1px solid #eee;
  border-right: 1px solid #eee;
  width: 100%;
}

th, td {
  padding: 2px 4px;
  border-left: 1px solid #eee;
  border-bottom: 1px solid #eee;
}


table a.ins {
  background: #ddd;
  color: #004;
  text-decoration: none;
  margin: 1px;
  padding: 2px 4px;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 75%;
  background: #dfd;
  border-left: 1px solid #cec;
  border-bottom: 1px solid #cec;
}

table a.upd {
  background: #ddd;
  color: #004;
  text-decoration: none;
  margin: 1px;
  padding: 2px 4px;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 75%;
  background: #ddf;
  border-left: 1px solid #cce;
  border-bottom: 1px solid #cce;
}

table a.del {
  background: #ddd;
  color: #004;
  text-decoration: none;
  margin: 1px;
  padding: 2px 4px;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 75%;
  background: #fdd;
  border-left: 1px solid #ecc;
  border-bottom: 1px solid #ecc;
}

input {
 background-color: #999;
 color: DfD;
 cursor: pointer;
}

input[disabled='disabled'] {
  background: #888;
  color: #AAA;
  cursor:default;
}

body,td,th {
	background-color: #000;
	font-size: 14px;
	color: #BBB;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
}
a {
	font-size: 14px;
	color: #900;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #900;
}
a:hover {
	text-decoration: underline;
	color: #F00;
}
a:active {
	text-decoration: none;
}

#leftFrame {
 background-color: #200;
}
#mainFrame {
 background-color: #000;
}
#bottomFrame {
 background-color: #100;
}


#borderFrame {
 background-color: #333;
}

#border2Frame {
 background-color: #333;
}

</style>
</head>

<body id="mainFrame">
<h1>The ipkg web frontend</h1>
<form methode="GET">
<table>
<tr>
	<td>Sync packages</td>
	<td>
		<input type="radio" name="updatedb" value="n" checked>no</input>
		<input type="radio" name="updatedb" value="y">yes</input>
	</td>
</tr>
<tr>
	<td>Type:</td>
	<td>
		<select name="typefilter">
			<option <? if ( $typefilter == "none") echo "selected"; ?> value="none">NONE</option>
			<option <? if ( $typefilter == "update") echo "selected"; ?> value="update">Updates</option>
			<option <? if ( $typefilter == "installed") echo "selected"; ?> value="installed">Installed</option>
			<option <? if ( $typefilter == "not") echo "selected"; ?> value="not">Not installed</option>
		</select>
	</td>
</tr>
<tr>
	<td>Filter</td>
	<td><input type="text" name="namefilter"></td>
</tr>
</table>
<input type="submit" name="submit">&nbsp;<input type="reset">
</form>




<?
if ( "info" == $task  && "" != $package )
{
     echo "<h2>Package Info</h2><pre>\n";
     system("/opt/bin/ipkg info $package");
     if ( "y" == $installed ) {
      system("/opt/bin/ipkg files $package");
     }
     echo '</pre>';
}

if ( "y" == $updatedb )
{
	echo "<h2>Upgrading package list</h2><pre>\n";
     system("/opt/bin/ipkg update");
	echo '</pre>';
}

if ( "install" == $task && "" != $package )
{
	echo "<h2>Install $package</h2><pre>\n";
	system("/opt/bin/ipkg -force-defaults install $package");
	echo '</pre>';
}

if ( "update" == $task && "" != $package)
{
	echo "<h2>Update $package</h2><pre>\n";
	system("/opt/bin/ipkg -force-defaults upgrade $package");
	echo '</pre>';
}

if ( "delete" == $task && "" != $package)
{
	echo "<h2>Delete $package</h2><pre>";
	system("/opt/bin/ipkg -force-defaults remove $package");
	echo '</pre>';
}

if ( "" != $submit  ){
   echo '<h2>Package list</h2>';
   @exec("/opt/bin/ipkg list_installed", $listinstalled );
   @exec("/opt/bin/ipkg list", $list );
   echo '<table border="1" cellpadding="0" cellspacing="0">';
   echo '<tr><th>task</th><th>Package</th><th>I-Ver</th><th>P-Ver</th><th>Comment</th><th>Delete</th></tr>';

   function packfilter($p)
   {
      global $namefilter;
      return ( eregi($namefilter, $p, $regs ) ) ;
   }
   if ( "" != $namefilter ) { $list = array_filter( $list, "packfilter" );   }
   
   foreach ($list as $pack ) {
      $task = "";
      $info = "";
      $version = "";
      $del = "&nbsp;";
      list($listname , $listversion, $listdescription ) = explode(" - ", $pack );
      
      if ( $listname != "" && $listversion != "" && $listdescription != "" )
      {
         foreach ($listinstalled as $packinstalled ) {
            list($nameinstalled , $versioninstalled, $descriptioninstalled ) = explode(" - ", $packinstalled );      
            if ( $nameinstalled == $listname )
            {
               $info ="<a title=\"package info $nameinstalled\" href='package.php?task=info&installed=y&package=$nameinstalled'>$nameinstalled</a>";
               $del = "<a href='package.php?task=delete&package=$nameinstalled' class='del'>delete</a>";
               if ( $versioninstalled != $listversion )
               {
                  $task = "<a href='package.php?task=update&package=$nameinstalled' class='upd'>update</a>";
                  $version = $versioninstalled;
               }
               else
               {
                  $version = $listversion;
                  $task = "&nbsp;";
               }
               break;            
            }
         }
         if ( "" == $task )
         {
            $task ="<a title=\"package info $listname\" href='package.php?task=install&package=$listname' class='ins'>install</a>";
         }
         
         if ( "" == $info )
         {
            $info ="<a href='package.php?task=info&package=$listname'>$listname</a>";
         }
         
        switch ( $typefilter ) 
        {
            case "update":
               if ( $version != "" && $version != $listversion )
                     echo "<tr><td>$task</td><td>$info</td><td>$listversion</td><td>$version</td><td>$listdescription</td><td>$del</td></tr>\n";
            break;
            case "installed":
               if ( $del != "&nbsp;" )
                     echo "<tr><td>$task</td><td>$info</td><td>$listversion</td><td>$version</td><td>$listdescription</td><td>$del</td></tr>\n";
            break;
            case "not":
               if ( $task != "&nbsp;" )
                     echo "<tr><td>$task</td><td>$info</td><td>$listversion</td><td>$version</td><td>$listdescription</td><td>$del</td></tr>\n";
            break;
            default:
               echo "<tr><td>$task</td><td>$info</td><td>$listversion</td><td>$version</td><td>$listdescription</td><td>$del</td></tr>\n";
            
            break;
         }
      }
   }
   echo '</table>';
}


?>
</body>
</html>