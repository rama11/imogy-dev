@extends('layouts.helpdesk.hlayout')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			User Manager 

		</h1>
		<a href="#" class="pull-right btn-box-tool text-green pull-left" data-toggle="modal" data-target="#modal-adduser"><i class="fa fa-plus"></i> Add New User</a>
		<ol class="breadcrumb">
			<li><a href="{{url('helpdesk')}}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">User Manage</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- List Users (Stat box) -->
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Enginer</a></li>
						<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Helpdesk</a></li>
						<li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Admin</a></li>
						<!-- <li class=""><a href="#create" data-toggle="tab" aria-expanded="false"><b>Create User</b></a></li> -->
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="activity">
							<!-- Post -->
							<div class="post">
								@foreach($users as $user)
								@if($user->role == 3)
								<?php $jam = null; $tanggal =null;?>
								<div class="user-block">

									<img class="img-circle img-bordered-sm" src="{{asset('AdminLTE/dist/img/user1-128x128.jpg')}}" alt="user image">
									<span class="username">
										<a href="/user/">{{$user->name}}</a>
										<a href="#" class="pull-right btn-box-tool text-red"><i class="fa fa-remove"></i> Remove</a>

										<a href="#" class="pull-right btn-box-tool text-green" data-toggle="modal" data-target="#modal-default" onclick="getMasuk('{{$user->id}}')" ><i class="fa fa-edit"></i> Edit Schedule</a>

										<a href="#" class="pull-right btn-box-tool text-blue" data-toggle="modal" data-target="#modal-profile" onclick="getProfile('{{$user->id}}')" ><i class="fa fa-edit"></i> Edit Profile</a>
									</span>
									@if($user->condition == "on")
									@foreach($waktu_absen as $absen)
									@if($absen->id_user == $user->id)
									<?php $jam=$absen->jam;
									$originalDate = $absen->tanggal;
									$tanggal = date("d/m/Y", strtotime($originalDate));
									?>
									@endif
									@endforeach

									<span class="description"><small class="label label-success">Onwork</small> Last Absent {{$jam}} - {{$tanggal}}</span>

									@else
									<span class="description"><small class="label label-danger">Offwork</small> </span>
									@endif
									<span class="description"><small class="label label-info">Work On {{$user->hadir}}</small> </span>
								</div>
								@endif
								@endforeach

								<!-- /.user-block -->
							</div>
							<!-- /.post -->

						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="timeline">
							<!-- Post -->
							<div class="post">
								@foreach($users as $user)
								@if($user->role == 2)
								<?php $jam = null; $tanggal =null;?>
								<div class="user-block">

									<img class="img-circle img-bordered-sm" src="{{asset('AdminLTE/dist/img/user1-128x128.jpg')}}" alt="user image">
									<span class="username">
										<a href="/user/">{{$user->name}}</a>
										<a href="#" class="pull-right btn-box-tool text-red"><i class="fa fa-remove"></i> Remove</a>

										<a href="#" class="pull-right btn-box-tool text-green" data-toggle="modal" data-target="#modal-default" onclick="getMasuk('{{$user->id}}')" ><i class="fa fa-edit"></i> Edit Schedule</a>

									</span>
									@if($user->condition == "on")
									@foreach($waktu_absen as $absen)
									@if($absen->id_user == $user->id)
									<?php $jam=$absen->jam;
									$originalDate = $absen->tanggal;
									$tanggal = date("d/m/Y", strtotime($originalDate));
									?>
									@endif
									@endforeach

									<span class="description"><small class="label label-success">Onwork</small> Last Absent {{$jam}} - {{$tanggal}}</span>

									@else
									<span class="description"><small class="label label-danger">Offwork</small> </span>
									@endif
									<span class="description"><small class="label label-info">Work On {{$user->hadir}}</small> </span>
								</div>
								@endif
								@endforeach

								<!-- /.user-block -->
							</div>
							<!-- /.post -->
							
						</div>

						<div class="tab-pane" id="settings">
							<!-- Post -->
							<div class="post">
								@foreach($users as $user)
								@if($user->role == 1)
								<?php $jam = null; $tanggal =null;?>
								<div class="user-block">

									<img class="img-circle img-bordered-sm" src="{{asset('AdminLTE/dist/img/user1-128x128.jpg')}}" alt="user image">
									<span class="username">
										<a href="/user/">{{$user->name}}</a>
										<a href="#" class="pull-right btn-box-tool text-red"><i class="fa fa-remove"></i> Remove</a>

										<a href="#" class="pull-right btn-box-tool text-green" data-toggle="modal" data-target="#modal-default" onclick="getMasuk('{{$user->id}}')" ><i class="fa fa-edit"></i> Edit Schedule</a>

									</span>
									@if($user->condition == "on")
									@foreach($waktu_absen as $absen)
									@if($absen->id_user == $user->id)
									<?php $jam=$absen->jam;
									$originalDate = $absen->tanggal;
									$tanggal = date("d/m/Y", strtotime($originalDate));
									?>
									@endif
									@endforeach

									<span class="description"><small class="label label-success">Onwork</small> Last Absent {{$jam}} - {{$tanggal}}</span>

									@else
									<span class="description"><small class="label label-danger">Offwork</small> </span>
									@endif
									<span class="description"><small class="label label-info">Work On {{$user->hadir}}</small> </span>
								</div>
								@endif
								@endforeach

								<!-- /.user-block -->
							</div>
							<!-- /.post -->
						</div>
						<div class="tab-pane" id="create">
							<!-- Post -->
							<div class="box-body">
								<div class="form-group col-md-6">
									<label for="add_nama" class="col-sm-2 control-label">Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="inputticket" placeholder="Name"></div>&nbsp; 
									</div> 
									<div class="form-group col-md-6">
										<label for="add_nama" class="col-sm-2 control-label">Gender</label>
										<div class="col-md-6">
											<input type="text" class="form-control" id="inputticket" placeholder="Gender"></div>&nbsp; 
										</div> 
										<div class="form-group col-md-6">
											<label for="add_nama" class="col-sm-2 control-label">Born</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="inputticket" placeholder="Born"></div>&nbsp; 
											</div> 
											<div class="form-group col-md-6">
												<label for="add_nama" class="col-sm-2 control-label">Education</label>
												<div class="col-md-6">
													<input type="text" class="form-control" id="inputticket" placeholder="Education"></div>&nbsp; 
												</div> 
												<div class="form-group col-md-6">
													<label for="add_nama" class="col-sm-2 control-label">Phone</label>
													<div class="col-md-6">
														<input type="number" class="form-control" id="inputticket" placeholder="Phone"></div>&nbsp; 
													</div> 
													<div class="form-group col-md-6">
														<label for="add_nama" class="col-sm-2 control-label">Address</label>
														<div class="col-md-6">
															<input type="text" class="form-control" id="inputticket" placeholder="Address"></div>&nbsp; 
														</div> 
														<div class="form-group col-md-6">
															<label for="add_email" class="col-sm-2 control-label">Email</label>
															<div class="col-md-6">
																<input type="email" class="form-control" id="inputticket" placeholder="Email"></div> &nbsp;
															</div>

															<div class="form-group col-md-6">
																<label for="add_email" class="col-sm-2 control-label">Role</label>
																<div class="col-md-6">
																	<input type="text" class="form-control" id="inputticket" placeholder="Role"></div> &nbsp;
																</div>

																<div class="form-group col-md-6">
																	<label for="add_email" class="col-sm-2 control-label">Team</label>
																	<div class="col-md-6">
																		<input type="text" class="form-control" id="inputticket" placeholder="Team"></div> &nbsp;
																	</div> 

																	<div class="form-group col-md-6">
																		<label for="add_email" class="col-sm-2 control-label">Location</label>
																		<div class="col-md-6">
																			<input type="email" class="form-control" id="inputticket" placeholder="Location"></div>  &nbsp;
																		</div>
																		<div class="box-body center">
																			<div class="nav-tabs-custom">
																				<ul class="nav nav-tabs">
																					<li class=""><a href="#hum" data-toggle="tab" aria-expanded="false">Insert Photo</a></li>

																				</ul>
																				<div class="form-group">
																					<label for="exampleInputFile">File input</label>
																					<input type="file" id="exampleInputFile">
																					<p class="help-block">Upload foto disini. 
																						<button class="btn btn-primary" type="submit">Upload</button>
																					</p>
																				</div>
																				<div class="text-center">
																					<img src="img/miuty.jpg" class="rounded" alt="..." width="20%" height="20%">
																				</div>
																			</div>
																		</div>

																		<div class="box-footer">
																			<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
																				<i class="fa fa-pencil-square-o"></i> Create User
																			</button>

																		</div>


																		<!-- /.post -->
																	</div>
																	<!-- /.tab-pane -->
																</div>
																<!-- /.tab-content -->
															</div>
															<!-- /.nav-tabs-custom -->
															@if(session('status'))
															<div class="alert alert-success alert-dismissible" style="margin-top: 150px;margin-right: 10px; position:fixed; top:0; right:0; width:300px;">
																<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
																<h4><i class="icon fa fa-check"></i> Success!</h4>
																Change time for {{session('status')}} success.
															</div>
															@endif
														</div>
													</div>
													<!-- /.row -->
												</section>
												<!-- /.content -->
											</div>
											<!-- Modal Edit Location -->
											<div class="modal fade in" id="modal-default"  tabindex="-1" role="dialog">
												<div class="modal-dialog">
													<form method="GET" action="{{url('setMasuk')}}">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">×</span></button>
																	<h4 class="modal-title">Edit Work Hours</h4>
																</div>
																<div class="modal-body">
																	<p id="nameMasuk"></p>
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label>Before</label>
																				<input id="beforeMasuk" class="form-control" placeholder="Enter ..." disabled="" type="text">
																			</div>
																		</div>
																		<div class="col-md-6">
																			<input id="userID" type="hidden" name="id" value="">
																			<input id="userNAME" type="hidden" name="name" value="">
																			<div class="form-group">
																				<label>After</label>
																				<select class="form-control" name="masuk">
																					<option value="07:00:00">07:00:00</option>
																					<option value="08:00:00">08:00:00</option>
																					<option value="14:00:00">14:00:00</option>
																					<option value="22:00:00">22:00:00</option>
																				</select>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
																	<button type="submit" class="btn btn-primary" >Save changes</button>
																</div>
															</div>
														</form>
														<!-- /.modal-content -->
													</div>
													<!-- /.modal-dialog -->
												</div>
												<div class="modal fade in" id="modal-profile"  tabindex="-1" role="dialog">
													<div class="modal-dialog">
														<form method="GET" action="{{url('setMasuk')}}">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">×</span></button>
																		<h4 class="modal-title">Edit Profile</h4>
																	</div>
																	<div class="modal-body">
																		<p id="nameMasuk"></p>
																		<div class="form-group">
																			<label for="name" class="col-md-4 control-label">Name</label>
																			<div class="col-md-6">
																				<input id="name" type="text" class="form-control" name="name" value="" required autofocus>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="email" class="col-md-4 control-label">E-Mail Address</label>

																			<div class="col-md-6">
																				<input id="email" type="email" class="form-control" name="email" required>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="location" class="col-md-4 control-label">Role</label>
																			<div class="col-md-6">
																				<select id="lokasi"  name="role" class="form-control" id="role">
																					<option value="3">Engineer</option>
																					<option value="2">Helpdesk</option>
																					<option value="1">Admin</option>
																				</select>                                    
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="location" class="col-md-4 control-label">Team</label>
																			<div class="col-md-6">
																				<select id="lokasi"  name="location" class="form-control">
																					<option id="msm" value="3">MSM</option>
																					<option id="dpg" value="2">DPG</option>
																				</select>                                    
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
																			<label for="location" class="col-md-4 control-label">Location</label>

																			<div class="col-md-6">
																				<select id="lokasi"  name="location" class="form-control">
																					<option value="1">TAM PDC Cibitung</option>
																					<option value="2">BPJS Kesehatan Pusat</option>
																					<option value="3">Inlingua</option>
																					<option value="4">Ruko</option>
																				</select>                                    
																			</div>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
																		<button type="submit" class="btn btn-primary" >Save changes</button>
																	</div>
																</div>
															</form>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->

													</div>
												</div>
												<div class="modal fade in" id="modal-adduser"  tabindex="-1" role="dialog">
													<div class="modal-dialog">
														<form method="GET" action="{{url('setMasuk')}}">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">×</span></button>
																		<h4 class="modal-title">Create New User</h4>
																	</div>
																	<div class="modal-body">
																		<p id="nameMasuk"></p>
																		<div class="form-group">
																			<label for="name" class="col-md-4 control-label">Name</label>
																			<div class="col-md-6">
																				<input id="name" type="text" class="form-control" name="name" required autofocus>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="email" class="col-md-4 control-label">E-Mail Address</label>

																			<div class="col-md-6">
																				<input id="email" type="email" class="form-control" name="email" required>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="email" class="col-md-4 control-label">Password</label>

																			<div class="col-md-6">
																				<input id="email" type="Password" class="form-control" name="password" required>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="email" class="col-md-4 control-label">Re-type Password</label>

																			<div class="col-md-6">
																				<input id="email" type="Password" class="form-control" name="re-password" required>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
																			<label for="location" class="col-md-4 control-label">Location</label>
																			<div class="col-md-6">
																				<select id="lokasi"  name="location" class="form-control">
																					<option value="1">TAM PDC Cibitung</option>
																					<option value="2">BPJS Kesehatan Pusat</option>
																					<option value="3">Inlingua</option>
																					<option value="4">Ruko</option>
																				</select>                                    
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
																			<label for="location" class="col-md-4 control-label">Role</label>

																			<div class="col-md-6">
																				<select id="lokasi"  name="role" class="form-control">
																					<option value="1">Admin</option>
																					<option value="2">Helpdesk</option>
																					<option value="3">Engineer</option>
																				</select>                                    
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
																			<label for="location" class="col-md-4 control-label">Team</label>

																			<div class="col-md-6">
																				<select id="lokasi"  name="role" class="form-control">
																					<option value="MSM">MSM</option>
																					<option value="DPG">DPG</option>
																				</select>                                    
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
																			<label for="location" class="col-md-4 control-label">Jabatan</label>

																			<div class="col-md-6">
																				<select id="lokasi"  name="role" class="form-control">
																					<option value="Manager">Manager</option>
																					<option value="Engineer">Engineer</option>
																					<option value="Admin">Admin</option>
																				</select>                                    
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="gender" class="col-md-4 control-label">Gender</label>
																			<div class="col-md-6">
																				<select id="gender"  name="gender" class="form-control">
																					<option value="Male">Male</option>
																					<option value="Female">Female</option>
																				</select>                                    
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="born" class="col-md-4 control-label">Place, Date of Birth</label>
																			<div class="col-md-6">
																				<input id="born" type="text" class="form-control" name="born" required autofocus>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="education" class="col-md-4 control-label">Education</label>
																			<div class="col-md-6">
																				<input id="education" type="text" class="form-control" name="education" required autofocus>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="phone" class="col-md-4 control-label">Phone</label>
																			<div class="col-md-6">
																				<input id="phone" type="text" class="form-control" name="phone" required autofocus>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="address" class="col-md-4 control-label">Address</label>
																			<div class="col-md-6">
																				<input id="address" type="text" class="form-control" name="address" required autofocus>
																			</div>
																		</div>
																		<br><br>
																		<div class="form-group">
																			<label for="foto" class="col-md-4 control-label">Photo</label>
																			<input id="foto"  type="file">

																			<p class="help-block">Only .jpg .jpeg and .png are allowed</p>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
																		<button type="submit" class="btn btn-primary" >Save changes</button>
																	</div>

																</div>
															</form>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->

													</div>
												</div>
												@endsection
												@section('script')
												<script type="text/javascript">
													function getMasuk(id){
														console.log(id);
														$.ajax({
															type: "GET",
															url: "getMasuk/" + id,
															success: function(result){
																console.log(result[0]["id"]);
																$("#nameMasuk").text("Change work hours for " + result[0]["name"]);
																$("#beforeMasuk").attr("placeholder",result[0]["hadir"]);
																$("#userID").val(result[0]["id"]);
																$("#userID").val(result[0]["id"]);
															},
														});
													};

													function getProfile(id){
														console.log(id);
														$.ajax({
															type: "GET",
															url: "getProfile/" + id,
															success: function(result){
																console.log(result[0]["id"]);
																$("#name").val(result[0]["name"]);
																$("#email").attr("placeholder",result[0]["email"]);
																if (result[0]["role"]=="3") {
																	alert("arema");
																}
															},
														});
													};


												</script>
												@endsection