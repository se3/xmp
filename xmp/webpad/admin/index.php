<?include "/mnt/HD_a2/www/pages/webian/chili/inc_config.php";?>
<?php
// If there's already a configuration file, then require authentication
if (is_file('configuration.php')) {
	include_once('configuration.php');
	include_once('authentication.php');
}
require_once('plugins.php');

// Handle a submitted form (write config file)
if (sizeof($_POST) && isset($_POST['_save'])) {
	// Figure out the password - either an md5 of a confirmed pass, or what
	// was already in the config file if not to be updated.
	$password = $config['password'];
	if (strlen($_POST['_password1'])) {
		if ($_POST['_password1'] == $_POST['_password2']) {
			$password = md5($_POST['_password1']);
			 $_SESSION['password'] = $password;
		}
	}
	
	// Update session username either way
	$_SESSION['username'] = $username ;
	
	// Determine what to put in the "email_from" var
	$email_from = $config['email_from'];
	if (strlen($_POST['email_from_name']) && strlen($_POST['email_from_email'])) {
		$email_from = addslashes($_POST['email_from_name']) . ' <' . $_POST['email_from_email'] . '>';
	}
	else if (strlen($_POST['email_from_email'])) {
		$email_from = $_POST['email_from_email'];
	}

	// Build out the "static" config string
	$config_str = '<' . '?php' . "\n";
	$config_str .= "\$config = array();\n\n" . 
					
					"\$config['username'] = '" . $username . "';\n" . 
					"\$config['password'] = '" . $password . "';\n" . 
					"\$config['home_dir'] = '" . addslashes($_POST['home_dir']) . "';\n" . 
					"\$config['logout_url'] = '" . $_POST['logout_url'] . "';\n\n" . 
					
					"\$config['allow_upload'] = " . ($_POST['allow_upload'] == 'true' ? 'true' : 'false') . ";\n" . 
					"\$config['use_templates'] = " . ($_POST['use_templates'] == 'true'  ? 'true' : 'false') . ";\n" . 
					"\$config['editor_wordwrap'] = " . ($_POST['editor_wordwrap'] == 'true'  ? 'true' : 'false') . ";\n" . 
					"\$config['editor_font_face'] = '" . (strlen($_POST['editor_font_face']) ? addslashes($_POST['editor_font_face']) : '') . "';\n" . 
					"\$config['editor_font_size'] = " . (preg_match('/^\d+$/', $_POST['editor_font_size']) ? $_POST['editor_font_size'] : 10) . ";\n\n" . 
					
					"\$config['allow_email'] = " . (strlen($_POST['allow_email']) ? $_POST['allow_email'] : 'false') . ";\n" . 
					"\$config['email_from'] = '" . $email_from . "';\n\n";

	// Add FTP Servers
	$config_str .= "\$config['allow_ftp'] = " . (strlen($_POST['allow_ftp']) ? $_POST['allow_ftp'] : 'false') . ";\n";
	for ($f = 0; $f <= $_POST['ftp_count']; $f++) {
		if (isset($_POST['ftp_' . $f])) {
			$config_str .= "\$config['ftp_servers'][] = array('host'=>'" . $_POST['ftp_' . $f]['host'] . "', 'port'=>" . (strlen($_POST['ftp_' . $f]['port']) ? $_POST['ftp_' . $f]['port'] : 21) . ", 'pasv'=>" . (strlen($_POST['ftp_' . $f]['pasv']) ? $_POST['ftp_' . $f]['pasv'] : 'false') . ", 'username'=>'" . $_POST['ftp_' . $f]['username'] . "', 'password'=>'" . $_POST['ftp_' . $f]['password'] . "');\n";
		}
	}
	$config_str .= "\n";
	
	// Add Plugin Configs
	$config_str .= "\$config['allow_plugins'] = " . (strlen($_POST['allow_plugins']) ? $_POST['allow_plugins'] : 'false') . ";\n";
	for ($p = 0; $p <= $_POST['plugin_count']; $p++) {
		if (isset($_POST['plugin_' . $p])) {
			$config_str .= "\$config['plugins'][] = array(";
			foreach ($_POST['plugin_' . $p] as $key=>$val) {
				$config_str .= "'$key'=>'" . addslashes($val) . "', ";
			}
			$config_str = substr($config_str, 0, -2) . ");\n";
		}
	}
	
	// Last line to include the system config
	$config_str .= "\n";
	$config_str .= "require_once(dirname(__FILE__) . '/webpad_conf.php');\n";
	$config_str .= '?' . '>';
	
	// Write the config string to file
	$cf = @fopen('configuration.php', 'w');
	if ($cf) {
		fwrite($cf, $config_str);
		fclose($cf);
		$saved = true;
		$msg = '<p align="center"><img src="../images/tick.gif" width="22" height="22" border="0" align="absmiddle" alt="Tick" /> <strong>Your webpad settings have been saved successfully.</strong></p><p align="center">You may now <a href="../">return to webpad.</a></p>';
	}
	else {
		$saved = false;
		$msg = '<p align="center"><img src="../images/delete-w.gif" width="22" height="22" border="0" align="absmiddle" alt="Cross" /> <strong>There was a problem saving your settings.</strong></p><p align="center">Check permissions on configuration.php and try again.</p>';
	}
	
	// Now include the new config again, to re-set $config to the new values.
	include('configuration.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>webpad Configuration</title>
<style type="text/css">
body {
	text-align: center;
	background: #EEEEEE;
	margin: 1em;
	font-family: Verdana, Arial, Helvetica;
	font-size: 90%;
}

form {
	margin: 0;
	padding: 0;
	border: 0;
}

h1 {
	background: #265997;
	color: #FFFFFF;
	font-family: Tahoma, Arial Narrow, Arial, Verdana, sans-serif;
	font-size: 1.5em;
	font-weight: 600;
	padding: 0.3em;
	margin: 0.5em auto 0 auto;
	text-align: center;
	width: 630px;
}

h2 {
	font-size: 15pt;
	margin: 0 0 0.5em 0;
}

hr {
	border-bottom: 0;
	border-top: solid 1px #EEEEEE;
}

a {
	color: #0000FF;
}

label {
	float: left;
	display: block;
	width: 180px;
	cursor: pointer;
}

label.inline {
	display: inline;
	width: auto;
	float: none;
}

label.ftp {
	margin-left: 50px;
	width: 100px;
}

label.plugin {
	margin-left: 50px;
	width: 100px;
}

form div {
	height: 2em;
}

form div.section {
	margin: 0.5em auto;
	position: relative;
	text-align: left;
	width: 600px;
	height: auto;
	background: #FFFFFF;
	border: solid 10px #3A85E1;
	padding: 1em;
}

form div.submit {
	text-align: left;
	width: 600px;
	height: auto;
	margin: 0.5em auto;
	padding: 1em;
	text-align: center;
}

input {
	display: inline;
	width: 150px;
}

input.long {
	width: 310px;
}

input.short {
	width: 40px;
}

input.auto {
	width: auto;
}

input.error {
	background: #FF9898;
	color: #FFFFFF;
	font-weight: bold;
	border: solid 1px #CE0000;
}

div.ftp {
	margin-left: 50px;
	display: block;
	height: auto;
	border-left: solid 2px #DDDDDD;
}

div.ftp_count {
	float: left;
	display: block;
	width: 40px;
	height: 55px;
	text-align: right;
}

div.ftp_count p {
	float: right;
	display: block;
	margin: 0;
	background: #CCCCCC;
	color: #FFFFFF;
	font-weight: bold;
	text-align: right;
	width: 18px;
	font-family: Garamond, Times, Serif;
	font-size: 15pt;
	padding-right: 3px;
}

div.plugin {
	margin-left: 50px;
	display: block;
	height: auto;
	border-left: solid 2px #DDDDDD;
}

div.plugin_icon {
	float: left;
	text-align: right;
	padding-right: 10px;
	display: block;
	width: 40px;
	height: 55px;
}

</style>
<script language="JavaScript" type="text/javascript">
<!--
// Load the logout_url value into a new window if there is one
function test_logout_url() {
	if (document.config.logout_url.value.length > 3) {
		window.open(document.getElementById('logout_url').value, 'logoutpreview', '');
	}
}

// Toggle the email section and make all fields read only if off
function toggle_email(tog) {
	document.getElementById('email_from_name').readOnly  = !tog;
	document.getElementById('email_from_email').readOnly = !tog;
}

// Toggle the FTP section and make all fields read only if off
function toggle_ftp(tog) {
	c = document.getElementById('ftp_count').value;
	for (i = 0; i <= c; i++) {
		if (document.getElementById('ftp_' + i + '[host]')) {
			document.getElementById('ftp_' + i + '[host]').readOnly     = !tog;
			document.getElementById('ftp_' + i + '[port]').readOnly     = !tog;
			document.getElementById('ftp_' + i + '[pasv]').readOnly     = !tog;
			document.getElementById('ftp_' + i + '[username]').readOnly = !tog;
			document.getElementById('ftp_' + i + '[password]').readOnly = !tog;
		}
	}
	document.getElementById('new_ftp_but').disabled = !tog;
}

// Add the form fields needs for a new FTP server entry. Updates the counter
// and numbers this one as the next one in order.
function add_new_ftp() {
	num = parseInt(document.getElementById('ftp_count').value) + 1;
	document.getElementById('ftp_count').value = num;
	
	ftp_str  = '<div class="ftp_count"><p>' + num + '</p></div>';
	
	ftp_str += '<div class="ftp">';
	
	ftp_str += '<div>';
	ftp_str += '<label for="ftp_' + num + '[host]" class="ftp">Host:</label>';
	ftp_str += '<input type="text" name="ftp_' + num + '[host]" id="ftp_' + num + '[host]" value="" /> : ';
	ftp_str += '<input type="text" name="ftp_' + num + '[port]" id="ftp_' + num + '[port]" value="21" class="short" />';
	ftp_str += '<input type="checkbox" name="ftp_' + num + '[pasv]" id="ftp_' + num + '[pasv]" value="true" class="auto" /> <label for="ftp_' + num + '[pasv]" class="inline"><small>Passive Mode</small></label>';
	ftp_str += '</div>';
	
	ftp_str += '<div>';
	ftp_str += '<label for="ftp_' + num + '[username]" class="ftp">Account:</label>';
	ftp_str += '<input type="text" name="ftp_' + num + '[username]" id="ftp_' + num + '[username]" value="username" /> ';
	ftp_str += '<input type="password" name="ftp_' + num + '[password]" id="ftp_' + num + '[password]" value="password" />';
	ftp_str += '</div>';
	
	ftp_str += '<div>';
	ftp_str += '<label for="ftp_' + num + '_delete" class="ftp">&nbsp;</label>';
	ftp_str += '<small>[<a href="javascript:delete_ftp(' + num + ');">Delete this config</a>]</small>';
	ftp_str += '</div>';
	
	ftp_str += '</div>';
	
	ftp_str += '<hr noshade="noshade" />';
	
	ftpSpan = document.createElement('span');
	ftpSpan.id = 'ftp_' + num;
	ftpSpan.innerHTML = ftp_str;
	
	div = document.getElementById('ftps');
	marker = document.getElementById('new_ftp_marker');
	div.insertBefore(ftpSpan, marker);
}

// Remove the form fields for an FTP server based on a number (used for field names and div id)
function delete_ftp(f) {
	if (confirm('Are you sure you want to delete this FTP server configuration?\nYou cannot undo this.')) {
		document.getElementById('ftp_' + f).innerHTML = '';
	}
}

// Toggles the availability of all the plugin fields in one hit, assuming they
// are all named starting with "plugin_" and nothing else is (or it will get 
// disabled as well)
function toggle_plugins(tog) {
	fields = document.getElementById('config');
	for (i = 0; i < fields.length; i++) {
		if (fields[i].name.match(/^plugin_/i)) {
			fields[i].readOnly = !tog;
		}
	}
	document.getElementById('new_plugin').disabled = !tog;
	document.getElementById('new_plugin_but').disabled = !tog;
}

// Using the dynamically-generated functions towards the bottom of this page, this
// function adds the HTML required for configuring a plugin. Increments the counter
// and names this one according to its position in the numbering
function add_new_plugin() {
	type = document.getElementById('new_plugin').options[document.getElementById('new_plugin').selectedIndex].value;
	num = parseInt(document.getElementById('plugin_count').value) + 1;
	document.getElementById('plugin_count').value = num;
	eval('plugin_fields = plugin_new_' + type + '(' + num + ')');
	ucf_type = type.substring(0, 1).toUpperCase() + type.substring(1, type.length);
	
	plugin_str  = '<div class="plugin_icon"><img src="../plugins/' + type + '/icon.gif" alt="' + ucf_type + '" border="0" /></div>';
	plugin_str += '<div class="plugin">';
	plugin_str += '<div>';
	plugin_str += '<label for="plugin_' + num + '[type]" class="plugin">Type:</label>';
	plugin_str += '<strong>' + ucf_type + '</strong> <small>[<a href="javascript:delete_plugin(' + num + ');">Delete this config</a>]</small>';
	plugin_str += '</div>';
	plugin_str += '<input type="hidden" name="plugin_' + num + '[type]" value="' + type + '" />';
	plugin_str += plugin_fields;
	plugin_str += '</div>';
	plugin_str += '<hr noshade="noshade" />';

	pluginSpan = document.createElement('span');
	pluginSpan.id = 'plugin_' + num;
	pluginSpan.innerHTML = plugin_str;
	
	div = document.getElementById('plugins');
	marker = document.getElementById('new_plugin_marker');
	div.insertBefore(pluginSpan, marker);
}

// Remove the HTML block for a specific plugin definition based on an id number
// With the HTML gone, it will not be processed when the page is submitted, so
// it won't be written to the configuration.php file.
function delete_plugin(p) {
	if (confirm('Are you sure you want to delete this plugin configuration?\nYou cannot undo this.')) {
		document.getElementById('plugin_' + p).innerHTML = '';
	}
}

// "Enable" home directory testing by changing out the current image/whatever for the trigger button
function home_dir_test_enable() {
	document.getElementById('home_dir_action').innerHTML = '<input type="button" name="test_home_dir" value="Test" class="auto" onclick="home_dir_test();" />';
}

// Perform the test on the home dir and update to either a tick or cross depending on results
function home_dir_test() {
	document.getElementById('home_dir_test_frame').src = 'home_dir_test.php?hd=' + escape(document.getElementById('home_dir').value);
}

// Checks that certain fields are entered properly before allowing submission.
function validate_form() {
	good = true;
	conf = document.getElementById('config');
	
	if (conf._username.value == '' || conf._username.value.match(/[^a-z\.\-_0-9]/i)) {
		conf._username.className += ' error';
		good = false;
	}
	else {
		conf._username.className = '';
	}
	
	<?php
	if (!isset($config['password']) || !strlen($config['password'])) {
		echo "if (conf._password1.value == '' || conf._password2.value == '') {\n";
		echo "		conf._password1.className += ' error';\n";
		echo "		conf._password2.className += ' error';\n";
		echo "		good = false;\n";
		echo "	}\n";
		echo "	else {\n";
		echo "		conf._password1.className = '';\n";
		echo "		conf._password2.className = '';\n";
		echo "	}\n";
		echo "\n";
	}
	?>
	
	if (conf.home_dir.value == '') {
		conf.home_dir.className += ' error';
		good = false;
	}
	else {
		conf.home_dir.className = 'long';
	}
	
	if (!good) {
		document.location.href = document.location.href.replace('#', '') + '#';
	}
	
	return good;
}
// -->
</script>
</head>

<body>
<h1>webpad Settings</h1>

<form name="config" id="config" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validate_form();">

<?php
if (strlen($msg)) {
	echo '<div class="section">' . $msg . '</div>';
}
?>

<div class="section">
<h2>Basic Information</h2>

<p><small>Specify a username and password to access webpad from now on (enter password twice for confirmation). Home Directory is the base directory on your server accessible to webpad; use the 'Test' button to ensure webpad can access it correctly. Logout URL is where you will be sent when logging out; leave blank to go nowhere.</small></p>

<div>
<label for="_username"><strong>Username:</strong></label>
<input type="text" name="_username" id="_username" value="<?php echo $config['username']; ?>" />
<small>(alpha-numeric . - _. No spaces)</small>
</div>

<div>
<label for="_password1"><strong>Password:</strong></label>
<input type="password" name="_password1" id="_password1" value="" />
<input type="password" name="_password2" id="_password2" value="" />
<small>(+ confirm)</small>
</div>

<?php
// Use the home dir specified, or guess one based on the location of this file.
// Defaults to the directory that webpad is installed in (with a fix for ugly Win32 paths)
if (strlen($config['home_dir'])) {
	$home_dir = $config['home_dir'];
}
else {
	$home_dir = preg_replace('/^([a-z]:)/is', '', str_replace('\\', '/', dirname(__FILE__)));
	$home_dir = substr($home_dir, 0, strrpos($home_dir, '/')) . '/';
}
?>

<div>
<label for="home_dir"><strong>Home Directory:</strong></label>
<input type="text" name="home_dir" id="home_dir" value="<?php echo $home_dir; ?>" class="long" onkeypress="home_dir_test_enable();" onchange="home_dir_test_enable();" />
<span id="home_dir_action"><input type="button" name="test_home_dir" value="Test" class="auto" onclick="home_dir_test();" /></span>
</div>

<div>
<label for="logout_url">Logout URL:</label>
<input type="text" name="logout_url" id="logout_url" value="<?php echo $config['logout_url']; ?>" class="long" />
<input type="button" name="test_logout_url_but" value="Test" class="auto" onclick="test_logout_url();" />
</div>

</div>

<div class="section">
<h2>webpad Editor Options</h2>

<p><small>webpad templates allow default file templates to be used in New Files. Allow uploads to upload images etc to your server. Word-wrap wraps the text in the main editor; font settings are optional, and only affect the editor window.</small></p>

<div>
<label for="use_templates_true">webpad templates:</label>
<input type="radio" name="use_templates" id="use_templates_true" value="true" class="auto"<?php echo ($config['use_templates'] === true ? ' checked="checked"' : ''); ?> /> <label for="use_templates_true" class="inline"><small>Enabled</small></label> 
<input type="radio" name="use_templates" id="use_templates_false" value="false" class="auto"<?php echo ($config['use_templates'] === false ? ' checked="checked"' : ''); ?> /> <label for="use_templates_false" class="inline"><small>Disabled</small></label>
</div>

<div>
<label for="upload_true">File Uploads:</label>
<input type="radio" name="allow_upload" id="allow_upload_true" value="true" class="auto"<?php echo ($config['allow_upload'] === true ? ' checked="checked"' : ''); ?> /> <label for="allow_upload_true" class="inline"><small>Enabled</small></label> 
<input type="radio" name="allow_upload" id="allow_upload_false" value="false" class="auto"<?php echo ($config['allow_upload'] === false ? ' checked="checked"' : ''); ?> /> <label for="allow_upload_false" class="inline"><small>Disabled</small></label>
</div>

<div>
<label for="editor_wordwrap_true">Word-wrap:</label>
<input type="radio" name="editor_wordwrap" id="editor_wordwrap_true" value="true" class="auto"<?php echo ($config['editor_wordwrap'] === true ? ' checked="checked"' : ''); ?> /> <label for="editor_wordwrap_true" class="inline"><small>Enabled</small></label> 
<input type="radio" name="editor_wordwrap" id="editor_wordwrap_false" value="false" class="auto"<?php echo ($config['editor_wordwrap'] === false ? ' checked="checked"' : ''); ?> /> <label for="editor_wordwrap_false" class="inline"><small>Disabled</small></label>
</div>

<div>
<label for="editor_font_face">Editor Font:</label>
<input type="text" name="editor_font_face" id="editor_font_face" value="<?php echo $config['editor_font_face']; ?>" /><small>, Fixedsys, Andale, Courier, Fixed-width;</small>
</div>

<div>
<label for="editor_font_size">Font Size:</label>
<input type="text" name="editor_font_size" id="editor_font_size" value="<?php echo $config['editor_font_size']; ?>" class="short" /> <small>pt</small>
</div>

</div>

<div class="section">
<h2><input type="checkbox" name="allow_email" id="allow_email" value="true" class="auto" onchange="toggle_email(this.checked);"<?php echo ($config['allow_email'] === true ? ' checked="checked"' : ''); ?> /> <label for="allow_email" class="inline">Enable Email</label></h2>

<p><small>webpad can send documents as an email (with auto-HTML detection). Enable this option above, and set a default name/email address to send from.</small></p>

<?php
$email_disable = ($config['allow_email'] === true ? '': ' readonly="readonly"');

if (preg_match('/^(.*)<([^@]+@[^>]+)>$/iUs', $config['email_from'], $email)) {
	$from_name = trim($email[1]);
	$from_email= trim($email[2]);
}
else {
	$from_name = 'Your Name';
	$from_email= 'Your Email Address';
}
?>
<div>
<label for="email_from_name">Send Email From:</label>
<input type="text" name="email_from_name" id="email_from_name" value="<?php echo $from_name . '"' . $email_disable; ?> />
<input type="text" name="email_from_email" id="email_from_email" value="<?php echo $from_email . '"' . $email_disable; ?> />
</div>

</div>

<div class="section" id="ftps">
<h2><input type="checkbox" name="allow_ftp" id="allow_ftp" value="true" class="auto" onchange="toggle_ftp(this.checked);"<?php echo ($config['allow_ftp'] === true ? ' checked="checked"' : ''); ?> /> <label for="allow_ftp" class="inline">Enable FTP</label></h2>

<p><small>Configure an FTP server to access it directly from within webpad. Host, username and password are required. Port number and Passive Mode will attempt defaults.</small></p>

<hr noshade="noshade" />

<?php
// FTP server counter
$f = 0;

if (sizeof($config['ftp_servers'])) {
	$ftp_disable = ($config['allow_ftp'] === true ? '': ' readonly="readonly"');
	foreach ($config['ftp_servers'] as $f=>$server) {
		echo '<span id="ftp_' . $f . '">';
		echo '<div class="ftp_count"><p>' . ($f + 1) . '</p></div>';
		
		echo '<div class="ftp">';
		
		echo '<div>';
		echo '<label for="ftp_' . $f . '[host]" class="ftp">Host:</label>';
		echo '<input type="text" name="ftp_' . $f . '[host]" id="ftp_' . $f . '[host]" value="' . $server['host'] . '"' . $ftp_disable . ' /> : ';
		echo '<input type="text" name="ftp_' . $f . '[port]" id="ftp_' . $f . '[port]" value="' . $server['port'] . '" class="short"' . $ftp_disable . ' />';
		echo '<input type="checkbox" name="ftp_' . $f . '[pasv]" id="ftp_' . $f . '[pasv]" value="true" class="auto"' . ($server['pasv'] === true ? ' checked="checked"' : '') . $ftp_disable . ' /> <label for="ftp_' . $f . '[pasv]" class="inline"><small>Passive Mode</small></label>';
		echo '</div>';
		
		echo '<div>';
		echo '<label for="ftp_' . $f . '[username]" class="ftp">Account:</label>';
		echo '<input type="text" name="ftp_' . $f . '[username]" id="ftp_' . $f . '[username]" value="' . $server['username'] . '"' . $ftp_disable . ' /> ';
		echo '<input type="password" name="ftp_' . $f . '[password]" id="ftp_' . $f . '[password]" value="' . $server['password'] . '"' . $ftp_disable . ' />';
		echo '</div>';
		
		echo '<div>';
		echo '<label for="ftp_' . $f . '_delete" class="ftp">&nbsp;</label>';
		echo '<small>[<a href="javascript:delete_ftp(' . $f . ');">Delete this config</a>]</small>';
		echo '</div>';
		
		echo '</div>';
		
		echo '<hr noshade="noshade" />';
		echo '</span>';
	}
	$f++;
}

echo '<input type="hidden" name="ftp_count" id="ftp_count" value="' . $f . '" />';
echo '<p align="center" id="new_ftp_marker"><strong>Add New FTP Server:</strong> <input type="button" name="new_ftp_but" id="new_ftp_but" value="Add" class="auto" onclick="javascript:add_new_ftp();"' . ($config['allow_ftp'] === true ? '' : ' disabled="true"') . ' /></p>';
?>

</div>

<div class="section" id="plugins">
<h2><input type="checkbox" name="allow_plugins" id="allow_plugins" value="true" class="auto" onchange="toggle_plugins(this.checked);"<?php echo ($config['allow_plugins'] === true ? ' checked="checked"' : ''); ?> /> <label for="allow_plugins" class="inline">Enable Plugins</label></h2>

<p><small>Plugins allow you to access other online data sources. Add and configure installed plugins below.</small></p>

<hr noshade="noshade" />

<?php
// Plugin counter
$p = 0;

// Output existing plugin configurations straight up
if (sizeof($config['plugins'])) {
	foreach ($config['plugins'] as $p=>$plugin) {
		// Abort this plugin if no type available
		if (!isset($plugin['type'])) {
			continue;
		}
		
		// Include the code for this plugin if available and required
		if (is_file('../plugins/' . $plugin['type'] . '/code.php')) {
			include_once('../plugins/' . $plugin['type'] . '/code.php');
		}
		else {
			continue;
		}
		
		// Get the field details
		$fields = false;
		eval('$fields = ' . $plugin['type'] . '_get_fields();');
		
		// Output the plugin settings block
		echo '<span id="plugin_' . $p . '">';
		echo '<div class="plugin_icon"><img src="../plugins/' . $plugin['type'] . '/icon.gif" alt="' . ucfirst($plugin['type']) . '" border="0" /></div>';
		echo '<div class="plugin">';

		echo '<div>';
		echo '<label for="plugin_' . $p . '[type]" class="plugin">Type:</label>';
		echo '<strong>' . ucfirst($plugin['type']) . '</strong> <small>[<a href="javascript:delete_plugin(' . $p . ');">Delete this config</a>]</small>';
		echo '</div>';
		
		echo '<input type="hidden" name="plugin_' . $p . '[type]" value="' . $plugin['type'] . '" />';
		
		foreach ($fields as $field) {
			echo '<div>';
			echo '<label for="plugin_' . $p . '[' . $field['name'] . ']" class="plugin">' . ucfirst($field['name']) . ':</label>';
			echo plugin_html_field($p, $field['name'], $plugin[$field['name']], $field['type'], $field['options']);
			echo '</div>';
		}
		
		echo '</div>';
		echo '<hr noshade="noshade" />';
		echo '</span>';
	}
}

echo '<input type="hidden" name="plugin_count" id="plugin_count" value="' . $p . '" />';

// Build out javascript details for adding a new plugin...
if (!function_exists('read_dir_to_array')) {
	include_once('../locations/common.php');
}
$plugins = read_dir_to_array('../plugins/');

if (is_array($plugins) && sizeof($plugins)) {
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	echo "<!--\n";
	foreach ($plugins as $plugin) {
		if (substr($plugin, 0, 1) != '_' && is_dir('../plugins/' . $plugin)) {
			// Include the code for this plugin if available and required
			if (is_file('../plugins/' . $plugin . '/code.php')) {
				include_once('../plugins/' . $plugin . '/code.php');
			}
			else {
				continue;
			}
			
			// Get the field details
			$fields = false;
			eval('$fields = ' . $plugin . '_get_fields();');
			
			$js_str = '';
			foreach ($fields as $field) {
				$js_str .= '<div>';
				$js_str .= '<label for=\"plugin_" + p + "[' . $field['name'] . ']\" class=\"plugin\">' . ucfirst($field['name']) . ':</label>';
				$js_str .= str_replace('##p##', '" + p + "', addslashes(plugin_html_field('##p##', $field['name'], '', $field['type'], $field['options'])));
				$js_str .= '</div>';
				
			}
			echo 'function plugin_new_' . $plugin . "(p) {\n";
			echo "	return \"$js_str\";\n";
			echo "}\n\n";
		}
	}
	echo "// -->\n";
	echo "</script>\n";
	
	echo '<p align="center" id="new_plugin_marker"><strong>Add New Plugin:</strong> ' . plugin_available_select() . ' <input type="button" name="new_plugin_but" id="new_plugin_but" value="Add" class="auto" onclick="add_new_plugin();"' . ($config['allow_plugins'] === true ? '' : ' disabled="true"') . ' /></p>';
	
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	echo "<!--\n";
	echo "// Update the disabled status of plugin fields\n";
	echo "toggle_plugins(document.getElementById('allow_plugins').checked);\n";
	echo "// -->\n";
	echo "</script>\n";
}
?>
</div>

<div class="submit">
<input type="submit" name="save" value="Save Settings" />
<small><a href="../">Back to webpad</a></small>
</div>

<iframe src="" name="home_dir_test_frame" id="home_dir_test_frame" border="0" height="0" width="0" style="border: 0; margin: 0; padding: 0;"></iframe>
<input type="hidden" name="_save" value="true" />
</form>
</body>
</html>