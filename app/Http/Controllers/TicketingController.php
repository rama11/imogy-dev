<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Mail;
use App\Mail\TicketMail;
use PHPMailer\PHPMailer;
use PDF;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TicketingController extends Controller
{


	public function __construct(){
		$this->middleware('auth');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tisygy(){

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

		// $var = "imogy@sinergy.co.id;endraw@sinergy.co.id;bsb_ts_atm@banksumselbabel.com;wisnu.darman@sinergy.co.id;juliusdeddy.darmawan@wincor-nixdorf.com;dimas.widyawan@services-division.com;doni.syufri.ext@wincor-nixdorf.com;juni.ibrahim@services-division.com;eko.qualita@gmail.com;umar.holik@banksumselbabel.com;rudi.partono@banksumselbabel.com;evi.kamal@banksumselbabel.com;jimy.mandoza@banksumselbabel.com;chairullah@banksumselbabel.com;bambang.nugroho@banksumselbabel.com;jauhari@banksumselbabel.com;sandy.perwira@banksumselbabel.com;rahmat.deli@banksumselbabel.com; heru.muharam@banksumselbabel.com;rahmad.deli@banksumselbabel.com;wisnu.aji@banksumselbabel.com; saptono@banksumselbabel.com; kui.ciong@banksumselbabel.com; jauhari.johan@banksumselbabel.com; purwaningsih@banksumselbabel.com;";
		// echo str_replace(';', '<br>', $var);
		// echo "<br>";
		// echo str_replace(';', '<br>',$clients[1]->open_cc);
		// echo "<br>";
		// echo $clients[1]->open_cc;

		return view('tisygy',compact('clients','atms'));
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

	public function getDashboard(Request $request){
		$result = DB::table('ticketing__id')
			->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
			->get();
		
		$result2 = DB::table('ticketing__activity')
			->select('activity',DB::raw("count(*) as count"))
			->whereIn('id',function ($query) {
					$query->select(DB::raw("MAX(id) AS activity"))
						->from('ticketing__activity')
						->groupBy('id_ticket');
				})
			->groupBy('activity')
			->get();

		if(!strpos($result2,"OPEN")){
			// $result2[] = (object)["activity"=>"OPEN","count"=>0];
		}
		if(!strpos($result,"PENDING")){
			// $result2[] = (object)["activity"=>"PENDING","count"=>0];
		}
		
		$count = [0,0,0,0,0,0];

		foreach ($result2 as $key => $value) {
			if($value->activity == "OPEN"){
				$count[0] = $value->count;
			} else if ($value->activity == "ON PROGRESS") {
				$count[1] = $value->count;
			} else if ($value->activity == "PENDING") {
				$count[2] = $value->count;
			} else if ($value->activity == "CLOSE") {
				$count[3] = $value->count;
			} else if ($value->activity == "CANCEL") {
				$count[4] = $value->count;
			}
		}
		$count[5] = $count[0] + $count[1] + $count[2] + $count[3] + $count[4];

		$get_client = DB::table('ticketing__client')
			->select('id','client_name','client_acronym')
			->get();

		// $count_client = DB::table('ticketing__id')
		// 	->select(DB::raw('id_client,COUNT(*)'))
		// 	->groupBy("id_client")
		// 	->get();

		$needed = DB::table('ticketing__detail')
			->select('ticketing__detail.severity','ticketing__detail.id_ticket','ticketing__detail.id_atm','ticketing__detail.location','aaa.operator','aaaa.date')
			->join(DB::raw("(SELECT `ticketing__activity`.`operator`,`ticketing__activity`.`id_ticket`
							FROM `ticketing__activity`
							JOIN (
								SELECT MAX(id) AS activity 
								FROM `ticketing__activity` 
								GROUP by `id_ticket`
							) AS aa
							ON `ticketing__activity`.`id` = aa.`activity`
							WHERE `ticketing__activity`.`activity` <> 'CLOSE' and `ticketing__activity`.`activity` <> 'CANCEL'
						) AS aaa"),"ticketing__detail.id_ticket","=","aaa.id_ticket")
			->join(DB::raw("(SELECT `ticketing__activity`.`date`,`ticketing__activity`.`id_ticket`
							FROM `ticketing__activity`
							JOIN (
								SELECT MIN(id) AS activity 
								FROM `ticketing__activity` 
								GROUP by `id_ticket`
							) AS aa
							ON `ticketing__activity`.`id` = aa.`activity`
							WHERE `ticketing__activity`.`activity` <> 'CLOSE' and `ticketing__activity`.`activity` <> 'CANCEL'
						) AS aaaa"),"ticketing__detail.id_ticket","=","aaaa.id_ticket")
			->where('ticketing__detail.severity','<>',0)
			->orderBy('ticketing__detail.severity','ASC')
			->get();

		$severity_count = DB::table('ticketing__detail')
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

		$client = [];
		$count_ticket = [];
		foreach ($get_client as $value) {
			$client[] = $value->client_acronym;
			$temp = 0;
			foreach ($result as $value2) {
				if($value2->id_client == $value->id){
					$temp++;
				}
			}
			$count_ticket[] = $temp;
		}

		return array($count,$client,$count_ticket,$needed,$severity_count);
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


	public function getCreateParameter(){
		
		$get_client = DB::table('ticketing__client')
			->select('id','client_acronym')
			->get();

		$get_severity = DB::table('ticketing__severity')
			->select('id','name','description')
			->get();

		$client = [];
		foreach ($get_client as $value) {
			$client[] = $value->client_acronym;
		}

		$severity_id = [];
		foreach ($get_severity as $value) {
			$severity_id[] = $value->id;
		}

		$severity_name = [];
		foreach ($get_severity as $value) {
			$severity_name[] = $value->name;
		}

		$severity_description = [];
		foreach ($get_severity as $value) {
			$severity_description[] = $value->description;
		}

		return array($client,$severity_id,$severity_name,$severity_description);
	}

	public function createIdTicket(){

		// DB::table('ticketing__id')
		// 	->insert(['id' => NULL]);

		$id = DB::table('ticketing__id')
			->orderBy('id','DESC')
			// ->get()
			->value('id');
			
		return $id + 1;
	}

	public function updateIdTicket(Request $req){
		
		$req->id_client = DB::table('ticketing__client')
			->where('client_acronym','=',$req->id_client)
			->value('id');

		DB::table('ticketing__id')
			->insert([
				'id' => $req->id,
				'id_ticket' => $req->id_ticket,
				'id_client' => $req->id_client,
				'operator' => $req->operator,
			]);
			// ->where('id','=',$req->id)
			// ->update(['id_ticket' => $req->id_ticket, 'id_client' => $id_client]);
		
	}

	public function setNewTicket(Request $req){
		$id_client = DB::table('ticketing__client')
			->where('client_acronym','=',$req->client)
			->value('id');


		date_default_timezone_set("Asia/Jakarta");

		DB::table('ticketing__detail')
			->insert([
				"id_ticket" => $req->id_ticket,
				"id_atm" => $req->id_atm,
				"refrence" => $req->refrence,
				"pic" => $req->pic,
				"contact_pic" => $req->contact_pic,
				"location" => $req->location,
				"problem" => $req->problem,
				"serial_device" => $req->serial_device,
				"note" => $req->note,
				"reporting_time" => $req->report,
				"severity" => substr($req->severity,0,1)
			]);

		DB::table('ticketing__activity')
			->insert([
				"id_ticket" => $req->id_ticket,
				"date" => date("Y-m-d H:i:s.000000"),
				"activity" => "OPEN",
				"operator" => Auth::user()->nickname,
				"note" => "Open Ticket"
			]);

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
			$result = DB::table('ticketing__client')
				->where('client_acronym','=',$req->client)
				->get()
				->toArray();
				// ->first();
		}
		return $result;

	}

	public function mailOpenTicket(Request $request){
		$mail = new PHPMailer\PHPMailer(true);
		
		// Yandex Configuration
		// $mail_host = env("YANDEX_MAIL_HOST");
		// $mail_port = env("YANDEX_MAIL_PORT");
		// $mail_user = env("YANDEX_MAIL_USERNAME");
		// $mail_pass = env("YANDEX_MAIL_PASSWORD");
		// $mail_auth = env("YANDEX_MAIL_ENCRYPTION");
		// $mail_from = env("YANDEX_MAIL_FROM");
		// $mail_name = env("YANDEX_MAIL_NAME");

		// Gmail Configuration
		$mail_host = env("GMAIL_MAIL_HOST");
		$mail_port = env("GMAIL_MAIL_PORT");
		$mail_user = env("GMAIL_MAIL_USERNAME");
		$mail_pass = env("GMAIL_MAIL_PASSWORD");
		$mail_auth = env("GMAIL_MAIL_ENCRYPTION");
		$mail_from = env("GMAIL_MAIL_FROM");
		$mail_name = env("GMAIL_MAIL_NAME");

		try {
			$mail->isSMTP();
			$mail->CharSet = "UTF-8";
			$mail->SMTPAuth = true;

			$mail->Host = $mail_host;
			$mail->Port = $mail_port;
			$mail->Username = $mail_user;
			$mail->Password = $mail_pass;
			$mail->SMTPSecure = $mail_auth;
			$mail->SetFrom($mail_from, $mail_name);

			$mail->Subject =  $request->subject;
			$mail->MsgHTML($request->body);

			$to = explode(";", $request->to);
			$cc = explode(";", $request->cc);
			
			foreach ($to as $key => $value) {
				if($to[$key] != NULL)
					$to[$key] = trim($value," ");
				echo trim($value," ") . "<br>";
			}

			foreach ($cc as $key => $value) {
				if($cc[$key] != "")
					$cc[$key] = trim($value," ");
				echo trim($value," ") . "<br>";
			}


			$to = array_slice($to,0,sizeof($to) - 1);
			$cc = array_slice($cc,0,sizeof($cc) - 1);

			for($i = 0;$i < sizeof($to);$i++){
				$mail->addAddress($to[$i]);
			}

			for($i = 0;$i < sizeof($cc);$i++){
				$mail->addCC($cc[$i]);
			}
			$mail->send();
		} catch (phpmailerException $e) {
			DB::table('email_error')
				->insert([
					"id" => $request->id_ticket,
					"email_to" => $request->to,
					"email_cc" => $request->cc,
					"email_subject" => $request->subject,
					"email_body" => $request->body,
					"email_type" => "OPEN"
				]);
			dd($e);
		} catch (Exception $e) {
			dd($e);
		}
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

	public function getPerformance3($acronym_client,$period){
		$id_client = DB::table('ticketing__client')
			->where('client_acronym','=',$acronym_client)
			->value('id');

		$result = DB::table('ticketing__id')
			->where('ticketing__id.id_client','=',$id_client)
			->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
			// ->join('ticketing__resolve','ticketing__resolve.id_ticket','=','ticketing__id.id_ticket')
			->orderBy('ticketing__id.id','ASC')
			// ->limit()
			->get();

		$result2 = [];

		foreach ($result as $key => $value) {
			$temp = explode("/",$value->id_ticket);
			$value->temp = $temp[2];

			$check = DB::table('ticketing__activity')
				->where('id_ticket','=',$value->id_ticket)
				->orderBy('id','DESC')
				->value('activity');


			if($value->temp == $period){
				if($check == "CLOSE" || $check == "CANCEL"){
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

					$result2[] = $value;
				}
			}
		}

		$result = $result2;

		return $result;
	}

	public function getPerformanceBySeverity(Request $req){

		$result = DB::table('ticketing__detail')
			->select(
					'ticketing__detail.id',
					'ticketing__detail.id_ticket',
					'ticketing__id.id_client',
					'aaa.operator',
					'ticketing__detail.refrence',
					'ticketing__detail.pic',
					'ticketing__detail.contact_pic',
					'ticketing__detail.location',
					'ticketing__detail.problem',
					'ticketing__detail.serial_device',
					'ticketing__detail.id_atm',
					'aaa.note',
					'ticketing__detail.engineer',
					'ticketing__detail.ticket_number_3party',
					'ticketing__detail.reporting_time',
					'ticketing__detail.severity',
					DB::raw('aaaa.`date` AS "open"'),
					DB::raw('ticketing__id.`id` AS "id_open"')
					// 'ticketing__detail.severity',
				)
			->join('ticketing__id','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
			->join(DB::raw("(SELECT `ticketing__activity`.`operator`,`ticketing__activity`.`id_ticket`,`ticketing__activity`.`note`
							FROM `ticketing__activity`
							JOIN (
								SELECT MAX(id) AS activity 
								FROM `ticketing__activity` 
								GROUP by `id_ticket`
							) AS aa
							ON `ticketing__activity`.`id` = aa.`activity`
						) AS aaa"),"ticketing__detail.id_ticket","=","aaa.id_ticket")
			->join(DB::raw("(SELECT `ticketing__activity`.`operator`,`ticketing__activity`.`id_ticket`,`ticketing__activity`.`date`
							FROM `ticketing__activity`
							JOIN (
								SELECT MIN(id) AS activity 
								FROM `ticketing__activity` 
								GROUP by `id_ticket`
							) AS bb
							ON `ticketing__activity`.`id` = bb.`activity`
						) AS aaaa"),"ticketing__detail.id_ticket","=","aaaa.id_ticket")
			->where('ticketing__detail.severity','=',$req->severity)
			->get();

			foreach ($result as $key => $value) {
				$value->last_status = array(
				DB::table('ticketing__activity')
					->where('id_ticket','=',$value->id_ticket)
					->orderBy('id','DESC')
					->value('activity'),
				DB::table('ticketing__activity')
					->where('id_ticket','=',$value->id_ticket)
					->orderBy('date','DESC')
					->value('date')
				);
			}

		return $result;
	}

	public function getPerformanceByClient(Request $request){
		// echo "Client : " . $request->client;
		$result = DB::table('ticketing__detail')
			->select(
					'ticketing__detail.id',
					'ticketing__detail.id_ticket',
					'ticketing__id.id_client',
					'aaa.operator',
					'ticketing__detail.refrence',
					'ticketing__detail.pic',
					'ticketing__detail.contact_pic',
					'ticketing__detail.location',
					'ticketing__detail.problem',
					'ticketing__detail.serial_device',
					'ticketing__detail.id_atm',
					'aaa.note',
					'ticketing__detail.engineer',
					'ticketing__detail.ticket_number_3party',
					'ticketing__detail.reporting_time',
					'ticketing__detail.severity',
					DB::raw('aaaa.`date` AS "open"'),
					DB::raw('ticketing__id.`id` AS "id_open"')
					// 'ticketing__detail.severity',
				)
			->join('ticketing__id','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
			->join(DB::raw("(SELECT `ticketing__activity`.`operator`,`ticketing__activity`.`id_ticket`,`ticketing__activity`.`note`
							FROM `ticketing__activity`
							JOIN (
								SELECT MAX(id) AS activity 
								FROM `ticketing__activity` 
								GROUP by `id_ticket`
							) AS aa
							ON `ticketing__activity`.`id` = aa.`activity`
						) AS aaa"),"ticketing__detail.id_ticket","=","aaa.id_ticket")
			->join(DB::raw("(SELECT `ticketing__activity`.`operator`,`ticketing__activity`.`id_ticket`,`ticketing__activity`.`date`
							FROM `ticketing__activity`
							JOIN (
								SELECT MIN(id) AS activity 
								FROM `ticketing__activity` 
								GROUP by `id_ticket`
							) AS bb
							ON `ticketing__activity`.`id` = bb.`activity`
						) AS aaaa"),"ticketing__detail.id_ticket","=","aaaa.id_ticket");

		$result = $result->where('ticketing__id.id_ticket','LIKE','%' . $request->client . '%')
			->get();

		return $result;
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

	public function getPerformance($id = 0){
		if($id == 0){
			$result = DB::table('ticketing__id')
				->orderBy('ticketing__id.id','DESC')
				->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
				->take(50)
				->get();
		} else {
			$result = DB::table('ticketing__id')
				->where('ticketing__id.id','=',$id)
				->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
				->take(100)
				->get();
		}

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
				->orderBy('date','DESC')
				->value('date')
			);

			$value->operator = DB::table('ticketing__activity')
				->where('id_ticket','=',$value->id_ticket)
				->orderBy('id','DESC')
				->value('operator');
		}

		return $result;
			
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

	public function updateTicket(Request $req){
		// echo $req->engineer . "<br>";
		// echo $req->ticket_number_3party . "<br>";

		$result = DB::table('ticketing__detail')
			->where('id_ticket','=',$req->id_ticket)
			->update([
				"engineer" => $req->engineer,
				"ticket_number_3party" => $req->ticket_number_3party,
			]);


		$update = DB::table('ticketing__activity')
			->insert([
				"id_ticket" => $req->id_ticket,
				"date" => date("Y-m-d H:i:s.000000"),
				"activity" => "ON PROGRESS",
				"operator" => Auth::user()->nickname,
				"note" => $req->note
			]);
			// ->get();

		$result = DB::table('ticketing__detail')
			->where('id_ticket','=',$req->id_ticket)
			// ->update([
			// 	"engineer" => $req->engineer,
			// 	"ticket_number_3party" => $req->ticket_number_3party,
			// ]);
			->get();

		$result = DB::table('ticketing__id')
			->where('ticketing__id.id_ticket','=',$req->id_ticket)
			->join('ticketing__client','ticketing__client.id','=','ticketing__id.id_client')
			->value('ticketing__client.client_acronym');

		return $result;

		// echo "<pre>";
		// print_r($result);
		// echo "</pre>";
	}

	public function closeTicket(Request $request){
		$mail = new PHPMailer\PHPMailer(true);
		
		// Yandex Configuration
		$mail_host = env("YANDEX_MAIL_HOST");
		$mail_port = env("YANDEX_MAIL_PORT");
		$mail_user = env("YANDEX_MAIL_USERNAME");
		$mail_pass = env("YANDEX_MAIL_PASSWORD");
		$mail_auth = env("YANDEX_MAIL_ENCRYPTION");
		$mail_from = env("YANDEX_MAIL_FROM");
		$mail_name = env("YANDEX_MAIL_NAME");

		// Gmail Configuration
		// $mail_host = env("GMAIL_MAIL_HOST");
		// $mail_port = env("GMAIL_MAIL_PORT");
		// $mail_user = env("GMAIL_MAIL_USERNAME");
		// $mail_pass = env("GMAIL_MAIL_PASSWORD");
		// $mail_auth = env("GMAIL_MAIL_ENCRYPTION");
		// $mail_from = env("GMAIL_MAIL_FROM");
		// $mail_name = env("GMAIL_MAIL_NAME");

		try {
			$mail->isSMTP();
			$mail->CharSet = "UTF-8";
			$mail->SMTPAuth = true;

			$mail->Host = $mail_host;
			$mail->Port = $mail_port;
			$mail->Username = $mail_user;
			$mail->Password = $mail_pass;
			$mail->SMTPSecure = $mail_auth;
			$mail->SetFrom($mail_from, $mail_name);
			
			$mail->Subject =  $request->subject;
			$mail->MsgHTML($request->body);

			$to = explode(";", $request->to);
			$cc = explode(";", $request->cc);
			
			foreach ($to as $key => $value) {
				if($to[$key] != NULL)
					$to[$key] = trim($value," ");
				// echo trim($value," ") . "<br>";
			}

			foreach ($cc as $key => $value) {
				if($cc[$key] != "")
					$cc[$key] = trim($value," ");
				// echo trim($value," ") . "<br>";
			}


			$to = array_slice($to,0,sizeof($to) - 1);
			$cc = array_slice($cc,0,sizeof($cc) - 1);

			for($i = 0;$i < sizeof($to);$i++){
				$mail->addAddress($to[$i]);
			}

			for($i = 0;$i < sizeof($cc);$i++){
				$mail->addCC($cc[$i]);
			}

			$mail->send();

			$update = DB::table('ticketing__activity')
				->insert([
					"id_ticket" => $request->id_ticket,
					"date" => $request->finish,
					"activity" => "CLOSE",
					"operator" => Auth::user()->nickname,
					"note" => "Close Ticket"
				]);

			// echo $request->finish . "<br>";
			// echo $request->finish . "<br>";
			// echo date("Y-m-d H:i:s.000000") . "<br>";

			$close = DB::table('ticketing__resolve')
				->insert([
					"id_ticket" => $request->id_ticket,
					"root_couse" => $request->root_cause,
					"counter_measure" => $request->couter_measure,
					"finish" => date("Y-m-d H:i:s.000000"),
					// "operator" => Auth::user()->nickname,
					// "note" => "note"
				]);

			$result = DB::table('ticketing__id')
				->where('ticketing__id.id_ticket','=',$request->id_ticket)
				->join('ticketing__client','ticketing__client.id','=','ticketing__id.id_client')
				->value('ticketing__client.client_acronym');


			return $result;

		} catch (phpmailerException $e) {
			DB::table('email_error')
				->insert([
					"id" => $request->id_ticket,
					"email_to" => $request->to,
					"email_cc" => $request->cc,
					"email_subject" => $request->subject,
					"email_body" => $request->body,
					"email_type" => "CLOSE"
				]);
			dd($e);
		} catch (Exception $e) {
			dd($e);
		}
	}

	public function attachmentCloseTicket(Request $request){
		// $file = $request->attachment;
		if(isset($req->attachment)){
			$file = $request->file('attachment');
			$fileName = $file->getClientOriginalName();
			$request->file('attachment')->move("attachment/close/", $fileName);
		}
	}

	public function pendingTicket(Request $request){
		$mail = new PHPMailer\PHPMailer(true);
		
		// Yandex Configuration
		$mail_host = env("YANDEX_MAIL_HOST");
		$mail_port = env("YANDEX_MAIL_PORT");
		$mail_user = env("YANDEX_MAIL_USERNAME");
		$mail_pass = env("YANDEX_MAIL_PASSWORD");
		$mail_auth = env("YANDEX_MAIL_ENCRYPTION");
		$mail_from = env("YANDEX_MAIL_FROM");
		$mail_name = env("YANDEX_MAIL_NAME");

		// Gmail Configuration
		// $mail_host = env("GMAIL_MAIL_HOST");
		// $mail_port = env("GMAIL_MAIL_PORT");
		// $mail_user = env("GMAIL_MAIL_USERNAME");
		// $mail_pass = env("GMAIL_MAIL_PASSWORD");
		// $mail_auth = env("GMAIL_MAIL_ENCRYPTION");
		// $mail_from = env("GMAIL_MAIL_FROM");
		// $mail_name = env("GMAIL_MAIL_NAME");

		try {
			$mail->isSMTP();
			$mail->CharSet = "UTF-8";
			$mail->SMTPAuth = true;

			$mail->Host = $mail_host;
			$mail->Port = $mail_port;
			$mail->Username = $mail_user;
			$mail->Password = $mail_pass;
			$mail->SMTPSecure = $mail_auth;
			$mail->SetFrom($mail_from, $mail_name);

			$mail->Subject =  $request->subject;
			$mail->MsgHTML($request->body);

			$to = explode(";", $request->to);
			$cc = explode(";", $request->cc);
			
			foreach ($to as $key => $value) {
				if($to[$key] != NULL)
					$to[$key] = trim($value," ");
				// echo trim($value," ") . "<br>";
			}

			foreach ($cc as $key => $value) {
				if($cc[$key] != "")
					$cc[$key] = trim($value," ");
				// echo trim($value," ") . "<br>";
			}


			$to = array_slice($to,0,sizeof($to) - 1);
			$cc = array_slice($cc,0,sizeof($cc) - 1);

			for($i = 0;$i < sizeof($to);$i++){
				$mail->addAddress($to[$i]);
			}

			for($i = 0;$i < sizeof($cc);$i++){
				$mail->addCC($cc[$i]);
			}

			$mail->send();

			$update = DB::table('ticketing__activity')
			->insert([
				"id_ticket" => $request->id_ticket,
				"date" => date("Y-m-d H:i:s.000000"),
				"activity" => "PENDING",
				"operator" => Auth::user()->nickname,
				"note" => "Panding Ticket - " .  $request->note_pending
			]);

			$result = DB::table('ticketing__id')
				->where('ticketing__id.id_ticket','=',$request->id_ticket)
				->join('ticketing__client','ticketing__client.id','=','ticketing__id.id_client')
				->value('ticketing__client.client_acronym');


			return $result;

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

	public function cancelTicket(Request $request){
		$mail = new PHPMailer\PHPMailer(true);

		// Yandex Configuration
		$mail_host = env("YANDEX_MAIL_HOST");
		$mail_port = env("YANDEX_MAIL_PORT");
		$mail_user = env("YANDEX_MAIL_USERNAME");
		$mail_pass = env("YANDEX_MAIL_PASSWORD");
		$mail_auth = env("YANDEX_MAIL_ENCRYPTION");
		$mail_from = env("YANDEX_MAIL_FROM");
		$mail_name = env("YANDEX_MAIL_NAME");

		// Gmail Configuration
		// $mail_host = env("GMAIL_MAIL_HOST");
		// $mail_port = env("GMAIL_MAIL_PORT");
		// $mail_user = env("GMAIL_MAIL_USERNAME");
		// $mail_pass = env("GMAIL_MAIL_PASSWORD");
		// $mail_auth = env("GMAIL_MAIL_ENCRYPTION");
		// $mail_from = env("GMAIL_MAIL_FROM");
		// $mail_name = env("GMAIL_MAIL_NAME");

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
			
			$mail->Subject = $request->subject;
			$mail->MsgHTML($request->body);

			$to = explode(";", $request->to);
			$cc = explode(";", $request->cc);
			
			foreach ($to as $key => $value) {
				if($to[$key] != NULL)
					$to[$key] = trim($value," ");
				// echo trim($value," ") . "<br>";
			}

			foreach ($cc as $key => $value) {
				if($cc[$key] != "")
					$cc[$key] = trim($value," ");
				// echo trim($value," ") . "<br>";
			}


			$to = array_slice($to,0,sizeof($to) - 1);
			$cc = array_slice($cc,0,sizeof($cc) - 1);

			for($i = 0;$i < sizeof($to);$i++){
				$mail->addAddress($to[$i]);
			}

			for($i = 0;$i < sizeof($cc);$i++){
				$mail->addCC($cc[$i]);
			}

			$mail->send();

			$update = DB::table('ticketing__activity')
			->insert([
				"id_ticket" => $request->id_ticket,
				"date" => date("Y-m-d H:i:s.000000"),
				"activity" => "CANCEL",
				"operator" => Auth::user()->nickname,
				"note" => "Cancel Ticket - " . $request->note_cancel
			]);

			$result = DB::table('ticketing__id')
				->where('ticketing__id.id_ticket','=',$request->id_ticket)
				->join('ticketing__client','ticketing__client.id','=','ticketing__id.id_client')
				->value('ticketing__client.client_acronym');


			return $result;

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

	public function testMail(Request $request){
		$mail = new PHPMailer\PHPMailer(true);

		try {
			$mail->isSMTP();
			$mail->CharSet = "utf-8";
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "tls";
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 587;
			$mail->Username = "aqsharidho@gmail.com";
			$mail->Password = "Ridho731922";
			$mail->SetFrom('imogy@sinergy.co.id', 'Helpdesk Sinergy');
			$mail->Subject =  $request->subject;
			$mail->MsgHTML($request->body);

			// $request->to = "prof.agastyo@gmail.com; prof.agastyo@hotmail.com; prof.agastyo@yahoo.co.id; alam@sinergy.co.id; firdaus@sinergy.co.id;";
			// $request->cc = "agastya@sinergy.co.id;";

			// echo $request->to . "<br>";
			// echo $request->cc . "<br><br>";

			$to = explode(";", $request->to);
			$cc = explode(";", $request->cc);
			
			foreach ($to as $key => $value) {
				if($to[$key] != NULL)
					$to[$key] = trim($value," ");
				echo trim($value," ") . "<br>";
			}

			foreach ($cc as $key => $value) {
				if($cc[$key] != "")
					$cc[$key] = trim($value," ");
				echo trim($value," ") . "<br>";
			}


			$to = array_slice($to,0,sizeof($to) - 1);
			$cc = array_slice($cc,0,sizeof($cc) - 1);

			for($i = 0;$i < sizeof($to);$i++){
				// echo $to[$i] . "<br>";
				$mail->addAddress($to[$i]);
			}

			for($i = 0;$i < sizeof($cc);$i++){
				// echo $cc[$i] . "<br>";
				$mail->addCC($cc[$i]);
			}


			// $mail->addAddress("prof.agastyo@gmail.com", "Helpdesk Sinergy");
			$mail->send();
		} catch (phpmailerException $e) {
			dd($e);
		} catch (Exception $e) {
			dd($e);
		}
	}


	public function getAtm(Request $request){
		$get_client = DB::table('ticketing__client')
			->where('client_acronym','=',$request->acronym)
			->value('id');

		$result = DB::table('ticketing__atm')
			->where('owner','=',$get_client)
			->select('atm_id')
			->get();
			// ->toArray();

		$final = array();
		foreach ($result as $value) {
			$final[] = $value->atm_id;
		}

		return $final;
	}

	public function getDetailAtm($id_atm){
		$client = DB::table('ticketing__client')
			->select('id','client_acronym','client_name')
			->get();

		$return = DB::table('ticketing__atm')
			->where('id','=',$id_atm)
			->get();

		return array($return,$client);
	}

	public function getDetailAtm2($id_atm){
		$client = DB::table('ticketing__client')
			->select('id','client_acronym','client_name')
			->get();

		$return = DB::table('ticketing__atm')
			->where('atm_id','=',$id_atm)
			->get();

		return $return;
	}

	public function setAtm(Request $request){
		return DB::table('ticketing__atm')
			->where('id','=',$request->idAtm)
			->update([
				"owner" => $request->atmOwner,
				"atm_id" => $request->atmID, 
				"serial_number" => $request->atmSerial,
				"location" => $request->atmLocation,
			]);
	}

	public function newAtm(Request $request){
		DB::table('ticketing__atm')
			->insert([
				"owner" => $request->atmOwner,
				"atm_id" => $request->atmID, 
				"serial_number" => $request->atmSerial,
				"location" => $request->atmLocation
			]);
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

	public function testReport($client,$month){
		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$client = $client;
		$bulan = $month;

		// Set document properties
		$title = 'Laporan Bulanan '. $client . ' '. $month . date(" Y");

		$spreadsheet->getProperties()->setCreator('SIP')
			->setLastModifiedBy('Rama Agastya')
			->setTitle($title);
			

		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('General');

		// Report Title
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(35);
		$spreadsheet->getActiveSheet()->setCellValue('J2', 'LAPORAN REPORT BANK ' . $client);
		$spreadsheet->getActiveSheet()->getStyle('J2')->getFont()->setName('Calibri');
		$spreadsheet->getActiveSheet()->getStyle('J2')->getFont()->setSize(24);
		$spreadsheet->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('J2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		// Report Month
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(35);
		$spreadsheet->getActiveSheet()->setCellValue('B2', date('F'));
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
		// $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(15);

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
			// ->setCellValue('R4','HANDPHONE');
		
		$value1 = $this->getPerformance3($client,$bulan);

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
				$spreadsheet->getActiveSheet()->setCellValue('I' . (5 + $key),date_format(date_create($value->reporting_time),'G:i:s'));
				$spreadsheet->getActiveSheet()->setCellValue('J' . (5 + $key),date_format(date_create($value->reporting_time),'d F Y'));
			} else {
				$spreadsheet->getActiveSheet()->setCellValue('I' . (5 + $key),date_format(date_create($value->open),'G:i:s'));
				$spreadsheet->getActiveSheet()->setCellValue('J' . (5 + $key),date_format(date_create($value->open),'d F Y'));
			}
			if($value->last_status[0] == "CANCEL"){
				$spreadsheet->getActiveSheet()->setCellValue('K' . (5 + $key),'-');
				$spreadsheet->getActiveSheet()->setCellValue('L' . (5 + $key),'-');
				$spreadsheet->getActiveSheet()->getStyle('B' . (5 + $key) .  ':Q' . (5 + $key))->applyFromArray($cancel_row);
			} else {
				$spreadsheet->getActiveSheet()->setCellValue('K' . (5 + $key),date_format(date_create($value->last_status[1]),'G:i:s'));
				$spreadsheet->getActiveSheet()->setCellValue('L' . (5 + $key),date_format(date_create($value->last_status[1]),'d F Y'));
			}
			$spreadsheet->getActiveSheet()->setCellValue('M' . (5 + $key),$value->pic);
			$spreadsheet->getActiveSheet()->setCellValue('N' . (5 + $key),$value->contact_pic);
			$spreadsheet->getActiveSheet()->setCellValue('O' . (5 + $key),$value->root_couse);
			$spreadsheet->getActiveSheet()->setCellValue('P' . (5 + $key),$value->counter_measure);
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
			->setCellValue('F6','PERIODE BULAN')
			->setCellValue('H6','AKHIR')
			;

		$spreadsheet->getActiveSheet()->getStyle("I5")->getAlignment()->setWrapText(true);
		$spreadsheet->getActiveSheet()->getStyle("J5")->getAlignment()->setWrapText(true);

		$value1 = $this->getPerformance5($client,$bulan);

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
		


		$name = 'Report ' . $client . ' - ' . $month . ' (' . date("Y-m-d H:i:s") . ').xlsx';
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save($name);
		return response()->download($name);
		



		// return $value1;

	}


	public function controll(){
		$user = DB::table('users')
			->get();
		return view('controllPage');
	}

	public function testEmail1(){
		return view('testEmail');
	}

	public function testEmail2(){
		$mail = new PHPMailer\PHPMailer(true);
		
		try {
			$mail->isSMTP();
			$mail->SMTPDebug = 2;
			$mail->CharSet = "utf-8";
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "tls";
			$mail->Host = "smtp.yandex.ru";
			$mail->Port = 587;
			$mail->Username = "imogy@sinergy.co.id";
			$mail->Password = "bpdorgcsuturrmij";
			$mail->SetFrom('imogy@sinergy.co.id', 'Helpdesk Sinergy');
			$mail->Subject =  "Test";
			$mail->MsgHTML("<h1>Test email with atchment</h1>");
			$mail->addAddress('agastya@sinergy.co.id');
			$mail->addAddress('msm@sinergy.co.id');
			$mail->addCC('prof.agastyo@gmail.com');
			$mail->addAttachment("img/WIMOGY.png");
			$mail->send();
			return "Success";
		} catch (phpmailerException $e) {
			dd($e);
		} catch (Exception $e) {
			dd($e);
		}
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

	

}
