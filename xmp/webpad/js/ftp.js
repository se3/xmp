// Perform a selection on a file.
// Changes appearance of the selected one and should update a field with the name
function select(element) {
	if (document.ftp.selected_element.value != '') {
		document.getElementById(document.ftp.selected_element.value).style.color = '#000000';
		document.getElementById(document.ftp.selected_element.value).style.background = 'transparent';
	}
	document.getElementById(element).style.color = '#FFFFFF';
	document.getElementById(element).style.background = '#000084';
	document.ftp.selected_element.value = element;
	
	// Call to update the selection on the parent frame
	update_file_name(element);
	return;
}

// Change directory via FTP
function cd(cd) {
	document.ftp.ftp_pwd.value += cd;
	document.ftp.submit();
}

// Change up one directory from the current one via FTP
function cdup(pwd) {
	pwd = document.ftp.ftp_pwd.value;
	newPath = '';
	components = pwd.split('/');
	if (components.length > 2) {
		for (this_bit = 0; this_bit < (components.length - 2); this_bit++) {
			newPath += components[this_bit] + '/';
		}
	}
	document.ftp.ftp_pwd.value = newPath;
	document.ftp.submit();
}

// Update the name of the selected file, based on a selection
function update_file_name(name) {
	parent.document.file.ftp_pwd.value = document.ftp.ftp_pwd.value;
	parent.document.file.filename.value = name;
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