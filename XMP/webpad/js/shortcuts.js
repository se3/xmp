// Catch key presses when called (onkeypress) and act accordingly
// when one of the shortcut combinations is detected.
function check_shortcuts(evt) {
	// The modified flag in the main editor
	mf = parent.frames.wp_edit.document.edit.modified;
	
	// If the control key isn't down, ignore completely (faster for IE)
	if (evt && evt.ctrlKey != true && evt.keyCode != 0) {
		mf.value = true;
		return true;
	}
	
	// No evt element? Bail out
	if (!evt) {
		mf.value = true;
		return true;
	}
	
	// Where to find our shortcut code
	tb = parent.frames.wp_toolbar;
	
	// Internet Explorer on PC
	if (document.all) {
		if (evt.keyCode != 0) {
			switch (evt.keyCode) {
				case 14 :						// ctrl-shift-n
					tb.file_new(true);
					return false;
				case 15 :						// ctrl-shift-o
					tb.file_open();
					return false;
				case 19 :						// ctrl-shift-s
					tb.file_save();
					return false;
				case 7 :						// ctrl-shift-g
					tb.go_to();
					return false;
				case 6 :						// ctrl-shift-f
					tb.find_str('');
					return false;
				case 8 :						// ctrl-shift-h
					tb.find_replace();
					mf.value = true;
					return false;
				case 2 :						// ctrl-shift-b
					tb.html_tag('<strong>', '</strong>');
					mf.value = true;
					return false;
				case 9 :						// ctrl-shift-i
					tb.html_tag('<em>', '</em>');
					mf.value = true;
					return false;
				case 1 :						// ctrl-shift-a
					tb.insert_href();
					mf.value = true;
					return false;
				case 12 :						// ctrl-shift-l
					tb.html_tag('<p align="left">', '</p>');
					mf.value = true;
					return false;
				case 5 :						// ctrl-shift-e
					  tb.html_tag('<p align="center">', '</p>');
					  mf.value = true;
					  return false;
				case 18 :						// ctrl-shift-r
					tb.html_tag('<p align="right">', '</p>');
					mf.value = true;
					return false;
				case 10 :						// ctrl-shift-j
					tb.html_tag('<p align="justify">', '</p>');
					mf.value = true;
					return false;
				case 16 :						// ctrl-shift-p
					tb.preview();
					return false;
				case 17 :						// ctrl-shift-q
					tb.insert_tab();
					mf.value = true;
					return false;
				case 9 :						// tab
					tb.insert_tab();
					mf.value = true;
					return false;
				default :
					mf.value = true;
					return true;
			}
		}
	}
	else if (document.getElementById) {
		// Mozilla/Firefox on PC
		if (evt.ctrlKey == true) {
			switch (evt.which) {
				case 78 :						// ctrl-shift-n
					tb.file_new(true);
					return false;
				case 79 :						// ctrl-shift-o
					tb.file_open();
					return false;
				case 83 :						// ctrl-shift-s
					tb.file_save();
					return false;
				case 71 :						// ctrl-shift-g
					tb.go_to();
					return false;
				case 70 :						// ctrl-shift-f
					tb.find_str('');
					return false;
				case 72 :						// ctrl-shift-h
					tb.find_replace();
					mf.value = true;
					return false;
				case 66 :						// ctrl-shift-b
					tb.html_tag('<strong>', '</strong>');
					mf.value = true;
					return false;
				case 73 :						// ctrl-shift-i
					tb.html_tag('<em>', '</em>');
					mf.value = true;
					return false;
				case 65 :						// ctrl-shift-a
					tb.insert_href();
					mf.value = true;
					return false;
				case 76 :						// ctrl-shift-l
					tb.html_tag('<p align="left">', '</p>');
					mf.value = true;
					return false;
				case 69 :						// ctrl-shift-e
					tb.html_tag('<p align="center">', '</p>');
					mf.value = true;
					return false;
				case 82 :						// ctrl-shift-r
					tb.html_tag('<p align="right">', '</p>');
					mf.value = true;
					return false;
				case 74 :						// ctrl-shift-j
					tb.html_tag('<p align="justify">', '</p>');
					mf.value = true;
					return false;
				case 80 :						// ctrl-shift-p
					tb.preview();
					return false;
				case 81 :						// ctrl-shift-q
					tb.insert_tab();
					mf.value = true;
					return false;
				default :
					mf.value = true;
					return true;
			}
		}
		
		// Mozilla/Firefox/Camino on Macintosh
		else {
			switch (evt.which) {
				case 732 :						// opt-shift-n
					tb.file_new(true);
					return false;
				case 216 :						// opt-shift-o
					tb.file_open();
					return false;
				case 205 :						// opt-shift-s
					tb.file_save();
					return false;
				case 733 :						// opt-shift-g
					tb.go_to();
					return false;
				case 207 :						// opt-shift-f
					tb.find_str('');
					return false;
				case 211 :						// opt-shift-h
					tb.find_replace();
					mf.value = true;
					return false;
				case 305 :						// opt-shift-b
					tb.html_tag('<strong>', '</strong>');
					mf.value = true;
					return false;
				case 710 :						// opt-shift-i
					tb.html_tag('<em>', '</em>');
					mf.value = true;
					return false;
				case 197 :						// opt-shift-a
					tb.insert_href();
					mf.value = true;
					return false;
				case 210 :						// opt-shift-l
					tb.html_tag('<p align="left">', '</p>');
					mf.value = true;
					return false;
				case 180 :						// opt-shift-e
					tb.html_tag('<p align="center">', '</p>');
					mf.value = true;
					return false;
				case 8240 :						// opt-shift-r
					tb.html_tag('<p align="right">', '</p>');
					mf.value = true;
					return false;
				case 212 :						// opt-shift-j
					tb.html_tag('<p align="justify">', '</p>');
					mf.value = true;
					return false;
				case 8719 :						// opt-shift-p
					tb.preview();
					return false;
				case 338 :						// opt-shift-q
					tb.insert_tab();
					mf.value = true;
					return false;
				default :
					mf.value = true;
					return true;		
			}
		}
	}
	
	return true;
}