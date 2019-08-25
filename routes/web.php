<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route yang di panggil pertama sendiri atau sebelum login
Route::get('/', function () {
    return view('welcome2');
});
// Route::get('/', function(){ 
//     return Redirect::to('https://sinergy-dev.xyz', 301); 
// });

// Route::get('{any}', function() {
    // return Redirect::to('https://sinergy-dev.xyz', 301); 
   // return redirect('https://targetdomain.com');
// })->where('any', '.*');

// Route::get('/test_cron','AdminController@test_cron');

Route::get('maps', function () {
    return view('maps');
});


// Dibawah adalah route yang hanya bisa di pangil jika sudah terAuthentification (login)
Auth::routes();
Route::get('/authenticate/{id}','HomeController@authenticate');

// Engginer Route
// Route::get('/home', function(){
	// echo "asdfasd";
// });

Route::get('testexcel','AdminController@testXLSX')->name('testexcel');

Route::get('/home', 'AdminController@index');
Route::get('/raw3/{id}','HomeController@raw');
Route::get('/history', 'HomeController@history');
Route::get('/profile', 'HomeController@profile');
Route::get('/eprofile', 'HomeController@eprofile');
Route::get('/eabsen', 'HomeController@eabsen');
Route::get('/ehistory', 'HomeController@ehistory');
Route::get('/etisygy', 'HomeController@etisygy');
Route::get('/eannoun', 'HomeController@eannoun');
Route::get('/eteamhistory', 'HomeController@eteamhistory');

// Helpdesk Route
Route::get('/helpdesk', 'HelpdeskController2@index');
Route::get('/raw2/{id}','HelpdeskController2@raw');

Route::post('/addUser', 'HelpdeskController2@addUser');
Route::post('/editUser', 'HelpdeskController2@editUser');

	//Route::get('/history2', 'HelpdeskController2@history');
	// Route::get('/profile', 'HelpdeskController2@profile');
	Route::get('/hsycal', 'HelpdeskController2@hsycal');
	Route::get('/htisygy', 'HelpdeskController2@htisygy');
	Route::get('/hannouncement', 'HelpdeskController2@hannouncement');
	Route::get('/husermanage', 'HelpdeskController2@husermanage');
	Route::get('/hhistory', 'HelpdeskController2@hhistory');
	Route::get('/hteamhistory', 'HelpdeskController2@hteamhistory');


	// User Manage Oleh Helpdesk
	Route::get('/getMasuk/{id}', 'HelpdeskController2@getMasuk');
	Route::get('/getProfile/{id}', 'HelpdeskController2@getProfile');
	Route::get('/setMasuk', 'HelpdeskController2@setMasuk');

	Route::get('/user', 'HelpdeskController2@user');
	Route::get('/hhistory', 'HelpdeskController2@history');
	Route::get('/hteamhistory', 'HelpdeskController2@teamhistory');
	Route::get('/huserhistory/{id}', 'HelpdeskController2@huserhistory');

	// Location Controll oleh Helpdesk
	Route::get('/hlocation', 'HelpdeskController2@location');
	Route::get('/getLocation/{id}' , 'HelpdeskController2@getLocation');
	Route::get('/setLocation' , 'HelpdeskController2@setLocation');
	Route::get('/addLocation' , 'HelpdeskController2@addLocation');

	Route::get('/habsen', 'HelpdeskController2@absen');

	Route::post('/htisygy', 'HelpdeskController2@add_atisygy');

	Route::get('/downloadPDF/{id}','HelpdeskController2@download');
	Route::get('/schedule','HelpdeskController2@schedule');
	Route::get('/changeAbsent/{id}','HelpdeskController2@changeAbsent');

// Admin Route


