@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')
@section('head')
	
@endsection
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<img src="img/tisygy.png" width="120" height="35">
			<small style="font-family: 'Montserrat', sans-serif;text-decoration: bold;">Ticketing Control</small>
		</h1>
	</section>

	<section class="content">

		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs" style="font-family: 'Montserrat', sans-serif;text-decoration: bold;">
						<li><a href="#tab_1" data-toggle="tab">Dashboard</a></li>
						<li><a href="#tab_2" data-toggle="tab">Project</a></li>
						<li class="active"><a href="#tab_3" data-toggle="tab">Person</a></li>
						<li><a href="#tab_4" data-toggle="tab">Mountly</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane" id="tab_1">
							<h1>Dashboard</h1>
						</div>

						<div class="tab-pane" id="tab_2">
							<h1>Project</h1>
						</div>
						<div class="tab-pane active" id="tab_3">
							<!-- <h1>Person</h1> -->
							<div class="row">
								
									<div class="col-md-3">
										<div class="box box-primary">
											<div class="box-body box-profile">
												<img class="profile-user-img img-responsive img-circle" src="img/Nila.jpg" alt="User profile picture">
												<h3 class="profile-username text-center">Nila Marsela</h3>
												<p class="text-muted text-center">Helpdesk Center</p>
												<ul class="list-group list-group-unbordered">
													<li class="list-group-item">
														<b>Open</b> <a class="pull-right">10</a>
													</li>
													<li class="list-group-item">
														<b>Close</b> <a class="pull-right">20</a>
													</li>
													<li class="list-group-item">
														<b>Pending</b> <a class="pull-right">13</a>
													</li>
												</ul>
												<a href="#" class="btn btn-primary btn-block"><b>Detail</b></a>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="box box-primary">
											<div class="box-body box-profile">
												<img class="profile-user-img img-responsive img-circle" src="img/Paul.jpg" alt="User profile picture">
												<h3 class="profile-username text-center">Yoh Paulus</h3>
												<p class="text-muted text-center">Helpdesk Center</p>
												<ul class="list-group list-group-unbordered">
													<li class="list-group-item">
														<b>Open</b> <a class="pull-right">10</a>
													</li>
													<li class="list-group-item">
														<b>Close</b> <a class="pull-right">20</a>
													</li>
													<li class="list-group-item">
														<b>Pending</b> <a class="pull-right">13</a>
													</li>
												</ul>
												<a href="#" class="btn btn-primary btn-block"><b>Detail</b></a>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="box box-primary">
											<div class="box-body box-profile">
												<img class="profile-user-img img-responsive img-circle" src="img/Wisnu.jpg" alt="User profile picture">
												<h3 class="profile-username text-center">Wisnu Darman</h3>
												<p class="text-muted text-center">Project Admin</p>
												<ul class="list-group list-group-unbordered">
													<li class="list-group-item">
														<b>Open</b> <a class="pull-right">10</a>
													</li>
													<li class="list-group-item">
														<b>Close</b> <a class="pull-right">20</a>
													</li>
													<li class="list-group-item">
														<b>Pending</b> <a class="pull-right">13</a>
													</li>
												</ul>
												<a href="#" class="btn btn-primary btn-block"><b>Detail</b></a>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="box box-primary">
											<div class="box-body box-profile">
												<img class="profile-user-img img-responsive img-circle" src="img/Yefta.JPG" alt="User profile picture">
												<h3 class="profile-username text-center">Yefta Satria</h3>
												<p class="text-muted text-center">Helpdesk Center</p>
												<ul class="list-group list-group-unbordered">
													<li class="list-group-item">
														<b>Open</b> <a class="pull-right">10</a>
													</li>
													<li class="list-group-item">
														<b>Close</b> <a class="pull-right">20</a>
													</li>
													<li class="list-group-item">
														<b>Pending</b> <a class="pull-right">13</a>
													</li>
												</ul>
												<a href="#" class="btn btn-primary btn-block"><b>Detail</b></a>
											</div>
										</div>
									</div>
							</div>
							<div class="row">
									<div class="col-md-3">
										<div class="box box-primary">
											<div class="box-body box-profile">
												<img class="profile-user-img img-responsive img-circle" src="img/Hisyam.jpg" alt="User profile picture">
												<h3 class="profile-username text-center">Achmad Hisyam</h3>
												<p class="text-muted text-center">Technical Support</p>
												<ul class="list-group list-group-unbordered">
													<li class="list-group-item">
														<b>Open</b> <a class="pull-right">10</a>
													</li>
													<li class="list-group-item">
														<b>Close</b> <a class="pull-right">20</a>
													</li>
													<li class="list-group-item">
														<b>Pending</b> <a class="pull-right">13</a>
													</li>
													
												</ul>
												<a href="#" class="btn btn-primary btn-block"><b>Detail</b></a>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="box box-primary">
											<div class="box-body box-profile">
												<img class="profile-user-img img-responsive img-circle" src="img/Yuni.jpg" alt="User profile picture">
												<h3 class="profile-username text-center">Yuni Firnita</h3>
												<p class="text-muted text-center">Admin MSM</p>
												<ul class="list-group list-group-unbordered">
													<li class="list-group-item">
														<b>Open</b> <a class="pull-right">10</a>
													</li>
													<li class="list-group-item">
														<b>Close</b> <a class="pull-right">20</a>
													</li>
													<li class="list-group-item">
														<b>Pending</b> <a class="pull-right">13</a>
													</li>
													
												</ul>
												<a href="#" class="btn btn-primary btn-block"><b>Detail</b></a>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="box box-primary">
											<div class="box-body box-profile">
												<img class="profile-user-img img-responsive img-circle" src="img/Rama.jpg" alt="User profile picture">
												<h3 class="profile-username text-center">Rama Agastya</h3>
												<p class="text-muted text-center">Manager MSM</p>
												<ul class="list-group list-group-unbordered">
													<li class="list-group-item">
														<b>Open</b> <a class="pull-right">10</a>
													</li>
													<li class="list-group-item">
														<b>Close</b> <a class="pull-right">20</a>
													</li>
													<li class="list-group-item">
														<b>Pending</b> <a class="pull-right">13</a>
													</li>
													
												</ul>
												<a href="#" class="btn btn-primary btn-block"><b>Detail</b></a>
											</div>
										</div>
									</div>

									<div class="col-md-3">
										<div class="box box-primary">
											<div class="box-body box-profile">
												<img class="profile-user-img img-responsive img-circle" src="img/Siwi.jpg" alt="User profile picture">
												<h3 class="profile-username text-center">Siwi Karuniawati</h3>
												<p class="text-muted text-center">Vice Precident</p>
												<ul class="list-group list-group-unbordered">
													<li class="list-group-item">
														<b>Open</b> <a class="pull-right">10</a>
													</li>
													<li class="list-group-item">
														<b>Close</b> <a class="pull-right">20</a>
													</li>
													<li class="list-group-item">
														<b>Pending</b> <a class="pull-right">13</a>
													</li>
													
												</ul>
												<a href="#" class="btn btn-primary btn-block"><b>Detail</b></a>
											</div>
										</div>
									</div>
								
							</div>
						</div>
						<div class="tab-pane" id="tab_4">
							<h1>Mountly</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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

@endsection