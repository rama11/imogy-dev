@extends('layouts.engineer.elayout')
@section('content')
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header" >
		<a href="{{url('absen')}}">
			<img src="img/labelaogy.png" width="120" height="40">
		</a>
		<ol class="breadcrumb" style="font-size: 15px;">
			<li><a href="{{url('ehistory')}}"><i class="fa fa-book"></i>My Attendance</a></li>
			<li><a href="{{url('eteamhistory')}}"><i class="fa fa-users"></i>My Team Attendance</a></li>
		</ol>
	</section>
	<section class="content">

		<!-- Simple box -->
		<div class="box" id="panel_simple">
			<div class="box-header with-border">
				<h3 class="box-title">My Team Attendance</h3>
			</div>
			<div class="col-md-4">
				<div class="box box-solid">
					
					<!-- /.box-header -->

					<div class="box-body text-center">



						
					</div>

					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-8">
								<div class="chart-responsive">
									<div class="progress vertical">
										<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="{{$ontime}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$ontime}}%">
											<span class="sr-only">{{$ontime}}%</span>
										</div>
									</div>
									<!-- ./col -->
									<div class="progress vertical">
										<div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="{{$injury}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$injury}}%">
											<span class="sr-only">{{$injury}}%</span>
										</div>
									</div>
									<!-- ./col -->
									<div class="progress vertical">
										<div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="{{$late}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$late}}%">
											<span class="sr-only">{{$late}}%</span>
										</div>
									</div>
									<!-- ./col -->
									<div class="progress vertical">
										<div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="{{$absen}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$absen}}%">
											<span class="sr-only">{{$absen}}%</span>
										</div>
									</div>
								</div>
								<!-- ./chart-responsive -->
							</div>
							<!-- /.col -->
							<div class="col-md-4">
								<ul class="chart-legend clearfix">
									<li><i class="fa fa-circle-o text-yellow"></i> Injury</li>
									<li><i class="fa fa-circle-o text-green"></i> Ontime</li>
									<li><i class="fa fa-circle-o text-red"></i> Late</li>
									<li><i class="fa fa-circle-o text-blue"></i> Absent</li>


								</ul>

								<!-- /.col -->
							</div>
							<!-- /.row -->
						</div>
						<!-- /.box-body -->
						<div class="box-footer no-padding">
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Ontime ({{$count[2]}})
									<span class="pull-right text-green">{{$ontime}}%</span></a>
								</li>

								<li><a href="#">Injury Time ({{$count[1]}})
									<span class="pull-right text-yellow">{{$injury}}%</span></a>
								</li>
								<li><a href="#">Late ({{$count[0]}})
									<span class="pull-right text-red"> {{$late}}%</span></a>
								</li>

								<li><a href="#">Absent ({{$absen}})
									<span class="pull-right text-blue">{{$absen}}%</span></a>
								</li>
								<li><a href="#"><b>Attendance ({{$count[3]}})</b>
									<span class="pull-right ">100%</span></a>
								</li>

							</ul>
						</div>
						<!-- /.footer -->
					</div>

					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>



			<!--<div class="box-body">
				<div class="row text-center">
					<div class="col-md-6" style="margin-top: 40px;">
						<div class="progress vertical">
							<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="{{$ontime}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$ontime}}%">
								<span class="sr-only">{{$ontime}}%</span>
							</div>
						</div>

						<div class="progress vertical">
							<div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="{{$injury}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$injury}}%">
								<span class="sr-only">{{$injury}}%</span>
							</div>
						</div>
						<div class="progress vertical">
							<div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="{{$late}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$late}}%">
								<span class="sr-only">{{$late}}%</span>
							</div>
						</div>
						<br>
						<button type="button" class="btn btn-success"></button>
							<span>Ontime </span>
						<button type="button" class="btn btn-warning"></button>
							<span>Injury Time</span>
						<button type="button" class="btn btn-danger"></button>
							<span>Late</span>
					</div>
					<div class="col-md-6" style="margin-top: 40px;">
						<div class="text-center">
							<span><h4>The Most Ontime Employee</h4></span>
						</div>
						<div class="box-body box-profile">
							<img class="profile-user-img img-responsive img-circle" src="img/miuty.jpg" alt="User profile picture">
							<h3 class="profile-username text-center">Miuty Is Beauty</h3>
							<p class="text-muted text-center">Peri Kecil</p>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;margin-bottom: 30px;">
					<div class="col-md-12 text-center">
						<h3>Attendance My Team on {{date('F y')}}</h3>
					</div>
		///		</div>-->
				<div class="row col-md-8">
					
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th>Name</th>
								<th>Location</th>

								<th style="width: 70px;" class="text-center">On Time</th>
								<th style="width: 50px;" class="text-center">Tolerance</th>
								<th style="width: 50px;" class="text-center">Late</th>
								<th>Absent</th>
								<th>Detail</th>
							</tr>

							@foreach($var as $key => $variable)
							<tr>
								<td>{{$key}}</td>
								<td>{{$variable['where']}}</td>

								<td class="text-center"><span class="badge bg-green">{{$variable['ontime']}}</span></td>
								<td class="text-center"><span class="badge bg-yellow">{{$variable['injury']}}</span></td>
								<td class="text-center"><span class="badge bg-red">{{$variable['late']}}</span></td>
								<td class="form-group">
									<select class="form-control" name="masuk">
										<option value="07:00:00">Absen</option>
										<option value="08:00:00">Sakit</option>
										<option value="14:00:00">Males</option>
										<option value="22:00:00">Izin</option>
									</select>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#modal-detail" onclick="modalDetail('{{$variable['id']}}')"><button type="button" class="btn btn-primary" ><i class="fa fa-align-left"></i></button></a>
								</td>

							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="box-footer clearfix">
					<p class="pull-right">For more other history information. Click <b id="detail" style="cursor:pointer">here</b></p>
				</div>
			</div>
			

			<!-- /.box-body -->
			
			<!-- /.box-footer-->
		</div>

		<!-- Detail box -->
		<div class="box" id="panel_detail" style="display: none;">
			<div class="box-header with-border">
				<h3 class="box-title">My History Absens	</h3>			
			</div>
			<div class="box-body">
				<p>This is all off your absent record. Check this history frequenly for futher, thanks</p>
				<table class="table table-bordered" id="detail_table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Time</th>
							<th>Date</th>
							<th>Where</th>
							<th style="width: 40px">Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas2 as $data)
						<tr>
							<td>{{$data->id_user}}</td>
							<td>{{$data->jam}}</td>
							<td>{{$data->tanggal}}</td>
							<td>{{$data->name}}</td>
							@if($data->late == "No")
							<td style="vertical-align: middle;">
								<span class="label label-danger" >{{$data->late}}</span>
							</td>
							@else
							<td style="vertical-align: middle;">
								<span class="label label-success" >{{$data->late}}</span>
							</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
			<!-- <div class="box-footer clearfix">
				<p class="pull-right">For more other history information. Click <b id="simple" style="cursor:pointer">here</b></p>
			</div> -->
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->
		<div class="modal fade in" id="modal-detail"  tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="titleModal">Detail for </h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-3">
								<div class="chart-responsive">
									<div class="progress vertical">
										<div id="barOntime" class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="height: %">
											<span class="sr-only">%</span>
										</div>
									</div>
									<!-- ./col -->
									<div class="progress vertical">
										<div id="barInjury" class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="height: %">
											<span class="sr-only">%</span>
										</div>
									</div>
									<div class="progress vertical">
										<div id="barLate" class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="height: %">
											<span class="sr-only">%</span>
										</div>
									</div>
									<!-- ./col -->
									<div class="progress vertical">
										<div id="barAbsen" class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 0%">
											<span class="sr-only">0%</span>
										</div>
									</div>
									<!-- ./col -->
								</div>
								<ul class="nav nav-pills nav-stacked">
								<li><a href="#" id="pill1">Ontime (3)
										<span class="pull-right text-green">33.3%</span></a>
									</li>
									<li><a href="#" id="pill2">Injury Time (3)
										<span class="pull-right text-yellow">33.3%</span></a>
									</li>
									<li><a href="#" id="pill3">Late (3)
										<span class="pull-right text-red"> 33.3%</span></a>
									</li>
									<li><a href="#" id="pill4">Absent (24)
										<span class="pull-right text-blue">80%</span></a>
									</li>
									<li><a href="#" id="pill5"><b>Attendance (9)</b>
										<span class="pull-right ">100%</span></a>
									</li>
								</ul>
								<!-- ./chart-responsive -->
							</div>
							<!-- /.col -->
							<div class="col-md-2" style="margin-top: 50px;">
								<ul class="chart-legend clearfix">
									<li><i class="fa fa-circle-o text-green"></i> Ontime</li>
									<li><i class="fa fa-circle-o text-yellow"></i> Injury</li>
									<li><i class="fa fa-circle-o text-red"></i> Late</li>
									<li><i class="fa fa-circle-o text-blue"></i> Absent</li>
								</ul>
								<!-- /.col -->
							</div>

							<div class="col-md-7">
								<table class="table table-bordered">
									<tbody id="tableModal">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<a id="downloadBtn" class="btn btn-primary pull-right" href="">
							<i class="fa fa-download"></i> Download Report
						</a>
					</div>

				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->

		</div>

	</section>
	<!-- /.tab-content -->

