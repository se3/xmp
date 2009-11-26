<?
$file = "/usr/local/etc/setup.php";
$fp = fopen($file, 'r');
$fileData = fread($fp, filesize($file));
fclose($fp);

$line = explode("\n", $fileData);
$i = 1;
while ($i <= 5) {
        $dataPair = explode('=', $line[$i]);
		if ($dataPair[0] == "Login" && $dataPair[1] == "true") {
                if ($_SESSION['loggedIn'] != 1) {
                       header("Location:login_form.php");
                        exit;
                }
        }

		if ($dataPair[0] == "Lang") {
			$lang = $dataPair[1];
			if (strcmp($dataPair[1], 'arabic')== 0){
				copy("arabic.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'brazil')== 0){
				copy("bra.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'czech')== 0){
				copy("czech.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'danish')== 0){
				copy("danish.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'english')== 0){
				copy("eng.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'estonia')== 0){
				copy("estonia.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'france')== 0){
				copy("france.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'german')== 0){
				copy("german.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'greek')== 0){
				copy("greek.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'hungarian')== 0){
				copy("hungarian.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'hebrew')== 0){
				copy("hebrew.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'italy')== 0){
				copy("italy.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'kr')== 0){
				copy("kr.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'neder')== 0){
				copy("neder.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'polish')== 0){
				copy("polish.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'portu')== 0){
				copy("portu.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'russia')== 0){
				copy("russia.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'spain')== 0){
				copy("spain.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'slovenia')== 0){
				copy("slovenian.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'thai')== 0){
				copy("thai.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'turkish')== 0){
				copy("turkish.php", "/tmp/lang.php");
			}else if (strcmp($dataPair[1], 'vietname')== 0){
				copy("vietnamese.php", "/tmp/lang.php");
			}else{
				copy("eng.php", "/tmp/lang.php");	
			}
		}
		$i++;
}
?>