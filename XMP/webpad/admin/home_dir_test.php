<?php
if (strlen($_GET['hd'])) {
	$home = urldecode($_GET['hd']);
	if (substr($home, -1) == '/') {
		if (is_dir($home)) {
			if (is_readable($home)) {
				if (is_writable($home)) {
					// All good
					$icon = 'tick.gif';
					$msg = 'Home directory appears valid.';
				}
				else {
					// Can't write to directory
					$icon = 'delete-w.gif';
					$msg = 'This directory is not writable, so you will not be able to save files to it.';
				}
			}
			else {
				// Can't read directory contents
				$icon = 'delete-w.gif';
				$msg = 'Cannot read the contents of this directory. Adjust the permissions on your server to allow read and write access.';
			}
		}
		else {
			// Directory doesn't exist
			$icon = 'delete-w.gif';
			$msg = 'That directory doesn\'t appear to exist, or you have entered it incorrectly.';
		}
	}
	else {
		// Doesn't end in a slash
		$icon = 'delete-w.gif';
		$msg = 'The home directory should end in a forward-slash.';
	}
	
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	echo "<!--\n";
	echo "parent.document.getElementById('home_dir_action').innerHTML = '<img src=\"../images/" . $icon . "\" alt=\"" . addslashes($msg) . "\" title=\"" . addslashes($msg) . "\" border=\"0\" align=\"absmiddle\" width=\"22\" height=\"22\" />';\n";
	echo "// -->\n";
	echo "</script>\n";
}
?>