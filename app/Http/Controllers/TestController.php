<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer;
use DB;
use Log;
use Auth;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

use Carbon\Carbon;

use App\Http\Models\Ticketing;
use App\Mail\MailOpenProject;

use DataTables;
use App\User;
use App\Http\Models\TicketingDetail;

class TestController extends Controller
{

	public function logging_activity($type, Request $req){
		date_default_timezone_set("Asia/Jakarta");
		if(Auth::check()){
			$user = "{userId:" . Auth::id() . " email:" . Auth::user()->email . "}";
		} else {
			// $user = "{userId:" . Auth::id() . " email:" . Auth::user()->mail . "}";
			$user = "{userId:NaN email:NaN}";
		}
		switch ($type) {
			case 'ERROR':
				Log::error($req->message ." " . $user);
				break;

			case 'ALERT':
				Log::alert($req->message ." " . $user);
				break;

			case 'INFO':
				Log::info($req->message ." " . $user);
				break;
			
			default:
				Log::error($req->message ." " . $user);
				break;
		}
	}

	public function buildEmail($email_type){
		$mail = new PHPMailer\PHPMailer(true);

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
		} else if ($email_type == "MailTrap Testing"){
			$mail_host = env('MAILTRAP_MAIL_HOST');
			$mail_port = env('MAILTRAP_MAIL_PORT');
			$mail_user = env('MAILTRAP_MAIL_USERNAME');
			$mail_pass = env('MAILTRAP_MAIL_PASSWORD');
			$mail_auth = env('MAILTRAP_MAIL_ENCRYPTION');
			$mail_from = env('MAILTRAP_MAIL_FROM');
			$mail_name = env('MAILTRAP_MAIL_NAME');
		}
		
