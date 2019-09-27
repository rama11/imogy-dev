<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\LogPhoneDetail;
use App\LogPhoneHistory;
use App\LogPhoneDetailHistory;

class LogPhoneController extends Controller
{

	public function __construct(){
		
		$this->middleware('auth');
	}

	public function index (){

		$logphone = DB::table('log_phone__detail')
			->orderBy('id','DESC')
			->get();
			
		$answere = DB::table('log_phone__detail')
			->where('details','=','0')
			->count();
	
		$rejectcalls = DB::table('log_phone__detail')
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

	public function setNewLog(Request $req){
		$editedDate = Carbon::parse(str_replace(' -','',$req->date));

		$detail = new LogPhoneDetail;
		$detail->answered = $req->answered;
		$detail->date = $editedDate;
		$detail->discussion = $req->discussion;
		$detail->caller = $req->caller;
		$detail->involved = $req->involved;
		$detail->details = $req->details;
		$detail->save();

		$data = LogPhoneDetailHistory::find($req->id_detail_history);
		$data->updated = 1;
		$data->id_detail = $detail->id;
		$data->save();
		// DB::table('log_phone__detail')
		// 	->insert([
		// 		'answered'   => $req->answered,
		// 		'date'       => Carbon::Parse($req->date)->format("Y-m-d h:i:s"),
		// 		'discussion' => $req->discussion,
		// 		'involved'   => $req->involved,
		// 		'details'    => $req->details,
		// 	]);
		return redirect('/logphone')->with('status', "success.");    
		// return $data;
	}

	public function getLastestCall(){
		$data = DB::connection('mysql_asterisk')
			->table('cel')
			->select('id','eventtype','eventtime','cid_num','cid_name')
			->where('cid_num',DB::table('log_phone__device')->pluck('cid_num'))
			->orderBy('id','DESC')
			->take(20)
			->get()
			->reverse()
			->values();

		foreach ($data as $value) {
			$insert = LogPhoneHistory::updateOrCreate(
				[
					'id_asterisk' => $value->id,
					'eventtype' => $value->eventtype,
					'eventtime' => $value->eventtime,
					'cid_num' => $value->cid_num,
					'cid_name' =>$value->cid_name
				]
			);
			if ($value->eventtype == "ANSWER"){
				LogPhoneDetailHistory::firstOrCreate(
					[
						'id_history' => $insert->id
					]
				);
			}
		}

		return LogPhoneDetailHistory::with('history')->where('updated',0)->first();

	}
}

