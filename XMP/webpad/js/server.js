// Perform a selection on a file.
// Changes appearance of the selected one and should update a field with the name
function select(element) {
	if (document.server.selected_element.value != '') {
		document.getElementById(document.server.selected_element.value).style.color = '#000000';
		document.getElementById(document.server.selected_element.value).style.background = 'transparent';
	}
	document.getElementById(element).style.color = '#FFFFFF';
	document.getElementById(element).style.background = '#000084';
	document.server.selected_element.value = element;
	
	// Call to update the selection on the parent frame
	update_file_name(element);
	return;
}

// Change current directory on the server
function cd(cd) {
	document.server.server_pwd.value = document.server.server_pwd.value + cd;
	document.server.submit();
}

// Change directory up one level from the current directory
function cdup(pwd) {
	components = pwd.split('/');
	newPath = '';
	for (this_bit = 0; this_bit < (components.length - 2); this_bit++) {
		newPath += components[this_bit] + '/';
	}
	document.server.server_pwd.value = newPath;
	document.server.submit();
}

// Update the name of the selected file, based on a selection
function update_file_name(name) {
	parent.document.file.server_pwd.value = document.server.server_pwd.value;
	parent.document.file.filename.value = name;
}

// Open a dialog to create a new folder
function new_directory() {
	open_console('../dialogs/directory.php?pwd=' + escape(document.file.server_pwd.value), 400, 120);
}

// Open a dialog to rename the selected file
function rename() {
	if (document.file.filename.value == '') {
		alert('You must select a file to rename.');
	}
	else {
		open_console('../dialogs/rename.php?pwd=' + escape(document.file.server_pwd.value) + '&file=' + escape(document.file.filename.value), 400, 120);
	}
}
	
// This requests the script required to delete a file (currently selected)
function delete_file() {
	// Make sure they selected something first
	if (document.file.filename.value == '') {
		alert('You must select a file to delete.');
	}
	else {
		if (confirm("Are you sure you want to delete '" + document.file.filename.value + "'?")) {
			document.file.delete_file.value = document.file.server_pwd.value + document.file.filename.value;
			document.file.filename.value = '';
			document.file.submit();
		}
	}
}

// Master function to do any checks etc for a save process
function handle_save() {
	if (document.file.filename.value == '') {
		alert('You must enter a name to save this file as.');
		return false;
	}

	// Check/confirm overwriting an existing file, then do it.
	return confirm_overwrite();
}