		try {
			$mail->isSMTP();
			$mail->SMTPDebug = 2;
			$mail->CharSet = "UTF-8";
			$mail->SMTPAuth = true;
			$mail->Host = $mail_host;
			$mail->Port = $mail_port;
			$mail->Username = $mail_user;
			$mail->Password = $mail_pass;
			$mail->SMTPSecure = $mail_auth;
			$mail->SetFrom($mail_from, $mail_name);
			return $mail;

		} catch (phpmailerException $e) {
			
			return dd($e);
		} catch (Exception $e) {
			return dd($e);
		}
	}

	public function performance(Request $req){
		echo "<h1>Test Performance</h1><br>";
		try {
				$mail = $this->buildEmail("Gmail Hello");

				$mail->Subject =  "Testing Performance for MailTrap Testing";
				$mail->MsgHTML("testPerformance");

				$mail->addAddress("agastya@sinergy.co.id");
				$mail->addCC("prof.agastyo@gmail.com");
				$mail->send();

				return "Testing Performance for Email : Success";

			} catch (phpmailerException $e) {
				
				return dd($e);
			} catch (Exception $e) {
				return dd($e);
			}
			return;
		if(isset($req->type) == "mailtrap"){
			try {
				$mail = $this->buildEmail("MailTrap Testing");

				$mail->Subject =  "Testing Performance for MailTrap Testing";
				$mail->MsgHTML("testPerformance");

				$mail->addAddress("agastya@sinergy.co.id");
				$mail->addCC("prof.agastyo@gmail.com");
				$mail->send();

				return "Testing Performance for Email : Success";

			} catch (phpmailerException $e) {
				
				return dd($e);
			} catch (Exception $e) {
				return dd($e);
			}
		} else {
			try {
				$mail = $this->buildEmail("Yandex MSM01");

				$mail->Subject =  "Testing Performance for Email Gmail";
				$mail->MsgHTML("testPerformance");

				$mail->addAddress("aqsharidho@gmail.com");
				$mail->addCC("prof.agastyo@gmail.com");
				$mail->send();

				return "Testing Performance for Email : Success";

			} catch (phpmailerException $e) {
				
				return dd($e);
			} catch (Exception $e) {
				return dd($e);
			}
		}
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

	public function getReportHelpdesk(){
		$data = DB::table('users')
			// ->where('role','1')
			// ->get();
			->toSql();

		$user = DB::table('ticketing__activity')
			->select('operator',DB::raw("count(*) as 'activity'"))
			->where('id_ticket','NOT LIKE','%Jan%')
			->where('operator','<>','Siwi')
			->groupBy('operator')
			->orderBy(DB::raw("count(*)"),'DESC')
			->toSql();
			// ->get();

		$result = DB::table('ticketing__activity')
			->select('activity',DB::raw("count(*) as 'operator'"))
			->where('operator','=','Alam')
			->where('id_ticket','NOT LIKE','%Jan%')
			->groupBy('activity')
			->toSql();
			// ->get()->toArray();

		$respond = DB::table('ticketing__detail')
			->join('ticketing__activity','ticketing__detail.id_ticket','=','ticketing__activity.id_ticket')
			->select('ticketing__detail.id','ticketing__activity.activity','ticketing__detail.reporting_time','ticketing__detail.id','ticketing__activity.operator','ticketing__detail.id_ticket','ticketing__activity.date')
			->where('ticketing__activity.activity','=','OPEN')
			->where('ticketing__detail.reporting_time','<>','Invalid date')
			->where('ticketing__detail.id_ticket','NOT LIKE','%Jan%')
			->where('ticketing__detail.reporting_time','<>','')
			->where('ticketing__activity.operator','=','Alam')
			->orderBy('ticketing__detail.id')
			->toSql();
			// ->get();

		$respond2 = DB::table('ticketing__detail')
			->join('ticketing__activity','ticketing__detail.id_ticket','=','ticketing__activity.id_ticket')
			->select('ticketing__detail.id','ticketing__activity.activity','ticketing__detail.reporting_time','ticketing__detail.id','ticketing__activity.operator','ticketing__detail.id_ticket','ticketing__activity.date')
			->where('ticketing__activity.activity','=','OPEN')
			->where('ticketing__detail.reporting_time','<>','Invalid date')
			->where('ticketing__detail.reporting_time','<>','')
			->where('ticketing__activity.operator','=','Nila')
			->orderBy('ticketing__detail.id')
			->toSql();
			// ->get();


		//////////////////////////////////
			
		// echo "<pre>";
		// echo($data . "<br>");
		// echo($user . "<br>");
		// echo($result . "<br>");
		// echo($respond . "<br>");
		// echo($respond2 . "<br>");
		// echo "</pre>";

		/////////////////////////////////

		$data = DB::table('users')
			// ->where('role','1')
			->get();

		$user = DB::table('ticketing__activity')
			->select('operator',DB::raw("count(*) as 'activity'"))
			// ->where('id_ticket','NOT LIKE','%Jan%')
			->whereRaw("`date` BETWEEN '2019-03-01' AND '2019-03-31'")
			->where('operator','<>','Siwi')
			->groupBy('operator')
			->orderBy(DB::raw("count(*)"),'DESC')
			->get();

		$data = array();

		foreach ($user as $value) {
			$result = DB::table('ticketing__activity')
				->select('activity',DB::raw("count(*) as 'operator'"))
				->where('operator','=',$value->operator)
				// ->where('id_ticket','NOT LIKE','%Jan%')
				->whereRaw('`date` BETWEEN "2019-03-01" AND "2019-03-31"')
				->groupBy('activity')
				->get()->toArray();
			

			$respond = DB::table('ticketing__detail')
				->join('ticketing__activity','ticketing__detail.id_ticket','=','ticketing__activity.id_ticket')
				->select('ticketing__detail.id','ticketing__activity.activity','ticketing__detail.reporting_time','ticketing__detail.id','ticketing__activity.operator','ticketing__detail.id_ticket','ticketing__activity.date')
				->where('ticketing__activity.activity','=','OPEN')
				->where('ticketing__detail.reporting_time','<>','Invalid date')
				// ->where('ticketing__detail.id_ticket','NOT LIKE','%Jan%')
				->whereRaw('`ticketing__activity`.`date` BETWEEN "2019-03-01" AND "2019-03-31"')
				->where('ticketing__detail.reporting_time','<>','')
				->where('ticketing__activity.operator','=',$value->operator)
				->orderBy('ticketing__detail.id')
				->get();

			$n = $respond->count();
			$all = array();

			// echo "<pre>";
			foreach ($respond as $value2) {
				// echo strtotime($value2->date);
				$subtract = (strtotime($value2->date)-strtotime($value2->reporting_time));
				$all[] = $subtract;

				// echo " - " . strtotime($value2->reporting_time) . " = ". $subtract . " = " . gmdate("H:i:s", $subtract) . "<br>";
			}
			// echo "<pre>";
			$temp3 = $value->operator;
			$temp = [];
			foreach ($result as $key => $value) {
				// echo($value->activity);
				$temp[] = $value->activity;
			}
			if(!in_array('CANCEL',$temp)){
				// array_push($temp, 'CANCEL');
				$temp2 = new  \stdClass();
				$temp2->activity = 'CANCEL';
				$temp2->operator = 0;

				array_push($result,$temp2);
			}
			if(!in_array('CLOSE',$temp)){
				// array_push($temp, 'CLOSE');
				$temp2 = new  \stdClass();
				$temp2->activity = 'CLOSE';
				$temp2->operator = 0;

				array_push($result,$temp2);
			}
			if(!in_array('ON PROGRESS',$temp)){
				// array_push($temp, 'ON PROGRESS');
				$temp2 = new  \stdClass();
				$temp2->activity = 'ON PROGRESS';
				$temp2->operator = 0;

				array_push($result,$temp2);
			}
			if(!in_array('OPEN',$temp)){
				// array_push($temp, 'OPEN');
				$temp2 = new  \stdClass();
				$temp2->activity = 'OPEN';
				$temp2->operator = 0;

				array_push($result,$temp2);
			}
			if(!in_array('PENDING',$temp)){
				// array_push($temp, 'PENDING');
				$temp2 = new  \stdClass();
				$temp2->activity = 'PENDING';
				$temp2->operator = 0;

				array_push($result,$temp2);
			}
			// $result[]->activity = 
			// print_r($result);
			// echo "</pre>";
			// rsort($all);
			// print_r($all);

			if($n == 0 || array_sum($all) == 0){
				$average = 0;
			} else {
				$average = array_sum($all) / $n;
				// $average = 0;
			}
			// echo "<br> Average " . gmdate("H:i:s", $average); 

			$data[] = array($temp3,$result,gmdate("H:i:s", $average));
			// print_r($data);
		}


		$respond = DB::table('ticketing__detail')
			->join('ticketing__activity','ticketing__detail.id_ticket','=','ticketing__activity.id_ticket')
			->select('ticketing__detail.id','ticketing__activity.activity','ticketing__detail.reporting_time','ticketing__detail.id','ticketing__activity.operator','ticketing__detail.id_ticket','ticketing__activity.date')
			->whereRaw('`ticketing__activity`.`date` BETWEEN "2019-03-01" AND "2019-03-31"')
			->where('ticketing__activity.activity','=','OPEN')
			->where('ticketing__detail.reporting_time','<>','Invalid date')
			->where('ticketing__detail.reporting_time','<>','')
			// ->where('ticketing__activity.operator','=','Nila')
			->orderBy('ticketing__detail.id')
			->get();

		$n = $respond->count();
		$all = array();
		$all2 = array();


		// echo "<pre>";
		foreach ($respond as $value2) {
			// echo strtotime($value2->date);
			$subtract = (strtotime($value2->date)-strtotime($value2->reporting_time));
			$all[] = array($subtract, $value2->id_ticket,$value2->date,$value2->reporting_time);
			$all2[] = $subtract;
			// echo " - " . strtotime($value2->reporting_time) . " = ". $subtract . " = " . gmdate("H:i:s", $subtract) . "<br>";
		}
		rsort($all);
		rsort($all2);

		$average = array_sum($all2) / $n;
		// echo "<br>Average " . gmdate("H:i:s", $average) . "<br>"; 
		// print_r($all);

		// return $data;

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// Indri, Paul, Nila

		$months = array("Mar","Apr","May","Jun","Jul","Aug","Sep","Nov","Dec");
		$months = array("Jan/2019","Feb/2019","Mar/2019","Apr/2019");
		$permonths = array();
		

		foreach ($months as $value3) {
			$data2 = array();
			foreach ($user as $value) {
				$CANCEL = DB::table('ticketing__activity')
					->select(DB::raw("count(*) as 'operator'"))
					->where('id_ticket','LIKE','%' . $value3 . '%')
					->where('ticketing__activity.activity','=','CANCEL')
					->where('operator','=',$value->operator)
					->groupBy('activity')
					->first();

				$CLOSE = DB::table('ticketing__activity')
					->select(DB::raw("count(*) as 'operator'"))
					->where('id_ticket','LIKE','%' . $value3 . '%')
					->where('ticketing__activity.activity','=','CLOSE')
					->where('operator','=',$value->operator)
					->groupBy('activity')
					->first();

				$ON_PROGRESS = DB::table('ticketing__activity')
					->select(DB::raw("count(*) as 'operator'"))
					->where('id_ticket','LIKE','%' . $value3 . '%')
					->where('ticketing__activity.activity','=','ON PROGRESS')
					->where('operator','=',$value->operator)
					->groupBy('activity')
					->first();

				$OPEN = DB::table('ticketing__activity')
					->select(DB::raw("count(*) as 'operator'"))
					->where('id_ticket','LIKE','%' . $value3 . '%')
					->where('ticketing__activity.activity','=','OPEN')
					->where('operator','=',$value->operator)
					->groupBy('activity')
					->first();

				$PENDING = DB::table('ticketing__activity')
					->select(DB::raw("count(*) as 'operator'"))
					->where('id_ticket','LIKE','%' . $value3 . '%')
					->where('ticketing__activity.activity','=','PENDING')
					->where('operator','=',$value->operator)
					->groupBy('activity')
					->first();
					
					if(isset($CANCEL->operator)){
						$CANCEL = $CANCEL->operator;
					} else {
						$CANCEL = 0;
					}
					if(isset($CLOSE->operator)){
						$CLOSE = $CLOSE->operator;
					} else {
						$CLOSE = 0;
					}
					if(isset($ON_PROGRESS->operator)){
						$ON_PROGRESS = $ON_PROGRESS->operator;
					} else {
						$ON_PROGRESS = 0;
					}
					if(isset($OPEN->operator)){
						$OPEN = $OPEN->operator;
					} else {
						$OPEN = 0;
					}
					if(isset($PENDING->operator)){
						$PENDING = $PENDING->operator;
					} else {
						$PENDING = 0;
					}
				$result = array($CANCEL,$CLOSE,$ON_PROGRESS,$OPEN,$PENDING);

				$respond = DB::table('ticketing__detail')
					->join('ticketing__activity','ticketing__detail.id_ticket','=','ticketing__activity.id_ticket')
					->select('ticketing__detail.id','ticketing__activity.activity','ticketing__detail.reporting_time','ticketing__detail.id','ticketing__activity.operator','ticketing__detail.id_ticket','ticketing__activity.date')
					->where('ticketing__detail.id_ticket','LIKE','%' . $value3 . '%')
					->where('ticketing__activity.activity','=','OPEN')
					->where('ticketing__detail.reporting_time','<>','Invalid date')
					->where('ticketing__detail.reporting_time','<>','')
					->where('ticketing__activity.operator','=',$value->operator)
					->orderBy('ticketing__detail.id')
					->get();

				$n = $respond->count();
				$all = array();

				// echo "<pre>";
				// print_r($result);
				// // print_r($respond);
				// echo "</pre>";
				foreach ($respond as $value2) {
					// echo strtotime($value2->date);
					$subtract = (strtotime($value2->date)-strtotime($value2->reporting_time));
					$all[] = $subtract;

					// echo " - " . strtotime($value2->reporting_time) . " = ". $subtract . " = " . gmdate("H:i:s", $subtract) . "<br>";
				}
				rsort($all);
				// print_r($all);
				if($n != 0){
					$average = array_sum($all) / $n;
				} else {
					$average = 0;
				}
				// echo "<br> Average " . gmdate("H:i:s", $average);


				$data2[] = array($value->operator,$result,gmdate("H:i:s", $average));
			}
			$permonths[$value3] = $data2;
		}

		$peruser = array();

		foreach ($user as $key => $value) {
			$peruser[] = $value;

		}

		// echo "<pre>";
		// print_r($permonths);
		// echo "</pre>";
		// return $permonths;


		return view('reportAll',compact('data','permonths'));
	}

	public function getReportHelpdesk2(){
		$data = DB::table('users')
			// ->where('role','1')
			->get();

		$user = DB::table('ticketing__activity')
			->select('operator',DB::raw("count(*) as 'activity'"))
			->groupBy('operator')
			->orderBy(DB::raw("count(*)"),'DESC')
			->where('')
			->get();

		$data = array();

		foreach ($user as $value) {
			$result = DB::table('ticketing__activity')
				->select('activity',DB::raw("count(*) as 'operator'"))
				->where('operator','=',$value->operator)
				->where('id_ticket','NOT LIKE','%Jan%')
				->groupBy('activity')
				->get()->toArray();

			$respond = DB::table('ticketing__detail')
				->join('ticketing__activity','ticketing__detail.id_ticket','=','ticketing__activity.id_ticket')
				->select('ticketing__detail.id','ticketing__activity.activity','ticketing__detail.reporting_time','ticketing__detail.id','ticketing__activity.operator','ticketing__detail.id_ticket','ticketing__activity.date')
				->where('ticketing__activity.activity','=','OPEN')
				->where('ticketing__detail.id_ticket','NOT LIKE','%Jan%')
				->where('ticketing__detail.reporting_time','<>','Invalid date')
				->where('ticketing__detail.reporting_time','<>','')
				->where('ticketing__activity.operator','=',$value->operator)
				->orderBy('ticketing__detail.id')
				->get();

			$n = $respond->count();
			$all = array();

			// echo "<pre>";
			foreach ($respond as $value2) {
				// echo strtotime($value2->date);
				$subtract = (strtotime($value2->date)-strtotime($value2->reporting_time));
				$all[] = $subtract;

				// echo " - " . strtotime($value2->reporting_time) . " = ". $subtract . " = " . gmdate("H:i:s", $subtract) . "<br>";
			}
			rsort($all);
			// print_r($all);

			$average = array_sum($all) / $n;
			// echo "<br> Average " . gmdate("H:i:s", $average); 

			$data[] = array($value->operator,$result,gmdate("H:i:s", $average));
		}

		$months2 = "May";
		$operator2 = "Nila";

		$result = DB::table('ticketing__activity')
				->select('activity',DB::raw("count(*) as 'operator'"))
				->where('operataor','=',$operator2)
				->where('id_ticket','LIKE',"%" . $months2 . "%")
				->groupBy('activity')
				->get()->toArray();

		$respond = DB::table('ticketing__detail')
			->join('ticketing__activity','ticketing__detail.id_ticket','=','ticketing__activity.id_ticket')
			->select('ticketing__detail.id','ticketing__activity.activity','ticketing__detail.reporting_time','ticketing__detail.id','ticketing__activity.operator','ticketing__detail.id_ticket','ticketing__activity.date')
			->where('ticketing__activity.activity','=','OPEN')
			->where('ticketing__detail.id_ticket','LIKE','%' . $months2 . '%')
			->where('ticketing__detail.reporting_time','<>','Invalid date')
			->where('ticketing__detail.reporting_time','<>','')
			->where('ticketing__activity.operator','=',$operator2)
			->orderBy('ticketing__detail.id')
			->get();

		$n = $respond->count();
		$all = array();
		$all2 = array();


		echo "<pre>";
		foreach ($respond as $value2) {
			// echo strtotime($value2->date);
			$subtract = (strtotime($value2->date)-strtotime($value2->reporting_time));
			$all[] = array($subtract, $value2->id_ticket,$value2->date,$value2->reporting_time);
			$all2[] = $subtract;
			// echo " - " . strtotime($value2->reporting_time) . " = ". $subtract . " = " . gmdate("H:i:s", $subtract) . "<br>";
		}
		rsort($all);
		rsort($all2);

		$average = array_sum($all2) / $n;
		// echo "<br>Average " . gmdate("H:i:s", $average) . "<br>"; 
		// print_r($all);
		// print_r($result);
		// print_r($all2);

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// Indri, Paul, Nila

		$months = array("Mar","Apr","May","Jun","Jul","Aug");
		$permonths = array();
		
		
		// foreach ($months as $value3) {
			$data2 = array();
			foreach ($user as $value) {
				$result = DB::table('ticketing__activity')
					->select('activity',DB::raw("count(*) as 'operator'"))
					->where('id_ticket','LIKE','%' . $months2 . '%')
					->where('operator','=',$value->operator)
					->groupBy('activity')
					->get()->toArray();

				$respond = DB::table('ticketing__detail')
					->join('ticketing__activity','ticketing__detail.id_ticket','=','ticketing__activity.id_ticket')
					->select('ticketing__detail.id','ticketing__activity.activity','ticketing__detail.reporting_time','ticketing__detail.id','ticketing__activity.operator','ticketing__detail.id_ticket','ticketing__activity.date')
					->where('ticketing__detail.id_ticket','LIKE','%' . $months2 . '%')
					->where('ticketing__activity.activity','=','OPEN')
					->where('ticketing__detail.reporting_time','<>','Invalid date')
					->where('ticketing__detail.reporting_time','<>','')
					->where('ticketing__activity.operator','=',$value->operator)
					->orderBy('ticketing__detail.id')
					->get();

				$n = $respond->count();
				$all = array();

				// echo "<pre>";
				// print_r($respond);
				// echo "</pre>";
				foreach ($respond as $value2) {
					// echo strtotime($value2->date);
					$subtract = (strtotime($value2->date)-strtotime($value2->reporting_time));
					$all[] = $subtract;

					// echo " - " . strtotime($value2->reporting_time) . " = ". $subtract . " = " . gmdate("H:i:s", $subtract) . "<br>";
				}
				rsort($all);
				// print_r($all);
				if($n != 0){
					$average = array_sum($all) / $n;
				} else {
					$average = 0;
				}
				echo "<br> Average " . gmdate("H:i:s", $average); 

				$data2[] = array($value->operator,$result,gmdate("H:i:s", $average));
			}
			$permonths[$months2] = $data2;
		// }

		$peruser = array();

		foreach ($user as $key => $value) {
			$peruser[] = $value;

		}

		// echo "<pre>";
		// print_r($permonths);
		// echo "</pre>";
		// return $permonths;


		return view('reportAll',compact('data','permonths'));
	}

	public function testFunction($parm){
		
		return $parm;

	}

	public function testDBRaw(){
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
			// ->get();
			->toSql();

		echo $needed;
	}

	// Get Ticketing Performance Specific Project + Period
	// Get Ticketing Performance Specific Project + Period (BANK||NON BANK)

	// Get Ticketing Performance Specific ID
	// Get Ticketing Performance Specific Project
	// Get Ticketing Performance All

	// Id, ID_Ticket, ID_ATM, Ticket Number, Open Time, Problem, PIC, Location, Status, Last Operator

	public function getTicketingPerformance(Request $request){
		$begin = memory_get_usage();
		$acronym_client = $request->client;
		$id_client = DB::table('ticketing__client')
			->where('client_acronym','=',$acronym_client)
			->value('id');

		$result = DB::table('ticketing__id')
			->join('ticketing__detail','ticketing__detail.id_ticket','=','ticketing__id.id_ticket')
			->where('ticketing__id.id_client','=',$id_client)
			->take(300)	
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
		echo 'Total memory usage : '. (memory_get_usage() - $begin);
		// return $result;
	}

	public function testChunkQuery(){
		$begin = memory_get_usage();	
		DB::table('ticketing__id')->orderBy('id')->chunk(10, function ($id_tickets) {
			foreach ($id_tickets as $id_ticket) {
				echo $id_ticket->id . " <br>";
			}
			echo "End Chunk <br>";
		});
		echo 'Total memory usage : '. (memory_get_usage() - $begin);
	}

	public function firebase(){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/firebase-key.json');
		$firebase = (new Factory)
			->withServiceAccount($serviceAccount)
			->withDatabaseUri('https://test-project-64a66.firebaseio.com/')
			->create();

		$database = $firebase->getDatabase();
		return $database;
		// $newPost = $database
		// 	->getReference('blog/posts')
		// 	->push([
		// 		'title' => 'Post title',
		// 		'body' => 'This should probably be longer.'
		// 	]);
		// //$newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
		// //$newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-
		// //$newPost->getChild('title')->set('Changed post title');
		// //$newPost->getValue(); // Fetches the data from the realtime database
		// //$newPost->remove();
		// echo"<pre>";
		// print_r($newPost->getvalue());
	}

	// public function testModelTicketing(){
	// 	$start = microtime(true);
		
	// 	$result = Ticketing::has('activity_ticket')
	// 		->with('lastest_activity_ticket')
	// 		->orderBy('id','DESC')	
	// 		// ->limit(10)
	// 		->get();

	// 	$result->map(function($item,$key){
	// 		return $item->lastest_activity_ticket_status = $item->lastest_activity_ticket->activity;
	// 	});

	// 	$result = $result->groupBy('lastest_activity_ticket_status');

	// 	$count = collect();
	// 	foreach ($result as $key => $value) {
	// 		$count->push($value->count());
	// 	}

	// 	// return Ticketing::
	// 	// 	->orderBy('id','DESC')
	// 	// 	->find(7179);
	// 		// ->limit(100)
	// 		// ->get();
	// 	// return $result;
	// 	// return collect([$result,$count]);
	// 	$time_elapsed_secs = microtime(true) - $start;
	// 	return $time_elapsed_secs;

	// }

	public function testModelTicketing(){
		$start = microtime(true);
		
		$result2 = DB::table('ticketing__activity')
			->select('activity',DB::raw("count(*) as count"))
			->whereIn('id',function ($query) {
					$query->select(DB::raw("MAX(id) AS activity"))
						->from('ticketing__activity')
						->groupBy('id_ticket');
				})
			->groupBy('activity')
			->get();
		
		$all = 0;
		foreach ($result2 as $key => $value) {
			$all = $all + $value->count;
		}
		$result2->push(["activity" => "ALL", "count" => $all]);
		$result2 = $result2->keyBy('activity');


		// return $result2;

		$get_client = DB::table('ticketing__client')
			->select('id','client_name','client_acronym')
			->get();
		$get_client->pluck('client_acronym');
		// return $get_client;

		$count_ticket_by_client = DB::table('ticketing__id')
			->selectRaw('`ticketing__client`.`client_acronym`, COUNT(*) AS ticket_count')
			->groupBy('ticketing__id.id_client')
			->join('ticketing__client','ticketing__client.id','=','ticketing__id.id_client')
			->get();

		// return $count_ticket_by_client;

		

		// $count_client = DB::table('ticketing__id')
		// 	->select(DB::raw('id_client,COUNT(*)'))
		// 	->groupBy("id_client")
		// 	->get();

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
			->get();

		// return $needed;


		$severity_count = DB::table('ticketing__detail')
			->select('ticketing__severity.name',DB::raw('COUNT(*) as count'))
			->join('ticketing__severity','ticketing__severity.id','=','ticketing__detail.severity')
			->where('ticketing__detail.severity','<>',0)
			->groupBy('ticketing__detail.severity')
			->get()
			->keyBy('name');

		$time_elapsed_secs = microtime(true) - $start;
		// return $time_elapsed_secs;

		// return array($count,$client,$count_ticket,$needed,$severity_count);
		return collect([
			"counter_condition" => $result2,
			"counter_severity" => $severity_count,
			"occurring_ticket" => $needed,
			$get_client,
			$count_ticket_by_client,
		]);
	}

	public function notif_test(){
		return view('testing.notif');
	}

	public function notif_test_store(){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/firebase-key.json');
		$firebase = (new Factory)
			->withServiceAccount($serviceAccount)
			->withDatabaseUri('https://test-project-64a66.firebaseio.com/')
			->create();

		$database = $firebase->getDatabase();

		$updateChart = $database
			->getReference('/test/')
			->push([
				"date" => Carbon::now()->formatLocalized('%d %B %Y')
			]);
	}

	public function testingATMMaps(){
		return view('mapsAtm');
	}

	public function testEmailReturn(){
		$data = array(
			"to" => array(
				"agastya@sinergy.co.id",
				'prof.agastyo@gmail.com',

				// "siwi@sinergy.co.id",
				// "johan@sinergy.co.id",
				// "dicky@sinergy.co.id",
				// "ferdinand@sinergy.co.id",
				// "wisnu.darman@sinergy.co.id"
			),
			"cc" => array(
				// "endraw@sinergy.co.id",
				// "msm@sinergy.co.id",

				'imogy@sinergy.co.id',
				'hellosinergy@gmail.com'
			),
			// "subject" => "Open Project - " . $req->CustomerName,
			"subject" => "Open Project - PT. Bussan Auto Finance",
			'name' => Auth::user()->name,
			'phone' => Auth::user()->phone,

			"customer" => "PT. Bussan Auto Finance",
			// "customer" => $req->CustomerName,
			"name_project" => "Cisco IP Phone Branch Denpasar",
			// "name_project" => $req->Name,
			"project_id" => "244/SOMPO/478/SIP/IX/2018",
			// "project_id" => $req->PID,
			"period" => "4x",
			// "period" => $req->Period . "x",
			"duration" => "3 Bulan",
			// "duration" => $req->Duration . " Bulan",
			"start" => "1 August 2019",
			// "start" => $startPeriod,
			"end" => "31 October 2019",
			// "end" => $endPeriod,
			
			"coordinatorName" => "Wisnu Darman",
			// "coordinatorName" => DB::table('users')->where('id',$req->Coordinator)->value('name'),
			"coordinatorEmail" => "wisnu.darman@sinergy.co.id",
			// "coordinatorEmail" => DB::table('users')->where('id',$req->Coordinator)->value('email'),
			
			"teamLeadName" => "Johan Ardi Wibisono",
			// "teamLeadName" => DB::table('users')->where('id',$req->Lead)->value('name'),
			"teamLeadEmail" => "johan@sinergy.co.id",
			// "teamLeadEmail" => DB::table('users')->where('id',$req->Lead)->value('email'),

			"teamMemberName" => array("Rama Agastya","Siwi Karuniawati","M Dicky Ardiansyah","Yohanis Ferdinand"),
			// "teamMemberName" => $teamMemberName,
			"teamMemberEmail" => array("agastya@sinergy.co.id","siwi@sinergy.co.id","dicky@sinergy.co.id","yohanis@sinergy.co.id")
			// "teamMemberEmail" => $teamMemberEmail
		);


		return new MailOpenProject($data);

	}

	public function testingServerSideDatatables(){
		return view('testingServerSideDatatables');
	}

	public function testingGetDataServerSide(){
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

		// $residual_ticket_result = TicketingDetail::with([
		// 		'first_activity_ticket:id_ticket,date,operator',
		// 		'lastest_activity_ticket',
		// 		'id_detail:id_ticket,id',
		// 	])
		// 	->whereNotIn('id_ticket',$occurring_ticket)
		// 	// ->limit((100 - $occurring_ticket->count()))
		// 	// ->limit((200 - $occurring_ticket->count()))
		// 	// ->limit((300 - $occurring_ticket->count()))
		// 	// ->limit((400 - $occurring_ticket->count()))
		// 	// ->limit((500 - $occurring_ticket->count()))
		// 	// ->limit((600 - $occurring_ticket->count()))
		// 	// ->limit((700 - $occurring_ticket->count()))
		// 	// ->limit((800 - $occurring_ticket->count()))
		// 	// ->limit((900 - $occurring_ticket->count()))
		// 	->limit((1000 - $occurring_ticket->count()))
		// 	->orderBy('id','DESC')
		// 	->get();

		$result = $occurring_ticket_result;
		// $result = $occurring_ticket_result->merge($residual_ticket_result);
		return Datatables::of($result)->make(true);
		// return Datatables::of(User::all())->make(true);
	}

	public function testLoading(){
		sleep(3);
		return 0;
	}

	public function testMailOnProgress(){
		return view('mailOnProgressTicket');
	}


}
