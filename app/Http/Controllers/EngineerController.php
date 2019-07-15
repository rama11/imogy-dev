<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EngineerController extends Controller
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index()
	{
		$users = DB::table('users')
			->orderBy('condition', 'desc')
			->limit(9)
			->get();

		$onwork_users = DB::table('users')
			->where('condition','=','on')
			->count();

		$offwork_users = $users->count() - $onwork_users;

		$data = array(
			"onwork_users" => $onwork_users,
			"offwork_users" => $offwork_users
		);

		$users = $users->toArray();

		return view('admin',compact('data','users'));
	}

	public function usermanage(){
		$users = DB::table('users')
			->orderBy('condition', 'desc')
			->limit(9)
			->get()
			->toArray();
		$waktu_absen = DB::table('waktu_absen')
			->get()
			->toArray();


		return view('usermanage',compact('users','waktu_absen'));
	}

	public function eannoun(){
		return view('eannoun');
	}
	
	public function eabsen(){
		$location = Auth::user()->location;
		$point = DB::table('location')
			->where('id','=',$location)
			->get()
			->first();
		return view('absen',compact('point','condition'));
	}


	public function user(){
		$users = DB::table('users')
			->orderBy('condition', 'desc')
			->limit(9)
			->get()
			->toArray();
		$waktu_absen = DB::table('waktu_absen')
			->get()
			->toArray();


		return view('data123',compact('users','waktu_absen'));
	}

	public function location(){
		$users = DB::table('users')
			->orderBy('condition', 'desc')
			->limit(9)
			->get()
			->toArray();
		$waktu_absen = DB::table('waktu_absen')
			->get()
			->toArray();

		return view('location',compact('users','waktu_absen'));
	}
}
