@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')
@section('head')
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" >
	<!-- Bootstrap time Picker -->
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css')}}">
	<!-- daterange picker -->
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker.css')}}">
	<!-- Select2 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
	<style type="text/css">
		.table2 > tbody > tr > th, .table2 > tbody > tr > td {
			border-color: #141414;border: 1px solid;padding: 3px;}

		.vertical-alignment-helper {
			display:table;
			height: 100%;
			width: 100%;
			pointer-events:none; /* This makes sure that we can still click outside of the modal to close it */
		}
		.vertical-align-center {
			/* To center vertically */
			display: table-cell;
			vertical-align: middle;
			pointer-events:none;
		}
		.modal-content {
			/* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
			width:inherit;
			max-width:inherit; /* For Bootstrap 4 - to avoid the modal window stretching full width */
			height:inherit;
			/* To center horizontally */
			margin: 0 auto;
			pointer-events: all;
		}
		body { padding-right: 0 !important }
	</style>
@endsection
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<img src="img/tisygy.png" width="120" height="35">
			<small style="font-family: 'Montserrat', sans-serif;text-decoration: bold;">Ticketing System Sinergy</small>
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- START CUSTOM TABS -->

		<div class="row">
			<div class="col-md-12">
				<!-- Custom Tabs -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs" style="font-family: 'Montserrat', sans-serif;text-decoration: bold;">
						<li class="active"><a href="#tab_1" data-toggle="tab" onclick="getDashboard()">Dashboard</a></li>
						<li><a href="#tab_2" data-toggle="tab">Create</a></li>
						<li><a href="#tab_3" data-toggle="tab" id="performance" onclick="getPerformance()">Performance</a></li>
						<li><a href="#tab_4" data-toggle="tab">Management</a></li>
						<li><a href="#tab_5" data-toggle="tab">Tracking</a></li>
						<li><a href="#tab_6" data-toggle="tab">Setting</a></li>
						<!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<!-- Info boxes -->
							<div class="row">
								<section class="col-md-6">
									<div class="row">
										<div class="col-md-4">
											<div class="info-box">
												<span class="info-box-icon bg-red"><i class="ion ion-unlocked"></i></span>

												<div class="info-box-content">
													<span class="info-box-text">OPEN</span>
													<span class="info-box-number" id="countOpen"></span>
												</div>
												<!-- /.info-box-content -->
											</div>
											<!-- /.info-box -->
										</div>
										
										<div class="col-md-4">
											<div class="info-box">
												<span class="info-box-icon bg-aqua"><i class="ion ion-settings"></i></span>

												<div class="info-box-content">
													<span class="info-box-text">PROGRESS</span>
													<span class="info-box-number" id="countProgress"></span>
												</div>
												<!-- /.info-box-content -->
											</div>
											<!-- /.info-box -->
										</div>
										
										<div class="col-md-4">
											<div class="info-box">
												<span class="info-box-icon bg-yellow"><i class="ion ion-ios-stopwatch"></i></span>

												<div class="info-box-content">
													<span class="info-box-text">PENDING</span>
													<span class="info-box-number" id="countPending"></span>
												</div>
												<!-- /.info-box-content -->
											</div>
											<!-- /.info-box -->
										</div>
									</div>
											
									<div class="row">
										<div class="col-md-4">
											<div class="info-box">
												<span class="info-box-icon bg-purple"><i class="ion ion-close-round"></i></span>

												<div class="info-box-content">
													<span class="info-box-text">CANCEL</span>
													<span class="info-box-number" id="countCancel"></span>
												</div>
												<!-- /.info-box-content -->
											</div>
											<!-- /.info-box -->
										</div>

										<div class="col-md-4">
											<div class="info-box">
												<span class="info-box-icon bg-green"><i class="ion ion-android-checkbox-outline"></i></span>

												<div class="info-box-content">
													<span class="info-box-text">CLOSE</span>
													<span class="info-box-number" id="countClose"></span>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="info-box">
												<span class="info-box-icon bg-navy"><i class="ion ion-archive"></i></span>

												<div class="info-box-content">
													<span class="info-box-text">ALL</span>
													<span class="info-box-number" id="countAll"></span>
												</div>
											</div>
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
										<!-- <div class="col-md-4">
											<button class="btn btn-default">
												BSBB 56
											</button>
											<button class="btn btn-default">
												BSBB 56
											</button>
											<button class="btn btn-default">
												BSBB 56
											</button>
										</div> -->
									</div>
								</section>
								<!-- /.col -->
								
								<!-- /.col -->
							</div>
							<!-- /.row -->

							<hr>

							<div class="row">
								<div class="col-md-6">
									<div class="box box-danger">
										<div class="box-header with-border">
											<h3 class="box-title">Recent Ticket</h3>
										</div>
										<!-- /.box-header -->
										<div class="box-body no-padding">
											<table class="table table-striped">
												<tr>
													<th>ID</th>
													<th>Customer</th>
													<th>Problem</th>
													<th>Date</th>
													<th>Status</th>
												</tr>
											</table>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->
								</div>
								<!-- /.col -->
								<div class="col-md-6">
									<!-- LINE CHART -->
									<div class="box box-info">
										<div class="box-header with-border">
											<h3 class="box-title">Statistic</h3>

											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
												<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
											</div>
										</div>
										<div class="box-body">
											<div class="chart">
												<canvas id="areaChart" style="height:250px"></canvas>

											</div>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->

								</div>

								<div class="col-md-6">
									<!-- LINE CHART -->
									<div class="box box-info">
										
										<div class="box-body">
											<div class="chart">
												<div id="timeee"></div>
											</div>
										</div>
										<!-- /.box-body -->
									</div>
									<!-- /.box -->

								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->

						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_2">
							<i class="btn btn-info" id="createIdTicket" onclick="reserveIdTicket()">Reserve ID Ticket</i>
							<div class="row" id="makeTicket">
								<div class="col-md-8">
									<form class="form-horizontal" action="{{url('/atisygy')}}" method="post">
										<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
										<input type="hidden" id="inputID">
										<div class="form-group" id="nomorDiv" style="display: none;">
											<label for="inputNomor" class="col-sm-2 control-label" >Nomor Ticket</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputticket" value="" readonly>
											</div>
										</div>
										<div class="form-group" id="clinetDiv" style="display: none;">
											<label for="inputCreator" class="col-sm-2 control-label">Client</label>
											<div class="col-sm-10">
												<select class="form-control" id="inputClient">
													<option selected="selected">Chose the client</option>
													@foreach($clients as $client)
														<option>{{$client->client_acronym}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group" id="refrenceDIV" style="display: none;">
											<label for="inputDescription" class="col-sm-2 control-label">Refrence</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputRefrence" placeholder=""></div>
										</div>
										<div class="form-group" id="picDiv" style="display: none;">
											<label for="inputDescription" class="col-sm-2 control-label">PIC</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputPIC" placeholder="" required></div>
										</div>
										<div class="form-group" id="contactDiv" style="display: none;">
											<label for="inputDescription" class="col-sm-2 control-label">Contact PIC</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputContact" placeholder="" required></div>
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
											<label for="inputEmail" class="col-sm-2 control-label">Problem</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputProblem" placeholder="" required></div>
										</div>
										<div class="form-group" id="inputATMid" style="display: none;">
											<label for="inputEmail" class="col-sm-2 control-label">ID ATM</label>
											<div class="col-sm-10">
												<select class="form-control select2" id="inputATM" style="width: 100%" required>
													<!-- <option>California</option>
													<option>Delaware</option>
													<option>Tennessee</option>
													<option>Texas</option>
													<option>Washington</option> -->
												</select>
												<!-- <input type="text" class="form-control" id="inputATM" placeholder=""> -->
											</div>
										</div>
										<div class="form-group" id="locationDiv" style="display: none;">
											<label for="inputEmail" class="col-sm-2 control-label">Location</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputLocation" placeholder="" required></div>
										</div>
										<div class="form-group" id="serialDiv" style="display: none;">
											<label for="inputEmail" class="col-sm-2 control-label">Serial Number</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputSerial" placeholder=""></div>
										</div>
										<div class="form-group" id="reportDiv" style="display: none;">
											<label for="inputEmail" class="col-sm-2 control-label">Report Time</label>
											<div class="col-sm-5">
												<div class="input-group">
													<input type="text" class="form-control timepicker" id="inputReport1">

													<div class="input-group-addon">
														<i class="fa fa-clock-o"></i>
													</div>
												</div>
											</div>
											<div class="col-sm-5">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control pull-right" id="inputReport2">
												</div>
												<!-- <input type="text" class="form-control" id="inputReport" placeholder=""> -->
											</div>
										</div>
										<div class="form-group" id="dateDiv" style="display: none;">
											<label for="inputEmail" class="col-sm-2 control-label">Date</label>
											<div class="col-sm-10">

												<input type="text" class="form-control" id="inputDate" placeholder="" disabled></div>
										</div>
										<div class="form-group" id="noteDiv" style="display: none;">
											<label for="inputEmail" class="col-sm-2 control-label">Note Update</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="inputNote" placeholder=""></div>
										</div>
									</form>
									<i class="btn btn-info pull-right" id="createTicket"  style="display: none;" onclick="createTicket()">Create Ticket</i>
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
										<!-- <tr>
											<th class="bg-primary">Engineer</th>
											<td id="holderEngineer"></td>
										</tr> -->
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
										<!-- <tr>
											<th class="bg-primary">Counter Measure</th>
											<td id="holderCounter"></td>
										</tr>
										<tr>
											<th class="bg-primary">Rootcause</th>
											<td id="holderRoot"></td>
										</tr> -->
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
									<i class="btn btn-info pull-right" id="createEmailBody" onclick="createEmailBody()">Create Email</i>
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
													@include('mailOpenTicket')
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<div class="pull-right">
													<div class="btn btn-default btn-file">
														<i class="fa fa-paperclip"></i> Attachment
														<input type="file" name="attachment" id="emailOpenAttachment">
													</div>
													<button class="btn btn-primary" onclick="sendOpenTicketBtn()"><i class="fa fa-envelope-o"></i> Send</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane table-responsive no-padding" id="tab_3">
							<button class="btn btn-default" onclick="getPerformance('TTNI')">TTNI</button>
							<button class="btn btn-default" onclick="getPerformance('SMPO')">SMPO</button>
							<button class="btn btn-default" onclick="getPerformance('BSBB')">BSBB</button>
							<button class="btn btn-default" onclick="getPerformance('BRKR')">BRKR</button>
							<button class="btn btn-default" onclick="getPerformance('BJBR')">BJBR</button>
							<button class="btn btn-default" onclick="getPerformance('BAF')">BAF</button>
							<!-- <div class=" pull-right input-group input-group-sm" style="width:  150px;">
								
								<input style="width: 200px" name="table_search" class="form-control pull-right" id="myInput" onkeyup="myFunction()" type="text" placeholder="Search for ID Ticket" title="Type in a ID Ticket">
								<div style="padding-right: 10px;" class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
								<input style="width: 200px" name="table_search" class="form-control pull-right" id="myInput2" onkeyup="myFunction2()" type="text" placeholder="Search for ID Atm" title="Type in a ID Atm">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div> -->
							<hr>
							<br>
							<table class="table table-bordered table-striped" id="tablePerformace">
							</table>

							<div class="modal fade" id="modal-ticket">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span></button>
											
											<h4 class="modal-title" id="modal-ticket-title">Ticket ID </h4>
											<div class="modal-tools pull-right">
												<span id="ticketOpen">6 March 2018 (08:45)</span> 
												<span class="label label-default" id="ticketStatus" onclick="modalStatus()"></span>
											</div>
											<span id="ticketOperator"></span>
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
														<li>09:00 - Open Ticket</li>
														<li>09:05 - Update Nomor Ticket</li>
														<li>09:10 - Engineer telah di contact dan sekarang menuju ke lokasi</li>
														<li>09:20 - Engineer telah sampai di lokasi</li>
														<li>09:25 - Engineer berkoordinasi dengan PIC di tempat</li>
														<li>09:50 - Engineer sedang merepleace pert yang rusak</li>
														<li>10:00 - Engineer mengetest perangkat bersama PIC</li>
														<li>10:05 - PIC ok</li>
														<li>10:10 - Close Ticket</li>
													</ul>
												</div>
												<div class="form-group">
													<label>Note Activity*</label>
													<textarea class="form-control" rows="1" id="ticketNote"></textarea>
												</div>
											</form>
										</div>
										<div class="modal-footer">
											<!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
											<button type="button" class="btn btn-success" onclick="closeTicket()" id="closeButton">Close</button>
											<button type="button" class="btn btn-warning" onclick="pendingTicket()" id="pendingButton">Pending</button>
											<button type="button" class="btn btn-default" onclick="cencelTicket()" id="cancelButton">Cancel</button>
											<button type="button" class="btn btn-primary" onclick="updateTicket()" id="updateButton">Update</button>
										</div>
									</div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
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
													<!-- time Picker -->
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
																	<!-- /.input group -->
																</div>
																<!-- /.form group -->
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
																<!-- /.input group -->
															</div>
														</div>
													</div>
												</form>
											</div>
											<div class="modal-footer">
												<!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
												<button type="button" class="btn btn-success " id="saveCloseButton">Close</button>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
							</div>

							<div class="modal fade" id="modal-next-close">
									
								{!! csrf_field() !!}
								<div class="vertical-alignment-helper">
									<div class="modal-dialog vertical-align-center modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span></button>
												
												<h4 class="modal-title" id="modal-ticket-title">Send Close Ticket </h4>
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
																@include('mailCloseTicket')
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
												<!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
												<!-- <form enctype="multipart/form-data" action="attachmentCloseTicket" method="POST" id="formClose"> -->
													<div class="btn btn-default btn-file">
														<i class="fa fa-paperclip"></i> Attachment
														<input type="file" name="attachment" id="emailCloseAttachment">
													</div>
												<!-- </form> -->
												<i class="btn btn-primary" onclick="sendCloseTicketBtn(1)"><i class="fa fa-envelope-o"></i> Send</i>
												<!-- <button type="button" class="btn btn-success " id="saveCloseButton">Close</button> -->
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
							</div>

							<div class="modal fade" id="modal-pending">
								<div class="vertical-alignment-helper">
									<div class="modal-dialog vertical-align-center">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span></button>
												
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
												<!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
												<button type="button" class="btn btn-warning " id="savePendingButton">Panding</button>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
							</div>

							<div class="modal fade" id="modal-next-pending">
									
								{!! csrf_field() !!}
								<div class="vertical-alignment-helper">
									<div class="modal-dialog vertical-align-center modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span></button>
												
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
																@include('mailPendingTicket')
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
												<!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
												<!-- <form enctype="multipart/form-data" action="attachmentCloseTicket" method="POST" id="formClose"> -->
													<div class="btn btn-default btn-file">
														<i class="fa fa-paperclip"></i> Attachment
														<input type="file" name="attachment" id="emailPendingAttachment">
													</div>
												<!-- </form> -->
												<i class="btn btn-primary" onclick="sendPendingTicketBtn(1)"><i class="fa fa-envelope-o"></i> Send</i>
												<!-- <button type="button" class="btn btn-success " id="saveCloseButton">Close</button> -->
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
							</div>

							<div class="modal fade" id="modal-cancel">
								<div class="vertical-alignment-helper">
									<div class="modal-dialog vertical-align-center">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span></button>
												
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
												<!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
												<button type="button" class="btn btn-default " id="saveCancelButton">Cancel</button>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
							</div>

							<div class="modal fade" id="modal-next-cancel">
									
								{!! csrf_field() !!}
								<div class="vertical-alignment-helper">
									<div class="modal-dialog vertical-align-center modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span></button>
												
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
																@include('mailCancelTicket')
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
												<!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
												<!-- <form enctype="multipart/form-data" action="attachmentCloseTicket" method="POST" id="formClose"> -->
													<div class="btn btn-default btn-file">
														<i class="fa fa-paperclip"></i> Attachment
														<input type="file" name="attachment" id="emailCancelAttachment">
													</div>
												<!-- </form> -->
												<i class="btn btn-primary" onclick="sendCancelTicketBtn(1)"><i class="fa fa-envelope-o"></i> Send</i>
												<!-- <button type="button" class="btn btn-success " id="saveCloseButton">Close</button> -->
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
							</div>
							<!-- /.modal -->

						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_4">
							Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
							when an unknown printer took a galley of type and scrambled it to make a type specimen book.
							It has survived not only five centuries, but also the leap into electronic typesetting,
							remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
							sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
							like Aldus PageMaker including versions of Lorem Ipsum.
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_5">
							Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
							when an unknown printer took a galley of type and scrambled it to make a type specimen book.
							It has survived not only five centuries, but also the leap into electronic typesetting,
							remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
							sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
							like Aldus PageMaker including versions of Lorem Ipsum.
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane table-responsive no-padding" id="tab_6">
							<button class="btn btn-default" onclick="emailSetting()">
								Email Setting
							</button>
							<button class="btn btn-default" onclick="atmSetting()">
								ATM Setting
							</button>
							<button class="btn btn-primary" onclick="atmAdd()" style="display: none" id="addAtm">
								Add ATM
							</button>
							<br>
						

							<table class="table table-striped" style="display: none;" id="emailSetting">
								<tr>
									<th style="width: 200px;vertical-align: middle;text-align: center;" rowspan="2" >Client</th>
									<th rowspan="2" style="vertical-align: middle;text-align: center;">Acronym</th>
									<th colspan="3" style="vertical-align: middle;text-align: center;">Open</th>
									<th colspan="3" style="vertical-align: middle;text-align: center;">Close</th>
									<th rowspan="2" style="vertical-align: middle;text-align: center;">#</th>
								</tr>
								<tr>
									<th style="vertical-align: middle;text-align: center;">Dear</th>
									<th style="vertical-align: middle;text-align: center;">To</th>
									<th style="vertical-align: middle;text-align: center;">Cc</th>
									<th style="vertical-align: middle;text-align: center;">Dear</th>
									<th style="vertical-align: middle;text-align: center;">To</th>
									<th style="vertical-align: middle;text-align: center;">Cc</th>
								</tr>
								@foreach($clients as $client)
								<tr>
									<td style="width: 200px;vertical-align: middle;text-align: center;" >{{$client->client_name}}</td>
									<td style="vertical-align: middle;text-align: center;">{{$client->client_acronym}}</td>
									<td style="vertical-align: middle;text-align: center;">{{$client->open_dear}}</td>
									<td>{!! $client->open_to !!}</td>
									<td>{!! $client->open_cc !!}</td>
									<td style="vertical-align: middle;text-align: center;">{{ $client->close_dear }}</td>
									<td>{!! $client->close_to !!}</td>
									<td>{!! $client->close_cc !!}</td>

									<td style="vertical-align: middle;text-align: center;"><button type="button" class="btn btn-block btn-default" onclick="editClient({{$client->id}})">Edit</button></td>
								</tr>
								@endforeach
							</table>
							<div style="display: none" id="atmSetting">
								<table class="table table-striped" id="atmTable">
									<thead>
										<tr>
											<th style="width: 200px;vertical-align: middle;text-align: center;">Owner</th>
											<th style="vertical-align: middle;text-align: center;">ATM ID</th>
											<th style="vertical-align: middle;text-align: center;">Serial Number</th>
											<th style="vertical-align: middle;text-align: center;">Location</th>
											<th conspan="2" style="vertical-align: middle;text-align: center;"></th>
										</tr>
									</thead>
									<tbody>
									@foreach($atms as $atm)
										<tr>
											<td style="width: 200px;vertical-align: middle;text-align: center;" >{{$atm->owner}}</td>
											<td style="vertical-align: middle;text-align: center;">{{$atm->atm_id}}</td>
											<td style="vertical-align: middle;text-align: center;">{{$atm->serial_number}}</td>
											<td style="vertical-align: middle;text-align: center;">{{$atm->location }}</td>
											<td style="vertical-align: middle;text-align: center;"><button type="button" class="btn btn-block btn-default" onclick="editAtm('{{$atm->id}}')">Edit</button></td>
										</tr>
									@endforeach
									</tbody>
								</table>
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
															<textarea class="form-control" rows="3" id="closeCc">asdfasdfasd&#13;&#10;adfasdfasd&#13;&#10;asdfasdfas</textarea>
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
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<div class="modal fade" id="modal-setting-atm">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span></button>
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
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<div class="modal fade" id="modal-setting-atm-add">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span></button>
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
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- nav-tabs-custom -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<!-- END CUSTOM TABS -->

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Version</b> 2.4.0
	</div>
	<strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
	reserved.
</footer>
@endsection 
@section('script')
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.5/Chart.bundle.min.js"></script>
<script src="https://raw.githubusercontent.com/bassjobsen/Bootstrap-3-Typeahead/master/bootstrap3-typeahead.min.js"></script>
<script>

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

	getDashboard();

	function getDashboard(){
		$.ajax({
			type:"GET",
			url:"getDashboard",
			success:function(result){
				console.log(result);
				$("#countOpen").text(result[0][0]);
				$("#countProgress").text(result[0][1]);
				$("#countPending").text(result[0][2]);
				$("#countClose").text(result[0][3]);
				$("#countCancel").text(result[0][4]);
				$("#countAll").text(result[0][5]);

				var config = {
					type: 'doughnut',
					data: {
						labels: result[1],
						datasets: [{
							data: result[2],
							backgroundColor: [
							  "#2ecc71",
							  "#e67e22",
							  "#c0392b",
							  "#3498db",
							  "#8e44ad"
							],
							hoverBackgroundColor: [
							  "#2ecc71",
							  "#e67e22",
							  "#c0392b",
							  "#3498db",
							  "#8e44ad"
							]
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
						text: "90%"
					}
				};

				var ctx = document.getElementById("pieChart").getContext("2d");
				window.myDoughnut = new Chart(ctx, config);

			}
		});
	}

	// var ctx = document.getElementById("pieChart").getContext("2d");
	// var myChart = new Chart(ctx, config);

	// var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
	// var pieChart = new Chart(pieChartCanvas);
	// var PieData = [
	//  {
	//      value: 700,
	//      color: "#f56954",
	//      highlight: "#f56954",
	//      label: "Chrome"
	//  },
	//  {
	//      value: 500,
	//      color: "#00a65a",
	//      highlight: "#00a65a",
	//      label: "IE"
	//  },
	//  {
	//      value: 400,
	//      color: "#f39c12",
	//      highlight: "#f39c12",
	//      label: "FireFox"
	//  },
	//  {
	//      value: 600,
	//      color: "#00c0ef",
	//      highlight: "#00c0ef",
	//      label: "Safari"
	//  },
	//  {
	//      value: 300,
	//      color: "#3c8dbc",
	//      highlight: "#3c8dbc",
	//      label: "Opera"
	//  },
	//  {
	//      value: 100,
	//      color: "#d2d6de",
	//      highlight: "#d2d6de",
	//      label: "Navigator"
	//  }
	// ];
	// var pieOptions = {
	//  //Boolean - Whether we should show a stroke on each segment
	//  segmentShowStroke: true,
	//  //String - The colour of each segment stroke
	//  segmentStrokeColor: "#fff",
	//  //Number - The width of each segment stroke
	//  segmentStrokeWidth: 2,
	//  //Number - The percentage of the chart that we cut out of the middle
	//  percentageInnerCutout: 50, // This is 0 for Pie charts
	//  //Number - Amount of animation steps
	//  animationSteps: 100,
	//  //String - Animation easing effect
	//  animationEasing: "easeOutBounce",
	//  //Boolean - Whether we animate the rotation of the Doughnut
	//  animateRotate: true,
	//  //Boolean - Whether we animate scaling the Doughnut from the centre
	//  animateScale: false,
	//  //Boolean - whether to make the chart responsive to window resizing
	//  responsive: true,
	//  // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	//  maintainAspectRatio: true,
	//  //String - A legend template
	//  legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
	// };
	// //Create pie or douhnut chart
	// // You can switch between pie and douhnut using the method below.
	// pieChart.Doughnut(PieData, pieOptions);

	$('#atmTable').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false
	});

	$("#inputReport1").timepicker({
		showInputs: false,
		minuteStep: 1,
		maxHours: 24,
		showMeridian: false,
		showSeconds:true,
	});

	$('#inputReport2').datepicker({
		autoclose: true
	});

	function newAtm(){
		$.ajax({
			type:"GET",
			url:"newAtm",
			data:{
				// idAtm:$("#idAtm").val(),
				atmOwner:$("#atmOwner2").val(),
				atmID:$("#atmID2").val(),
				atmSerial:$("#atmSerial2").val(),
				atmLocation:$("#atmLocation2").val(),
			},
			success: function (){
				$("#modal-setting-atm-add").modal('toggle');
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
		$("#emailSetting").show();
		$("#atmSetting").hide();
		$("#addAtm").hide();
	}
	function atmSetting(){
		$("#atmSetting").show();
		$("#emailSetting").hide();
		$("#addAtm").show();
	}

	$("#inputATM").select2({
		minimumInputLength: 2,
		tags: [],
		ajax: {
			url: 'getAtm',
			dataType: 'json',
			type: "GET",
			quietMillis: 50,
			data: function (term) {
				return {
					term: term
				};
			},
			results: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.completeName,
							slug: item.slug,
							id: item.id
						}
					})
				};
			}
		}
	});

	function myFunction() {
		var input, filter, table, tr, td, i;
		input = document.getElementById("myInput");
		filter = input.value.toUpperCase();
		table = document.getElementById("tablePerformace");
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
		table = document.getElementById("tablePerformace");
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

	// $('#example2').DataTable();

	

	$("#inputATM").change(function(){
		$.ajax({
			type:"GET",
			url:"getDetailAtm2/" + this.value,
			success: function(result){
				console.log(result[0].serial_number);
				// result[0].location
				$("#inputLocation").val(result[0].location);
				$("#inputSerial").val(result[0].serial_number);
			}
		});
	});
	$(".sidebar-toggle").click();
	//Timepicker
	$(".timepicker").timepicker({
		showInputs: false,
		minuteStep: 1,
		maxHours: 24,
		showMeridian: false,
		showSeconds:true,
	});

	

	$('#dateClose').datepicker({
		autoclose: true
	});

	$("#saveCloseButton").on("click",{
			id_ticket:$('#ticketID').val(),
		},function(event){
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
					// console.log();
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

	$("#savePendingButton").on("click",{
			id_ticket:$('#ticketID').val(),
		},function(){
			if($("#saveReasonPending").val() == ""){
				alert('You must fill pending reason!');
			} else {
				if(confirm("Are you sure to pending this ticket?")){
					console.log("yes");
					
					$("#modal-next-pending").modal('toggle');

					$.ajax({
						type:"GET",
						url:"getEmailReciver",
						data:{
							id_ticket:$('#ticketID').val(),
						},
						success: function (result){
							$("#emailPendingTo").val(result[0].close_to);
							$("#emailPendingCc").val(result[0].close_cc);
							$("#emailPendingSubject").val("Pending Tiket " + $(".holderPendingLocation").text() + " [" + $(".holderPendingProblem").text() +"]");
							$("#emailPendingHeader").html("Dear <b>" + result[0].close_dear + "</b><br>Berikut terlampir Pending Tiket untuk Problem <b>" + $(".holderPendingLocation").text() + "</b> : ");
							$(".holderPendingCustomer").text(result[0].client_name);

							if(result[0].client_acronym  == "BJBR" || result[0].client_acronym  == "BSBB" || result[0].client_acronym  == "BRKR"){
								$(".holderPendingIDATM2").show();
								$(".holderNumberTicket2").show();
							} else {
								$(".holderPendingIDATM2").hide();
								$(".holderNumberTicket2").hide();
							}

							console.log(result[0]);
						}
					})

					$(".holderPendingNote").text($("#saveReasonPending").val());

					// $.ajax({
					//  type:"get",
					//  url:"pendingTicket",
					//  data:{
					//      reason:$("#saveReasonPending").val(),
					//  },
					//  success:function(){
					//      $('#modal-pending').modal('toggle');
					//      $('#modal-ticket').modal('toggle');
					//  }
					// });
					
				} else {
					console.log("no");
				}
			}
		}
	);

	$("#saveCancelButton").on("click",function(){
		if($("#saveReasonCancel").val() == ""){
			alert('You must fill cancel reason!');
		} else {
			if(confirm("Are you sure to cancel this ticket?")){
				console.log("yes");

				$("#modal-next-cancel").modal('toggle');

				$.ajax({
					type:"GET",
					url:"getEmailReciver",
					data:{
						id_ticket:$('#ticketID').val(),
					},
					success: function (result){
						$("#emailCancelTo").val(result[0].close_to);
						$("#emailCancelCc").val(result[0].close_cc);
						$("#emailCancelSubject").val("Cancel Tiket " + $(".holderCancelLocation").text() + " [" + $(".holderCancelProblem").text() +"]");
						$("#emailCancelHeader").html("Dear <b>" + result[0].close_dear + "</b><br>Berikut terlampir Cancel Tiket untuk Problem <b>" + $(".holderCancelLocation").text() + "</b> : ");
						$(".holderCancelCustomer").text(result[0].client_name);

						if(result[0].client_acronym  == "BJBR" || result[0].client_acronym  == "BSBB" || result[0].client_acronym  == "BRKR"){
							$(".holderCancelIDATM2").show();
							$(".holderNumberTicket2").show();
						} else {
							$(".holderCancelIDATM2").hide();
							$(".holderNumberTicket2").hide();
						}

						console.log(result[0]);
					}
				})

				$(".holderCancelNote").text($("#saveCancelPending").val());

				// $.ajax({
				//  type:"get",
				//  url:"cancelTicket",
				//  data:{
				//      reason:$("#cancelReasonPending").val(),
				//  },
				//  success:function(){
				//      $('#modal-pending').modal('toggle');
				//      $('#modal-ticket').modal('toggle');
				//  }
				// });
			} else {
				console.log("no");
			}
		}
	});

	function modalStatus(id){
		console.log(id);
	}

	function closeTicket(id){
		$('#modal-close').modal('toggle');
		// $('#modal-ticket').modal('toggle');a
	}

	function sendCloseTicketBtn(id){
		var body = $("#bodyCloseMail").html();
		//2018-03-16 06:33:57.000000
		var finish_time = moment($("#timeClose").val() + " " + $("#dateClose").val()).format("YYYY-MM-DD HH:mm:ss.000000");

		$.ajax({
			type:"GET",
			url:"closeTicket",
			data:{
				id_ticket:$('#ticketID').val(),
				root_cause:$("#saveCloseRoute").val(),
				couter_measure:$("#saveCloseCouter").val(),
				finish:finish_time,
				body:body,
				subject: $("#emailCloseSubject").val(),
				to: $("#emailCloseTo").val(),
				cc: $("#emailCloseCc").val(),
				attachment: $("#emailCloseAttachment").val()
			},
			success: function (result){
				alert('Close email has been sent');
				$("#modal-close").modal('toggle');
				$("#modal-next-close").modal('toggle');
				$("#modal-ticket").modal('toggle');
				$("#performance").click();
			},
		});
		if($("#emailCloseAttachment").val() != ""){
			$("#formClose").submit();
		}
	}

	function sendPendingTicketBtn(id){
		var body = $("#bodyPendingMail").html();
		//2018-03-16 06:33:57.000000
		var finish_time = moment($("#timeClose").val() + " " + $("#dateClose").val()).format("YYYY-MM-DD HH:mm:ss.000000");

		$.ajax({
			type:"GET",
			url:"pendingTicket",
			data:{
				id_ticket:$('#ticketID').val(),
				// root_cause:$("#saveCloseRoute").val(),
				// couter_measure:$("#saveCloseCouter").val(),
				// finish:finish_time,
				body:body,
				subject: $("#emailPendingSubject").val(),
				to: $("#emailPendingTo").val(),
				cc: $("#emailPendingCc").val(),
				attachment: $("#emailPendingAttachment").val()
			},
			success: function (result){
				alert('Pending email has been esnt');
				$("#modal-pending").modal('toggle');
				$("#modal-next-pending").modal('toggle');
				$("#modal-ticket").modal('toggle');
				$("#performance").click();
			},
		});
		if($("#emailPendingAttachment").val() != ""){
			$("#formPending").submit();
		}
	}

	function sendCancelTicketBtn(id){
		var body = $("#bodyCancelMail").html();
		//2018-03-16 06:33:57.000000
		var finish_time = moment($("#timeClose").val() + " " + $("#dateClose").val()).format("YYYY-MM-DD HH:mm:ss.000000");

		$.ajax({
			type:"GET",
			url:"cancelTicket",
			data:{
				id_ticket:$('#ticketID').val(),
				// root_cause:$("#saveCloseRoute").val(),
				// couter_measure:$("#saveCloseCouter").val(),
				// finish:finish_time,
				body:body,
				subject: $("#emailCancelSubject").val(),
				to: $("#emailCancelTo").val(),
				cc: $("#emailCancelCc").val(),
				attachment: $("#emailCancelAttachment").val()
			},
			success: function (result){
				alert('Cancel email has been sent');
				$("#modal-cancel").modal('toggle');
				$("#modal-next-cancel").modal('toggle');
				$("#modal-ticket").modal('toggle');
				$("#performance").click();
			},
		});
		if($("#emailPendingAttachment").val() != ""){
			$("#formPending").submit();
		}
	}

	function pendingTicket(id){
		$('#modal-pending').modal('toggle');
	}

	function savePending(id){

	}

	function cancelTicket(id){
		$('#modal-cancel').modal('toggle');
	}

	function saveCancel(id){

	}

	function updateTicket(id){
		console.log(id);
		if($("#ticketNote").val() == ""){
			alert("Please give you note!");
		} else {
			if(confirm("Are you sure to update this ticket?")){
				$.ajax({
					type:"GET",
					url:"updateTicket",
					data:{
						id_ticket:id,
						ticket_number_3party:$("#ticketNumber").val(),
						engineer:$("#ticketEngineer").val(),
						note:$("#ticketNote").val(),
					},
					success: function(result){
						$("#ticketNumber").val("");
						$("#ticketEngineer").val("");
						$('#modal-ticket').modal('toggle');
						$('#performance').click();
					}
				});
			}
		}
	}

	function getPerformance(client = ""){
		$("#tablePerformace").empty();
		$("#myInput2").val("");
		$("#myInput").val("");
		var heading = "";
		heading = heading + '<thead>';
			heading = heading + '<tr>';
				heading = heading + '<th style="width: 150px;vertical-align: middle;">ID Ticket</th>';
				heading = heading + '<th style="text-align:center;width: 50px">ID ATM*</th>';
				heading = heading + '<th style="text-align:center;width: 100px">Ticket Number</th>';
				// heading = heading + '<th style="width: 100px">Number Tiket</th>';
				heading = heading + '<th style="text-align:center;width: 100px;vertical-align: middle;">Open</th>';
				heading = heading + '<th style="vertical-align: middle;">Problem</th>';
				heading = heading + '<th style="width: 40px;vertical-align: middle;">PIC</th>';
				heading = heading + '<th style="width: 100px;vertical-align: middle;">Location</th>';
				heading = heading + '<th style="width: 40px;vertical-align: middle;">Status</th>';
				heading = heading + '<th style="width: 40px;vertical-align: middle;">Operator</th>';
				heading = heading + '<th style="width: 40px;vertical-align: middle;"></th>';
			heading = heading + '</tr>';
		heading = heading + '</thead>';
		heading = heading + '<tbody>';

		$("#tablePerformace").append(heading);
		if(client != ""){
			var url = "getPerformance2?client=" + client;
			$("#tablePerformace").DataTable();
		} else {
			var url = "getPerformance2?client=all";
		}
		$.ajax({
			type:"GET",
			url:url,
			success:function(result){
				var body = "";
				// console.log(result[0]);

				$.each(result, function(key,value){
					body = body + '<tr>';
						body = body + '<td style="width: 150px;vertical-align: middle;">' + value.id_ticket + '</td>';
						body = body + '<td style="width: 50px; vertical-align: middle;">' + value.id_atm + '</td>';
						body = body + '<td style="width: 100px; vertical-align: middle;">' + value.ticket_number_3party + '</td>';
						// body = body + '<td style="width: 100px; vertical-align: middle;">51705282    </td>';
						body = body + '<td style="width: 40px" class="text-center">' + moment(value.open).format('D MMMM YYYY HH:mm') + '</td>';
						body = body + '<td>' + value.problem + '</td>';
						body = body + '<td style="width: 100px">' + value.pic + ' - ' + value.contact_pic + '</td>';
						body = body + '<td style="width: 100px">' + value.location + '</td>';
						if(value.last_status == "OPEN"){
							body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-danger">' + value.last_status + '</span></td>';
						} else if(value.last_status == "ON PROGRESS") {
							body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-info">' + value.last_status + '</span></td>';
						} else if(value.last_status == "PENDING") {
							body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-warning">' + value.last_status + '</span></td>';
						} else if(value.last_status == "CLOSE") {
							body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-success">' + value.last_status + '</span></td>';
						} else if(value.last_status == "CANCEL") {
							body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-success" style="background-color:#555299 !important;">' + value.last_status + '</span></td>';
						}
						body = body + '<td style="width: 40px; vertical-align: middle;">' + value.operator + '</td>';
						body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><button class="btn btn-default" onclick="showTicket(' + value.id_open + ')">Detail</button></td>';
					body = body + '</tr>';
				});

				$("#tablePerformace").append(body);
				$("#tablePerformace").append('</tbody>');
				// $("#tablePerformace").DataTable({
				//  "order":[[0,"desc"]],
				// });
				$("#tablePerformace").DataTable();
				// $("#tablePerformace").DataTable().rows().remove().draw();
			},
		});
	}



	function showTicket(id){
		$.ajax({
			type:"GET",
			url:"getTicket",
			data:{
				id:id,
			},
			success: function(result){
				$("#updateButton").attr("onclick","updateTicket('" + result[0].id_ticket + "')");
				$("#cancelButton").attr("onclick","cancelTicket('" + result[0].id_ticket + "')");
				$("#pendingButton").attr("onclick","pendingTicket('" + result[0].id_ticket + "')");
				$("#closeButton").attr("onclick","closeTicket('" + result[0].id_ticket + "')");

				// $("#ticketStatus").attr("onclick","modalStatus('" + result[0].id_ticket + "')");
				
				$('#modal-ticket').modal('toggle');
				$('#ticketID').val(result[0].id_ticket);
				$("#modal-ticket-title").html("Ticket ID <b>" + result[0].id_ticket + "</b>");
				$("#ticketOpen").text(moment(result[0].open).format('D MMMM YYYY (HH:mm)'));
				$("#ticketIDATM").val(result[0].id_atm);
				$("#ticketStatus").text(result[0].last_status);
				$("#ticketStatus").attr('style','');
				if(result[0].last_status == "OPEN"){
					$("#ticketStatus").attr('class','label label-danger');
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',false);
				} else if(result[0].last_status == "PENDING") {
					$("#ticketStatus").attr('class','label label-warning');
					$("#pendingButton").prop('disabled',false);
					$("#closeButton").prop('disabled',false);
				} else if(result[0].last_status == "CLOSE"){
					$("#ticketStatus").attr('class','label label-success');
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',true);
					$("#cancelButton").prop('disabled',true);
				} else if(result[0].last_status == "ON PROGRESS"){
					$("#ticketStatus").attr('class','label label-info');
					$("#updateButton").prop('disabled',false);
					$("#closeButton").prop('disabled',false);
					$("#cancelButton").prop('disabled',false);
					$("#pendingButton").prop('disabled',false);
				} else if(result[0].last_status == "CANCEL"){
					$("#ticketStatus").attr('class','label label-purple');
					$("#ticketStatus").attr('style','background-color: #555299 !important;');
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',true);
					$("#cancelButton").prop('disabled',true);
				}

				$("#ticketSerial").val(result[0].serial_device);
				$("#ticketProblem").val(result[0].problem);
				$("#ticketPIC").val(result[0].pic + ' - ' + result[0].contact_pic);
				$("#ticketLocation").val(result[0].location);
				$("#ticketOperator").html(" by: <b>" + result[0].operator + "</b>");
				// $("#ticketNote").val(result[0].note);
				$("#ticketNote").val("");

				console.log(result[0].engineer);

				// if(result[0].engineer != null){
					$("#ticketEngineer").val(result[0].engineer);
				//  $("#ticketEngineer").prop('readonly',true);
				//  console.log("adfasdfa");
				// } else {
				//  $("#ticketEngineer").val("");
				//  $("#ticketEngineer").prop('readonly',false);
				// }

				// console.log(result[0].ticket_number_3party);

				// if(result[0].ticket_number_3party != null){
					$("#ticketNumber").val(result[0].ticket_number_3party);
				//  $("#ticketNumber").prop('readonly',true);
				// } else {
				//  $("#ticketNumber").val("");
				//  $("#ticketNumber").prop('readonly',false);
				// }

				$("#ticketActivity").empty();
				$.each(result[1],function(key,value){
					$("#ticketActivity").append('<li>' + moment(value.date).format("MMMM DD (HH:mm)") + ' [' + value.operator + '] - ' + value.note + '</li>');
				});

				$(".holderCloseID").text(result[0].id_ticket);
				$(".holderCloseRefrence").text(result[0].refrence);
				$(".holderClosePIC").text(result[0].pic);
				$(".holderCloseContact").text(result[0].contact_pic);
				$(".holderCloseLocation").text(result[0].location);
				$(".holderCloseProblem").text(result[0].problem);
				$(".holderCloseSerial").text(result[0].serial_device);
				$(".holderCloseIDATM").text(result[0].id_atm);

				$(".holderCloseNote").text("");
				$(".holderCloseEngineer").text(result[0].engineer);

				// 2018-03-15 10:22:08
				var waktu = moment((result[0].open), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");
				

				$(".holderCloseDate").text(waktu);
				

				$(".holderCloseStatus").html("<b>CLOSE</b>");
				$(".holderNumberTicket").text($("#ticketNumber").val());

					// $("#ticketNumber").val(result[0].ticket_number_3party);

				$(".holderPendingID").text(result[0].id_ticket);
				$(".holderPendingRefrence").text(result[0].refrence);
				$(".holderPendingPIC").text(result[0].pic);
				$(".holderPendingContact").text(result[0].contact_pic);
				$(".holderPendingLocation").text(result[0].location);
				$(".holderPendingProblem").text(result[0].problem);
				$(".holderPendingSerial").text(result[0].serial_device);
				$(".holderPendingIDATM").text(result[0].id_atm);

				$(".holderPendingNote").text("");
				$(".holderPendingEngineer").text(result[0].engineer);

				// 2018-03-15 10:22:08
				var waktu = moment((result[0].open), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");
				

				$(".holderPendingDate").text(waktu);
				

				$(".holderPendingStatus").html("<b>PENDING</b>");
				$(".holderNumberTicket").text($("#ticketNumber").val());

				$(".holderCancelID").text(result[0].id_ticket);
				$(".holderCancelRefrence").text(result[0].refrence);
				$(".holderCancelPIC").text(result[0].pic);
				$(".holderCancelContact").text(result[0].contact_pic);
				$(".holderCancelLocation").text(result[0].location);
				$(".holderCancelProblem").text(result[0].problem);
				$(".holderCancelSerial").text(result[0].serial_device);
				$(".holderCancelIDATM").text(result[0].id_atm);

				$(".holderCancelNote").text("");
				$(".holderCancelEngineer").text(result[0].engineer);

				// 2018-03-15 10:22:08
				var waktu = moment((result[0].open), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");
				

				$(".holderCancelDate").text(waktu);
				

				$(".holderCancelStatus").html("<b>CANCEL</b>");
				$(".holderNumberTicket").text($("#ticketNumber").val());


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

	//--------------
	//- AREA CHART -
	//--------------

	/*// Get context with jQuery - using jQuery's .get() method.
	var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
	// This will get the first returned node in the jQuery collection.
	var areaChart = new Chart(areaChartCanvas);

	var areaChartData = {
		labels: ["January", "February", "March", "April", "May", "June", "July"],
		datasets: [
			{
				label: "Electronics",
				fillColor: "rgba(210, 214, 222, 1)",
				strokeColor: "rgba(210, 214, 222, 1)",
				pointColor: "rgba(210, 214, 222, 1)",
				pointStrokeColor: "#c1c7d1",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [65, 59, 80, 81, 56, 55, 40]
			},
			{
				label: "Digital Goods",
				fillColor: "rgba(60,141,188,0.9)",
				strokeColor: "rgba(60,141,188,0.8)",
				pointColor: "#3b8bba",
				pointStrokeColor: "rgba(60,141,188,1)",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(60,141,188,1)",
				data: [28, 48, 40, 19, 86, 27, 90]
			}
		]
	};*/

	// var areaChartOptions = {
	// 	//Boolean - If we should show the scale at all
	// 	showScale: true,
	// 	//Boolean - Whether grid lines are shown across the chart
	// 	scaleShowGridLines: false,
	// 	//String - Colour of the grid lines
	// 	scaleGridLineColor: "rgba(0,0,0,.05)",
	// 	//Number - Width of the grid lines
	// 	scaleGridLineWidth: 1,
	// 	//Boolean - Whether to show horizontal lines (except X axis)
	// 	scaleShowHorizontalLines: true,
	// 	//Boolean - Whether to show vertical lines (except Y axis)
	// 	scaleShowVerticalLines: true,
	// 	//Boolean - Whether the line is curved between points
	// 	bezierCurve: true,
	// 	//Number - Tension of the bezier curve between points
	// 	bezierCurveTension: 0.3,
	// 	//Boolean - Whether to show a dot for each point
	// 	pointDot: false,
	// 	//Number - Radius of each point dot in pixels
	// 	pointDotRadius: 4,
	// 	//Number - Pixel width of point dot stroke
	// 	pointDotStrokeWidth: 1,
	// 	//Number - amount extra to add to the radius to cater for hit detection outside the drawn point
	// 	pointHitDetectionRadius: 20,
	// 	//Boolean - Whether to show a stroke for datasets
	// 	datasetStroke: true,
	// 	//Number - Pixel width of dataset stroke
	// 	datasetStrokeWidth: 2,
	// 	//Boolean - Whether to fill the dataset with a color
	// 	datasetFill: true,
	// 	//String - A legend template
	// 	legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
	// 	//Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	// 	maintainAspectRatio: true,
	// 	//Boolean - whether to make the chart responsive to window resizing
	// 	responsive: true
	// };

	// //Create the line chart
	// areaChart.Line(areaChartData, areaChartOptions);

	$("#compose-textarea").wysihtml5();

	function sendOpenTicketBtn(){
		if(confirm("Are you sure to send this ticket?")){
			// var dear = "Bu Retno";
			
			// var problem = $("#inputLocation").val();
			// var idTicket = $("#inputticket").val();
			// var refrence = $("#inputRefrence").val();
			// var customer = $("#inputClient").val();
			// var pic = $("#inputPIC").val();
			// var contact = $("#inputContact").val();
			// var problem = $("#inputProblem").val();
			// var location = $("#inputLocation").val();
			// var engineer = $("#inputEngineer").val();
			// var date = $("#inputDate").val();
			// var serial = $("#inputSerial").val();

			console.log("Yes");

			// var body=data.replace(/^.*?<body>(.*?)<\/body>.*?$/s,"$1");
			// $("body").html(body);
			var body = $("#bodyOpenMail").html();
			// console.log(body);

			$.ajax({
				type:"GET",
				url:"mailOpenTicket",
				data:{
					body:body,
					subject: $("#emailOpenSubject").val(),
					to: $("#emailOpenTo").val(),
					cc: $("#emailOpenCc").val(),
					attachment: $("#emailOpenAttachment").val()
				},
				success: function(result){
					console.log("success");
					alert('Email Has Been Sent!');
					$("#performance").click();
					// window.location('/tisygy');
				},
			});

			// $.ajax({
			//  type:"GET",
			//  url:"testMail",
			//  data:{
			//      body:body,
			//      subject: $("#emailOpenSubject").val(),
			//      to: $("#emailOpenTo").val(),
			//      cc: $("#emailOpenCc").val(),
			//      attachment: $("#emailOpenAttachment").val()
			//  },
			//  success: function(result){
			//      console.log("success");
			//      alert('Email Has Been Sent!');
			//      $("#performance").click();
			//      // window.location('/tisygy');
			//  },
			// });
		}
	}

	function reserveIdTicket() {

		if("{{Auth::user()->id}}" == 4){
			$("#inputticket").val('testing');
			$("#inputID").val('testing');
			$("#nomorDiv").show();
			$("#inputDate").val(moment().format("DD-MMM-YY HH:mm"));
			$("#clinetDiv").show();
			$("#createIdTicket").hide();
		} else {
			$.ajax({
				type:"GET",
				url:"reserveIdTicket",
				success: function(result){
					$("#inputticket").val(result);
					$("#inputID").val(result);
					$("#nomorDiv").show();
					$("#inputDate").val(moment().format("DD-MMM-YY HH:mm"));
					$("#clinetDiv").show();
					$("#createIdTicket").hide();
				},
			});
		}
	}

	

	function createEmailBody(){
		$("#sendTicket").show();
		$("#makeTicket").hide();
		
		$.ajax({
			type:"GET",
			url:"getEmailReciver",
			data:{
				client:$("#inputClient").val()
			},
			success: function(result){
				if("{{Auth::user()->id}}" == 4){
					$("#emailOpenTo").val("agastya@sinergy.co.id;");
					$("#emailOpenCc").val("paulus@sinergy.co.id;");
					$("#emailOpenSubject").val("[Testing] Open Tiket " + $("#inputLocation").val() + " [" + $("#inputProblem").val() +"]");
				} else {
					$("#emailOpenTo").val(result[0].open_to);
					$("#emailOpenCc").val(result[0].open_cc);
					$("#emailOpenSubject").val("Open Tiket " + $("#inputLocation").val() + " [" + $("#inputProblem").val() +"]");
				}
				$("#emailOpenHeader").html("Dear <b>" + result[0].open_dear + "</b><br>Berikut terlampir Open Tiket untuk Problem <b>" + $("#inputLocation").val() + "</b> : ");
				$(".holderCustomer").text(result[0].client_name);
			}
		});

		// if($("#inputClient").val() == "TTNI") {
		//  var dear = "Bu Retno";
		//  $("#emailTo").val("retno.elisyah@ttni.co.id; msm@sinergy.co.id; helpdesk@sinergy.co.id; hellosinergy@gmail.com");
		//  $("#emailCc").val("tango.support@ttni.co.id; endraw@sinergy.co.id");
		//  $("#emailSubject").val("Open Tiket " + $("#inputLocation").val() + " [ " + $("#inputProblem").val() +" ]");
		//  $("#emailHeader").html("Dear <b>" + dear + "</b><br>Berikut terlampir Open Tiket untuk Problem <b>" + $("#inputLocation").val() + "</b> : ");
		// } else if($("#inputClient").val() == "BSBB"){
		//  $("#emailTo").val("retno.elisyah@ttni.co.id; msm@sinergy.co.id; helpdesk@sinergy.co.id; hellosinergy@gmail.com");
		//  $("#emailCc").val("tango.support@ttni.co.id; endraw@sinergy.co.id");
		//  $("#emailHeader").html("Dear <b>" + dear + "</b><br>Berikut terlampir Open Tiket untuk Problem <b>" + $("#inputLocation").val() + "</b> : ");
		// } else if($("#inputClient").val() == "BJBR"){
		//  $("#emailTo").val("retno.elisyah@ttni.co.id; msm@sinergy.co.id; helpdesk@sinergy.co.id; hellosinergy@gmail.com");
		//  $("#emailCc").val("tango.support@ttni.co.id; endraw@sinergy.co.id");
		//  $("#emailHeader").html("Dear <b>" + dear + "</b><br>Berikut terlampir Open Tiket untuk Problem <b>" + $("#inputLocation").val() + "</b> : ");
		// } else if($("#inputClient").val() == "BRKR"){
		//  $("#emailTo").val("retno.elisyah@ttni.co.id; msm@sinergy.co.id; helpdesk@sinergy.co.id; hellosinergy@gmail.com");
		//  $("#emailCc").val("tango.support@ttni.co.id; endraw@sinergy.co.id");
		//  $("#emailHeader").html("Dear <b>" + dear + "</b><br>Berikut terlampir Open Tiket untuk Problem <b>" + $("#inputLocation").val() + "</b> : ");
		// } else if($("#inputClient").val() == "SMPO"){
		//  $("#emailTo").val("retno.elisyah@ttni.co.id; msm@sinergy.co.id; helpdesk@sinergy.co.id; hellosinergy@gmail.com");
		//  $("#emailCc").val("tango.support@ttni.co.id; endraw@sinergy.co.id");
		//  $("#emailHeader").html("Dear <b>" + dear + "</b><br>Berikut terlampir Open Tiket untuk Problem <b>" + $("#inputLocation").val() + "</b> : ");
		// } else {
		//  $("#emailTo").val("");
		//  $("#emailCc").val("");
		//  $("#emailSubject").val("");
		// }


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
		$(".holderNote").text($("#inputNote").val());
		
		$(".holderEngineer").text($("#inputEngineer").val());
		$(".holderDate").text(waktu);
		// .("#holderCounter").text($("#inputticket").val();
		// .("#holderRoot").text($("#inputticket").val();

		$(".holderStatus").html("<b>OPEN</b>");
		$(".holderWaktu").html("<b>" + waktu2 + "</b>");

		report = moment($("#inputReport1").val() + " " + $("#inputReport2").val()).format("YYYY-MM-DD HH:mm:ss.000000");
		// report = moment("13:56:30 03/27/2018").format("YYYY-MM-DD HH:mm:ss.000000");

		if("{{Auth::user()->id}}" == 4){
			$.ajax({
				type:"GET",
				url:"setNewTicketqweq",
				data:{
					id:$("#inputID").val(),
					id_ticket:$("#inputticket").val(),
					client:$("#inputClient").val(),

					id_atm:$("#inputATM").val(),
					refrence:$("#inputRefrence").val(),
					pic:$("#inputPIC").val(),
					contact_pic:$("#inputContact").val(),
					location:$("#inputLocation").val(),
					problem:$("#inputProblem").val(),
					serial_device:$("#inputSerial").val(),
					note:$("#inputNote").val(),
					report:report,
				},
			});
		} else {
			$.ajax({
				type:"GET",
				url:"setNewTicket",
				data:{
					id:$("#inputID").val(),
					id_ticket:$("#inputticket").val(),
					client:$("#inputClient").val(),

					id_atm:$("#inputATM").val(),
					refrence:$("#inputRefrence").val(),
					pic:$("#inputPIC").val(),
					contact_pic:$("#inputContact").val(),
					location:$("#inputLocation").val(),
					problem:$("#inputProblem").val(),
					serial_device:$("#inputSerial").val(),
					note:$("#inputNote").val(),
					report:report,
				},
			});
		}

	}

	$("#inputPIC").change(function(){
		if($(this).val() == ""){
			$(this).closest('.form-group').addClass('has-error')
		} else {
			$(this).closest('.form-group').removeClass('has-error')
		}
	});

	$("#inputContact").change(function(){
		if($(this).val() == ""){
			$(this).closest('.form-group').addClass('has-error')
		} else {
			$(this).closest('.form-group').removeClass('has-error')
		}
	});
	$("#inputProblem").change(function(){
		if($(this).val() == ""){
			$(this).closest('.form-group').addClass('has-error')
		} else {
			$(this).closest('.form-group').removeClass('has-error')
		}
	});
	$("#inputLocation").change(function(){
		if($(this).val() == ""){
			$(this).closest('.form-group').addClass('has-error')
		} else {
			$(this).closest('.form-group').removeClass('has-error')
		}
	});

	function createTicket(){

		if($("#inputPIC").val() == "" ){
			alert('You must set PIC');
		} else if($("#inputContact").val() == "" ){
			alert('You must set Contact PIC');
		} else if($("#inputProblem").val() == "" ){
			alert('You must set Problem');
		} else if($("#inputLocation").val() == "" ){
			alert('You must set Location');
		} else {
			var waktu = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("D MMMM YYYY");
			var waktu2 = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("HH:mm");

			console.log(waktu);

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
			// $("#holderCounter").text($("#inputticket").val();
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



	var perawan = 0;

	$("#inputClient").change(function(){
		// $("#inputATM").select2();
		// updateID(select option:selected);
		if(perawan == 0){
			$("#inputticket").val($("#inputticket").val() + "/" + this.value + moment().format("/MMM/YYYY"));
		} else {
			var str = $("#inputticket").val();
			str = str.substr(0,3);

			$("#inputticket").val(str + "/" + this.value + moment().format("/MMM/YYYY"));
		}

		if("{{Auth::user()->id}}" == 4){
			var idDummy = 1;
		} else {
			var idDummy = null;
		}

		$.ajax({
			type:"GET",
			url:"updateIdTicket",
			data:{
				id:idDummy,
				id_ticket:$("#inputticket").val(),
				id_client:this.value,
				operator:"{{Auth::user()->nickname}}",
			}
		});


		// var data;
		$.ajax({
			type:"GET",
			url:"getAtm",
			data:{
				acronym:this.value,
			},
			success: function(result){
				console.log(result);
				$("#inputATM").select2('destroy');
				$("#inputATM").select2({
					data:result
				});
			}
		});


		// if(this.value == "BJBR"){
		//  $(".2owner").show();
		//  $(".3owner").hide();
		//  $(".4owner").hide();
		// }
		// else if(this.value == "BSBB"){
		//  $(".2owner").hide();
		//  $(".3owner").show();
		//  $(".4owner").hide();
		// }
		// else if(this.value == "BRKR"){
		//  $(".2owner").hide();
		//  $(".3owner").hide();
		//  $(".4owner").show();
		// }

		if(this.value == "BJBR" || this.value == "BSBB" || this.value == "BRKR"){
			$("#inputATMid").show();
			$("#categoryDiv").show();
		} else {
			$("#inputATMid").hide();
		}

		$("#refrenceDIV").show();
		$("#nomorDiv").show();
		$("#clinetDiv").show();
		$("#picDiv").show();
		$("#contactDiv").show();
		$("#problemDiv").show();
		$("#locationDiv").show();
		$("#dateDiv").show();
		$("#noteDiv").show();
		$("#serialDiv").show();
		$("#reportDiv").show();
		
		$("#createTicket").show();

		perawan = 1;
		console.log(perawan);

	});


	

</script>
@endsection