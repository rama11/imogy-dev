@extends('layouts.app')
@section('head')
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="../../plugins/iCheck/square/blue.css">
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
@endsection

@section('body')
class="hold-transition login-page" style="background-color:#f7f9fd"@endsection

@section('content')
	<div class="login-box" style="margin-top:100px"> 
		<div class="login-box-body" >
			<center>
				<a href="{{ url('/') }}">
					<img src="img/bar1.png" width="200px">
				</a>
			</center>
			<br>

			<form role="form" method="post" action="{{ route('login') }}">
				{{ csrf_field() }}
							
				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
					<input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
		
				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
					<input id="password" type="password" class="form-control" placeholder="Password" name="password" required>
					<br>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					@if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>
			
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox">
							<label style="padding-left: 0px">
								<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
							</label>
						</div>
					</div>
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat"> Login</button>
					</div>
				</div>
				<!-- <div>
					<a href="{{ route('password.request') }}">I Forgot My Password</a>
				</div> -->
			</form>
		</div>
		<img src="img/sip.png" style="position:fixed; right:0.1px; bottom:0.2px; align-items:right; text-align: right;" width="10%">
	</div>
@endsection

@section('script')
	<script src="{{ asset('AdminLTE/plugins/jQuery/jquery-3.1.1.min.js')}}"></script>
	<script src="{{ asset('AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>
	<script>
		$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' // optional
			});

			console.log("asdfasd");
		});
	</script>
@endsection

