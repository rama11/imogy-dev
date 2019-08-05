<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use StdClass;
use DB;

class HomeController extends Controller
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
		return view('home');
	}

	public function testPage(){
		return view('testPage');
	}

	public function testDataTable(){
		return view('testDataTable');
	}

	public function profile(){
		return view('profile');
	}

	public function authenticate($id){
		if(Auth::user()->id == "4" || $id == 4){
			Auth::loginUsingId($id);
			return redirect()->back();
		} else {
			return abort(404);
		}
	}

	public function debugMode(){
		if(DB::table('console')
			->where('id_user',Auth::user()->id)
			->value("mode") == 1){

			DB::table('console')
				->where('id_user',Auth::user()->id)
				->update(["mode" => 0]);
		} else {
			DB::table('console')
				->where('id_user',Auth::user()->id)
				->update(["mode" => 1]);
		}

		return redirect()->back();
	}

	public function testProgram(){
		$json = '[ { "_id": "5ac32950e72430e2f99bff6c", "index": 0, "guid": "1e697723-bde4-4890-8f32-5133c4039996", "isActive": true, "balance": "$3,113.13", "picture": "http://placehold.it/32x32", "age": 32, "eyeColor": "green", "name": "Shepard Carey", "gender": "male", "company": "AQUOAVO", "email": "shepardcarey@aquoavo.com", "phone": "+1 (965) 572-2973", "address": "651 Apollo Street, Albany, Nebraska, 6444", "about": "Amet nostrud sit anim officia do. Minim dolore qui occaecat anim non est aliquip qui ea fugiat labore adipisicing Lorem. Ipsum occaecat pariatur exercitation dolor. Qui velit consectetur culpa velit consequat eiusmod.\r\n", "registered": "2015-07-10T12:11:07 -07:00", "latitude": -26.557952, "longitude": 64.457327, "tags": [ "anim", "nulla", "consectetur", "tempor", "eiusmod", "culpa", "et" ], "friends": [ { "id": 0, "name": "Wendi Wall" }, { "id": 1, "name": "Kristine Booker" }, { "id": 2, "name": "Hayes Weaver" } ], "greeting": "Hello, Shepard Carey! You have 9 unread messages.", "favoriteFruit": "banana" } ]';
		// $json = new StdClass();
		// $json->id = "214";
		// $json->index_employee = "OP2-MSM-34a";
		// $json->name = "Rama Agastya";
		// $json->born_place = 'Malang';
		// $json->born_date = '5 Ocktober 2000';
		// $json->contact = array('email' => 'agastya@sinergy.co.id','phone' => '+62 823-247-4400');
		// $json->devision = "Manage Service";
		// $json->role = "Technical Engineer";
		// $json->certification = array(
		// 	array('title' => 'CCNA Routing and Switching','get_on' => '27 December 2017','score' => '978/1000'),
		// 	array('title' => 'CCNP Routing and Switching','get_on' => '17 December 2018','score' => '878/1000'),
		// 	array('title' => 'CCIE Routing and Switching','get_on' => '20 March 2020','score' => '898/1000'),
		// );
		// $json->skill = array(
		// 	'pushing' => 70,
		// 	'versatility' => 45,
		// 	'fighting' => 93,
		// 	'farming' => 21,
		// 	'supporting' => 77,
		// );

		// for($a=5; $a>=1; $a--){
		// 	if($a%2 != 0){
		// 		for($b=5; $b>=$a; $b--){
		// 			echo "* ";
		// 		}
		// 		echo "<br>";
		// 	}
		// }
		
		// for($a=2; $a<=5; $a++){
		// 	if($a%2 != 0){
		// 		for($b=5; $b>=$a; $b--){
		// 			echo "* ";
		// 		}
		// 		echo "<br>";
		// 	}
		// }

		// echo "<pre>";
		// print_r($json);
		// echo "</pre>";
		$json = json_decode($json);

		return $json;
		// return json_decode($json);
		// return view('testProgram');
	}



	public function testValue(){
		// $array = array("data1","data2","data3");

		$array = DB::table('users')
			->get();

		return $array;
	}
}
