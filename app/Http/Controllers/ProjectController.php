<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MailOpenProject;
use App\Jobs\QueueEmail;
use Mail;
use Auth;
use DB;

class ProjectController extends Controller
{
	//

	public function __construct(){
		
		$this->middleware('auth');
	}

	public function index(){

		return view('project.overview');
	}

	public function manage(){

		return view('project.manage');
	}

	public function getCustomer(){
		return DB::table('project__customer')
			->select(DB::raw('id, name as text'))
			->get();
	}

	public function getMember(){
		$engineer = DB::table('project__member')
			->select(DB::raw('id, nickname as text,position'))
			->where('position','Engineer')
			->get();

		$helpdesk = DB::table('project__member')
			->select(DB::raw('id, nickname as text,position'))
			->where('position','Helpdesk')
			->get();

		$coordinator = DB::table('project__member')
			->select(DB::raw('id, nickname as text,position'))
			->where('position','Coordinator')
			->get();
		
		return array( 
			"coordinator" => array(
				array(
					"text" => "Coordinator",
					"children" => $coordinator
				),
			),
			"all" => array(
				array(
					"text" => "Engineer",
					"children" => $engineer
				),
				array(
					"text" => "Helpdesk",
					"children" => $helpdesk
				),
			),
		);
	}

	public function setProjectList(Request $req){
		if($req->Customer == 0){
			DB::table('project__customer')
				->insert(
					[
						'name' => $req->CustomerName
					]
				);
			$req->Customer = DB::table('project__customer')->where('name',$req->CustomerName)->value('id');
		}

		DB::table('project__list')
			->insert(
				[
					'project_name' => $req->Name,
					'project_pid' => $req->PID,
					'project_customer' => $req->Customer,
					'project_start' => $req->StartPeriod,
					'project_periode' => $req->Period,
					'project_periode_duration' => $req->Duration,
					'project_coordinator' => $req->Coordinator,
					'project_leader' => $req->Lead,
				]
			);
		$teamMemberName = [];
		$teamMemberEmail = [];
		foreach ($req->Member as $member) {
			$temp = DB::table('users')->where('nickname',$member)->first();
			$teamMemberName[] = $temp->name;
			$teamMemberEmail[] = $temp->email;

			DB::table('project__team_member')
				->insert(
					[
						'project_list_id' => DB::table('project__list')->where('project_pid',$req->PID)->value('id'),
						'user_id' => $temp->id,
					]
				);
		}
		
		$startPeriod[0] = date('j F Y', strtotime("+" . ($req->Duration*0) . " months", strtotime($req->StartPeriod)));
		$endPeriod[0] = date('j F Y', strtotime("+" . ($req->Duration*1) . " months -1 days", strtotime($req->StartPeriod)));

		DB::table('project__event')
			->insert(
				[
					'project_list_id' => DB::table('project__list')->where('project_pid',$req->PID)->value('id'),
					'name' => "Preventive Periode " . 1,
					'note' => date('j F Y', strtotime("+" . ($req->Duration*0) . " months", strtotime($req->StartPeriod))) . " - " . date('j F Y', strtotime("+" . ($req->Duration*1) . " months -1 days", strtotime($req->StartPeriod))),
					'due_date' => date('Y-m-d', strtotime("+" . ($req->Duration*1) . " months", strtotime($req->StartPeriod))),
					'status' => "Active"
				]
			);

		for($i = 1; $i < $req->Period; $i++){
			$start = date('j F Y', strtotime("+" . ($req->Duration*$i) . " months", strtotime($req->StartPeriod)));
			$end = date('j F Y', strtotime("+" . ($req->Duration*($i+1)) . " months -1 days", strtotime($req->StartPeriod)));
			$startPeriod[$i] = $start;
			$endPeriod[$i] = $end;
			DB::table('project__event')
				->insert(
					[
						'project_list_id' => DB::table('project__list')->where('project_pid',$req->PID)->value('id'),
						'name' => "Preventive Periode " . ($i+1),
						'note' => $start . " - " . $end,
						'due_date' => date('Y-m-d', strtotime("+" . ($req->Duration*($i+1)) . " months", strtotime($req->StartPeriod))),
						'status' => "On Going"
					]
				);
		}

		$data = array(
			"to" => array(
				"agastya@sinergy.co.id",
				// "siwi@sinergy.co.id",
				// "johan@sinergy.co.id",
				// "dicky@sinergy.co.id",
				// "ferdinand@sinergy.co.id",
				// "wisnu.darman@sinergy.co.id"
			),
			// "to" => array_push(
			// 	$teamMemberName, 
			// 	DB::table('users')->where('id',$req->Coordinator)->value('email'),
			// 	DB::table('users')->where('id',$req->Lead)->value('email')
			// ),
			"cc" => array(
				"prof.agastyo@gmail.com",
				// "endraw@sinergy.co.id",
				// "msm@sinergy.co.id"
			),
			"subject" => "Open Project - " . $req->CustomerName,
			"name" => Auth::user()->name,
			"phone" => Auth::user()->phone,

			"customer" => $req->CustomerName,
			"name_project" => $req->Name,
			"project_id" => $req->PID,
			"period" => $req->Period . "x",
			"duration" => $req->Duration . " Bulan",
			"start" => $startPeriod,
			"end" => $endPeriod,
			
			"coordinatorName" => DB::table('users')->where('id',DB::table('project__member')->where('id',$req->Coordinator)->value('user_id'))->value('name'),
			"coordinatorEmail" => DB::table('users')->where('id',DB::table('project__member')->where('id',$req->Coordinator)->value('user_id'))->value('email'),
			
			"teamLeadName" => DB::table('users')->where('id',DB::table('project__member')->where('id',$req->Lead)->value('user_id'))->value('name'),
			"teamLeadEmail" => DB::table('users')->where('id',DB::table('project__member')->where('id',$req->Lead)->value('user_id'))->value('email'),

			"teamMemberName" => $teamMemberName,
			"teamMemberEmail" => $teamMemberEmail

		);

		// return $this->sendProjectListOpen( $data );
		// Mail::to($data["to"])
		// 	->cc($data["cc"])
		// 	->send(new MailOpenProject($data));

		dispatch(new QueueEmail($data));
		// return new MailOpenProject($data);

		// return null;
	}

