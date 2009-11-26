<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
$filename = "/usr/local/etc/keyword.data";
if (file_exists($filename)) {
    $fp = fopen($filename, 'r');
    if (filesize($filename)>0){
	$fileData = fread($fp, filesize($filename));
    }
    fclose($fp);
}
?>

<script language=javascript>

function livekey(){
	document.Keywords.target = 'gframe';
	document.Keywords.action="./URL_data.php";
	document.Keywords.submit();
	
}

</script>

<html>
<title><?echo $STR_LiveKeyTitle;?></title>
<link href="dlf/styles.css" rel="stylesheet" type="text/css">
<body oncontextmenu="return false;" valign="middle">

	<form name="Keywords" action='javascript:livekey();' method="post" enctype="multipart/form-data">
		  <center>
          <table valign="middle" border="0" width="500">
              <tr><td>
				<textarea cols="60" rows="22" name="url" id="edit-comment"><?echo $fileData;?></textarea>
			  </td></tr>
              <tr>  
				<td align='center'><input type="submit" name="saveurl" class='btn_2' value="<?echo $STR_Save;?>" onclick='javascript:livekey();'>
				<input type="button" name="" class='btn_2' onClick="javascript:window.close()" value="<?echo $STR_Close;?>"></td>
              </tr>
          </table>
		  </center>

    </form>

<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
</body>
</html>
