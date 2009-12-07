<?php
require_once('../admin/configuration.php');
require_once('../admin/authentication.php');
require_once('../locations/common.php');

// Blunt deny if config doesn't allow emailing
if ($config['allow_email'] != true) {
	exit;
}

// Process a submitted email request
if (isset($_POST['email_from']) && isset($_POST['email_to'])) {
	$_SESSION['email_from']    = $_POST['email_from'];
	$_SESSION['email_to']      = $_POST['email_to'];
	$_SESSION['email_subject'] = $_POST['subject'];
	$_SESSION['operation']     = 'email';
	
	// Close this window and reload webpad
	reload_webpad_and_close();
}
?>
<html>
<head>
<title>Send File As Email</title>
<link rel="stylesheet" href="../css/dialog.css" type="text/css" />
<script language="JavaScript" type="text/javascript">
<!--
function verify_email_process() {
	// Make sure they entered a from/to value
	if (document.email.email_from.value == '' || document.email.email_to.value == '') {
		alert("You must enter at least one email address in the 'To:' field\nand an email address in the 'From:' field to send this message.");
		return false;
	}
    
	// If it looks like there are multiple email addresses, then verify them all
	if (document.email.email_to.value.indexOf(',')) {
		fixed_emails = Array();
		
		emails = document.email.email_to.value.split(',');
		for (e = 0; e < emails.length; e++) {
			re = / /gi;
			emails[e] = emails[e].replace(re, '');
			if (emails[e] != "") {
				fixed_emails[fixed_emails.length] = emails[e];
			}
		}
	}
	else {
		emails = Array();
		emails[0] = document.email.email_to.value;
	}
	
	clean_emails = "";
	
	for (e = 0; e < fixed_emails.length; e++) {
		if (!validate_email_address(fixed_emails[e])) {
			return false;
		}
		clean_emails = clean_emails + fixed_emails[e] + ', ';
	}

	// Update the email list with the clean one and allow submission.
	document.email.email_to.value = clean_emails;
	return true;
}


function validate_email_address(email) {
	re = /^[a-z\d\.\-]+@[a-z\d\.\-]{2,}$/i;
	if (email.match(re)) {
		return true;
	}
	else {
		alert('You entered an invalid email address.');
		return false;
	}
}
// -->
</script>
</head>

<body onload="this.focus(); document.email.<?php echo ($config['email_from'] == '' ? 'email_from' : 'email_to'); ?>.focus();" onkeypress="if (event.keyCode==27) { window.close(); }">

<h1>Send File As Email</h1>

<form name="email" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return verify_email_process();">

<table cellpadding="3" cellspacing="0" border="0" width="100%">

<tr>
<td><label for="from">From:</label></td>
<td><?php
// If email details are in the config, then default to that
echo "<input type=\"text\" name=\"email_from\" id=\"from\" size=\"45\" value=\"" . (strlen($config['email_from']) ? $config['email_from'] : '') . "\" />";
?></td>
</tr>

<tr>
<td><label for="to">To:</label></td>
<td><input type="text" name="email_to" id="to" size="45" value="" /></td>
</tr>

<tr>
<td><label for="subject">Subject:</label></td>
<td><input type="text" name="subject" id="subject" size="45" value="[no subject]" /></td>
</tr>

<tr>
<td colspan="2" align="center" class="small">Separate multiple email addresses with a comma.</td>
</tr>

<tr>
<td align="center" colspan="3">
<input type="submit" name="submit" value="  Send  " />
<input type="button" name="cancel" value="Cancel" onclick="self.close();" />
</td>
</tr>

</table>

</form>
</body>
</html>