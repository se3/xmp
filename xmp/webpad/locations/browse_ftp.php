<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('common.php');
require_once('ftp.php');

// Blunt deny if config doesn't allow ftp
if ($config['allow_ftp'] != true) {
	exit;
}

// Make sure there are specified FTP Servers available
if (!sizeof($config['ftp_servers'])) {
	output_ftp_error('You do not have any FTP Servers configured yet.</p><p>Please consult the Help Manual for details on configuring servers in this version of webpad.');
}

// Get the details of the requested ftp server
if (isset($_REQUEST['ftp']) && strlen($_REQUEST['ftp'])) {
	$server = $config['ftp_servers'][$_REQUEST['ftp']];
	
	// Update ftp session detail
	$_SESSION['ftp'] = $_REQUEST['ftp'];
}
else if (isset($_SESSION['ftp'])) {
	$server = $config['ftp_servers'][$_SESSION['ftp']];
}
else {
	header('Location: select_ftp.php?clear=true');
	exit;
}

// Determine and configure the current FTP directory
if (isset($_GET['home']) && $_GET['home'] == 'true') {
	$_SESSION['ftp_pwd'] = '';
	$ftp_pwd = '';
}
else if (!isset($_REQUEST['ftp_pwd'])) {
	if (!isset($_SESSION['ftp_pwd']) || $_SESSION['ftp_pwd'] == '') {
        $_SESSION['ftp_pwd'] = '';
        $ftp_pwd = '';
	}
	else {
        $ftp_pwd = $_SESSION['ftp_pwd'];
	}
}
else {
	$_SESSION['ftp_pwd'] = str_replace('+', ' ', $_REQUEST['ftp_pwd']);
	$ftp_pwd = str_replace('+', ' ', $_REQUEST['ftp_pwd']);
}


// Attempt a connection to the requested server
$port = (isset($server['port']) && $server['port'] != '' ? $server['port'] : 0);
if (!($ftp = @ftp_connect($server['host'], $port))) {
	output_ftp_error('Could not connect to host \'' . $server['host'] . '\'.</p><p>Perhaps your username or password are wrong, or the host is not available.');
}

if (!($logged_in = @ftp_login($ftp, $server['username'], $server['password']))) {
	output_ftp_error('Could not log in to ' . $server['host'] . '<br />using the username and password you have configured.</p><p>Please check them and confirm they are correct before trying again.');
}
// Set PASV mode according to configuration
ftp_pasv($ftp, $server['pasv']);

// If we're not at the home directory, then change to the current dir
if (strlen($ftp_pwd)) {
	if (!@ftp_chdir($ftp, $ftp_pwd)) {
		output_ftp_error('Could not change directory to \'' . $ftp_pwd . '\' on this server.</p><p>Perhaps the server\'s permissions do not allow it, or the directory has been removed.');
	}
}

?>
<html>
<head>
<title>webpad: ftp browse</title>
<link rel="stylesheet" href="../css/files.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/ftp.js"></script>
</head>

<body onkeypress="if (event.keyCode==27) { window.close(); }">
<?php

$dirs = array();
$files = array();

// Get listing of files from this dir and process it
if ($rawlist = @ftp_rawlist($ftp, "")) {
	// Different handling for different server types, based on regexes
	switch (@ftp_systype($ftp)) {
		case ('Windows_NT') :
			while (list($foo, $dirline) = each($rawlist)) {
				if (ereg('[-0-9]+ *[0-9:]+[PA]?M? +<DIR> {10}(.*)', $dirline, $regs)) {
					$dirinfo[0] = 1;
					$dirs[]     = $regs[1] . '/';
					$dirinfo[1] = 0;
					$dirinfo[2] = $regs[1];
				}
				else if (ereg('[-0-9]+ *[0-9:]+[PA]?M? +([0-9]+) (.*)', $dirline, $regs)) {
					$dirinfo[0] = 0;
					$files[]    = $regs[2];
					$dirinfo[1] = $regs[1];
					$dirinfo[2] = $regs[2];
				}
			}
			break;
		case ('UNIX') :
		default :
			while (list($foo, $dirline) = each($rawlist)) {
				if (ereg('([-d])[rwxst-]{9}.* ([0-9]*) [a-zA-Z]+ [0-9: ]*[0-9] (.+)', $dirline, $regs)) { 
					if ($regs[3] != '.' && $regs[3] != '..') {
						if($regs[1] == 'd') {
							$dirinfo[0] = 1; 
							$dirs[]     = $regs[3] . '/';
						}
						else {
							$dirinfo[0] = 0; 
							$files[]    = $regs[3];
						}
						$dirinfo[1] = $regs[2]; 
						$dirinfo[2] = $regs[3]; 
					}
				}
				else if (ereg('([l])[rwxst-]{9}.* ([0-9]*) [a-zA-Z]+ [0-9: ]*[0-9] (.+) ->', $dirline, $regs)) { 
					$dirinfo[0] = 1; 
					$dirs[]     = $regs[3] . '/';
					$dirinfo[1] = $regs[2]; 
					$dirinfo[2] = $regs[3]; 
				}
			}
	}
}

// Close connection and sort the arrays that we have alphabetically
$close = @ftp_quit($ftp);
sort($dirs, SORT_STRING);
sort($files, SORT_STRING);

// Include a link up, or back to change server
if ($ftp_pwd == '') {
	if (sizeof($config['ftp_servers']) > 1) {
		echo '<a href="select_ftp.php?clear=true" title="Change Active Server"><img src="../images/files_up.gif" width="19" height="18" border="0" align="absmiddle" /> Change Active Server</a>';
	}
}
else {
	echo '<a href="javascript:cdup();" title="Parent Directory"><img src="../images/files_up.gif" width="19" height="18" border="0" align="absmiddle" /> Parent Directory</a>';
}

// Output list of directories
foreach ($dirs as $dir) {
	echo '<a href="javascript:cd(\'' . urlencode($dir) . '\');" title="' . $dir . '"><img src="../images/files_dir.gif" width="19" height="18" border="0" align="absmiddle" /> ' . basename($dir) . '</a>';
}

$file_list = array();

// And a list of files
foreach ($files as $file) {
	$file_list[] = $file;
	if (!in_array(substr($file, strrpos($file, '.') + 1), $config['restrict_files'])) {
		echo '<a href="javascript:select(\'' . $file . '\');" ondblclick="select(\'' . $file . '\'); if (confirm_open()) {parent.document.file.submit();}" id="' . $file . '" title="' . $file . '"><img src="../images/files_file.gif" width="19" height="18" border="0" align="absmiddle" /> ' . basename($file) . '</a>';
	}
	else {
		echo '<div class="disabled"><img src="../images/files_file.gif" width="19" height="18" title="File format restricted" border="0" align="absmiddle" /> ' . $file . '</div>';
	}
}
?>

<script language="JavaScript" type="text/javascript">
<!--
parent.document.file.ftp_pwd.value     = '<?php echo addslashes($_SESSION['ftp_pwd']); ?>';
parent.document.file.current_dir.value = '<?php echo addslashes($_SESSION['ftp_pwd'] == '' ? '~/' : $_SESSION['ftp_pwd']); ?>';

file_list = new Array('<?php 
if ($file_list) {
	foreach ($file_list as $file) {
		echo addslashes($file) . "', '";
	}
}
?>');
// -->
</script>

<form name="ftp" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="ftp_pwd" value="<?php echo $ftp_pwd; ?>" />
<input type="hidden" name="ftp" value="<?php echo $_REQUEST['ftp']; ?>" />
<input type="hidden" name="selected_element" value="" />
</form>

</body>
</html>