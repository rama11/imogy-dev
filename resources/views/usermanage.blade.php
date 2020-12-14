@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))
@section('head')
<link rel="stylesheet" href="{{ url('plugins/timepicker/bootstrap-timepicker.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			User Manager 
		</h1>
		<a href="#" class="pull-right btn-box-tool text-green pull-left" data-toggle="modal" data-target="#modal-adduser"><i class="fa fa-plus"></i> Add New User</a>
		<ol class="breadcrumb">
			<li><a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">User Manage</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						@foreach($privileges as $privilege)
						<li>
							<a href="#{{$privilege->id}}" data-toggle="tab" aria-expanded="true">
								{{$privilege->privilege_name}}
							</a>
						</li>
						@endforeach
					</ul>

					<div class="tab-content">
						@foreach($privileges as $privilege)
						<div class="tab-pane" id="{{$privilege->id}}">
							<div class="post">
								@foreach($users as $user)
									@if($user->jabatan == $privilege->id)
									<?php $jam = null; $tanggal =null;?>
										<div class="user-block">

											<img class="img-circle img-bordered-sm" src="{{url($user->foto)}}" >
											<span class="username">
												<a href="#">{{$user->name}}</a>
												<a href="#" class="pull-right btn-box-tool text-red">
													<i class="fa fa-remove"></i> Remove
												</a>
												<a href="#" class="pull-right btn-box-tool text-green" data-toggle="modal" data-target="#modal-default" onclick="getMasuk('{{$user->id}}')" >
													<i class="fa fa-edit"></i> Edit Schedule
												</a>
												@if(Auth::user()->jabatan == 1 || Auth::user()->jabatan == 5) 
												<a href="#" class="pull-right btn-box-tool text-yellow" data-toggle="modal" data-target="#modal-profile" onclick="getProfile('{{$user->id}}')" >
													<i class="fa fa-edit"></i> Edit Profile
												</a>
												@endif
											</span>
											@if($user->condition == "on")
												@foreach($waktu_absen as $absen)
													@if($absen->id_user == $user->id)
														<?php 
															$jam=$absen->jam;
															$originalDate = $absen->tanggal;
															$tanggal = date("d/m/Y", strtotime($originalDate));
														?>
													@endif
												@endforeach
												<span class="description"><small class="label label-success">Onwork</small> Last Absent {{$jam}} - {{$tanggal}}</span>
											@else
												<span class="description"><small class="label label-danger">Offwork</small> </span>
											@endif
											<span class="description"><small class="label label-info">Work On {{$presents_timing[$user->present_timing - 1]->on_time}}</small> </span>
										</div>
									@endif
								@endforeach
							</div>
						</div>
						@endforeach
					</div>
					@if(session('status'))
						<div class="alert alert-success alert-dismissible" style="margin-top: 150px;margin-right: 10px; position:fixed; top:0; right:0; width:300px;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h4>
								<i class="icon fa fa-check"></i> Success!
							</h4>
							Change time for {{session('status')}} success.
						</div>
					@endif
				</div>
			</div>
		</div>
	</section>
	<div class="modal fade in" id="modal-default"  tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<form method="GET" action="{{url('setMasuk')}}">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Edit Work Hours Or Shifing</h4>
					</div>
					<div class="modal-body">
						<p id="nameMasuk"></p>
						<div class="row">
							<label for="shifting" class="col-md-3 control-label">Shifting</label>
							<div class="col-md-9">
								<div class="form-group">
									<select name="shifting" class="form-control" id="shiftingEdit">
										<option value="0">NON SHIFTING</option>
										<option value="1">SHIFTING</option>
									</select>                                    
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Before</label>
									<input id="beforeMasuk" class="form-control" placeholder="Enter ..." disabled="" type="text">
								</div>
							</div>
							<div class="col-md-6">
								<input id="userID" type="hidden" name="id" value="">
								<div class="bootstrap-timepicker">
									<div class="form-group">
										<label>After</label>

										<div class="input-group">
											<input type="text" class="form-control timepicker" name="masuk" id="afterEdit">

											<div class="input-group-addon">
												<i class="fa fa-clock-o"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="modal fade in" id="modal-profile"  tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<form class="form-horizontal" method="POST" action="{{url('editProfile')}}">
				<input type="hidden" name="id" id="id_user">
				{!! csrf_field() !!}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Edit Profile</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="name" class="col-md-3 control-label">Name</label>
							<div class="col-md-9">
								<input id="name" type="text" class="form-control" name="name" value="" required autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-md-3 control-label">E-Mail Address</label>

							<div class="col-md-9">
								<input id="email" type="email" class="form-control" name="email" required>
							</div>
						</div>
						<div class="form-group">
							<label for="location" class="col-md-3 control-label">Jabatan</label>
							<div class="col-md-9">
								<select id="privilege" name="jabatan" class="form-control" id="jabatan">
									@foreach($privileges as $privilege)
										<option value="{{$privilege->id}}">{{$privilege->privilege_name}}</option>
									@endforeach
								</select>                                    
							</div>
						</div>
						<!-- <div class="form-group">
							<label for="shifting" class="col-md-3 control-label">Shifting</label>
							<div class="col-md-9">
								<select name="shifting" class="form-control">
										<option disabled="disabled" selected="selected">Choose One</option>
										<option value="0">NON SHIFTING</option>
										<option value="1">SHIFTING</option>
								</select>                                    
							</div>
						</div> -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" >Save changes</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="modal fade in" id="modal-adduser"  tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<form class="form-horizontal" method="POST" action="{{url('addUser')}}" enctype="multipart/form-data">
			 {!! csrf_field() !!}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Create New User</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="name" class="col-md-3 control-label">Name</label>
							<div class="col-md-8">
								<input id="name" type="text" class="form-control" name="name" required autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="nickname" class="col-md-3 control-label">Nickname</label>
							<div class="col-md-8">
								<input id="nickname" type="text" class="form-control" name="nickname" required autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-md-3 control-label">E-Mail Address</label>
							<div class="col-md-8">
								<input id="email" type="email" class="form-control" name="email" required autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-md-3 control-label">Password</label>
							<div class="col-md-8">
								<input id="email" type="Password" class="form-control" name="password" required autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-md-3 control-label">Re-type Password</label>
							<div class="col-md-8">
								<input id="email" type="Password" class="form-control" name="re-password" required>
							</div>
						</div>
						<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
							<label for="location" class="col-md-3 control-label">Location</label>
							<div class="col-md-8">
								<select id="lokasi"  name="location" class="form-control">
									@foreach($location as $loc)
										<option value="{{$loc->id}}">{{$loc->name}}</option>
									@endforeach
								</select>                                    
							</div>
						</div>
						<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
							<label for="location" class="col-md-3 control-label">Team</label>
							<div class="col-md-8">
								<select id="lokasi"  name="team" class="form-control">
									<option value="MSM">MSM</option>
									<option value="DPG">DPG</option>
								</select>                                    
							</div>
						</div>
						<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
							<label for="location" class="col-md-3 control-label">Jabatan</label>
							<div class="col-md-8">
								<select id="lokasi"  name="jabatan" class="form-control">
									@foreach($privileges as $privilege)
										<option value="{{$privilege->id}}">{{$privilege->privilege_name}}</option>
									@endforeach
								</select>                                    
							</div>
						</div>
						<div class="form-group">
							<label for="gender" class="col-md-3 control-label">Gender</label>
							<div class="col-md-8">
								<select id="gender"  name="gender" class="form-control">
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>                                    
							</div>
						</div>
						<div class="form-group">
							<label for="born" class="col-md-3 control-label">Place, Date of Birth</label>
							<div class="col-md-8">
								<input id="born" type="text" class="form-control" name="born">
							</div>
						</div>
						<div class="form-group">
							<label for="education" class="col-md-3 control-label">Education</label>
							<div class="col-md-8">
								<input id="education" type="text" class="form-control" name="education">
							</div>
						</div>
						<div class="form-group">
							<label for="phone" class="col-md-3 control-label">Phone</label>
							<div class="col-md-8">
								<input id="phone" type="text" class="form-control" name="phone">
							</div>
						</div>
						<div class="form-group">
							<label for="address" class="col-md-3 control-label">Address</label>
							<div class="col-md-8">
								<input id="address" type="text" class="form-control" name="address">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" >Adduser</button>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{ url('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

