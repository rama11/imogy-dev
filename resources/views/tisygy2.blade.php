@extends('layouts.admin.layout_fast')

@section('head')
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css')}}">
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
	
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
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs" id="myTab">
						<li class="active"><a href="#tab_1" data-toggle="tab" onclick="getDashboard()">Dashboard</a></li>
						<li>
							<a href="#tab_2" data-toggle="tab" onclick="getCreateParameter()">Create</a>
						</li>
						<li>
							<a href="#tab_3" data-toggle="tab" id="performance" onclick="getPerformance()">Performance</a>
						</li>
						<li>
							<a href="#tab_6" data-toggle="tab">Setting</a>
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
														<th>Open</th>
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

							<hr>

						</div>
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
													
												</select>
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
										<hr id="hrLine2" style="display: none">
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
													<!-- <div class="btn btn-default btn-file">
														<i class="fa fa-paperclip"></i> Attachment
														<input type="file" name="attachment" id="emailOpenAttachment">
													</div> -->
													<button class="btn btn-primary" onclick="sendOpenTicketBtn()"><i class="fa fa-envelope-o"></i> Send</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane table-responsive no-padding" id="tab_3">
							<div id="clientList">
								
							</div>
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
											<div class="modal-tools pull-right" style="text-align: right";>
												<div>
													<span class="label label-default" id="ticketSeverity" style="font-size: 15px;"></span>
												</div>
												<div style="margin-top: 5px;">
													<span id="ticketOpen"></span> 
													<span class="label label-default" id="ticketStatus"></span>
												</div>
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
													</ul>
												</div>
												<div class="form-group" id="ticketNoteHolder">
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
											<div class="btn-group pull-left">
												<button type="button" class="btn btn-default">Show</button>
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li><a href="#">Open Ticket</a></li>
													<li><a href="#">Pending Ticket</a></li>
													<li><a href="#">Cancel Ticket</a></li>
													<li><a href="#">Close Ticket</a></li>
													<li class="divider"></li>
													<li><a href="#">Back To Detail</a></li>
												</ul>
											</div>
											<!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
											<button type="button" class="btn btn-success" onclick="closeTicket()" id="closeButton">Close</button>
											<button type="button" class="btn btn-warning" onclick="pendingTicket()" id="pendingButton">Pending</button>
											<button type="button" class="btn bg-purple" onclick="cencelTicket()" id="cancelButton" >Cancel</button>
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
													<!-- <div class="btn btn-default btn-file">
														<i class="fa fa-paperclip"></i> Attachment
														<input type="file" name="attachment" id="emailCloseAttachment">
													</div> -->
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
												<button type="button" class="btn btn-warning " id="savePendingButton">Pending</button>
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
													<!-- <div class="btn btn-default btn-file">
														<i class="fa fa-paperclip"></i> Attachment
														<input type="file" name="attachment" id="emailPendingAttachment">
													</div> -->
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
													<!-- <div class="btn btn-default btn-file">
														<i class="fa fa-paperclip"></i> Attachment
														<input type="file" name="attachment" id="emailCancelAttachment">
													</div> -->
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
						
							<div class="row">
								<table class="table table-striped col-md-12" style="display: none;" id="emailSetting">
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
							</div>
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

