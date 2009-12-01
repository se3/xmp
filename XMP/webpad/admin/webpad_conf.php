<?php
// Always allow server access for Personal Edition
$config['allow_server'] = true;

// Set the names of the icons to use in the file dialogs. The names all 
// get .gif added to them and are assumed to be files available in the 
// ./images/ directory within webpad's installation directory
// 'mycomputer' or your own icon, 36x36, #808080 transparent bg
$config['mycomputer_icon'] = 'mycomputer.gif';
$config['mycomputer_label'] = 'My Computer';

// 'myserver' or your own icon
$config['myserver_icon'] = 'myserver.gif';
$config['myserver_label'] = 'My Server';

// 'ftpserver' or your own icon
$config['ftpserver_icon'] = 'ftpserver.gif';
$config['ftpserver_label'] = 'FTP Server';

// 'plugins' or your own icon
$config['plugins_icon'] = 'plugins.gif';
$config['plugins_label'] = 'My Plugins';

// 'webpage' or your own icon
$config['webpage_icon'] = 'webpage.gif';
$config['webpage_label'] = 'Webpage';

// Types of files to offer for saving to client. They can save with
// any extension, but these types offer 'smart-completion' of filenames.
// If they pick one, and don't add the extension to the filename, it will
// be added for them before they download the file.
$file_types = array();
$file_types['css'] = 'Cascading Style Sheet (*.css)';
$file_types['html'] = 'Hypertext Document (*.html)';
$file_types['js'] = 'JavaScript Source File (*.js)';
$file_types['php'] = 'PHP Script File (*.php)';
$file_types['sql'] = 'SQL Dump File (*.sql)';
$file_types['txt'] = 'Text File (*.txt)';
$file_types['xml'] = 'XML Document (*.xml)';

$file_types['all_files'] = 'All File Types (*.*)';

// This array is used to determine which types of files to allow users 
// to open. You must enter the extension of all file types that you 
// want to restrict (won't be able to open them using webpad)
$config['restrict_files'] = array('jpg', 'gif', 'png', 'doc', 'xls', 
									'pdf', 'tar', 'gz', 'zip', 'ico', 
									'exe', 'swf', 'rar', 'mov', 'wmv');
?>