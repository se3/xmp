// These are (unfortunately) required for a shaky Mozilla hack.
// They should be set to the "magic" line height for each platform
win_lineHeight = 15.1;
mac_lineHeight = 17.1;

// This updates the title of the window to include the active filename if present
function update_window_title() {
	// Get the current filename according to hidden fields
	filename = parent.frames.wp_edit.document.edit.display_filename.value;
	
	// Clean up filename to remove tags in case they are there
	re = new RegExp('(<[^>]*>)', 'g');
	filename = filename.replace(re, '');
	
	// Figure out what the title will be, based on the format of the file etc.
	if (filename != 'new_webpad_document' && filename != '') {
		titlePrefix = filename + ' - ';
	}
	else {
		titlePrefix = '';
	}
	
	// Set the title of the window according to filename, format etc.
	parent.document.title = titlePrefix + 'webpad: the web-based text editor';
}

// Simply clears the edit area and resets everything. Checks first if anything has changed 
// since last save, asks for confirmation if it has.
function file_new(force) {
	if (use_templates && !force) {
		open_console('dialogs/new.php', 400, 150);
	}
	else {
		if (confirm_discard()) {
			parent.frames.wp_edit.document.edit.display_filename.value = '';
			parent.frames.wp_edit.document.edit.filename.value = 'new';
			parent.frames.wp_edit.document.edit.operation.value = 'new';
			parent.frames.wp_edit.document.edit.wp_document.value = '';
			parent.frames.wp_edit.document.edit.submit();
		}
	}
}

// Opens the file dialog to allow you to open a new file
function file_open() {
	open_console('open.php', 550, 370);
}

// Opens the file upload dialog to allow an arbitrary file upload
function file_upload() {
	open_console('dialogs/upload.php', 410, 130);c
}

// This invokes the saving of a file, figures out what needs to happen and
// then opens windows or submits forms as required.
function file_save() {
	if (parent.frames.wp_edit.document.edit.filename.value == 'new_webpad_document') {
		self.file_save_as();
	}
	else {
		parent.frames.wp_edit.document.edit.override.value = 'true';
		parent.frames.wp_edit.document.edit.operation.value = 'save';
		parent.frames.wp_edit.document.edit.submit();
	}
}

// Opens up the save dialog to allow you to specify a new location to save this file
function file_save_as() {
	open_console('save.php', 550, 370);
}

// Open up the dialog to allow the user to email the file to someone.
function email() {
	if (parent.frames.wp_edit.document.edit.wp_document.value == '') {
		return;
	}
	
	open_console('dialogs/email.php', 490, 180);
}

// This prints the current file by opening a new window, then writing the current
// text into that window in a good print font, and calls a self.print() on body load.
function print() {
	if (parent.frames.wp_edit.document.edit.wp_document.value == '') {
		return;
	}
	
	filename = parent.frames.wp_edit.document.edit.display_filename.value;
	modified_edit_text = parent.frames.wp_edit.document.edit.wp_document.value.replace(/&/gi, '&amp;');
	modified_edit_text = modified_edit_text.replace(/\t/gi, '    ');
	modified_edit_text = modified_edit_text.replace(/  /gi, '&nbsp; ');
	modified_edit_text = modified_edit_text.replace(/</gi, '&lt;');
	modified_edit_text = modified_edit_text.replace(/>/gi, '&gt;');
	modified_edit_text = modified_edit_text.replace(/\n/gi, '<br />');
	webpad_print = window.open('', 'webpad_print');
	webpad_print.document.open();
	webpad_print.document.writeln("<html>\n<head>\n<title>" + filename + "</title>\n</head>\n\n<body onload=\"self.print();\">\n<div style=\"font-family: Courier, Monaco, Andale, Fixed-width; font-size: 9pt;\">\n");
	webpad_print.document.writeln(modified_edit_text);
	webpad_print.document.writeln("\n</div>\n</body>\n</html>");
	webpad_print.document.close();
}

// Toggle the state of word-wrap in the main editing window
function word_wrap() {
	currstate = 'on';
	if (currstate == 'off') {
		currstate = 'on';
	}
	else {
		currstate = 'off';
	}
}

