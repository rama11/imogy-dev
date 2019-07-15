@extends('layouts.engineer.elayout') 
@section('content')
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
						<img class="profile-user-img img-responsive img-circle" src="img/denny.jpeg" alt="User profile picture">

						<h3 class="profile-username text-center"><p>{{Auth::user()->name}}</p></h3> 

						<p class="text-muted text-center">Manager MSM</p>

						<ul class="list-group list-group-unbordered">
							<li class="list-group-item">
								<b>Gender</b> <a class="pull-right">{{Auth::user()->gender}}</a>
							</li>
							<li class="list-group-item">
								<b>Age</b> <a class="pull-right">17</a>
							</li>
							<li class="list-group-item">
								<b>Email</b> <a class="pull-right">endraw@sinergy.co.id</a>
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
							S2 Binus University 
						</p>

						<hr>

						<strong><i class="fa fa-map-marker margin-r-5"></i> Born</strong>

						<p class="text-muted">Palembang, 24 September 1989</p>

						<hr>

						<strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

						<p>
							<span class="label label-danger">UI Design</span>
							<span class="label label-success">Coding</span>
							<span class="label label-info">Javascript</span>
							<span class="label label-warning">PHP</span>
							<span class="label label-primary">Node.js</span>
						</p>

						<hr>

						<strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

						<p>Cinta Ini Membunuhku</p>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#activity" data-toggle="tab">My Profile</a></li>

					</ul>


					<div class="tab-content">
						<div class="active tab-pane" id="activity">
							<!-- Post -->
							<section class="invoice">
								<!-- title row -->
								<div class="row">
									<div class="col-xs-12">
										<h2 class="page-header">
											<i class="fa fa-user"></i>&nbsp{{Auth::user()->name}}<a href="#" class="pull-right btn-box-tool text-blue" data-toggle="modal" data-target="#modal-profile")" ><i class="fa fa-edit"></i> Edit Profile</a>

										</h2>
									</div>
									<!-- /.col -->
								</div>
								<!-- info row -->

								<!-- /.col -->

								<!-- /.row -->

								<!-- Table row -->
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

													<td><b>Title</b></td>

													<td>{{Auth::user()->jabatan}}</td>

												</tr>
												<tr>

													<td><b>Phone</b></td>

													<td>{{Auth::user()->phone}}</td>

												</tr>
												<tr>

													<td><b>Divison</b></td>

													<td>{{Auth::user()->role}}</td>

												</tr>


											</tbody>
										</table>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->



								<!-- /.col -->
								<div class="row invoice-info ">
									<div class="col-sm-12 invoice-col">
										<b>Company</b>
										<address>
											<b class="text-info">Sinergy Informasi Pratama</b><br>




											| Inlingua Building 2nd Floor |<br>
											| Jl. Puri Raya, Blok A 2/3 No. 33-35 | Puri Indah |<br>
											| Kembangan | Jakarta 11610 – Indonesia |<br>
											| info@sinergy.co.id | helpdesk@sinergy.co.id |
										</address>
									</div>
									<div class="row">
										<!-- accepted payments column -->
										<div class="col-xs-6">
											<img src="img/header.jpg" width="500px">

										</div>

										<!-- /.row -->

										<!-- this row will not appear when printing -->


										<!-- /.row -->
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
																		<input id="name" type="text" class="form-control" name="name" value="{{Auth::user()->name}}" required autofocus>
																	</div>
																</div>
																<br><br>
																<div class="form-group">
																	<label for="email" class="col-md-4 control-label">E-Mail Address</label>

																	<div class="col-md-6">
																		<input id="email" type="email" class="form-control" name="email" value="{{Auth::user()->email}}" required>
																	</div>
																</div>
																<br><br>
																<div class="form-group">
																	<label for="gender" class="col-md-4 control-label">Gender</label>
																	<div class="col-md-6">
																		<select id="gender"  name="gender" class="form-control">
																			<option value="Male" <?php if(Auth::user()->gender=="Male"){echo '"selected="selected"';} ?>>Male</option>
																			<option value="Female" <?php if(Auth::user()->gender=="Female"){echo '"selected="selected"';} ?>>Female</option>
																		</select>                                    
																	</div>
																</div>
																<br><br>
																<div class="form-group">
																	<label for="born" class="col-md-4 control-label">Place, Date of Birth</label>
																	<div class="col-md-6">
																		<input id="born" type="text" class="form-control" name="born" value="{{Auth::user()->born}}" required autofocus>
																	</div>
																</div>
																<br><br>
																<div class="form-group">
																	<label for="education" class="col-md-4 control-label">Education</label>
																	<div class="col-md-6">
																		<input id="education" type="text" class="form-control" name="education" value="{{Auth::user()->education}}" required autofocus>
																	</div>
																</div>
																<br><br>
																<div class="form-group">
																	<label for="phone" class="col-md-4 control-label">Phone</label>
																	<div class="col-md-6">
																		<input id="phone" type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}" required autofocus>
																	</div>
																</div>
																<br><br>
																<div class="form-group">
																	<label for="address" class="col-md-4 control-label">Address</label>
																	<div class="col-md-6">
																		<input id="address" type="text" class="form-control" name="address" value="{{Auth::user()->address}}" required autofocus>
																	</div>
																</div>
																<br><br>
																<div class="form-group">
																	<label for="foto" class="col-md-4 control-label">Photo</label>
																	<input id="foto"  type="file" value="{{Auth::user()->foto}}">

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
									</section>
									<!-- /.content -->

								</div>

								@endsection