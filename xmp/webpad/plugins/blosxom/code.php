<?php
require_once(dirname(__FILE__) . '/../../locations/server.php');
require_once(dirname(__FILE__) . '/../../locations/common.php');

/**
 * @return Boolean
 * @param Array $plugin
 * @desc Validates the configuration of this plugin
 */
function blosxom_validate_plugin($plugin) {
	if (sizeof($plugin) != 3) {
		return false;
	}
	if (!isset($plugin['type']) || $plugin['type'] != 'blosxom') {
		return false;
	}
	if (!isset($plugin['label']) || !strlen($plugin['label'])) {
		return false;
	}
	if (!isset($plugin['datadir']) || !is_dir($plugin['datadir'])) {
		return false;
	}
	
	return true;
}

/**
 * @return Array
 * @desc Returns an array specifying the fields required to configure this plugin.
 */
function blosxom_get_fields() {
	$fields = array();
	
	$fields[] = array('name'=>'label', 'type'=>'text', 'options'=>false);
	$fields[] = array('name'=>'datadir', 'type'=>'text', 'options'=>false);
	
	return $fields;
}

/**
 * @return String
 * @param Array $plugin
 * @desc Returns a user-friendly title for this plugin for display in the plugin listing
 */
function blosxom_get_title($plugin) {
	return 'blosxom Blog (' . $plugin['label'] . ')';
}