// Function to jump to a line within the document
function go_to(num) {
	if (arguments.length == 0) {
		goto_line = prompt('Go to line:', 1);
	}
	
	cp = 0;
	lp = false;
	txtarea = parent.frames.wp_edit.document.edit.wp_document;
	txtarea.focus();
	body = txtarea.value;
	
	for (tl = 1; tl < goto_line; tl++) {
		if (cp == lp) {
			cp++;
		}
		cp = body.substr(0, body.indexOf("\n", cp)).length;
		lp = cp;
	}
	
	// Internet Explorer
	if (document.all) {
		r = txtarea.createTextRange();
		if (goto_line == 1) {
			r.move('character', 0);
		}
		else {
			r.move('character', cp - (goto_line - 2));
		}
		r.select();
	}
	
	// Mozilla Variants
	else if (document.getElementById) {
		// For some reason, need to modify the contents of the field for
		// jumping to a blank line to work
		txtarea.value += ' ';
		txtarea.value = txtarea.value.substring(0, txtarea.value.length - 1);
		
		// Fix character positioning
		if (goto_line > 1) {
			cp = cp + 1;
		}
		txtarea.setSelectionRange(cp, cp);
		scroll_to_line(txtarea, goto_line);
	}
}


// This will locate a text string (and select it) in the currently open file
nfs = 0;
function find_str(str) {
	var txt, i, found, str;
	win = parent.frames.wp_edit;
	win.document.edit.wp_document.focus();
	
	// If we don't have a string, then ask for one.
	if (str == '') {
		if (!(str = prompt('Find in document:', get_find_str()))) {
			return;
		}
	}
	
	// Put this string into the cookie (for 'Find Next')
	document.cookie = 'str=' + str + '#@';

	// Internet Explorer
	if (document.all) {
		txt = win.document.body.createTextRange();
		for (i = 0; i <= nfs && (found = txt.findText(str)) != false; i++) {
			txt.moveStart('character', 1);
			txt.moveEnd('textedit');
		}
		
		if (found) {
			txt.moveStart('character', -1);
			txt.findText(str);
			txt.select();
			txt.scrollIntoView();
			nfs++;
		}
		else {
			if (nfs > 0) {
				nfs = 0;
				find_str(str);
			}
			else {
				alert("'" + str + "' was not found in the document.");
			}
		}
	}
	
	// Mozilla Variants
	else if (document.getElementById) {
		txtarea = win.document.edit.wp_document;
		
		// Get location of this occurrence
		offset = txtarea.selectionEnd;
		strStart = txtarea.value.indexOf(str, offset);
		if (strStart == -1) {
			offset = 0;
			strStart = txtarea.value.indexOf(str, offset);
			
			if (strStart == -1) {
				alert("'" + str + "' was not found in the document.");
				return;
			}
		}
		
		strLength = str.length;
		strEnd = strStart + strLength;

		// Reset the value of the textarea with the added HTML
		s1 = txtarea.value.substring(0, strStart);

		// Reset cursor position to the found text
		txtarea.setSelectionRange(s1.length, strEnd);

		// Now scroll to the active line
		scroll_to_line(txtarea, count_lines(s1));
	}
	
	return;
}

// Should repeat a "find_str()" call and find the next occurrence in the contents.
// Gets the last used 'Find' string from the cookie
function find_next() {
	str = get_find_str();
	find_str(str);
}

// Grab the string that was previousl searched from from the cookie
function get_find_str() {
	start = document.cookie.indexOf('str=') + 4;
	delimeter = document.cookie.indexOf('#@');
	str = document.cookie.substr(start, delimeter - start);
	return str;
}

// Counts the number of lines in a string, based on \n
function count_lines(str) {
	lines = str.split("\n");
	return lines.length
}

