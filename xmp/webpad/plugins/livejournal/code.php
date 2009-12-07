<?php
include_once(dirname(__FILE__) . '/../_blogging/blog_configuration.php');
include_once(dirname(__FILE__) . '/../_blogging/class.mtclient.php');
include_once(dirname(__FILE__) . '/../_blogging/mt_blogs.php');

/**
 * @return Boolean
 * @param Array $plugin
 * @desc Validates the configuration of this plugin
 */
function livejournal_validate_plugin($plugin) {
	if (sizeof($plugin) != 3) {
		return false;
	}
	if (!isset($plugin['type']) || $plugin['type'] != 'livejournal') {
		return false;
	}
	if (!isset($plugin['username']) || !preg_match('/^.{3,}$/i', $plugin['username'])) {
		return false;
	}
	if (!isset($plugin['password']) || !preg_match('/^.{3,}$/i', $plugin['password'])) {
		return false;
	}
	
	return true;
}

/**
 * @return Array
 * @desc Returns an array specifying the fields required to configure this plugin.
 */
function livejournal_get_fields() {
	$fields = array();
	
	$fields[] = array('name'=>'username', 'type'=>'text', 'options'=>false);
	$fields[] = array('name'=>'password', 'type'=>'password', 'options'=>false);
	
	return $fields;
}

/**
 * @return String
 * @param Array $plugin
 * @desc Returns an appropriate title for a LiveJournal account, based on the contents of the plugin array passed to it.
 */
function livejournal_get_title($plugin) {
	return 'LiveJournal Account (' . $plugin['username'] . ')';
}

/**
 * @return void
 * @param Array $plugin
 * @param Int $id
 * @desc Produces a listing of blogs available in this account, based on the array passed to it (uses Blogger API)
 */
function livejournal_listing($plugin, $id) {
	global $config, $livejournal_host, $livejournal_path;
	return mt_listing($id, $config['plugins_label'], $plugin['username'], $plugin['password'], $livejournal_host, $livejournal_path, 'livejournal');
}

/**
 * @return String
 * @desc Opens a LJ entry based on session variables. Returns the title and content concatenated together for editing
 */
function livejournal_open() {
	global $config, $livejournal_host, $livejournal_path;
	$plugin = $config['plugins'][$_SESSION['plugin']];
	return mt_open($plugin['username'], $plugin['password'], $livejournal_host, $livejournal_path, 'livejournal');
}

/**
 * @return String
 * @desc Saves a LJ entry to the LJ server using the Blogger API
 */
function livejournal_save($name, $str) {
	global $config, $javascript_msg, $livejournal_host, $livejournal_path;
	$plugin = $config['plugins'][$_SESSION['plugin']];
	return mt_save($str, $plugin['username'], $plugin['password'], $livejournal_host, $livejournal_path, 'livejournal');
}

?>