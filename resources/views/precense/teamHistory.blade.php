@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('head')
	<link rel="stylesheet" href="{{ url('plugins/datatables/dataTables.bootstrap.css')}}">
@endsection

@section('content')
<style>
.loader {
	border: 16px solid #f3f3f3;
	border-radius: 50%;
	border-top: 16px solid #3498db;
	width: 120px;
	height: 120px;
	-webkit-animation: spin 2s linear infinite;
	animation: spin 2s linear infinite;
	margin: auto;
	position: absolute;
	top:0;
	bottom: 0;
	left: 0;
	right: 0;
}

@-webkit-keyframes spin {
	0% { -webkit-transform: rotate(0deg); }
	100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
}

.cover {
	position: fixed;
	top: 0;
	left: 0;
	background: rgba(0,0,0,0.6);
	z-index: 5000;
	width: 100%;
	height: 100%;
	display: none;
}
</style>
<div class="cover" id="cover">
	<div class="loader"></div>
</div>



<div class="content-wrapper">

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
							<li><a href="#" id="pill1">Ontime (0)
								<span class="pull-right text-green">0.0%</span></a>
							</li>
							<li><a href="#" id="pill2">Injury Time (0)
								<span class="pull-right text-yellow">0.0%</span></a>
							</li>
							<li><a href="#" id="pill3">Late (0)
								<span class="pull-right text-red"> 0.0%</span></a>
							</li>
							<li><a href="#" id="pill4">Absent (0)
								<span class="pull-right text-blue">0%</span></a>
							</li>
							<li><a href="#" id="pill5"><b>Attendance (0)</b>
								<span class="pull-right ">0%</span></a>
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
						<table id="tableModal2" class="table table-bordered">
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
	</div>
</div>
	<!-- Content Header (Page header) -->
	<section class="content-header" >
		<a href="{{url('absen')}}">
			<img src="{{url('img/labelaogy.png')}}" width="120" height="40">
		</a>
		<ol class="breadcrumb" style="font-size: 15px;">
			<li><a href="{{url('precense/myhistory')}}"><i class="fa fa-book"></i>My Attendance</a></li>
			@if(Auth::user()->jabatan == "1" || Auth::user()->jabatan == "5")
				<li><a href="{{url('precense/teamhistory')}}"><i class="fa fa-users"></i>My Team Attendance</a></li>
				<li><a href="{{url('precense/reporting')}}"><i class="fa fa-users"></i>Reporting</a></li>
			@endif
		</ol>
	</section>

	<section class="content">
		<div class="row">

			<section class="col-lg-4 col-xs-6" id="panel_simple">
				
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Presentase</h3>
					</div>
					<div class="box-body ">
						<div class="row">
							<div class="col-md-8 text-center">
								<div class="chart-responsive">
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
									<div class="progress vertical">
										<div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="{{$absen}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$absen}}%">
											<span class="sr-only">{{$absen}}%</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<ul class="chart-legend">
									<li><i class="fa fa-circle-o text-yellow"></i> Injury</li>
									<li><i class="fa fa-circle-o text-green"></i> Ontime</li>
									<li><i class="fa fa-circle-o text-red"></i> Late</li>
									<li><i class="fa fa-circle-o text-blue"></i> Absent</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="box box-default">
					<div class="box-body ">
						<ul class="nav nav-pills nav-stacked">
							<li>
								<a href="#">Ontime ({{$count[2]}})
									<span class="pull-right text-green">+{{$ontime}}%</span>
								</a>
							</li>
							<li>
								<a href="#">Injury Time ({{$count[1]}})
									<span class="pull-right text-yellow">+{{$injury}}%</span>
								</a>
							</li>
							<li>
								<a href="#">Late ({{$count[0]}})
									<span class="pull-right text-red">+{{$late}}%</span>
								</a>
							</li>
							<li>
								<a href="#">Absent ({{$count[4]}})
									<span class="pull-right text-blue">-{{$absen}}%</span>
								</a>
							</li>
							<li>
								<a href="#"><b>Attendance ({{$count[3]}})</b>
									<span class="pull-right ">{{$attendance}}%</span>
								</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="box box-default">
					<div class="box-body ">
						<p>For more other history information. Click <b id="detail" style="cursor:pointer">here</b></p>
					</div>
				</div>

			</section>

			<section class="col-lg-8 col-xs-6" id="panel_simple2">
				
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Team Attendence</h3>
					</div>
					<div class="box-body no-padding">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 7px;">#</th>
									<th>Name</th>
									<th>Location</th>
									<th style="width: 70px;" class="text-center">On Time</th>
									<th style="width: 50px;" class="text-center">Tolerance</th>
									<th style="width: 50px;" class="text-center">Late</th>
									<th class="text-center">Detail</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1;?>
								@foreach($summaryCounts as $summaryCount)
								<tr>
									<td>{{$i}}.</td>
									<td>{{$summaryCount->name}}</td>
									<td>{{$summaryCount->location}}</td>

									<td class="text-center"><span class="badge bg-green">{{$summaryCount->on_time}}</span></td>
									<td class="text-center"><span class="badge bg-yellow">{{$summaryCount->tolerance}}</span></td>
									<td class="text-center"><span class="badge bg-red">{{$summaryCount->late}}</span></td>

									<td class="text-center">
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-detail" onclick="modalDetail('{{$summaryCount->id_user}}')"><i class="fa fa-align-left"></i></button>
									</td>

								</tr>
								<?php $i++;?>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

			</section>

			<section class="col-lg-12 col-xs-12" id="panel_detail" style="display: none;">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">All history attendance</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<!-- <p>This is all off your absent record. Check this history frequenly for futher, thanks</p> -->
						<table class="table table-bordered dataTable" id="detail_table">
							<thead>
								<tr>
									<th>Id</th>
									<th>Name</th>
									<th>Time</th>
									<th>Date</th>
									<th>Where</th>
									<th>User Agent</th>
									<th>IP Access</th>
									<th style="width: 40px">Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach($datas2 as $data)
								<tr>
									<td>{{$data->id}}</td>
									<td>{{$data->user_name}}</td>
									<td>{{$data->jam}}</td>
									<td>{{$data->tanggal}}</td>
									<td>{{$data->location_name}}</td>
									<td>{{$data->http_user_agent}}</td>
									<td>{{$data->ip_access}}</td>
									@if($data->late == "Late")
									<td style="vertical-align: middle;">
										<span class="label label-danger" >{{$data->late}}</span>
									</td>
									@elseif($data->late == "Injury-Time")
									<td style="vertical-align: middle;">
										<span class="label label-warning" >{{$data->late}}</span>
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
					<div class="box-footer clearfix">
						<p class="pull-right">For more other history information. Click <b id="simple" style="cursor:pointer">here</b></p>
					</div>
				</div>
			</section>
		</div>
	</section>