<script type="text/javascript">
	$(".timepicker").timepicker({
		showInputs: false,
		minuteStep: 1,
		maxHours: 24,
		showMeridian: false,
		showSeconds:true,
	});
	function getMasuk(id){
		// console.log(id);
		$.ajax({
			type: "GET",
			url: "{{url('/usermanage/getMasuk/')}}/" + id,
			success: function(result){
				// console.log(result[0]["id"]);
				$("#nameMasuk").text("Change work hours for " + result[1]);
				$("#beforeMasuk").attr("placeholder",result[2]);
				$("#userID").val(result[0]);
				$("#shiftingEdit option[value='" + result[3] + "']").attr("selected",true);
				$("#afterEdit option[value='" + result[4] + "']").attr("selected",true);
				if(result[3] == 0){
					$("#afterEdit").prop('disabled', false)
				} else {
					$("#afterEdit").prop('disabled', 'disabled')
				}
			},
		});
	};

	function getProfile(id){
		console.log(id);
		$.ajax({
			type: "GET",
			url: "{{url('/usermanage/getProfile')}}/" + id,
			success: function(result){
				// console.log(result[0]["id"]);
				$("#id_user").val(id);
				$("#name").val(result[0]["name"]);
				$("#email").val(result[0]["email"]);
				$("#privilege").val(result[0]["jabatan"]);
			},
		});
	};

</script>
@endsection