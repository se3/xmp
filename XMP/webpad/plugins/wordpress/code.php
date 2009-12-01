<?php
include_once(dirname(__FILE__) . '/../_blogging/blog_configuration.php');
include_once(dirname(__FILE__) . '/../_blogging/class.mtclient.php');
include_once(dirname(__FILE__) . '/../_blogging/mt_blogs.php');

/**
 * @return Boolean
 * @param Array $plugin
 * @desc Validates the configuration of this plugin
 */
function wordpress_validate_plugin($plugin) {
	if (sizeof($plugin) != 5) {
		return false;
	}
	if (!isset($plugin['type']) || $plugin['type'] != 'wordpress') {
		return false;
	}
	if (!isset($plugin['username']) || !strlen($plugin['username'])) {
		return false;
	}
	if (!isset($plugin['password']) || !strlen($plugin['password'])) {
		return false;
	}
	if (!isset($plugin['host']) || !strlen($plugin['host'])) {
		return false;
	}
	if (!isset($plugin['path']) || !strlen($plugin['path'])) {
		return false;
	}
	
	return true;
}

/**
 * @return Array
 * @desc Returns an array specifying the fields required to configure this plugin.
 */
function wordpress_get_fields() {
	$fields = array();
	
	$fields[] = array('name'=>'username', 'type'=>'text', 'options'=>false);
	$fields[] = array('name'=>'password', 'type'=>'password', 'options'=>false);
	$fields[] = array('name'=>'host', 'type'=>'text', 'options'=>false);
	$fields[] = array('name'=>'path', 'type'=>'text', 'options'=>false);
	
	return $fields;
}

/**
 * @return String
 * @param Array $plugin
 * @desc Returns an appropriate title for a WordPress account, based on the contents of the plugin array passed to it.
 */
function wordpress_get_title($plugin) {
	return 'WordPress Account (' . $plugin['username'] . ')';
}

/**
 * @return void
 * @param Array $plugin
 * @param Int $id
 * @desc Produces a listing of blogs available in this account, based on the array passed to it (uses MetaWeblogAPI)
 */
function wordpress_listing($plugin, $id) {
	global $config;
	return mt_listing($id, $config['plugins_label'], $plugin['username'], $plugin['password'], $plugin['host'], $plugin['path'], 'wordpress');
}

/**
 * @return String
 * @desc Opens a LJ entry based on session variables. Returns the title and content concatenated together for editing
 */
function wordpress_open() {
	global $config;
	$plugin = $config['plugins'][$_SESSION['plugin']];
	return mt_open($plugin['username'], $plugin['password'], $plugin['host'], $plugin['path'], 'wordpress');
}

/**
 * @return String
 * @desc Saves a WordPress entry to the server using the mtclient class
 */
function wordpress_save($name, $str) {
	global $config, $javascript_msg;
	$plugin = $config['plugins'][$_SESSION['plugin']];
	return mt_save($str, $plugin['username'], $plugin['password'], $plugin['host'], $plugin['path'], 'wordpress');
}

?>