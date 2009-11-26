<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
include '/tmp/lang.php';
$data = $_POST['url'];
//if url file dont exists create it....
$file = "/usr/local/etc/keyword.data";
if (!file_exists($file)) {
        $urlfile = fopen($file, "w");
        fwrite($urlfile, $data);
        fclose($urlfile);
        chmod($file,0600);
}else {
        chmod($file,0777);
        $urlfile = fopen($file, "w");
        fwrite($urlfile, $data);
        fclose($urlfile);
        chmod($file,0600);
}
echo "<script>alert('$STR_DataSaved');</script>";
echo "<script>document.location.href='url.php'</script>";
?>
