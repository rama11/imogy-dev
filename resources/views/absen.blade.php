@extends((Auth::user()->role == "1") ? 'layouts.admin.layoutLight' : 'layouts.engineer.elayout')
@section('content')
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
			<div class="box-body" style="margin-top: 50px;">
				<div class="row">
					<div class="col-xs-12 text-center">
						<canvas id="canvas" width="300" height="300" style="background-color:rgba(0,0,0,0)"></canvas>
						<br>
						<h3>{{date("l, d M Y H:i:s")}}</h3>
						<br>
						<div class="row">
							<div class="col-md-4  col-md-offset-4 text-center">
								@if ($sudah == 'sudah')
									@if($keterangan == 1)
										<div class="alert alert-success" role="alert"  id="logined">Absen Complete (On-Time)</div>
									@elseif($keterangan == 2)
										<div class="alert alert-warning" role="alert"  id="logined">Absen Complete (Injury)</div>
									@elseif($keterangan == 3)
										<div class="alert alert-error" role="alert"  id="logined">Absen Complete (Late)</div>
									@elseif($keterangan == 4)
										<div class="alert alert-info" role="alert"  id="logined">You are absent today (Absent)</div>
									@elseif($keterangan == 5)
										<div class="alert alert-info" role="alert"  id="logined">You are not working today (Libur)</div>
									@endif

									@if($sudah_pulang == 'sudah')
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPulang" id="pulang">SUDAH PULANG</button>
									@else
										<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalPulang" id="pulang">PULANG</button>
									@endif
								@else 
									<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal" id="absen">ABSEN</button>
								@endif
								<button style="display: none;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2" id="berhasil">Berhasil</button>
								<button style="display: none;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal3" id="gagal">Gagal</button>
							</div>
						</div>

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
			<div class="box-footer">
				
			</div>
		</div>
	</section>
</div>
@endsection 

@section('script')
<script>
	$(document).ready(function(){
		// console.log("{{Auth::user()->name}}");
		// console.log("Lokasi : {{$point->name}}");

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
					if(calculate  < radius) {
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
								// location.reload();
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
					
				}, function() {
					if("{{Auth::user()->id}}" != "4"){
						$.ajax({
							type:"GET",
							data:{
								message: "Gagal Absen - Geolocation is not support"
							},
							url: "logging/ERROR",
							success: function(){
								alert("Geolocation is not support");
							}
						})
					} else {
						$("#berhasil").click();
						$("#myModal").hide();
						$("#absen").hide();
						$("#logined").show(); //
						$("#close").click(function () {
							$(".modal-backdrop").hide();
						});

						$.ajax({
							type: "POST",
							data: {
								"_token": "{{ csrf_token() }}",
							},
							url: "raw/{{Auth::user()->id}}",
							success: function(){
								location.reload();
							},
						});
						$("#absen").hide();
					}

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

	var canvas = document.getElementById("canvas");
	var ctx = canvas.getContext("2d");
	var radius = canvas.height / 2;
	ctx.translate(radius, radius);
	radius = radius * 0.90
	setInterval(drawClock, 1000);

	function drawClock() {
		drawFace(ctx, radius);
		drawNumbers(ctx, radius);
		drawTime(ctx, radius);
	}

	function drawFace(ctx, radius) {
		var grad;
		ctx.beginPath();
		ctx.arc(0, 0, radius, 0, 2*Math.PI);
		ctx.fillStyle = 'white';
		ctx.fill();
		grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
		grad.addColorStop(0, 'rgb(43, 78, 98)');
		grad.addColorStop(0.5, 'rgb(43, 78, 98)');
		grad.addColorStop(1, 'rgb(43, 78, 98)');
		ctx.strokeStyle = grad;
		ctx.lineWidth = radius*0.1;
		ctx.stroke();
		ctx.beginPath();
		ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
		ctx.fillStyle = 'rgb(43, 78, 98)';
		ctx.fill();
	}

	function drawNumbers(ctx, radius) {
		var ang;
		var num;
		ctx.font = radius*0.15 + "px arial";
		ctx.textBaseline="middle";
		ctx.textAlign="center";
		for(num = 1; num < 13; num++){
			ang = num * Math.PI / 6;
			ctx.rotate(ang);
			ctx.translate(0, -radius*0.85);
			ctx.rotate(-ang);
			ctx.fillText(num.toString(), 0, 0);
			ctx.rotate(ang);
			ctx.translate(0, radius*0.85);
			ctx.rotate(-ang);
		}
	}

	function drawTime(ctx, radius){
		var now = new Date();
		var hour = now.getHours();
		var minute = now.getMinutes();
		var second = now.getSeconds();
		hour=hour%12;
		hour=(hour*Math.PI/6)+
		(minute*Math.PI/(6*60))+
		(second*Math.PI/(360*60));
		drawHand(ctx, hour, radius*0.5, radius*0.07);
		minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
		drawHand(ctx, minute, radius*0.8, radius*0.07);
		second=(second*Math.PI/30);
		drawHand(ctx, second, radius*0.9, radius*0.02);
	}

	function drawHand(ctx, pos, length, width) {
		ctx.beginPath();
		ctx.lineWidth = width;
		ctx.lineCap = "round";
		ctx.moveTo(0,0);
		ctx.rotate(pos);
		ctx.lineTo(0, -length);
		ctx.stroke();
		ctx.rotate(-pos);
	}
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=geometry"></script> -->
<script async defer src="https://maps.googleapis.com/maps/api/js?v=3&libraries=geometry&key=AIzaSyBNVCp8lA_LCRxr1rCYhvFIUNSmDsbcGno"></script>
@endsection