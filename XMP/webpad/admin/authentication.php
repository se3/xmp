<?php
// Create a session for this user
session_name('webpad');
session_start();

// If authentication details are posted to this page, register
// them into the session and then apply security checks.
if (isset($_POST['username']) && isset($_POST['password'])) {
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
}


// Check for the existance of a password, and that it matches the access password hash
if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || $_SESSION['password'] != $config['password']) {
	// Keep track of how many attempts this user has made
	if (!session_is_registered('auth_attempts')) {
		$_SESSION['auth_attempts'] = 1;
	}
	else {
		$_SESSION['auth_attempts']++;
	}
	
	// If they have made less than 3 attempts, then give them the chance to log in
	if ($_SESSION['auth_attempts'] <= 3) {
		$msg_title = 'Please Log In';
		$msg_body  = '<p>You must log in to access this copy of webpad. Please enter your username and password below to continue.</p>';
		$msg_body .= '<form method="post" name="auth" action="./">';
		$msg_body .= '<p><label for="username" style="float: left; display: block; width: 140px; text-align: right; line-height: 2em;">Username:</label><input type="text" name="username" id="username" style="margin-left: 20px; width: 200px; margin-bottom: 1em;" /><br />';
		$msg_body .= '<label for="password" style="float: left; display: block; width: 140px; text-align: right; line-height: 2em;">Password:</label><input type="password" name="password" id="password" style="margin-left: 20px; width: 200px;" /></p>';
		$msg_body .= '<div align="center" style="padding-top: 15px;"><input type="submit" value="Log In" /></div></form>';
		$msg_body .= "\n\t<script language=\"JavaScript\" type=\"text/javascript\">\n\t<!--\n\tdocument.auth.username.focus();\n\t// -->\n\t</script>\n";
		include('message.php');
		exit;
	}
	// This gets dumped if they can't validate properly.
	else {
		$msg_type = 'error';
		$msg_title = 'Authentication Failed';
		$msg_body = '<p>This copy of webpad is restricted and you are unable to supply valid authentication details. Please contact the system administrator or check your configuration.</p>';
		$msg_body .= '<p><a href="../">Return to XMP</a>';
		include('message.php');
		exit;
	}
}
else {
	$_SESSION['auth_attempts'] = 0;
}

?>