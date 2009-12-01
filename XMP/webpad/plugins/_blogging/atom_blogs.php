<?php

/**
 * @return Boolean
 * @param Array $plugin
 * @desc Validates the configuration of this plugin
 */
function atom_validate_plugin($plugin) {
	if (!isset($plugin['type']) || !in_array($plugin['type'], array('typepad', 'blogger'))) {
		return false;
	}		
	if (!isset($plugin['username']) || !strlen($plugin['username'])) {
		return false;
	}
	if (!isset($plugin['password']) || !strlen($plugin['password'])) {
		return false;
	}
	return true;
}

function atom_listing($endpoint, $username, $password, $auth, $label, $type, $id) {
	$listing = '';
	
	$ai = new AtomAPI($endpoint, $username, $password, $auth);
	if ($ai->error()) {
		switch ($ai->error()) {
			case 1 :
				$listing .= '<p>The endpoint you supplied appears to be invalid.</p>';
				break;
			case 2 :
				$listing .= '<p>Authentication type must be Basic or WSSE.</p>';
				break;
			case 3 :
				$listing .= '<p>Authentication failed.</p><p>Please check your username/password in your webpad configuration.</p>';
				break;
			case 4 :
				$listing .= '<p>This account does not have access to any blogs.</p>';
		}
	}
	else {
		$feeds = $ai->get_feeds();
		
		if (is_array($feeds)) {
			if (sizeof($feeds) == 1) {
				header('Location: ../plugins/_blogging/atom_list_entries.php?p=' . $id . "&f=" . urlencode($feeds[0]['service.feed']));
				exit;
			}
			
			$listing .= "<a href=\"select_plugin.php?clear=true\" title=\"" . $label . "\"><img src=\"../images/files_up.gif\" width=\"19\" height=\"18\" alt=\"\" border=\"0\" align=\"absmiddle\" /> " . $label . "</a>\n";
			
			foreach ($feeds as $f=>$feed) {
				$listing .= "<a href=\"../plugins/_blogging/atom_list_entries.php?p=" . $id . "&f=" . urlencode($feed['service.feed']) . "\" id=\"feed" . $f . "\" title=\"" . $feed['title'] . "\"><img src=\"../plugins/" . $type . "/icon.gif\" width=\"19\" height=\"18\" border=\"0\" align=\"absmiddle\" /> " . $feed['title'] . "</a>\n";
			}
		}
		else {
			$listing .= '<p>No available blogs were found for this account.</p>';
		}
	}
	return $listing;
}

function atom_open() {
	global $config, $javascript_msg;
	
	// Create Auth Object
	if ($config['plugins'][$_SESSION['plugin']]['type'] == 'blogger') {
		require_once(dirname(__FILE__) . '/class.basicauth.php');
		$auth = new BasicAuth($config['plugins'][$_SESSION['plugin']]['username'], $config['plugins'][$_SESSION['plugin']]['password']);
	}
	else {
		require_once(dirname(__FILE__) . '/class.wsse.php');
		$auth = new WSSE($config['plugins'][$_SESSION['plugin']]['username'], $config['plugins'][$_SESSION['plugin']]['password']);
	}
	
	// Break down the identifier details into its parts
	$at = strpos($_SESSION['plugin_identifier'], '@');
	$entry_uri = substr($_SESSION['plugin_identifier'], 1, $at - 1);
	$feed_uri = substr($_SESSION['plugin_identifier'], $at + 1, -1);
	
	// Get the feed as specified
	$ar = new AtomRequest('GET', urldecode($entry_uri), $auth);
	$response = $ar->exec();
	
	if ($response == 200) {
		$entry = new AtomEntry();
		$entry->from_xml($ar->get_response());
		
		// Pull out the existing title and content from this object
		$title = $entry->get_title('title');
		$content = $entry->get_content('content');
		
		// Strip out the default namespace tags
		$content = preg_replace(array('/^\s*<div xmlns="http:\/\/www.w3.org\/1999\/xhtml">/s', '/<\/div>\s*$/s'), '', trim($content));
		
		return html_entity_decode($title) . "\n" . trim($content);
	}
	else {
		$javascript_msg = '@Couldn\'t open your blog post.';
		return false;
	}
}

function atom_save($document) {
	global $config, $javascript_msg;
	
	// Split up the post to get the title and content separately
	$div = strpos($document, "\n");
	$title = trim(substr($document, 0, $div));
	$content = substr($document, $div + 1);
	
	// Prep these elements for use in the Atom objects later
	$title = array('title'=>htmlspecialchars($title), 'mode'=>'escaped', 'type'=>'text/html');
	$content = array('content'=>htmlspecialchars($content), 'mode'=>'escaped', 'type'=>'text/html');
	
	// Create Auth Object
	if ($config['plugins'][$_SESSION['plugin']]['type'] == 'blogger') {
		require_once(dirname(__FILE__) . '/class.basicauth.php');
		$auth = new BasicAuth($config['plugins'][$_SESSION['plugin']]['username'], $config['plugins'][$_SESSION['plugin']]['password']);
	}
	else {
		require_once(dirname(__FILE__) . '/class.wsse.php');
		$auth = new WSSE($config['plugins'][$_SESSION['plugin']]['username'], $config['plugins'][$_SESSION['plugin']]['password']);
	}
	
	// Break down the identifier details into its parts
	if (preg_match('/^\[(https?)?.*@https?.*\]$/Ui', $_SESSION['plugin_identifier'])) {
		$at = strpos($_SESSION['plugin_identifier'], '@');
		$entry_uri = substr($_SESSION['plugin_identifier'], 1, $at - 1);
		if (trim($entry_uri) == '') {
			$entry_uri = false;
		}
		$feed_uri = substr($_SESSION['plugin_identifier'], $at + 1, -1);
	}
	else {
		// Couldn't figure out where to save to
		$javascript_msg = '@Couldn\'t locate the blog to save this post to.';
		return $_SESSION['filename'];
	}
	
	// If we're updating an existing one, we need some details
	if ($entry_uri !== false) {
		// Create the new entry and get it as XML
		$ae = new AtomEntry($title, $content);
		$ae = $ae->to_xml('PUT');
		
		$ar = new AtomRequest('PUT', urldecode($entry_uri), $auth, $ae);
		$response = $ar->exec();
		
		if ($response == 200) {
			$javascript_msg = 'Post saved successfully.';
			return;
		}
		else {
			$javascript_msg = '@Saving your post failed, please try again. (' . $ar->get_response() . ')';
			return;
		}
	}
	// Otherwise we can construct an AtomEntry and post it to the PostURI
	else {
		// Make the entry, and get it in XML (for POSTing)
		$ae = new AtomEntry($title, $content);
		$ae = $ae->to_xml('POST');
		
		$ar = new AtomRequest('POST', urldecode($feed_uri), $auth, $ae);
		$response = $ar->exec();
		
		if ($response == 200 || $response == 201) {
			// Need to get the EditURI for this new post now
			$ae = new AtomEntry();
			$ae->from_xml($ar->get_response());
			$link = $ae->get_links('rel', 'service.edit');
			
			$javascript_msg = 'Post saved successfully.';
			$_SESSION['plugin_identifier'] = '[' . urlencode($link[0]['href']) . '@' . $feed_uri . ']';
			return;
		}
		else {
			$javascript_msg = '@Saving your post failed, please try again. (' . $ar->get_response() . ')';
			return;
		}
	}
}

?>