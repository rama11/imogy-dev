<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>AOGY</title>
	<link href="img/square.png" rel="icon" type="image/x-icon">

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
	<style type="text/css">
		.modal {
			text-align: center;
		}
		
		@media screen and (min-width: 768px) {
			.modal:before {
				display: inline-block;
				vertical-align: middle;
				content: " ";
				height: 100%;
			}
		}
		
		.modal-dialog {
			display: inline-block;
			text-align: left;
			vertical-align: middle;
		}
	</style>

</head>

<body>
	<div id="app">
		<nav class="navbar navbar-default navbar-static-top" style="background-color: rgb(43, 78, 98);">
			<div class="container">
				<div class="navbar-header">

					<!-- Collapsed Hamburger -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<!-- Branding Image -->
					<a class="navbar-brand miuty_nav_font" href="{{ url('/') }}" style="background-color: rgb(43, 78, 98);color:#FFF;">
												IMOGY
										</a>
				</div>

				<div class="collapse navbar-collapse" id="app-navbar-collapse">
					<!-- Left Side Of Navbar -->
					<ul class="nav navbar-nav">
						&nbsp;
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="nav navbar-nav navbar-right">
						<!-- Authentication Links -->
						@if (Auth::guest())
							<li><a href="{{ route('login') }}">Login</a></li>
							<li><a href="{{ route('register') }}">Register</a></li>
						@else
							<li class="dropdown">
								<a style="color:#FFF;background-color: rgb(43, 78, 98);" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									<img src="{{ asset('img/user7-128x128.jpg')}}" class="user-image" alt="User Image"> Engineer, {{ Auth::user()->name }} <span class="caret"></span>
								</a>

								<ul class="dropdown-menu" role="menu">
									<li>
										<a href="profile">Profile</a>
									</li>
									<li>
										<a href="history">History</a>
									</li>
									<li>
										<a id="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
											Logout
										</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
											{{ csrf_field() }}
										</form>
									</li>
								</ul>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>

		@yield('background') @yield('content')
	</div>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/jquery.js') }}"></script>
	<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
	@if(!Auth::guest())
	<script type="text/javascript">
		$(document).ready(function() {
			$("#logout").click(function() {
				$.ajax({
					type: "GET",
					url: "raw/{{Auth::user()->id}}",
					success: '',
				});
			});
		});
	</script>
	@endif 
	@yield('script')
</body>

</html>