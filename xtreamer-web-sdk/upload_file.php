<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(0);
include '/tmp/lang.php';

// Code for Session Cookie workaround
        if (isset($_POST["PHPSESSID"])) {
                session_id($_POST["PHPSESSID"]);
        } else if (isset($_GET["PHPSESSID"])) {
                session_id($_GET["PHPSESSID"]);
        }

        session_start();

// Check post_max_size (http://us3.php.net/manual/en/features.file-upload.php#73762)
        $POST_MAX_SIZE = ini_get('post_max_size');
        $unit = strtoupper(substr($POST_MAX_SIZE, -1));
        $multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

        if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
                header("HTTP/1.1 500 Internal Server Error");
                echo "POST exceeded maximum allowed size.";
                exit(0);
        }

// Settings
		if ((substr($_GET['dir'],0,2) != '/.') and (substr($_GET['dir'],0,1) != '.') and ($_GET["dir"]=='')){
			$save_path = '/tmp/usbmounts/sda1/';
		}else if ((substr($_GET['dir'],0,2) != '/.') and (substr($_GET['dir'],0,1) != '.') and ($_GET["dir"]!='')){
			$save_path = '/tmp/usbmounts'.$_GET["dir"]."/";
		}
		$upload_name = "Filedata";
        $max_file_size_in_bytes = 1073741824;                           // 1GB in bytes
        $extension_whitelist = array("jpg", "gif", "png", "avi", "wmv", "mkv", "mpeg", "mp4");      // Allowed file extensions
        $valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';                                // Characters allowed in the file name (in a Regular Expression format)
        
// Other variables      
        $MAX_FILENAME_LENGTH = 260;
        $file_name = "";
        $file_extension = "";
        $uploadErrors = array(
        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
        );


// Validate the upload
        if (!isset($_FILES[$upload_name])) {
                HandleError("No upload found in \$_FILES for " . $upload_name);
                exit(0);
        } else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
                HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
                exit(0);
        } else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
                HandleError("Upload failed is_uploaded_file test.");
                exit(0);
        } else if (!isset($_FILES[$upload_name]['name'])) {
                HandleError("File has no name.");
                exit(0);
        }
        
// Validate the file size (Warning: the largest files supported by this code is 1GB)
        $file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
        if (!$file_size || $file_size > $max_file_size_in_bytes) {
                HandleError("File exceeds the maximum allowed size");
                exit(0);
        }
        
        if ($file_size <= 0) {
                HandleError("File size outside allowed lower bound");
                exit(0);
        }


// Validate file name (for our purposes we'll just remove invalid characters)
        //$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
		$file_name = basename(stripslashes($_FILES[$upload_name]['name']));
        if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
                HandleError("Invalid file name");
                exit(0);
        }


// Validate that we won't over-write an existing file
        if (file_exists($save_path . $file_name)) {
                HandleError("File with this name already exists");
                exit(0);
        }

// Validate file extension
        $path_info = pathinfo($_FILES[$upload_name]['name']);
        $file_extension = $path_info["extension"];
        $is_valid_extension = false;
        foreach ($extension_whitelist as $extension) {
                if (strcasecmp($file_extension, $extension) == 0) {
                        $is_valid_extension = true;
                        break;
                }
        }
//        if (!$is_valid_extension) {
//                HandleError("Invalid file extension");
//                exit(0);
//        }

// Process the file
        //sleep(50);
        if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
                HandleError("File could not be saved.");
                exit(0);
        }

        echo $STR_File_recvd;
        exit(0);

function HandleError($message) {
        //header("HTTP/1.1 500 Internal Server Error");
		header($message);
        echo $message;
}
?>
