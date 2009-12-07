<?php
include_once(dirname(__FILE__) . '/../_blogging/blog_configuration.php');
include_once(dirname(__FILE__) . '/../_blogging/class.atomapi.php');
include_once(dirname(__FILE__) . '/../_blogging/atom_blogs.php');

/**
 * @return Boolean
 * @param Array $plugin
 * @desc Validates the configuration of this plugin
 */
function blogger_validate_plugin($plugin) {
	return atom_validate_plugin($plugin);
}

/**
 * @return Array
 * @desc Returns an array specifying the fields required to configure this plugin.
 */
function blogger_get_fields() {
	$fields = array();
	
	$fields[] = array('name'=>'username', 'type'=>'text', 'options'=>false);
	$fields[] = array('name'=>'password', 'type'=>'password', 'options'=>false);
	
	return $fields;
}

/**
 * @return String
 * @param Array $plugin
 * @desc Returns the string title to use to display this Blogger.com account.
 */
function blogger_get_title($plugin) {
	return 'Blogger Account (' . $plugin['username'] . ')';
}

/**
 * @return void
 * @param Array $plugin
 * @param Int $id
 * @desc Produces a listing of blogs available in this account, based on the array passed to it (uses Atom)
 */
function blogger_listing($plugin, $id) {
	global $config, $blogger_endpoint, $blogger_auth;
	return atom_listing($blogger_endpoint, $plugin['username'], $plugin['password'], $blogger_auth, $config['plugins_label'], 'blogger', $id);
}

/**
 * @return String
 * @desc Opens a Blogger entry based on session variables. Returns the title and content concatenated together for editing
 */
function blogger_open() {
	return atom_open();
}

/**
 * @return String
 * @desc Saves a Blogger entry to the Blogger.com server
 */
function blogger_save($name, $str) {
	return atom_save($str);
}

?>