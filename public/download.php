<?php

$dir    =  getcwd() . '/public/';
$files1 = scandir($dir);

$nameFile = $_GET['nameFile'];
$nameFile = "Report_BJBR_-_November_2019-11-25_Rama.xlsx";
$attachment_location = $_SERVER["DOCUMENT_ROOT"] . "report/" . $nameFile;
// echo $attachment_location;
// echo file_exists($attachment_location);
// if (file_exists($attachment_location)) {

	header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
	header('Content-Disposition: attachment; filename=' . $nameFile );
	header('Content-Type: application/octet-stream');
	header('Content-Length: ' . filesize($nameFile));
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	flush(); 
	readfile($attachment_location);
// 	die();
// } else {
// 	die("Error: File not found.");
// } 
