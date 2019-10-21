<!DOCTYPE html> 
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>IMOGY </title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		
		<link href="{{url('img/imoicon.png')}}" rel="icon" type="image/x-icon">
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
		@yield('head')
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.0/css/AdminLTE.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.0/css/skins/_all-skins.min.css">
		
		<style type="text/css">
			.switch {
				position: relative;
				display: inline-block;
				width: 60px;
				height: 34px;
			}
			.switch input {display:none;}
			.slider {
				position: absolute;
				cursor: pointer;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				background-color: #ccc;
				-webkit-transition: .4s;
				transition: .4s;
			}
			.slider:before {
				position: absolute;
				content: "";
				height: 26px;
				width: 26px;
				left: 4px;
				bottom: 4px;
				background-color: white;
				-webkit-transition: .4s;
				transition: .4s;
			}
			input:checked + .slider {
				background-color: #2196F3;
			}
			input:focus + .slider {
				box-shadow: 0 0 1px #2196F3;
			}
			input:checked + .slider:before {
				-webkit-transform: translateX(26px);
				-ms-transform: translateX(26px);
				transform: translateX(26px);
			}
			.slider.round {
				border-radius: 34px;
			}
			.slider.round:before {
				border-radius: 50%;
			}
		</style>
	</head>
	@if(isset($sidebar_collapse))
	<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
	@else
	<body class="hold-transition skin-blue sidebar-mini">
	@endif
		<div class="wrapper">

			<header class="main-header">
				<a href="{{url('admin')}}" class="logo"  style="background-color: #2b4e62">
					<span class="logo-mini"><img src="{{url('img/iconwhitek.png')}}" style="padding:5px;width: 45px; height: 45px;"></span>
					<span class="logo-lg" style="background-color: #2b4e62"><img src="{{url('img/bar.png')}}" width="70px" align="center"></span>
				</a>
				<nav class="navbar navbar-static-top" style=" background-color: #2b4e62">
					<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>

					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									@if(Auth::user()->foto == "0")
										<img src="{{url('img/no-image.png')}}" class="user-image" alt="User Image">
									@else
										<img src="{{url(Auth::user()->foto)}}" class="user-image" alt="User Image">
									@endif
									<span class="hidden-xs">{{Auth::user()->name}}</span>
								</a>
								<ul class="dropdown-menu">
									<li class="user-header" style="background-color:#222d32">
										@if(Auth::user()->foto == "0")
											<img src="{{url('img/no-image.png')}}" class="img-circle" alt="User Image">
										@else
											<img src="{{url(Auth::user()->foto)}}" class="img-circle" alt="User Image">
										@endif

										<p>
											{{Auth::user()->name}} 
											<small><i class="fa fa-circle text-success"></i> Super Users</small>
										</p>
									</li>
									
									<li class="user-footer">
										@if(Auth::user()->id != 4)
											<div class="pull-left">
												<a href="{{ url('profile')}}" class="btn btn-default btn-flat">Profile</a>
											</div>
										@else
											<div class="pull-left">
												@if(isset($debug))
													<a href="{{ url('debugMode')}}" class="btn btn-danger btn-flat">Active</a>
												@else
													<a href="{{ url('debugMode')}}" class="btn btn-success btn-flat">Passive</a>
												@endif
											</div>
										@endif
										
										<div class="pull-right">
											<a class="btn btn-default btn-flat"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
												{{ csrf_field() }}
											</form>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>

			<aside class="main-sidebar">
				<section class="sidebar">
					<div class="user-panel">
						<a href="{{ url('profile')}}" class="pull-left image">
							@if(Auth::user()->foto == "0")
								<img src="{{url('img/no-image.png')}}" class="img-circle" alt="User Image">
							@else
								<img src="{{url(Auth::user()->foto)}}" class="img-circle" alt="User Image">
							@endif
						</a>
						<div class="pull-left info">
							<p>{{Auth::user()->name}}</p>
								<small><i class="fa fa-circle text-success"> </i>  Super Users</small>					
						</div>
					</div>
					
					<ul class="sidebar-menu" data-widget="tree">
						<li class="header" onclick="url()">
							Main Menu
						</li>
						<li class="activeable" id="dashboard">
							<a href="{{ url('/admin') }}">
								<i class="fa fa-dashboard"></i> <span>Dashboard</span>
							</a>
						</li>
						<li class="activeable" id="absen">
							<a href="{{ url('absen')}}">
								<i class="fa fa-clock-o"></i>
								<span>AOGY</span>
							</a>
						</li>
						<li class="activeable" id="tisygy">
							<a href="{{ url('tisygy')}}">
								<i class="fa fa-paper-plane"></i>
								<span>TISYGY</span>
							</a>
						</li>
						<li class="activeable" id="usermanage">
							<a href="{{ url('usermanage')}}">
								<i class="fa fa-users"></i>
								<span>Users Management</span>
							</a>
						</li>
						<li class="activeable" id="schedule">
							<a href="{{ url('schedule')}}">
								<i class="fa fa-flag-o"></i>
								<span>Shifting Schedule</span>
							</a>
						</li>
						<li class="activeable" id="location">
							<a href="{{ url('location')}}">
								<i class="fa fa-location-arrow"></i>
								<span>Set Absent Location</span>
							</a>
						</li>
						<li class="activeable treeview" id="project">
							<a href="#">
								<i class="fa fa-calendar"></i>
								<span>WINDA</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li>
									<a href="{{ url('project')}}">Overview</a>
								</li>
								<li>
									<a href="{{ url('project/manage')}}">Manage</a>
								</li>
								<li>
									<a href="{{ url('project/archive')}}">Archive</a>
								</li>
								<li>
									<a href="{{ url('project/setting')}}">Setting</a>
								</li>
							</ul>
						</li>
						<li class="activeable" id="logphone">
							<a href="{{url ('logphone')}}">
								<i class="fa fa-book"></i>
								<span>Log Phone</span>
							</a>
						</li>
					</ul>
				</section>
			</aside>

			@yield('content')
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="{{ url('dist/js/adminlte.min.js')}}"></script>


		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script> -->
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/locale/id.js"></script> -->

		<!-- <script src="{{ url('plugins/daterangepicker/daterangepicker.js')}}"></script>
		<script src="{{ url('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
		
		<script src="{{ url('plugins/morris/morris.min.js')}}"></script>
		<script src="{{ url('plugins/sparkline/jquery.sparkline.min.js')}}"></script>
		<script src="{{ url('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
		<script src="{{ url('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
		<script src="{{ url('plugins/knob/jquery.knob.js')}}"></script>
		<script src="{{ url('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
		<script src="{{ url('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
		<script src="{{ url('plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{ url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
		<script src="{{ url('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
		<script src="{{ url('plugins/chartjs/Chart.min.js')}}"></script>
		<script src="{{ url('plugins/fastclick/fastclick.js')}}"></script>
		<script src="{{ url('js/jquery-ui.min.js')}}"></script>
		<script src="{{ url('js/fullcalendar.min.js')}}"></script> -->

		<!-- <script src="{{ url('dist/js/demo.js')}}"></script> -->

		<script type="text/javascript">
			$(".activeable").has('a[href="' + location.protocol + '//' + location.host + location.pathname + '"]').addClass('active')
		</script>
	@yield('script')
	</body>
</html>
