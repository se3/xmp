<?
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
$_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
include "chooselang.php";
include '/tmp/lang.php';

$HDDInfo = shell_exec("df -h|grep /dev/scsi/host0/bus0/target0/lun0/part1");
sscanf($HDDInfo,"%s %s %s %s", $aaa,$HDDTotal, $HDDUsed, $HDDFree);
?>

<html>
<head>
<title><?echo $STR_Setup;?></title>
<link href="dlf/styles.css" rel="stylesheet" type="text/css">
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#012436" oncontextmenu="return false;">

<script language="javascript">
function local_nfs_change(){
	if (!document.nfs.lmount.value){
		alert('<?echo $STR_select_lmount;?>');
	}else if (!document.nfs.rmount.value){
		alert('<?echo $STR_select_rmount;?>');
	}else if (!document.nfs.opt.value){
		alert('<?echo $STR_select_option;?>');
	}else{
		loadDivEl = document.getElementById("loadDiv");
		loadDivEl.style.visibility = 'visible';
		document.nfs.target = 'gframe';
		document.nfs.action = 'nfs_local.php';
		document.nfs.submit();
	}
}

function delmont(){
	flg = 0;
	for(i=0;i<document.unmount.length;i++){
		if(document.unmount[i].checked == true){
			flg = 1;
			break;
		}else{
			flg = 0;
		}
	}

	if(flg == 0){
		alert("<?echo $STR_No_item_selected;?>");
		return false;
	}
	if(confirm('<?echo $STR_ReallyDelete;?>')){
		document.unmount.target = 'gframe';
		document.unmount.action = 'NFS_delete.php';
		document.unmount.submit();
	}
}
</script>

<center>
<table cellspacing="0" cellpadding="0" border="0" height="500" width="996">

	<tr><td width=300>&nbsp</td>
		<td width=620>&nbsp</td>
        <td height="100" align="right" valign="bottom"><a href="index.php"><Img src="dlf/mvix_logo.png" width="300" height="72"></td>
    </tr>