	public function sendProjectListOpen( $data ) {

	}

	public function testSendProjectListOpen(Request $req){
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
			// "start" => "1 August 2019",
			// "start" => $startPeriod,
			// "end" => "31 October 2019",
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

		// Mail::to($data["to"])
		// 	->cc($data["cc"])
		// 	->send(new MailOpenProject($data));

		dispatch(new QueueEmail($data));
		
		
		// return view('project.mailOpenProject');
	}

	public function getAllProjectList(){
		return json_encode(array('data' => DB::table('project__list')
			->select(
					"project__list.id",
					"project__list.project_name",
					"project__list.project_pid",
					DB::raw("project__customer.name as project_customer"),
					DB::raw("IFNULL ( DATEDIFF(project_event.due_date,'" . date('Y-m-d') . "'),0 )as project_start"),
					DB::raw("IFNULL ( DATEDIFF(project_event.due_date,'" . date('Y-m-d') . "'),0 )as project_start2"),
					"project__list.project_periode",
					"project__list.project_periode_duration",
					// "project__list.project_coordinator",
					"project__list.project_leader",
					DB::raw("leader.nickname as project_leader"),
					DB::raw("coordinator.nickname as project_coordinator")
				)
			// ->where('project__event.status','Active')
			->join(
				DB::raw('(select * from project__event where project__event.status = "Active") AS project_event'),
				'project_event.project_list_id',
				'=',
				'project__list.id','left')
			->orderBy('project_start','ASC')
			->join('project__customer','project__list.project_customer','=','project__customer.id')
			->join('project__member as leader','project__list.project_leader','=','leader.id','left outer')
			->join('project__member as coordinator','project__list.project_coordinator','=','coordinator.id','left outer')
			->get()
		));
	}

	public function getDetailProjectList(Request $req){
		
		DB::table('project__event')
			->where('project_list_id',$req->id)
			->value('id');

		return array("event" => 
			DB::table('project__event')
				->where('project_list_id',$req->id)
				->orderBy('due_date',"ASC")
				->get()
			,"eventHistory" => 
			DB::table('project__event_history')
				->select(
					'project__event_history.id',
					'project__event_history.project_event_id',
					'project__event_history.time',
					'project__event_history.note',
					'project__event_history.type',
					'project__event_history.updater'
				)
				->join(DB::raw('(SELECT id FROM project__event WHERE project_list_id = ' . $req->id . ') AS project_event'),'project_event.id','project__event_history.project_event_id')
				->orderBy('project__event_history.time','ASC')
				->get()
		);
	}

	public function getShortDetailProjectList(Request $req){
		$event = DB::table('project__event')
			->select('project__event.due_date','project__event.id','project__event.name','project__list.project_pid')
			->join('project__list','project__list.id','=','project__event.project_list_id')
			->where('project__event.project_list_id',$req->id_project)
			->where('project__event.status','Active')
			->first();

		if(!empty($event)){
			$history = DB::table('project__event_history')
				->where('project_event_id','=',$event->id)
				->orderBy('id','DESC')
				->first();



			if(isset($history->note)){
				return array(
					'project_id' => $event->project_pid,
					'lastest_update' => $history->note,
					'event_now' => $event->name,
				);
			} else {
				return array(
					'project_id' => $event->project_pid,
					'lastest_update' => "N/A",
					'event_now' => $event->name,
				);
			}
		} else {
			return array(
				'project_id' => "N/A",
				'lastest_update' => "N/A",
				'event_now' => "Project Close",
			);
		}


	}

	public function setUpdateEventProject(Request $req){
		DB::table('project__event_history')
			->insert(
				[
					'project_event_id' => $req->id,
					'time' => $req->time,
					'note' => $req->note,
					'type' => $req->type,
					'updater' => Auth::user()->nickname,
				]
			);
		
		if($req->type == "Finish"){
			DB::table('project__event')
				->where('id',$req->id)
				->update(['status'=>'Passed']);

			DB::table('project__event')
				->where('id',$req->id + 1)
				->update(['status'=> 'Active']);
		}
		
		return null;
	}

	public function setting(){

		return view('project.setting');

	}

	public function getSettingProject(Request $req){
		return DB::table('project__list')
			->where('id',$req->id)
			->get();
	}
}
