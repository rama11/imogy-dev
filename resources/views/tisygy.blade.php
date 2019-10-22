@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('head')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

	<link rel="stylesheet" href="{{ url('css/jquery.emailinput.min.css') }}">
	<link rel="stylesheet" href="{{ url('plugins/timepicker/bootstrap-timepicker.min.css')}}">
	<link rel="stylesheet" href="{{ url('plugins/datepicker/datepicker3.css')}}">
	<link rel="stylesheet" href="{{ url('plugins/datatables/dataTables.bootstrap.css')}}">

	<!-- <link rel="stylesheet" href="{{ url('dist/css/AdminLTE.min.css')}}"> -->

	<style type="text/css">
		.table2 > tbody > tr > th, .table2 > tbody > tr > td {
			border-color: #141414;border: 1px solid;padding: 3px;}

		.vertical-alignment-helper {
			display:table;
			height: 100%;
			width: 100%;
			pointer-events:none;
		}
		.vertical-align-center {
			display: table-cell;
			vertical-align: middle;
			pointer-events:none;
		}
		.modal-content {
			width:inherit;
			max-width:inherit; 
			height:inherit;
			margin: 0 auto;
			pointer-events: all;
		}

		.table > tbody > tr > td {
			vertical-align: middle;
		}

		.dataTables_filter {display: none;}
		.border-radius-0 {
			border-radius: 0px !important;
		}
		.swal2-margin {
			margin: .3125em;
		}

		.label {
			border-radius: 0px !important;
		}

		.has-error .select2-selection {
			border-color: rgb(185, 74, 72) !important;
		}
		
		body { padding-right: 0 !important }
	</style>
@endsection
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<img src="img/tisygy.png" width="120" height="35">
			<small >Ticketing System Sinergy</small>
		</h1>
	</section>

	<section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="active">
					<a href="#tab_1" data-toggle="tab" onclick="getDashboard()">Dashboard</a>
				</li>
				<li>
					<a href="#tab_2" data-toggle="tab" id="createparam" onclick="makeNewTicket()">Create</a>
				</li>
				<li>
					<a href="#tab_3" data-toggle="tab" id="performance" onclick="getPerformanceAll()">Performance</a>
				</li>
				<li>
					<a href="#tab_4" data-toggle="tab">Setting</a>
				</li>
				<li>
					<a href="#tab_5" data-toggle="tab">Reporting</a>
				</li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<div class="row">
						<section class="col-md-6">
							<b>Occurring</b>
							<div class="row">
								<div class="col-md-4 col-sm-6">
									<div class="info-box">
										<span class="info-box-icon bg-red"><i class="ion ion-unlocked"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">OPEN</span>
											<span class="info-box-number" id="countOpen"></span>
										</div>
									</div>
								</div>
								
								<div class="col-md-4 col-sm-6">
									<div class="info-box">
										<span class="info-box-icon bg-aqua"><i class="ion ion-settings"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">PROGRESS</span>
											<span class="info-box-number" id="countProgress"></span>
										</div>
									</div>
								</div>
								
								<div class="col-md-4 col-sm-6">
									<div class="info-box">
										<span class="info-box-icon bg-yellow"><i class="ion ion-ios-stopwatch"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">PENDING</span>
											<span class="info-box-number" id="countPending"></span>
										</div>
									</div>
								</div>
							</div>
							<b>Completed</b>
							<div class="row">
								<div class="col-md-4 col-sm-6">
									<div class="info-box">
										<span class="info-box-icon bg-purple"><i class="ion ion-close-round"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">CANCEL</span>
											<span class="info-box-number" id="countCancel"></span>
										</div>
									</div>
								</div>

								<div class="col-md-4 col-sm-6">
									<div class="info-box">
										<span class="info-box-icon bg-green"><i class="ion ion-android-checkbox-outline"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">CLOSE</span>
											<span class="info-box-number" id="countClose"></span>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="info-box">
										<span class="info-box-icon bg-navy"><i class="ion ion-archive"></i></span>

										<div class="info-box-content">
											<span class="info-box-text">ALL</span>
											<span class="info-box-number" id="countAll"></span>
										</div>
									</div>
								</div>
							</div>

							<b>Need Attention</b>
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>ID</th>
												<th>ATM*</th>
												<th>Location</th>
												<th>Last Update</th>
												<th>Severity</th>
												<th>Operator</th>
											</tr>
										</thead>
										<tbody id="importanTable">
										</tbody>
									</table>
								</div>
							</div>
						</section>
						<section class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<div class="info-box">
										<div class="box-body">
											<canvas id="pieChart" style="height:250px"></canvas>
										</div>
									</div>
								</div>
							</div>
							<b>Severity</b>
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="info-box bg-red">
										<span class="info-box-icon" onclick="getSeverity(1)"><i class="fa fa-caret-square-o-up"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Critical</span>
											<span class="info-box-number" id="countCritical"></span>

											<span class="progress-description" title="Critical impact to business operations">
												[< 3 hour] Critical impact to business operations
												
											</span>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6">
									<div class="info-box bg-orange">
										<span class="info-box-icon" onclick="getSeverity(2)"><i class="fa fa-caret-square-o-right"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Major</span>
											<span class="info-box-number" id="countMajor"></span>

											<span class="progress-description" title="Significant impact to business operations">
												[< 8 hour] Significant impact to business operations
											</span>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="info-box"style="background-color: #f1c40f;color: #fff !important;">
										<span class="info-box-icon"  onclick="getSeverity(3)"><i class="fa fa-caret-square-o-down"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Moderate</span>
											<span class="info-box-number" id="countModerate"></span>

											<span class="progress-description" title="Business operations noticeably impaired ">
												[1x24 hour] Business operations noticeably impaired 
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="info-box bg-green" >
										<span class="info-box-icon" onclick="getSeverity(4)"><i class="fa fa-caret-square-o-down"></i></span>
										<div class="info-box-content">
											<span class="info-box-text">Minor</span>
											<span class="info-box-number" id="countMinor"></span>

											<span class="progress-description" title="Installation, upgrade, or configuration assistance General product information ">
												[on preventive] Installation, upgrade, or configuration assistance General product information 
											</span>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
				
				<div class="tab-pane" id="tab_2">
					<i class="btn btn-flat btn-info" id="createIdTicket" onclick="reserveIdTicket()">Reserve ID Ticket</i>
					<div class="row" id="formNewTicket">
						<div class="col-md-8">
							<form class="form-horizontal">
								<input type="hidden" id="inputID">
								<div class="form-group" id="nomorDiv" style="display: none;">
									<label for="inputNomor" class="col-sm-2 control-label" >Nomor Ticket</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputticket" value="" readonly>
									</div>
								</div>
								<div class="form-group" id="clientDiv" style="display: none;">
									<label class="col-sm-2 control-label">Client</label>
									<div class="col-sm-4">
										<select class="form-control" id="inputClient">
											<option selected="selected">Chose the client</option>
										</select>
									</div>
									<label class="col-sm-1 control-label">Severity</label>
									<div class="col-sm-5">
										<select class="form-control" id="inputSeverity">
											<option selected="selected">Chose the severity</option>
										</select>
									</div>
								</div>

								<hr id="hrLine" style="display: none">
								<div class="form-group" id="refrenceDiv" style="display: none;">
									<label for="inputDescription" class="col-sm-2 control-label">Refrence</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputRefrence" placeholder=""></div>
								</div>
								<!-- <div class="form-group has-error">
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Input with
										error</label>
									<input type="text" class="form-control" id="inputError" placeholder="Enter ...">
									
								</div> -->
								<div class="form-group" id="picDiv" style="display: none;">
									<label for="inputDescription" class="col-sm-2 control-label">PIC*</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputPIC" placeholder="" required>
										<span class="help-block" style="margin-bottom: 0px; display: none;">Person In Charge must be fill!</span>
									</div>
								</div>
								<div class="form-group" id="contactDiv" style="display: none;">
									<label for="inputDescription" class="col-sm-2 control-label">Contact PIC*</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputContact" placeholder="" required>
										<span class="help-block" style="margin-bottom: 0px; display: none;">Contact PIC must be fill!</span>
									</div>
								</div>
								<div class="form-group" id="categoryDiv" style="display: none;">
									<label for="inputCreator" class="col-sm-2 control-label">Category</label>
									<div class="col-sm-10">
										<select class="form-control" id="inputCategory" required>
											<option selected="selected">Chose problem category</option>
											<option>Aktivasi</option>
											<option>Cash Handler Fatal</option>
											<option>Cassette Fatal</option>
											<option>EJ Fail</option>
											<option>Key Fail</option>
											<option>Listening</option>
											<option>Vandalisme</option>
											<option>Softkey</option>
											<option>Dispenser</option>
											<option>Cartreader</option>
											<option>Printer</option>
											<option>Lain-lain</option>
										</select>
									</div>
								</div>
								<div class="form-group" id="problemDiv" style="display: none;">
									<label for="inputEmail" class="col-sm-2 control-label">Problem*</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputProblem" placeholder="" required>
										<span class="help-block" style="margin-bottom: 0px; display: none;">Problem must be fill!</span>
									</div>
								</div>
								<div class="form-group" id="inputATMid" style="display: none;">
									<label for="inputEmail" class="col-sm-2 control-label">ID ATM*</label>
									<div class="col-sm-10">
										<select class="form-control select2" id="inputATM" style="width: 100%" required></select>
										<span class="help-block" style="margin-bottom: 0px; display: none;">ATM must be select!</span>
									</div>
								</div>
								<div class="form-group" id="locationDiv" style="display: none;">
									<label for="inputEmail" class="col-sm-2 control-label">Location*</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputLocation" placeholder="" required>
										<span class="help-block" style="margin-bottom: 0px; display: none;">Location Must be fill!</span>
									</div>
								</div>
								<div class="form-group" id="serialDiv" style="display: none;">
									<label for="inputEmail" class="col-sm-2 control-label">Serial Number</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputSerial" placeholder="">
									</div>
								</div>

								<hr id="hrLine2" style="display: none">
								<div class="form-group" id="reportDiv" style="display: none;">
									<label for="inputEmail" class="col-sm-2 control-label">Report Time*</label>
									<div class="col-sm-5 firstReport">
										<div class="input-group">
											<input type="text" class="form-control" id="inputReportingTime" placeholder="ex. 01:11:00">
											<div class="input-group-addon">
												<i class="fa fa-clock-o"></i>
											</div>
										</div>
										<span class="help-block" style="margin-bottom: 0px; display: none;">Time must be set!</span>
									</div>
									<div class="col-sm-5 secondReport">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" class="form-control pull-right" id="inputReportingDate">
										</div>
										<span class="help-block" style="margin-bottom: 0px; display: none;">Date must be set!</span>
										<!-- <input type="text" class="form-control" id="inputReport" placeholder=""> -->
									</div>
								</div>
								<div class="form-group" id="dateDiv" style="display: none;">
									<label for="inputEmail" class="col-sm-2 control-label">Date Open</label>
									<div class="col-sm-10">

										<input type="text" class="form-control" id="inputDate" placeholder="" disabled></div>
								</div>
								<div class="form-group" id="noteDiv" style="display: none;">
									<label for="inputEmail" class="col-sm-2 control-label">Note Update</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="inputNote" placeholder=""></div>
								</div>
							</form>
							<i class="btn btn-flat btn-info pull-right" id="createTicket"  style="display: none;" onclick="createTicket()">Create Ticket</i>
						</div>

						<div class="col-md-4" id="tableTicket" style="display: none;">
							<table class="table table2">
								<tr>
									<th class="bg-primary">Ticket ID</th>
									<td id="holderID"></td>
								</tr>
								<tr>
									<th class="bg-primary">Refrence</th>
									<td id="holderRefrence"></td>
								</tr>
								<tr>
									<th class="bg-primary">Customer</th>
									<td id="holderCustomer"></td>
								</tr>
								<tr>
									<th class="bg-primary">PIC</th>
									<td id="holderPIC"></td>
								</tr>
								<tr>
									<th class="bg-primary">Contact</th>
									<td id="holderContact"></td>
								</tr>
								<tr>
									<th class="bg-primary">Problem</th>
									<td id="holderProblem"></td>
								</tr>
								<tr>
									<th class="bg-primary">Location</th>
									<td id="holderLocation"></td>
								</tr>
								
								<tr id="holderIDATM2" style="display: none;">
									<th class="bg-primary">ID ATM</th>
									<td id="holderIDATM"></td>
								</tr>
								<tr>
									<th class="bg-primary">Date</th>
									<td id="holderDate"></td>
								</tr>
								<tr>
									<th class="bg-primary">Serial number</th>
									<td id="holderSerial"></td>
								</tr>
								<tr>
									<th class="bg-primary">Severity</th>
									<td id="holderSeverity"></td>
								</tr>
								<tr>
									<th class="bg-primary">Status</th>
									<td id="holderStatus" class="text-center bg-red-active" style="border-bottom: none;"></td>
								</tr>
								<tr>
									<th class="bg-primary">Waktu</th>
									<td id="holderWaktu" class="text-center bg-red-active" style="border-top: none;"></td>
								</tr>
								<tr>
									<th class="bg-primary">Note</th>
									<td id="holderNote"></td>
								</tr>
							</table>
							<i class="btn btn-flat btn-info pull-right" id="createEmailBody" onclick="createEmailBody()">Create Email</i>
						</div>
					</div>
					<div class="row" id="sendTicket" style="display: none;">
						<div class="col-md-12">
							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-1 control-label">
										To : 
									</label>
									<div class="col-sm-11">
										<input class="form-control" name="emailTo" id="emailOpenTo">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-1 control-label">
										Cc :
									</label>
									<div class="col-sm-11">
										<input class="form-control" name="emailCc" id="emailOpenCc">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-1 control-label">
										Subject :
									</label>
									<div class="col-sm-11">
										<input class="form-control" name="emailSubject" id="emailOpenSubject">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyOpenMail">
											
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<div class="pull-right">
											<!-- <div class="btn btn-default btn-file">
												<i class="fa fa-paperclip"></i> Attachment
												<input type="file" name="attachment" id="emailOpenAttachment">
											</div> -->
											<button class="btn btn-flat btn-primary" onclick="sendOpenEmail()"><i class="fa fa-envelope-o"></i> Send</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="tab_3">
					<div class="row">
						<div class="col-md-9">
							<b>Filter by Client : </b>
							<div id="clientList"></div>
						</div>
						<div class="col-md-3">
							<b class="pull-right" style="color: white;">.</b>
							<div class="input-group pull-right">
								<input id="searchBarTicket" type="text" class="form-control" placeholder="Search Anyting">
								<span class="input-group-btn">
									<button id="applyFilterTablePerformance" type="button" class="btn btn-default btn-flat">
										<i class="fa fa-fw fa-search"></i>
									</button>
									<!-- <button id="clearFilterTable" type="button" class="btn btn-default btn-flat">
										<i class="fa fa-fw fa-remove"></i>
									</button> -->
									<!-- <button id="reloadTable" type="button" class="btn btn-default btn-flat">
										<i class="fa fa-fw fa-refresh"></i>
									</button> -->
								</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-striped" id="tablePerformance">
								<thead>
									<th style="width: 120px;text-align:center;vertical-align: middle;">ID Ticket</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">ID ATM*</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">Ticket Number</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">Open</th>
									<th style="vertical-align: middle;">Problem</th>
									<th style="text-align: center;vertical-align: middle;">PIC</th>
									<th style="width: 100px;vertical-align: middle;">Location</th>
									<th style="text-align: center;vertical-align: middle;">Status</th>
									<th style="text-align: center;vertical-align: middle;">Operator</th>
									<th style="text-align: center;vertical-align: middle;">Action</th>
								</thead>
								<tfoot>
									<th style="width: 120px;text-align:center;vertical-align: middle;">ID Ticket</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">ID ATM*</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">Ticket Number</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">Open</th>
									<th style="vertical-align: middle;">Problem</th>
									<th style="text-align: center;vertical-align: middle;">PIC</th>
									<th style="width: 100px;vertical-align: middle;">Location</th>
									<th style="text-align: center;vertical-align: middle;">Status</th>
									<th style="text-align: center;vertical-align: middle;">Operator</th>
									<th style="text-align: center;vertical-align: middle;">Action</th>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="tab_4">
					<div class="row form-group">
						<div class="col-md-9">
							<button class="btn btn-flat btn-default" onclick="emailSetting()">
								Email Setting
							</button>
							<button class="btn btn-flat btn-default" onclick="atmSetting()">
								ATM Setting
							</button>
							<button class="btn btn-flat btn-default" onclick="severitySetting()">
								Severity Setting
							</button>

							
						</div>
						<div class="col-sm-3 settingComponent" style="display: none" id="addAtm2">
							<div class="input-group">	
								<input id="searchBarATM" type="text" class="form-control" placeholder="Search ATM">
								<span class="input-group-btn">
									<button id="applyFilterTableATM" type="button" class="btn btn-default btn-flat">
										<i class="fa fa-fw fa-search"></i>
									</button>
									<button class="btn btn-flat btn-primary" onclick="atmAdd()" id="addAtm" style="margin-left: 10px;">
										Add ATM
									</button>
								</span>
							</div>
						</div>
					</div>
					<div style="display: none" id="emailSetting" class="row form-group settingComponent">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<th colspan="6" style="vertical-align: middle;text-align: center;">Open</th>
										<th colspan="6" style="vertical-align: middle;text-align: center;">Close</th>
									</tr>
									<tr>
										<th style="vertical-align: middle;text-align: center;">Client</th>
										<th style="vertical-align: middle;text-align: center;">Acronym</th>
										<th style="vertical-align: middle;text-align: center;">Dear</th>
										<th style="vertical-align: middle;text-align: center;">To</th>
										<th style="vertical-align: middle;text-align: center;">Cc</th>
										<th style="vertical-align: middle;text-align: center;">Dear</th>
										<th style="vertical-align: middle;text-align: center;">To</th>
										<th style="vertical-align: middle;text-align: center;">Cc</th>
										<th style="vertical-align: middle;text-align: center;">#</th>
										
									</tr>
									@foreach($clients as $client)
									<tr>
										<td style="vertical-align: middle;text-align: left;">{{$client->client_name}}</td>
										<td style="vertical-align: middle;text-align: center;">{{$client->client_acronym}}</td>
										<td style="vertical-align: middle;text-align: left;">{{$client->open_dear}}</td>
										<td style="vertical-align: middle;text-align: left;">{!! $client->open_to !!}</td>
										<td style="vertical-align: middle;text-align: left;">{!! $client->open_cc !!}</td>
										<td style="vertical-align: middle;text-align: left;">{{ $client->close_dear }}</td>
										<td style="vertical-align: middle;text-align: left;">{!! $client->close_to !!}</td>
										<td style="vertical-align: middle;text-align: left;">{!! $client->close_cc !!}</td>

										<td style="vertical-align: middle;text-align: center;"><button type="button" class="btn btn-block btn-default" onclick="editClient({{$client->id}})">Edit</button></td>
									</tr>
									@endforeach
								</table>
							</div>		
						</div>
					</div>
					<div style="display: none" id="atmSetting" class="row form-group settingComponent">
						<div class="col-md-12">
							<table class="table table-striped" id="tableAtm">
								<thead>
									<tr>
										<th style="vertical-align: middle;text-align: center;">Owner</th>
										<th style="vertical-align: middle;text-align: center;">ATM ID</th>
										<th style="vertical-align: middle;text-align: center;">Serial Number</th>
										<th style="vertical-align: middle;text-align: center;">Location</th>
										<th style="vertical-align: middle;text-align: center;"></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div style="display: none" id="severitySetting" class="row form-group settingComponent">
						<div class="col-md-12">
							Comming Soon...
						</div>
					</div>
				</div>

				<div class="tab-pane" id="tab_5">
					Comming Soon...
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="modal-ticket">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="margin-left: 5px;">×</span>
					</button>
					<div class="modal-tools pull-right" style="text-align: right";>
						<div>
							<span class="label label-default" id="ticketSeverity" style="font-size: 15px;"></span>
						</div>
						<div style="margin-top: 5px;">
							<span id="ticketOpen"></span> 
							<span class="label label-default" id="ticketStatus"></span>
						</div>
					</div>
					<div>
						<h4 class="modal-title" id="modal-ticket-title">Ticket ID </h4>
						<span id="ticketOperator"></span>
					</div>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" class="form-control" id="ticketID">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>ID ATM</label>
									<input type="text" class="form-control" id="ticketIDATM" readonly>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Serial Number</label>
									<input type="text" class="form-control" id="ticketSerial" readonly>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Problem</label>
							<input type="text" class="form-control" id="ticketProblem" readonly>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>PIC</label>
									<input type="text" class="form-control" id="ticketPIC" readonly>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Location</label>
									<input type="text" class="form-control" id="ticketLocation" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Number Ticket</label>
									<input type="text" class="form-control" id="ticketNumber">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Engineer</label>
									<input type="text" class="form-control" id="ticketEngineer">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Activity</label>
							<ul id="ticketActivity">
							</ul>
						</div>
						<div class="form-group" id="ticketNoteUpdate">
							<label>Note Activity*</label>
							<textarea class="form-control" rows="1" id="ticketNote"></textarea>
						</div>
						<div class="form-group" style="display: none" id="ticketRoute" >
							<label>Route Cause</label>
							<textarea type="text" class="form-control" id="ticketRouteTxt"  readonly></textarea>
						</div>
						<div class="form-group" style="display: none" id="ticketCouter">
							<label>Couter Measure</label>
							<textarea type="text" class="form-control" id="ticketCouterTxt" readonly></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-flat btn-success" id="closeButton">Close</button>
					<button type="button" class="btn btn-flat btn-warning" id="pendingButton">Pending</button>
					<button type="button" class="btn btn-flat bg-purple" id="cancelButton" >Cancel</button>
					<button type="button" class="btn btn-flat btn-primary" id="updateButton">Update</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-close">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						
						<h4 class="modal-title" id="modal-ticket-title">Close Ticket </h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">
								<label>Root Cause</label>
								<textarea type="text" class="form-control" id="saveCloseRoute"></textarea>
							</div>
							<div class="form-group">
								<label>Couter Measure</label>
								<textarea type="text" class="form-control" id="saveCloseCouter"></textarea>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Time</label>

											<div class="input-group">
												<input type="text" class="form-control timepicker" id="timeClose">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Date</label>

										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" class="form-control pull-right" id="dateClose">
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat btn-success " onclick="prepareCloseEmail()">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-next-close">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modal-ticket-title">Send Close Ticket</h4>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email To : 
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailTo" id="emailCloseTo">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email Cc :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailCc" id="emailCloseCc">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Subject :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailSubject" id="emailCloseSubject">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyCloseMail">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="pull-right">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<i class="btn btn-flat btn-primary" onclick="sendCloseEmail()"><i class="fa fa-envelope-o"></i> Send</i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-pending">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="modal-ticket-title">Pending Ticket</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">
								<label>Reason</label>
								<textarea type="text" class="form-control" id="saveReasonPending"></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat btn-warning " onclick="preparePendingEmail()">Pending</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-next-pending">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="modal-ticket-title">Send Pending Ticket </h4>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email To : 
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailTo" id="emailPendingTo">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email Cc :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailCc" id="emailPendingCc">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Subject :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailSubject" id="emailPendingSubject">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyPendingMail">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="pull-right">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<i class="btn btn-flat btn-primary" onclick="sendPendingEmail()"><i class="fa fa-envelope-o"></i> Send</i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-cancel">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="modal-ticket-title">Cancel Ticket</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">
								<label>Reason</label>
								<textarea type="text" class="form-control" id="saveReasonCancel"></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat bg-purple " onclick="prepareCancelEmail()">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-next-cancel">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="modal-ticket-title">Send Cancel Ticket </h4>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email To : 
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailTo" id="emailCancelTo">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email Cc :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailCc" id="emailCancelCc">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Subject :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailSubject" id="emailCancelSubject">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyCancelMail">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<i class="btn btn-flat btn-primary" onclick="sendCancelEmail()"><i class="fa fa-envelope-o"></i> Send</i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modal-setting-title">Change Setting for </h4>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" class="form-control" id="clientId">
						<div class="form-group">
							<label>Client Title</label>
							<input type="text" class="form-control" id="clientTitle">
						</div>
						<div class="form-group">
							<label>Client Acronym</label>
							<input type="text" class="form-control" id="clientAcronym">
						</div>
						<hr>
						<div class="form-group">
							<label>Open Dear</label>
							<input type="text" class="form-control" id="openDear">
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Open To</label>
									<textarea class="form-control" rows="3" id="openTo"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Open Cc</label>
									<textarea class="form-control" rows="3" id="openCc"></textarea>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label>Close Dear</label>
							<input type="text" class="form-control" id="closeDear">
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Close To</label>
									<textarea class="form-control" rows="3" id="closeTo"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Close Cc</label>
									<textarea class="form-control" rows="3" id="closeCc"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="saveClient()">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting-atm">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="modal-setting-title">Change ATM Detail </h4>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" id="idAtm">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Owner</label>
									<select class="form-control" id="atmOwner"></select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>ATM ID</label>
									<input type="text" class="form-control" id="atmID">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Serial Number</label>
							<input type="text" class="form-control" id="atmSerial">
						</div>
						<div class="form-group">
							<label>Location ATM</label>
							<input type="text" class="form-control" id="atmLocation">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="saveAtm()">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting-atm-add">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="modal-setting-title">ATM Add</h4>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" id="idAtm">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Owner</label>
									<select class="form-control" id="atmOwner2"></select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>ATM ID</label>
									<input type="text" class="form-control" id="atmID2">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Serial Number</label>
							<input type="text" class="form-control" id="atmSerial2">
						</div>
						<div class="form-group">
							<label>Location ATM</label>
							<input type="text" class="form-control" id="atmLocation2">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="newAtm()">Add</button>
				</div>
			</div>
		</div>
	</div>
</div>
<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Version</b> 2.4.0
	</div>
	<strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
	reserved.
</footer>
@endsection 
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.5/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>

<script src="{{ url('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ url('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ url('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{ url('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ url('js/jquery.emailinput.min.js')}}"></script>

<script>

	var swalWithCustomClass

	$(document).ready(function(){
		getDashboard();

		// $('#searchBarTicket').keyup(function(){
		// 	$("#tablePerformance").DataTable().search($(this).val()).draw();
		// })

		$('#searchBarATM').keypress(function(e){
			if(e.keyCode == 13){
				$("#tableAtm").DataTable().search($('#searchBarATM').val()).draw();
			}
		});

		$('#applyFilterTableATM').click(function(){
			$("#tableAtm").DataTable().search($('#searchBarATM').val()).draw();
		})
		
		$('#searchBarTicket').keypress(function(e){
			if(e.keyCode == 13){
				$("#tablePerformance").DataTable().search($('#searchBarTicket').val()).draw();
			}
		});

		$('#applyFilterTablePerformance').click(function(){
			$("#tablePerformance").DataTable().search($('#searchBarTicket').val()).draw();
		})


		$('#clearFilterTable').click(function(){
			$('#searchBarTicket').val('')
			$('#tablePerformance').DataTable().search('').draw();
		});

		$('#reloadTable').click(function(){
			$(".buttonFilter").removeClass('btn-primary').addClass('btn-default')
			$("#tablePerformance").DataTable().ajax.url('tisygy/getPerformanceAll').load();
		});

		swalWithCustomClass = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-flat btn-primary swal2-margin',
				cancelButton: 'btn btn-flat btn-danger swal2-margin',
				popup: 'border-radius-0',
			},
			buttonsStyling: false,
		})

		$('#dateClose').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy'
		});


		$("#inputReportingTime").val(moment().format('HH:mm:ss'))

		// $("#inputReportingTime").timepicker({
		// 	showInputs: false,
		// 	minuteStep: 1,
		// 	maxHours: 24,
		// 	showMeridian: false,
		// 	showSeconds:true,
		// });

		$('#inputReportingDate').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy'
		});

	})

	function swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,callback){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "Make sure there is nothing wrong to send this " + typeActivity + " ticket!",
			type: typeAlert,
			showCancelButton: true,
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			}).then((result) => {
				if (result.value){
					Swal.fire({
						title: 'Please Wait..!',
						text: "It's sending..",
						allowOutsideClick: false,
						allowEscapeKey: false,
						allowEnterKey: false,
						customClass: {
							popup: 'border-radius-0',
						},
						onOpen: () => {
							Swal.showLoading()
						}
					})

					$.ajax({
						type: typeAjax,
						url: urlAjax,
						data: dataAjax,
						success: function(resultAjax){
							Swal.hideLoading()
							swalWithCustomClass.fire({
								title: 'Success!',
								text: typeActivity + " Ticket Sended.",
								type: 'success',
								confirmButtonText: 'Reload',
							}).then((result) => {
								// console.log(resultAjax)
								callback()
								getPerformanceByClient(resultAjax.client_acronym_filter)
							})
						}
					});
				}
			}
		);
	}

	$("#manageID").change(function(){
		// console.log(this.value);
		$("#manageIDTicket").val(this.value);
	});

	$("#manageClient").change(function(){
		var id = $("#manageID").val();
		$("#manageIDTicket").val();
		$("#manageIDTicket").val(id + "/" + this.value);
	});

	$("#manageDate").change(function(){
		var id = $("#manageID").val();
		var client = $("#manageClient").val();
		var date = moment($("#manageDate").val(),"DD/MM/YYYY").format('MMM/YYYY');
		$("#manageIDTicket").val();
		$("#manageIDTicket").val(id + "/" + client + "/" + date);
	});



	Chart.pluginService.register({
		beforeDraw: function(chart) {
			if (chart.config.centerText.display !== null &&
				typeof chart.config.centerText.display !== 'undefined' &&
				chart.config.centerText.display) {
				drawTotals(chart);
			}
		},
	});

	function drawTotals(chart) {
 
		var width = chart.chart.width,
		height = chart.chart.height,
		ctx = chart.chart.ctx;
	 
		ctx.restore();
		var fontSize = (height / 114).toFixed(2);
		ctx.font = fontSize + "em sans-serif";
		ctx.textBaseline = "middle";
	 
		var text = chart.config.centerText.text,
		textX = Math.round((width - ctx.measureText(text).width) / 2),
		textY = height / 2;
	 
		ctx.fillText(text, textX * 2/3 , textY);
		ctx.save();
	}

	function getDashboard(){
		$.ajax({
			type:"GET",
			url:"{{url('tisygy/getDashboard')}}",
			success:function(result){

				// console.log(result);
				$("#countOpen").text(result.counter_condition.OPEN);
				$("#countProgress").text(result.counter_condition.PROGRESS);
				$("#countPending").text(result.counter_condition.PENDING);
				$("#countClose").text(result.counter_condition.CLOSE);
				$("#countCancel").text(result.counter_condition.CANCEL); 
				$("#countAll").text(result.counter_condition.ALL);

				$("#countCritical").text(result.counter_severity.Critical);
				$("#countMajor").text(result.counter_severity.Major);
				$("#countModerate").text(result.counter_severity.Moderate);
				$("#countMinor").text(result.counter_severity.Minor);
				var append = ""
				$.each(result.chart_data.label,function(key,value){
					var onclickFunction = "getPerformanceByClient('" + value + "')";
					append = append + '<button class="btn btn-flat btn-default buttonFilter buttonFilter' + value+ '" onclick=' + onclickFunction + '>' + value + '</button> ';
				});

				$("#clientList").html(append);

				var append = '';
				$("#importanTable").empty(append);
				$.each(result.occurring_ticket,function(key,value){
					append = append + '<tr onclick=goTo("'+ value.id_ticket + '") >';
						append = append + '<td>' + value.id_ticket + '</td>';
						append = append + '<td>' + value.id_atm + '</td>';
						append = append + '<td>' + value.location + '</td>';
						append = append + '<td>' + moment(value.date).format('D MMM HH:mm') + '</td>';
						if(value.severity == 1)
							append = append + '<td><span class="label label-danger">Critical</span></td>';
						else if (value.severity == 2)
							append = append + '<td><span class="label" style="background-color:#e67e22 !important">Major</span></td>';
						else if (value.severity == 3)
							append = append + '<td><span class="label" style="background-color:#f1c40f !important">Moderate</span></td>';
						else if (value.severity == 4)
							append = append + '<td><span class="label label-success">Minor</span></td>';
						append = append + '<td>' + value.operator + '</td>';
					append = append + '</tr>';
				});
				
				$("#importanTable").append(append);

				var config = {
					type: 'doughnut',
					data: {
						labels: result.chart_data.label,
						datasets: [{
							data: result.chart_data.data,
							backgroundColor: [
							"#EA2027",
							"#EE5A24",
							"#F79F1F",
							"#FFC312",
							"#C4E538",
							"#A3CB38",
							"#009432",
							"#006266",
							"#1B1464",
							"#0652DD",
							"#1289A7",
							"#12CBC4",
							"#FDA7DF",
							"#D980FA",
							"#9980FA",
							"#5758BB"
							],
						}]
					},
					options: {
						responsive: true,
						legend: {
							position:'right',
							display: true,
							labels: {
								generateLabels: function(chart) {
									var data = chart.data;
									if (data.labels.length && data.datasets.length) {
										return data.labels.map(function(label, i) {
											var meta = chart.getDatasetMeta(0);
											var ds = data.datasets[0];
											var arc = meta.data[i];
											var custom = arc && arc.custom || {};
											var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
											var arcOpts = chart.options.elements.arc;
											var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
											var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
											var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

											// We get the value of the current label
											var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

											return {
												// Instead of `text: label,`
												// We add the value to the string
												text: label + " : " + value,
												fillStyle: fill,
												strokeStyle: stroke,
												lineWidth: bw,
												hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
												index: i
											};
										});
									} else {
										return [];
									}
								}
							}
						}
					},
					centerText: {
						display: true,
						text: ""
					}
				};

				var ctx = document.getElementById("pieChart").getContext("2d");
				window.myDoughnut = new Chart(ctx, config);

				if("{{Auth::user()->id}}" == 4){
					$("#management").click();
				}

			}
		});
	}

	function clearFormNewTicket(){
		$("#inputRefrence").val('');
		$("#inputPIC").val('');
		$("#inputContact").val('');
		$("#inputCategory").val('');
		$("#inputProblem").val('');
		if ($('#inputATM').hasClass("select2-hidden-accessible")) {
			$("#inputATM").select2('destroy');
		}
		$("#inputATM").empty()
		$("#inputLocation").val('');
		$("#inputSerial").val('');
		// $("#inputReportingTime").val('');
		$("#inputReportingTime").val(moment().format('HH:mm:ss'))
		$("#inputReportingDate").val('');
		$("#inputDate").val('');
		$("#inputNote").val('');

		$("#hrLine").show();
		$("#hrLine2").show();

		$("#nomorDiv").hide()
		$("#clientDiv").hide()
		$("#refrenceDiv").hide()
		$("#picDiv").hide()
		$("#contactDiv").hide()
		$("#categoryDiv").hide()
		$("#problemDiv").hide()
		$("#inputATMid").hide()
		$("#locationDiv").hide()
		$("#serialDiv").hide()
		$("#reportDiv").hide()
		$("#dateDiv").hide()
		$("#noteDiv").hide()
		$("#createTicket").hide()

		$("#holderID").text('');
		$("#holderRefrence").text('');
		$("#holderCustomer").text('');
		$("#holderPIC").text('');
		$("#holderContact").text('');
		$("#holderProblem").text('');
		$("#holderLocation").text('');
		$("#holderEngineer").text('');
		$("#holderDate").text('');
		$("#holderSerial").text('');
		$("#holderSeverity").text('');
		// $("#holderRoot").text($("#inputticket").val();
		$("#holderNote").text('');
		$("#holderStatus").html('');
		$("#holderWaktu").html('');
		$("#holderIDATM2").hide();
		$("#holderIDATM").text('');
		
		$("#tableTicket").hide();

		$('.emailMultiSelector').remove()
		$("#emailOpenTo").val('')
		$("#emailOpenCc").val('')
		$("#emailOpenSubject").val('')
		$("#bodyOpenMail").empty()
		$("#sendTicket").hide()

		$("#formNewTicket").hide();
		$("#createIdTicket").show();
	}

	function makeNewTicket(){
		if(firstTimeTicket !== 0){
			swalWithCustomClass.fire({
				title: 'Are you sure?',
				text: "This information of create ticket will be reset!",
				type: 'warning',
				showCancelButton: true,
			}).then((result) => {
				firstTimeTicket = 0
				clearFormNewTicket()
				$.ajax({
					type:"GET",
					url:"getCreateParameter",
					success: function (result){
						var append = "";
						var append2 = "<option selected='selected'>Chose the client</option> ";
						var append3 = "<option selected='selected' val='None'>Chose the severity</option> ";

						$.each(result[0],function(key,value){
							var dummy = "getPerformance('" + value + "')";
							append = append + '<button class="btn btn-default" onclick=' + dummy + '>' + value + '</button> ';
							append2 = append2 + "<option value='" + value + "'>" + value + "</option>";
						});

						$.each(result[2],function(key,value){
							append3 = append3 + "<option value='" + result[1][key] + " (" + value + ")'>" + value + " (" + result[3][key] +")</option>";
						});

						$("#inputClient").html(append2);
						$("#inputSeverity").html(append3);
					},
				});
			})
		} else {
			$.ajax({
				type:"GET",
				url:"getCreateParameter",
				success: function (result){
					var append = "";
					var append2 = "<option selected='selected'>Chose the client</option> ";
					var append3 = "<option selected='selected' val='None'>Chose the severity</option> ";

					$.each(result[0],function(key,value){
						var dummy = "getPerformance('" + value + "')";
						append = append + '<button class="btn btn-default" onclick=' + dummy + '>' + value + '</button> ';
						append2 = append2 + "<option value='" + value + "'>" + value + "</option>";
					});

					$.each(result[2],function(key,value){
						append3 = append3 + "<option value='" + result[1][key] + " (" + value + ")'>" + value + " (" + result[3][key] +")</option>";
					});

					$("#inputClient").html(append2);
					$("#inputSeverity").html(append3);
				},
			});
		}
		
	}

	// $('#atmTable').DataTable({
	// 	"paging": true,
	// 	"lengthChange": false,
	// 	"searching": true,
	// 	"ordering": true,
	// 	"info": true,
	// 	"autoWidth": false
	// });

	

	

	function newAtm(){
		$.ajax({
			type:"GET",
			url:"newAtm",
			data:{
				atmOwner:$("#atmOwner2").val(),
				atmID:$("#atmID2").val(),
				atmSerial:$("#atmSerial2").val(),
				atmLocation:$("#atmLocation2").val(),
			},
			success: function (){
				$("#modal-setting-atm-add").modal('toggle');
				window.location('/tisygy');
			}
		})
	}

	function atmAdd(){
		$("#modal-setting-atm-add").modal('toggle');
		$.ajax({
			type:"GET",
			url:"getDetailAtm/621",
			success:function(result){
				$.each(result[1], function (key,value){
					$("#atmOwner2").append("<option value='" + value.id + "'>(" + value.client_acronym + ") " + value.client_name + "</option>")
				});
			}
		});
	}

	function saveAtm(){
		$.ajax({
			type:"GET",
			url:"setAtm",
			data:{
				idAtm:$("#idAtm").val(),
				atmOwner:$("#atmOwner").val(),
				atmID:$("#atmID").val(),
				atmSerial:$("#atmSerial").val(),
				atmLocation:$("#atmLocation").val(),
			},
			success: function (){
				$("#modal-setting-atm").modal('toggle');
			}
		})
	}

	function editAtm(atm_id){
		$("#modal-setting-atm").modal('toggle');
		$.ajax({
			type:"GET",
			url:"getDetailAtm/" + atm_id,
			success:function(result){
				$.each(result[1], function (key,value){
					$("#atmOwner").append("<option value='" + value.id + "'>(" + value.client_acronym + ") " + value.client_name + "</option>")
				});
				$("#idAtm").val(atm_id);
				$("#atmOwner").val(result[0][0].owner);
				$("#atmID").val(result[0][0].atm_id);
				$("#atmSerial").val(result[0][0].serial_number);
				$("#atmLocation").val(result[0][0].location);
			}
		});
	}

	function emailSetting(){
		$(".settingComponent").hide()
		$("#emailSetting").show()
	}

	function atmSetting(){
		$(".settingComponent").hide()
		$("#atmSetting").show()
		$("#addAtm").show()
		$("#addAtm2").show()

		if($.fn.dataTable.isDataTable("#tableAtm")){

		} else {
			$("#tableAtm").DataTable({
				ajax:{
					type:"GET",
					url:"{{url('tisygy/setting/getAllAtm')}}",
					dataSrc: function (json){
						json.data.forEach(function(data,idex){
							data.action = '<button type="button" class="btn btn-block btn-default" onclick="editAtm('+ data.id + ')">Edit</button>'
						})
						return json.data
					}
				},
				columns:[
					{
						data:'owner',
						className:'text-center',
					},
					{ 	
						data:'atm_id',
						className:'text-center',
					},
					{
						data:'serial_number',
						className:'text-center',
					},
					{ 
						data:'location',
						className:'text-center',
					},
					{
						data:'action',
						className:'text-center',
						orderable: false,
						searchable: true,
					}
				],
				// order: [[10, "DESC" ]],
				autoWidth:false,
				lengthChange: false,
				searching:true,
			})
		}

	}

	function severitySetting(){
		$(".settingComponent").hide()
		$("#severitySetting").show()
	}

	// $("#inputATM").select2({
	// 	minimumInputLength: 2,
	// 	selectOnClose: true,
	// 	tags: [],
	// 	ajax: {
	// 		url: 'getAtm',
	// 		dataType: 'json',
	// 		type: "GET",
	// 		quietMillis: 50,
	// 		data: function (term) {
	// 			return {
	// 				term: term
	// 			};
	// 		},
	// 		results: function (data) {
	// 			return {
	// 				results: $.map(data, function (item) {
	// 					return {
	// 						text: item.completeName,
	// 						slug: item.slug,
	// 						id: item.id
	// 					}
	// 				})
	// 			};
	// 		}
	// 	}
	// });

	function myFunction() {
		var input, filter, table, tr, td, i;
		input = document.getElementById("myInput");
		filter = input.value.toUpperCase();
		table = document.getElementById("tablePerformance");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[0];
			if (td) {
				if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
		}
	}

	function myFunction2() {
		var input, filter, table, tr, td, i;
		input = document.getElementById("myInput2");
		filter = input.value.toUpperCase();
		table = document.getElementById("tablePerformance");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[1];
			if (td) {
				if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
		}
	}

	$("#inputATM").change(function(){
		if(this.value === "Select One"){
			$("#inputLocation").val("");
			$("#inputSerial").val("");
		} else {
			$.ajax({
				type:"GET",
				url:"{{url('tisygy/create/getAtmDetail')}}",
				data:{
					id_atm:this.value
				},
				success: function(result){
					$("#inputLocation").val(result.location);
					$("#inputSerial").val(result.serial_number);
				}
			});
		}
	});
	// $(".sidebar-toggle").click();
	//Timepicker
	$(".timepicker").timepicker({
		showInputs: false,
		minuteStep: 1,
		maxHours: 24,
		showMeridian: false,
		showSeconds:true,
	});

	
	$("#saveCloseButton").on("click",{id_ticket:$('#ticketID').val()},function(event){
			if($("#saveCloseRoute").val() == "" && $("#saveCloseCouter").val() == ""){
				alert('You must fill root cause and counter measure!');
			} else if($("#saveCloseCouter").val() == ""){
				alert('You must fill counter measure!');
			} else if($("#saveCloseRoute").val() == ""){
				alert('You must fill root cause!');
			} else if($("#timeClose").val() == ""){
				alert('You must fill time!');
			} else if($("#dateClose").val() == ""){
				alert('You must fill date!');
			} else {
				if(confirm("Are you sure to close this ticket?")){
					$("#modal-next-close").modal('toggle');
					// $.ajax({
					//  type:"get",
					//  url:"closeTicket",
					//  data:{
					//      id_ticket:event.data.id_ticket,
					//      root_cause:$("#saveCloseRoute").val(),
					//      couter_measure:$("#saveCloseCouter").val()
					//  },
					//  success:function(){
					//      $('#modal-close').modal('toggle');
					//      $('#modal-ticket').modal('toggle');
					//  }
					// });

					$.ajax({
						type:"GET",
						url:"getEmailReciver",
						data:{
							id_ticket:$('#ticketID').val(),
						},
						success: function (result){
							$("#emailCloseTo").val(result[0].close_to);
							$("#emailCloseCc").val(result[0].close_cc);
							$("#emailCloseSubject").val("Close Tiket " + $(".holderCloseLocation").text() + " [" + $(".holderCloseProblem").text() +"]");
							$("#emailCloseHeader").html("Dear <b>" + result[0].close_dear + "</b><br>Berikut terlampir Close Tiket untuk Problem <b>" + $(".holderCloseLocation").text() + "</b> : ");
							$(".holderCloseCustomer").text(result[0].client_name);

							if(result[0].client_acronym  == "BJBR" || result[0].client_acronym  == "BSBB" || result[0].client_acronym  == "BRKR"){
								$(".holderCloseIDATM2").show();
								$(".holderNumberTicket2").show();
							} else {
								$(".holderCloseIDATM2").hide();
								$(".holderNumberTicket2").hide();
							}

							console.log(result[0].client_acronym);
						}
					})
					$(".holderCloseCounter").text($("#saveCloseCouter").val());
					$(".holderCloseRoot").text($("#saveCloseRoute").val());
					var waktu2 = moment($("#timeClose").val() + " " + $("#dateClose").val()).format("DD MMMM YYYY (HH:mm)");
					console.log(waktu2);
					$(".holderCloseWaktu").html("<b>" + waktu2 + "</b>");

				} else {
					console.log("no");
				}
			}
		}
	);

	function prepareCloseEmail() {
		if($("#saveCloseRoute").val() == "" && $("#saveCloseCouter").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill root cause and counter measure!',
				'error'
			)
		} else if($("#saveCloseCouter").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill counter measure!',
				'error'
			)
		} else if($("#saveCloseRoute").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill root cause!',
				'error'
			)
		} else if($("#timeClose").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill time!',
				'error'
			)
		} else if($("#dateClose").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill date!',
				'error'
			)
		} else {
			swalWithCustomClass.fire({
				title: 'Are you sure?',
				text: "Are you sure to close this ticket?",
				type: 'warning',
				showCancelButton: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url:"{{url('tisygy/mail/getCloseMailTemplate')}}",
						type:"GET",
						success: function (result){
							$("#bodyCloseMail").html(result);
						}
					})

					$.ajax({
						url:"{{url('tisygy/mail/getEmailData')}}",
						type:"GET",
						data:{
							id_ticket:$('#ticketID').val()
						},
						success: function (result){
							// Holder Close

							$(".holderCloseID").text(result.ticket_data.id_ticket);
							$(".holderCloseRefrence").text(result.ticket_data.refrence);
							$(".holderClosePIC").text(result.ticket_data.pic);
							$(".holderCloseContact").text(result.ticket_data.contact_pic);
							$(".holderCloseLocation").text(result.ticket_data.location);
							$(".holderCloseProblem").text(result.ticket_data.problem);
							$(".holderCloseSerial").text(result.ticket_data.serial_device);
							$(".holderCloseSeverity").text(result.ticket_data.severity_detail.id + " (" + result.ticket_data.severity_detail.name + ")")
							
							$(".holderCloseIDATM").text(result.ticket_data.id_atm);

							$(".holderCloseNote").text("");
							$(".holderCloseEngineer").text(result.ticket_data.engineer);

							var waktu = moment((result.ticket_data.first_activity_ticket.date), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");

							$(".holderCloseDate").text(waktu);

							$(".holderCloseStatus").html("<b>CLOSE</b>");
							$(".holderNumberTicket").text($("#ticketNumber").val());

							// Email Reciver
							$('.emailMultiSelector ').remove()
							$("#emailCloseTo").val(result.ticket_reciver.close_to)
							$("#emailCloseTo").emailinput({ onlyValidValue: true, delim: ';' });
							$("#emailCloseCc").val(result.ticket_reciver.close_cc)
							$("#emailCloseCc").emailinput({ onlyValidValue: true, delim: ';' });

							$("#emailCloseSubject").val("Close Tiket " + $(".holderCloseLocation").text() + " [" + $(".holderCloseProblem").text() +"]");
							$("#emailCloseHeader").html("Dear <b>" + result.ticket_reciver.close_dear + "</b><br>Berikut terlampir Close Tiket untuk Problem <b>" + $(".holderCloseLocation").text() + "</b> : ");
							$(".holderCloseCustomer").text(result.ticket_reciver.client_name);

							if(result.ticket_reciver.client_acronym  == "BJBR" || result.ticket_reciver.client_acronym  == "BSBB" || result.ticket_reciver.client_acronym  == "BRKR"){
								$(".holderCloseIDATM2").show();
								$(".holderNumberTicket2").show();
							} else {
								$(".holderCloseIDATM2").hide();
								$(".holderNumberTicket2").hide();
							}

							$(".holderCloseCounter").text($("#saveCloseCouter").val());
							$(".holderCloseRoot").text($("#saveCloseRoute").val());
							$(".holderCloseWaktu").html("<b>" + moment($("#dateClose").val(),'DD/MM/YYYY').format("DD MMMM YYYY") + " " + moment($("#timeClose").val(),'HH:mm:ss').format("(HH:mm)") + "</b>");
						},
						complete: function(){
							$("#modal-next-close").modal('toggle');
						}
					})
				}
			})
		}
	}

	function preparePendingEmail(){
		if($("#saveReasonPending").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill pending reason!',
				'error'
			)
		} else {
			swalWithCustomClass.fire({
				title: 'Are you sure?',
				text: "Are you sure to pending this ticket?",
				type: 'warning',
				showCancelButton: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url:"{{url('tisygy/mail/getPendingMailTemplate')}}",
						type:"GET",
						success: function (result){
							$("#bodyPendingMail").html(result);
						}
					})

					$.ajax({
						url:"{{url('tisygy/mail/getEmailData')}}",
						type:"GET",
						data:{
							id_ticket:$('#ticketID').val()
						},
						success: function (result){
							// Holder Pending

							$(".holderPendingID").text(result.ticket_data.id_ticket);
							$(".holderPendingRefrence").text(result.ticket_data.refrence);
							$(".holderPendingPIC").text(result.ticket_data.pic);
							$(".holderPendingContact").text(result.ticket_data.contact_pic);
							$(".holderPendingLocation").text(result.ticket_data.location);
							$(".holderPendingProblem").text(result.ticket_data.problem);
							$(".holderPendingSerial").text(result.ticket_data.serial_device);
							$(".holderPendingSeverity").text(result.ticket_data.severity_detail.id + " (" + result.ticket_data.severity_detail.name + ")")

							$(".holderPendingIDATM").text(result.ticket_data.id_atm);

							$(".holderPendingNote").text("");
							$(".holderPendingEngineer").text(result.ticket_data.engineer);

							var waktu = moment((result.ticket_data.first_activity_ticket.date), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");

							$(".holderPendingDate").text(waktu);

							$(".holderPendingStatus").html("<b>PENDING</b>");
							$(".holderNumberTicket").text($("#ticketNumber").val());

							// Email Reciver
							$('.emailMultiSelector ').remove()
							$("#emailPendingTo").val(result.ticket_reciver.close_to)
							$("#emailPendingTo").emailinput({ onlyValidValue: true, delim: ';' });
							$("#emailPendingCc").val(result.ticket_reciver.close_cc)
							$("#emailPendingCc").emailinput({ onlyValidValue: true, delim: ';' });

							$("#emailPendingSubject").val("Pending Tiket " + $(".holderPendingLocation").text() + " [" + $(".holderPendingProblem").text() +"]");
							$("#emailPendingHeader").html("Dear <b>" + result.ticket_reciver.close_dear + "</b><br>Berikut terlampir Pending Tiket untuk Problem <b>" + $(".holderPendingLocation").text() + "</b> : ");
							$(".holderPendingCustomer").text(result.ticket_reciver.client_name);

							if(result.ticket_reciver.client_acronym  == "BJBR" || result.ticket_reciver.client_acronym  == "BSBB" || result.ticket_reciver.client_acronym  == "BRKR"){
								$(".holderPendingIDATM2").show();
								$(".holderNumberTicket2").show();
							} else {
								$(".holderPendingIDATM2").hide();
								$(".holderNumberTicket2").hide();
							}
							$(".holderCancelNote").text($("#saveReasonCancel").val());
							$(".holderPendingNote").text($("#saveReasonPending").val());
						},
						complete: function(){
							$("#modal-next-pending").modal('toggle');
						}
					})
				}
			})
		}
	}

	function prepareCancelEmail() {
		if($("#saveReasonCancel").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill cancel reason!',
				'error'
			)
		} else {
			swalWithCustomClass.fire({
				title: 'Are you sure?',
				text: "Are you sure to cancel this ticket?",
				type: 'warning',
				showCancelButton: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url:"{{url('tisygy/mail/getCancelMailTemplate')}}",
						type:"GET",
						success: function (result){
							$("#bodyCancelMail").html(result);
						}
					})

					$.ajax({
						url:"{{url('tisygy/mail/getEmailData')}}",
						type:"GET",
						data:{
							id_ticket:$('#ticketID').val()
						},
						success: function (result){
							// Holder Cancel
							$(".holderCancelID").text($('#ticketID').val());
							$(".holderCancelRefrence").text(result.ticket_data.refrence);
							$(".holderCancelPIC").text(result.ticket_data.pic);
							$(".holderCancelContact").text(result.ticket_data.contact_pic);
							$(".holderCancelLocation").text(result.ticket_data.location);
							$(".holderCancelProblem").text(result.ticket_data.problem);
							$(".holderCancelSerial").text(result.ticket_data.serial_device);
							$(".holderCancelSeverity").text(result.ticket_data.severity_detail.id + " (" + result.ticket_data.severity_detail.name + ")")

							$(".holderCancelIDATM").text(result.ticket_data.id_atm);

							$(".holderCancelNote").text("");
							$(".holderCancelEngineer").text(result.ticket_data.engineer);

							var waktu = moment((result.ticket_data.first_activity_ticket.date), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");

							$(".holderCancelDate").text(waktu);

							$(".holderCancelStatus").html("<b>CANCEL</b>");
							$(".holderNumberTicket").text($("#ticketNumber").val());

							// Email Reciver
							$('.emailMultiSelector ').remove()
							$("#emailCancelTo").val(result.ticket_reciver.close_to)
							$("#emailCancelTo").emailinput({ onlyValidValue: true, delim: ';' });
							$("#emailCancelCc").val(result.ticket_reciver.close_cc)
							$("#emailCancelCc").emailinput({ onlyValidValue: true, delim: ';' });

							$("#emailCancelSubject").val("Cancel Tiket " + $(".holderCancelLocation").text() + " [" + $(".holderCancelProblem").text() +"]");
							$("#emailCancelHeader").html("Dear <b>" + result.ticket_reciver.close_dear + "</b><br>Berikut terlampir Cancel Tiket untuk Problem <b>" + $(".holderCancelLocation").text() + "</b> : ");
							$(".holderCancelCustomer").text(result.ticket_reciver.client_name);

							if(result.ticket_reciver.client_acronym  == "BJBR" || result.ticket_reciver.client_acronym  == "BSBB" || result.ticket_reciver.client_acronym  == "BRKR"){
								$(".holderCancelIDATM2").show();
								$(".holderNumberTicket2").show();
							} else {
								$(".holderCancelIDATM2").hide();
								$(".holderNumberTicket2").hide();
							}
							$(".holderCancelNote").text($("#saveReasonCancel").val());
						},
						complete: function(){
							$("#modal-next-cancel").modal('toggle');
						}
					})
				}
			})
		}
	}

	function sendCloseEmail(){
		var typeAlert = 'warning'
		var typeActivity = 'Close'
		var typeAjax = "GET"
		var urlAjax = "{{url('tisygy/mail/sendEmailClose')}}"
		var dataAjax = {
				id_ticket:$('#ticketID').val(),
				root_cause:$("#saveCloseRoute").val(),
				couter_measure:$("#saveCloseCouter").val(),
				finish:moment($("#dateClose").val(),'DD/MM/YYYY').format("YYYY-MM-DD") + " " + moment($("#timeClose").val(),'HH:mm:ss').format("HH:mm:ss.000000"),
				body:$("#bodyCloseMail").html(),
				subject: $("#emailCloseSubject").val(),
				to: $("#emailCloseTo").val(),
				cc: $("#emailCloseCc").val(),
			}

		swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,function(){
			$("#modal-next-close").modal('toggle');
			$("#modal-close").modal('toggle');
			$("#modal-ticket").modal('toggle');
		})
	}

	function sendPendingEmail(){
		var typeAlert = 'warning'
		var typeActivity = 'Pending'
		var typeAjax = "GET"
		var urlAjax = "{{url('tisygy/mail/sendEmailPending')}}"
		var dataAjax = {
				id_ticket:$('#ticketID').val(),
				subject: $("#emailPendingSubject").val(),
				to: $("#emailPendingTo").val(),
				cc: $("#emailPendingCc").val(),
				note_pending: $("#saveReasonPending").val(),
				body:$("#bodyPendingMail").html(),
			}

		swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,function(){
			$("#modal-next-pending").modal('toggle');
			$("#modal-pending").modal('toggle');
			$("#modal-ticket").modal('toggle');
		})
	}

	function sendCancelEmail(id){

		var typeAlert = 'warning'
		var typeActivity = 'Cancel'
		var typeAjax = "GET"
		var urlAjax = "{{url('tisygy/mail/sendEmailCancel')}}"
		var dataAjax = {
				id_ticket:$('#ticketID').val(),
				subject: $("#emailCancelSubject").val(),
				to: $("#emailCancelTo").val(),
				cc: $("#emailCancelCc").val(),
				note_cancel: $("#saveReasonCancel").val(),
				body:$("#bodyCancelMail").html(),
			}

		swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,function(){
			$("#modal-cancel").modal('toggle');
			$("#modal-next-cancel").modal('toggle');
			$("#modal-ticket").modal('toggle');
		})
	}

	function closeTicket(id){
		$("#saveCloseRoute").val('')
		$("#saveCloseCouter").val('')
		$('#modal-close').modal('toggle');
	}

	function pendingTicket(id){
		$("#saveReasonPending").val('')
		$('#modal-pending').modal('toggle');
	}

	function cancelTicket(id){
		$('#saveReasonCancel').val('')
		$('#modal-cancel').modal('toggle');
	}

	function updateTicket(id){
		// console.log(id);
		if($("#ticketNote").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'Please give you note before Update!',
				'error'
			)
		} else {
			swalWithCustomClass.fire({
				title: 'Are you sure?',
				text: "Are you sure to update this ticket?",
				type: 'warning',
				showCancelButton: true,
			}).then((result) => {
				$.ajax({
					type:"GET",
					url:"{{url('tisygy/setUpdateTicket')}}",
					data:{
						id_ticket:id,
						ticket_number_3party:$("#ticketNumber").val(),
						engineer:$("#ticketEngineer").val(),
						note:$("#ticketNote").val(),
					},
					success: function(result){
						$("#ticketActivity").prepend('<li>' + moment(result.date).format("DD MMMM - HH:mm") + ' [' + result.operator + '] - ' + result.note + '</li>');
						$("#ticketNote").val("")
						$("#ticketStatus").attr('class','label label-info');
						$("#ticketStatus").text('ON PROGRESS')
						$("#updateButton").prop('disabled',false);
						$("#closeButton").prop('disabled',false);
						$("#cancelButton").prop('disabled',false);
						$("#pendingButton").prop('disabled',false);
						$("#modal-ticket").modal('toggle')
						getPerformanceByClient(result.client_acronym_filter)
						swalWithCustomClass.fire(
							'Success',
							'Update Completed!',
							'success'
						)
					}
				});
			})
		}
	}

	var dataTicket = [];

	function getPerformanceAll(){
		if($.fn.dataTable.isDataTable("#tablePerformance")){
			$(".buttonFilter").removeClass('btn-primary').addClass('btn-default')
			$("#tablePerformance").DataTable().ajax.url('tisygy/getPerformanceAll').load();
		} else {
			$("#tablePerformance").DataTable({
				ajax:{
					type:"GET",
					url:"{{url('tisygy/getPerformanceAll')}}",
					dataSrc: function (json){
						json.data.forEach(function(data,idex){
							data.open_time = moment(data.first_activity_ticket.date,'YYYY-MM-DD, HH:mm:ss').format('D MMMM YYYY HH:mm')
							data.pic = data.pic + ' - ' + data.contact_pic
							if(data.lastest_activity_ticket.activity == "OPEN"){
								data.lastest_status_numerical = 1
								data.lastest_status = '<span class="label label-danger">' + data.lastest_activity_ticket.activity + '</span>'
							} else if(data.lastest_activity_ticket.activity == "ON PROGRESS") {
								data.lastest_status_numerical = 2
								data.lastest_status = '<span class="label label-info">' + data.lastest_activity_ticket.activity + '</span>'
							} else if(data.lastest_activity_ticket.activity == "PENDING") {
								data.lastest_status_numerical = 3
								data.lastest_status = '<span class="label label-warning">' + data.lastest_activity_ticket.activity + '</span>'
							} else if(data.lastest_activity_ticket.activity == "CANCEL") {
								data.lastest_status_numerical = 4
								data.lastest_status = '<span class="label bg-purple">' + data.lastest_activity_ticket.activity + '</span>'
							} else if(data.lastest_activity_ticket.activity == "CLOSE") {
								data.lastest_status_numerical = 5
								data.lastest_status = '<span class="label label-success">' + data.lastest_activity_ticket.activity + '</span>'
							} 
							data.lastest_operator = data.lastest_activity_ticket.operator
							data.action = '<button class="btn btn-default btn-flat btn-sm" onclick="showTicket(' + data.id_detail.id + ')">Detail</button>'
						})
						return json.data
					}
				},
				columns:[
					{
						data:'id_ticket',
						width:"12.5%"
					},
					{ 	
						data:'id_atm',
						className:'text-center',
						width:"5%"
					},
					{
						data:'ticket_number_3party',
						className:'text-center',
						width:"5%"
					},
					{ 
						data:'open_time',
						className:'text-center',
						width:"7%"
					},
					{
						data:'problem',
						// width:"25%"
					},
					{ 
						data:'pic',
						className:'text-center',
						width:"10%"
					},
					{
						data:'location',
						width:"12%"
					},
					{ 
						data:'lastest_status',
						className:'text-center',
						orderData:[ 10 ],
						width:"3%"
					},
					{ 
						data:'lastest_operator',
						className:'text-center',
						width:"3%"
					},
					{
						data:'action',
						className:'text-center',
						orderable: false,
						searchable: true,
						width:"3%"
					},
					{ 
						data: "lastest_status_numerical",
						targets: [ 7 ] ,
						visible: false ,
						searchable: true
					},
				],
				// order: [[10, "DESC" ]],
				autoWidth:false,
				lengthChange: false,
				searching:true,
				initComplete: function () {
					var condition_available = ["OPEN","ON PROGRESS","PENDING","CANCEL","CLOSE"]
					this.api().columns().every( function () {
						if(this.index() == 8){
							// console.log('every colom data')
							var column = this;
							var select = $('<select class="form-control"><option value="">Show All</option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column.search( val ? '^'+val+'$' : '', true, false ).draw();
								} );

							
							column.data().unique().each( function ( d, j ) {
								select.append( '<option value="' + d + '">' + d +'</option>' )
							})
						} else if (this.index() == 7){
							var column = this;
							var select = $('<select class="form-control"><option value="">Show All</option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									// console.log(val);
									column.search( val ? val : '', true, false ).draw();
								} );

							condition_available.forEach( function ( d, j ) {
								select.append( '<option value="' + d + '">' + d +'</option>' )
							})
						}
					})
				},
			})

		}
	}

	function getPerformanceByClient(client){
		$('#clientList').find(".buttonFilter" + client).removeClass('btn-default').addClass('btn-primary')
		$('#clientList').find(":not(.buttonFilter" + client + ")").removeClass('btn-primary').addClass('btn-default')
		$("#tablePerformance").DataTable().clear().draw();
		$("#tablePerformance").DataTable().ajax.url("{{url('tisygy/getPerformanceByClient?client=')}}" + client).load();
	}

	// $('#myTab a').click(function (e) {
	// 	e.preventDefault()
	// 	console.log(this);
	// 	$(this).tab('show')
	// });

	var severityFirst = 1; 

	function getSeverity(severity){
		$("#performance").click()
		$("#tablePerformance").DataTable().ajax.url('tisygy/getPerformanceBySeverity?severity=' + severity).load();
		// $.ajax({
		// 	type:"GET",
		// 	url:"{{url('tisygy/getPerformanceBySeverity')}}",
		// 	data:{
		// 		severity:severity
		// 	},
		// 	success:function(result){
				
		// 	},
		// });
	}

	function addRows(client){
		var url = "getPerformance2?client=" + client;
					
		$("#tablePerformance").DataTable().clear().draw();
		dataTicket = [];
		$.ajax({
			type:"GET",
			url:url,
			success:function(result){
				$.each(result, function(key,value){
					if((value.id_ticket).indexOf('/') == 3){
						var id_ticket = '0' + value.id_ticket;
					} else {
						var id_ticket =  value.id_ticket;
					}
					
					if(value.last_status[0] == "OPEN"){
						var status =  '<span class="label label-danger">' + value.last_status[0] + '</span>';
					} else if(value.last_status[0] == "ON PROGRESS") {
						var status =  '<span class="label label-info">' + value.last_status[0] + '</span>';
					} else if(value.last_status[0] == "PENDING") {
						var status =  '<span class="label label-warning">' + value.last_status[0] + '</span>';
					} else if(value.last_status[0] == "CLOSE") {
						var status =  '<span class="label label-success">' + value.last_status[0] + '</span>';
					} else if(value.last_status[0] == "CANCEL") {
						var status =  '<span class="label label-success" style="background-color:#555299 !important;">' + value.last_status[0] + '</span>';
					}

					var button = '<button class="btn btn-default" onclick="showTicket(' + value.id_open + ')">Detail</button>';
					dataTicket.push([
						id_ticket,
						value.id_atm,
						value.ticket_number_3party,
						moment(value.open).format('dddd, D MMMM YYYY HH:mm'),
						value.problem ,
						value.pic + ' - ' + value.contact_pic,
						value.location,
						status,
						value.operator,
						button
					]);

				});
			},
			complete: function(){
				$.each(dataTicket, function(key,value){
					$("#tablePerformance").DataTable().row.add([
						value[0],
						value[1],
						value[2],
						value[3],
						value[4],
						value[5],
						value[6],
						value[7],
						value[8],
						value[9]
					]).draw(false);
				});
			}
		});
	}

	function showTicket(id){
		$.ajax({
			type:"GET",
			url:"{{url('tisygy/getPerformanceByTicket')}}",
			data:{
				idTicket:id,
			},
			success: function(result){
				$("#updateButton").attr("onclick","updateTicket('" + result.id_ticket + "')");
				$("#cancelButton").attr("onclick","cancelTicket('" + result.id_ticket + "')");
				$("#pendingButton").attr("onclick","pendingTicket('" + result.id_ticket + "')");
				$("#closeButton").attr("onclick","closeTicket('" + result.id_ticket + "')");

				var severityType = "", severityClass = ""
				if(result.severity == 1){
					severityType = "Critical"
					severityClass = "label label-danger"
				} else if(result.severity == 2){
					severityType = "Major"
					severityClass = "label label-warning"
				} else if(result.severity == 3){
					severityType = "Moderate"
					severityClass = "label label-info"
				} else if(result.severity == 4){
					severityType = "Minor"
					severityClass = "label label-success"
				} else {
					severityType = "N/A"
					severityClass = "label label-default"
				}

				$('#ticketID').val(result.id_ticket);
				$("#modal-ticket-title").html("Ticket ID <b>" + result.id_ticket + "</b>");
				$("#ticketOperator").html(" latest by: <b>" + result.lastest_activity_ticket.operator + "</b>");
				$("#ticketSeverity").text(severityType);
				$("#ticketSeverity").attr('class',severityClass);
				$("#ticketOpen").text(moment(result.lastest_activity_ticket.date).format('D MMMM YYYY (HH:mm)'));
				$("#ticketStatus").text(result.lastest_activity_ticket.activity);
				$("#ticketStatus").attr('style','');

				$("#ticketIDATM").val(result.id_atm);
				$("#ticketSerial").val(result.serial_device);
				$("#ticketProblem").val(result.problem);
				$("#ticketPIC").val(result.pic + ' - ' + result.contact_pic);
				$("#ticketLocation").val(result.location);

				$("#ticketNote").val("");

				$("#ticketEngineer").val(result.engineer);
				$("#ticketNumber").val(result.ticket_number_3party);

				$("#ticketActivity").empty();
				$.each(result.all_activity_ticket,function(key,value){
					$("#ticketActivity").append('<li>' + moment(value.date).format("DD MMMM - HH:mm") + ' [' + value.operator + '] - ' + value.note + '</li>');
				});

				if(result.reporting_time != "Invalid date"){
					$("#ticketActivity").append('<li>Reporting time : ' + moment(result.reporting_time).format("DD MMMM - HH:mm") + ' </li>');
				} else {
					$("#ticketActivity").append('<li>Reporting time : ' + result.reporting_time + '</li>');
				}

				$(".holderCloseSeverity").text(result.severity + " (" + severityType + ")");
				$(".holderPendingSeverity").text(result.severity + " (" + severityType + ")");
				$(".holderCancelSeverity").text(result.severity + " (" + severityType + ")");

				$("#ticketNoteUpdate").show();

				$("#ticketCouter").hide();
				$("#ticketRoute").hide();

				if(result.lastest_activity_ticket.activity == "OPEN"){
					$("#ticketStatus").attr('class','label label-danger');
					
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',false);
				} else if(result.lastest_activity_ticket.activity == "PENDING") {
					$("#ticketStatus").attr('class','label label-warning');
					
					$("#pendingButton").prop('disabled',false);
					$("#closeButton").prop('disabled',false);
				} else if(result.lastest_activity_ticket.activity == "CLOSE"){
					$("#ticketStatus").attr('class','label label-success');
					
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',true);
					$("#cancelButton").prop('disabled',true);
					
					$("#ticketNoteUpdate").hide();
					$("#ticketCouter").show();
					$("#ticketRoute").show();
					$("#ticketCouterTxt").val(result.resolve.counter_measure);
					$("#ticketRouteTxt").val(result.resolve.root_couse);
				} else if(result.lastest_activity_ticket.activity == "ON PROGRESS"){
					$("#ticketStatus").attr('class','label label-info');
					
					$("#updateButton").prop('disabled',false);
					$("#closeButton").prop('disabled',false);
					$("#cancelButton").prop('disabled',false);
					$("#pendingButton").prop('disabled',false);
				} else if(result.lastest_activity_ticket.activity == "CANCEL"){
					$("#ticketStatus").attr('class','label label-purple');
					$("#ticketStatus").attr('style','background-color: #555299 !important;');
					$("#ticketNoteUpdate").hide();
					
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',true);
					$("#cancelButton").prop('disabled',true);
				}

				

				

				
				$('#modal-ticket').modal('toggle');
			}
		});
	}

	function saveClient(){
		$.ajax({
			type:"POST",
			url:"setSettingClient",
			data:{
				"_token": "{{ csrf_token() }}",
				id:$("#clientId").val(),
				client_name:$("#clientTitle").val(),
				client_acronym:$("#clientAcronym").val(),
				open_dear:$("#openDear").val(),
				open_to:$("#openTo").val(),
				open_cc:$("#openCc").val(),
				close_dear:$("#closeDear").val(),
				close_to:$("#closeTo").val(),
				close_cc:$("#closeCc").val(),
			},
			success : function(){
				$('#modal-setting').modal('toggle');
			}
		});
	}

	function editClient(id){
		$.ajax({
			type:"GET",
			url:"getSettingClient",
			data: {
				id:id,
			},
			success : function(result){
				$('#modal-setting').modal('toggle');
				$("#modal-setting-title").html("Change Setting for <b>" + result[0].client_name + "</b>");

				$("#clientId").val("");
				$("#clientTitle").val("");
				$("#clientAcronym").val("");
				$("#openDear").val("");
				$("#openTo").val("");
				$("#openCc").val("");
				$("#closeDear").val("");
				$("#closeTo").val("");

				$("#clientId").val(id);
				$("#clientTitle").val(result[0].client_name);
				$("#clientAcronym").val(result[0].client_acronym);
				
				$("#openDear").val(result[0].open_dear);
				$("#openTo").val(result[0].open_to);
				$("#openCc").val(result[0].open_cc);

				$("#closeDear").val(result[0].close_dear);
				$("#closeTo").val(result[0].close_to);
				$("#closeCc").val(result[0].close_cc);
				console.log(result);
			},
		});
		console.log(id);
	}

	$('#bodyOpenMail').slimScroll({
		height: '250px'
	});
	$('#bodyCloseMail').slimScroll({
		height: '250px'
	});

	function sendOpenEmail(){

		var typeAlert = 'warning'
		var typeActivity = 'Open'
		var typeAjax = "GET"
		var urlAjax = "{{url('tisygy/mail/sendEmailOpen')}}"
		var dataAjax = {
				body:$("#bodyOpenMail").html(),
				subject: $("#emailOpenSubject").val(),
				to: $("#emailOpenTo").val(),
				cc: $("#emailOpenCc").val(),
				attachment: $("#emailOpenAttachment").val(),
				id_ticket:$("#inputticket").val(),

				id:$("#inputID").val(),
				client:$("#inputClient").val(),

				id_atm:$("#inputATM").val(),
				refrence:$("#inputRefrence").val(),
				pic:$("#inputPIC").val(),
				contact_pic:$("#inputContact").val(),
				location:$("#inputLocation").val(),
				problem:$("#inputProblem").val(),
				serial_device:$("#inputSerial").val(),
				note:$("#inputNote").val(),
				report:moment($("#inputReportingDate").val(),'DD/MM/YYYY').format("YYYY-MM-DD") + " " + moment($("#inputReportingTime").val(),'HH:mm:ss').format("HH:mm:ss.000000"),
				severity:$("#inputSeverity").val()
			}

		swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,function(){
			$("#performance").click();
			// $("#modal-cancel").modal('toggle');
			// $("#modal-next-cancel").modal('toggle');
			// $("#modal-ticket").modal('toggle');
		})

		// if(confirm("Are you sure to send this ticket?")){
		// 	console.log("Yes");
		// 	var body = $("#bodyOpenMail").html();
			
		// 	$.ajax({
		// 		type:"GET",
		// 		url:"mailOpenTicket",
		// 		data:{
		// 			body:body,
		// 			subject: $("#emailOpenSubject").val(),
		// 			to: $("#emailOpenTo").val(),
		// 			cc: $("#emailOpenCc").val(),
		// 			attachment: $("#emailOpenAttachment").val()
		// 		},
		// 		success: function(result){
		// 			console.log("success");
		// 			alert('Email Has Been Sent!');
		// 			$("#performance").click();
		// 			// window.location('/tisygy');
		// 		},
		// 	});

		// }
	}

	function reserveIdTicket() {
		if("{Auth::check()}"){
			$.ajax({
				type:"GET",
				url:"{{url('tisygy/create/getReserveIdTicket')}}",
				success: function(result){
					$("#inputticket").val(result);
					$("#inputID").val(result);
					$("#inputDate").val(moment().format("DD-MMM-YY HH:mm"));
					
					$("#nomorDiv").show();
					$("#clientDiv").show();
					$("#formNewTicket").show();

					$("#createIdTicket").hide();
				},
			});
		} else {
			window.location('/login');
		}
	}

	function createEmailBody(){
		$("#sendTicket").show();
		$("#formNewTicket").hide();
		
		$.ajax({
			url:"{{url('tisygy/mail/getOpenMailTemplate')}}",
			type:"GET",
			success: function (result){
				$("#bodyOpenMail").html(result);
				$.ajax({
					type:"GET",
					url:"{{url('tisygy/mail/getEmailData')}}",
					data:{
						client:$("#inputClient").val()
					},
					success: function(result){
						$('.emailMultiSelector').remove()
						$("#emailOpenTo").val(result.open_to)
						$("#emailOpenTo").emailinput({ onlyValidValue: true, delim: ';' });
						$("#emailOpenCc").val(result.open_cc)
						$("#emailOpenCc").emailinput({ onlyValidValue: true, delim: ';' });
						
						$("#emailOpenSubject").val("Open Tiket " + $("#inputLocation").val() + " [" + $("#inputProblem").val() +"]");
						$("#emailOpenHeader").html("Dear <b>" + result.open_dear + "</b><br>Berikut terlampir Open Tiket untuk Problem <b>" + $("#inputLocation").val() + "</b> : ");
						$(".holderCustomer").text(result.client_name);
					}
				});

				if(!$("#inputATM").val()){
					$("#inputATM").val(" - ");
				} else {
					$(".holderIDATM2").show();
					$(".holderIDATM").text($("#inputATM").val());
				}

				if(!$("#inputSerial").val()){
					$("#inputSerial").val(" - ");
				}

				if(!$("#inputRefrence").val()){
					$("#inputRefrence").val(" - ");
				}

				if(!$("#inputNote").val()){
					$("#inputNote").val(" - ");
				}
				
				$("#locationProblem").text($("#inputLocation").val());

				var waktu = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("D MMMM YYYY");
				var waktu2 = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("HH:mm");

				$(".holderID").text($("#inputticket").val());
				
				$(".holderRefrence").text($("#inputRefrence").val());
				$(".holderPIC").text($("#inputPIC").val());
				$(".holderContact").text($("#inputContact").val());
				$(".holderLocation").text($("#inputLocation").val());
				$(".holderProblem").text($("#inputProblem").val());
				$(".holderSerial").text($("#inputSerial").val());
				$(".holderSeverity").text($("#inputSeverity").val());
				$(".holderNote").text($("#inputNote").val());
				
				$(".holderEngineer").text($("#inputEngineer").val());
				$(".holderDate").text(waktu);

				$(".holderStatus").html("<b>OPEN</b>");
				$(".holderWaktu").html("<b>" + waktu2 + "</b>");
			}
		})
	}

	// $("#inputPIC").change(function(){
	// 	if($(this).val() == ""){
	// 		$(this).closest('.form-group').addClass('has-error')
	// 	} else {
	// 		$(this).closest('.form-group').removeClass('has-error')
	// 	}
	// });

	// $("#inputContact").change(function(){
	// 	if($(this).val() == ""){
	// 		$(this).closest('.form-group').addClass('has-error')
	// 	} else {
	// 		$(this).closest('.form-group').removeClass('has-error')
	// 	}
	// });
	// $("#inputProblem").change(function(){
	// 	if($(this).val() == ""){
	// 		$(this).closest('.form-group').addClass('has-error')
	// 	} else {
	// 		$(this).closest('.form-group').removeClass('has-error')
	// 	}
	// });
	// $("#inputLocation").change(function(){
	// 	if($(this).val() == ""){
	// 		$(this).closest('.form-group').addClass('has-error')
	// 	} else {
	// 		$(this).closest('.form-group').removeClass('has-error')
	// 	}
	// });

	function createTicket(){
		$(".help-block").hide()
		if($("#inputPIC").val() == "" ){
			$("#picDiv").addClass('has-error')
			$("#picDiv .col-sm-10 .help-block").show()
		} else if($("#inputContact").val() == "" ){
			$("#contactDiv").addClass('has-error')
			$("#contactDiv .col-sm-10 .help-block").show()
		} else if($("#inputProblem").val() == "" ){
			$("#problemDiv").addClass('has-error')
			$("#problemDiv .col-sm-10 .help-block").show()
		} else if($("#inputATMid").is(':visible') && $("#inputATM").val() === "Select One"){
			$("#inputATMid").addClass('has-error')
			$("#inputATMid .col-sm-10 .help-block").show()
		} else if($("#inputLocation").val() == "" ){
			$("#locationDiv").addClass('has-error')
			$("#locationDiv .col-sm-10 .help-block").show()
		} else if($("#inputReportingTime").val() == "" ){
			$("#reportDiv").addClass('has-error')
			$("#reportDiv .col-sm-5.firstReport .help-block").show()

			$("#inputReportingDate").css("border-color",'#d2d6de')
			$("#reportDiv .col-sm-5.secondReport .input-group .input-group-addon").css("border-color",'#d2d6de')
			$("#reportDiv .col-sm-5.secondReport .input-group .input-group-addon i").css("color",'#555')
		} else if($("#inputReportingDate").val() == "" ){
			$("#reportDiv").addClass('has-error')
			$("#reportDiv .col-sm-5.secondReport .help-block").show()

			$("#inputReportingTime").css("border-color",'#d2d6de')
			$("#reportDiv .col-sm-5.firstReport .input-group .input-group-addon").css("border-color",'#d2d6de')
			$("#reportDiv .col-sm-5.firstReport .input-group .input-group-addon i").css("color",'#555')
		} else {
			$(".has-error").removeClass('has-error')
			var waktu = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("D MMMM YYYY");
			var waktu2 = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("HH:mm");

			$("#tableTicket").show();
			$("#holderID").text($("#inputticket").val());
			$("#holderRefrence").text($("#inputRefrence").val());
			$("#holderCustomer").text($("#inputClient").val());
			$("#holderPIC").text($("#inputPIC").val());
			$("#holderContact").text($("#inputContact").val());
			$("#holderProblem").text($("#inputProblem").val());
			$("#holderLocation").text($("#inputLocation").val());
			$("#holderEngineer").text($("#inputEngineer").val());
			$("#holderDate").text(waktu);
			$("#holderSerial").text($("#inputSerial").val());
			$("#holderSeverity").text($("#inputSeverity").val());
			// $("#holderRoot").text($("#inputticket").val();
			$("#holderNote").text($("#inputNote").val());
			$("#holderStatus").html("<b>OPEN</b>");
			$("#holderWaktu").html("<b>" + waktu2 + "</b>");

			if($("#inputClient").val() == "BJBR" || $("#inputClient").val() == "BSBB" || $("#inputClient").val() == "BRKR"){
				$("#holderIDATM2").show();
				$("#holderIDATM").text($("#inputATM").val());
			} else {
				$("#holderIDATM2").hide();
			}
			
		}


	}

	function getBankAtm(){
		if($("#inputClient").val() == "BJBR" || $("#inputClient").val() == "BSBB" || $("#inputClient").val() == "BRKR"){
			$.ajax({
				type:"GET",
				url:"{{url('tisygy/create/getAtmId')}}",
				data:{
					acronym:$("#inputClient").val(),
				},
				success: function(result){
					$("#inputATMid").show();
					$("#categoryDiv").show();
					if ($('#inputATM').hasClass("select2-hidden-accessible")) {
						$("#inputATM").select2('destroy');
					}
					result.unshift('Select One')
					// console.log(result);
					$("#inputATM").select2({
						data:result
					});
					$("#locationDiv .col-sm-2").text('Location')
				}
			});
		} else {
			$("#locationDiv .col-sm-2").text('Location*')
			$("#inputATM").val("");
			$("#inputSerial").val("");
			$("#inputLocation").val("");
			$("#inputATMid").hide();
		}
	}

	var firstTimeTicket = 0;

	$("#inputClient").change(function(){
		var acronym_client = this.value;
		if(firstTimeTicket == 0){
			$.ajax({
				type:"GET",
				url:"{{url('tisygy/create/setReserveIdTicket')}}",
				data:{
					id_ticket:$("#inputticket").val() + "/" + acronym_client + moment().format("/MMM/YYYY"),
					acronym_client:acronym_client,
					operator:"{{Auth::user()->nickname}}",
				},
				success: function(result){
					$("#inputticket").val($("#inputticket").val() + "/" + acronym_client + moment().format("/MMM/YYYY"));
				}
			});
		} else {
			var temp = $("#inputticket").val().split('/')
			temp[1] = acronym_client
			var changeResult = temp.join('/')

			$.ajax({
				type:"GET",
				url:"{{url('tisygy/create/putReserveIdTicket')}}",
				data:{
					id_ticket_before:$("#inputticket").val(),
					id_ticket_after:changeResult,
					acronym_client:acronym_client,
				},
				success: function(result){
					$("#inputticket").val(changeResult);
				}
			});
		}


		if($("#inputSeverity").val() != "Chose the severity"){
			getBankAtm();
		}

		firstTimeTicket = 1;
	});


	$("#inputSeverity").change(function(){
		$("#hrLine").show();
		$("#hrLine2").show();
		$("#refrenceDiv").show();
		$("#picDiv").show();
		$("#contactDiv").show();
		$("#problemDiv").show();
		$("#locationDiv").show();
		$("#dateDiv").show();
		$("#noteDiv").show();
		$("#serialDiv").show();
		$("#reportDiv").show();
		
		$("#createTicket").show();
		getBankAtm();
	});

</script>
@endsection
