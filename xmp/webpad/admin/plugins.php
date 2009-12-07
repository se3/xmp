<?php
/**
 * @return String
 * @param Int $plugin
 * @param String $name
 * @param String $value
 * @param String $type [text|password|textarea|checkbox|radio|select]
 * @param Array $opts
 * @desc Creates the HTML required for a plugin input field. Needs the $plugin for field naming, and other values control the details of the element which is output.
*/
function plugin_html_field($plugin, $name, $value, $type, $opts = false) {
	switch ($type) {
		case 'text' :
			$str = '<input type="text" name="plugin_' . $plugin . '[' . $name . ']" id="plugin_' . $plugin . '[' . $name . ']" value="' . $value . '" class="long" />';
			break;
		case 'password' :
			$str = '<input type="password" name="plugin_' . $plugin . '[' . $name . ']" id="plugin_' . $plugin . '[' . $name . ']" value="' . $value . '" class="long" />';
			break;
		case 'textarea' :
			$str = '<textarea name="plugin_' . $plugin . '[' . $name . ']" id="plugin_' . $plugin . '[' . $name . ']">' . $value . '</textarea>';
			break;
		case 'checkbox' :
			$str = '';
			foreach ($opts as $opt=>$label) {
				$str .= '<input type="checkbox" name="plugin_' . $plugin . '[' . $name . ']" id="plugin_' . $plugin . '[' . $name . ']" value="' . $opt . '" class="auto"' . ($opt == $value ? ' checked="checked"' : '') . ' /> <label for="plugin_' . $plugin . '[' . $name . ']" class="inline"><small>' . $label . '</small></label> ';
			}
			break;
		case 'radio' :
			$str = '';
			foreach ($opts as $opt=>$label) {
				$str .= '<input type="radio" name="plugin_' . $plugin . '[' . $name . ']" id="plugin_' . $plugin . '[' . $name . '][' . $opt . ']" value="' . $opt . '" class="auto"' . ($opt == $value ? ' checked="checked"' : '') . ' /> <label for="plugin_' . $plugin . '[' . $name . '][' . $opt . ']" class="inline"><small>' . $label . '</small></label> ';
			}
			break;
		case 'select' :
			$str = '<select name="plugin_' . $plugin . '[' . $name . ']" id="plugin_' . $plugin . '[' . $name . ']" class="auto">';
			foreach ($opts as $opt=>$label) {
				$str .= '<option value="' . $opt . '"' . ($opt == $value ? ' selected="selected"' : '') . '>' . $label . '</option>';
			}
			$str .= '</select>';
	}
	
	return $str;
}

/**
 * @return String
 * @desc Returns the HTML required for a SELECT box containing all available plugins in the /plugins/ directory.
*/
function plugin_available_select() {
	global $config;
	
	if (!function_exists('read_dir_to_array')) {
		include_once('../locations/common.php');
	}
	$plugins = read_dir_to_array('../plugins/');
	
	if (is_array($plugins) && sizeof($plugins)) {
		$str = '<select name="new_plugin" id="new_plugin"' . ($config['allow_plugins'] === true ? '' : ' disabled="true"') . '>';
		
		foreach ($plugins as $plugin) {
			if (substr($plugin, 0, 1) != '_' && is_dir('../plugins/' . $plugin)) {
				$str .= '<option value="' . $plugin . '">' . ucfirst($plugin) . '</option>';
			}
		}
		$str .= '</select>';
	}
	else {
		$str = false;
	}
	
	return $str;
}
?>