</div>
@endsection
@section('script')
<script>
	function modalDetail(id){
		// alert('detail for : ' + id);
		$.ajax({
			type: "GET",
			url: "auserhistory/" + id,
			success: function(result){
				$("#titleModal").text("Detail for " + result[5]);

				$("#barLate").attr("aria-valuenow",result[1]);
				$("#barInjury").attr("aria-valuenow",result[2]);
				$("#barOntime").attr("aria-valuenow",result[3]);

				$("#barLate").attr("style","height:" + result[1]  + "%");
				$("#barInjury").attr("style","height:" + result[2]  + "%");
				$("#barOntime").attr("style","height:" + result[3]  + "%");

				$("#pill3").html("Late (" + result[0][0] + ") <span class='pull-right text-red'>" + result[1] +"%</span>");
				$("#pill2").html("Injury Time( " + result[0][1] + ") <span class='pull-right text-yellow'>" + result[2] +"%</span>");
				$("#pill1").html("Ontime (" + result[0][2] + ") <span class='pull-right text-green'>" + result[3] +"%</span>");
				$("#pill4").html("Absent (" + result[0][3] + ") <span class='pull-right text-blue'>" + result[4] +"%</span>");
				$("#pill5").html("Attendance (" + result[0][4] + ") <span class='pull-right'>100%</span>");

				$("#downloadBtn").attr("href","downloadPDF/" + id);

				console.log(result[6]);
				var object = result[6];
				var location = result[7];
				var i = 0;
				$("#tableModal").empty();
				$("#tableModal").append("<tr><th>Schedule</th><th>Present Time</th><th>Date</th><th>Where</th><th style='width: 40px'>Status</th></tr>");
				for(var where in object){
					console.log(object[where].location)
					$("#tableModal").append("<tr><td>" + location[i].hadir + "</td><td>" + object[where].jam + "</td><td>" + object[where].tanggal + "</td><td>" + object[where].location + "</td><td style='vertical-align: ;''> <span class='label label-default'>" + object[where].late + "</span></td></tr>");
					i++;
				}
				console.log(result);
			},
		});
	};

	$(document).ready(function(){
		console.log('asdfasdf');
		
		// Click to Detail
		$("#detail").click(function () {
			console.log('asdfasdf');
			$("#panel_simple").fadeOut(function () {
				$("#panel_detail").fadeIn();
			});
		});

		//Click to Simple
		$("#simple").click(function () {
			console.log('asdfasdf');
			$("#panel_detail").fadeOut(function () {
				$("#panel_simple").fadeIn();
			});
		});
	});

	//Init for DataTable
	// $('#detail_table').dataTable();
</script>
@endsection