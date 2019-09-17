<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use PDF;

class HelpdeskController2 extends Controller
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

	public function index(){

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

		$late = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',auth::user()->id)
			->where('late','=','Late')
			->count();
		$injury = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',auth::user()->id)
			->where('late','=','Injury-Time')
			->count();
		$ontime = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',auth::user()->id)
			->where('late','=','On-Time')
			->count();
		$all = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',auth::user()->id)
			->count();			

		if($late == 0 || $injury == 0 || $ontime == 0 || $all == 0){
			$late = 1;
			$injury = 1;
			$ontime = 1;
			$all = 1;
		}

		$count = [
			$late,
			$injury,
			$ontime,
			$all
		];

		$persen = [
			$late = round($late / $all * 100,1),
			$injury = round($injury / $all * 100,1),
			$ontime = round($ontime / $all * 100,1),
		];

		$absen = 0;
		//('datas','datas2','kehadiran','persen','count','absen'));

		return view('helpdesk',compact('data','users','persen','count','absen'));
	}

	public function husermanage(){
		$users = DB::table('users')
			->orderBy('condition', 'desc')
			// ->limit(9)
			->get()
			->toArray();
		$waktu_absen = DB::table('waktu_absen')
			->get()
			->toArray();
		$location = DB::table('location')
			->get()
			->toArray();

		// echo "<pre>";
		// print_r($users);
		// echo "</pre>";

		

		return view('husermanage',compact('users','waktu_absen','location'));
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

	public function hsycal(){
		$users = DB::table('users')
			->orderBy('condition', 'desc')
			->limit(9)
			->get()
			->toArray();
		$waktu_absen = DB::table('waktu_absen')
			->get()
			->toArray();


		return view('hsycal',compact('users','waktu_absen'));
	}

	public function location(){
		$users = DB::table('users')
			->orderBy('location','ASC')
			->get()
			->toArray();

		$location = DB::table('location')
			->get()
			->toArray();

		foreach ($users as $user) {
			// echo $user->location . "<br>";
			for ($i=0; $i < sizeof($location); $i++) { 
				if($user->location == $location[$i]->id){
					$user->location = $location[$i]->name;
				}
			}
		}

		// echo "<pre>";
		// print_r($users);
		// print_r($location);
		// echo "</pre>";

		return view('hlocation',compact('users','location'));
	}

	public function getLocation($id){
		$users = DB::table('users')
			// ->orderBy('location','ASC')
			->where('id','=',$id)
			->get()
			->toArray();

		$location = DB::table('location')
			->get()
			->toArray();

		foreach ($users as $user) {
			// echo $user->location . "<br>";
			for ($i=0; $i < sizeof($location); $i++) { 
				if($user->location == $location[$i]->id){
					$user->location = $location[$i]->name;
				}
			}
		}
		// echo "<pre>";
		// print_r($users);
		// print_r($location);
		// echo "</pre>";
		return $users;
	}

	public function getMasuk($id){

		$users = DB::table('users')
			->where('id','=',$id)
			->get()
			->toArray();

		return $users;
	}
	public function getProfile($id){
		$users = DB::table('users')
			->where('id','=',$id)
			->get()
			->toArray();

		return $users;
	}

	public function setMasuk(Request $request){

		DB::table('users')
			->where('id','=',$request->id)
			->update(['hadir' => $request->masuk]);

		return redirect('husermanage')->with('status', $request->name);
	}

	public function setLocation(Request $request){

		DB::table('users')
			->where('id','=',$request->id)
			->update(['location' => $request->location]);

		echo "Id : " . $request->id . "<br>";
		echo "Location : " . $request->location . "<br>";
		echo "Name : " . $request->name . "<br>";

		return redirect('hlocation')->with('status', "Change location for " . $request->name . "success.");
	}

	public function addLocation(Request $request){

		DB::table('location')
			->insert([
				'name' => $request->pleace,
				'lat' => $request->lat,
				'lang' => $request->lng
				]);

		return redirect('hlocation')->with('status', "Add location for " . $request->pleace . " success.");
	}

	// public function addUser(Request $request){
	public function addUser(Request $request){
		date_default_timezone_set('Asia/Jakarta');

		// $file = $request->gambar;
		$file = $request->file('gambar');
        $fileName = $file->getClientOriginalName();
        $request->file('gambar')->move("img/", $fileName);

        if($request->born == NULL){
        	$request->born = "Born";
        }
        if($request->education == NULL){
        	$request->education = "Last education";
        }
        if($request->phone == NULL){
        	$request->phone = "Phone Number";
        }
        if($request->address == NULL){
        	$request->address = "Address Now";
        }

		$date = date('Y-m-d h:i:s', time());
		DB::table('users')
			->insert([
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'created_at' => $date,
				'updated_at' => $date,
				'location' => $request->location,
				'condition' => 'off',
				'role' => $request->role,
				'team' => $request->team,
				'gender' => $request->gender,
				'jabatan' => $request->jabatan,
				'born' => $request->born,
				'education' => $request->education,
				'phone' => $request->phone,
				'address' => $request->address,
				'hadir' => "08:00:00",
				'foto' => 'img/' . $fileName
				]);

		return redirect('husermanage')->with('status', "Add User for " . $request->name . " success.");
	}

	public function absen(){
		$location = Auth::user()->location;
		$point = DB::table('location')
			->where('id','=',$location)
			->get()
			->first();

		$id = Auth::user()->id;
		$belum = DB::table('waktu_absen')
			->where('tanggal','=',date('Y/m/d'))
			->where('id_user','=',$id)
			->get()
			->toArray();		

		if($belum == NULL){
			$sudah = "sudah";
		} else {
			$sudah = "belum";
		}


		return view('habsen',compact('point','condition','sudah'));
	}

	public function raw($id){
		$done = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->where('tanggal','=',date('Y/m/d'))
			->count();

		if ($done == 0) {

			echo "Mula " . Auth::user()->condition;
			if(Auth::user()->condition == "off"){
				$con = "on";
				$condition = DB::table('users')
					->where('id','=',$id)
					->update(['condition' => $con]);
			} else {
				$con = "off";
				$condition = DB::table('users')
					->where('id','=',$id)
					->update(['condition' => $con]);
			}
			echo "<br>Akhirnya " . $con;
			$location = Auth::user()->location;
			echo  "<br>Location : " . $location;

			date_default_timezone_set("Asia/Jakarta");
			echo "<br>" . date('H:i:s') . " ";

			// echo (date('H:i:s') <= strtotime("08:00:00") ? "<br>Yes, Late" : "<br>No, do'n Late");
			if(Auth::user()->hadir == "08:00:00")
			{
				if(time() <= strtotime("08:00:00")) {
					$late = "On-Time";
				} elseif(time() > strtotime("08:00:00") && time() <= strtotime("08:30:00")){
					$late = "Injury-Time";
				} else {
					$late = "Late";
				}
			} else {
				if(time() <= strtotime(Auth::user()->hadir)){
					$late = "On-Time";
				} elseif (time() > strtotime(Auth::user()->hadir) && time() <= strtotime(Auth::user()->hadir)+1800) {
					$late = "Injury-Time";
				} else {
					$late = "Late";
				}
			}

			$update = DB::table('waktu_absen')
				->insert([
					'id' => NULL,
					'id_user' => $id,
					'hadir' => Auth::user()->hadir,
					'jam' => date('H:i:s'),
					'tanggal' => date('Y/m/d'),
					'location' => $location,
					'late' => $late
					]);

		} else {
			echo "Anda sudah absen hari ini";
		}
	}

	public function htisygy(){
		return view('htisygy');
	}

	public function hannouncement(){
		return view('hannouncement');
	}

	public function history(){
		// echo "asdfas";
		$id = Auth::user()->id;
		$datas = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->where('tanggal','like','%-' . date('m') .'-%')
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();

		$kehadiran=DB::table('users')
			->where('id_user','=',$id)
			->join('waktu_absen','waktu_absen.id_user','=','users.id')
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();
		
		if(count($datas) > 10){
			$datas = array_slice(array_reverse($datas), 0, 9);
			$kehadiran = array_slice(array_reverse($kehadiran), 0, 9);
		} else {
			$datas = array_reverse($datas);
			$kehadiran = array_slice(array_reverse($kehadiran), 0, count($datas));
		}

		$datas2 = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->join('location','waktu_absen.location','=','location.id')
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();
		$datas2 = array_reverse($datas2);

		$location = DB::table('location')
			->get()
			->toArray();
		foreach ($datas as $data) {
			// echo $user->location . "<br>";
			for ($i=0; $i < sizeof($location); $i++) { 
				if($data->location == $location[$i]->id){
					$data->location = $location[$i]->name;
				}
			}
		}

		$late = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',auth::user()->id)
			->where('late','=','Late')
			->count();
		$injury = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',auth::user()->id)
			->where('late','=','Injury-Time')
			->count();
		$ontime = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',auth::user()->id)
			->where('late','=','On-Time')
			->count();
		$all = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',auth::user()->id)
			->count();			

		$count = [
			$late,
			$injury,
			$ontime,
			$all
		];

		if($late == 0 || $injury == 0 || $ontime == 0 || $all == 0){
			$late == 1 ;
			$injury == 1 ;
			$ontime == 1 ;
			$all = 1;
		}

		$persen = [
			$late = round($late / $all * 100,1),
			$injury = round($injury / $all * 100,1),
			$ontime = round($ontime / $all * 100,1),
		];

		$absen = 0;	

		// echo'<pre>';
		// print_r($datas);
		// echo$late."<br>";
		// echo$injury."<br>";
		// echo$ontime."<br>";
		// echo$all."<br>";
		// print_r($persen);
		// print_r($count);
		// echo'</pre>';
		return view('hhistory',compact('datas','datas2','kehadiran','persen','count','absen'));
	}

	public function teamhistory(){
		// echo "asdfas";
		$id = Auth::user()->id;
		$datas = DB::table('waktu_absen')
			->join('location','waktu_absen.location','=','location.id')
			->where('tanggal','=',date('Y/m/d'))
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();
		$datas = array_slice(array_reverse($datas), 0, 9);
		
		$datas2 = DB::table('waktu_absen')
			->join('location','waktu_absen.location','=','location.id')
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();
		$datas2 = array_reverse($datas2);

		$users = DB::table('users')
			->select('id','name','team')
			->where('team','=',AUth::user()->team)
			->orderBy('location')
			->get()
			->toArray();

		$status;
		foreach($users as $user){
			$status[] = $user->name;
		}

		foreach($users as $user){
			$IDUser[] = $user->id;
		}

		$ids = DB::table('users')
			->select('id','name','hadir','location')
			->get()
			->toarray();

		$done = DB::table('waktu_absen')
			->where('tanggal','=',date('Y/m/d'))
			->get()
			->toarray();

		

		foreach ($done as $key => $value) {

			foreach ($ids as $key2 => $value2) {
				if($value->id_user == $value2->id){
					if($value->late == "Absen"){
						// echo $value->id_user . " dia tidak masuk <br>";
						$absenToday[$key] = $value->id_user;
					}
				}
			}
		}

		foreach ($ids as $key => $value) {
			$ids[$key] = $value->id;
		}

		// echo "<pre>";
		// print_r($ids);
		// echo "</pre>";


		if(!isset($absenToday)){
			// echo "sudah absen semua";
			$absenToday = array();
			$problem = array();
			foreach ($ids as $key => $value) {
				$alasan = DB::table('waktu_absen')
					->where('id_user','=',$value)
					->where('tanggal','=',date('Y/m/d'))
					->first();
					// ->toarray();
				if($alasan == NULL){
					$problem[$key] = "No data yet";
				} else {
					$problem[$key] = $alasan->late;
				}
			}
		} else {
			$ids = array_diff($ids,$absenToday);
			foreach ($ids as $key => $value) {
				// echo $value ;
				$countQuery = DB::table('waktu_absen')
					->where('id_user','=',$value)
					->where('tanggal','=',date('Y/m/d'))
					->count();
				// echo " " . $countQuery ;
				if($countQuery == 1){
					$alasan = DB::table('waktu_absen')
						->where('id_user','=',$value)
						->where('tanggal','=',date('Y/m/d'))
						->get()
						->toarray();
					$problem[$key] = $alasan[0]->late;
					// echo " " . $alasan[0]->late . "<br>";
				} else {
					$problem[$key] = "Belum absen";
				}
			}
		}

		

		// print_r($absenToday);
		// print_r($problem);
		// print_r($done);

		foreach ($status as $key => $stat) {
			$all = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','like','%-' . date('m') .'-%')
				->get()
				->toarray();
			$late = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','like','%-' . date('m') .'-%')
				->where('late','=',"late")
				->get()
				->toarray();
			$ontime = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','like','%-' . date('m') .'-%')
				->where('late','=',"on-time")
				->get()
				->toarray();
			$injury = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','like','%-' . date('m') .'-%')
				->where('late','=',"injury-time")
				->get()
				->toarray();

			$where =  DB::table('users')
				->join('location','users.location','=','location.id')
				->where('users.id','=',$IDUser[$key])
				->select('location.name')
				->get()
				->toarray();


			$var[$stat]["all"] = sizeof($all);
			$var[$stat]["late"] = sizeof($late);
			$var[$stat]["ontime"] = sizeof($ontime);
			$var[$stat]["injury"] = sizeof($injury);
			$var[$stat]["where"] = $where[0]->name;
			$var[$stat]["id"] = $IDUser[$key];
		}

		foreach ($datas2 as $data) {
			// echo $user->location . "<br>";
			for ($i=0; $i < sizeof($users); $i++) { 
				if($data->id_user == $users[$i]->id){
					$data->id_user = $users[$i]->name;
				}
			}
		}

		foreach ($datas as $data) {
			// echo $user->location . "<br>";
			for ($i=0; $i < sizeof($users); $i++) { 
				if($data->id_user == $users[$i]->id){
					$data->id_user = $users[$i]->name;
				}
			}
		}

		$late = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('late','=','Late')
			->count();
		$injury = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('late','=','Injury-Time')
			->count();
		$ontime = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('late','=','On-Time')
			->count();
		$all = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->count();			

		$count = [
			$late,
			$injury,
			$ontime,
			$late + $injury + $ontime,
			$all - ($late + $injury + $ontime)
		];

		if($late == 0 && $injury == 0 && $ontime == 0 && $all == 0){
			$late == 1 ;
			$injury == 1 ;
			$ontime == 1 ;
			$all = 1;
		}

		$late = round($late / $all * 100,0);
		$injury = round($injury / $all * 100,0);
		$ontime = round($ontime / $all * 100,0);
		$absen = 100 - ($late + $injury + $ontime);
		$attendance = 100 - $absen;
		
		if($late == 0 && $injury == 0 && $ontime == 0){
			// $status = "kosong";
			$absen = 0;
			$attendance = 0;
		} else {
			// $status = "isi";
			$absen = 100 - ($late + $injury + $ontime);
			$attendance = 100 - $absen;
		}

		// echo $late . "<br>";
		// echo $injury . "<br>";
		// echo $ontime . "<br>";
		// echo $all . "<br>";

		// echo "<pre>";
		// print_r($var);
		// print_r($IDUser);
		// print_r($status);
		// print_r($users);
		// print_r($datas2);
		// echo "</pre>";
		return view('hteamhistory',compact('datas','datas2','var','status','late','injury','ontime','count','absen','attendance','absenToday','ids','problem'));
	}

	function huserhistory ($id){

		$datas = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->where('tanggal','like','%-' . date('m') .'-%')
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();

		$kehadiran=DB::table('users')
			->where('id_user','=',$id)
			->join('waktu_absen','waktu_absen.id_user','=','users.id')
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();
		
		if(count($datas) > 10){
			$datas = array_slice(array_reverse($datas), 0, 9);
			$kehadiran = array_slice(array_reverse($kehadiran), 0, 9);
		} else {
			$datas = array_reverse($datas);
			$kehadiran = array_slice(array_reverse($kehadiran), 0, count($datas));
		}

		$location = DB::table('location')
			->get()
			->toArray();

		foreach ($datas as $data) {
			// echo $user->location . "<br>";
			for ($i=0; $i < sizeof($location); $i++) { 
				if($data->location == $location[$i]->id){
					$data->location = $location[$i]->name;
				}
			}
		}

		$name = DB::table('users')
			->where('id','=',$id)
			->get();
		$name = $name[0]->name;

		$late = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',$id)
			->where('late','=','Late')
			->count();
		$injury = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',$id)
			->where('late','=','Injury-Time')
			->count();
		$ontime = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',$id)
			->where('late','=','On-Time')
			->count();
		$all = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',$id)
			->count();

		$count = [
			$late,
			$injury,
			$ontime,
			$all - ($late + $injury + $ontime),
			$late + $injury + $ontime
		];

		if($late == 0 && $injury == 0 && $ontime == 0 && $all == 0){
			$late == 1 ;
			$injury == 1 ;
			$ontime == 1 ;
			$all = 1;
		}

		$late = round($late / $all * 100,1);
		$injury = round($injury / $all * 100,1);
		$ontime = round($ontime / $all * 100,1);

		if($late == 0 && $injury == 0 && $ontime == 0){
			$status = "kosong";
			$absen = 0;
			$attendance = 0;
		} else {
			$status = "isi";
			$absen = 100 - ($late + $injury + $ontime);
			$attendance = 100 - $absen;
		}

		$data = [$count,$late,$injury,$ontime,$absen,$name,$datas,$kehadiran,$id,$attendance,$status];
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		return $data;
	}

	function download($id){

		$datas = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->where('tanggal','like','%-' . date('m') .'-%')
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();
		$kehadiran=DB::table('users')
			->where('id_user','=',$id)
			->join('waktu_absen','waktu_absen.id_user','=','users.id')
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();

		$location = DB::table('location')
			->get()
			->toArray();

		foreach ($datas as $data) {
			// echo $user->location . "<br>";
			for ($i=0; $i < sizeof($location); $i++) { 
				if($data->location == $location[$i]->id){
					$data->location = $location[$i]->name;
				}
			}
		}

		$late = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',$id)
			->where('late','=','Late')
			->count();
		$injury = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',$id)
			->where('late','=','Injury-Time')
			->count();
		$ontime = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',$id)
			->where('late','=','On-Time')
			->count();
		$all = DB::table('waktu_absen')
			->where('tanggal','like','%-' . date('m') .'-%')
			->where('id_user','=',$id)
			->count();

		$count = [
			$late,
			$injury,
			$ontime,
			0,
			$all
		];

		$late = round($late / $all * 100,1);
		$injury = round($injury / $all * 100,1);
		$ontime = round($ontime / $all * 100,1);
		$absen = 0;
		$name = DB::table('users')
			->where('id','=',$id)
			->get();

		$name = $name[0]->name;

		// echo "<pre>";
		// print_r($datas);
		// echo "</pre>";

		$adsen = 0;

		$pdf = PDF::loadView('pdf', compact('datas','kehadiran','count','name','absen'));
		return $pdf->stream("asd.pdf");
	}

	function schedule (){
		$ids = DB::table('users')
			->select('id','name','hadir','location')
			->get()
			->toarray();

		date_default_timezone_set("Asia/Tehran");
		foreach ($ids as $key => $value) {
			$date = (int)substr($value->hadir, 0, 2);
			$date = $date + 1;
			$date = sprintf("%02d", $date);

			echo $date . "<br>";
			if(date("H")  == $date){
				$count = DB::table('waktu_absen')
					->where('id_user','=',$value->id)
					->where('tanggal','=',date('Y/m/d'))
					->count();
				echo $value->id . " " . $count . " " . substr($value->hadir, 0, 2) . " > " . date("H") ."<br>";
				if($count == 0){
					$update = DB::table('waktu_absen')
						->insert([
							'id' => NULL,
							'id_user' => $value->id,
							'hadir' => $value->hadir,
							'jam' => date('H:i:s'),
							'tanggal' => date('Y/m/d'),
							'location' => $value->location,
							'late' => "Absent"
							]);

				} else {
					echo "----sudah absen<br>";
				}
			} else {
				echo "not<br>";
			}
		}

		echo "<pre>";
		print_r($ids);
		echo "</pre>";
		// return 0;
	}

	function changeAbsent(Request $req,$id){
		echo $id . " alasan " . $req->alasan;

		$update = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->where('tanggal','=',date('Y/m/d'))
			->update(['late' => $req->alasan]);
		return redirect()->back();		
	}

	function editUser(Request $request){
		
		if($request->name == NULL){
        	$request->name = Auth::user()->name;
        }
        if($request->email == NULL){
        	$request->email = Auth::user()->email;
        }
        if($request->gender == NULL){
        	$request->gender = Auth::user()->gender;
        }
        if($request->born == NULL){
        	$request->born = Auth::user()->born;
        }
        if($request->education == NULL){
        	$request->education = Auth::user()->education;
        }
        if($request->phone == NULL){
        	$request->phone = Auth::user()->phone;
        }
        if($request->address == NULL){
        	$request->address = Auth::user()->address;
        }
        if($request->gambar == NULL){
        	echo $request->name . "<br>";
			echo $request->email . "<br>";
			echo $request->gender . "<br>";
			echo $request->born . "<br>";
			echo $request->education . "<br>";
			echo $request->phone . "<br>";
			echo $request->address . "<br>";
        	auth::user()->gambar;
	        $update = DB::table('users')
			->where('id','=',$request->id)
			->update([
				'name' => $request->name,
				'email' => $request->email,
				'gender' => $request->gender,
				'born' => $request->born,
				'education' => $request->education,
				'phone' => $request->phone,
				'address' => $request->address,
				'foto' => 'img/' . Auth::user()->foto
			]);
			return redirect()->back();
        }else{
        	$file = $request->file('gambar');
	        $fileName = $file->getClientOriginalName();
	        $request->file('gambar')->move("img/", $fileName);
	        $update = DB::table('users')
			->where('id','=',$request->id)
			->update([
				'name' => $request->name,
				'email' => $request->email,
				'gender' => $request->gender,
				'born' => $request->born,
				'education' => $request->education,
				'phone' => $request->phone,
				'address' => $request->address,
				'foto' => 'img/' . $fileName
			]);
			return redirect()->back();
        }
	}
}