// Scrolls to the line specified in a textarea, based on some dodgy calculations
// Only revert to this when there is no scrollIntoView() option (eg in Mozilla)
function scroll_to_line(field, line) {
	if (navigator.appVersion.indexOf("Win") != -1) {
		lineHeight = win_lineHeight;
	}
	else if (navigator.appVersion.indexOf("Mac") != -1) {
		lineHeight = mac_lineHeight;
	}
	field.scrollTop = line * lineHeight - (line / 7 + 20);
}

// Opens a console window and requests a term to search for and what to replace it with
function find_replace() {
	open_console('dialogs/find_replace.php', 360, 160, 'findnreplace');
}

// This performs the actual search and replace function, given a search term and a 
// string to replace it with. The search is done on the live contents.
function _find_replace(findTxt, replaceTxt, flags) {
	flags = flags + 'g';
	targetTxt = parent.frames.wp_edit.document.edit.wp_document;
	
	edited = targetTxt.value;
	re = new RegExp(findTxt, flags);
	if (findTxt == replaceTxt) {
		return;
	}
	edited = edited.replace(re, replaceTxt);
	if (edited == targetTxt.value) {
		alert('String not found!');
	}
	else {
		targetTxt.value = edited;
	}
	targetTxt.focus();
}

// This is a useful function for inserting HTML-style tags. Wraps a selection in
// the specified start and end tags if there is one, otherwise appends the tags
// together, to the end of the document.
function html_tag(openTag, closeTag, targetObject) {
	// Default target to use (toolbar buttons use this)
	if (!targetObject || targetObject == "") {
		targetObject = 'parent.frames.wp_edit.document.edit.wp_document';
	}
	
	// Figure out if we need to tell IE to refer to an opener etc
	if (targetObject == 'parent.frames.wp_edit.document.edit.wp_document') {
		targetWindow = 'parent.frames.wp_edit.document';
	}
	else {
		targetWindow = 'opener.parent.frames.wp_edit.document';
	}

	// Update some details to the main window
	targ = eval(targetWindow);
	targ.edit.modified.value = true;
	targ.edit.wp_document.focus();
	
	// Now call the appropriate function to insert the tag, based on the browser
	// Internet Explorer
	if (document.all) {
		_ie_html_tag(eval(targetObject), openTag, closeTag, eval(targetWindow));
	}
	// Mozilla Variants
	else if (document.getElementById) {
		_moz_html_tag(eval(targetObject), openTag, closeTag);
	}
}

// This function handles insertion of tags under mozilla, which
// requires some different handling to work
function _moz_html_tag(txtarea, lft, rgt) {
	if (txtarea.type != 'textarea') {
		txtarea = txtarea.edit.wp_document;
	}
	newScroll = txtarea.scrollTop;
	
	// Get location for insertion
	selLength = txtarea.textLength;
	selStart = txtarea.selectionStart;
	selEnd = txtarea.selectionEnd;

	// Reset the value of the textarea with the added HTML
	s1 = (txtarea.value).substring(0, selStart);
	s2 = (txtarea.value).substring(selStart, selEnd);
	s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + lft + s2 + rgt + s3;
	
	// Reset cursor position to the inserted text
	txtarea.selectionStart = s1.length + lft.length + s2.length + rgt.length;
	txtarea.selectionEnd = txtarea.selectionStart;
	
	// Reset scroll position to where it should be (avoid jump to top)
	txtarea.scrollTop = newScroll;
}

// This will insert the tag for IE, which is simpler because of
// some custom IE objects
function _ie_html_tag(txtarea, lft, rgt, targWin) {
	strSelection = targWin.selection.createRange().text;
	if (strSelection != '') {
		targWin.selection.createRange().text = lft + strSelection + rgt;
	}
	else {
		targWin.selection.createRange().text = lft + rgt;
	}
}

// Launches the color-palette dialog to select/insert a color hex
function insert_hex() {
	open_console('dialogs/color.php', 330, 200);
}

// Launches the dialog to insert an HREF tag
function insert_href() {
	open_console('dialogs/href.php', 400, 170);
}

// Launches the dialog for an image to be inserted
function insert_img() {
	open_console('dialogs/img.php', 300, 320);
}

// Launches the dialog to create/insert a table
function insert_table() {
	open_console('dialogs/table.php', 300, 350);
}

