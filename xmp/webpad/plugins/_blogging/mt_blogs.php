<?php

/**
 * @return void
 * @param String $id
 * @param String $label
 * @param String $username
 * @param String $password
 * @param String $host
 * @param String $path
 * @param String $type
 * @desc Creates a listing of available blogs for this account after connecting and downloading.
*/
function mt_listing($id, $label, $username, $password, $host, $path, $type) {
	$listing = '';
	
	if ($type == 'livejournal') {
		$mt = new bloggerclient($username, $password, $host, $path);
	}
	else {
		$mt = new mtclient($username, $password, $host, $path);
	}
	
	if (!is_object($mt)) {
		$listing .= '<p>Could not initiate blog details.</p>';
		return $listing;
	}
	
	// Get available blogs for listing
	$blogs = $mt->getUsersBlogs();
	if (is_array($blogs) && sizeof($blogs[0])) {
		if (sizeof($blogs) == 1) {
			header('Location: ../plugins/_blogging/mt_list_entries.php?p=' . $id . '&b=0&t=' . $type);
			exit;
		}
		
		$listing .= "<a href=\"select_plugin.php?clear=true\" title=\"" . $label . "\"><img src=\"../images/files_up.gif\" width=\"19\" height=\"18\" alt=\"\" border=\"0\" align=\"absmiddle\" /> " . $label . "</a>\n";
		
		foreach ($blogs as $bid=>$blog) {
			$listing .= "<a href=\"../plugins/_blogging/mt_list_entries.php?p=" . $id . "&b=" . $bid . "&t=" . $type . "\" id=\"blog" . $blog['blogid'] . "\" title=\"" . $blog['blogName'] . "\"><img src=\"../plugins/" . $type . "/icon.gif\" width=\"19\" height=\"18\" border=\"0\" align=\"absmiddle\" /> " . $blog['blogName'] . "</a>\n";
		}
	}
	else {
		$listing .= '<p>No available blogs were found for this account.</p>';
	}
	
	return $listing;
}

/**
 * @return String
 * @param String $username
 * @param String $password
 * @param String $host
 * @param String $path
 * @param String $type
 * @desc Connects, downloads the entry specified in the session, and returns it (title and content)
*/
function mt_open($username, $password, $host, $path, $type) {
	if ($type == 'livejournal') {
		$mt = new bloggerclient($username, $password, $host, $path);
	}
	else {
		$mt = new mtclient($username, $password, $host, $path);
	}
	
	// Get the post id from the plugin identifier
	$at = strpos($_SESSION['plugin_identifier'], '@');
	$entry_id = urldecode(substr($_SESSION['plugin_identifier'], 1, $at - 1));
	$feed_id = urldecode(substr($_SESSION['plugin_identifier'], $at + 1, -1));
	$post = $mt->getPost($entry_id);

	$title = $post['title'];
	if ($title == '') {
		preg_match('/^<title>(.*)<\/title>/sUi', $post['content'], $title);
		$post = trim($title[1]) . "\n" . trim(preg_replace('/^<title>(.*)<\/title>/sUi', '', $post['content']));
	}
	else {
		$post = trim($title) . "\n" . trim($post['description']);
	}
	
	// Return the post, re-configured to suit webpad's display method
	return $post;
}

/**
 * @return String
 * @param String $str
 * @param String $username
 * @param String $password
 * @param String $host
 * @param String $path
 * @param String $type
 * @desc Saves the string passed in according to the details in the session.
*/
function mt_save($str, $user, $pass, $host, $path, $type) {
	global $javascript_msg;
	
	// Split up the post to get the title and content separately
	$div = strpos($str, "\n");
	$title = trim(substr($str, 0, $div));
	$content = substr($str, $div + 1);
	
	// Construct the new post and update session details
	$the_post = '<title>' . $title . "</title>\n" . $content;
	$_SESSION['filename'] = $title;
	$_SESSION['display_filename'] = $title;
	
	// Break down the identifier details into its parts
	if (preg_match('/^\[[^@]*@[^\]]*\]$/Ui', $_SESSION['plugin_identifier'])) {
		$at = strpos($_SESSION['plugin_identifier'], '@');
		$entry_id = urldecode(substr($_SESSION['plugin_identifier'], 1, $at - 1));
		if (trim($entry_id) == '') {
			$entry_id = false;
		}
		$feed_id = urldecode(substr($_SESSION['plugin_identifier'], $at + 1, -1));
	}
	else {
		// Couldn't figure out where to save to
		$javascript_msg = '@Couldn\'t locate the blog to save this post to.';
		return $_SESSION['filename'];
	}
	
	if ($type == 'livejournal') {
		$mt = new bloggerclient($user, $pass, $host, $path);
	}
	else {
		$mt = new mtclient($user, $pass, $host, $path);
	}

	// Updating an existing post (editPost)
	if ($entry_id !== false) {
		if ($type == 'livejournal') {
			$done = $mt->editPost($entry_id, $the_post, true);
		}
		else {
			$done = $mt->editPost($entry_id, $content, $title, true);
		}
		
		if ($done) {
			$javascript_msg = 'Entry updated successfully.';
		}
		else {
			$javascript_msg = '@Couldn\'t update your entry.';
		}
		return $_SESSION['filename'];
	}
	// Otherwise we'll create a new post (newPost) entirely and send it along
	else {
		if ($type == 'livejournal') {
			$done = $mt->newPost($feed_id, $the_post, true);
		}
		else {
			$done = $mt->newPost($feed_id, $content, $title, true);
		}
		
		if ($done) {
			$_SESSION['plugin_identifier'] = '[' . urlencode($done) . '@' . urlencode($feed_id) . ']';
			$javascript_msg = 'New entry posted successfully.';
		}
		else {
			$javascript_msg = '@Couldn\'t post your entry to your blog.';
		}
		return $_SESSION['filename'];
	}
}

?>