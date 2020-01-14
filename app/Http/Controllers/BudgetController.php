<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\BudgetAccount;
use App\Http\Models\BudgetNote;
use App\Http\Models\BudgetActivity;
use Auth;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;




class BudgetController extends Controller
{
    //
    public function indexAccount(){
        $sidebar_collapse = true;
    	return view('budget.account',compact('sidebar_collapse'));
    }

    public function setAccount(Request $req){
        $data = new BudgetAccount();
        $data->PID = $req->PID;
        $data->customer = $req->customer;
        $data->project_name = $req->project_name;
        $data->start = Carbon::now()->toDateString();
        $data->end = Carbon::now()->toDateString();
        $data->budget = $req->budget;
        $data->save();
    }

    public function indexNote(){
        $sidebar_collapse = true;
    	return view('budget.note',compact('sidebar_collapse'));
    }

    public function getDataParameterNote(){
    	return array(
    		"account" => BudgetAccount::get()->pluck("PID"),
    		"issuer" => Auth::user()->pluck("nickname"),
    	);
    }

    public function getDataAccount(){
    	return array("data" => BudgetAccount::all());
    }

    public function getDataNote(){
    	return array("data" =>     
    		BudgetNote::join('budget__account','budget__account.id','=','budget__note.id_account')
    			->select(
    				'budget__note.id',
    				'budget__note.date',
    				'budget__note.document',
    				'budget__note.issuer',
    				'budget__note.purpose',
    				'budget__note.detail',
    				'budget__note.nominal',
                    'budget__account.PID',
    				'budget__account.customer'
    			)->orderBy('id','DESC')
                ->get());
    }

    public function setNote(Request $req){
        $PID = BudgetAccount::where('PID','=',$req->PID)->first();

        $data = new BudgetNote();
        $data->date =  Carbon::parse($req->date)->toDateString();
        $data->document = $req->document;
        $data->issuer = $req->issuer;
        $data->purpose = $req->purpose;
        $data->detail = $req->detail;
        $data->nominal = $req->nominal;
        $data->id_account = $PID->id;
        $data->procced = Auth::user()->nickname;
        $data->save();

        $dataActivity = new BudgetActivity();
        $dataActivity->id_note = BudgetNote::orderBy('id','DESC')->first()->id;
        $dataActivity->date = Carbon::now()->toDateTimeString();
        $dataActivity->activity = "Created";
        $dataActivity->note = "Note Created";
        $dataActivity->updater = Auth::user()->nickname;
        $dataActivity->save();
    }

    public function getIndividualNote(Request $req){
        $note = BudgetNote::where('id','=',$req->id)->first();
        return array(
            'note' => $note,
            'account' => BudgetAccount::where('id','=',$note->id_account)->first(),
            'procced' => BudgetActivity::orderBy('id','ASC')->where('id_note','=',$req->id)->first()->updater,
            'latest' => BudgetActivity::orderBy('id','DESC')->where('id_note','=',$req->id)->first(),
            'activity' => BudgetActivity::orderBy('id','ASC')->where('id_note','=',$req->id)->get()
        );
        // return BudgetActivity::where('id_note','=',$req->id)->get();
    }

    public function updateNote(Request $req){
        $data = new BudgetActivity();
        $data->id_note = $req->id_note;
        $data->date = Carbon::now()->toDateTimeString();
        $data->activity = $req->activity;
        $data->note = $req->note;
        $data->updater = Auth::user()->nickname;
        $data->save();

    }

    public function editNote(Request $req){
        $data = BudgetNote::find($req->id_note);
        $data->date =  Carbon::parse($req->date)->toDateString();
        $data->document = $req->document;
        $data->purpose = $req->purpose;
        $data->detail = $req->detail;
        $data->nominal = $req->nominal;

        if($data->isDirty()){
            foreach ($data->getDirty() as $key => $value) {
                $dataActivity = new BudgetActivity();
                $dataActivity->id_note = $req->id_note;
                $dataActivity->date = Carbon::now()->toDateTimeString();
                $dataActivity->activity = "On Progress";
                $dataActivity->note = "Edited : " . $key ." -> " . $value;
                $dataActivity->updater = Auth::user()->nickname;
                $dataActivity->save();
            }
        }

        $data->save();

    }

