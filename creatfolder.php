<?php
//This file will allow to create New Folder.
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include '/tmp/lang.php';
//if login option is true check login status
$file = "/usr/local/etc/setup.php";
$fp = fopen($file, 'r');
$fileData = fread($fp, filesize($file));
fclose($fp);
$line = explode("\n", $fileData);
$i = 1;
while ($i <= 5) {
        $dataPair = explode('=', $line[$i]);
        if ($dataPair[0] == "Login" && $dataPair[1] == "true") {
                if ($_SESSION['loggedIn'] != 1) {
                       header("Location:login_form.php");
                        exit;
                }
        }
        $i++;
}

$mediapath = $_GET['dir'];

//to deetct internal HDD exists or not
$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);
?>

<script language=javascript>

function makefolder(){
	document.makedir.target = 'gframe';
	document.makedir.action="./creatfolder_new.php?dir=<?echo $mediapath;?>";
	document.makedir.submit();
	
}

</script>

<HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> <? echo $STR_NewFolder ;?></title>
	<link rel="stylesheet" type="text/css" href="dlf/styles.css" />
</head>
<body marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 oncontextmenu="return false;" onLoad="document.forms.makedir.dir_name.focus()" onunLoad="window.opener.location.reload();">
	<table cellspacing="0" cellpadding="0" border="0" width=100% align=center valign=middle>
		<tr height=10><td></td></tr>
		<tr>	
          	<td width=100% align="center" valign="center" background="dlf/top_menu.jpg"><font face="arial" color="#ff0000"><h2><? echo $STR_CreateNewFolder ;?></h2></font></td>
	    </tr>
		
		<tr height=15><td></td></tr>
		<tr><td>
		<center>
		<table>
			<form name="makedir" action='javascript:makefolder();' method="post" enctype="multipart/form-data">

			<tr><td><font face="Arial" color="white" size="2"><? echo $STR_CurrentLocation ;?></td></tr>
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
					$currentpath = "..." . substr($mediapath1, -56);
				}else{
					$currentpath = $mediapath1;
				}
			?>
			<tr><td bgcolor="#e9e9e9"><font color= 'black' face='Arial' size='2'><?echo $currentpath;?>/</td></tr>
			<tr><td ><font face="Arial" color="white" size="2"><? echo $STR_FolderName;?>
					<input type="text" name="dir_name" class="textbox" size="42" class=textbox maxlength="255"> 
					<input type=button name=create class='btn_2' value="<? echo $STR_Create;?>" onclick='javascript:makefolder();';>
			</td></tr>
			<tr><td><font face="Arial" color="white" size="2">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<? echo $STR_MaxLength;?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
			<input type=button class='btn_2' onclick="window.close()" class="web-button" value="<? echo $STR_Close;?>">	</td></tr></table>
			</form>
			<center>
		</td></tr>
	</table>
<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
</body>
</HTML>