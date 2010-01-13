<?php
/*
 * Copyright (C) 2006 - 2007, West-Web Limited.
 *
 * Nickolay Shestakov <ns@ampex.ru>
 *
 * This program is free software, distributed under the terms of
 * the GNU General Public License Version 2. See the LICENSE file
 * at the top of the source tree.
 */
 
include_once("func.php"); 

extract(stripslashes_r($_GET));

$size=filesize($file);

if(empty($file) || (!is_file($file)) || (!$size)) exit();
$bn=substr(strrchr($file,'/'),1);
if(!($fp=@fopen($file, "rb"))) exit();

if($type == 'txt') {?>
    <html>
    <head>
    <title><?=$title?></title>		
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body style="margin: 0px;">
    <textarea id="ta" style="width: 100%; height: 100%; border: 0; overflow: auto;
    font-size: 12px; font-family: courier new,monospace;" readonly=1><? 
    $i=0;
    while(!feof($fp)) {
      //echo $i.". ";
      echo fgets($fp);
      $i++;
    }
    //echo "num_rows=$i";
    fclose($fp);
    //$plus = (int) $i*0.05;
    //if($plus < 10) $plus=10;
    ?>
    </textarea>
    <script type="text/javascript">
    <?/* //document.getElementById('ta').rows=<?=($i+$plus)?>;*/?>
    </script>
    </body>
    </html>
<?
exit();
}
//echo "type=$type";
switch ($type) {
    case 'wav'	: $ctype="audio/x-wav";$type="Microsoft Audio";$head_b=true; break;
    case 'mp3'	: $ctype="audio/x-mpeg"; $type="MPEG audio"; $head_b=true; break;
    case 'jpeg'	: case 'jpg': case 'jpe': $ctype="image/jpeg"; $head_b=true; break;
    case 'tif'	:
    case 'tiff'	: $ctype="image/tiff"; $head_b=true; break;
    case 'png'	: $ctype="image/x-png"; $type="Portable Network Graphics";break;
    case 'gif'	: $ctype="image/gif"; $head_b=true; break;
    case 'bmp'	: $ctype="image/x-ms-bmp"; $head_b=true; $type="MIcrosoft Window bitmap";break;
    case 'html'	: $ctype="text/html"; break;
    case 'txt'	: $ctype="text/plain"; $type="Plain Text";break;
    case 'pdf'	: $ctype="application/pdf"; $type="Adobe Acrobat PDF";break;
    case 'rtf'	: $ctype="application/rtf"; break;
    case 'doc'	: $ctype="application/msword"; $type="MS Word"; break;
    case 'zip'	: $ctype="application/zip"; $head_b=true; break;
    case 'tar'	: $ctype="application/tar"; $head_b=true; break;
    default 	: $ctype="application/octet-stream"; $head_b=true; $type="Binary";break;

}


header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: ".$type." file");
header("Content-Type: ".$ctype);
if($head_b) {
    header("Content-Disposition: attachment; filename=" . $bn);
    header("Content-Transfer-Encoding: binary");
}
header("Content-length: " . $size);
fpassthru($fp);
?>