Route::get('/admin', 'AdminController@index');
Route::get('/test_page', 'AdminController@test_page');
Route::get('/announcement', 'AdminController@announcement');
Route::post('/addUser', 'AdminController@addUser');
Route::post('/addUserShifting', 'AdminController@addUserShifting');
Route::post('/editUser', 'AdminController@editUser');
Route::post('/editProfile', 'AdminController@editProfile');



	// User Manage Oleh Admin
	Route::get('/usermanage', 'AdminController@usermanage');
	Route::get('/getMasuk/{id}', 'AdminController@getMasuk');
	Route::get('/getProfile/{id}', 'AdminController@getProfile');
	Route::get('/setMasuk', 'AdminController@setMasuk');

	Route::get('/user', 'AdminController@user');
	Route::get('/ahistory', 'AdminController@history');
	Route::get('/ahistory2', 'AdminController@historydet');
	Route::get('/ateamhistory', 'AdminController@teamhistory');
	Route::get('/auserhistory/{id}', 'AdminController@auserhistory');
	Route::get('/areport', 'AdminController@areport');
	Route::get('/getReport','AdminController@getReport');
	Route::get('/getReportPerUser','AdminController@getReportPerUser');

	// Location Controll oleh Admin
	Route::get('/location', 'AdminController@location');
	Route::get('/getLocation/{id}' , 'AdminController@getLocation');
	Route::get('/setLocation' , 'AdminController@setLocation');
	Route::get('/addLocation' , 'AdminController@addLocation');
	Route::get('/getLocationAfter','AdminController@getLocationAfter');

	Route::get('/absen', 'AdminController@absen');
	Route::get('/raw/{id}', 'AdminController@raw');
	Route::post('/raw/{id}', 'AdminController@raw');
	Route::get('/createPresenceLocation', 'AdminController@createPresenceLocation');
	Route::get('/asycal', 'AdminController@asycal');
	
	Route::get('/downloadPDF/{id}','AdminController@download');
	Route::get('/changeAbsent/{id}','AdminController@changeAbsent');
	Route::post('/changePasswords','AdminController@changePassword');

	Route::get('/matikan', 'AdminController@matikan');
	Route::get('createEvent','AdminController@createAsycal');
	Route::get('deleteEvent','AdminController@deleteAsycal');
	Route::get('/json','AdminController@jsonAsycal');


	Route::get('/schedule','AdminController@schedule');
	Route::get('/getScheduleAll', 'AdminController@getScheduleAll');
	Route::get('/getScheduleProject/{id}', 'AdminController@getScheduleProject');
	Route::get('/getScheduleSelected','AdminController@getScheduleSelected');

	Route::get('/crateSchedule','AdminController@crateSchedule');
	Route::get('/deleteSchedule/{id}','AdminController@deleteSchedule');
	Route::get('/changeMonth','AdminController@changeMonth');

	// Ticketing Route
	// dgsdfgdfgsfg`

	

	
	Route::get('/hash', 'AdminController@hash');
	Route::get('getRecentTicket','AdminController@getRecentTicket');
	Route::get('/testHollyday/{date}','AdminController@testHollyday');
	// Route::post('/atisygy', 'AdminController@add_atisygy');

