<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
		return DB::table('project__member')
			->select(DB::raw('id, nickname as text,position'))
			->get();
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

		foreach ($req->Member as $member) {
			DB::table('project__team_member')
				->insert(
					[
						'project_list_id' => DB::table('project__list')->where('project_pid',$req->PID)->value('id'),
						'user_id' => DB::table('users')->where('nickname',$member)->value('id'),
					]
				);
		}
		
		DB::table('project__event')
			->insert(
				[
					'project_list_id' => DB::table('project__list')->where('project_pid',$req->PID)->value('id'),
					'name' => "Preventive Periode " . 1,
					'note' => date('j F Y', strtotime("+" . ($req->Duration*0) . " months", strtotime($req->StartPeriod))) . " - " . date('j F Y', strtotime("+" . ($req->Duration*1) . " months -1 days", strtotime($req->StartPeriod))),
					'due_date' => date('Y-m-d', strtotime("+" . ($req->Duration*0) . " months", strtotime($req->StartPeriod))),
					'status' => "Active"
				]
			);

		for($i = 1; $i < $req->Period; $i++){
			DB::table('project__event')
				->insert(
					[
						'project_list_id' => DB::table('project__list')->where('project_pid',$req->PID)->value('id'),
						'name' => "Preventive Periode " . ($i+1),
						'note' => date('j F Y', strtotime("+" . ($req->Duration*$i) . " months", strtotime($req->StartPeriod))) . " - " . date('j F Y', strtotime("+" . ($req->Duration*$i+1) . " months -1 days", strtotime($req->StartPeriod))),
						'due_date' => date('Y-m-d', strtotime("+" . ($req->Duration*$i) . " months", strtotime($req->StartPeriod))),
						'status' => "On Going"
					]
				);
		}


		return null;
	}

	public function getAllProjectList(){
		return json_encode(array('data' => DB::table('project__list')
			->select(
					"project__list.id",
					"project__list.project_name",
					"project__list.project_pid",
					DB::raw("project__customer.name as project_customer"),
					"project__list.project_start",
					"project__list.project_periode",
					"project__list.project_periode_duration",
					// "project__list.project_coordinator",
					"project__list.project_leader",
					DB::raw("leader.nickname as project_leader"),
					DB::raw("coordinator.nickname as project_coordinator")
				)
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
			->where('project_list_id',$req->id_project)
			->where('status','Active')
 			->first();

 		$history = DB::table('project__event_history')
	 			->where('project_event_id','=',$event->id)
	 			->orderBy('id','DESC')
	 			->first();

	 	if(isset($history->note)){
			return array(
				'next_due_date' => date_diff(date_create($event->due_date),date_create(date('Y-m-d')))->days,
				'lastest_update' => $history->note,
				'event_now' => $event->name,
			);
	 	} else {
	 		return array(
				'next_due_date' => date_diff(date_create($event->due_date),date_create(date('Y-m-d')))->days,
				'lastest_update' => "N/A",
				'event_now' => $event->name,
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
}
