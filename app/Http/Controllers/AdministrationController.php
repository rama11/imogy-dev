<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AdministrationController extends Controller
{
	//
	public function index() {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$documentName = 'world.xlsx';

		// $writer = new Xlsx($spreadsheet);
		// $writer->save($documentName);
		// return response()->download($documentName);

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save($documentName);
		return response()->download($documentName);
	}
}
