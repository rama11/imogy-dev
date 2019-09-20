<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class LogPhoneController extends Controller
{

    public function __construct(){
		
		$this->middleware('auth');
	}

    public function index (){

        $logphone = DB::table('log_phone')
            ->get();
            
        $answere = DB::table('log_phone')
            ->where('details','=','0')
            ->count();
    
        $rejectcalls = DB::table('log_phone')
            ->where('details','=','1')
            ->count();    

        $allcalls = $logphone->count();    
        
        $data = array(
			"answere" => $answere,
            "rejectcalls" => $rejectcalls,
            "allcalls" => $allcalls,
		);

		$logphone = $logphone->toArray();

        return view('logphone.dashboard',compact('logphone','data','answere','rejectcalls','allcalls'));
    }

    public function addnew(Request $req){
        DB::table('log_phone')
            ->insert([
                'answered'   => $req->answered,
                'date'       => Carbon::Parse($req->date)->format("Y-m-d h:i:s"),
                'discussion' => $req->discussion,
                'involved'   => $req->involved,
                'details'    => $req->details,
            ]);
        return redirect('/logphone')->with('status', "success.");    
    }
}

