<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProjectController extends Controller
{
	//

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
			// ->where('position',$req->type)
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

		return null;
	}

	public function setting(){

		return view('project.setting');

	}
}
