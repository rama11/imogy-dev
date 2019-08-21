<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>IMOGY </title>
	<link href="img/imoicon.png" rel="icon" type="image/x-icon">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css')}}">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="plugins/morris/morris.css">
	<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="../../plugins/select2/select2.min.css">
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fullcalendar/fullcalendar.min.css')}}">
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fullcalendar/fullcalendar.print.css')}}" media="print">
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<header class="main-header">
		<a href="{{url('home')}}" class="logo"  style="background-color: #2b4e62">
			<span class="logo-mini"><img src="img/square.png"></span>
			<span class="logo-lg" style="background-color: #2b4e62"><img src="img/bar.png" width="70px" align="center"></span>
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
									
									@if(Auth::user()->jabatan == 1)
										<small><i class="fa fa-circle text-success"></i> Admin</small>
									@elseif(Auth::user()->jabatan == 2)
										<small><i class="fa fa-circle text-success"></i> Helpdesk</small>
									@elseif(Auth::user()->jabatan == 3)
										<small><i class="fa fa-circle text-success"></i> Engineer</small>
									@endif
								</p>
							</li>
							<li class="user-footer">
								<div class="pull-left">
									<a href="{{ url('profile')}}" class="btn btn-default btn-flat">Profile</a>
								</div>
								<div class="pull-right">
									<a class="btn btn-default btn-flat"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
				<a href = "{{ url('profile')}}" class="pull-left image">
					@if(Auth::user()->foto == "0")
						<img src="{{url('img/no-image.png')}}" class="img-circle" alt="User Image">
					@else
						<img src="{{url(Auth::user()->foto)}}" class="img-circle" alt="User Image">
					@endif
				</a>
				<div class="pull-left info">
					<p>{{Auth::user()->name}}</p>

						@if(Auth::user()->jabatan == 1)
							<small><i class="fa fa-circle text-success"></i> Admin</small>
						@elseif(Auth::user()->jabatan == 2)
							<small><i class="fa fa-circle text-success"></i> Helpdesk</small>
						@elseif(Auth::user()->jabatan == 3)
							<small><i class="fa fa-circle text-success"></i> Engineer</small>
						@endif
					
				</div>
			</div>
			<ul class="sidebar-menu" data-widget="tree">
				<li class="header" onclick="url()">Main Menu</li>
				
				<li class="" id="dashboard">
					<a href="home">
						<i class="fa fa-dashboard"></i> <span>Dashboard</span>
					</a>
				</li>
				<li class="" id="absen">
					<a href="{{ url('absen')}}">
						<i class="fa fa-clock-o"></i>
						<span>AOGY</span>
					</a>
				</li>
				<li class="" id="tisygy">
					<a href="{{ url('/tisygy')}}">
						<i class="fa fa-paper-plane"></i>
						<span>TISYGY</span>
					</a>
				</li>
				<!-- 
				
				<li class="" id="sycal">
					<a href="{{ url('asycal')}}">
						<i class="fa fa-calendar"></i>
						<span>SYCAL</span>
					</a>
				</li>
				<li class="" id="announ">
					<a href="{{ url('eannoun')}}">
						<i class="fa fa-bookmark-o"></i>
						<span>Announcement</span>
					</a>
				</li> -->
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	@yield('content')
	<!-- /.content-wrapper -->
	<!-- Control Sidebar -->
	<!-- /.control-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
			 immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3.1.1 -->
<script src="plugins/jQuery/jquery-3.1.1.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/select2.full.min.js"></script>

	<!-- <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script> -->
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>


<!-- chart-->
<script src="{{ asset('AdminLTE/plugins/jQuery/jquery-3.1.1.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ asset('AdminLTE/plugins/chartjs/Chart.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('AdminLTE/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
<!-- page script -->
<script src="{{asset('AdminLTE/plugins/jQuery/jquery-3.1.1.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('js/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('js/demo.js')}}"></script>
<!-- fullCalendar 2.2.5 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('js/fullcalendar.min.js')}}"></script>


<script type="text/javascript">
$(document).ready(function(){
	var path = (document.URL).split("/");
	switch(path[path.length - 1]) {
		case "admin":
			$("#dashboard").addClass("active");
			$("#absen").removeClass("active");
			$("#tisygy").removeClass("active");
			$("#usermanage").removeClass("active");
			$("#schedule").removeClass("active");
			$("#location").removeClass("active");
			console.log("admin");

						break;

			case "absen":
			$("#dashboard").removeClass("active");
			$("#absen").addClass("active");
			$("#tisygy").removeClass("active");
			$("#usermanage").removeClass("active");
			$("#schedule").removeClass("active");
			$("#location").removeClass("active");
			console.log("absen");
			
						break;

			case "ahistory":
			$("#dashboard").removeClass("active");
			$("#absen").addClass("active");
			$("#tisygy").removeClass("active");
			$("#usermanage").removeClass("active");
			$("#schedule").removeClass("active");
			$("#location").removeClass("active");
			console.log("ahistory");

						break;			

			case "tisygy":
			$("#dashboard").removeClass("active");
			$("#absen").removeClass("active");
			$("#tisygy").addClass("active");
			$("#usermanage").removeClass("active");
			$("#schedule").removeClass("active");
			$("#location").removeClass("active");
			console.log("tisygy");
			
						break;

			
		default:
			$("#dashboard").addClass("active");
	};
	// console.log(path[path.length - 1]);
});
</script>

@yield('script')
</body>
</html>
