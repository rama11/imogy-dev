<?php

$dir    =  getcwd() . '/public/';
$files1 = scandir($dir);

$nameFile = $_GET['nameFile'];
$attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/report/" . $nameFile;
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
