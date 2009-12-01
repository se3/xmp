<html>
<head>
<title>webpad: <?php echo $msg_title; ?></title>
<style type="text/css">
body {
	text-align: center;
	background: #EEEEEE;
	color: #000000;
	font-family: Tahoma, Arial Narrow, Arial, Verdana, sans-serif;
	font-size: 0.9em;
	margin: 0;
	padding: 1em;
	border: 0;
}

h1 {
	background: #265997;
	color: #FFFFFF;
	font-family: Tahoma, Arial Narrow, Arial, Verdana, sans-serif;
	font-size: 1.5em;
	font-weight: 600;
	padding: 0.3em;
	margin: 0;
	text-align: center;
}

label {
	font-weight: bold;
}

#message {
	background: #FFFFFF;
	position: relative;
<?php echo (!isset($width) ? "\ttop: 5em;\n" : ''); ?>
	width: <?php echo (isset($width) ? $width : '500px'); ?>;
	margin: 0 auto;
	text-align: left;
	border: solid 10px #3A85E1;
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	text-align: left;
	font-size: 0.9em;
	padding: 1em;
	line-height: 1.5em;
}

#message .body {
	padding: .5em;
}

#message a {
	color: #000000;
}
</style>
<script language="JavaScript" type="text/javascript">
<!--
if (document.location.href != top.document.location.href) {
	top.location.href = document.location.href;
}
// -->
</script>
</head>

<body>
<div id="message">
<h1><?php echo $msg_title; ?></h1>
<div class="body"><?php echo $msg_body; ?></div>
</div>
</body>
</html>