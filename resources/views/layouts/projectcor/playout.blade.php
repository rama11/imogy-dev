<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>IMOGY </title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		
		<link href="{{url('img/imoicon.png')}}" rel="icon" type="image/x-icon">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
		
		<link rel="stylesheet" href="{{url('bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}">
		<link rel="stylesheet" href="{{url('dist/css/skins/_all-skins.min.css')}}">
		@yield('head')
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
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
												<small><i class="fa fa-circle text-success"></i> Project Cordinator</small>
										</p>
									</li>
									
									<li class="user-footer">
										<div class="pull-left">
											<a href="{{ url('profile')}}" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
											<a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
												Logout
											</a>
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
								<small><i class="fa fa-circle text-success"></i> Project Cordinator</small>
						</div>
					</div>
					<ul class="sidebar-menu" data-widget="tree">
						<li class="header" onclick="url()">
							Main Menu
						</li>
						<li class="" id="dashboard">
							<a href="{{ url('/admin')}}">
								<i class="fa fa-dashboard"></i> <span>Dashboard</span>
							</a>
						</li>
						<li class="" id="absen">
							<a href="{{ url('absen')}}">
								<i class="fa fa-clock-o"></i>
								<span>AOGY</span>
							</a>
						</li>
						<li class="" id="atisygy">
							<a href="{{ url('/tisygy')}}">
								<i class="fa fa-paper-plane"></i>
								<span>TISYGY</span>
							</a>
						</li>
						<!-- <li class="" id="usermanage">
							<a href="{{ url('usermanage')}}">
								<i class="fa fa-users"></i>
								<span>Users Management</span>
							</a>
						</li>
						<li class="" id="schedule">
							<a href="{{ url('schedule')}}">
								<i class="fa fa-flag-o"></i>
								<span>Shifting Schedule</span>
							</a>
						</li>
						<li class="" id="location">
							<a href="{{ url('location')}}">
								<i class="fa fa-location-arrow"></i>
								<span>Set Absent Location</span>
							</a>
						</li> -->
						<li class="" id="project">
							<a href="{{ url('project/manage')}}">
								<i class="fa fa-calendar"></i>
								<span>Project Manage</span>
							</a>
						</li>
					</ul>
				</section>
			</aside>
<<<<<<< HEAD
			@yield('content')
		</div>
		
		<script src="{{url('plugins/jQuery/jquery-3.1.1.min.js')}}"></script>
		<script src="{{url('bootstrap/js/bootstrap.min.js')}}"></script>
		<script src="{{url('dist/js/adminlte.min.js')}}"></script>
=======

			@yield('content')
			
		</div>
		<script src="{{ url('plugins/jQuery/jquery-3.1.1.min.js')}}"></script>
		<script src="{{ url('bootstrap/js/bootstrap.min.js')}}"></script>
		<script src="{{ url('dist/js/adminlte.min.js')}}"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/locale/id.js"></script>

		<script src="{{ url('plugins/morris/morris.min.js')}}"></script>
		<script src="{{ url('plugins/sparkline/jquery.sparkline.min.js')}}"></script>
		<script src="{{ url('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
		<script src="{{ url('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
		<script src="{{ url('plugins/knob/jquery.knob.js')}}"></script>
		<script src="{{ url('plugins/daterangepicker/daterangepicker.js')}}"></script>
		<script src="{{ url('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
		<script src="{{ url('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
		<script src="{{ url('plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{ url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
		<script src="{{ url('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
		<script src="{{ url('plugins/chartjs/Chart.min.js')}}"></script>
		<script src="{{ url('plugins/fastclick/fastclick.js')}}"></script>
		<script src="{{ url('dist/js/demo.js')}}"></script>
		<script src="{{ url('js/jquery-ui.min.js')}}"></script>
		<script src="{{ url('js/fullcalendar.min.js')}}"></script>

