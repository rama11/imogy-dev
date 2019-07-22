<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
	//

	public function index(){

		return view('project.overview');

	}

	public function manage(){

		return view('project.manage');

	}

	public function setting(){

		return view('project.setting');

	}
}
