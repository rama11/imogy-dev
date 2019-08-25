@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')
@section('content')
<style>
	#analog-clock {
		position: relative;
		width: 300px;
		height: 300px;
		margin: auto;
	}

	#clock-dial {
		width: 100%;
		height: 100%;
		background: #1d3030;
		border-radius: 50%;
	}

	#clock-dial-circle {
		position: absolute;
		width: 3%;
		height: 3%;
		border-radius: 50%;
		background: white;
		top: 48.5%;
		left: 48.5%;
	}

	.clock-dial-stick {
		position: absolute;
		top: 5%;
		left: 49.8%;
		width: 0.7%;
		height: 7%;
		opacity 0.5;
		background: lightgray;
		-webkit-transform-origin: 50% 640%;
	}
	#clock-dial-12 {
		-webkit-transform: rotate(0deg);
	}
	#clock-dial-1 {
		-webkit-transform: rotate(30deg);
	}
	#clock-dial-2 {
		-webkit-transform: rotate(60deg);
	}
	#clock-dial-3 {
		-webkit-transform: rotate(90deg);
	}
	#clock-dial-4 {
		-webkit-transform: rotate(120deg);
	}
	#clock-dial-5 {
		-webkit-transform: rotate(150deg);
	}
	#clock-dial-6 {
		-webkit-transform: rotate(180deg);
	}
	#clock-dial-7 {
		-webkit-transform: rotate(210deg);
	}
	#clock-dial-8 {
		-webkit-transform: rotate(240deg);
	}
	#clock-dial-9 {
		-webkit-transform: rotate(270deg);
	}
	#clock-dial-10 {
		-webkit-transform: rotate(300deg);
	}
	#clock-dial-11 {
		-webkit-transform: rotate(330deg);
	}

	#hour-hand {
		position: absolute;
		width: 1.5%;
		height: 25%;
		background: white;
		top: 24%;
		left: 49.25%;
		-webkit-transform-origin: 50% 110%;
	}

	#min-hand {
		position: absolute;
		width: 1.5%;
		height: 35%;
		background: white;
		top: 12%;
		left: 49.25%;
		-webkit-transform-origin: 50% 110%;
	}

	#sec-hand {
		position: absolute;
		width: 1%;
		height: 35%;
		background: red;
		top: 12%;
		left: 49.5%;
		-webkit-transform-origin: 50% 110%;
	}

	/* apply a natural box layout model to all elements */
	*, *:before, *:after {
		-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
	}
</style>
<div class="content-wrapper">
	<section class="content-header" >
		<img src="img/labelaogy.png" width="120" height="40">
		<ol class="breadcrumb" style="font-size: 15px;">
			<li><a href="{{url('ahistory')}}"><i class="fa fa-book"></i>My Absent History</a></li>
			@if(Auth::user()->role == "1")
				<li><a href="{{url('ateamhistory')}}"><i class="fa fa-users"></i>My Team Attendance</a></li>
				<li><a href="{{url('areport')}}"><i class="fa fa-users"></i>Reporting</a></li>
			@endif
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-body" style="margin-top: 40px;">
				<div class="row">
					<div class="col-xs-12 text-center">
						<div id="analog-clock">
							<div id="clock-dial">
								<div id="clock-dial-circle"></div>	
								<div id="clock-dial-12" class="clock-dial-stick"></div>
								<div id="clock-dial-1" class="clock-dial-stick"></div>
								<div id="clock-dial-2" class="clock-dial-stick"></div>		
								<div id="clock-dial-3" class="clock-dial-stick"></div>
								<div id="clock-dial-4" class="clock-dial-stick"></div>
								<div id="clock-dial-5" class="clock-dial-stick"></div>		
								<div id="clock-dial-6" class="clock-dial-stick"></div>
								<div id="clock-dial-7" class="clock-dial-stick"></div>
								<div id="clock-dial-8" class="clock-dial-stick"></div>		
								<div id="clock-dial-9" class="clock-dial-stick"></div>
								<div id="clock-dial-10" class="clock-dial-stick"></div>
								<div id="clock-dial-11" class="clock-dial-stick"></div>		
							</div>
	
							<div id="clock-hands">
								<div id="hour-hand"></div>
								<div id="min-hand"></div>
								<div id="sec-hand"></div>
							</div>
						</div>

						
						<br>
						<h3>{{date("l, d M Y H:i:s")}}</h3>
						<br>
						<div class="row">
							<div class="col-md-4	col-md-offset-4 text-center">
								@if ($sudah == 'sudah')
									@if($keterangan == 1)
										<div class="alert alert-success" role="alert"	id="logined">Absen Complete (On-Time)</div>
									@elseif($keterangan == 2)
										<div class="alert alert-warning" role="alert"	id="logined">Absen Complete (Injury)</div>
									@elseif($keterangan == 3)
										<div class="alert alert-error" role="alert"	id="logined">Absen Complete (Late)</div>
									@elseif($keterangan == 4)
										<div class="alert alert-info" role="alert"	id="logined">You are absent today (Absent)</div>
									@elseif($keterangan == 5)
										<div class="alert alert-info" role="alert"	id="logined">You are not working today (Libur)</div>
									@elseif($keterangan == 6)
										<div class="alert alert-info" role="alert"	id="logined">You are not shifting today (No Shifting)</div>									
								@endif

								@if($sudah_pulang == 'sudah')
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPulang" id="pulang">SUDAH PULANG</button>
									@else

										@if($keterangan == 6)

										 <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalPulang" style="display:none">PULANG</button>
										
										@elseif($keterangan == 5)
										
										<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalPulang" style="display:none">PULANG</button>
										
										@else

										<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalPulang" id="pulang">PULANG</button>

										@endif
									@endif
								@else 
									<button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal" id="absen">ABSEN</button>
								@endif
								<button style="display: none;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2" id="berhasil">Berhasil</button>
								<button style="display: none;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal3" id="gagal">Gagal</button>
							</div>
						</div>
						<br>

						<div class="modal fade" id="myModal" role="dialog">
							<div class="modal-dialog">

								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Absen Location</h4>
									</div>
									<div class="modal-body">
										<p>Please go to your area, and login on there</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-success" id="absenLocation">Absen Location</button>
										<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>

						<div class="modal fade" id="myModal2" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Login on Position Success</h4>
									</div>
									<div class="modal-body">
										<p>You have been login on your area. Keep spirit for our bussines</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="close">Close</button>
									</div>
								</div>

							</div>
						</div>

						<div class="modal fade" id="myModal3" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Login on Position Failed</h4>
									</div>
									<div class="modal-body">
										<p>You are not on your absent area. Please go to {{$point->name}} for successfully login.</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" id="tryAgain">Try Again</button>
										<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>

						<div class="modal fade" id="modalPulang" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Absen Pulang</h4>
									</div>
									<div class="modal-body">
										<p>Please go to your area, and login on there</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" id="pulang">Pulang</button>
										<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection 
