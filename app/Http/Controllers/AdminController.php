<?php
 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use PDF;
use Mail;
use App\Mail\Ticket;
use App\Mail\TicketMail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class AdminController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->middleware('auth');
		// date_default_timezone_set("ETC/GMT-5");
		// date_default_timezone_set("Asia/Jakarta");
		// echo date('H:i:s');
		$debug = DB::table('console')
			->where('id_user','=',4)
			->value('mode');
	}
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$users = DB::table('users')
			->where('team','=',Auth::user()->team)
			->orderBy('condition', 'desc')
			// ->limit(9)
			->get();
		$onwork_users = DB::table('users')
			->where('condition','=','on')
			->count();
		$offwork_users = DB::table('users')
			->where('condition','=','off')
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
		if($late == 0 && $injury == 0 && $ontime == 0 && $all == 0){
			$late = 1;
			$injury = 1;
			$ontime = 1;
			$all = 1;
		}
		$count = [
			$late,
			$injury,
			$ontime,
			$late + $injury + $ontime,
			$absen = $all - ($late + $injury + $ontime)
		];
		$persen = [
			$late = round($late / $all * 100,0),
			$injury = round($injury / $all * 100,0),
			$ontime = round($ontime / $all * 100,0),
			$absen = 100 - ($late + $injury + $ontime),
			$attendance = 100 - $absen
		];
		//('datas','datas2','kehadiran','persen','count','absen'));
		// echo "<pre>";
		// print_r($persen);
		// print_r($count);
		// echo "</pre>";
		
		return view('admin',compact('data','users','persen','count','absen'));
	}
	public function test_page(){
		return view('test_page');
	}
	public function usermanage(){
		$users = DB::table('users')
			->orderBy('condition', 'desc')
			// ->limit(9)
			->get()
			->toArray();
		$shifting = DB::table('users')
			->where('shifting','=','shifitng')
			->get();	
		$waktu_absen = DB::table('waktu_absen')
			->get()
			->toArray();
		$location = DB::table('location')
			->get()
			->toArray();
		$presents_timing = DB::table('present_timing')
			->get()
			->toArray();
		$privileges = DB::table('privilege')
			->get();

		// $shifting = DB::table('users')
		// echo "<pre>";
		// print_r($privileges);
		// echo "</pre>";
		// Auth::user()->name = "Rama";
		// echo Auth::user()->name;
		return view('usermanage',compact('users','waktu_absen','location','presents_timing','privileges','shifting'));
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
	public function asycal(){
		return view('asycal',compact('users','waktu_absen'));
	}
	public function jsonAsycal(){
		$data = array(
			[
				'id' => 1,
				'title'=> 'All Day Event',
				'start'=> '2017-08-01',
				'className' => 'redEvent',
				// 'backgroundColor'=> "#f56954", //red
				// 'borderColor'=> "#f56954" //red
			],
			[
				'id' => 2,
				'title'=> 'Long Event',
				'start'=> '2017-08-14',
				'end'=> '2017-08-17',
				'className' => 'yellowEvent',
				// 'backgroundColor'=> "#f39c12", //yellow
				// 'borderColor'=> "#f39c12" //yellow
			],
			[
				'id' => 3,
				'title'=> 'Meeting',
				'start'=> '2017-08-07T10:30:00',
				'allDay'=> false,
				'className' => 'blueEvent',
				// 'backgroundColor'=> "#0073b7", //Blue
				// 'borderColor'=> "#0073b7" //Blue
			],
			[
				'id' => 4,
				'title'=> 'Lunch',
				'start'=> '2017-08-20T12:00:00',
				'end'=> '2017-08-20T14:00:00',
				'allDay'=> false,
				'className' => 'infoEvent',
				// 'backgroundColor'=> "#00c0ef", //Info (aqua)
				// 'borderColor'=> "#00c0ef" //Info (aqua)
			],
			[
				'id' => 5,
				'title'=> 'Birthday Party',
				'start'=> '2017-08-15T19:00:00',
				'end'=> '2017-08-15T23:00:00',
				'allDay'=> false,
				'className' => 'successEvent',
				// 'backgroundColor'=> "#00a65a", //Success (green)
				// 'borderColor'=> "#00a65a" //Success (green)
			],
			[
				'id' => 6,
				'title'=> 'Click for Google',
				'start'=> '2017-08-28',
				'end'=> '2017-08-29',
				'className' => 'primaryEvent',
				'url'=> 'http://google.com/',
				// 'backgroundColor'=> "#3c8dbc", //Primary (light-blue)
				// 'borderColor'=> "#3c8dbc" //Primary (light-blue)
			]
		);
		$data2 = DB::table('calendar')
			->get()
			->toArray();
		return $data2;
	}
	public function createAsycal(Request $req){
		DB::table('calendar')
			->insert([
					'id' => NULL,
					'title' => $req->title,
					'start' => $req->start,
					'end' => $req->end,
					'allDay' => 1,
					'className' => 'successEvent'
				]);
		return $req->end;
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
			for ($i=0; $i < sizeof($location); $i++) { 
				if($user->location == $location[$i]->id){
					$user->location = $location[$i]->name;
				}
			}
		}
		$privileges = DB::table('privilege')
			->get();
		// echo "<pre>";
		// print_r($users);
		// print_r($location);
		// echo "</pre>";
		return view('location',compact('users','location','privileges'));
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
		$result = DB::table('present_timing')
			->where('id',$users[0]->present_timing)
			->value('name');
		$result = [$users[0]->id,$users[0]->name,$result];
		return $result;
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
			->update(['present_timing' => $request->masuk]);
		return redirect('usermanage')->with('status', $request->name);
	}
	public function setLocation(Request $request){
		DB::table('users')
			->where('id','=',$request->id)
			->update(['location' => $request->location]);
		echo "Id : " . $request->id . "<br>";
		echo "Location : " . $request->location . "<br>";
		echo "Name : " . $request->name . "<br>";
		return redirect('location')->with('status', "Change location for " . $request->name . "success.");
	}
	public function addLocation(Request $request){
		DB::table('location')
			->insert([
				'name' => $request->pleace,
				'lat' => $request->lat,
				'lang' => $request->lng,
				'radius' => '500'
				]);
		return redirect('location')->with('status', "Add location for " . $request->pleace . " success.");
	}
	public function getLocationAfter(Request $req){
		$getProject = DB::table('project')
			->where('id_location','=',$req->location)
			// ->get()
			->value('project');
		return $getProject;
		// $req->location;
	}
	// public function project(Request $req){
	// 	$project = DB::table('project')
	// 		->where('id','=',$req->id)
	// 		->where('project','=',$req->project)
	// 		->where('shifting','=',$req->shifting)
	// 		->where('id_location','=',$req->request)
	// 		->get()
	// 		->firs();
	// }
	
	public function addUser(Request $request){
		date_default_timezone_set('Asia/Jakarta');
		
		// $fileName = $request->gambar;
		// $fileName = $request->file('gambar')->getClientOriginalName();
		// $request->file('gambar')->move('img/user.png', $fileName);
		
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
				'nickname' => "$request->nickname",
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
				'shifting' => 0,
				'education' => $request->education,
				'phone' => $request->phone,
				'address' => $request->address,
				'hadir' => "00:00:00",
				'foto' => 'img/user.png',
				'present_timing' => '1'
				]);
		return redirect('usermanage')->with('status', "Add User for " . $request->name . " success.");
	}

	public function addUserShifting(Request $request){
		$date = date('Y-m-d h:i:s', time());
		if(DB::table('detail_users')->where('id_user',$request->id_user,)->where('on_project',$request->on_project)->get() == NULL){
			DB::table('detail_users')
			->insert([
				'id_user' => $request->id_user,
				'on_project' => $request->on_project,
				]);
			return redirect('schedule')->with('message', "Add User " . " success.");
		} else {
			DB::table('shifting')
			->where('id_user','=',$request->id_user)
			->delete();
			DB::table('detail_users')
			->where('id_user','=',$request->id_user)
			->delete();
			DB::table('detail_users')
			->insert([
				'id_user' => $request->id_user,
				'on_project' => $request->on_project,
				]);
			return redirect('schedule')->with('message', "Add User " . " success.");
		}
		
	}
	
	public function absen(){
		// if(Auth::user()->shifting == 1){
		// } else {
			date_default_timezone_set("Asia/Jakarta");
			$location = Auth::user()->location;
			$point = DB::table('location')
				->where('id','=',$location)
				->get()
				->first();
			$id = Auth::user()->id;
			
			$hari_malam = date('d') - 1;
			$hari_malam = date('Y/m/') . $hari_malam;
			$pulang_malam = DB::table('waktu_absen')
				->where('id_user','=',$id)
				->where('tanggal','=',$hari_malam)
				->value('hadir');
			
			$pulang = DB::table('waktu_absen')
				->where('id_user','=',$id)
				->where('tanggal','=',$hari_malam)
				->value('pulang');
			
			$belum = DB::table('waktu_absen')
				->where('tanggal','=',date('Y/m/d'))
				->where('id_user','=',$id)
				->get()
				->first();
			$start = DB::table('shifting')
				->where('id_user','=',Auth::user()->id)
				->where('start','LIKE',date('Y-m-d') . '%')
				->first();			
			// echo $pulang . "<br>";
			// echo $pulang_malam . "<br>";
			// echo $hari_malam . "<br>";
			// echo date('Y/m/d') . "<br>";
			// if($start == ''){
				
			// }else{
				
			// }
			// echo "<br><pre>";
			// print_r($belum);	
			// echo "</pre>";
			
			if($belum == NULL){
				if($pulang_malam == "22:00:00"){
					if(date('Y/m/d') != $hari_malam){
						$sudah = "belum";
					} else {
						$kemaren = DB::table('waktu_absen')
							->where('id_user','=',$id)
							->where('tanggal','=',$hari_malam)
							->value('late');
						if($kemaren == "On-Time"){
							$keterangan = 1;
						} else if($kemaren == "Injury-Time") {
							$keterangan = 2;
						} else if ($kemaren == "Late") {
							$keterangan = 3;
						} else if ($kemaren == "Absen"){
							$keterangan = 4;
						}
						$sudah = "sudah";
						$pulang = DB::table('waktu_absen')
							->where('id_user','=',$id)
							->where('tanggal','=',$hari_malam)
							->value('pulang');
						if($pulang == "" ){
							$sudah_pulang = "belum";
						} else {
							$sudah_pulang = "sudah";
						}
					}
				} else {
					$sudah = "belum";
					$sudah_pulang = "belum";
					$keterangan=0;
				}
			} else {
				$sudah = "sudah";
				
				if($belum->late == "On-Time"){
					$keterangan = 1;
				} else if($belum->late == "Injury-Time") {
					$keterangan = 2;
				} else if ($belum->late == "Late") {
					$keterangan = 3;
				} else if ($belum->late == "Absen"){
					$keterangan = 4;
				}
				
				$pulang = DB::table('waktu_absen')
					->where('id_user','=',$id)
					->where('tanggal','=',date('Y/m/d'))
					->value('pulang');
				if($pulang == "" ){
					$sudah_pulang = "belum";
				} else {
					$sudah_pulang = "sudah";
					// $tidakShifting = "true";
				}
			}
			if(Auth::user()->shifting == 1 ){
				$getSchedule = DB::table('shifting')
					->where('id_user','=',Auth::user()->id)
					->where('start','LIKE',date('Y-m-d') . '%')
					->first();
				// echo "<pre>";
				// print_r($getSchedule);
				// echo "</pre>";
				if($getSchedule == NULL){
					// $tidakShifting = true;
					$sudah = "sudah";
					$keterangan = 6;
				} else {
				
					$liburCondition = substr($getSchedule->start, 11,5);
					if($liburCondition == "Libur"){
						$sudah = "sudah";
						$keterangan = 5;
	
					}
				}
			}
				
			$layout = 'layouts.admin.layout';
			return view('absen',compact('sudah', 'keterangan', 'layout', 'sudah_pulang', 'point'));
				
	}
	public function createPresenceLocation(Request $request){
		$id_absen = DB::table('waktu_absen')
			->orderBy('id','DESC')	
			->value('id');
		DB::table('absen_location')
			->insert([
				'id' => NULL,
				'id_absen' => $id_absen,
				'condition_presence' => $request->condition,
				'lat' => $request->lat,
				'lng' => $request->lng
			]);
	}
	public function raw($id){
		date_default_timezone_set("Asia/Jakarta");
		$hari_malam = date('d') - 1;
		$hari_malam = date('Y/m/') . $hari_malam;
		$pulang_malam = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->where('tanggal','=',$hari_malam)
			->value('hadir');
		echo "Jadwal masuk kemaren " . $pulang_malam . "<br>Hari Malam : " . $hari_malam . "<br><br>";
		$done = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->where('tanggal','=',date('Y/m/d'))
			->count();
		$con = "on";
		$condition = DB::table('users')
			->where('id','=',$id)
			->update(['condition' => $con]);	
		// if ($done == 0 || Auth::user()->id == "4") {
		if ($done == 0) {
			echo "Online - Offline<br>";
			echo "--Mula " . Auth::user()->condition;
			// if(Auth::user()->condition == "off"){
				
			// } else {
				
			// }
			echo "<br>--Akhirnya " . $con;
			$location = Auth::user()->location;
			echo  "<br><br>Location : " . $location . "<br>";
			date_default_timezone_set("Asia/Jakarta");
			echo "<br> Jam sekarang : " . date('H:i:s') . " <br>";
			echo "Harus hadir : " . Auth::user()->hadir . "<br><br>";
			
			echo "Menggunakan present timing : " . Auth::user()->present_timing . "<br><br>";
			$now = time();
			// $now = time() - 3600;
			if(Auth::user()->shifting == 0)
			{
				echo "<b>Non-Shifting</b><br>";
				$on_time = DB::table('present_timing')
					->where('id',Auth::user()->present_timing)
					->value('on_time');
				$injury_time = DB::table('present_timing')
					->where('id',Auth::user()->present_timing)
					->value('injury_time');
				$late_time = DB::table('present_timing')
					->where('id',Auth::user()->present_timing)
					->value('late_time');
				if($now <= strtotime($on_time)) {
					$late = "On-Time";
					echo $now . "<br>";
					echo "On-Time <br>";
				// 08:16 lebih akan late
				} else if ($now <= strtotime($injury_time)) {
					$late = "Injury-Time";
					echo $now . "<br>";
					echo "Injury-Time<br>";
				} else if ($now >= strtotime($late_time)) {
					$late = "Late";
					echo $now . "<br>";
					echo "Late-Time<br>";
				}
				$insert = DB::table('waktu_absen')
					->insert([
						'id' => NULL,
						'id_user' => $id,
						'hadir' => date('H:i:s',strtotime($on_time)),
						'jam' => date('H:i:s',time()),
						'tanggal' => date('Y/m/d'),
						'location' => $location,
						'late' => $late
					]);
			} else {
				$getSchedule = DB::table('shifting')
					->where('id_user','=',$id)
					->where('start','LIKE',date('Y-m-d') . '%')
					->first();
				echo "<b>Shifting</b><br>";
				echo "<pre>";
				print_r($getSchedule);
				echo $now;
				echo "</pre>";
				if($getSchedule){
					$masuk = date('H:i:s',strtotime($getSchedule->start) - 25200);
					// $masuk = "22:40:00";
					echo "asdfadsasdfads " . $masuk;
					echo "<br> Jadwalnya " . date('H:i:s',strtotime($masuk)) . " " . strtotime($masuk);
					echo "<br> Sekarangg " . date('H:i:s',time()) . " " . time();
					echo "<br>";
					if($now <= strtotime($masuk) + 60){
						$late = "On-Time";
					} elseif ($now > strtotime($masuk) + 60 && $now <= strtotime($masuk) + 930) {
						$late = "Injury-Time";
					} else {
						$late = "Late";
					}
					$insert = DB::table('waktu_absen')
					->insert([
						'id' => NULL,
						'id_user' => $id,
						'hadir' => $masuk,
						'jam' => date('H:i:s',time()),
						'tanggal' => date('Y/m/d'),
						'location' => $location,
						'late' => $late
					]);
				} else {
					$late = "On-Time";
					$insert = DB::table('waktu_absen')
					->insert([
						'id' => NULL,
						'id_user' => $id,
						'hadir' => "00:08:00",
						'jam' => date('H:i:s',time()),
						'tanggal' => date('Y/m/d'),
						'location' => $location,
						'late' => $late
					]);
				}
			}
			echo "<br>" . date('Y-m-d');
			echo "<br>" . $late;
		} else {
			echo "Anda sudah absen hari ini ";
			$pulang = DB::table('waktu_absen')
				->where('id_user','=',$id)
				->where('tanggal','=',date('Y/m/d'))
				->value('pulang');
			$pulang2 = DB::table('waktu_absen')
				->where('id_user','=',$id)
				->where('tanggal','=',$hari_malam)
				->value('pulang');
			$sql = DB::table('waktu_absen')
				->where('id_user','=',$id)
				->where('tanggal','=',$hari_malam)
				// ->value('pulang')
				->toSql();
				
			$con = "off";
			$condition = DB::table('users')
				->where('id','=',$id)
				->update(['condition' => $con]);	
			echo "<br> sql pulang2 : ";
			echo($sql);
			echo "<br> pulang : " . $pulang;
			echo "<br> pulang2 : " . $pulang2;
			if($pulang == null || $pulang2 == null){
				$shifting = DB::table('users')
					->where('id',$id)
					->value('shifting');
				if($shifting == 1){
					echo "<br>Shifting --";
					if($pulang2 != null){
						$Date = date('Y-m-d');
						$hari_malam2 = date('Y-m-d', strtotime($Date. ' - 1 days'));
						$waktu_pulang = DB::table('shifting')
							->where('id_user','=',$id)
							->where('start','LIKE',$hari_malam2 . "%")
							// ->where('start','LIKE',$hari_malam . "%")
							->value('end');
							
						$harus_pulang = substr(substr($waktu_pulang,11),0,8);
						$id = DB::table('waktu_absen')
							->where('id_user','=',$id)
							->where('tanggal','=',$hari_malam)
							->value('id');
						echo $id;
						echo "<br> Dia harus absen pulang malam";
						
						echo " -- " . $hari_malam . " -- " . $id;
						DB::table('waktu_absen')
							->where('id',$id)
							->update(['pulang' => date('H:i:s',time()),'harus_pulang' => $harus_pulang]);
					} else {
						$waktu_pulang = DB::table('shifting')
							->where('id_user','=',$id)
							->where('end','LIKE',date('Y-m-d') . "%")
							->value('end');
							
						$harus_pulang = substr(substr($waktu_pulang,11),0,8);
						$id = Auth::user()->id;
						$id = DB::table('waktu_absen')
							->where('id_user','=',$id)
							->where('tanggal','=',date('Y/m/d'))
							->value('id');
						echo $harus_pulang;
						echo "<br> Dia tidak pulang malam";
						DB::table('waktu_absen')
							->where('id',$id)
							->update(['pulang' => date('H:i:s',time()),'harus_pulang' => $harus_pulang]);
					}
				} else {
					if($id == 40){
						$pulangnya = "17:30:00";
					} else {
						$pulangnya = "16:30:00";
					}
					$id = DB::table('waktu_absen')
						->where('id_user','=',$id)
						->where('tanggal','=',date('Y/m/d'))
						->value('id');
					DB::table('waktu_absen')
						->where('id',$id)
						->update(['pulang' => date('H:i:s',time()), 'harus_pulang' => $pulangnya]);
				}
			} else {
				echo "<br>Anda sudah absen pulang hari ini ";
			}
		}
	}
	public function getRecentTicket(){
		$data = DB::table('Ticket')
			->orderBy('nomor','DESC')
			->get();
		return $data;
	}
	public function announcement(){
		return view('announcement');
	}
	public function historydet(){
		$id = Auth::user()->id;
		
		$tanggal = date('Y') . "-" . date('m') . "%";
		
		$datadet = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->where('tanggal','like',$tanggal)
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();
			
	
			$kehadiran = DB::table('users')
				->where('id_user','=',$id)
				->join('waktu_absen','waktu_absen.id_user','=','users.id')
				->orderBy('tanggal','ASC')
				->orderBy('jam','ASC')
				->get()
				->toarray();
			
			if(count($datadet) > 10){
				$datadet = array_slice(array_reverse($datadet), 0, 9);
				$kehadiran = array_slice(array_reverse($kehadiran), 0, 9);
			} else {
				$datadet = array_reverse($datadet);
				$kehadiran = array_slice(array_reverse($kehadiran), 0, count($datadet));
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
			foreach ($datadet as $data) {
				// echo $user->location . "<br>";
				for ($i=0; $i < sizeof($location); $i++) { 
					if($data->location == $location[$i]->id){
						$data->location = $location[$i]->name;
					}
				}
			}
	
			$late = DB::table('waktu_absen')
				->where('tanggal','like',$tanggal)
				->where('id_user','=',auth::user()->id)
				->where('late','=','Late')
				->count();
			$injury = DB::table('waktu_absen')
				->where('tanggal','like',$tanggal)
				->where('id_user','=',auth::user()->id)
				->where('late','=','Injury-Time')
				->count();
			$ontime = DB::table('waktu_absen')
				->where('tanggal','like',$tanggal)
				->where('id_user','=',auth::user()->id)
				->where('late','=','On-Time')
				->count();
			$all = DB::table('waktu_absen')
				->where('tanggal','like',$tanggal)
				->where('id_user','=',auth::user()->id)
				->count();			
	
			$count = [
				$late,
				$injury,
				$ontime,
				$late + $injury + $ontime,
				$absen = $all - ($late + $injury + $ontime)
			];
	
			if($late == 0 && $injury == 0 && $ontime == 0 && $all == 0){
				$late == 1 ;
				$injury == 1 ;
				$ontime == 1 ;
				$all = 1;
			}
	
			$persen = [
				$late = round($late / $all * 100,0),
				$injury = round($injury / $all * 100,0),
				$ontime = round($ontime / $all * 100,0),
				$absen = 100 - ($late + $injury + $ontime),
				$attendance = 100 - $absen
			];
		
			return view('ahistory2',compact('datadet','datas2','kehadiran','persen','count','absen'));
	}
	public function history(){
		// echo "asdfas";
		$id = Auth::user()->id;
		$tanggal = date('Y') . "-" . date('m') . "%";
		// echo $tanggal;
		$datas = DB::table('waktu_absen')
			->where('id_user','=',$id)
			->where('tanggal','like',$tanggal)
			->orderBy('tanggal','DESC')
			->orderBy('jam','DESC')
			->limit(4)
			->get()
			->toarray();
		$kehadiran = DB::table('users')
			->where('id_user','=',$id)
			->join('waktu_absen','waktu_absen.id_user','=','users.id')
			->orderBy('tanggal','DESC')
			->orderBy('jam','DESC')
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
			->where('tanggal','like',$tanggal)
			->where('id_user','=',auth::user()->id)
			->where('late','=','Late')
			->count();
		$injury = DB::table('waktu_absen')
			->where('tanggal','like',$tanggal)
			->where('id_user','=',auth::user()->id)
			->where('late','=','Injury-Time')
			->count();
		$ontime = DB::table('waktu_absen')
			->where('tanggal','like',$tanggal)
			->where('id_user','=',auth::user()->id)
			->where('late','=','On-Time')
			->count();
		$all = DB::table('waktu_absen')
			->where('tanggal','like',$tanggal)
			->where('id_user','=',auth::user()->id)
			->count();			
		$count = [
			$late,
			$injury,
			$ontime,
			$late + $injury + $ontime,
			$absen = $all - ($late + $injury + $ontime)
		];
		if($late == 0 && $injury == 0 && $ontime == 0 && $all == 0){
			$late == 1 ;
			$injury == 1 ;
			$ontime == 1 ;
			$all = 1;
		}
		$persen = [
			$late = round($late / $all * 100,0),
			$injury = round($injury / $all * 100,0),
			$ontime = round($ontime / $all * 100,0),
			$absen = 100 - ($late + $injury + $ontime),
			$attendance = 100 - $absen
		];
		// $absen = 0;	
		// echo'<pre>';
		// print_r($datas);
		// echo$late."<br>";
		// echo$injury."<br>";
		// echo$ontime."<br>";
		// echo$all."<br>";
		// print_r($persen);
		// print_r($count);
		// echo'</pre>';
		return view('ahistory',compact('datas','datas2','kehadiran','persen','count','absen'));
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
					$hours = DB::table('users')
							->select('hadir')
							->where('id','=',$value)
							->get()->toArray();
					if(date_format(date_add(date_create($hours[0]->hadir),date_interval_create_from_date_string("8 hours")),'H:i:s') < date('H:i:s')){
						// echo "<br>Dia libur";
						$problem[$key] = "Libur";
					} else {
						// echo "<br>Dia tidak Libur";
						// $problem[$key] = "Belum absen";
						$problem[$key] = "No data yet";
					}
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
				// echo "<br>" . $countQuery ;
				if($countQuery == 1){
					$alasan = DB::table('waktu_absen')
						->where('id_user','=',$value)
						->where('tanggal','=',date('Y/m/d'))
						->get()
						->toarray();
					$problem[$key] = $alasan[0]->late;
					// echo " " . $alasan[0]->late . "<br>";
				} else {
					$hours = DB::table('users')
							->select('hadir')
							->where('id','=',$value)
							->get()->toArray();
					if(date_format(date_add(date_create($hours[0]->hadir),date_interval_create_from_date_string("8 hours")),'H:i:s') < date('H:i:s')){
						// echo "<br>Dia libur";
						$problem[$key] = "Libur";
					} else {
						// echo "<br>Dia tidak Libur";
						$problem[$key] = "Belum absen";
					}
					// echo date_format(date_add(date_create($hours[0]->hadir),date_interval_create_from_date_string("8 hours")),'H:i:s') . " -- " . date('H:i:s');
					
				}
			}
		}
		
		// echo "<pre>";
		// print_r($absenToday);
		// print_r($problem);
		// print_r($done);
		// echo "</pre>";
		foreach ($status as $key => $stat) {
			$all = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','like','%' . date('y') . '-' . date('m') .'-%')
				->get()
				->toarray();
			$late = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','like','%' . date('y') . '-' . date('m') .'-%')
				->where('late','=',"late")
				->get()
				->toarray();
			$ontime = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','like','%' . date('y') . '-' . date('m') .'-%')
				->where('late','=',"on-time")
				->get()
				->toarray();
			$injury = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','like','%' . date('y') . '-' . date('m') .'-%')
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
			->where('tanggal','like','%' . date('y') . '-' . date('m') .'-%')
			->where('late','=','Late')
			->count();
		$injury = DB::table('waktu_absen')
			->where('tanggal','like','%' . date('y') . '-' . date('m') .'-%')
			->where('late','=','Injury-Time')
			->count();
		$ontime = DB::table('waktu_absen')
			->where('tanggal','like','%' . date('y') . '-' . date('m') .'-%')
			->where('late','=','On-Time')
			->count();
		$all = DB::table('waktu_absen')
			->where('tanggal','like','%' . date('y') . '-' . date('m') .'-%')
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
		// print_r($absenToday);
		// print_r($ids);
		// print_r($IDUser);
		// print_r($status);
		// print_r($users);
		// print_r($datas2);
		// echo "</pre>";
		return view('admin.teamhistory',compact('datas','datas2','var','status','late','injury','ontime','count','absen','attendance','absenToday','ids','problem'));
	}
	public function auserhistory ($id,$start = 0,$end = 0){
	
		if($start == 0 && $end == 0){
			$datas = DB::table('waktu_absen')
				->where('id_user','=',$id)
				->where('tanggal','like','%' . date('y') . '-' . date('m') .'-%')
				->orderBy('tanggal','ASC')
				->orderBy('jam','ASC')
				->get()
				->toarray();
		} else {
			$datas = DB::table('waktu_absen')
				->where('id_user','=',$id)
				->where('tanggal','>=',$start)
				->where('tanggal','<=',$end)
				->orderBy('tanggal','ASC')
				// ->orderBy('jam','ASC')
				->get()
				->toarray();
			$datas = $this->getAbsen($start,$end,$id)->toarray();
		}
		$kehadiran = DB::table('users')
			->where('id_user','=',$id)
			->join('waktu_absen','waktu_absen.id_user','=','users.id')
			->orderBy('tanggal','ASC')
			->orderBy('jam','ASC')
			->get()
			->toarray();
		
		if(count($datas) > 10){
			if($start == 0 && $end == 0){
				$datas = array_slice(array_reverse($datas), 0, 9);
				$kehadiran = array_slice(array_reverse($kehadiran), 0, 9);
			}
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
		if($start != 0 && $end != 0){
			$late = DB::table('waktu_absen')
				->where('tanggal','>=',$start)
				->where('tanggal','<=',$end)
				->where('id_user','=',$id)
				->where('late','=','Late')
				->count();
			$injury = DB::table('waktu_absen')
				->where('tanggal','>=',$start)
				->where('tanggal','<=',$end)
				->where('id_user','=',$id)
				->where('late','=','Injury-Time')
				->count();
			$ontime = DB::table('waktu_absen')
				->where('tanggal','>=',$start)
				->where('tanggal','<=',$end)
				->where('id_user','=',$id)
				->where('late','=','On-Time')
				->count();
			$all = DB::table('waktu_absen')
				->where('tanggal','>=',$start)
				->where('tanggal','<=',$end)
				->where('id_user','=',$id)
				->count();
		} else {
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
		}
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
		if ($all != 0){
			$status = "absen";
			$absen = 100;
			$attendance = 0;
		} else  if($late == 0 && $injury == 0 && $ontime == 0 ){
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
		// print_r($all);
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
		$tittle = 'My Attendence';
		$pdf = PDF::loadView('pdf', compact('datas','kehadiran','count','name','absen'));
		return $pdf->stream($tittle .".pdf");
	}
	public function changeMonth(Request $req){
		return $this->schedule($req->start);
	}
	public function schedule ($month = "") {
		$nameUsers = DB::table('users')
			->where('shifting', 'LIKE', '%1%')
			->get();
		
		$nameUsersShif = DB::table('users')
			->where('shifting', 'LIKE', '%0%')
			->get();
		$nameUsersShif2 = DB::table('users')
			->where('shifting', 'LIKE', '%1%')
			->get();	

		$users = DB::table('detail_users')
			->join('users','users.id','=','detail_users.id_user')
			->join('project','project.id','=','detail_users.on_project')
			->select('users.id','users.name','project.project','detail_users.on_project')
			->get()
			->toArray();
		if($month == ""){
			$when = date('Y-m');
		} else {
			$when = $month;
		}
		foreach ($users as $user) {
			$user->shift_malam = 0;$user->shift_sore = 0;$user->shift_pagi = 0;$user->shift_libur = 0;
			
			$shifts = DB::table('shifting')
				->where('id_user','=',$user->id)
				->where('start','LIKE',$when . '%')
				->get()
				->toArray();
			
			foreach ($shifts as $shift) {
				if($shift->className == "pagi" || $shift->className == "Pagi")
					$user->shift_pagi++;
				elseif($shift->className == "sore" || $shift->className == "Sore")
					$user->shift_sore++;
				elseif($shift->className == "malam" || $shift->className == "Malam")
					$user->shift_malam++;
				elseif($shift->className == "libur" || $shift->className == "Libur")
					$user->shift_libur++;
			}
		}
		$projects = DB::table('project')
			->get()
			->toArray();
		if($month == ""){
			return view('admin.schedule',compact('users','projects','nameUsers','nameUsersShif','nameUsersShif2'));
		} else {
			return $users;
		}
		// echo "<pre>";
		// print_r($projects);
		// print_r($users);
		// echo "</pre>";
	}
	function getScheduleAll (){
		$datas = DB::table('shifting')
			->orderBy('start')
			->get()
			->toArray();
		$user_detail = DB::table('detail_users')
			->join('project','project.id','=','detail_users.on_project')
			->get()
			->toArray();
		return json_encode($datas);
	}
	function getScheduleProject ($id){
		$data = DB::table('shifting')
			->join('detail_users','detail_users.id_user','=','shifting.id_user')
			->where('detail_users.on_project','=',$id)
			->get()
			->toArray();
		return json_encode($data);
	}
	function getScheduleSelected (Request $req){
		$data = DB::table('shifting')
			->where('id_user','=',$req->idUser)
			->where('id_project','=',$req->idProject)
			->get()
			->toArray();
		return json_encode($data);
	}
	public function crateSchedule (Request $req){
		$user = DB::table('users')->where("name","LIKE","%" . $req->name)->first();
		// echo "title : " . $req->title . "<br>";
		// echo "start : " . $req->start . "<br>";
		// echo "end : " . $req->end . "<br>";
		// echo "shift : " . $req->shift . "<br>";
		// echo "name : " . $req->name . "<br>";
		// echo "id : " . $user->id . "<br>";
		DB::table('shifting')
			->insert(
				[
					'id' => NULL,
					'id_user' => $user->id,
					'title' => $req->title,
					'start' => $req->start,
					'end' => $req->end,
					'className' => $req->shift,
					'hadir' => "00:00:00",
					'tanggal' => date('Y-m-d h:i:s'),
					'id_project' => $req->id_project,
					
				]
			);
		return DB::table('shifting')->orderBy('id','DESC')->first()->id;
	}
	public function deleteSchedule ($id) {
		DB::table('shifting')
			->where('id','=',$id)
			->delete();
	}
	function changeAbsent(Request $req,$id){
		echo $id . " alasan " . $req->alasan;
		if($req->alasan == "Libur"){
			echo "<br>Dia Pengen Libur";
			DB::table('waktu_absen')
				->where('id_user','=',$id)
				->where('tanggal','=',date('Y/m/d'))
				->delete();
		} else {
			DB::table('waktu_absen')
				->where('id_user','=',$id)
				->where('tanggal','=',date('Y/m/d'))
				->update(['late' => $req->alasan]);
			echo "<br>Dia Tidak Libur";
		}
		return redirect()->back();		
	}
	
	function editProfile(Request $request){
	if($request->name == NULL){
			$request->name = Auth::user()->name;
		}else if ($request->email == NULL){
			$request->email = Auth::user()->email;
		}else if ($request->role == NULL){
			$request->role = Auth::user()->jabatan;
		}else if ($request->shifting == NULL){
			$request->shifting = Auth::user()->shifting;
		}else {
			DB::table('detail_users')
				->where('id_user','=',$request->id)
				->delete();
			DB::table('shifting')
				->where('id_user','=',$request->id)
				->delete();
			DB::table('users')
			->where('id','=',$request->id)
			->update([
				"name" => $request->name,
				"email" => $request->email,
				"jabatan" => $request->role,
				"shifting" => $request->shifting
			]);
				return redirect()->back();
			}
	if(DB::table('users')->where('id','=',$request->id)->where('shifting','=',0 )){				
		DB::table('users')
			->where('id','=',$request->id)
			->update([
				"name" => $request->name,
				"email" => $request->email,
				"jabatan" => $request->role,
				"shifting" => $request->shifting
			]);
			return redirect()->back();

		} 
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
	function changePassword(Request $req){
		// $update = DB::table('users')
		// 			->where('id','=',$req->id)
		// 			->update([
		// 				'password' => Hash::make($req->pass)
		// 			]);
		if (Hash::check($req->old, Auth::user()->password)) {
			if($req->pass == $req->repass){
				$update = DB::table('users')
					->where('id','=',$req->id)
					->update([
						'password' => Hash::make($req->pass)
					]);
				return redirect()->back()->with('success','Password change successful');
			} else {
				return redirect()->back()->with('error','Password change unsuccessful');
			}
		} else {
			return redirect()->back()->with('error','Wrong password');
		}
	}
	public function areport(){
		
		return view('areport');
	}
	public function getReport(Request $req){
		// echo "<pre>";
		// echo $req->start . "<br>";
		// echo $req->end;
		// echo "</pre>";
		$query = DB::table('waktu_absen')
			->where('tanggal','>=',$req->start)
			->where('tanggal','<=',$req->end)
			->where('id_user','<>',32)
			->where('id_user','<>',35)
			->where('id_user','<>',74)
			->where('id_user','<>',76)
			->get()
			->toArray();
		$users = DB::table('users')
			->select('id','name','team')
			// ->where('team','=',Auth::user()->team)
			->where('id','<>',32)
			->where('id','<>',35)
			->where('id','<>',74)
			->where('id','<>',76)
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
		foreach ($status as $key => $stat) {
			$all = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->get()
				->toarray();
			$late = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->where('late','=',"late")
				->get()
				->toarray();
			$ontime = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->where('late','=',"on-time")
				->get()
				->toarray();
			$injury = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->where('late','=',"injury-time")
				->get()
				->toarray();
			$absen = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->where('late','<>',"injury-time")
				->where('late','<>',"late")
				->where('late','<>',"on-time")
				->get()
				->toarray();
			$where =  DB::table('users')
				->join('location','users.location','=','location.id')
				->where('users.id','=',$IDUser[$key])
				->select('location.name')
				->get()
				->toarray();
			$var[$stat]["all"] = sizeof($all);
			$var[$stat]["all"] = sizeof($late) + sizeof($ontime) + sizeof($injury);
			$var[$stat]["late"] = sizeof($late);
			$var[$stat]["ontime"] = sizeof($ontime);
			$var[$stat]["injury"] = sizeof($injury);
			$var[$stat]["absen"] = sizeof($absen);
			$var[$stat]["where"] = $where[0]->name;
			$var[$stat]["id"] = $IDUser[$key];
		}
		if($req->pdf){
			$summary[0] = 0; $summary[1] = 0; $summary[2] = 0; $summary[3] = 0; $summary[4] = 0;
			foreach ($var as $key => $val) {
				$summary[0] = $summary[0] + $val['ontime'];
				$summary[1] = $summary[1] + $val['injury'];
				$summary[2] = $summary[2] + $val['late'];
				$summary[3] = $summary[3] + $val['absen'];
			}
			$summary[4] = $summary[0] + $summary[1] + $summary[2];
			$data['start'] = $req->startDate;
			$data['end'] = $req->endDate;
			foreach ($IDUser as $key => $value) {
				$details [] = $this->auserhistory($value,$req->start,$req->end);
				foreach ($details as $detail) {
					if($detail[6] != NULL){
						foreach($detail[6] as $detail2){
							$detail2->hari = date("l", strtotime($detail2->tanggal));
						}
					} 
				}
			}
			
			$tittle = 'Attandance Report ' . $req->startDate . ' to ' . $req->endDate;
			$pdf = PDF::loadView('pdf2',compact('var','summary','data','details','tittle'));
			return $pdf->stream($tittle ."Report " . $data['start'] . " to " . $data['end'] . " .pdf");
			// return $details;

		// 	$tittle = 'My Attendence';
		// $pdf = PDF::loadView('pdf', compact('datas','kehadiran','count','name','absen'));
		// return $pdf->stream($tittle .".pdf");
			
			// return view('pdf2',compact('var','summary','data','details','tittle'));
			// return view('pdf4',compact('var','summary','data','details'));
		} else {
			$var['start'] = $req->start;
			$var['end'] = $req->end;
			$var['pdf'] = True;
			$var['startDate'] = date("j F Y",strtotime($var['start']));
			$var['endDate'] = date("j F Y",strtotime($var['end']));
			return $var;
			// return $data;
		}
	}
	public function getReportPerUser(Request $req){
		// echo "<pre>";
		// echo $req->start . "<br>";
		// echo $req->end;
		// echo "</pre>";
		$query = DB::table('waktu_absen')
			->where('tanggal','>=',$req->start)
			->where('tanggal','<=',$req->end)
			->get()
			->toArray();
		$users = DB::table('users')
			->select('id','name','team')
			->where('team','=',Auth::user()->team)
			->where('id','=',$req->id_user)
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
		foreach ($status as $key => $stat) {
			$all = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->get()
				->toarray();
			$late = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->where('late','=',"late")
				->get()
				->toarray();
			$ontime = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->where('late','=',"on-time")
				->get()
				->toarray();
			$injury = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->where('late','=',"injury-time")
				->get()
				->toarray();
			$absen = DB::table('waktu_absen')
				->where('id_user','=',$IDUser[$key])
				->where('tanggal','>=',$req->start)
				->where('tanggal','<=',$req->end)
				->where('late','<>',"injury-time")
				->where('late','<>',"late")
				->where('late','<>',"on-time")
				->get()
				->toarray();
			$where =  DB::table('users')
				->join('location','users.location','=','location.id')
				->where('users.id','=',$IDUser[$key])
				->select('location.name')
				->get()
				->toarray();
			$var[$stat]["all"] = sizeof($all);
			$var[$stat]["all"] = sizeof($late) + sizeof($ontime) + sizeof($injury);
			$var[$stat]["late"] = sizeof($late);
			$var[$stat]["ontime"] = sizeof($ontime);
			$var[$stat]["injury"] = sizeof($injury);
			$var[$stat]["absen"] = sizeof($absen);
			$var[$stat]["where"] = $where[0]->name;
			$var[$stat]["id"] = $IDUser[$key];
		}
		if($req->pdf){
			$summary[0] = 0; $summary[1] = 0; $summary[2] = 0; $summary[3] = 0; $summary[4] = 0;
			foreach ($var as $key => $val) {
				$summary[0] = $summary[0] + $val['ontime'];
				$summary[1] = $summary[1] + $val['injury'];
				$summary[2] = $summary[2] + $val['late'];
				$summary[3] = $summary[3] + $val['absen'];
			}
			$summary[4] = $summary[0] + $summary[1] + $summary[2];
			$data['start'] = $req->startDate;
			$data['end'] = $req->endDate;
			foreach ($IDUser as $key => $value) {
				$details [] = $this->auserhistory($value,$req->start,$req->end);
				foreach ($details as $detail) {
					if($detail[6] != NULL){
						foreach($detail[6] as $detail2){
							$detail2->hari = date("l", strtotime($detail2->tanggal));
						}
					} 
				}
			}
			
			$users = DB::table('users')->where('id','=',$req->id_user)->value('name');
			// echo $users;
			// echo $users;
			// echo $start;
			$tittle = 'Attandance Report For - ' . $users . ' [' . $req->startDate . ' to ' . $req->endDate . ']';
			$pdf2 = PDF::loadView('pdfReportAbsenPerUser',compact('var','summary','data','details','users','tittle'));
			// return $pdf2->stream("Report " . $data['start'] . " to " . $data['end'] . " .pdf");
			return $pdf2->stream($tittle . ".pdf");
		} else {
			return $var;
		}
	}
	public function matikan(){
		$ids = DB::table('users')
			->select('id','name','hadir','location','shifting')
			->orderBy('shifting','DESC')
			->get()
			->toarray();
				// GMT +6
		// date_default_timezone_set("Asia/Dhaka");
				// GMT +7
		date_default_timezone_set("Asia/Jakarta");
				// GMT +8
		// date_default_timezone_set("Asia/Makassar");
				// GMT +9
		// date_default_timezone_set("Asia/Tokyo");
				// GMT -9
		// date_default_timezone_set("America/Anchorage");
				// GMT -7
		// date_default_timezone_set("Etc/GMT-6");
		echo "<h1>Tanggal : " . date('Y/m/d') . " on " . date_default_timezone_get() . " hari " . date('l') . "</h1>";
		foreach ($ids as $key => $value) {
			echo $value->shifting . "<br>";
			$date = (int)substr($value->hadir, 0, 2);
			
			// Ditambah 8 jam kerja dia + 1 jam istirahat
			$libur = FALSE;
			if($value->shifting == 1){
				if($value->id != 32){
					$schedule = DB::table('shifting')
						->where('id_user','=',$value->id)
						->where('start','LIKE',date("Y-m-d").'%')
						->first();
					$date = (int)substr($schedule->start, 11,2);
					if((int)substr($schedule->start, 11,2) == 0){
						$libur = TRUE;
					}
					$date = $date + 9;
					$date = sprintf("%02d", $date);
					// echo "<pre>";
						// print_r($schedule->start);
						echo (int)substr($schedule->start, 11,3);
					// echo "</pre>";
				}
			} else {
				$date = $date + 9;
				$date = sprintf("%02d", $date);
				// echo $date;
			}
			$arr = explode(' ',trim($value->name));
			
			if($date > 24){
				$date = $date - 24;
				$over = TRUE;
				echo "-- over TRUE -- ";
			} else {
				$over = FALSE;
				echo "-- over FALSE -- ";
			}
			if($value->shifting == 0){
				$shifting = FALSE;
				echo "not Shifting -- ";
				if(date('l') == "Saturday" || date('l') == "Sunday"){
					echo "Libur <br>";
					echo $arr[0] . " -- tidak usah absen <br><br>";
				} else if ($this->testHollyday("j-M")){
					echo "Libur <br>";
					echo $arr[0] . " -- tidak usah absen <br><br>";
				} else {
					echo "tidak Libur <br>";
					echo $arr[0] . " must absent before " . $date . " and now is " . date("H");
			
					if(date("H")  == $date) {
						
						if($over){
							$date = date_create(date('Y/m/d'));
							date_sub($date,date_interval_create_from_date_string("1 days"));
							$date2 = $date->format('Y/m/d');
							$count1 = DB::table('waktu_absen')
								->where('id_user','=',$value->id)
								->where('tanggal','=',date('Y/m/d'))
								->count();
							$count2 = DB::table('waktu_absen')
								->where('id_user','=',$value->id)
								->where('tanggal','=',$date2)
								->count();
							echo "<br> Count 1 = "; 
							print_r($count1);
							echo "<br> Count 2 = ";
							print_r($count2);
							if ($count1 == 0 && $count2 == 0) {
								echo "<br>--- Dia tidak masuk";
								$insert = DB::table('waktu_absen')
									->insert([
										'id' => NULL,
										'id_user' => $value->id,
										'hadir' => $value->hadir,
										'jam' => date('H:i:s'),
										'tanggal' => $date2,
										'location' => $value->location,
										'late' => "Absen"
										]);
							} else {
								echo "<br>--- Dia masuk";
							}
							echo "<br>";
							echo "<br>";
						} else {    
							$count = DB::table('waktu_absen')
								->where('id_user','=',$value->id)
								->where('tanggal','=',date('Y/m/d'))
								->count();
							
							echo "---- Id user : " . $value->id . " ---- jumlah masuk hari ini " . $count . "  ---- hadir jam " . substr($value->hadir, 0, 2) . " > sekarang " . date("H") ." dia tidak masuk jam 22.00<br>";
							
							if($count == 0){
								$insert = DB::table('waktu_absen')
									->insert([
										'id' => NULL,
										'id_user' => $value->id,
										'hadir' => $value->hadir,
										'jam' => date('H:i:s'),
										'tanggal' => date('Y/m/d'),
										'location' => $value->location,
										'late' => "Absen"
										]);
							} else {
								echo "---- sudah absen<br><br>";
							}
						}
					} else {
						echo " -- Now is not absent hours<br><br>";
					}
				}
			} else {
				$shifting = TRUE;
				echo "Shifting -- <br>";
				echo $arr[0] . " must absent before " . $date . " and now is " . date("H");
				
				if ($libur == TRUE){
					echo "Libur <br>";
					echo $arr[0] . " -- tidak usah absen <br><br>";
				} else {
					if(date("H")  == $date) {
						
						if($over){
							$date = date_create(date('Y/m/d'));
							date_sub($date,date_interval_create_from_date_string("1 days"));
							$date2 = $date->format('Y/m/d');
							$count1 = DB::table('waktu_absen')
								->where('id_user','=',$value->id)
								->where('tanggal','=',date('Y/m/d'))
								->count();
							$count2 = DB::table('waktu_absen')
								->where('id_user','=',$value->id)
								->where('tanggal','=',$date2)
								->count();
							echo "<br> Count 1 = "; 
							print_r($count1);
							echo "<br> Count 2 = ";
							print_r($count2);
							if ($count1 == 0 && $count2 == 0) {
								echo "<br>--- Dia tidak masuk";
								$insert = DB::table('waktu_absen')
									->insert([
										'id' => NULL,
										'id_user' => $value->id,
										'hadir' => date('H:i:s',strtotime($schedule->start)),
										'jam' => date('H:i:s'),
										'tanggal' => $date2,
										'location' => $value->location,
										'late' => "Absen"
										]);
							} else {
								echo "<br>--- Dia masuk";
							}
							echo "<br>";
							echo "<br>";
						} else {    
							$count = DB::table('waktu_absen')
								->where('id_user','=',$value->id)
								->where('tanggal','=',date('Y/m/d'))
								->count();
							
							echo "---- Id user : " . $value->id . " ---- jumlah masuk hari ini " . $count . "  ---- hadir jam " . substr($value->hadir, 0, 2) . " > sekarang " . date("H") ." dia tidak masuk jam 22.00<br>";
							
							if($count == 0){
								$insert = DB::table('waktu_absen')
									->insert([
										'id' => NULL,
										'id_user' => $value->id,
										'hadir' => date('H:i:s',strtotime($schedule->start)),
										'jam' => date('H:i:s'),
										'tanggal' => date('Y/m/d'),
										'location' => $value->location,
										'late' => "Absen"
										]);
							} else {
								echo "---- sudah absen<br><br>";
							}
						}
					} else {
						echo " -- Now is not absent hours<br><br>";
					}
				}
			}
		}
	}
	public function testHollyday($date){
		$hollydays = array([
			"1",
			"Jan",
			"Mon",
			"New Year's Day",
		],
		[
			"16",
			"Feb",
			"Fri",
			"Chinese New Year",
		],
		[
			"17",
			"Mar",
			"Sat",
			"Bali Hindu New Year",
		],
		[
			"30",
			"Mar",
			"Fri",
			"Good Friday",
		],
		[
			"14",
			"Apr",
			"Sat",
			"Isra Mi'raj",
		],
		[
			"1",
			"May",
			"Tue",
			"Labour Day",
		],
		[
			"10",
			"May",
			"Thu",
			"Ascension Day of Jesus Christ",
		],
		[
			"29",
			"May",
			"Tue",
			"Waisak Day",
		],
		[
			"1",
			"Jun",
			"Fri",
			"Pancasila Day",
		],
		[
			"14",
			"Jun",
			"Wed",
			"Lebaran Holiday",
		],
		[
			"13",
			"Jun",
			"Thu",
			"Lebaran Holiday",
		],
		[
			"16",
			"Jun",
			"Fri",
			"Hari Raya Idul Fitri",
		],
		[
			"15",
			"Jun",
			"Sat",
			"Hari Raya Idu",
		],
		[
			"19",
			"Jun",
			"Mon",
			"Lebaran Holiday",
		],
		[
			"18",
			"Jun",
			"Tue",
			"Lebaran Holiday",
		],
		[
			"17",
			"Aug",
			"Fri",
			"Independence Day",
		],
		[
			"22",
			"Aug",
			"Wed",
			"Idul Adha",
		],
		[
			"11",
			"Sep",
			"Tue",
			"Islamic New Year",
		],
		[
			"20",
			"Nov",
			"Tue",
			"Prophet Muhammad's Birthday",
		],
		[
			"24",
			"Dec",
			"Mon",
			"Christmas Holiday",
		],
		[
			"25",
			"Dec",
			"Tue",
			"Christmas Da",
		]);
		// $hollyday = DB::table('users')
		// 	->select('id','name','hadir')
		// 	->get();
		// return $hollyday[1][1];
		$hollydayNow;
		foreach ($hollydays as $hollyday) {
			if($date ==  $hollyday[0] . "-" .$hollyday[1]){
				echo "Now is " . $hollyday[3] . "<br>";
				$hollydayNow = $hollyday[3];
			}
		}
		if(isset($hollydayNow)){
			return $hollydayNow;
		} else {
			return FALSE;
		}
		// return json_encode($hollydays);
	}
	public function test_cron(){
		date_default_timezone_set("Asia/Jakarta");
		$ids = DB::table('users')
			->select('id','name','hadir','location','shifting','nickname')
			->where('id','<>','32')
			->where('shifting','<>','0')
			// ->where('id','=','4')
			->orderBy('shifting','ASC')
			->get()
			->toarray();
		foreach ($ids as $key => $value) {
			syslog(LOG_ERR, "Test Cron to table - " . $value->name);
			$date = (int)substr($value->hadir, 0, 2);
			
			$libur = FALSE;
			if($value->shifting == 1){
				$schedule = DB::table('shifting')
					->where('id_user','=',$value->id)
					->where('start','LIKE',date("Y-m-d").'%')
					->first();
				$date = (int)substr($schedule->start, 11,2);
				if((int)substr($schedule->start, 11,2) == 0){
					$libur = TRUE;
				}
				$date = $date + 9;
				$date = sprintf("%02d", $date);
				echo "------------------------------------------------<br>Start : " . $schedule->start . "<br>Jam : ";
				echo (int)substr($schedule->start, 11,3) . "<br>";
			} else {
				$date = $date + 9;
				$date = sprintf("%02d", $date);
				echo $date;
			}
			if($value->shifting == 0){
				$shifting = FALSE;
				echo " not Shifting -- ";
				if(date('l') == "Saturday" || date('l') == "Sunday"){
					echo "Libur <br>";
					echo $value->id . " - " . $value->nickname . " -- tidak usah absen <br><br>";
				} else {
					echo "tidak Libur <br>";
					echo $value->id . " - " . $value->nickname . " must absent before " . $date . " and now is " . date("H");
			
					if( date("H") == $date) {
						$count = DB::table('waktu_absen')
							->where('id_user','=',$value->id)
							->where('tanggal','=',date('Y/m/d'))
							->count();
						
						echo "<br>---- Id user : " . $value->id . " ---- jumlah masuk hari ini " . $count . "  ---- hadir jam " . substr($value->hadir, 0, 2) . " > sekarang " . date("H") ." dia tidak masuk jam 22.00<br>";
						
						if($count == 0){
							$insert = DB::table('waktu_absen')
								->insert([
									'id' => NULL,
									'id_user' => $value->id,
									'hadir' => $value->hadir,
									'jam' => date('H:i:s'),
									'tanggal' => date('Y/m/d'),
									'location' => $value->location,
									'late' => "Absen"
									]);
							echo "---- tidak absen<br><br>";
						} else {
							echo "---- sudah absen<br><br>";
						}
					} else {
						echo " -- Now is not absent hours<br><br>";
					}
				}
			} else {
				$over_time = $date;
				if($over_time > 24){
					$date = $date - 24;
					$over = TRUE;
					echo "-- over TRUE -- ";
				} else {
					$over = FALSE;
					echo "-- over FALSE -- ";
				}
				$shifting = TRUE;
				echo "Shifting -- <br>";
				echo $value->id . " - " . $value->nickname . " must absent before " . $date . " and now is " . date("H");
				
				if ($libur == TRUE){
					echo "Libur <br>";
					echo $value->id . " - " . $value->nickname . " -- tidak usah absen <br><br>";
				} else {
					if(date("H") == $date) {
						
						if($over){
							$date = date_create(date('Y/m/d'));
							date_sub($date,date_interval_create_from_date_string("1 days"));
							$date2 = $date->format('Y/m/d');
							$count1 = DB::table('waktu_absen')
								->where('id_user','=',$value->id)
								->where('tanggal','=',date('Y/m/d'))
								->count();
							$count2 = DB::table('waktu_absen')
								->where('id_user','=',$value->id)
								->where('tanggal','=',$date2)
								->count();
							echo "<br> Count 1 = "; 
							print_r($count1);
							echo "<br> Count 2 = ";
							print_r($count2);
							if ($count1 == 0 && $count2 == 0) {
								echo "<br>--- Dia tidak masuk";
								$insert = DB::table('waktu_absen')
									->insert([
										'id' => NULL,
										'id_user' => $value->id,
										'hadir' => date('H:i:s',strtotime($schedule->start)),
										'jam' => date('H:i:s'),
										'tanggal' => $date2,
										'location' => $value->location,
										'late' => "Absen"
										]);
							} else {
								echo "<br>--- Dia masuk";
							}
							echo "<br>";
							echo "<br>";
						} else {    
							$count = DB::table('waktu_absen')
								->where('id_user','=',$value->id)
								->where('tanggal','=',date('Y/m/d'))
								->count();
							
							echo "<br>---- Id user : " . $value->id . " ---- jumlah masuk hari ini " . $count . "  ---- hadir jam " . substr($value->hadir, 0, 2) . " > sekarang " . date("H") ." dia tidak masuk jam 22.00<br>";
							
							if($count == 0){
								$insert = DB::table('waktu_absen')
									->insert([
										'id' => NULL,
										'id_user' => $value->id,
										'hadir' => date('H:i:s',strtotime($schedule->start)),
										'jam' => date('H:i:s'),
										'tanggal' => date('Y/m/d'),
										'location' => $value->location,
										'late' => "Absen"
										]);
							} else {
								echo "---- sudah absen<br><br>";
							}
						}
					} else {
						echo " -- Now is not absent hours<br><br>";
					}
				}
			}
		}
	}
	public function testXLSX(){
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');
		$writer = new Xlsx($spreadsheet);
		// $writer->save('hello world.xlsx');
		return $writer->save('hello world.xlsx');
	}
	public function testCalendar(){
		return view('testCalendar');
	}
	public function testPulang(){
		$start = "2018-06-21";
		$end = "2018-06-30";
		if(!isset($name)){
			$results = DB::table('waktu_absen')
				->join('users','users.id','=','waktu_absen.id_user')
				->join('location','location.id','=','waktu_absen.location')
				->where('users.shifting','1')
				->where('waktu_absen.tanggal','>=',$start)
				->where('waktu_absen.tanggal','<=',$end)
				->select(
					'waktu_absen.id',
					'users.nickname',
					'waktu_absen.hadir',
					'waktu_absen.jam',
					'waktu_absen.tanggal',
					'location.name',
					'waktu_absen.late',
					'waktu_absen.pulang',
					'waktu_absen.harus_pulang'
				);
		} else {
			$results = DB::table('waktu_absen')
				->join('users','users.id','=','waktu_absen.id_user')
				->join('location','location.id','=','waktu_absen.location')
				->where('users.shifting','1')
				->where('waktu_absen.tanggal','>=',$start)
				->where('waktu_absen.tanggal','<=',$end)
				->where('users.nickname','=',$name)
				->select(
					'waktu_absen.id',
					'users.nickname',
					'waktu_absen.hadir',
					'waktu_absen.jam',
					'waktu_absen.tanggal',
					'location.name',
					'waktu_absen.late',
					'waktu_absen.pulang',
					'waktu_absen.harus_pulang'
				);
		}
			
		// $per_user = $results->orderBy('users.nickname','ASC')->get();
		// $results = $results->orderBy('waktu_absen.pulang','DESC')->get();
		$results = $results->orderBy('waktu_absen.tanggal','DESC')->get();
		// echo "<pre>";
		// print_r($result);
		// echo "</pre>";
		return view('testPulang',compact('results'));
	}
	public function test_faker(){
		$faker = \Faker\Factory::create();
		$fake = $faker->name;
		return $fake;
	}
	
	public function getAbsen($start,$end,$id_user){
	// public function getAbsen(){
		// echo "hahaha";
		// $start = '2019-02-26';
		// $end = '2019-03-25';
		// // Mbak indri
		// $id_user = '40';
		// Yefta
		// $id_user = '47';
		// $data = $data;
		// $start = $start;
		// $end = $end;
		// $id_user = $id_user;
		$datetime1 = date_create($start);
		$datetime2 = date_create($end);
		$interval = date_diff($datetime1, $datetime2)->days;
		// echo "Interval : " . $interval . "<br>";
		
		$data = DB::table('waktu_absen')
			->where('id_user',$id_user)
			->where('tanggal','>=',$start)
			->where('tanggal','<=',$end)
			->orderBy('tanggal','ASC')
			->get();
		
		// echo $data[0]->tanggal;
		$shifting = DB::table('users')
			->where('id',$id_user)
			->value('shifting');
		$location = DB::table('users')
			->where('id',$id_user)
			->value('location');
		$tanggal = [];
		for ($i=0; $i < sizeof($data); $i++) { 
			$tanggal[] = $data[$i]->tanggal;
		}
		// echo "<pre>";
		// print_r($tanggal);
		// echo "</pre>";
		if($shifting == 0){
			for ($i=0; $i < $interval; $i++) { 
				// Office Hours (Senin - Jumat)
				$day = ["Fri", "Thu", "Wed", "Tue", "Mon"];
				$date1 = date_create($start);
				$date1 = date_add($date1,date_interval_create_from_date_string('+ ' . $i . ' days'));
				// echo date_format($date1,"D");
				if(in_array(date_format($date1,"D"),$day)){
					if(in_array(date_format($date1,"Y-m-d"),$tanggal)){
						// echo " match - present<br>";
					} else {
						$hadir = DB::table('users')
							->where('id',$id_user)
							->value('hadir');
						// echo date_format($date1,"Y-m-d") . " match - absen<br>";
						// $object = new stdClass();
						// $object->id = 1;
						// $object->id_user = $id_user;
						// $object->id_shifting = NULL;
						// $object->hadir = $hadir;
						// $object->jam = NULL;
						// $object->tanggal = date_format($date1,"Y-m-d");
						// $object->location = $location;
						// $object->late = "Absen";
						// $object->pulang = null;
						// $object->harus_pulang = nul;
						
						$temp = array(
							"id"=>1,
							"id_user"=>$id_user,
							"id_shifting"=>NULL,
							"hadir"=>NULL,
							"jam"=>NULL,
							"tanggal"=>date_format($date1,"Y-m-d"),
							"location"=>$location,
							"late"=>"Absen",
							"pulang"=>null,
							"harus_pulang"=>null
						);
						$data[] = (object)$temp;
						// $data[] = $object;
						// $data[] = $temp;
					}
				}
			}
		} else {
			$source = DB::table('shifting')
				->where('id_user',$id_user)
				->where('className','Libur')
				->orderBy('start','DESC')
				->limit($interval)
				->get();
			$libur = [];
			for ($i=0; $i < sizeof($source); $i++) { 
				$libur[] = substr($source[$i]->start, 0,10);
			}
			// echo "<pre>";
			// print_r($libur);
			// echo "</pre>";
			for ($i=0; $i < $interval; $i++) { 
				// Shiffting 
				// $day = ["Fri", "Thu", "Wed", "Tue", "Mon"];
				$date1 = date_create($start);
				$date1 = date_add($date1,date_interval_create_from_date_string('+ ' . $i . ' days'));
				// echo date_format($date1,"Y-m-d");
				if(!in_array(date_format($date1,"Y-m-d"),$libur)){
					if(in_array(date_format($date1,"Y-m-d"),$tanggal)){
						// echo " " . date_format($date1,"Y-m-d") . " masuk";
					} else {
						// $object = new stdClass();
						// $object->id = 1;
						// $object->id_user = $id_user;
						// $object->id_shifting = NULL;
						// $object->hadir = $hadir;
						// $object->jam = NULL;
						// $object->tanggal = date_format($date1,"Y-m-d");
						// $object->location = $location;
						// $object->late = "Absen";
						// $object->pulang = null;
						// $object->harus_pulang = nul;
						
						// $data[] = $object;
						// echo " " . date_format($date1,"Y-m-d") . " masuk dan tidak absen";
						$temp = array(
							"id"=>1,
							"id_user"=>$id_user,
							"id_shifting"=>NULL,
							"hadir"=>NULL,
							"jam"=>NULL,
							"tanggal"=>date_format($date1,"Y-m-d"),
							"location"=>$location,
							"late"=>"Absen",
							"pulang"=>null,
							"harus_pulang"=>null
						);
						$data[] = (object)$temp;
					}
				} else {
					// echo  " " . date_format($date1,"Y-m-d") . " libur";
				}
				// echo "<br>";
			}
		}
		// $data->sortBy('tanggal');
		// usort($data,'tanggal');
		
		// $data->append($temp);
		// array_push($temp,$data);
		return $data;
		// return $user;
	}
	
	public function getAbsen2(){
		$user = DB::table('users')
			->get();
		// echo "<pre>";
		echo "<table>";
		foreach ($user as $value) {
			$result = $this->getAbsen('2019-02-26','2019-03-25',$value->id);
			// echo $value->id . ' - ' . $result[0]->location . "<br>";
			foreach ($result as $key) {
				$key->location = DB::table('location')->where('id',$key->location)->value('name');
				$key->id_user = DB::table('users')->where('id',$key->id_user)->value('nickname');
				echo "<tr>";
				echo "<td>" . $key->id_user . "</td>";
				echo "<td>" . $key->hadir . "</td>";
				echo "<td>" . $key->jam . "</td>";
				echo "<td>" . $key->tanggal . "</td>";
				echo "<td>" . $key->location . "</td>";
				echo "<td>" . $key->late . "</td>";
				echo "<td>" . $key->pulang . "</td>";
				echo "<td>" . $key->harus_pulang . "</td>";
				echo "</tr>";
			}
			// print_r($result[0]);
		}
		echo "</table>";
		// print_r($this->getAbsen('2019-02-26','2019-03-25','31'));
		// print_r($this->getAbsen('2019-02-26','2019-03-25','33'));
		// echo "</pre>";
		// return $this->getAbsen('2019-02-26','2019-03-25','33');
	}
	// public function hash(){
	// 	DB::table('users')->where('id','=',41)->update(['password' => Hash::make("Sip2017!")]);
	// }
}