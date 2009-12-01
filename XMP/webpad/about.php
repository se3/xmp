<?php
@include_once('admin/configuration.php');

$width = '85%';
$msg_title = 'About webpad';
$msg_body = '<p><small>webpad is designed to provide easy access to files on a webserver and in other places around the web. It is intended to be a simple, handy tool with the features that you need every day.</small></p>
			<p><strong>Version:</strong> 3.0 Personal Edition (beta)</p>
			<p><strong>Written By:</strong> <a href="http://www.dentedreality.com.au/" target="_blank">Beau Lebens</a>, &copy; 2005</p>
			<p><strong>Icons By:</strong> <a href="http://www.icon-king.com/" target="_blank">Icon King</a> (mod. Nuvola)</p>
			<p><strong>More Info:</strong> <a href="http://www.dentedreality.com.au/webpad/" target="_blank">webpad website</a></p>
			<p align="center"><input type="button" name="close" value="Close" onclick="window.close();" /></p>';
require_once('admin/message.php');

?>