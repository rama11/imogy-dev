<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Mail;
use Response;
use App\Mail\TicketMail;
use PHPMailer\PHPMailer;
use PDF;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use App\Http\Models\Ticketing;
use App\Http\Models\TicketingDetail;
use App\Http\Models\TicketingActivity;
use App\Http\Models\TicketingResolve;
use App\Http\Models\TicketingClient;
use App\Http\Models\TicketingATM;
use App\Http\Models\TicketingSeverity;

use Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;;

class TicketingController extends Controller
{


	public function __construct(){
		
	}

	public function tisygy(){

		$clients = DB::table('ticketing__client')
			->where('situation','=',1)
			->get();

		$count = $clients->count();

		$atms = DB::table('ticketing__atm')
			->get();

		for($i = 0; $i < $count;$i++){
			$clients[$i]->open_to = str_replace(';', '<br>',$clients[$i]->open_to);
			$clients[$i]->open_cc = str_replace(';', '<br>',$clients[$i]->open_cc);
			$clients[$i]->close_to = str_replace(';', '<br>',$clients[$i]->close_to);
			$clients[$i]->close_cc = str_replace(';', '<br>',$clients[$i]->close_cc);
		}

		foreach ($atms as $atm) {
			$atm->owner = DB::table('ticketing__client')
				->where('id','=',$atm->owner)
				->value('client_acronym');
		}

		// $var = "imogy@sinergy.co.id;endraw@sinergy.co.id;bsb_ts_atm@banksumselbabel.com;wisnu.darman@sinergy.co.id;juliusdeddy.darmawan@wincor-nixdorf.com;dimas.widyawan@services-division.com;doni.syufri.ext@wincor-nixdorf.com;juni.ibrahim@services-division.com;eko.qualita@gmail.com;umar.holik@banksumselbabel.com;rudi.partono@banksumselbabel.com;evi.kamal@banksumselbabel.com;jimy.mandoza@banksumselbabel.com;chairullah@banksumselbabel.com;bambang.nugroho@banksumselbabel.com;jauhari@banksumselbabel.com;sandy.perwira@banksumselbabel.com;rahmat.deli@banksumselbabel.com; heru.muharam@banksumselbabel.com;rahmad.deli@banksumselbabel.com;wisnu.aji@banksumselbabel.com; saptono@banksumselbabel.com; kui.ciong@banksumselbabel.com; jauhari.johan@banksumselbabel.com; purwaningsih@banksumselbabel.com;";
		// echo str_replace(';', '<br>', $var);
		// echo "<br>";
		// echo str_replace(';', '<br>',$clients[1]->open_cc);
		// echo "<br>";
		// echo $clients[1]->open_cc;
		$sidebar_collapse = true;
		return view('tisygy',compact('clients','atms','sidebar_collapse'));
	}

	public function tisygy2(){

		$clients = DB::table('ticketing__client')
			->get();

		$count = DB::table('ticketing__client')
			->count();

		$atms = DB::table('ticketing__atm')
			->get();

		for($i = 0; $i < $count;$i++){
			$clients[$i]->open_to = str_replace(';', '<br>',$clients[$i]->open_to);
			$clients[$i]->open_cc = str_replace(';', '<br>',$clients[$i]->open_cc);
			$clients[$i]->close_to = str_replace(';', '<br>',$clients[$i]->close_to);
			$clients[$i]->close_cc = str_replace(';', '<br>',$clients[$i]->close_cc);
		}

		foreach ($atms as $atm) {
			$atm->owner = DB::table('ticketing__client')
				->where('id','=',$atm->owner)
				->value('client_acronym');
		}

		return view('tisygy2',compact('clients','atms'));
	}

