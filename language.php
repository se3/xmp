<?
	session_start();
	error_reporting(0);
	$lang = $_POST['language'];

	$_SESSION['lang'] = $lang;

	if (strcmp($_SESSION['lang'], 'arabic')== 0){
		copy("arabic.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'czech')== 0){
		copy("czech.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'danish')== 0){
		copy("danish.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'english')== 0){
		copy("eng.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'estonia')== 0){
		copy("estonia.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'france')== 0){
		copy("france.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'german')== 0){
		copy("german.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'greek')== 0){
		copy("greek.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'hungarian')== 0){
		copy("hungarian.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'hebrew')== 0){
		copy("hebrew.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'italy')== 0){
		copy("italy.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'kr')== 0){
		copy("kr.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'neder')== 0){
		copy("neder.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'polish')== 0){
		copy("polish.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'portu')== 0){
		copy("portu.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'brazil')== 0){
		copy("bra.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'russia')== 0){
		copy("russia.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'spain')== 0){
		copy("spain.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'slovenia')== 0){
		copy("slovenian.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'thai')== 0){
		copy("thai.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'turkish')== 0){
		copy("turkish.php", "/tmp/lang.php");
	}else if (strcmp($_SESSION['lang'], 'vietname')== 0){
		copy("vietnamese.php", "/tmp/lang.php");
	}else{
		copy("eng.php", "/tmp/lang.php");
	}

	$filename = "/usr/local/etc/setup.php";
    $fp = fopen($filename, 'r');
    $fileData = fread($fp, filesize($filename));
    fclose($fp);

    $line = explode("\n", $fileData);
	$i = 0;
	while ($i <= 7) {
        	$dataPair = explode('=', $line[$i]);
        	if ($dataPair[0] == Lang) {
				$dataPair[1] = $lang;
				$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
			}else{
				$data = $data. $dataPair[0].'='.$dataPair[1]."\n";
			}
        $i++;
	}
  
	$file = fopen("/usr/local/etc/setup.php", "w");
	fwrite($file, $data);
	fclose($file);
	
	echo "<script>parent.window.location.href='setup_language.php'; </script>";
?>