// Launches the dialog to create/insert a bullet or number list
function insert_list() {
	open_console('dialogs/list.php', 360, 370);
}

// Similar to the print() function, except that it just writes the entire contents
// into the window that is opened, so it shows the user the HTML preview.
function preview() {
	if (parent.frames.wp_edit.document.edit.wp_document.value != '') {
		webpad_preview = window.open('', 'webpad_preview');
		webpad_preview.document.open();
		webpad_preview.document.write(parent.frames.wp_edit.document.edit.wp_document.value);
		webpad_preview.document.close();
	}
}

// When they click the "about" question mark in the toolbar...
function about() {
	open_console('about.php', 400, 440, 'aboutwebpad');
}

// Open up a window to load the help manual into
function help() {
	Xsize = 700;
	Ysize = 500;
	locateX = (screen.width - Xsize) / 2;
	locateY = (screen.height * 0.9 - Ysize) / 2;
	webpad_help = window.open('docs/user_manual.html', 'webpad_help', 'width=' + Xsize + ',height=' + Ysize + ',left=' + locateX + ',top=' + locateY + ',screenX=' + locateX + ',screenY=' + locateY + ',toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no');
}

// After confirming if required, go to the admin/settings interface
function settings() {
	if (confirm_discard()) {
		parent.document.location.href = 'admin/';
	}
}

// After confirming if required, log out of webpad
function logout() {
	if (confirm_discard()) {
		parent.document.location.href = 'logout.php';
	}
}

// Requests confirmation from the user before clearing the current file if the flag
// has been raised to indicate it may have changed.
function confirm_discard() {
	if (parent.frames.wp_edit.document.edit.modified.value == 'true') {
		return confirm('Discard any unsaved changes and continue?');
	}
	else {
		return true;
	}
}

// Requests confirmation from the user before opening a new file if the modified
// has been raised to indicate it may have changed.
function confirm_open() {
	if (top.opener.parent.frames.wp_edit.document.edit.modified.value == 'true') {
		return confirm('Discard any unsaved changes\nand open this file?');
	}
	else {
		return true;
	}
}

// Check/confirm overwrite
function confirm_overwrite() {
	if (document.file.filename.value != '') {
		if (in_array(document.file.filename.value, frames.files_iframe.file_list)) {
			return confirm("Overwrite existing file '" + document.file.filename.value + "'?");
		}
		else {
			return true;
		}
	}
}

// Generic function for opening a centred console window.
function open_console(fileName, Xsize, Ysize, name) {
	now = new Date();
	stamp = now.getMilliseconds();
	locateX = (screen.width - Xsize) / 2;
	locateY = (screen.height * 0.9 - Ysize) / 2;
	name = name + 'webpad_console' + stamp;
	window.open(fileName, name, 'width=' + Xsize + ',height=' + Ysize + ',left=' + locateX + ',top=' + locateY + ',screenX=' + locateX + ',screenY=' + locateY + ',toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no');
}

// Generic function for opening a centred console window, with a status bar.
function open_window(fileName, Xsize, Ysize, name) {
	now = new Date();
	stamp = now.getMilliseconds();
	locateX = (screen.width - Xsize) / 2;
	locateY = (screen.height * 0.9 - Ysize) / 2;
	name = name + 'webpad_console' + stamp;
	window.open(fileName, name, 'width=' + Xsize + ',height=' + Ysize + ',left=' + locateX + ',top=' + locateY + ',screenX=' + locateX + ',screenY=' + locateY + ',toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=no,resizable=yes,copyhistory=no');
}

// Inserts a tab character into the document, since without this,
// a TAB press would jump fields in the document/form.
function insert_tab() {
	html_tag("\t", '');
}

// Returns true or false based on whether the specified string is found
// in the array. This is based on the PHP function of the same name.
function in_array(stringToSearch, arrayToSearch) {
	for (s = 0; s < arrayToSearch.length; s++) {
		thisEntry = arrayToSearch[s].toString();
		if (thisEntry == stringToSearch) {
			return true;
		}
	}
	return false;
}
