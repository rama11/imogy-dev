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
	//return view('welcome3');
});    

// Test commit -d

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
// use Telegram;       


Route::get('testSendMassage','TelegramController@testSendMassage');

Route::post('telegramWebHook/' . env('TELEGRAM_BOT_TOKEN'),'TelegramController@getWebhookUpdate');

Route::get('telegram','TelegramViewController@index');
Route::get('telegram/reporting','TelegramViewController@reporting');
Route::get('telegram/setting/webhook','TelegramViewController@setting_webhook');
Route::get('telegram/setting/user_sync','TelegramViewController@setting_user_sync');
Route::get('telegram/setting/user_sync/getViewData','TelegramViewController@getViewData');
Route::get('telegram/setting/user_sync/getTableData','TelegramViewController@getTableData');
Route::get('telegram/setting/user_sync/revokeTelegramUser','TelegramViewController@revokeTelegramUser');
Route::get('telegram/setting/notif_subscription','TelegramViewController@setting_notif_subscription');
Route::get('telegram/setting/notif_subscription/getSyncData','TelegramViewController@getSyncData');

	// Route::get('tisygy/getPerformanceByClient','TicketingController@getPerformanceByClient');

// Dibawah adalah route yang hanya bisa di pangil jika sudah terAuthentification (login)
Auth::routes();
Route::get('/authenticate/{id}','HomeController@authenticate');
Route::get('getReportTicket/{client}/{month}','TicketingController@getReportTicket');
Route::get('tisygy/report/getParameter','TicketingController@getReportParameter');
Route::get('tisygy/report/make','TicketingController@makeReportTicket');
Route::get('tisygy/report/download','TicketingController@downloadReportTicket');
		

Route::get('firebase','TestController@firebase');
Route::get('administration','AdministrationController@index');
Route::get('testLiteral',function(){
	return App\Http\Models\TicketingClient::find(1)->value('banking');
});


// Engginer Route
// Route::get('/home', function(){
	// echo "asdfasd";
// });