</section>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="{{ url('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script>

	$('#detail_table').DataTable({
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
        ],
        "order": [[ 0, "desc" ]]
	});

	function modalDetail(id){
		// alert('detail for : ' + id);
		$("#tableModal").empty();

		$.ajax({
			type: "GET",
			url: "{{url('/precense/teamhistory/getUserHistory')}}/" + id,
			beforeSend: function() {
				console.log("start");
				$("#cover").show();
			},
			complete: function() {
				$("#cover").hide();
				console.log("complete");
			},
			success: function(result){
				$("#titleModal").text("Detail for " + result[5]);

				$("#barLate").attr("aria-valuenow",result[1]);
				$("#barInjury").attr("aria-valuenow",result[2]);
				$("#barOntime").attr("aria-valuenow",result[3]);

				$("#barLate").attr("style","height:" + result[1]  + "%");
				$("#barInjury").attr("style","height:" + result[2]  + "%");
				$("#barOntime").attr("style","height:" + result[3]  + "%");

				$("#pill3").html("Late (" + result[0][0] + ") <span class='pull-right text-red'>+" + result[1] +"%</span>");
				$("#pill2").html("Injury Time( " + result[0][1] + ") <span class='pull-right text-yellow'>+" + result[2] +"%</span>");
				$("#pill1").html("Ontime (" + result[0][2] + ") <span class='pull-right text-green'>+" + result[3] +"%</span>");
				$("#pill4").html("Absent (" + result[0][3] + ") <span class='pull-right text-blue'>-" + result[4] +"%</span>");
				$("#pill5").html("Attendance (" + result[0][4] + ") <span class='pull-right'>" + result[9] + "%</span>");

				$("#downloadBtn").attr("href","{{url('/precense/teamhistory/getIndifidualHistory')}}/" + id);

				// console.log(result[6]);
				var object = result[6];
				var location = result[7];
				var i = 0;
				$("#tableModal").append("<tr><th>Schedule</th><th>Present Time</th><th>Date</th><th>Where</th><th style='width: 40px'>Status</th></tr>");
				console.log("Nama : " + result[5] + " absen : " + result[10]);
				if(result[10] == "kosong"){
					$("#tableModal").append("<tr class='text-center'><td colspan='5'>No data yet</td></tr>");
				} else {
					for(var where in object){

						// console.log(object[where].location)
						if(object[where].late == "Late"){
							$("#tableModal").append("<tr><td>" + location[i].hadir + "</td><td>" + object[where].jam + "</td><td>" + object[where].tanggal + "</td><td>" + object[where].location + "</td><td style='vertical-align: ;''> <span class='label label-danger'>" + object[where].late + "</span></td></tr>");
						} else if (object[where].late == "Injury-Time"){
							$("#tableModal").append("<tr><td>" + location[i].hadir + "</td><td>" + object[where].jam + "</td><td>" + object[where].tanggal + "</td><td>" + object[where].location + "</td><td style='vertical-align: ;''> <span class='label label-warning'>" + object[where].late + "</span></td></tr>");
						} else if (object[where].late == "On-Time"){
							$("#tableModal").append("<tr><td>" + location[i].hadir + "</td><td>" + object[where].jam + "</td><td>" + object[where].tanggal + "</td><td>" + object[where].location + "</td><td style='vertical-align: ;''> <span class='label label-success'>" + object[where].late + "</span></td></tr>");
						} else {
							$("#tableModal").append("<tr><td>" + location[i].hadir + "</td><td>" + object[where].jam + "</td><td>" + object[where].tanggal + "</td><td>" + object[where].location + "</td><td style='vertical-align: ;''> <span class='label label-default'>" + object[where].late + "</span></td></tr>");
						}
						i++;
					}
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
			$("#panel_simple2").fadeOut();
		});

		//Click to Simple
		$("#simple").click(function () {
			console.log('asdfasdf');
			$("#panel_detail").fadeOut(function () {
				$("#panel_simple").fadeIn();
				$("#panel_simple2").fadeIn();
			});
		});
	});

	function clickSubmit(){
		$("#change").click();
	}

	//Init for DataTable
</script>
@endsection