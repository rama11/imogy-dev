<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Artisan;
use DB;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		//
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->call(function() {
			syslog(LOG_ERR, "Test Cron Success ");

			$projectAll = DB::table('project__list')
				->pluck('id')
				->toArray();

			foreach ($projectAll as $id) {
				Artisan::call('ProjectRemainder:send',[
					'id' => $id
				]);
				syslog(LOG_ERR, "Loop Success " . $id);
			}

		})->dailyAt('08:00')->timezone('Asia/Jakarta');

		$schedule->call(function () {
			DB::table('users')
				->update(['condition' => "off"]);
		})->daily()->timezone('Asia/Jakarta');
		// $schedule->call(function() {
		// 	$text = "Test Text";

		// 	syslog(LOG_ERR, "Test Cron Success " . $text);
		// })->everyMinute();

		// Schedule untuk memeriksa hadir tidak nya orang itu
		// $schedule->call(function (){
		// $ids = DB::table('users')
			//  ->select('id','name','hadir','location')
			//  ->get()
			//  ->toarray();

			// date_default_timezone_set("Asia/Jakarta");
			// foreach ($ids as $key    => $value) {
			//  $date = (int)substr($value->hadir, 0, 2);
				
			//  // Ditambah 8 jam kerja dia + 1 jam istirahat
			//  $date = $date + 9;
			//  $date = sprintf("%02d", $date);

			//  echo $date . "<br>";
			//  if(date("H")  == $date){
			//      $count = DB::table('waktu_absen')
			//          ->where('id_user','=',$value->id)
			//          ->where('tanggal','=',date('Y/m/d'))
			//          ->count();
			//      echo $value->id . " " . $count . " " . substr($value->hadir, 0, 2) . " > " . date("H") ."<br>";
			//      if($count == 0){
			//          $insert = DB::table('waktu_absen')
			//              ->insert([
			//                  'id' => NULL,
			//                  'id_user' => $value->id,
			//                  'hadir' => $value->hadir,
			//                  'jam' => date('H:i:s'),
			//                  'tanggal' => date('Y/m/d'),
			//                  'location' => $value->location,
			//                  'late' => "Absen"
			//                  ]);

			//      } else {
			//          echo "----sudah absen<br>";
			//      }
			//  } else {
			//      echo "not<br>";
			//  }
			// }

			// echo "<pre>";
			// print_r($ids);
			// echo "</pre>";
			// // return 0;
   //      })->hourly();

		// $schedule->call(function () {
		// 	date_default_timezone_set("Asia/Jakarta");

		// 	$ids = DB::table('users')
		// 		->select('id','name','hadir','location','shifting')
		// 		->where('id','<>','32')
		// 		->orderBy('shifting','DESC')
		// 		->get()
		// 		->toarray();
		// 	// DB::table('test_cron')->insert(["id" => date('Y/m/d H:i:s')]);
		// 	// echo "Tanggal : " . date('Y/m/d H:i:s') . " on " . date_default_timezone_get() . " hari " . date('l') . "echo."; 
		// 	foreach ($ids as $key => $value) {
		// 		syslog(LOG_ERR, "Test Cron to table - " . $value->name);
		// 		$date = (int)substr($value->hadir, 0, 2);
				
		// 		$libur = FALSE;
		// 		if($value->shifting == 1){

		// 			$schedule = DB::table('shifting')
		// 				->where('id_user','=',$value->id)
		// 				->where('start','LIKE',date("Y-m-d").'%')
		// 				->first();

		// 			$date = (int)substr($schedule->start, 11,2);
		// 			if((int)substr($schedule->start, 11,2) == 0){
		// 				$libur = TRUE;
		// 			}

		// 			$date = $date + 9;
		// 			$date = sprintf("%02d", $date);
		// 			syslog(LOG_ERR, "Test Cron to table - " .  (int)substr($schedule->start, 11,3));
		// 		} else {
		// 			$date = $date + 9;
		// 			$date = sprintf("%02d", $date);
		// 			syslog(LOG_ERR, "Test Cron to table - " . $date);
		// 		}
		// 	}
		// })->everyMinute();
		// $schedule->call(function (){
		// 	$ids = DB::table('users')
		// 		->select('id','name','hadir','location','shifting')
		// 		->orderBy('shifting','DESC')
		// 		->get()
		// 		->toarray();

		// 	syslog(LOG_ERR, "Test Cron Success" . $ids);

		// 			// GMT +6
		// 	// date_default_timezone_set("Asia/Dhaka");
		// 			// GMT +7
		// 	date_default_timezone_set("Asia/Jakarta");
		// 			// GMT +8
		// 	// date_default_timezone_set("Asia/Makassar");
		// 			// GMT +9
		// 	// date_default_timezone_set("Asia/Tokyo");
		// 			// GMT -9
		// 	// date_default_timezone_set("America/Anchorage");
		// 			// GMT -7
		// 	// date_default_timezone_set("Etc/GMT-6");

		// 	echo "<h1>Tanggal : " . date('Y/m/d') . " on " . date_default_timezone_get() . " hari " . date('l') . "</h1>";

		// 	foreach ($ids as $key => $value) {
		// 		syslog(LOG_ERR, "Test Cron - " . $value->name);
		// 		if($value->id != 32){
		// 			echo $value->shifting . "<br>";
		// 			$date = (int)substr($value->hadir, 0, 2);
					
		// 			// Ditambah 8 jam kerja dia + 1 jam istirahat
		// 			$libur = FALSE;
		// 			if($value->shifting == 1){
		// 				if($value->id != 32){
		// 					$schedule = DB::table('shifting')
		// 						->where('id_user','=',$value->id)
		// 						->where('start','LIKE',date("Y-m-d").'%')
		// 						->first();
		// 					$date = (int)substr($schedule->start, 11,2);
		// 					if((int)substr($schedule->start, 11,2) == 0){
		// 						$libur = TRUE;
		// 					}
		// 					$date = $date + 9;
		// 					$date = sprintf("%02d", $date);

		// 					// echo "<pre>";
		// 						// print_r($schedule->start);
		// 						echo (int)substr($schedule->start, 11,3);
		// 					// echo "</pre>";
		// 				}
		// 			} else {
		// 				$date = $date + 9;
		// 				$date = sprintf("%02d", $date);
		// 				// echo $date;
		// 			}

		// 			$arr = explode(' ',trim($value->name));
					
		// 			if($date > 24){
		// 				$date = $date - 24;
		// 				$over = TRUE;
		// 				echo "-- over TRUE -- ";
		// 			} else {
		// 				$over = FALSE;
		// 				echo "-- over FALSE -- ";
		// 			}

		// 			if($value->shifting == 0){
		// 				$shifting = FALSE;
		// 				echo "not Shifting -- ";

		// 				if(date('l') == "Saturday" || date('l') == "Sunday"){
		// 					echo "Libur <br>";
		// 					echo $arr[0] . " -- tidak usah absen <br><br>";
		// 				} else {
		// 					echo "tidak Libur <br>";
		// 					echo $arr[0] . " must absent before " . $date . " and now is " . date("H");
					
		// 					if(date("H")  == $date) {
								
		// 						if($over){
		// 							$date = date_create(date('Y/m/d'));
		// 							date_sub($date,date_interval_create_from_date_string("1 days"));
		// 							$date2 = $date->format('Y/m/d');

		// 							$count1 = DB::table('waktu_absen')
		// 								->where('id_user','=',$value->id)
		// 								->where('tanggal','=',date('Y/m/d'))
		// 								->count();

		// 							$count2 = DB::table('waktu_absen')
		// 								->where('id_user','=',$value->id)
		// 								->where('tanggal','=',$date2)
		// 								->count();

		// 							echo "<br> Count 1 = "; 
		// 							print_r($count1);
		// 							echo "<br> Count 2 = ";
		// 							print_r($count2);

		// 							if ($count1 == 0 && $count2 == 0) {
		// 								echo "<br>--- Dia tidak masuk";
		// 								$insert = DB::table('waktu_absen')
		// 									->insert([
		// 										'id' => NULL,
		// 										'id_user' => $value->id,
		// 										'hadir' => $value->hadir,
		// 										'jam' => date('H:i:s'),
		// 										'tanggal' => $date2,
		// 										'location' => $value->location,
		// 										'late' => "Absen"
		// 										]);
		// 							} else {
		// 								echo "<br>--- Dia masuk";
		// 							}

		// 							echo "<br>";
		// 							echo "<br>";
		// 						} else {    
		// 							$count = DB::table('waktu_absen')
		// 								->where('id_user','=',$value->id)
		// 								->where('tanggal','=',date('Y/m/d'))
		// 								->count();
									
		// 							echo "---- Id user : " . $value->id . " ---- jumlah masuk hari ini " . $count . "  ---- hadir jam " . substr($value->hadir, 0, 2) . " > sekarang " . date("H") ." dia tidak masuk jam 22.00<br>";
									
		// 							if($count == 0){
		// 								$insert = DB::table('waktu_absen')
		// 									->insert([
		// 										'id' => NULL,
		// 										'id_user' => $value->id,
		// 										'hadir' => $value->hadir,
		// 										'jam' => date('H:i:s'),
		// 										'tanggal' => date('Y/m/d'),
		// 										'location' => $value->location,
		// 										'late' => "Absen"
		// 										]);
		// 							} else {
		// 								echo "---- sudah absen<br><br>";
		// 							}
		// 						}
		// 					} else {
		// 						echo " -- Now is not absent hours<br><br>";
		// 					}
		// 				}
		// 			} else {
		// 				$shifting = TRUE;
		// 				echo "Shifting -- <br>";
		// 				echo $arr[0] . " must absent before " . $date . " and now is " . date("H");
						
		// 				if ($libur == TRUE){
		// 					echo "Libur <br>";
		// 					echo $arr[0] . " -- tidak usah absen <br><br>";
		// 				} else {
		// 					if(date("H")  == $date) {
								
		// 						if($over){
		// 							$date = date_create(date('Y/m/d'));
		// 							date_sub($date,date_interval_create_from_date_string("1 days"));
		// 							$date2 = $date->format('Y/m/d');

		// 							$count1 = DB::table('waktu_absen')
		// 								->where('id_user','=',$value->id)
		// 								->where('tanggal','=',date('Y/m/d'))
		// 								->count();

		// 							$count2 = DB::table('waktu_absen')
		// 								->where('id_user','=',$value->id)
		// 								->where('tanggal','=',$date2)
		// 								->count();

		// 							echo "<br> Count 1 = "; 
		// 							print_r($count1);
		// 							echo "<br> Count 2 = ";
		// 							print_r($count2);

		// 							if ($count1 == 0 && $count2 == 0) {
		// 								echo "<br>--- Dia tidak masuk";
		// 								$insert = DB::table('waktu_absen')
		// 									->insert([
		// 										'id' => NULL,
		// 										'id_user' => $value->id,
		// 										'hadir' => date('H:i:s',strtotime($schedule->start)),
		// 										'jam' => date('H:i:s'),
		// 										'tanggal' => $date2,
		// 										'location' => $value->location,
		// 										'late' => "Absen"
		// 										]);
		// 							} else {
		// 								echo "<br>--- Dia masuk";
		// 							}

		// 							echo "<br>";
		// 							echo "<br>";
		// 						} else {    
		// 							$count = DB::table('waktu_absen')
		// 								->where('id_user','=',$value->id)
		// 								->where('tanggal','=',date('Y/m/d'))
		// 								->count();
									
		// 							echo "---- Id user : " . $value->id . " ---- jumlah masuk hari ini " . $count . "  ---- hadir jam " . substr($value->hadir, 0, 2) . " > sekarang " . date("H") ." dia tidak masuk jam 22.00<br>";
									
		// 							if($count == 0){
		// 								$insert = DB::table('waktu_absen')
		// 									->insert([
		// 										'id' => NULL,
		// 										'id_user' => $value->id,
		// 										'hadir' => date('H:i:s',strtotime($schedule->start)),
		// 										'jam' => date('H:i:s'),
		// 										'tanggal' => date('Y/m/d'),
		// 										'location' => $value->location,
		// 										'late' => "Absen"
		// 										]);
		// 							} else {
		// 								echo "---- sudah absen<br><br>";
		// 							}
		// 						}
		// 					} else {
		// 						echo " -- Now is not absent hours<br><br>";
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}
		// })->hourly();

		// Schedule untuk merubah status menjadi offwork nya orang itu

	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		$this->load(__DIR__.'/Commands');

		require base_path('routes/console.php');
	}
}
