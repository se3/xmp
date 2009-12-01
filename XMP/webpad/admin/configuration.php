<?php
$config = array();

$config['username'] = 'root';
$config['password'] = 'admin';
$config['home_dir'] = '/';
$config['logout_url'] = '';

$config['allow_upload'] = true;
$config['use_templates'] = true;
$config['editor_wordwrap'] = true;
$config['editor_font_face'] = '';
$config['editor_font_size'] = 10;

$config['allow_email'] = false;
$config['email_from'] = 'Your Name <Your Email Address>';

$config['allow_ftp'] = true;

$config['allow_plugins'] = true;

require_once(dirname(__FILE__) . '/webpad_conf.php');
?>