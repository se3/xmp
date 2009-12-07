<?php
include_once(dirname(__FILE__) . '/../_blogging/blog_configuration.php');
include_once(dirname(__FILE__) . '/../_blogging/class.atomapi.php');
include_once(dirname(__FILE__) . '/../_blogging/atom_blogs.php');

/**
 * @return Boolean
 * @param Array $plugin
 * @desc Validates the configuration of this plugin
 */
function typepad_validate_plugin($plugin) {
	return atom_validate_plugin($plugin);
}

/**
 * @return Array
 * @desc Returns an array specifying the fields required to configure this plugin.
 */
function typepad_get_fields() {
	$fields = array();
	
	$fields[] = array('name'=>'username', 'type'=>'text', 'options'=>false);
	$fields[] = array('name'=>'password', 'type'=>'password', 'options'=>false);
	
	return $fields;
}

/**
 * @return String
 * @param Array $plugin
 * @desc Returns an appropriate title for a TypePad account, based on the contents of the plugin array passed to it.
 */
function typepad_get_title($plugin) {
	return 'TypePad Account (' . $plugin['username'] . ')';
}

/**
 * @return void
 * @param Array $plugin
 * @param Int $id
 * @desc Produces a listing of blogs available in this account, based on the array passed to it (uses Atom)
 */
function typepad_listing($plugin, $id) {
	global $config, $typepad_endpoint, $typepad_auth;
	return atom_listing($typepad_endpoint, $plugin['username'], $plugin['password'], $typepad_auth, $config['plugins_label'], 'typepad', $id);
}

/**
 * @return String
 * @desc Opens a TypePad entry based on session variables. Returns the title and content concatenated together for editing
 */
function typepad_open() {
	return atom_open();
}

/**
 * @return String
 * @desc Saves a TypePad entry to the TypePad server
 */
function typepad_save($name, $str) {
	return atom_save($str);
}

?>