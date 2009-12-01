// Perform a selection on a file.
// Changes appearance of the selected one and should update a field with the name
function select(count, label, entry, feed) {
	if (document.blog.selected_element.value != '') {
		document.getElementById(document.blog.selected_element.value).style.color = '#000000';
		document.getElementById(document.blog.selected_element.value).style.background = 'transparent';
	}
	document.getElementById('entry' + count).style.color = '#FFFFFF';
	document.getElementById('entry' + count).style.background = '#000084';
	document.blog.selected_element.value = 'entry' + count;
	
	// Call to update the selection on the parent frame
	update_file_name(label, entry, feed);
	return;
}

// Update the name of the selected file, based on a selection
function update_file_name(label, entry, feed) {
	parent.document.file.identifier.value = '[' + entry + '@' + feed + ']';
	document.blog.entry.value = entry;
	document.blog.label.value = label;
	parent.document.file.filename.value = label;
}

// Figure out the title (first line) of the current post
function get_title() {
	post = top.opener.parent.frames.wp_edit.document.edit.wp_document.value;
	if (post.indexOf("\n")) {
		title = post.substring(0, post.indexOf("\n"));
		re = new RegExp('(<[^>]*>)', 'g');
		title = title.replace(re, '');
		return title;
	}
	else {
		return '';
	}
}

// Delete the currently selected entry. Used in the plugins toolbar
function delete_entry() {
	// Make sure they selected something first
	if (document.blog.entry.value == '') {
		alert('You must select an entry to delete.');
	}
	else {
		if (confirm("Are you sure you want to delete '" + document.blog.label.value + "'?")) {
			document.blog.delete_entry.value = document.blog.entry.value;
			document.blog.entry.value = '';
			document.blog.submit();
		}
	}
}