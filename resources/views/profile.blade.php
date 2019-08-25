@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')

@section('content')

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header" >
		<h1>
			Profile
		</h1>
	</section>


	<!-- Main content -->
	<section class="content">
		<div class="row">
			
			<div class="col-md-3">

				<!-- Profile Image -->
				<div class="box box-primary">
					<div class="box-body box-profile">
						<img class="profile-user-img img-responsive img-circle" src="{{url(Auth::user()->foto)}}" alt="User profile picture">
						<h3 class="profile-username text-center">
							<p>{{Auth::user()->name}}</p>
						</h3> 
						<p class="text-muted text-center">
						
							@if(Auth::user()->jabatan == 1)
								<small> Admin</small>
							@elseif(Auth::user()->jabatan == 2)
								<small> Helpdesk</small>
							@elseif(Auth::user()->jabatan == 3)
								<small> Engineer</small>
							@endif
						</p>
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item">
								<b>Gender</b> <a class="pull-right">{{Auth::user()->gender}}</a>
							</li>
							<li class="list-group-item">
								<b>Email</b> <a class="pull-right">{{Auth::user()->email}}</a>
							</li>
						</ul>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->

				<!-- About Me Box -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">About Me</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<strong><i class="fa fa-book margin-r-5"></i> Education</strong>
						<p class="text-muted">
							{{Auth::user()->education}} 
						</p>
						<hr>
						<strong><i class="fa fa-map-marker margin-r-5"></i> Born</strong>
						<p class="text-muted">{{Auth::user()->born}}</p>
						<hr>
						<strong><i class="fa fa-flag margin-r-5"></i> Nationality</strong>
						<p class="text-muted">Indonesia</p>
						<hr>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#activity" data-toggle="tab">My Profile</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="activity">
							<section class="invoice">
								<div class="row">
									<div class="col-xs-12">
										<h2 class="page-header">
											<i class="fa fa-user"></i>{{Auth::user()->name}}
											<a href="#" class="pull-right btn-box-tool text-yellow" data-toggle="modal" data-target="#modal-password")" ><i class="fa fa-key"></i> Change Password</a>
											<a href="#" class="pull-right btn-box-tool text-blue" data-toggle="modal" data-target="#modal-profile")" ><i class="fa fa-edit"></i> Edit Profile</a>

										</h2>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 table-responsive">
										<table class="table table-striped">
											<tbody>
												<tr>
													<td><b>Name</b></td>
													<td>{{Auth::user()->name}}</td>
												</tr>
												<tr>
													<td><b>Date Of Birth</b></td>
													<td>{{Auth::user()->born}}</td>
												</tr>
												<tr>
													<td><b>Position</b></td>
													<td>
														@if(Auth::user()->jabatan == 1)
															<small> Admin</small>
														@elseif(Auth::user()->jabatan == 2)
															<small> Helpdesk</small>
														@elseif(Auth::user()->jabatan == 3)
															<small> Engineer</small>
														@endif
													
													</td>
												</tr>
												<tr>
													<td><b>Phone</b></td>
													<td>{{Auth::user()->phone}}</td>
												</tr>
												<tr>
													<td><b>Divison</b></td>
													<td>{{Auth::user()->team}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row invoice-info ">
									<div class="col-sm-12 invoice-col">
										<b>Company</b>
										<address>
											<b class="text-info">Sinergy Informasi Pratama</b><br>
											| Jl. Puri Raya, Blok A 2/3 No. 33-35 | Puri Indah |<br>
											| Kembangan | Jakarta 11610 – Indonesia |<br>
											| info@sinergy.co.id | helpdesk@sinergy.co.id |
										</address>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<img src="img/header.jpg" width="500px">
									</div>
								</div>
							</section>
						</div>
					</div>

					@if(session('success'))
						<div class="alert alert-success alert-dismissible" style="margin-top: 150px;margin-right: 10px; position:fixed; top:0; right:0; width:300px;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h4>
								<i class="icon fa fa-check"></i> Success!
							</h4>
							{{session('success')}}
						</div>
					@endif
					@if(session('error'))
						<div class="alert alert-error alert-dismissible" style="margin-top: 150px;margin-right: 10px; position:fixed; top:0; right:0; width:300px;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h4>
								<i class="icon fa fa-check"></i> Error!
							</h4>
							{{session('error')}}
						</div>
					@endif

				</div>
			</div>

			<div class="modal fade in" id="modal-profile"  tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" action="{{url('editUser')}}" enctype="multipart/form-data">
							<input type="hidden" name="id" value="{{Auth::user()->id}}">
							{!! csrf_field() !!}
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
								<h4 class="modal-title">Edit Profile</h4>
							</div>
							<div class="modal-body">
								
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control" name="name" value="{{Auth::user()->name}}" >
								</div>

								<div class="form-group">
									<label>E-Mail Address</label>
									<input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
								</div>

								<div class="form-group">
									<label>Gender</label>
									<select name="gender" class="form-control">
										<option value="Male" @if(Auth::user()->gender == "Male") selected="selected" @endif>Male</option>
										<option value="Female" @if(Auth::user()->gender == "Female") selected="selected" @endif>Female</option>
									</select>                                    
								</div>

								<div class="form-group">
									<label>Place, Date of Birth</label>
									<input type="text" class="form-control" name="born" value="{{Auth::user()->born}}" >
								</div>

								<div class="form-group">
									<label>Education</label>
									<input type="text" class="form-control" name="education" value="{{Auth::user()->education}}" >
								</div>

								<div class="form-group">
									<label>Phone</label>
									<input type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}" >
								</div>

								<div class="form-group">
									<label>Address</label>
									<input type="text" class="form-control" name="address" value="{{Auth::user()->address}}" >
								</div>

								<div class="form-group">
									<label>Photo</label>
									<input type="file" name="gambar">
									<p class="help-block">Only .jpg .jpeg and .png are allowed</p>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary" >Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="modal fade in" id="modal-password"  tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<form method="POST" action="{{url('changePasswords')}}">
						<input type="hidden" name="id" value="{{Auth::user()->id}}">
						 {!! csrf_field() !!}
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
								<h4 class="modal-title">Change Password</h4>
							</div>
							<div class="modal-body">
								<p id="nameMasuk"></p>
								<div class="form-group">
									<label class="col-md-4 control-label">Old Password</label>
									<div class="col-md-6">
										<input type="password" id="password" class="form-control" name="old"  data-toggle="password" placeholder="Old Password" required>
									</div>
								</div>
								<br>
								<br>
								<div class="form-group">
									<label class="col-md-4 control-label">New Password</label>
									<div class="col-md-6">
										<input type="password" class="form-control" name="pass"  data-toggle="password" placeholder="New Password" required>
									</div>
								</div>
								<br>
								<br>
								<div class="form-group">
									<label class="col-md-4 control-label">Re New Password</label>
									<div class="col-md-6">
										<input type="password" class="form-control" name="repass" placeholder="Re New Password" data-toggle="password" required>
									</div>
								</div>
								<br>
								<br>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary" >Save changes</button>
							</div>
						</div>
					</form>
				</div>
			</div>


		</div>
	</section>
</div>
@endsection