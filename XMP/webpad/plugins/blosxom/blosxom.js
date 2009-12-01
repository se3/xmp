// Perform a selection on a file.
// Changes appearance of the selected one and should update a field with the name
function select(element) {
	if (document.blosxom.selected_element.value != '') {
		document.getElementById(document.blosxom.selected_element.value).style.color = '#000000';
		document.getElementById(document.blosxom.selected_element.value).style.background = 'transparent';
	}
	document.getElementById(element).style.color = '#FFFFFF';
	document.getElementById(element).style.background = '#000084';
	document.blosxom.selected_element.value = element;
	
	// Call to update the selection on the parent frame
	update_file_name(element);
	return;
}

// Change current directory on the server
function cd(cd) {
	document.blosxom.plugin_blosxom_pwd.value += cd;
	document.blosxom.submit();
}

// Change directory up one level from the current directory
function cdup(pwd) {
	components = pwd.split('/');
	newPath = '';
	for (this_bit = 0; this_bit < (components.length - 2); this_bit++) {
		newPath += components[this_bit] + '/';
	}
	document.blosxom.plugin_blosxom_pwd.value = newPath;
	document.blosxom.submit();
}

// Figure out the title (first line) of the current post
function get_title() {
	post = top.opener.parent.frames.wp_edit.document.edit.wp_document.value;
	if (post.indexOf("\n")) {
		title = post.substring(0, post.indexOf("\n"));
		re = new RegExp('(<[^>]*>)', 'g');
		title = title.replace(re, '');
		re = new RegExp('([^a-z0-9])', 'gi');
		title = title.replace(re, '-');
		while (title.indexOf('--') > -1) {
			title = title.replace(/--/g, '-');
		}
		if (title.substring(0, 1) == '-') {
			title = title.substring(1, title.length);
		}
		if (title.substring(title.length - 1) == '-') {
			title = title.substring(0, title.length - 1);
		}
		return title.toLowerCase() + '.txt';
	}
	else {
		return '';
	}
}

// Update the name of the selected file, based on a selection
function update_file_name(name) {
	parent.document.file.identifier.value = document.blosxom.plugin_blosxom_pwd.value + name;
	document.blosxom.entry.value = name;
	parent.document.file.filename.value = name;
}

// Delete the currently selected entry. Used in the plugins toolbar
function delete_entry() {
	// Make sure they selected something first
	if (document.blosxom.entry.value == '') {
		alert('You must select an entry to delete.');
	}
	else {
		if (confirm("Are you sure you want to delete '" + document.blosxom.entry.value + "'?")) {
			document.blosxom.delete_entry.value = document.blosxom.entry.value;
			document.blosxom.entry.value = '';
			document.blosxom.submit();
		}
	}
}