// Ticketing Route
	Route::get('tisygy', 'TicketingController@tisygy');
	Route::get('tisygy2', 'TicketingController@tisygy2');
	// Route::get('tisygy', function(){
		// echo "<h1 style='font-size:100px'>Mas Danang Nganteng</h1>";
	// });
	Route::get('reserveIdTicket','TicketingController@createIdTicket');
	Route::get('getEmailReciver', 'TicketingController@getEmailReciver');
	Route::get('setNewTicket','TicketingController@setNewTicket');
	Route::get('mailOpenTicket','TicketingController@mailOpenTicket');
	// Route::get('getPerformance','TicketingController@getPerformance');
	// Route::get('getPerformance2','TicketingController@getPerformance2');
	Route::get('getTicket','TicketingController@getTicket');
	Route::get('updateTicket','TicketingController@updateTicket');
	Route::get('closeTicket','TicketingController@closeTicket');
	Route::post('attachmentCloseTicket','TicketingController@attachmentCloseTicket');
	Route::get('pendingTicket','TicketingController@pendingTicket');
	Route::get('cancelTicket','TicketingController@cancelTicket');
	Route::get('mailCloseTicket','TicketingController@mailCloseTicket');	
	Route::get('getSettingClient' , 'TicketingController@getSettingClient');
	Route::post('setSettingClient' , 'TicketingController@setSettingClient');
	Route::get('getAtm','TicketingController@getAtm');
	Route::get('getDetailAtm/{id}','TicketingController@getDetailAtm');
	Route::get('getDetailAtm2/{id}','TicketingController@getDetailAtm2');
	Route::get('getDashboard','TicketingController@getDashboard');
	Route::get('setAtm','TicketingController@setAtm');
	Route::get('newAtm','TicketingController@newAtm');
	Route::get('updateIdTicket','TicketingController@updateIdTicket');

	Route::get('getReportTicket/{client}/{month}','TicketingController@testReport');
	// Route::get('getReportTicket/{client}/{month}',function($client,$month){
	// 	echo $client . "<br>";
	// 	echo $month;

	// });
	
	Route::get('controll','TicketingController@controll');
	Route::get('getReportHelpdesk','TestController@getReportHelpdesk');
	Route::get('getReportHelpdesk2','TestController@getReportHelpdesk2');

	// Testing Route
	Route::get('testPerformance', 'TestController@performance');
	Route::get('logging/{type}','TestController@logging_activity');
	Route::get('testGetTicketingPerformance','TestController@getTicketingPerformance');
	Route::get('testChunkQuery','TestController@testChunkQuery');
	// testChunkQuery
	
	// Route::get('testGetHadir', 'AdminController@getAbsen');
	// Route::get('testGetHadir2', 'AdminController@getAbsen2');
	// Route::get('testCount', 'TicketingController@count_query');
	// Route::get('testPage', 'HomeController@testPage');
	// Route::get('testDataTable', 'HomeController@testDataTable');
	// Route::get('testPHP','HomeController@testProgram');
	// Route::get('testMail','TicketingController@testMail');
	// Route::get('testMasPras','TicketingController@testMasPras');
	// Route::get('testReport','TicketingController@testReport');
	// Route::get('debugMode','HomeController@debugMode');
	// Route::get('testValue/{id}','HomeController@testValue');
	// Route::get('testFaker','AdminController@test_faker');
	// Route::get('testDBRaw','TestController@testDBRaw');


	// Route::get('testPulang','AdminController@testPulang');
	// // Route::get('testHariRaya','AdminController@testHariRaya');/
	
	Route::get('testEmail2','TicketingController@testEmail2');
	// Route::get('testEmail1','TicketingController@testEmail1');
	// Route::post('testUpload','TicketingController@testUpload');
	// Route::get('testMiddleware','AdminController@index')->middleware('debugging');
	// Route::get('testPersen',function(){
	// 	$date = 6;
	// 	echo sprintf("iki adalah sebuah format %02d", $date);
	// });

//Auth::routes();
	Route::get('getPerformance2','TicketingController@getPerformance2');
	Route::get('getPerformanceBySeverity','TicketingController@getPerformanceBySeverity');
	Route::get('getPerformanceByClient','TicketingController@getPerformanceByClient');
	
	Route::get('getPerformance','TicketingController@getPerformance');
	Route::get('getDashboard','TicketingController@getDashboard');
	Route::get('getCreateParameter','TicketingController@getCreateParameter');
	Route::get('getClientTest','TestController@getSettingClient');
// Route::get('/home', 'HomeController@index')->name('home');

// Project Route
	Route::get('project','ProjectController@index');
	Route::get('project/manage','ProjectController@manage');
	// Input Project
	Route::get('project/manage/getCustomer','ProjectController@getCustomer');
	Route::get('project/manage/getMember','ProjectController@getMember');
	Route::post('project/manage/setProjectList','ProjectController@setProjectList');

	Route::get('project/manage/sendProjectListOpen','ProjectController@sendProjectListOpen');
	route::get('project/manage/previewSendProjectListOpen',function(){
		return new App\Mail\MailOpenProject();
	});
	// Get Project
	Route::get('project/manage/getAllProjectList','ProjectController@getAllProjectList');
	Route::get('project/manage/getDetailProjectList','ProjectController@getDetailProjectList');
	Route::get('project/manage/getShortDetailProjectList','ProjectController@getShortDetailProjectList');
	Route::post('project/manage/setUpdateEventProject','ProjectController@setUpdateEventProject');
	
	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
	
	Route::get('project/setting','ProjectController@setting');

	Route::get('project/setting/getSettingProject','ProjectController@getSettingProject');
