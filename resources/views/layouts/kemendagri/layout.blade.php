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
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/pace/pace.min.css')}}" >
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	@yield('head')
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<header class="main-header">
		<a href="{{url('admin')}}" class="logo"  style="background-color: #2b4e62">
			<span class="logo-mini"><img src="img/iconwhitek.png" style="padding:5px;width: 45px; height: 45px;"></span>
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
							<!-- User image -->
							<li class="user-header" style="background-color:#222d32">
								@if(Auth::user()->foto == "0")
									<img src="{{url('img/no-image.png')}}" class="img-circle" alt="User Image">
								@else
									<img src="{{url(Auth::user()->foto)}}" class="img-circle" alt="User Image">
								@endif
								<p>
									{{Auth::user()->name}} 
									<small>{{Auth::user()->jabatan}}</small>
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
									<a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
				<div class="pull-left image">
					@if(Auth::user()->foto == "0")
						<img src="{{url('img/no-image.png')}}" class="img-circle" alt="User Image">
					@else
						<img src="{{url(Auth::user()->foto)}}" class="img-circle" alt="User Image">
					@endif
				</div>
				<div class="pull-left info">
					<p>{{Auth::user()->name}}</p>
					<a href="#"><i class="fa fa-circle text-success"></i> Kemendagri</a>
				</div>
			</div>
			<ul class="sidebar-menu" data-widget="tree">
				<li class="header" onclick="url()">Main Menu</li>
				<li class="" id="dashboard">
					<a href="admin">
						<i class="fa fa-dashboard"></i> <span>Dashboard</span>
					</a>
				</li>
				<li class="" id="atisygy">
					<a href="{{ url('/tisygy')}}">
						<i class="fa fa-paper-plane"></i>
						<span>TISYGY</span>
					</a>
				</li>
			</ul>
		</section>
	</aside>
	@yield('content')
</div>

<script src="plugins/jQuery/jquery-3.1.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/knob/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/fastclick/fastclick.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
<script src="../../plugins/select2/select2.full.min.js"></script>
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/jQuery/jquery-3.1.1.min.js')}}"></script>
<script src="{{ asset('AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/chartjs/Chart.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/pace/pace.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/fastclick/fastclick.js')}}"></script>
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('AdminLTE/dist/js/demo.js')}}"></script>
<script src="{{asset('AdminLTE/plugins/jQuery/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('js/fastclick.js')}}"></script>
<script src="{{asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('js/demo.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/locale/id.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('js/fullcalendar.min.js')}}"></script>


<script type="text/javascript">
$(document).ready(function(){
	var path = (document.URL).split("/");
	switch(path[path.length - 1]) {
		case "admin":
			$("#dashboard").addClass("active");
			$("#usermanage").removeClass("active");
			$("#location").removeClass("active");
			$("#absen").removeClass("active");
			$("#atisygy").removeClass("active");
			$("#sycal").removeClass("active");
						break;
		case "usermanage":
			$("#dashboard").removeClass("active");
			$("#usermanage").addClass("active");
			$("#location").removeClass("active");
			$("#absen").removeClass("active");
			$("#atisygy").removeClass("active");
			$("#sycal").removeClass("active");
			break;
		case "location":
			$("#dashboard").removeClass("active");
			$("#usermanage").removeClass("active");
			$("#location").addClass("active");
			$("#absen").removeClass("active");
			$("#atisygy").removeClass("active");
			$("#sycal").removeClass("active");
			break;
		case "absen":
			$("#dashboard").removeClass("active");
			$("#usermanage").removeClass("active");
			$("#location").removeClass("active");
			$("#atisygy").removeClass("active");
			$("#absen").addClass("active");
			$("#sycal").removeClass("active");
			console.log("absen");
			break;
		case "atisygy":
			$("#dashboard").removeClass("active");
			$("#usermanage").removeClass("active");
			$("#location").removeClass("active");
			$("#absen").removeClass("active");
			$("#atisygy").addClass("active");
			$("#sycal").removeClass("active");
			console.log("atisygy");
			break;
		case "asycal":
			$("#dashboard").removeClass("active");
			$("#usermanage").removeClass("active");
			$("#location").removeClass("active");
			$("#absen").removeClass("active");
			$("#atisygy").removeClass("active");
			$("#sycal").addClass("active");
			console.log("sycal");
			break;
		default:
			$("#dashboard").addClass("active");
	};
	console.log(path[path.length - 1]);
});
</script>
@yield('script')
</body>
</html>