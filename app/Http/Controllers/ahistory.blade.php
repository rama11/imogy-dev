@extends('layouts.admin.layout')
@section('content')
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header" >
		<a href="{{url('absen')}}">
			<img src="img/labelaogy.png" width="120" height="40">
		</a>
		<ol class="breadcrumb" style="font-size: 15px;">
			<li><a href="{{url('ahistory')}}"><i class="fa fa-book"></i>My Attendance</a></li>
			<li><a href="{{url('ateamhistory')}}"><i class="fa fa-users"></i>My Team Attendance</a></li>
		</ol>
	</section>
	<section class="content">

		<!-- Simple box -->
		<div class="box" id="panel_simple">
			<div class="box-header with-border">
				<h3 class="box-title">My Attendance	</h3>			
			</div>

			<div class="col-md-6">
				<div class="box box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Performance Bars</h3>
					</div>
					<!-- /.box-header -->

					<div class="box-body text-center">
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


						
						</div>
						<div class="box-body text-center">
							<button type="button" class="btn btn-success"></button>
							<span>Ontime</span>
							<button type="button" class="btn btn-warning"></button>
							<span>Injury Time</span>
							<button type="button" class="btn btn-danger"></button>
							<span>Late</span>
						</div>


						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<div class="col-md-6">
					<div class="box box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">My Performance</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body ">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<th>Week</th>
										<th>Ontime</th>
										<th>Injury Time</th>
										<th>Late</th>


									</tr>

									<tr>
										<td>Week 1</td>
										<td>10</td>
										<td>5</td>
										<td>7</td>

									</tr>
									<tr>
										<td>Week 2</td>
										<td>15</td>
										<td>3</td>
										<td>8</td>

									</tr>
									<tr>
										<td>Week 3</td>
										<td>15</td>
										<td>3</td>
										<td>8</td>

									</tr>
									<tr>
										<td>Week 4</td>
										<td>15</td>
										<td>3</td>
										<td>8</td>

									</tr>

								</tbody>
							</table>
							<center><b>AGUSTUS</b></center>
							<br>

							<i>"Yesterday is gone. Tomorrow has not yet come. We have only today. Let we make ourself become someone who always on time."</i>








						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>


				<div class="box-body">

					<table class="table table-bordered">
						<tbody>
							<tr>
								<th>My Schedule</th>
								<th>My Present Time</th>
								<th>Date</th>
								<th>Where</th>
								<th style="width: 40px">Status</th>
							</tr>
							@foreach($datas as $key =>$data)
							<tr>

								<td>{{$kehadiran[$key]->hadir}}</td>
								<td>{{$data->jam}}</td>
								<td>{{date("d/m/Y", strtotime($data->tanggal))}}</td>
								<td>{{$data->name}}</td>
								@if($data->late == "On-Time")
								<td style="vertical-align: middle;">
									<span class="label label-success" >{{$data->late}}</span>
								</td>
								@elseif($data->late == "Injury-Time")
								<td style="vertical-align: ;">
									<span class="label label-warning" >{{$data->late}}</span>
								</td>
								@else
								<td style="vertical-align: ;">
									<span class="label label-danger" >{{$data->late}}</span>
								</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
				<div class="box-footer clearfix">
					<p class="pull-right">For more other history information. Click <b id="detail" style="cursor:pointer">here</b></p>
				</div>
				<!-- /.box-footer-->
			</div>

			<!-- Detail box -->
			<div class="box" id="panel_detail" style="display: none;">
				<div class="box-header with-border">
					<h3 class="box-title">My Attendance	</h3>			
				</div>
				<div class="box-body">

					<table class="table table-bordered" id="detail_table">
						<thead>
							<tr>
								<th>My Schedule</th>
								<th>Time</th>
								<th>Date</th>
								<th>Where</th>
								<th style="width: 40px">Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach($datas as $key =>$data)
							<tr>
								<td>{{$kehadiran[$key]->hadir}}</td>
								<td>{{$data->jam}}</td>
								<td>{{date("d/m/Y", strtotime($data->jam))}}</td>
								<td>{{$data->name}}</td>
								@if($data->late == "On-Time")
								<td style="vertical-align: middle;">
									<span class="label label-success" >{{$data->late}}</span>
								</td>
								@elseif($data->late == "Injury-Time")
								<td style="vertical-align: ;">
									<span class="label label-warning" >{{$data->late}}</span>
								</td>
								@else
								<td style="vertical-align: ;">
									<span class="label label-danger" >{{$data->late}}</span>
								</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
				<div class="box-footer clearfix">
					<p class="pull-right">For more other history information. Click <b id="simple" style="cursor:pointer">here</b></p>
				</div>
				<!-- /.box-footer-->
			</div>
			<!-- /.box -->

		</section>
		<!-- /.tab-content -->

	</div>
</div>
</section>
</div>
@endsection
@section('script')
<script>
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
	$('#detail_table').dataTable();
</script>
@endsection