    public function makeReportBudget(Request $req){
        $spreadsheet = new Spreadsheet();

        $title = 'Laporan Budgeting';

        $spreadsheet->getProperties()->setCreator('SIP')
            ->setLastModifiedBy(Auth::user()->name)
            ->setTitle($title);

        // $spreadsheet->getActiveSheet()->setTitle('All');

        // $spreadsheet->getActiveSheet()->setCellValue('A1', 'ID ');
        // $spreadsheet->getActiveSheet()->setCellValue('B1', 'Account ');
        // $spreadsheet->getActiveSheet()->setCellValue('C1', 'Project');
        // $spreadsheet->getActiveSheet()->setCellValue('D1', 'Customer ');
        // $spreadsheet->getActiveSheet()->setCellValue('E1', 'Date ');
        // $spreadsheet->getActiveSheet()->setCellValue('F1', 'Document ');
        // $spreadsheet->getActiveSheet()->setCellValue('G1', 'Issuer ');
        // $spreadsheet->getActiveSheet()->setCellValue('H1', 'Purpose ');
        // $spreadsheet->getActiveSheet()->setCellValue('I1', 'Detail ');
        // $spreadsheet->getActiveSheet()->setCellValue('J1', 'Nominal ');
        // $spreadsheet->getActiveSheet()->setCellValue('K1', 'Procced ');

        // $notes = BudgetNote::all();
        // $notes = BudgetNote::with('account_note')
        //     ->orderBy('issuer','ASC')
        //     ->get();

        // Per User
        $users = BudgetNote::groupBy('issuer')
            ->select('issuer')
            ->get();

        foreach ($users as $index_user => $user) {
            $spreadsheet->createSheet($index_user+1)->setTitle($user->issuer);
            $spreadsheet->setActiveSheetIndex($index_user+1);

            $spreadsheet->getActiveSheet()->setCellValue('A1', 'ID ');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Account ');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Project');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Customer ');
            $spreadsheet->getActiveSheet()->setCellValue('E1', 'Date ');
            $spreadsheet->getActiveSheet()->setCellValue('F1', 'Document ');
            $spreadsheet->getActiveSheet()->setCellValue('G1', 'Issuer ');
            $spreadsheet->getActiveSheet()->setCellValue('H1', 'Purpose ');
            $spreadsheet->getActiveSheet()->setCellValue('I1', 'Detail ');
            $spreadsheet->getActiveSheet()->setCellValue('J1', 'Nominal ');
            $spreadsheet->getActiveSheet()->setCellValue('K1', 'Procced ');

            $notes = BudgetNote::with('account_note')
                ->where('issuer','=',$user->issuer)
                ->orderBy('issuer','ASC')
                ->get();

            foreach ($notes as $key => $note) {
                $key = $key + 1;
                $spreadsheet->getActiveSheet()->setCellValue("A" . ($key + 1), $note->id);
                $spreadsheet->getActiveSheet()->setCellValue("B" . ($key + 1), $note->account_note->PID);
                $spreadsheet->getActiveSheet()->setCellValue("C" . ($key + 1), $note->account_note->project_name);
                $spreadsheet->getActiveSheet()->setCellValue("D" . ($key + 1), $note->account_note->customer);
                $spreadsheet->getActiveSheet()->setCellValue("E" . ($key + 1), Carbon::parse($note->date)->format('d/m/Y'));
                $spreadsheet->getActiveSheet()->setCellValue("F" . ($key + 1), $note->document);
                $spreadsheet->getActiveSheet()->setCellValue("G" . ($key + 1), $note->issuer);
                $spreadsheet->getActiveSheet()->setCellValue("H" . ($key + 1), $note->purpose);
                $spreadsheet->getActiveSheet()->setCellValue("I" . ($key + 1), $note->detail);
                $spreadsheet->getActiveSheet()->setCellValue("J" . ($key + 1), $note->nominal);
                $spreadsheet->getActiveSheet()->setCellValue("K" . ($key + 1), $note->procced);
            }
        }
        

        $name = 'Report_Budget_by_' . Auth::user()->nickname . '_' . date('Y-m-d') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('report/' . $name);
        return $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER['HTTP_HOST'] . "/report/" . $name;
    }
}
