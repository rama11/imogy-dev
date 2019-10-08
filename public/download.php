<?php

// echo "hahaha";

$dir    = '/var/www/html/imogy-dev/public/';
$files1 = scandir($dir);

// echo "<pre>";
// print_r($files1);
// echo "</pre>";
$nameFile = "Report_BJBR_-_Sep_(2019-10-08).xlsx";
$nameFile = $_GET['nameFile'];
$attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/" . $nameFile;
if (file_exists($attachment_location)) {

	header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
	header('Content-Disposition: attachment; filename=' . $nameFile );
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Length: ' . filesize($nameFile));
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	readfile($nameFile);
	die();
} else {
	die("Error: File not found.");
} 

// public function download (){
// 	return "asdfasdfasd";
// }

// download();