Route::group(['middleware' => ['preventbacklogout','auth']], function(){

	Route::get('testexcel','AdminController@testXLSX')->name('testexcel');
	Route::get('/home', 'AdminController@index');
	Route::get('/raw3/{id}','HomeController@raw');
	Route::get('/history', 'HomeController@history');
	Route::get('/profile', 'HomeController@profile');
	Route::get('/eprofile', 'HomeController@eprofile');
	Route::get('/eabsen', 'HomeController@eabsen');
	Route::get('/ehistory', 'HomeController@ehistory');
	// Route::get('/etisygy', 'HomeController@etisygy');
	Route::get('/eannoun', 'HomeController@eannoun');
	// Route::get('/eteamhistory', 'HomeController@eteamhistory');
	// Helpdesk Route
	Route::get('/helpdesk', 'HelpdeskController2@index');
	Route::get('/raw2/{id}','HelpdeskController2@raw');
	Route::post('/addUser', 'HelpdeskController2@addUser');
	Route::post('/editUser', 'HelpdeskController2@editUser');
		//Route::get('/history2', 'HelpdeskController2@history');
		// Route::get('/profile', 'HelpdeskController2@profile');
	Route::get('/hsycal', 'HelpdeskController2@hsycal');
	// Route::get('/htisygy', 'HelpdeskController2@htisygy');
	Route::get('/hannouncement', 'HelpdeskController2@hannouncement');
	// Route::get('/husermanage', 'HelpdeskController2@husermanage');
	Route::get('/hhistory', 'HelpdeskController2@hhistory');
	// Route::get('/hteamhistory', 'HelpdeskController2@hteamhistory');
	// User Manage Oleh Helpdesk
	// Route::get('/getMasuk/{id}', 'HelpdeskController2@getMasuk');
	Route::get('/getProfile/{id}', 'HelpdeskController2@getProfile');
	// Route::get('/setMasuk', 'HelpdeskController2@setMasuk');
	Route::get('/user', 'HelpdeskController2@user');
	Route::get('/hhistory', 'HelpdeskController2@history');
	// Route::get('/hteamhistory', 'HelpdeskController2@teamhistory');
	Route::get('/huserhistory/{id}', 'HelpdeskController2@huserhistory');
	// Location Controll oleh Helpdesk
	Route::get('/hlocation', 'HelpdeskController2@location');
	Route::get('/getLocation/{id}' , 'HelpdeskController2@getLocation');
	// Route::get('/setLocation' , 'HelpdeskController2@setLocation');
	// Route::get('/addLocation' , 'HelpdeskController2@addLocation');
	Route::get('/habsen', 'HelpdeskController2@absen');
	// Route::post('/htisygy', 'HelpdeskController2@add_atisygy');
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
	Route::get('/precense/myhistory', 'AdminController@myHistory');
	Route::get('/precense/myhistory/detail', 'AdminController@myHistoryDetail');
		// User Manage Oleh Admin
	Route::middleware(['aogy.role'])->group(function () {

		Route::get('/precense/teamhistory', 'AdminController@teamHistory');
		Route::get('/precense/teamhistory/getUserHistory/{id}', 'AdminController@getUserHistory');
		Route::get('/precense/teamhistory/getIndifidualHistory/{id}','AdminController@getIndifidualHistory');

		Route::get('/precense/reporting', 'AdminController@precenseReporting');
		Route::get('/precense/reporting/getUserToReport','AdminController@getUserToReport');
		Route::get('/precense/reporting/getReportPrecenseAll','AdminController@getReportPrecenseAll');
		Route::get('/precense/reporting/getReportPrecensePerUser','AdminController@getReportPrecensePerUser');
	});
	Route::middleware(['shiftingloc.role'])->group(function () {
		Route::get('schedule','AdminController@schedule');
		Route::get('schedule/getThisMonth', 'AdminController@getScheduleThisMonth');
		Route::get('schedule/getThisProject', 'AdminController@getScheduleThisProject');
		Route::get('schedule/getThisUser','AdminController@getScheduleThisUser');
		Route::get('schedule/crateSchedule','AdminController@crateSchedule');
		Route::get('schedule/deleteSchedule','AdminController@deleteSchedule');
		Route::get('schedule/changeMonth','AdminController@changeMonth');
		Route::get('schedule/getLogActivityShifting','AdminController@getLogActivityShifting');
		
		
		Route::get('/usermanage', 'AdminController@usermanage');
		Route::get('/usermanage/addLocation' , 'AdminController@addLocation');
		Route::get('/usermanage/getLocationAfter','AdminController@getLocationAfter');
		Route::get('/usermanage/getLocation/{id}' , 'AdminController@getLocation');
		Route::get('/usermanage/setLocation' , 'AdminController@setLocation');
		Route::get('/location', 'AdminController@location');
		// Route::get('/getScheduleProject/{id}', 'AdminController@getScheduleProject');
		// Route::get('/deleteSchedule/{id}','AdminController@deleteSchedule');
		// Route::get('/changeMonth','AdminController@changeMonth');
	});
	Route::get('/usermanage/getMasuk/{id}', 'AdminController@getMasuk');
	Route::get('/usermanage/getProfile/{id}', 'AdminController@getProfile');
	Route::get('/setMasuk', 'AdminController@setMasuk');
	Route::get('/user', 'AdminController@user');
	// Route::get('/ahistory', 'AdminController@history');
	Route::get('/ahistory2', 'AdminController@historydet');
	Route::get('/getReport','AdminController@getReport');
	// Location Controll oleh Admin
	
	Route::get('/absen', 'AdminController@absen');

	Route::get('/raw/{id}', 'AdminController@raw');
	Route::post('/raw/{id}', 'AdminController@raw');
	Route::get('/createPresenceLocation', 'AdminController@createPresenceLocation');
	Route::get('/asycal', 'AdminController@asycal');
	
	Route::get('/changeAbsent/{id}','AdminController@changeAbsent');
	Route::post('/changePasswords','AdminController@changePassword');
	Route::get('/matikan', 'AdminController@matikan');
	Route::get('createEvent','AdminController@createAsycal');
	Route::get('deleteEvent','AdminController@deleteAsycal');
	Route::get('/json','AdminController@jsonAsycal');

	// Ticketing Route
	// dgsdfgdfgsfg`
	Route::middleware(['logphone.role'])->group(function () {
	Route::get('/logphone','LogPhoneController@index');
	Route::get('logphone/getAllLogPhone','LogPhoneController@getAllLogPhone');
	Route::post('/logphone/setNewLog','LogPhoneController@setNewLog');
	Route::get('/logphone/getLastestCall','LogPhoneController@getLastestCall');

	});


	Route::get('/hash', 'AdminController@hash');
	Route::get('getRecentTicket','AdminController@getRecentTicket');
	Route::get('/testHollyday/{date}','AdminController@testHollyday');
	// Route::post('/atisygy', 'AdminController@add_atisygy');
	// Ticketing Route


	// Route::get('tisygy', 'TicketingController@tisygy');
	Route::get('tisygy/controll', 'TicketingController@controll');
	Route::middleware(['tisygy.role'])->group(function () {

		Route::get('tisygy2', 'TicketingController@tisygy2');
		// Route::get('tisygy', function(){
			// echo "<h1 style='font-size:100px'>Mas Danang Nganteng</h1gController@createIdTicket');
		// Route::get('reserveIdTicket','TicketingController@createIdTicket');
		Route::get('getEmailReciver', 'TicketingController@getEmailReciver');
		// Route::get('setNewTicket','TicketingController@setNewTicket');
		// Route::get('mailOpenTicket','TicketingController@mailOpenTicket');
		// Route::get('getPerformance','TicketingController@getPerformance');
		// Route::get('getPerformance2','TicketingController@getPerformance2');
		// Route::get('getTicket','TicketingController@getTicket');
		// Route::get('updateTicket','TicketingController@updateTicket');
		// Route::get('closeTicket','TicketingController@closeTicket');
		Route::post('attachmentCloseTicket','TicketingController@attachmentCloseTicket');
		// Route::get('pendingTicket','TicketingController@pendingTicket');
		// Route::get('cancelTicket','TicketingController@cancelTicket');
		Route::get('mailCloseTicket','TicketingController@mailCloseTicket');	
		Route::get('getSettingClient' , 'TicketingController@getSettingClient');
		Route::post('setSettingClient' , 'TicketingController@setSettingClient');
		
		// Route::get('getDetailAtm/{id}','TicketingController@getDetailAtm');
		// Route::get('getDetailAtm2/{id}','TicketingController@getDetailAtm2');
		// Route::get('setAtm','TicketingController@setAtm');
		// Route::get('newAtm','TicketingController@newAtm');
		// Route::get('getReportTicket/{client}/{month}','TicketingController@testReport');
	});
		

		// Route::get('getReportTicket/{client}/{month}',function($client,$month){
		// 	echo $client . "<br>";
		// 	echo $month;
		// });
		
	Route::get('controll','TicketingController@controll');
	Route::get('getReportHelpdesk','TestController@getReportHelpsdesk');
	Route::get('getReportHelpdesk2','TestController@getReportHelpdesk2');
	// Testing Route
	Route::get('testPerformance', 'TestController@performance');
	Route::get('testLoading', 'TestController@testLoading');
	Route::get('logging/{type}','TestController@logging_activity');
	Route::get('testGetTicketingPerformance','TestController@getTicketingPerformance');
	Route::get('testChunkQuery','TestController@testChunkQuery');
	Route::get('notif_test','TestController@notif_test');
	Route::get('notif_test_store','TestController@notif_test_store');
	Route::get('testingATMMaps','TestController@testingATMMaps');
	Route::get('testMailOnProgress','TestController@testMailOnProgress');
	// testChunkQuery
	
	Route::get('testGetHadir/{start}/{end}/{id}', 'AdminController@getAbsen');
	Route::get('testEmailReturn', 'TestController@testEmailReturn');
	Route::get('testingServerSideDatatables', 'TestController@testingServerSideDatatables');
	Route::get('testingGetDataServerSide', 'TestController@testingGetDataServerSide');

	
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
	
	// Route::get('testEmail2','TicketingController@testEmail2');
	// Route::get('testEmail1','TicketingController@testEmail1');
	// Route::post('testUpload','TicketingController@testUpload');
	// Route::get('testMiddleware','AdminController@index')->middleware('debugging');
	// Route::get('testPersen',function(){
	// 	$date = 6;
	// 	echo sprintf("iki adalah sebuah format %02d", $date);
	// });
//Auth::routes();
	// Route::get('tisygy/getDashboard','TicketingController@getDashboard');
	Route::get('tisygy', 'TicketingController@tisygy');
	Route::get('tisygy/getDashboard','TicketingController@getDashboard');
	Route::get('tisygy/report/getParameter','TicketingController@getReportParameter');
	Route::get('tisygy/getPerformanceAll','TicketingController@getPerformanceAll');
	Route::get('tisygy/getPerformanceByClient','TicketingController@getPerformanceByClient');
	Route::get('tisygy/getPerformanceByTicket','TicketingController@getPerformanceByTicket');
	Route::get('tisygy/getPerformanceBySeverity','TicketingController@getPerformanceBySeverity');
	
	Route::get('tisygy/setUpdateTicket','TicketingController@setUpdateTicket');
	Route::get('tisygy/setUpdateTicketPending','TicketingController@setUpdateTicketPending');
	
	Route::get('tisygy/create/getParameter','TicketingController@getCreateParameter');
	Route::get('tisygy/create/getAtmId','TicketingController@getAtmId');
	Route::get('tisygy/create/getAbsenId','TicketingController@getAbsenId');
	Route::get('tisygy/create/getAtmDetail','TicketingController@getAtmDetail');
	Route::get('tisygy/create/getAbsenDetail','TicketingController@getAbsenDetail');
	Route::get('tisygy/create/getAtmPeripheralDetail','TicketingController@getAtmPeripheralDetail');
	Route::get('tisygy/create/getReserveIdTicket','TicketingController@getReserveIdTicket');
	Route::get('tisygy/create/setReserveIdTicket','TicketingController@setReserveIdTicket');
	Route::get('tisygy/create/putReserveIdTicket','TicketingController@putReserveIdTicket');
	// Route::get('tisygy/create/getEmailReciver', 'TicketingController@getEmailReciver');
	
	Route::get('tisygy/mail/getEmailData','TicketingController@getEmailData');

	Route::get('tisygy/create/setNewTicket', 'TicketingController@setNewTicket');
	Route::get('tisygy/mail/getOpenMailTemplate','TicketingController@getOpenMailTemplate');
	Route::get('tisygy/mail/sendEmailOpen','TicketingController@sendEmailOpen');
	
	Route::get('tisygy/mail/getCloseMailTemplate','TicketingController@getCloseMailTemplate');
	Route::get('tisygy/mail/sendEmailClose','TicketingController@sendEmailClose');

	Route::get('tisygy/mail/getCancelMailTemplate','TicketingController@getCancelMailTemplate');
	Route::get('tisygy/mail/sendEmailCancel','TicketingController@sendEmailCancel');

	Route::get('tisygy/mail/getOnProgressMailTemplate','TicketingController@getOnProgressMailTemplate');
	Route::get('tisygy/mail/sendEmailOnProgress','TicketingController@sendEmailOnProgress');

	Route::get('tisygy/getPendingTicketData','TicketingController@getPendingTicketData');
	Route::get('tisygy/mail/getPendingMailTemplate','TicketingController@getPendingMailTemplate');
	Route::get('tisygy/mail/sendEmailPending','TicketingController@sendEmailPending');

	Route::get('tisygy/mail/getReciver', 'TicketingController@getEmailReciver');

	Route::get('tisygy/setting/getAllAtm', 'TicketingController@getAllAtmSetting');
	Route::get('tisygy/setting/getDetailAtm','TicketingController@getDetailAtm');

	Route::get('tisygy/setting/getAllAbsen', 'TicketingController@getAllAbsenSetting');
	Route::get('tisygy/setting/getDetailAbsen','TicketingController@getDetailAbsen');
	

	Route::get('tisygy/setting/getParameterAddAtm','TicketingController@getParameterAddAtm');
	Route::get('tisygy/setting/setAtm','TicketingController@setAtm');
	Route::get('tisygy/setting/setAbsen','TicketingController@setAbsen');
	Route::get('tisygy/setting/deleteAtm','TicketingController@deleteAtm');
	Route::get('tisygy/setting/deleteAbsen','TicketingController@deleteAbsen');
	Route::get('tisygy/setting/newAtm','TicketingController@newAtm');
	Route::get('tisygy/setting/newAbsen','TicketingController@newAbsen');

	Route::get('tisygy/setting/getSettingClient' , 'TicketingController@getSettingClient');
	Route::post('tisygy/setting/setSettingClient' , 'TicketingController@setSettingClient');
	Route::get('tisygy/setting/newAtmPeripheral','TicketingController@newAtmPeripheral');
	Route::get('tisygy/setting/editAtmPeripheral','TicketingController@editAtmPeripheral');
	Route::get('tisygy/setting/deleteAtmPeripheral','TicketingController@deleteAtmPeripheral');

	// Route::get('getPerformanceBySeverity','TicketingController@getPerformanceBySeverity');
	// Route::get('getPerformanceByClient','TicketingController@getPerformanceByClient');
	
	// Route::get('getPerformance','TicketingController@getPerformance');
	// Route::get('getDashboard','TicketingController@getDashboard');
	// Route::get('getClientTest','TestController@getSettingClient');
	// Route::get('/home', 'HomeController@index')->name('home');
	// Project Route
	Route::middleware(['project.role'])->group(function () {
		Route::get('project','ProjectController@index');
		Route::get('project/getDashboardProject','ProjectController@getDashboard');
		Route::get('project/getProjectByUrgency','ProjectController@getProjectByUrgency');

		Route::get('project/manage','ProjectController@manage');
		// Input Project
		Route::get('project/manage/getCustomer','ProjectController@getCustomer');
		Route::get('project/manage/getMember','ProjectController@getMember');
		Route::post('project/manage/setProjectList','ProjectController@setProjectList');
		Route::get('project/manage/sendProjectListOpen','ProjectController@sendProjectListOpen');
		Route::get('project/manage/testSendProjectListOpen','ProjectController@testSendProjectListOpen');
		Route::get('project/manage/previewFinishEventProject');
		// Get Project
		Route::get('project/manage/getAllProjectList','ProjectController@getAllProjectList');
		Route::get('project/manage/getSelectedProjectList','ProjectController@getSelectedProjectList');
		
		Route::get('project/manage/getDetailProjectList','ProjectController@getDetailProjectList');
		Route::get('project/manage/getShortDetailProjectList','ProjectController@getShortDetailProjectList');
		Route::post('project/manage/setUpdateEventProject','ProjectController@setUpdateEventProject');
		
		Route::get('project/archive','ProjectController@archive');
		Route::get('project/archive/getArchiveProjectList','ProjectController@getArchiveProjectList');

		Route::get('project/setting','ProjectController@setting');
		Route::get('project/setting/getSettingProject','ProjectController@getSettingProject');
		Route::get('project/setting/setSettingProject','ProjectController@setSettingProject');
		Route::get('project/setting/getSettingPeriod','ProjectController@getSettingPeriod');
		Route::get('project/setting/setSettingPeriod','ProjectController@setSettingPeriod');
		Route::get('project/setting/setSettingPeriodStart','ProjectController@setSettingPeriodStart');

	});

	Route::get('budget/account','BudgetController@indexAccount');
	Route::get('budget/account/getDataAccount','BudgetController@getDataAccount');
	Route::post('budget/account/setAccount','BudgetController@setAccount');

	Route::get('budget/note','BudgetController@indexNote');
	Route::get('budget/note/getDataNote','BudgetController@getDataNote');
	Route::get('budget/note/getDataParameterNote','BudgetController@getDataParameterNote');
	Route::post('budget/note/setNote','BudgetController@setNote');
	Route::get('budget/note/getIndividualNote','BudgetController@getIndividualNote');
	
	Route::get('budget/note/filter/getAllParameterFilter','BudgetController@getAllParameterFilter');
	Route::get('budget/note/filter/getFilteredData','BudgetController@getFilteredData')->name('getFilteredData');

	
	Route::post('budget/note/updateNote','BudgetController@updateNote');
	Route::post('budget/note/editNote','BudgetController@editNote');
	Route::get('budget/note/makeReportBudget','BudgetController@makeReportBudget');



	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

});
?>