<tr><td width=350>&nbsp</td>
	<td width=620 valign="top">

	<table width=540 height="50"  cellspacing="0" cellpadding="0" border="0">

	<tr><td>
		<table cellspacing="0" cellpadding="0" border="0"><tr>
			<td><a href="register_form.php">
				<font face="arial" color="white" size="2"><b><?echo $STR_Login_Head;?> </b></font>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_ddns.php"><b><?echo $STR_DDNS_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_http.php"><b><?echo $STR_HTTP_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_ftp.php"><b><?echo $STR_FTP_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_live_keyword.php"><b><?echo $STR_LiveKeyword_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_backup.php"><b><?echo $STR_Backup_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
		</tr></table>
	</td></tr>
	
	<tr><td>
		<table cellspacing="0" cellpadding="0" border="0"><tr>
			<td width="150"></td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_language.php"><b><?echo $STR_Language_Head;?> </b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><font face="arial" color="white" size="2">
				<a href="setup_upnp_boost.php"><b><?echo $STR_NAS_Mode;?></b>
				<font face="arial" color="white" size="2">|&nbsp</td>
			<td><a href="setup_nfs.php">
				<font face="arial" color="#ff0000" size="2"><b><u><?echo $STR_NFS_Client;?></u></b></td>
		</tr></table>
	</td></tr>	
	</table>
	
	
	

	<table cellspacing="0" cellpadding="0" border="0">
	<tr height=20><td></td></tr>
	<tr><td height=50 width=0></td>
	<td>
	<div style='width: 540; height: 125; overflow: auto; border: 1px solid #ff0000; background: transparent ;'>
	<form name="unmount" action="javascript:delmont()" method="post">
	<?
			$filename = "/usr/local/etc/nfs";
			if (file_exists($filename)) {
				$fp = fopen($filename, 'r');
				$fileData = fread($fp, filesize($filename));
				fclose($fp);
			}else{
				$fp = fopen($filename, 'w');
				$fileData = fread($fp, filesize($filename));
				fclose($fp);
			}

			$line = explode("\n", $fileData);
			$count = count($line);
			for ($i=0; $i<$count-1; $i++){
				$line1[$i] = $line[$i];

				if ($aaa!= ""){
					$line1[$i] = str_replace("/tmp/usbmounts/sda", "/HDD", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdb1", "/USB1", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdc1", "/USB2", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdd1", "/USB3", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdb", "/USB", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdc", "/USB", $line1[$i]);
					$line1[$i] = str_replace("/tmp/nfsmount", "/NFS Shortcut", $line1[$i]);
				}else{
					$line1[$i] = str_replace("/tmp/nfsmount", "/NFS Shortcut", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sda1", "/USB1", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdb1", "/USB2", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdc1", "/USB3", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdd1", "/USB4", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdb", "/USB", $line1[$i]);
					$line1[$i] = str_replace("/tmp/usbmounts/sdc", "/USB", $line1[$i]);
				}
				echo '<table width=750 cellspacing="0" cellpadding="0" border="0" >';
				echo "<tr> <td>";
				if($line1[$i] != ""){
					echo "<input type='checkbox' name='mylist[]' value='$line[$i]'>";
					echo "<font color='white' face='Arial' size='2'>";
					echo $line1[$i];
				}
				echo "</td></tr></table>";
			}
	?>
	</td></tr>	
	<tr height=3><td></td></tr>
	<tr><td></td><td align="right"><input type="button" class='btn_2' name="del" value="<?echo $STR_Delete;?>" onClick="javascript:delmont();"></td></tr>
	</form>
	</div>
	
	<tr><td width=0></td>
		<td>
		<form name="nfs" action="javascript:local_nfs_change()" method="post">
			<table border="0">
			  <tr><td></td><td><input type="text" name="l_mount" class="textbox" size="50" style="display: none;" value="<?echo $_SESSION['NFS'];?>"><br></td></tr>
			  <tr><td width="130"><font face="Arial" color="white" size="2"><?echo $STR_Local_Mount;?></td>
			  <td><input type="text" name="lmount" class="textbox" size="50" disabled="yes" value="<?echo $_SESSION['NFS_show'];?>"><br></td>
			  <td><input type="button" class='btn_2' name="apply" value="Browse" onClick="window.open('NFS_dir.php','directory','height=630,width=550,left=220,top=50');"></td></tr>
			  <tr><td width="130"><font face="Arial" color="white" size="2"><?echo $STR_Remote_Mount;?></td>
			  <td><input type="text" name="rmount" class="textbox" size="50"><br></td></tr>
			  <tr><td></td><td><font face="Arial" color="white" size="2">xxx.xxx.xxx.xxx:/home</td></tr>
			  <tr><td width="130"><font face="Arial" color="white" size="2"><?echo $STR_Options;?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp-o</td>
			  <td><input type="text" name="opt" class="textbox" size="50"><br></td></tr>
			  <tr><td></td><td><font face="Arial" color="white" size="2">rsize=32768,wsize=32768,tcp</td></tr>
			  <tr><td height="5"></td></tr>
			  <tr><td></td><td><input type="button" class='btn_2' name="apply" value="<?echo $STR_Apply;?>" onClick="javascript:local_nfs_change();"></td></tr>
			</table>
		</form>
		</td>
	</tr>
	</table>

	</td>

	<td width="337" align="right" valign="middle"><img src="dlf/pvr_img.png" width="337" height="250"></td>
</tr>
</table>

<iframe name='gframe' width=0 height=0 style="display:none"></iframe>
<div id="loadDiv" name="loadDiv" style="position:absolute; visibility:hidden; left:340;top:190;width:200; height:100; z-index:1;">
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

<table width="700"  border="0" cellspacing="0" cellpadding="0">
  <tr height=4><td></td></tr>	
  <tr>
    <td align="right" valign="top" style="border-top:solid 1px; border-top-color:#FFFFFF"><table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr><td width=20></td>
        <td width=440 valign="middle"><font face="Arial" color="#748e94" size="2"><a href="index.php"><?echo $STR_Home;?></a> | <a href="register_form.php"><?echo $STR_Setup;?></a> | <a href="logout.php"><?echo $STR_Logout;?></a></font></td>

		<td align=right>
			<table><tr><!--td align=right><font face="Arial" color="#000000" size="1"><b><?echo date('M, d Y | h:i A');?></td--></tr>
				   <tr><td align=right><font face="Arial" color="#000000" size="1"><b>Copyright ⓒ 2009 Xtreamer.net, All right reserved.</td></tr>
			</table>
		</td>

        <td align=right><img src="dlf/footer.png" width="175" height="51" usemap="#planetmap">
		<map name="planetmap">
		  <area shape="rect" coords="05,100,135,2" href='#' onclick="window.open('http://xtreamer.net/','MyVideo','height=675,width=987,left=100,top=100, toolbar=yes,location=yes,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no');";/>
		</map>
		</td>
      </tr>
    </table>
      </td>
  </tr>
</table>
</center>

</body>
</html>