<script>

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

	getDashboard();

	function getDashboard(){
		$.ajax({
			type:"GET",
			url:"getDashboard",
			data:{
				client:"all"
			},
			success:function(result){
				// console.log(result);
				$("#countOpen").text(result[0][0]);
				$("#countProgress").text(result[0][1]);
				$("#countPending").text(result[0][2]);
				$("#countClose").text(result[0][3]);
				$("#countCancel").text(result[0][4]);
				$("#countAll").text(result[0][5]);

				$("#countCritical").text(result[4][0]['count']);
				$("#countMajor").text(result[4][1]['count']);
				$("#countModerate").text(result[4][2]['count']);
				$("#countMinor").text(result[4][3]['count']);

				var append = "";
				$.each(result[1],function(key,value){
					var dummy = "getPerformance('" + value + "')";
					append = append + '<button class="btn btn-default" onclick=' + dummy + '>' + value + '</button> ';
				});

				$("#clientList").html(append);

				var append = '';
				$("#importanTable").empty(append);
				$.each(result[3],function(key,value){
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
					return key < 9;
				});
				
				$("#importanTable").append(append);

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
							  "#8e44ad",
							  "#34495e",
							  "#1abc9c",
							  "#7f8c8d"
							],
							hoverBackgroundColor: [
							  "#40d47e",
							  "#e98b39",
							  "#d14233",
							  "#4aa3df",
							  "#9b50ba",
							  "#3d566e",
							  "#1dd2af",
							  "#8c9899"
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
						text: ""
					}
				};

				var ctx = document.getElementById("pieChart").getContext("2d");
				window.myDoughnut = new Chart(ctx, config);

				// if("{{Auth::user()->id}}" == 4){
				// 	$("#management").click();
				// }

			}
		});
	}

	function getCreateParameter(){
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
				// console.log(result[0].serial_number);
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

				$(".holderCancelNote").text($("#saveReasonCancel").val());

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
				// $("#performance").click();
				addRows(result);
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
				attachment: $("#emailPendingAttachment").val(),
				note_pending: $("#saveReasonPending").val()
			},
			success: function (result){
				alert('Pending email has been esnt');
				$("#modal-pending").modal('toggle');
				$("#modal-next-pending").modal('toggle');
				$("#modal-ticket").modal('toggle');
				// $("#performance").click();
				addRows(result);
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
				attachment: $("#emailCancelAttachment").val(),
				note_cancel: $("#saveReasonCancel").val()
			},
			success: function (result){
				alert('Cancel email has been sent');
				$("#modal-cancel").modal('toggle');
				$("#modal-next-cancel").modal('toggle');
				$("#modal-ticket").modal('toggle');
				// $("#performance").click();
				addRows(result);
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
						addRows(result);
					}
				});
			}
		}
	}

	var dataTicket = [];

	function getPerformance(client = ""){
		
		if(client != ""){
			addRows(client)
		} else {
			$("#tablePerformace").empty();
			$("#myInput2").val("");
			$("#myInput").val("");
			var heading = "";
			heading = heading + '<thead>';
				heading = heading + '<tr>';
					heading = heading + '<th style="width: 150px;vertical-align: middle;">ID Ticket</th>';
					heading = heading + '<th style="text-align:center;width: 100px;vertical-align: middle;">ID ATM*</th>';
					heading = heading + '<th style="text-align:center;width: 100px;vertical-align: middle;">Ticket Number</th>';
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
			
			var url = "getPerformance2?client=all";
			$.ajax({
				type:"GET",
				url:url,
				success:function(result){
					var body = "";
					// console.log(result[0]);

					$.each(result, function(key,value){
						body = body + '<tr>';
							if((value.id_ticket).indexOf('/') == 3){
								body = body + '<td style="width: 150px;vertical-align: middle;">0' + value.id_ticket + '</td>';
							} else {
								body = body + '<td style="width: 150px;vertical-align: middle;">' + value.id_ticket + '</td>';
							}
							body = body + '<td style="width: 50px; vertical-align: middle;">' + value.id_atm + '</td>';
							body = body + '<td style="width: 100px; vertical-align: middle;">' + value.ticket_number_3party + '</td>';
							// body = body + '<td style="width: 100px; vertical-align: middle;">51705282    </td>';
							body = body + '<td style="width: 40px" class="text-center">' + moment(value.open).format('dddd, D MMMM YYYY HH:mm') + '</td>';
							body = body + '<td>' + value.problem + '</td>';
							body = body + '<td style="width: 100px">' + value.pic + ' - ' + value.contact_pic + '</td>';
							body = body + '<td style="width: 100px">' + value.location + '</td>';
							if(value.last_status[0] == "OPEN"){
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-danger">' + value.last_status[0] + '</span></td>';
							} else if(value.last_status[0] == "ON PROGRESS") {
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-info">' + value.last_status[0] + '</span></td>';
							} else if(value.last_status[0] == "PENDING") {
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-warning">' + value.last_status[0] + '</span></td>';
							} else if(value.last_status[0] == "CLOSE") {
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-success">' + value.last_status[0] + '</span></td>';
							} else if(value.last_status[0] == "CANCEL") {
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-success" style="background-color:#555299 !important;">' + value.last_status[0] + '</span></td>';
							}
							body = body + '<td style="width: 40px; vertical-align: middle;">' + value.operator + '</td>';
							body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><button class="btn btn-default" onclick="showTicket(' + value.id_open + ')">Detail</button></td>';
						body = body + '</tr>';
					});

					$("#tablePerformace").append(body);
					$("#tablePerformace").append('</tbody>');
					
					$("#tablePerformace").DataTable();
					// $("#tablePerformace").DataTable().rows().remove().draw();
				},
			});
		}
	}

	// $('#myTab a').click(function (e) {
	// 	e.preventDefault()
	// 	console.log(this);
	// 	$(this).tab('show')
	// });

	var severityFirst = 1; 

	function getSeverity(severity){
		var url = "getPerformanceBySeverity?severity=" + severity;
		// $("#tablePerformace").DataTable().clear().draw();
		dataTicket = [];

		$.ajax({
			type:"GET",
			url:url,
			beforeSend:function(){
				// var url = "getPerformance2?client=all";
				if (severityFirst == 1) {
					$("#tablePerformace").empty();
					$("#myInput2").val("");
					$("#myInput").val("");
					var heading = "";
					heading = heading + '<thead>';
						heading = heading + '<tr>';
							heading = heading + '<th style="width: 150px;vertical-align: middle;">ID Ticket</th>';
							heading = heading + '<th style="text-align:center;width: 100px;vertical-align: middle;">ID ATM*</th>';
							heading = heading + '<th style="text-align:center;width: 100px;vertical-align: middle;">Ticket Number</th>';
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
				}
			},
			success:function(result){
				if(severityFirst == 1){
					var body = "";
					$.each(result, function(key,value){
						body = body + '<tr>';
							if((value.id_ticket).indexOf('/') == 3){
								body = body + '<td style="width: 150px;vertical-align: middle;">0' + value.id_ticket + '</td>';
							} else {
								body = body + '<td style="width: 150px;vertical-align: middle;">' + value.id_ticket + '</td>';
							}
							body = body + '<td style="width: 50px; vertical-align: middle;">' + value.id_atm + '</td>';
							body = body + '<td style="width: 100px; vertical-align: middle;">' + value.ticket_number_3party + '</td>';
							body = body + '<td style="width: 40px" class="text-center">' + moment(value.open).format('dddd, D MMMM YYYY HH:mm') + '</td>';
							body = body + '<td>' + value.problem + '</td>';
							body = body + '<td style="width: 100px">' + value.pic + ' - ' + value.contact_pic + '</td>';
							body = body + '<td style="width: 100px">' + value.location + '</td>';
							if(value.last_status[0] == "OPEN"){
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-danger">' + value.last_status[0] + '</span></td>';
							} else if(value.last_status[0] == "ON PROGRESS") {
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-info">' + value.last_status[0] + '</span></td>';
							} else if(value.last_status[0] == "PENDING") {
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-warning">' + value.last_status[0] + '</span></td>';
							} else if(value.last_status[0] == "CLOSE") {
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-success">' + value.last_status[0] + '</span></td>';
							} else if(value.last_status[0] == "CANCEL") {
								body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><span class="label label-success" style="background-color:#555299 !important;">' + value.last_status[0] + '</span></td>';
							}
							body = body + '<td style="width: 40px; vertical-align: middle;">' + value.operator + '</td>';
							body = body + '<td style="width: 40px; vertical-align: middle;text-align: center"><button class="btn btn-default" onclick="showTicket(' + value.id_open + ')">Detail</button></td>';
						body = body + '</tr>';
					});

					$("#tablePerformace").append(body);
					$("#tablePerformace").append('</tbody>');
					
					$("#tablePerformace").DataTable();
				} else {
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
				}
			},
			complete: function(){
				$('#myTab a[href="#tab_3"]').tab('show');
				if(severityFirst == 1){
					severityFirst = 0;
				} else {
					$("#tablePerformace").DataTable().clear().draw();
					$.each(dataTicket, function(key,value){
						$("#tablePerformace").DataTable().row.add([
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
			}
		});
	}

	function addRows(client){
		var url = "getPerformance2?client=" + client;
					
		$("#tablePerformace").DataTable().clear().draw();
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
					$("#tablePerformace").DataTable().row.add([
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
				$("#ticketOpen").text(moment(result[0].last_status[1]).format('D MMMM YYYY (HH:mm)'));
				$("#ticketIDATM").val(result[0].id_atm);
				$("#ticketStatus").text(result[0].last_status[0]);
				$("#ticketStatus").attr('style','');

				if(result[0].severity == 1){
					$("#ticketSeverity").text("Critical");
					$("#ticketSeverity").attr('class','label label-danger');
					$(".holderCloseSeverity").text(result[0].severity + " (Critical)");
					$(".holderPendingSeverity").text(result[0].severity + " (Critical)");
					$(".holderCancelSeverity").text(result[0].severity + " (Critical)");
				} else if(result[0].severity == 2){
					$("#ticketSeverity").text("Major");
					$("#ticketSeverity").attr('class','label label-warning');
					$(".holderCloseSeverity").text(result[0].severity + " (Major)");
					$(".holderPendingSeverity").text(result[0].severity + " (Major)");
					$(".holderCancelSeverity").text(result[0].severity + " (Major)");
				} else if(result[0].severity == 3){
					$("#ticketSeverity").text("Moderate");
					$("#ticketSeverity").attr('class','label label-info');
					$(".holderCloseSeverity").text(result[0].severity + " (Moderate)");
					$(".holderPendingSeverity").text(result[0].severity + " (Moderate)");
					$(".holderCancelSeverity").text(result[0].severity + " (Moderate)");
				} else if(result[0].severity == 4){
					$("#ticketSeverity").text("Minor");
					$("#ticketSeverity").attr('class','label label-success');
					$(".holderCloseSeverity").text(result[0].severity + " (Minor)");
					$(".holderPendingSeverity").text(result[0].severity + " (Minor)");
					$(".holderCancelSeverity").text(result[0].severity + " (Minor)");
				} else {
					$("#ticketSeverity").text("N/A");
					$("#ticketSeverity").attr('class','label label-default');
					$(".holderCloseSeverity").text("(N/A)");
					$(".holderPendingSeverity").text("(N/A)");
					$(".holderCancelSeverity").text("(N/A)");
				}

				$("#ticketNoteHolder").show();

				$("#ticketCouter").hide();
				$("#ticketRoute").hide();

				if(result[0].last_status[0] == "OPEN"){
					$("#ticketStatus").attr('class','label label-danger');
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',false);
				} else if(result[0].last_status[0] == "PENDING") {
					$("#ticketStatus").attr('class','label label-warning');
					$("#pendingButton").prop('disabled',false);
					$("#closeButton").prop('disabled',false);
				} else if(result[0].last_status[0] == "CLOSE"){
					$("#ticketStatus").attr('class','label label-success');
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',true);
					$("#cancelButton").prop('disabled',true);
					$("#ticketNoteHolder").hide();
					$("#ticketCouter").show();
					$("#ticketRoute").show();
					$("#ticketCouterTxt").val(result[2].counter_measure);
					$("#ticketRouteTxt").val(result[2].root_couse);

				} else if(result[0].last_status[0] == "ON PROGRESS"){
					$("#ticketStatus").attr('class','label label-info');
					$("#updateButton").prop('disabled',false);
					$("#closeButton").prop('disabled',false);
					$("#cancelButton").prop('disabled',false);
					$("#pendingButton").prop('disabled',false);
				} else if(result[0].last_status[0] == "CANCEL"){
					$("#ticketStatus").attr('class','label label-purple');
					$("#ticketStatus").attr('style','background-color: #555299 !important;');
					$("#ticketNoteHolder").hide();
					
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

				if(result[0].reporting_time != "Invalid date"){
					$("#ticketActivity").append('<li>Reporting time : ' + moment(result[0].reporting_time).format("MMMM DD (HH:mm)") + ' </li>');
				} else {
					$("#ticketActivity").append('<li>Reporting time : ' + result[0].reporting_time + '</li>');
				}

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
		if("{Auth::check()}"){
			if("{{Auth::user()->id}}" == 4){
				$("#inputticket").val('0000');
				$("#inputID").val('0000');
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
		} else {
			window.location('/login');
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
				$("#emailOpenTo").val(result[0].open_to);
				$("#emailOpenCc").val(result[0].open_cc);
				$("#emailOpenSubject").val("Open Tiket " + $("#inputLocation").val() + " [" + $("#inputProblem").val() +"]");
				$("#emailOpenHeader").html("Dear <b>" + result[0].open_dear + "</b><br>Berikut terlampir Open Tiket untuk Problem <b>" + $("#inputLocation").val() + "</b> : ");
				$(".holderCustomer").text(result[0].client_name);
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
		// .("#holderCounter").text($("#inputticket").val();
		// .("#holderRoot").text($("#inputticket").val();

		$(".holderStatus").html("<b>OPEN</b>");
		$(".holderWaktu").html("<b>" + waktu2 + "</b>");

		report = moment($("#inputReport1").val() + " " + $("#inputReport2").val()).format("YYYY-MM-DD HH:mm:ss.000000");
		// report = moment("13:56:30 03/27/2018").format("YYYY-MM-DD HH:mm:ss.000000");

		if("{{Auth::user()->id}}" == 4){
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
					severity:$("#inputSeverity").val()
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
					severity:$("#inputSeverity").val()
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
				url:"getAtm",
				data:{
					acronym:$("#inputClient").val(),
				},
				success: function(result){
					console.log(result);
					$("#inputATMid").show();
					$("#categoryDiv").show();
					$("#inputATM").select2('destroy');
					$("#inputATM").select2({
						data:result
					});
				}
			});
		} else {
			$("#inputATM").val("");
			$("#inputSerial").val("");
			$("#inputLocation").val("");
			$("#inputATMid").hide();
		}
	}

	var perawan = 0;

	$("#inputClient").change(function(){
		if(perawan == 0){
			$("#inputticket").val($("#inputticket").val() + "/" + this.value + moment().format("/MMM/YYYY"));
		} else {
			var str = $("#inputticket").val();
			str = str.substr(0,str.indexOf('/')+0);
			$("#inputticket").val(str + "/" + this.value + moment().format("/MMM/YYYY"));
		}

		if("{{Auth::user()->id}}" == 4){
			var idDummy = 1;
			$.ajax({
				type:"GET",
				url:"updateIdTicketasdfa",
				data:{
					id:idDummy,
					id_ticket:$("#inputticket").val(),
					id_client:this.value,
					operator:"{{Auth::user()->nickname}}",
				}
			});
		} else {
			var idDummy = null;
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
		}


		if($("#inputSeverity").val() != "Chose the severity"){
			getBankAtm();
		}

		perawan = 1;
		// console.log(perawan);
	});


	$("#inputSeverity").change(function(){
		$("#hrLine").show();
		$("#hrLine2").show();
		$("#refrenceDIV").show();
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
