<?
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';
//if upload temp directory not exists create it.
$tempfile = "/tmp/hdd/volumes/HDD1/.cached";
if (!file_exists($tempfile)) {
	echo `mkdir /tmp/hdd/volumes/HDD1/.cached`;
}

shell_exec('rm -rf /tmp/hdd/volumes/HDD1/.cached/*');

$mediapath = $_GET['dir'];

//to deetct internal HDD exists or not
$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title><?echo $STR_UploadTitle;?></title>

<link href="js/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="swfupload.js"></script>
<script type="text/javascript" src="js/swfupload.queue.js"></script>
<script type="text/javascript" src="js/fileprogress.js"></script>
<script type="text/javascript" src="js/handlers.js"></script>
<script type="text/javascript">

		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "swfupload.swf",
				upload_url: "upload_file.php?dir=<? echo $mediapath;?>",
				post_params: {"PHPSESSID" : ""},
				file_size_limit : "1024 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 1025,
				file_queue_limit : 10,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "dlf/TestImageNoText_65x29.png",
				button_width: "45",
				button_height: "20",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">Upload</span>',
				button_text_style: ".theFont { color: #FFFFFF; font-size: 14; font-family: 'Arial';}",
				button_cursor: SWFUpload.CURSOR.HAND,				
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };


//----------------------------------


function makefolder(){

	document.makedir.target = 'gframe';
	document.makedir.action="./newfolder.php?dir=<?echo $mediapath;?>";
	document.makedir.submit();
	
}

function stop(){
	document.write_form.Button1.disabled=true;
	//document.write_form.Button2.disabled=false;
	document.gframe.location.href = 'stop.php';
}

function startps(){
	document.write_form.Button1.disabled=false;
	document.write_form.Button2.disabled=true;
	document.gframe.location.href = 'start.php';
}

function EnableDisable(){
	document.gframe.location.href = 'EnableDisable.php';
}

</script>
</head>


<!--meta http-equiv="Content-Type" content="text/html; charset=utf-8"-->

<link href="dlf/styles.css" rel="stylesheet" type="text/css">

<style type="text/css">
body {
	font-family: Arial, Verdana, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
	background-color: #012436;
	background-image: url('dlf/background.jpg');
	background-repeat: no-repeat;
	background-attachment:fixed;
	background-position: center center;
	padding: 0;
	margin: 0;
}

table, td {
	font-family: Arial, Verdana, Helvetica, sans-serif;
	font-size: 12px;
	padding: 0px;
}

#TitleStrip {
	padding: 10px;
	background-color: #012436;
	font-size: 16px;
	background-image: url('dlf/top_menu.jpg');
	color: #ff0000;
}

#Content {padding-left: 5px; padding-right: 5px;}
p.alignright {text-align: right;}
hr {margin: 0px 0;}
.ErrorMsg {color: #F00;}
</style>


<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu='return false' ondragstart='return false' ONMOUSEOVER="EnableDisable();" onunLoad="window.opener.location.reload();">
<div id="TitleStrip"><center> <?echo $STR_UploadTitle;?> </div>
<div id="Content">

<form name="makedir" action='javascript:makefolder();' method="post" enctype="multipart/form-data">
	<table width=455 cellspacing="0" cellpadding="0" border="0">
	<tr><td><?echo $STR_UploadLocation;?></td></tr>
	<?
		$mediapath1 = $mediapath;
		if ($aaa!= ""){
			$mediapath1 = str_replace("sda", "HDD", $mediapath1);
			$mediapath1 = str_replace("sdb1", "USB1", $mediapath1);
			$mediapath1 = str_replace("sdc1", "USB2", $mediapath1);
			$mediapath1 = str_replace("sdd1", "USB3", $mediapath1);
			$mediapath1 = str_replace("sdb", "USB", $mediapath1);
			$mediapath1 = str_replace("sdc", "USB", $mediapath1);
		}else{
			$mediapath1 = str_replace("sda1", "USB1", $mediapath1);
			$mediapath1 = str_replace("sdb1", "USB2", $mediapath1);
			$mediapath1 = str_replace("sdc1", "USB3", $mediapath1);
			$mediapath1 = str_replace("sdd1", "USB4", $mediapath1);
			$mediapath1 = str_replace("sdb", "USB", $mediapath1);
			$mediapath1 = str_replace("sdc", "USB", $mediapath1);
		}

		if (strlen($mediapath) > 60){
			$currentpath = "..." . substr($mediapath1, -57);
		}else{
			$currentpath = $mediapath1;
		}
	?>
	<tr><td bgcolor="#e9e9e9"><font face="Arial" color="#000000" size="2"><?echo $currentpath;?></td></tr>
	<tr height=5><td></td></tr>
	<tr><td><?echo $STR_NewFolderName;?>&nbsp
		<input type="text" name="dir_name" class="textbox" size="35" maxlength="255"> 
		<input type=button class='btn_2' name=create value="<?echo $STR_Create;?>" onclick='javascript:makefolder();';>
	</td></tr>
	<tr height=5><td></td></tr>
	</table>		
</form>


	<form id="form1" name="write_form" action="upload.php" method="post" enctype="multipart/form-data">
	<hr></hr>
	<table width=455 height=390 cellspacing="0" cellpadding="0" border="0">

	<tr><td>

			<div class="fieldset flash" id="fsUploadProgress">
				<span class="legend"></span>
			</div>

				<div>
					<span id="spanButtonPlaceHolder"></span>
					&nbsp<input id="btnCancel" type="button" class='btn_2' value="<?echo $STR_Cancel;?>" onclick="swfu.cancelQueue();" disabled="disabled"/>
				</div>
	</td></tr></table>


<hr>
	<table cellspacing="0" cellpadding="0" border="0" width=458 align=center>
	<tr height=10><td></td></tr>	
	<tr><td><font color="#FFFFFF"><BLINK><?echo $STR_Caution;?></BLINK><?echo "[".$STR_NAS_Mode."]";?></td>

		<tr><td width=79% ><font color="#FFFFFF">
				<?echo $STR_If500;?><br>
				<?//echo $STR_AfterFinishUpload;?>
			</td>
			<td>
				<input type=button class='btn_2' name="Button1" value="<?echo $STR_Start;?>" onclick="javascript:stop();";>
			</td>
		</tr>
	</table>		
</form>

<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
<div id="loadDiv" name="loadDiv" style="position:absolute; visibility:hidden; left:30;top:120;width:200; height:100; z-index:1;">
	<table cellspacing="0" cellpadding="0" border="0" width=100% height=100%>
		<td valign=middle align=center>
			<table borde=0 align=center>
				<td align=center>			
					<img src="dlf/upload.gif">
				</td>
			</table>
		</td>
	</table>
</div>
</body>
</html>