>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d

		<script type="text/javascript">
			$(document).ready(function(){
				var path = (document.URL).split("/");
<<<<<<< HEAD
				switch((document.URL).split("/")[(document.URL).split("/").length - 1]) {
=======
				switch(path[path.length - 1]) {
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
					case "admin":
						$("#dashboard").addClass("active");
						$("#absen").removeClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").removeClass("active");
						$("#location").removeClass("active");
<<<<<<< HEAD
						$("#project").removeClass("active");
						console.log("admin");
						break;

=======
						$("#schedule#").removeClass("active");
						$("#project").removeClass("active");
						console.log("admin");
						break;
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
					case "absen":
						$("#dashboard").removeClass("active");
						$("#absen").addClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").removeClass("active");
						$("#location").removeClass("active");
<<<<<<< HEAD
						$("#project").removeClass("active");
						console.log("absen");
						break;

=======
						$("#schedule#").removeClass("active");
						$("#project").removeClass("active");
						console.log("absen");
						break;
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
					case "ahistory":
						$("#dashboard").removeClass("active");
						$("#absen").addClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").removeClass("active");
						$("#location").removeClass("active");
<<<<<<< HEAD
						$("#project").removeClass("active");
						console.log("ahistory");
						break;

=======
						$("#schedule#").removeClass("active");
						$("#project").removeClass("active");
						console.log("ahistory");
						break;
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
					case "ateamhistory":
						$("#dashboard").removeClass("active");
						$("#absen").addClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").removeClass("active");
						$("#location").removeClass("active");
<<<<<<< HEAD
						$("#project").removeClass("active");
						console.log("ateamhistory");
						break;

=======
						$("#schedule#").removeClass("active");
						$("#project").removeClass("active");
						console.log("ateamhistory");
						break;
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
					case "areport":
						$("#dashboard").removeClass("active");
						$("#absen").addClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").removeClass("active");
						$("#location").removeClass("active");
<<<<<<< HEAD
						$("#project").removeClass("active");
						console.log("location");
						break;

=======
						$("#schedule#").removeClass("active");
						$("#project").removeClass("active");
						console.log("location");
						break;
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
					case "tisygy":
						$("#dashboard").removeClass("active");
						$("#absen").removeClass("active");
						$("#tisygy").addClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").removeClass("active");
						$("#location").removeClass("active");
<<<<<<< HEAD
=======
						$("#schedule#").removeClass("active");
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
						$("#project").removeClass("active");
						console.log("tisygy");
						break;
						
					case "usermanage":
						$("#dashboard").removeClass("active");
						$("#absen").removeClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").addClass("active");
						$("#schedule").removeClass("active");
						$("#location").removeClass("active");
<<<<<<< HEAD
=======
						$("#schedule#").removeClass("active");
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
						$("#project").removeClass("active");
						console.log("usermanage");
						break;
					
					case "schedule":
						$("#dashboard").removeClass("active");
						$("#absen").removeClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").addClass("active");
						$("#location").removeClass("active");
<<<<<<< HEAD
						$("#project").removeClass("active");
						console.log("schedule");
						break;

=======
						$("#schedule#").removeClass("active");
						$("#project").removeClass("active");
						console.log("schedule");
						break;
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
					case "location":
						$("#dashboard").removeClass("active");
						$("#absen").removeClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").removeClass("active");
						$("#location").addClass("active");
<<<<<<< HEAD
						$("#project").removeClass("active");
						console.log("location");
						break;

					case "manage":
=======
						$("#schedule#").removeClass("active");
						$("#project").removeClass("active");
						console.log("location");
						break;
					case "schedule#":
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
						$("#dashboard").removeClass("active");
						$("#absen").removeClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").removeClass("active");
						$("#location").removeClass("active");
<<<<<<< HEAD
						$("#project").addClass("active");
						console.log("location");
						break;

					case "project":
=======
						$("#schedule#").addClass("active");
						$("#project").removeClass("active");
						console.log("location");
						break;
					case "manage":
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
						$("#dashboard").removeClass("active");
						$("#absen").removeClass("active");
						$("#tisygy").removeClass("active");
						$("#usermanage").removeClass("active");
						$("#schedule").removeClass("active");
						$("#location").removeClass("active");
						$("#project").addClass("active");
						console.log("location");
<<<<<<< HEAD
						break;
															
=======
						break;				
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
					default:
						$("#dashboard").addClass("active");
				};
				// console.log(path[path.length - 1]);
			});
		</script>
<<<<<<< HEAD
		@yield('script')
=======
	@yield('script')
>>>>>>> b0bb1b0d5d2ece26a6a6636a47f252c7f331fb4d
	</body>
</html>