@section('script')
<script>
	$(document).ready(function(){
		var condition;
		$("#absenLocation").click(function () {
			condition = 'masuk';
			initMap();
		});

		$("#tryAgain").click(function(){
			condition = 'masuk';
			initMap();
		});

		$("#pulang").click(function(){
			condition = 'pulang';
			initMap();
		});
		
		var map, infoWindow, pos;
		function initMap() {

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					pos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};

					var lat = "{{$point->lat}}";
					var lang = "{{$point->lang}}";
					var p1 = new google.maps.LatLng(lat, lang);
					var p2 = new google.maps.LatLng(pos.lat, pos.lng);

					var radius = parseInt("{{$point->radius}}") / 1000;
					console.log("Lokasi : {{$point->name}}");
					console.log("Radius : " + radius);
						
					var calculate = calcDistance(p1, p2);
					if(calculate < radius) {
						$("#berhasil").click();
						$("#myModal").hide();
						$("#absen").hide();
						$("#logined").show();
						$("#close").click(function () {
							$(".modal-backdrop").hide();
						});
						alert(calculate + " km, masuk wilayah");
						$.ajax({
							type: "POST",
							data: {
								"_token": "{{ csrf_token() }}",
							},
							url: "raw/{{Auth::user()->id}}",
							success: function(){
								$.ajax({
									type: "GET",
									data: {
										"lat": lat,
										"lng": lang,
										"condition" : condition,
									},
									url: "createPresenceLocation",
									success: function(){
										location.reload();
									},
								});
							},
						});
						$("#absen").hide();
					} else {
						$.ajax({
							type:"GET",
							data:{
								message: "Gagal Absen - Keluar Wilayah"
							},
							url: "logging/ERROR",
							success: function(){
								$("#gagal").click();
								$("#myModal").hide();
								$(".modal-backdrop").hide();
								alert(calcDistance(p1, p2) + " km, keluar wilayah");
							}
						})
					}
					function calcDistance(p1, p2) {
						return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
					}
					console.log(pos.lat + " , " + pos.lng);
				}, 
				function() {
					console.log("Geolocation error");
				});
			} else {
				handleLocationError(false, infoWindow, map.getCenter());
			}
		}

		function handleLocationError(browserHasGeolocation, infoWindow, pos) {
			infoWindow.setPosition(pos);
			infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
			infoWindow.open(map);
		}
	});
	
	function updateTime () {
		now = new Date ();

		document.getElementById("hour-hand").style.webkitTransform = "rotate(" + (now.getHours() * 30 + now.getMinutes() / 2) + "deg)";
		
		document.getElementById("min-hand").style.webkitTransform = "rotate(" + (now.getMinutes() * 6 + now.getSeconds() / 10) + "deg)";
		
		document.getElementById("sec-hand").style.webkitTransform = "rotate(" + now.getSeconds() * 6 + "deg)";
		
		setTimeout(function () {
			updateTime();
		}, 1000);
	}

	updateTime();
	
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?v=3&libraries=geometry&key={{env('GOOGLE_API_KEY')}}"></script>

@endsection