function blosxom_listing($plugin, $id) {
	global $config;
	
	$listing = '';
	
	// Pull in a posted value and store it in the session.
	if (isset($_POST['plugin_blosxom_pwd']) && $_POST['plugin_blosxom_pwd'] != '') {
		$_SESSION['plugin_blosxom_pwd'] = $_POST['plugin_blosxom_pwd'];
		$dir = $_SESSION['plugin_blosxom_pwd'];
	}
	else if (isset($_SESSION['plugin_blosxom_pwd']) && stristr(str_replace('../', '', $_SESSION['plugin_blosxom_pwd']), $plugin['datadir'])) {
		$dir = $_SESSION['plugin_blosxom_pwd'];
	}
	else {
		$dir = $plugin['datadir'];
	}
	
	// Handle request to delete an entry
	if (isset($_POST['delete_entry']) && strlen($_POST['delete_entry'])) {
		$del = $dir . $_POST['delete_entry'];
		if (is_file($del)) {
			if (!@unlink($del)) {
				$listing .= "<script language=\"JavaScript\" type=\"text/javascript\">\n";
				$listing .= "<!--\n";
				$listing .= "alert('Can\'t delete that post - you might not have permission to do so.');\n";
				$listing .= "// -->\n";
				$listing .= "</script>\n";
			}
		}
	}

	// Include our plugin and  blosxom scripts
	$listing .= '<script language="JavaScript" type="text/javascript" src="../js/tools.js"></script>';
	$listing .= '<script language="JavaScript" type="text/javascript" src="../js/plugins.js"></script>';
	$listing .= '<script language="JavaScript" type="text/javascript" src="../plugins/blosxom/blosxom.js"></script>';
	
	// If we're not at the home dir, then supply a link back up one
	if ($dir != $plugin['datadir'] && substr($dir, 0, -1) != $plugin['datadir']) {
		$listing .= "<a href=\"javascript:cdup('" . $dir . "');\" title=\"Parent Directory\"><img src=\"../images/files_up.gif\" width=\"19\" height=\"18\" alt=\"\" border=\"0\" align=\"absmiddle\" /> Parent Directory</a>\n";
	}
	else {
		$listing .= "<a href=\"select_plugin.php?clear=true\" title=\"" . $config['plugins_label'] . "\"><img src=\"../images/files_up.gif\" width=\"19\" height=\"18\" alt=\"\" border=\"0\" align=\"absmiddle\" /> " . $config['plugins_label'] . "</a>\n";
	}

	// Get all entries in this dir to an array
	$files = read_dir_to_array($dir);
	
	// Now if we have some entries, check them all and build the file listing
	if ($files !== false) {
		$file_list = array();
		foreach($files as $file) {
			if (is_dir(addslashes($dir . $file))) {
				if (is_readable($dir . '/' . $file) && is_writable($dir . '/' . $file)) {
					$listing .= "<a href=\"javascript:cd('" . urlencode($file) . urlencode("/") . "');\" id=\"" . $file . "_\" title=\"" . $file . "\"><img src=\"../images/files_dir.gif\" width=\"19\" height=\"18\" border=\"0\" align=\"absmiddle\" /> " . $file . "</a>\n";
				}
				else {
					$listing .= "<div class=\"disabled\"><img src=\"../images/files_dir_locked.gif\" width=\"19\" height=\"18\" alt=\"Access Denied\" border=\"0\" align=\"absmiddle\" /> " . $file . "</div>\n";
				}
			}
			else {
				// Add to listing of files in this dir.
				$file_list[] = $file;
				if (!in_array(substr($file, strrpos($file, '.') + 1), $config['restrict_files'])) {
					$listing .= "<a href=\"javascript:select('" . $file . "');\" ondblclick=\"select('" . $file . "'); if (confirm_open()) {parent.document.file.submit();}\" id=\"" . $file . "\" title=\"" . $file . "\"><img src=\"../images/files_file.gif\" width=\"19\" height=\"18\" border=\"0\" align=\"absmiddle\" /> " . $file . "</a>\n";
				}
				else {
					$listing .= "<div class=\"disabled\"><img src=\"../images/files_file.gif\" width=\"19\" height=\"18\" title=\"File format restricted\" border=\"0\" align=\"absmiddle\" /> " . $file . "</div>\n";
				}
			}
		}
		$listing .= "<form name=\"blosxom\" action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
		$listing .= "<input type=\"hidden\" name=\"p\" value=\"" . $id . "\" />\n";
		$listing .= "<input type=\"hidden\" name=\"selected_element\" value=\"\" />\n";
		$listing .= "<input type=\"hidden\" name=\"entry\" value=\"\" />\n";
		$listing .= "<input type=\"hidden\" name=\"delete_entry\" value=\"\" />\n";
		$listing .= "<input type=\"hidden\" name=\"plugin_blosxom_pwd\" value=\"" . $dir . "\" />\n";
		$listing .= "</form>\n";
		$listing .= "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		$listing .= "<!--\n";
		$listing .= "if (parent.parent.frames.saveas_locations) {\n";
		$listing .= "	parent.document.file.filename.value = get_title();\n";
		$listing .= "}\n";
		$listing .= "parent.document.file.identifier.value = '" . addslashes($dir) . "';\n";
		$listing .= "add_plugin_tool('../images/delete.gif', 'javascript:files_iframe.delete_entry();', 'Delete Selected Entry', 1);\n";
		$listing .= "// -->\n";
		$listing .= "</script>\n";
	}
	else {
		$listing .= "<p>Could not access directory '" . $dir . "'.</p>";
	}
	
	return $listing;
}

/**
 * @return String
 * @desc Gets the contents of the selected post and returns it as a string.
 */
function blosxom_open() {
	return parse_file($_SESSION['plugin_identifier']);
}

/**
 * @return String
 * @desc Saves the blosxom post to file and returns the new filename.
 */
function blosxom_save($file, $str) {
	global $config, $javascript_msg;
	
	if (stristr($_SESSION['plugin_blosxom_pwd'], $config['plugins'][$_SESSION['plugin']]['datadir']) !== false) {
		save_to_server($_SESSION['plugin_blosxom_pwd'] . $_SESSION['filename'], $str);
		$javascript_msg = 'blosxom post saved successfully.';
		return $file;
	}
	else {
		$javascript_msg = '@Couldn\'t save your post because it was outside your blog\'s data directory.';
		return $file;
	}
}

?>