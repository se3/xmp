<?php

/*******************************/

$www_dir="/fm"; //directory where FileManager is (relatively Web-server Document Root directory)
$tmp_dir="/tmp"; //must be writable

/********* FileManager work directories *******/

$filemanager_dirs=array('ROOT'=>'/','HDD'=>'/tmp/usbmounts');


/******** Timeouts (sec) ***********/

$httpTimeout=20; //common HTTP-request timeout
$uploadFileTimeout=120; //Uploading remote file timeout
$shellTimeout=120; //Timeout, using when run shell command

/****** e-mail config *********/

$defaultFromAddress="filemanager@localhost";
$defaultFromName="File Manager";
$mailer="smtp";
$mail_host="localhost";
$client_charset="windows-1251";

/*****************************/

$default_lang="en_us"; 
$languages=array('en_us'=>'US English','ru_ru'=>'Russian');

$default_theme="Original";

$audio_exts=array('wav','gsm','ulaw','ul','al','mu','alaw','g729','g722','ogg','pcm','sln','g723','vox','au');

/******* max size uploaded file ********/

$max_file_size=20000000;

/****** php error reporting **********/

$err_reporting=0;

?>