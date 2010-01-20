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
               header("Location:www/login_form.php");
               exit;
               }
	   }
	$i++;
	}
?>