	public function getDashboard(){
		// $start = microtime(true);

		$result2 = DB::table('ticketing__condition')
			->select('name',DB::raw("IFNULL(`ticketing_activity`.`count`,0) AS `count`"))
			->join(DB::raw("(SELECT
				        `activity`,
				        COUNT(*) AS `count`
				    FROM
				        `ticketing__activity`
				    WHERE
				        `id` IN(
				        SELECT
				            MAX(`id`) AS `activity`
				        FROM
				            `ticketing__activity`
				        GROUP BY
				            `id_ticket`
				    )
				GROUP BY
		    `activity`) AS `ticketing_activity`"),'ticketing_activity.activity','=','ticketing__condition.name','left')
		    ->get()->keyBy('name');

		// return $result2;

		$all = 0;
		foreach ($result2 as $key => $value) {
			$all = $all + $value->count;
		}

		$result2 = $result2->map(function($item, $key){
			return $item->count;
		});

		$result2->put("ALL",$all);
		$result2->put("PROGRESS",$result2["ON PROGRESS"]);
		$result2->forget("ON PROGRESS");
		// return $result2;

		$get_client = DB::table('ticketing__client')
			->select('id','client_name','client_acronym')
			->where('situation','=','1')
			->pluck('client_acronym');
		// return $get_client;

		$count_ticket_by_client = DB::table('ticketing__id')
			->selectRaw('`ticketing__client`.`client_acronym`, COUNT(*) AS ticket_count')
			->groupBy('ticketing__id.id_client')
			->join('ticketing__client','ticketing__client.id','=','ticketing__id.id_client')
			->where('ticketing__client.situation','=','1')
			->orderBy('ticket_count','DESC')
			->get();
		// return $count_ticket_by_client;

		$needed = DB::table('ticketing__activity')
			->select('ticketing__detail.id', 'ticketing__detail.id_ticket', 'ticketing__detail.id_atm', 'ticketing__detail.location', 'ticketing__activity.operator', 'ticketing__activity.date','ticketing__detail.severity')
			->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__activity.id_ticket')
			->whereIn('ticketing__activity.id', function ($query){
					$query->selectRaw("MAX(`ticketing__activity`.`id`) AS `activity`")
						->from('ticketing__activity')
						->groupBy('id_ticket');
				})
			->where('activity','<>','CLOSE')
			->where('activity','<>','CANCEL')
			->orderBy('ticketing__detail.severity','ASC')
			->limit(10)
			->get();
		// return $needed;

		$severity_count = DB::table('ticketing__detail')
			->select('ticketing__severity.name',DB::raw('COUNT(*) as count'))
			->join('ticketing__severity','ticketing__severity.id','=','ticketing__detail.severity')
			->where('ticketing__detail.severity','<>',0)
			->groupBy('ticketing__detail.severity')
			->get()
			->keyBy('name');

		$severity_count = $severity_count->map(function($item, $key){
			return $item->count;
		});

		// $time_elapsed_secs = microtime(true) - $start;
		// return $time_elapsed_secs;

		return collect([
			"counter_condition" => $result2,
			"counter_severity" => $severity_count,
			"occurring_ticket" => $needed,
			"customer_list" => $get_client,
			"chart_data" => [
				"label" => $count_ticket_by_client->pluck('client_acronym'),
				"data" => $count_ticket_by_client->pluck('ticket_count')
			]
		]);

	}

	public function count_query(){
		// $require = DB::table('ticketing__activity')
		// 	->select(DB::raw("MAX(id) AS activity"))
		// 	->where('activity','=','OPEN')
		// 	->groupBy('id_ticket')
		// 	->get();

		$result = DB::table('ticketing__detail')
			->select('ticketing__detail.severity',DB::raw('COUNT(*) as count'))
			->join(DB::raw("(SELECT `ticketing__activity`.`operator`,`ticketing__activity`.`id_ticket`
							FROM `ticketing__activity`
							JOIN (
								SELECT MAX(id) AS activity 
								FROM `ticketing__activity` 
								GROUP by `id_ticket`
							) AS aa
							ON `ticketing__activity`.`id` = aa.`activity`
						) AS aaa"),"ticketing__detail.id_ticket","=","aaa.id_ticket")
			->where('ticketing__detail.severity','<>',0)
			->groupBy('ticketing__detail.severity')
			->get();

		// if(!strpos($result,"OPEN")){
		// 	$result[] = (object)["activity"=>"OPEN","count"=>0];
		// }
		// if(!strpos($result,"PENDING")){
		// 	$result[] = (object)["activity"=>"PENDING","count"=>0];
		// }

		return $result;
	}

	public function getOpenMailTemplate(){
		return view('mailOpenTicket');
	}

	public function getCloseMailTemplate(){
		return view('mailCloseTicket');
	}

	public function getPendingMailTemplate(){
		return view('mailPendingTicket');
	}
	
	public function getCancelMailTemplate(){
		return view('mailCancelTicket');
	}

	public function getEmailData(Request $req){
		if(isset($req->client)){
			return $result = TicketingClient::where('client_acronym',$req->client)
				->first();
		} else {
			$idTicket = $req->id_ticket;
			$ticket_data = TicketingDetail::whereHas('id_detail', function($query) use ($idTicket){
					$query->where('id','=',$idTicket);
				})
				->with([
					'lastest_activity_ticket:id_ticket,date,activity,operator',
					'resolve',
					'first_activity_ticket',
					'severity_detail:id,name'
				])
				->first();

			$ticket_reciver = Ticketing::where('id',$idTicket)
				->first()
				->client_ticket;

			return collect([
				"ticket_data" => $ticket_data,
				"ticket_reciver" => $ticket_reciver
			]);
		}
	}


	public function getCreateParameter(){
		$client = TicketingClient::where('situation','=',1)->orderBy('client_acronym')->get();
		$severity = TicketingSeverity::all();
		
		return array(
			$client->pluck('client_acronym'),
			$severity->pluck('id'),
			$severity->pluck('name'),
			$severity->pluck('description'),
		);
	}

	public function getReserveIdTicket(){
		return Ticketing::orderBy('id','DESC')->first()->id + 1;
	}

	public function setReserveIdTicket(Request $req){
		// $req->id_client = DB::table('ticketing__client')
		// 	->where('client_acronym','=',$req->id_client)
		// 	->value('id');

		$newTicketId = new Ticketing();
		$newTicketId->id = $req->id;
		$newTicketId->id_ticket = $req->id_ticket;
		$newTicketId->id_client = TicketingClient::where('client_acronym',$req->acronym_client)->value('id');
		$newTicketId->operator = Auth::user()->nickname;

		$newTicketId->save();

		// DB::table('ticketing__id')
		// 	->insert([
		// 		'id' => $req->id,
		// 		'id_ticket' => $req->id_ticket,
		// 		'id_client' => TicketingClient::where('client_acronym',$req->acronym_client)->value('id'),
		// 		'operator' => Auth::user()->nickname,
		// 	]);
	}

	public function putReserveIdTicket(Request $req){
		// $req->id_client = DB::table('ticketing__client')
		// 	->where('client_acronym','=',$req->id_client)
		// 	->value('id');

		$updateTicketId = Ticketing::where('id_ticket',$req->id_ticket_before)->first();
		$updateTicketId->id_ticket = $req->id_ticket_after;
		$updateTicketId->id_client = TicketingClient::where('client_acronym',$req->acronym_client)->value('id');

		$updateTicketId->save();

		// DB::table('ticketing__id')
		// 	->insert([
		// 		'id' => $req->id,
		// 		'id_ticket' => $req->id_ticket,
		// 		'id_client' => TicketingClient::where('client_acronym',$req->acronym_client)->value('id'),
		// 		'operator' => Auth::user()->nickname,
		// 	]);
	}

	public function setNewTicket(Request $req){
		$id_client = DB::table('ticketing__client')
			->where('client_acronym','=',$req->client)
			->value('id');

		date_default_timezone_set("Asia/Jakarta");



		// DB::table('ticketing__detail')
		// 	->insert([
		// 		"id_ticket" => $req->id_ticket,
		// 		"id_atm" => $req->id_atm,
		// 		"refrence" => $req->refrence,
		// 		"pic" => $req->pic,
		// 		"contact_pic" => $req->contact_pic,
		// 		"location" => $req->location,
		// 		"problem" => $req->problem,
		// 		"serial_device" => $req->serial_device,
		// 		"note" => $req->note,
		// 		"reporting_time" => $req->report,
		// 		"severity" => substr($req->severity,0,1)
		// 	]);

		

		// DB::table('ticketing__activity')
		// 	->insert([
		// 		"id_ticket" => $req->id_ticket,
		// 		"date" => date("Y-m-d H:i:s.000000"),
		// 		"activity" => "OPEN",
		// 		"operator" => Auth::user()->nickname,
		// 		"note" => "Open Ticket"
		// 	]);

		// "2018-03-15 12:20:13.000000"
		// "2018-03-08 10:24:42.000000"
		// echo date("Y-m-d H:i:s.000000");
	}

	public function getEmailReciver(Request $req){
		if(isset($req->id_ticket)){
			// echo $req->id_ticket;
			$id_client = DB::table('ticketing__id')
				->where('id_ticket','=',$req->id_ticket)
				->value('id_client');
			// echo $id_client;

			$result = DB::table('ticketing__client')
				->where('id','=',$id_client)
				->get()
				->toArray();

		} else {
			$result = TicketingClient::where('client_acronym',$req->client)
				->first();
		}
		return $result;

	}

	public function sendEmailOpen(Request $request){
		$mail = $this->makeMailer($request->to,$request->cc,$request->subject,$request->body);

		$mail->send();

		$detailTicketOpen = new TicketingDetail();
		$detailTicketOpen->id_ticket = $request->id_ticket;
		$detailTicketOpen->id_atm = $request->id_atm;
		$detailTicketOpen->refrence = $request->refrence;
		$detailTicketOpen->pic = $request->pic;
		$detailTicketOpen->contact_pic = $request->contact_pic;
		$detailTicketOpen->location = $request->location;
		$detailTicketOpen->problem = $request->problem;
		$detailTicketOpen->serial_device = $request->serial_device;
		$detailTicketOpen->note = $request->note;
		$detailTicketOpen->reporting_time = $request->report;
		$detailTicketOpen->severity = substr($request->severity,0,1);

		$detailTicketOpen->save();

		$activityTicketOpen = new TicketingActivity();
		$activityTicketOpen->id_ticket = $request->id_ticket;
		$activityTicketOpen->date = date("Y-m-d H:i:s.000000");
		$activityTicketOpen->activity = "OPEN";
		$activityTicketOpen->operator = Auth::user()->nickname;
		$activityTicketOpen->note = "Open Ticket";

		$activityTicketOpen->save();

		$clientAcronymFilter = Ticketing::with('client_ticket')
			->where('id_ticket',$request->id_ticket)
			->first()
			->client_ticket
			->client_acronym;
		$activityTicketOpen->client_acronym_filter = $clientAcronymFilter;
		return $activityTicketOpen;
	}

	

	public function getPerformance5($acronym_client,$period){


		if($acronym_client != "TTNI"){
			$result = DB::table('ticketing__id')
				->where('ticketing__detail.id_ticket','LIKE','%' . $period . '%')
				->where('ticketing__detail.id_ticket','LIKE','%' . $acronym_client . '%')
				->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
				->orderBy('ticketing__detail.id_atm','ASC')
				->get();
		} else {
			$result = DB::table('ticketing__id')
				->where('ticketing__detail.id_ticket','LIKE','%' . $period . '%')
				->where('ticketing__detail.id_ticket','LIKE','%' . $acronym_client . '%')
				->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
				->orderBy('ticketing__detail.id_ticket','ASC')
				->get();
		}

		$final = [];

		$atm_before = $result[0]->id_atm; 

		foreach ($result as $key => $value) {

			$check = DB::table('ticketing__activity')
				->where('id_ticket','=',$value->id_ticket)
				->orderBy('id','DESC')
				->value('activity');

			$downtime = 0;

			if($check == "CLOSE" || $check == "CANCEL"){
				$value->open = DB::table('ticketing__activity')
					->where('id_ticket','=',$value->id_ticket)
					->where('activity','=','OPEN')
					->value('date');

				$value->id_open = DB::table('ticketing__id')
					->where('id_ticket','=',$value->id_ticket)
					->value('id');

				$value->last_status = array(
					$check,
					DB::table('ticketing__activity')
						->where('id_ticket','=',$value->id_ticket)
						->orderBy('id','DESC')
						->value('date')
					);

				if($value->id_atm == $atm_before){
					
				}

				if($check == "CLOSE"){
					$value->root_couse = DB::table('ticketing__resolve')
						->where('id_ticket','=',$value->id_ticket)
						->value('root_couse');

					$value->counter_measure = DB::table('ticketing__resolve')
						->where('id_ticket','=',$value->id_ticket)
						->value('counter_measure');

				} else {
					$value->root_couse = '-';
					$value->counter_measure = '-';
				}


				$value->operator = DB::table('ticketing__activity')
					->where('id_ticket','=',$value->id_ticket)
					->orderBy('id','DESC')
					->value('operator');

				$final[] = $value;

			}
		}

		return $final;
	}

	public function getPerformanceByFinishTicket($acronym_client,$period){
		$occurring_ticket = DB::table('ticketing__activity')
			->select('id_ticket','activity')
			->whereIn('id',function ($query) {
				$query->select(DB::raw("MAX(id) AS activity"))
					->from('ticketing__activity')
					->groupBy('id_ticket');
				})
			->where('activity','<>','CANCEL')
			->where('activity','<>','CLOSE')
			->whereRaw('`id_ticket` LIKE "%' . $acronym_client . '%"')
			->get()
			->pluck('id_ticket');

		$residual_ticket_result = TicketingDetail::with([
				'first_activity_ticket:id_ticket,date,operator',
				'lastest_activity_ticket',
				'id_detail:id_ticket,id',
				'resolve',
			])
			->whereNotIn('id_ticket',$occurring_ticket)
			->whereRaw("`id_ticket` LIKE '%/" . $acronym_client . "/" . $period . "'")
			->orderBy('id','ASC')
			->get();

		return $residual_ticket_result;

		// $id_client = DB::table('ticketing__client')
		// 	->where('client_acronym','=',$acronym_client)
		// 	->value('id');

		// $result = DB::table('ticketing__id')
		// 	->where('ticketing__id.id_client','=',$id_client)
		// 	->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
		// 	// ->join('ticketing__resolve','ticketing__resolve.id_ticket','=','ticketing__id.id_ticket')
		// 	->orderBy('ticketing__id.id','ASC')
		// 	// ->limit()
		// 	->get();

		// $result2 = [];

		// foreach ($result as $key => $value) {
		// 	$temp = explode("/",$value->id_ticket);
		// 	$value->temp = $temp[2] . "/" . $temp[3];

		// 	$check = DB::table('ticketing__activity')
		// 		->where('id_ticket','=',$value->id_ticket)
		// 		->orderBy('id','DESC')
		// 		->value('activity');


		// 	if($value->temp == $period){
		// 		if($check == "CLOSE" || $check == "CANCEL"){
		// 			$value->open = DB::table('ticketing__activity')
		// 				->where('id_ticket','=',$value->id_ticket)
		// 				->where('activity','=','OPEN')
		// 				->value('date');

		// 			$value->id_open = DB::table('ticketing__id')
		// 				->where('id_ticket','=',$value->id_ticket)
		// 				->value('id');

		// 			$value->last_status = array(
		// 				DB::table('ticketing__activity')
		// 					->where('id_ticket','=',$value->id_ticket)
		// 					->orderBy('id','DESC')
		// 					->value('activity'),
		// 				DB::table('ticketing__activity')
		// 					->where('id_ticket','=',$value->id_ticket)
		// 					->orderBy('id','DESC')
		// 					->value('date')
		// 				);

		// 			if($check == "CLOSE"){
		// 				$value->root_couse = DB::table('ticketing__resolve')
		// 					->where('id_ticket','=',$value->id_ticket)
		// 					->value('root_couse');

		// 				$value->counter_measure = DB::table('ticketing__resolve')
		// 					->where('id_ticket','=',$value->id_ticket)
		// 					->value('counter_measure');
		// 			} else {
		// 				$value->root_couse = '-';
		// 				$value->counter_measure = '-';
		// 			}


		// 			$value->operator = DB::table('ticketing__activity')
		// 				->where('id_ticket','=',$value->id_ticket)
		// 				->orderBy('id','DESC')
		// 				->value('operator');

		// 			$result2[] = $value;
		// 		}
		// 	}
		// }

		// $result = $result2;

		// return $result;
	}

	public function getPerformanceBySeverity(Request $req){
		$start = microtime(true);

		$occurring_ticket = DB::table('ticketing__activity')
			->select('ticketing__activity.id_ticket','ticketing__activity.activity')
			->whereIn('ticketing__activity.id',function ($query) {
				$query->select(DB::raw("MAX(id) AS activity"))
					->from('ticketing__activity')
					->groupBy('id_ticket');
				})
			->where('ticketing__activity.activity','<>','CANCEL')
			->where('ticketing__activity.activity','<>','CLOSE')
			->get();

		$occurring_ticket_result = TicketingDetail::with([
				'first_activity_ticket:id_ticket,date,operator',
				'lastest_activity_ticket',
				'id_detail:id_ticket,id',
			])
			->whereIn('id_ticket',$occurring_ticket->pluck('id_ticket'))
			->where('severity',$req->severity)
			->orderBy('id','DESC')
			->get();

		$finish_ticket = DB::table('ticketing__activity')
			->select('ticketing__activity.id_ticket','ticketing__activity.activity')
			->whereIn('ticketing__activity.id',function ($query) {
				$query->select(DB::raw("MAX(`id`) AS `activity`"))
					->from('ticketing__activity')
					->groupBy('id_ticket');
				})
			->whereRaw('(`ticketing__activity`.`activity` = "CANCEL" OR `ticketing__activity`.`activity` = "CLOSE")')
			->orderBy('ticketing__activity.id','DESC')
			->get()
			->pluck('id_ticket');

		$finish_ticket_result = TicketingDetail::with([
				'first_activity_ticket:id_ticket,date,operator',
				'lastest_activity_ticket',
				'id_detail:id_ticket,id',
			])
			->whereIn('id_ticket',$finish_ticket)
			->where('severity',$req->severity)
			->take(100 - $occurring_ticket_result->count())
			->orderBy('id','DESC')
			->get();

		$result = $occurring_ticket_result->merge($finish_ticket_result);

		// $time_elapsed_secs = microtime(true) - $start;
		// return $time_elapsed_secs;

		return array('data' => $result);
	}

	public function getPerformanceByClient(Request $request){
		$start = microtime(true);
		$client_acronym = $request->client;

		$occurring_ticket = DB::table('ticketing__activity')
			->select('ticketing__activity.id_ticket','ticketing__activity.activity','ticketing__id.id_client')
			->whereIn('ticketing__activity.id',function ($query) {
				$query->select(DB::raw("MAX(id) AS activity"))
					->from('ticketing__activity')
					->groupBy('id_ticket');
				})
			->join('ticketing__id','ticketing__id.id_ticket','=','ticketing__activity.id_ticket')
			->where('ticketing__activity.activity','<>','CANCEL')
			->where('ticketing__activity.activity','<>','CLOSE')
			// ->where('ticketing__id.id_client','=',2)
			->get();

		$occurring_ticket_result = TicketingDetail::with([
				'first_activity_ticket:id_ticket,date,operator',
				'lastest_activity_ticket',
				'id_detail:id_ticket,id',
			])
			->whereIn('id_ticket',
				$occurring_ticket->where('id_client','=',DB::table('ticketing__client')
					->where('client_acronym','=',$client_acronym)
					->value('id')
				)
				->pluck('id_ticket')
			)
			->orderBy('id','DESC')
			->get();

		$finish_ticket = DB::table('ticketing__activity')
			->select('ticketing__activity.id_ticket','ticketing__activity.activity')
			->whereIn('ticketing__activity.id',function ($query) {
				$query->select(DB::raw("MAX(`id`) AS `activity`"))
					->from('ticketing__activity')
					->groupBy('id_ticket');
				})
			->whereRaw('`ticketing__activity`.`id_ticket` LIKE "%/' . $client_acronym . '/%"')
			->whereRaw('(`ticketing__activity`.`activity` = "CANCEL" OR `ticketing__activity`.`activity` = "CLOSE")')
			->orderBy('ticketing__activity.id','DESC')
			->take(100 - $occurring_ticket_result->count())
			->get()
			->pluck('id_ticket');

		$finish_ticket_result = TicketingDetail::with([
				'first_activity_ticket:id_ticket,date,operator',
				'lastest_activity_ticket',
				'id_detail:id_ticket,id',
			])
			->whereIn('id_ticket',$finish_ticket)
			->orderBy('id','DESC')
			->get();

		$result = $occurring_ticket_result->merge($finish_ticket_result);

		// $time_elapsed_secs = microtime(true) - $start;
		// return $time_elapsed_secs;

		return array("data" => $result);
	}

	public function getPerformance2(Request $req){
		if($req->client == "all"){
			return $this->getPerformance(0);
		} else {
			return $this->getPerformance4($req->client);
		}
	}

	public function getPerformance4($acronym_client){
		$id_client = DB::table('ticketing__client')
			->where('client_acronym','=',$acronym_client)
			->value('id');

		$result = DB::table('ticketing__id')
			->where('ticketing__id.id_client','=',$id_client)
			->take(300)	
			->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
			->orderBy('ticketing__id.id','DESC')
			->get();

		foreach ($result as $key => $value) {
			// echo $value->id . "<br>";

			

			$value->open = DB::table('ticketing__activity')
				->where('id_ticket','=',$value->id_ticket)
				->where('activity','=','OPEN')
				->value('date');

			$value->id_open = DB::table('ticketing__id')
				->where('id_ticket','=',$value->id_ticket)
				->value('id');

			$value->last_status = array(
				DB::table('ticketing__activity')
					->where('id_ticket','=',$value->id_ticket)
					->orderBy('id','DESC')
					->value('activity'),
				DB::table('ticketing__activity')
					->where('id_ticket','=',$value->id_ticket)
					->orderBy('id','DESC')
					->value('date')
				);

			$value->operator = DB::table('ticketing__activity')
				->where('id_ticket','=',$value->id_ticket)
				->orderBy('id','DESC')
				->value('operator');

		}

		return $result;
	}

	public function getPerformance(){
		// $start = microtime(true);
		$result = TicketingDetail::with([
				'first_activity_ticket:id_ticket,date',
				'lastest_activity_ticket',
				'id_detail:id_ticket,id',
			])
			->limit(1)
			->orderBy('id','DESC')
			->get();

		// $time_elapsed_secs = microtime(true) - $start;
		// return $time_elapsed_secs;

		return array("data" => $result);
			
	}

	public function getPerformanceAll(){
		// sleep(5);
		$occurring_ticket = DB::table('ticketing__activity')
			->select('id_ticket','activity')
			->whereIn('id',function ($query) {
				$query->select(DB::raw("MAX(id) AS activity"))
					->from('ticketing__activity')
					->groupBy('id_ticket');
				})
			->where('activity','<>','CANCEL')
			->where('activity','<>','CLOSE')
			->get()
			->pluck('id_ticket');

		$occurring_ticket_result = TicketingDetail::with([
				'first_activity_ticket:id_ticket,date,operator',
				'lastest_activity_ticket',
				'id_detail:id_ticket,id',
			])
			->whereIn('id_ticket',$occurring_ticket)
			->orderBy('id','DESC')
			->get();

		$residual_ticket_result = TicketingDetail::with([
				'first_activity_ticket:id_ticket,date,operator',
				'lastest_activity_ticket',
				'id_detail:id_ticket,id',
			])
			->whereNotIn('id_ticket',$occurring_ticket)
			->limit((100 - $occurring_ticket->count()))
			->orderBy('id','DESC')
			->get();

		$result = $occurring_ticket_result->merge($residual_ticket_result);

		return array("data" => $result);

	}

	public function getTicket(Request $req){

		$result = $this->getPerformance($req->id);
		
		$activity = DB::table('ticketing__activity')
			->where('id_ticket','=',$result[0]->id_ticket)
			->orderBy('id','DESC')
			->get();

		if($result[0]->last_status[0] == "CLOSE"){
			$resolve = DB::table('ticketing__resolve')
				->where('id_ticket','=',$result[0]->id_ticket)
				->get();
			$result = array($result[0],$activity,$resolve[0]);
			return $result;
		}

		$result = array($result[0],$activity);
		return $result;
		
	}
	public function getPerformanceByTicket(Request $req){
		$idTicket = $req->idTicket;
		$result = TicketingDetail::whereHas('id_detail', function($query) use ($idTicket){
				$query->where('id','=',$idTicket);
			})
			->with([
				'lastest_activity_ticket:id_ticket,date,activity,operator',
				'resolve',
				'all_activity_ticket',
				'first_activity_ticket'
			])
			->first();

		return $result;
	}

	public function setUpdateTicket(Request $req){
		$detailTicketUpdate = TicketingDetail::where('id_ticket',$req->id_ticket)
			->first();

		$detailTicketUpdate->engineer = $req->engineer;
		$detailTicketUpdate->ticket_number_3party = $req->ticket_number_3party;

		$detailTicketUpdate->save();

		$activityTicketUpdate = new TicketingActivity();
		$activityTicketUpdate->id_ticket = $req->id_ticket;
		$activityTicketUpdate->date = date("Y-m-d H:i:s.000000");
		$activityTicketUpdate->activity = "ON PROGRESS";
		$activityTicketUpdate->operator = Auth::user()->nickname;
		$activityTicketUpdate->note = $req->note;

		$activityTicketUpdate->save();

		$clientAcronymFilter = Ticketing::with('client_ticket')
			->where('id_ticket',$req->id_ticket)
			->first()
			->client_ticket
			->client_acronym;

		$activityTicketUpdate->client_acronym_filter = $clientAcronymFilter;
		
		return $activityTicketUpdate;
	}

	public function attachmentCloseTicket(Request $request){
		// $file = $request->attachment;
		if(isset($req->attachment)){
			$file = $request->file('attachment');
			$fileName = $file->getClientOriginalName();
			$request->file('attachment')->move("attachment/close/", $fileName);
		}
	}

	

	public function makeMailer($to, $cc, $subject, $body){
		$mail = new PHPMailer\PHPMailer(true);

		$email_type = "Yandex MSM01";

		if($email_type == "Yandex MSM01"){
			$mail_host = env('YANDEX_MAIL_HOST_MSM01');
			$mail_port = env('YANDEX_MAIL_PORT_MSM01');
			$mail_user = env('YANDEX_MAIL_USERNAME_MSM01');
			$mail_pass = env('YANDEX_MAIL_PASSWORD_MSM01');
			$mail_auth = env('YANDEX_MAIL_ENCRYPTION_MSM01');
			$mail_from = env('YANDEX_MAIL_FROM_MSM01');
			$mail_name = env('YANDEX_MAIL_NAME_MSM01');

		} else if ($email_type == "Yandex Imogy"){
			$mail_host = env('YANDEX_MAIL_HOST_IMOGY');
			$mail_port = env('YANDEX_MAIL_PORT_IMOGY');
			$mail_user = env('YANDEX_MAIL_USERNAME_IMOGY');
			$mail_pass = env('YANDEX_MAIL_PASSWORD_IMOGY');
			$mail_auth = env('YANDEX_MAIL_ENCRYPTION_IMOGY');
			$mail_from = env('YANDEX_MAIL_FROM_IMOGY');
			$mail_name = env('YANDEX_MAIL_NAME_IMOGY');
		} else if ($email_type == "Gmail Hello"){
			// Gmail Configuration
			$mail_host = env('GMAIL_MAIL_HOST');
			$mail_port = env('GMAIL_MAIL_PORT');
			$mail_user = env('GMAIL_MAIL_USERNAME');
			$mail_pass = env('GMAIL_MAIL_PASSWORD');
			$mail_auth = env('GMAIL_MAIL_ENCRYPTION');
			$mail_from = env('GMAIL_MAIL_FROM');
			$mail_name = env('GMAIL_MAIL_NAME');
		}

		try {
			$mail->isSMTP();
			$mail->CharSet = "utf-8";
			$mail->SMTPAuth = true;

			$mail->Host = $mail_host;
			$mail->Port = $mail_port;
			$mail->Username = $mail_user;
			$mail->Password = $mail_pass;
			$mail->SMTPSecure = $mail_auth;
			$mail->SetFrom($mail_from, $mail_name);

			$mail->Subject = $subject;
			$mail->MsgHTML($body);

			$to = explode(";", $to);
			$cc = explode(";", $cc);
			
			for($i = 0;$i < sizeof($to);$i++){
				$mail->addAddress($to[$i]);
			}

			for($i = 0;$i < sizeof($cc);$i++){
				$mail->addCC($cc[$i]);
			}
			
			return $mail;

		} catch (phpmailerException $e) {
			DB::table('email_error')
				->insert([
					"id" => $request->id_ticket,
					"email_to" => $request->to,
					"email_cc" => $request->cc,
					"email_subject" => $request->subject,
					"email_body" => $request->body,
					"email_type" => "PENDING"
				]);
			dd($e);
		} catch (Exception $e) {
			dd($e);
		}
	}

	public function sendEmailClose(Request $request){
		$mail = $this->makeMailer($request->to,$request->cc,$request->subject,$request->body);

		$mail->send();

		$activityTicketUpdate = new TicketingActivity();
		$activityTicketUpdate->id_ticket = $request->id_ticket;
		$activityTicketUpdate->date = $request->finish;
		$activityTicketUpdate->activity = "CLOSE";
		$activityTicketUpdate->operator = Auth::user()->nickname;
		$activityTicketUpdate->note = "CLOSE";

		$activityTicketUpdate->save();

		$resolveTicket = new TicketingResolve();
		$resolveTicket->id_ticket = $request->id_ticket;
		$resolveTicket->root_couse = $request->root_cause;
		$resolveTicket->counter_measure = $request->couter_measure;
		$resolveTicket->finish = date("Y-m-d H:i:s.000000");

		$resolveTicket->save();

		$clientAcronymFilter = Ticketing::with('client_ticket')
			->where('id_ticket',$request->id_ticket)
			->first()
			->client_ticket
			->client_acronym;

		$activityTicketUpdate->client_acronym_filter = $clientAcronymFilter;
		
		return $activityTicketUpdate;
	}

	public function sendEmailCancel(Request $request){
		$mail = $this->makeMailer($request->to,$request->cc,$request->subject,$request->body);

		$mail->send();

		$activityTicketUpdate = new TicketingActivity();
		$activityTicketUpdate->id_ticket = $request->id_ticket;
		$activityTicketUpdate->date = date("Y-m-d H:i:s.000000");
		$activityTicketUpdate->activity = "CANCEL";
		$activityTicketUpdate->operator = Auth::user()->nickname;
		$activityTicketUpdate->note = "Cancel Ticket - " . $request->note_cancel;

		$activityTicketUpdate->save();

		$clientAcronymFilter = Ticketing::with('client_ticket')
			->where('id_ticket',$request->id_ticket)
			->first()
			->client_ticket
			->client_acronym;

		$activityTicketUpdate->client_acronym_filter = $clientAcronymFilter;
		
		return $activityTicketUpdate;
	}

	public function sendEmailPending(Request $request){
		$mail = $this->makeMailer($request->to,$request->cc,$request->subject,$request->body);

		$mail->send();

		$activityTicketUpdate = new TicketingActivity();
		$activityTicketUpdate->id_ticket = $request->id_ticket;
		$activityTicketUpdate->date = date("Y-m-d H:i:s.000000");
		$activityTicketUpdate->activity = "PENDING";
		$activityTicketUpdate->operator = Auth::user()->nickname;
		$activityTicketUpdate->note = "Panding Ticket - " . $request->note_pending;

		$activityTicketUpdate->save();

		$clientAcronymFilter = Ticketing::with('client_ticket')
			->where('id_ticket',$request->id_ticket)
			->first()
			->client_ticket
			->client_acronym;

		$activityTicketUpdate->client_acronym_filter = $clientAcronymFilter;
		
		return $activityTicketUpdate;
	}

	public function mailCloseTicket(Request $request){
		
	}

	public function getSettingClient(Request $req){
		$result = DB::table('ticketing__client')
			->where('id','=',$req->id)
			->get();

			// $result[0]->open_to = str_replace(';', '&#13;&#10;',$result[0]->open_to);
			// $result[0]->open_cc = str_replace(';', '&#13;&#10;',$result[0]->open_cc);
			// $result[0]->close_to = str_replace(';', '&#13;&#10;',$result[0]->close_to);
			// $result[0]->close_cc = str_replace(';', '&#13;&#10;',$result[0]->close_cc);

		return $result;
	}

	public function setSettingClient(Request $req){
	
		DB::table('ticketing__client')
			->where('id','=',$req->id)
			->update([
				"client_name" => $req->client_name,
				"client_acronym" => $req->client_acronym,
				"open_dear" => $req->open_dear,
				"open_to" => $req->open_to,
				"open_cc" => $req->open_cc,
				"close_dear" => $req->close_dear,
				"close_to" => $req->close_to,
				"close_cc" => $req->close_cc,
			]);
	}

	

	public function getAllAtmSetting(){
		return array('data' => TicketingATM::join('ticketing__client','ticketing__atm.owner','=','ticketing__client.id')
			->select(
				'ticketing__atm.id',
				DB::raw('`ticketing__client`.`client_acronym` AS `owner`'),
				'ticketing__atm.atm_id',
				'ticketing__atm.serial_number',
				'ticketing__atm.location',
				'ticketing__atm.activation'
			)
			->orderBy('ticketing__atm.id','DESC')
			->get());
	}


	public function getAtmId(Request $request){
		$result = TicketingClient::with('client_atm')
			->where('client_acronym',$request->acronym)
			->first();

		return $result->client_atm->pluck('atm_id');
	}

	public function getAtmDetail(Request $request){
		return TicketingATM::where('atm_id',$request->id_atm)->first();
	}

	public function getParameterAddAtm(){
		return TicketingClient::select('id','client_acronym','client_name')
			->where('banking','=',1)
			->get();
	}

	public function getDetailAtm(Request $request){
		$atm = TicketingATM::where('id',$request->id_atm)->first();

		$client = TicketingClient::select('id','client_acronym','client_name')
			->where('banking','=',1)
			->get();

		return array(
			'atm' => $atm,
			'client' => $client
		);
	}

	public function setAtm(Request $request){
		$setAtm = TicketingATM::where('id','=',$request->idAtm)->first();
		 $messages = [
		    'atmID.unique' => 'The ATM ID has already been taken!',
		    'atmSerial.unique' => 'The Serial Number has already been taken!',
		];

    	$validator = Validator::make($request->all(), [
			'atmID' => Rule::unique('ticketing__atm','atm_id')->ignore($setAtm->id),
			'atmSerial' => Rule::unique('ticketing__atm','serial_number')->ignore($setAtm->id),
        ],$messages);

        if (!$validator->passes()) {
			return response()->json(['error'=>$validator->errors()->all()]);
        }

		$setAtm->fill([
				"owner" => $request->atmOwner,
				"atm_id" => $request->atmID, 
				"serial_number" => $request->atmSerial,
				"location" => $request->atmLocation,
				"address" => $request->atmAddress,
				"activation" =>  Carbon::createFromFormat('d/m/Y',$request->atmActivation)->formatLocalized('%Y-%m-%d'),
				"note" => $request->atmNote,
			]);

		$setAtm->save();

	}

	public function deleteAtm(Request $request){
		TicketingATM::where('id','=',$request->idAtm)->first()->delete();
	}

	public function newAtm(Request $request){
		$newAtm = new TicketingATM();

        $messages = [
		    'atmID.unique' => 'The ATM ID has already been taken!',
		    'atmSerial.unique' => 'The Serial Number has already been taken!',
		    'atmOwner.required' => 'You must select ATM Owner!',
		    'atmLocation.required' => 'You must set ATM Location!',
		    'atmAddress.required' => 'You must select ATM Address!',
		    'atmActivation.required' => 'You must set ATM Activation date!',
		];

    	$validator = Validator::make($request->all(), [
			'atmID' => 'unique:ticketing__atm,atm_id',
			'atmSerial' => 'unique:ticketing__atm,serial_number',
			'atmOwner' => 'required',
			'atmLocation' => 'required',
			'atmAddress' => 'required',
			'atmActivation' => 'required',
        ],$messages);

        if (!$validator->passes()) {
			return response()->json(['error'=>$validator->errors()->all()]);
        }

		$newAtm->fill([
				"owner" => $request->atmOwner,
				"atm_id" => $request->atmID, 
				"serial_number" => $request->atmSerial,
				"location" => $request->atmLocation,
				"address" => $request->atmAddress,
				"activation" =>  Carbon::createFromFormat('d/m/Y',$request->atmActivation)->formatLocalized('%Y-%m-%d'),
				"note" => $request->atmNote,
			]);

		$newAtm->save();

	}

	public function getReport($client){
		$result = DB::table('ticketing__id')
			->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
			// ->limit(1)
			// ->where()
			->get();

		$result2;

		foreach ($result as $key => $value) {
			$temp = explode("/",$value->id_ticket);
			$value->temp = $temp[2];

			if($temp[2] == "Apr"){
				if($temp[1] == $client){
					$open = DB::table('ticketing__activity')
						->where('id_ticket','=',$value->id_ticket)
						->where('activity','=','OPEN')
						->value('date');

					$status = DB::table('ticketing__activity')
						->where('id_ticket','=',$value->id_ticket)
						// ->where('activity','=','CLOSE')
						->orderBy('id','DESC')
						->get();
						// ->value('date');

					$close = DB::table('ticketing__activity')
						->where('id_ticket','=',$value->id_ticket)
						->where('activity','=','CLOSE')
						->value('date');

					$resolve = DB::table('ticketing__resolve')
						->where('id_ticket','=',$value->id_ticket)
						->get();

					$value->activity = array('open' => $open,'close' => $close);
					$value->statu = array($status[0]->activity,$status[0]->date);
					if(!$resolve->isEmpty()){
						$value->resolve = array('root_couse' => $resolve[0]->root_couse,'counter_measure' => $resolve[0]->counter_measure);
					} else {
						$value->resolve = array('root_couse' => ' - ','counter_measure' => ' - ');
					}

					$result2[] = $value;
					
				}

				
			}
		}
		$result = $result2;


		$pdf = new Dompdf();
		$pdf->set_option("isPhpEnabled", true);

		$pdf = PDF::loadView('reportTicket',compact('result'))->setPaper('a1', 'landscape');
		return $pdf->stream("Report Ticket " . date("Y-m-d") . " .pdf");

		// return view('reportTicket',compact('result'));

		// return $result2;
	}

	public function testMasPras(){

		return view('testMasPras');

	}

	public function makeReportTicket(Request $req){
		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$client = TicketingClient::find($req->client)->client_acronym;
		$bulan = Carbon::createFromDate($req->year, $req->month + 1, 1)->format('M');

		// Set document properties
		$title = 'Laporan Bulanan '. $client . ' '. $bulan . " " . $req->year;

		$spreadsheet->getProperties()->setCreator('SIP')
			->setLastModifiedBy('Rama Agastya')
			->setTitle($title);

		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('General');

		// Report Title
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(35);
		$spreadsheet->getActiveSheet()->setCellValue('J2', 'LAPORAN REPORT ' . $client);
		$spreadsheet->getActiveSheet()->getStyle('J2')->getFont()->setName('Calibri');
		$spreadsheet->getActiveSheet()->getStyle('J2')->getFont()->setSize(24);
		$spreadsheet->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('J2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		// Report Month
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(35);
		$spreadsheet->getActiveSheet()->setCellValue('B2', Carbon::createFromDate(2018, $req->month + 1, 1)->format('F'));
		$spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setName('Calibri');
		$spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setSize(24);
		$spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		$Colom_Header = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => Border::BORDER_THIN,
					'color' => ['argb' => 'FF000000'],
				],
			],
			'font' => [
				'name' => 'Calibri',
				'bold' => false,
				'size' => 11,
			],
			'alignment' => [
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			],
			'fill' => [
				'fillType' => Fill::FILL_SOLID,
				'color' => ['argb' => 'FF00B0F0'],
			],
		];

		$border = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => Border::BORDER_THIN,
					'color' => ['argb' => 'FF000000'],
				],
			],
		];

		$cancel_row = [
			'fill' => [
				'fillType' => Fill::FILL_SOLID,
				'color' => ['argb' => 'FFFF0000'],
			],
		];

		$spreadsheet->getActiveSheet()->getStyle('A4:Q4')->applyFromArray($Colom_Header);
		$spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(25);
		
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(60);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(80);
		$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(100);
		$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

		// Colom Header
		$spreadsheet->getActiveSheet(0)
			->setCellValue('A4','NO')
			->setCellValue('B4','ID tiket SIP')
			->setCellValue('C4','ID ATM')
			->setCellValue('D4','LOKASI ')
			->setCellValue('E4','SN ATM')
			->setCellValue('F4','NUMBER TIKET')
			->setCellValue('G4','PROBLEM')
			->setCellValue('H4','TIKET WINCOR')
			->setCellValue('I4','JAM OPEN')
			->setCellValue('J4','TGL. OPEN TIKET')
			->setCellValue('K4','TGL. SELESAI')
			->setCellValue('L4','SELESAI')
			->setCellValue('M4','PIC')
			->setCellValue('N4','NO TLP')
			->setCellValue('O4','ROOTCOSE')
			->setCellValue('P4','CONTERMASURE')
			->setCellValue('Q4','ENGINEER');
		
		$value1 = $this->getPerformanceByFinishTicket($client,$bulan . "/" . $req->year);
		// return $value1;

		foreach ($value1 as $key => $value) {
			$spreadsheet->getActiveSheet()->getStyle('A' . (5 + $key))->applyFromArray($Colom_Header);
			$spreadsheet->getActiveSheet()->getStyle('B' . (5 + $key) .  ':Q' . (5 + $key))->applyFromArray($border);
			$spreadsheet->getActiveSheet()->setCellValue('A' . (5 + $key),$key + 1);
			$spreadsheet->getActiveSheet()->setCellValue('B' . (5 + $key),$value->id_ticket);
			$spreadsheet->getActiveSheet()->setCellValue('C' . (5 + $key),$value->id_atm);
			$spreadsheet->getActiveSheet()->setCellValue('D' . (5 + $key),$value->location);
			$spreadsheet->getActiveSheet()->setCellValue('E' . (5 + $key),$value->serial_device);
			$spreadsheet->getActiveSheet()->setCellValue('F' . (5 + $key),$value->refrence);
			$spreadsheet->getActiveSheet()->setCellValue('G' . (5 + $key),$value->problem);
			$spreadsheet->getActiveSheet()->setCellValue('H' . (5 + $key),$value->ticket_number_3party);
			if($value->open == NULL){
				// $spreadsheet->getActiveSheet()->setCellValue('I' . (5 + $key),"NULL");
				// $spreadsheet->getActiveSheet()->setCellValue('J' . (5 + $key),"NULL");
				if($value->reporting_time != "Invalid date"){
					$spreadsheet->getActiveSheet()->setCellValue('I' . (5 + $key),date_format(date_create($value->reporting_time),'G:i:s'));
					$spreadsheet->getActiveSheet()->setCellValue('J' . (5 + $key),date_format(date_create($value->reporting_time),'d F Y'));
				}
			} else {
				$spreadsheet->getActiveSheet()->setCellValue('I' . (5 + $key),date_format(date_create($value->open),'G:i:s'));
				$spreadsheet->getActiveSheet()->setCellValue('J' . (5 + $key),date_format(date_create($value->open),'d F Y'));
			}
			if($value->lastest_activity_ticket->activity == "CANCEL"){
				$spreadsheet->getActiveSheet()->setCellValue('K' . (5 + $key),'-');
				$spreadsheet->getActiveSheet()->setCellValue('L' . (5 + $key),'-');
				$spreadsheet->getActiveSheet()->getStyle('B' . (5 + $key) .  ':Q' . (5 + $key))->applyFromArray($cancel_row);
			} else {
				$spreadsheet->getActiveSheet()->setCellValue('K' . (5 + $key),date_format(date_create($value->lastest_activity_ticket->date),'G:i:s'));
				$spreadsheet->getActiveSheet()->setCellValue('L' . (5 + $key),date_format(date_create($value->lastest_activity_ticket->date),'d F Y'));
				if(isset($value->resolve)){
					$spreadsheet->getActiveSheet()->setCellValue('O' . (5 + $key),$value->resolve->root_couse);
					$spreadsheet->getActiveSheet()->setCellValue('P' . (5 + $key),$value->resolve->counter_measure);
				}
			}
			$spreadsheet->getActiveSheet()->setCellValue('M' . (5 + $key),$value->pic);
			$spreadsheet->getActiveSheet()->setCellValue('N' . (5 + $key),$value->contact_pic);
			$spreadsheet->getActiveSheet()->setCellValue('Q' . (5 + $key),$value->engineer);
			// $spreadsheet->getActiveSheet()->setCellValue('R' . (5 + $key),$value->id_ticket);
		}

		


		// $total = 16;
		// $activity = [
		// 	"Avability (%)",
		// 	"Respon Time (ms)",
		// 	"Packet Loss (%)",
		// 	"CPU (%)",
		// 	"Memory (%)",
		// 	"Packet Size (%)",
		// ];
		// for($i = 0;$i < $total;$i++){
		// 	$spreadsheet->setActiveSheetIndex(0)
		// 		->setCellValue('A' . (($i * 6) + 7),$i+1);

		// 	$spreadsheet->setActiveSheetIndex(0)
		// 		->setCellValue('B' . (($i * 6) + 3),$i);

		// 	$spreadsheet->getActiveSheet()->mergeCells('A' . (($i * 6) + 7) . ':A' . ((($i * 6) + 7) + 5));
		// 	$spreadsheet->getActiveSheet()->getStyle('A' . (($i * 6) + 7))->applyFromArray($stye1);
		// 	$spreadsheet->getActiveSheet()->getStyle('A' . (($i * 6) + 7))->applyFromArray($stye2);

		// 	for($j = 0;$j < 6;$j++){
		// 		$spreadsheet->setActiveSheetIndex(0)
		// 			->setCellValue('C' . ((($i * 6) + 7) + $j), $activity[$j]);
		// 		$spreadsheet->getActiveSheet()->getStyle('C' . ((($i * 6) + 7) + $j))->applyFromArray($stye1);
		// 		$spreadsheet->getActiveSheet()->getRowDimension(((($i * 6) + 7) + $j))->setRowHeight(18);

		// 	}

		// }

		
		
		$spreadsheet->createSheet(1)->setTitle('Summary');
		$spreadsheet->setActiveSheetIndex(1);

		$Colom_Header2 = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => Border::BORDER_THIN,
					'color' => ['argb' => 'FF000000'],
				],
			],
			'font' => [
				'name' => 'Calibri',
				'bold' => TRUE,
				'size' => 11,
			],
			'alignment' => [
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical' => Alignment::VERTICAL_CENTER,
			]
		];

		$spreadsheet->getActiveSheet()
			->setCellValue('B5','No')
			->setCellValue('C5','ID ATM')
			->setCellValue('D5','LOKASI ATM')
			->setCellValue('E5','PERIODE BULAN')
			->setCellValue('I5','TOTAL DATA CORECTIVE (JAM) ')
			->setCellValue('J5','JUMLAH OPERASIONAL')
			->setCellValue('K5','SLA')

			->setCellValue('E6','AWAL')
			->setCellValue('F6','PERIODE PROBLEM')
			->setCellValue('H6','AKHIR')
			;

		$spreadsheet->getActiveSheet()->getStyle("I5")->getAlignment()->setWrapText(true);
		$spreadsheet->getActiveSheet()->getStyle("J5")->getAlignment()->setWrapText(true);

		$value1 = $this->getPerformance5($client,$bulan . "/" . $req->year);

		$middle = [
			'alignment' => [
				'horizontal' => Alignment::HORIZONTAL_LEFT,
				'vertical' => Alignment::VERTICAL_CENTER,
			]
		];

		$index = 0;

		// $atm_id = $value1[0]->id_atm;
		$atm_id = "";
		$repeat = 0;
		foreach ($value1 as $key => $value) {
			if($value->last_status[0] == "CLOSE"){
				

				$spreadsheet->getActiveSheet()->getStyle('B' . (7 + $index))->getFill()->setFillType(Fill::FILL_SOLID);
				$spreadsheet->getActiveSheet()->getStyle('B' . (7 + $index))->getFill()->getStartColor()->setARGB('FF2E75B6');
				$spreadsheet->getActiveSheet()->getStyle('B' . (7 + $index) .  ':K' . (7 + $index))->applyFromArray($border);
				$spreadsheet->getActiveSheet()->setCellValue('B' . (7 + $index),$index + 1);
				$spreadsheet->getActiveSheet()->setCellValue('D' . (7 + $index),$value->location);
				$spreadsheet->getActiveSheet()->setCellValue('E' . (7 + $index),date_format(date_create($bulan),"01/m/Y"));
				$spreadsheet->getActiveSheet()->setCellValue('F' . (7 + $index),date_format(date_create($value->open),'d/m/Y h:i A'));
				$spreadsheet->getActiveSheet()->setCellValue('G' . (7 + $index),date_format(date_create($value->last_status[1]),'d/m/Y h:i A'));
				$spreadsheet->getActiveSheet()->setCellValue('H' . (7 + $index),date_format(date_create($bulan),"t/m/Y"));
				
				$close_ticket_time = (int)strtotime($value->last_status[1]);
				$open_ticket_time = (int)strtotime($value->open);
				if ($close_ticket_time > $open_ticket_time){
					if($open_ticket_time == NULL){
						$operasional = round(($close_ticket_time - (int)strtotime($value->reporting_time))/3600,2);
					} else {
						$operasional = round(($close_ticket_time - $open_ticket_time)/3600,2);
					}
				} else {
					if($open_ticket_time == NULL){
						$operasional = round(((int)strtotime($value->reporting_time) - $close_ticket_time)/3600,2);
					} else {
						$operasional = round(($open_ticket_time - $close_ticket_time)/3600,2);
					}
				}

				$spreadsheet->getActiveSheet()->setCellValue('I' . (7 + $index),$operasional);
				$spreadsheet->getActiveSheet()->setCellValue('J' . (7 + $index),(int)date_format(date_create($bulan),"t") * 24);
				$sla_result = 100 - round(($operasional / ((int)date_format(date_create($bulan),"t") * 24)) * 100 , 2);
				$spreadsheet->getActiveSheet()->setCellValue('K' . (7 + $index),($sla_result < 0 ? 0 : $sla_result));
				
				if($client != "TTNI"){
					$spreadsheet->getActiveSheet()->setCellValue('C' . (7 + $index),$value->id_atm);
					$spreadsheet->getActiveSheet()->setCellValue('C' . (7 + $index),$value->id_atm);
					if($atm_id == $value->id_atm){
						$atm_id = $atm_id;
						$repeat++;
					} else {
						// $spreadsheet->getActiveSheet()->getStyle('C' . (7 + $index))->getFill()->setFillType(Fill::FILL_SOLID);
						// $spreadsheet->getActiveSheet()->getStyle('C' . (7 + $index))->getFill()->getStartColor()->setARGB('FFFF0000');
						if($repeat != 0){
							// $spreadsheet->getActiveSheet()->getStyle('C' . ((6 + $index) - $repeat))->getFill()->setFillType(Fill::FILL_SOLID);
							// $spreadsheet->getActiveSheet()->getStyle('C' . ((6 + $index) - $repeat))->getFill()->getStartColor()->setARGB('FF00FF00');
							$spreadsheet->getActiveSheet()->mergeCells('C' . ((6 + $index) - $repeat) . ':C' . (((6 + $index) - $repeat) + $repeat));
							$spreadsheet->getActiveSheet()->mergeCells('D' . ((6 + $index) - $repeat) . ':D' . (((6 + $index) - $repeat) + $repeat));
							$spreadsheet->getActiveSheet()->getStyle('C' . ((6 + $index) - $repeat) . ':C' . (((6 + $index) - $repeat) + $repeat))->applyFromArray($middle);
							$spreadsheet->getActiveSheet()->getStyle('D' . ((6 + $index) - $repeat) . ':D' . (((6 + $index) - $repeat) + $repeat))->applyFromArray($middle);
						}

						$repeat = 0;
						$atm_id = $value->id_atm;
					}
				} else {
					$spreadsheet->getActiveSheet()->setCellValue('C' . (7 + $index),'-');
					$spreadsheet->getActiveSheet()->setCellValue('C' . (7 + $index),'-');
				}

				$index++;
			}
		}

		$bold = [
			'font' => [
				'name' => 'Calibri',
				'bold' => TRUE,
				'size' => 11,
			]
		];

		$spreadsheet->getActiveSheet()->getStyle('J' . (7 + $index) .  ':K' . (7 + $index))->applyFromArray($border);
		$spreadsheet->getActiveSheet()->getStyle('J' . (7 + $index) .  ':K' . (7 + $index))->applyFromArray($bold);
		$spreadsheet->getActiveSheet()->setCellValue('J' . (7 + $index),"TOTAL");
		$spreadsheet->getActiveSheet()->setCellValue('K' . (7 + $index),"=ROUND(AVERAGE(K7:K" . (6 + $index) . "),3)");

		// echo (int)strtotime($value1[0]->open) . "<br>";
		// echo (int)strtotime($value1[0]->last_status[1]) . "<br>";
		// echo ((int)strtotime($value1[0]->last_status[1]) - (int)strtotime($value1[0]->open)) . "<br>";
		// echo round(((int)strtotime($value1[0]->last_status[1]) - (int)strtotime($value1[0]->open))/3600,2) . "<br>";

		$spreadsheet->getActiveSheet()->getStyle('E5')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('E5')->getFill()->getStartColor()->setARGB('FF2E75B6');

		$spreadsheet->getActiveSheet()->getStyle('E6')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('E6')->getFill()->getStartColor()->setARGB('FFFF0000');

		$spreadsheet->getActiveSheet()->getStyle('F6')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('F6')->getFill()->getStartColor()->setARGB('FFFFFF00');

		$spreadsheet->getActiveSheet()->getStyle('H6')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('H6')->getFill()->getStartColor()->setARGB('FF00B050');

		$spreadsheet->getActiveSheet()->getStyle('B5:K6')->applyFromArray($Colom_Header2);

		$spreadsheet->getActiveSheet()->mergeCells('B5:B6');
		$spreadsheet->getActiveSheet()->mergeCells('C5:C6');
		$spreadsheet->getActiveSheet()->mergeCells('D5:D6');
		$spreadsheet->getActiveSheet()->mergeCells('E5:H5');
		$spreadsheet->getActiveSheet()->mergeCells('I5:I6');
		$spreadsheet->getActiveSheet()->mergeCells('J5:J6');
		$spreadsheet->getActiveSheet()->mergeCells('K5:K6');
		$spreadsheet->getActiveSheet()->mergeCells('F6:G6');

		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);

		$spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(20);


		


		$spreadsheet->setActiveSheetIndex(1);
		$spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(98);

		// Redirect output to a client’s web browser (Xlsx)
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
		// header('Cache-Control: max-age=0');
		// // If you're serving to IE 9, then the following may be needed
		// header('Cache-Control: max-age=1');

		// // If you're serving to IE over SSL, then the following may be needed
		// header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		// header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		// header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		// header('Pragma: public'); // HTTP/1.0
		


		$name = 'Report_' . $client . '_-_' . Carbon::createFromDate( $req->year , $req->month + 1, 1)->format('F-Y') . '_(' . date("Y-m-d") . ')_' . Auth::user()->nickname . '.xlsx';
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('report/' . $name);
		return $name;
		// return response()->download($name);

		// return $value1;

	}

	public function downloadReportTicket(Request $req){
		return redirect($_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER['HTTP_HOST'] . "/download.php?nameFile=" . $req->name);
	}


	// public function controll(){
	// 	$user = DB::table('users')
	// 		->get();
	// 	return view('controllPage');
	// }

	public function testEmail1(){
		return view('testEmail');
	}

	public function testUpload(Request $request){
		// echo "image " . $request->data;
		// $fp = fopen('img/'.$request->name,'w');
		// fwrite($fp, $request->data);
		// fclose($fp);

		
		// $fileName = $request->name;
		// $request->file('data')->move("img/", $fileName);

		$output_file = $request->fileName;
		$ifp = fopen( "img/" . $output_file, 'w' ); 
		$data = explode( ',', $request->data );
		fwrite( $ifp, base64_decode( $data[ 1 ] ) );
		fclose( $ifp ); 
	}

	public function getReportParameter(){
		return array(
			'client_data' => TicketingClient::select('id','client_acronym','client_name')
				->where('situation','=','1')
				->get(),
			'ticket_year' => DB::table('ticketing__detail')
				->selectRaw("SUBSTRING_INDEX(`id_ticket`, '/', -1) AS `year`")
				->orderBy('year','DESC')
				->groupBy('year')
				->get()
			);
	}

	public function controll(){
		// echo "asdfasdf";
		if(Auth::user()->id == 4 || Auth::user()->id == 6){
			return view('tisygyControll');
		}
	}

}
