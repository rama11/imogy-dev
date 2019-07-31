@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')

@section('content')
<style>

html{
			font-family: Verdana,sans-serif;
			font-size: small;
		}
		table {
		    border-collapse: collapse;
		    width: 100%;
		}

		th, td {
		    text-align: left;
		    padding: 8px;
		}

		tr:nth-child(even){background-color: #f2f2f2}

		th {
		    background-color: #2b4e62;
		    color: white;
		}
		.badge {
			background-color: #000;
			color: #fff;
			/*display: inline-block;*/
			padding: 8px;
			text-align: center;
			border-radius: 50%;
		}
		.ontime {
			background-color: #00a65a;
		}
		.tolerance {
			background-color: #f39c12;
		}
		.late {
			background-color: #dd4b39;
		}
		.absent {
			background-color: #777;
		}
		.all {
			background-color: #0073b7;
		}


		.ontime2 {
			background-color: rgba(0,166,90,0.7);
		}
		.tolerance2 {
			background-color: rgba(243,156,18,0.7);
		}
		.late2 {
			background-color: rgba(221,75,57,0.7);
		}
		.absent2 {
			background-color: rgba(119,119,119,0.7);
		}
		.all2 {
			background-color: rgba(0,115,183,0.7);
		}

		h2 {
			border-bottom: 15px solid #fff;
		}
		
</style>	
		<div class="content-wrapper">
			<section class="content-header" >
				<a href="{{url('absen')}}">
					<img src="img/labelaogy.png" width="120" height="40">
				</a>
				<ol class="breadcrumb" style="font-size: 15px;">
					<li><a href="{{url('ahistory')}}">
						<i class="fa fa-book"></i>My Attendance</a>
					</li>
					@if(Auth::user()->role == "1")
						<li>
							<a href="{{url('ateamhistory')}}">
								<i class="fa fa-users"></i>
								Team Attendance
							</a>
						</li>
						<li>
							<a href="{{url('areport')}}">
							<i class="fa fa-users"></i>
							Reporting
						</a>
						</li>
					@endif
				</ol>
			</section>
			<section class="content">
				<div class="box" id="panel_simple">
					<div class="box-header with-border">
						<h3 class="box-title">My Attendance	on {{date('F')}}</h3>			
					</div>
					<div class="col-md-4">
						<div class="box box-solid">
							<div class="box-body">
								<div class="row">
									<div class="col-md-8">
										<div class="chart-responsive">
											<div class="progress vertical">
												<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="{{$persen[2]}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$persen[2]}}%">
													<span class="sr-only">{{$persen[2]}}%</span>
												</div>
											</div>
											<div class="progress vertical">
												<div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="{{$persen[1]}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$persen[1]}}%">
													<span class="sr-only">{{$persen[1]}}%</span>
												</div>
											</div>
											<div class="progress vertical">
												<div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="{{$persen[0]}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$persen[0]}}%">
													<span class="sr-only">{{$persen[0]}}%</span>
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
										<ul class="chart-legend clearfix">
											<li><i class="fa fa-circle-o text-green"></i> Ontime</li>
											<li><i class="fa fa-circle-o text-yellow"></i> Injury</li>
											<li><i class="fa fa-circle-o text-red"></i> Late</li>
											<li><i class="fa fa-circle-o text-blue"></i> Absent</li>
										</ul>
									</div>
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-pills nav-stacked">
									<li><a href="#">Ontime ({{$count[2]}})
											<span class="pull-right text-green">+{{$persen[2]}}%</span></a>
										</li>
										<li><a href="#">Injury Time ({{$count[1]}})
											<span class="pull-right text-yellow">+{{$persen[1]}}%</span></a>
										</li>
										<li><a href="#">Late ({{$count[0]}})
											<span class="pull-right text-red">+{{$persen[0]}}%</span></a>
										</li>
										<li><a href="#">Absent ({{$count[4]}})
											<span class="pull-right text-blue">-{{$persen[3]}}%</span></a>
										</li>
										<li><a href="#"><b>Attendance ({{$count[3]}})</b>
											<span class="pull-right ">{{$persen[4]}}%</span></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body col-md-8">
						<table id="table_id" class="table table-bordered">
								<tr>
									<th style="text-align: center;">My Schedule</th>
									<th style="text-align: center;">My Present Time</th>
									<th style="text-align: center;">Date</th>
									<th style="text-align: center;">Where</th>
									<th style="width: 40px" style="text-align: center;">Status</th>
								</tr>
							<tbody>
								
								@foreach($datas as $key =>$data)
									<tr>
										<td>{{$kehadiran[$key]->hadir}}</td>
										<td>{{$data->jam}}</td>
										<td rowspan="2" style="vertical-align: middle;text-align: center;">{{date("d/m/Y", strtotime($data->tanggal))}}</td>
										<td rowspan="2" style="vertical-align: middle;text-align: center;">{{$data->location}}</td>
										@if($data->late == "On-Time")
											<td rowspan="2" style="vertical-align: middle;text-align: center;">
												<span class="label label-success" >{{$data->late}}</span>
											</td>
										@elseif($data->late == "Injury-Time")
											<td rowspan="2" style="vertical-align: middle;text-align: center;">
												<span class="label label-warning" >{{$data->late}}</span>
											</td>
										@elseif($data->late == "Late")
											<td rowspan="2" style="vertical-align: middle;text-align: center;">
												<span class="label label-danger" >{{$data->late}}</span>
											</td>
										@else
											<td rowspan="2" style="vertical-align: middle;text-align: center;">
												<span class="label label-info" >{{$data->late}}</span>
											</td>
										@endif
									</tr>
									<tr>	
										@if($data->harus_pulang)
											<td style="text-align: right;">{{$data->harus_pulang}}</td>
											<td style="text-align: right;">{{$data->pulang}}</td>
										@else
											<td style="text-align: right;">-</td>
											<td style="text-align: right;">-</td>
										@endif
									</tr>
								@endforeach
							</tbody>
						</table>
						<!-- <ul class="pagination pull-left">
                			<li><a href="#">Prev</a></li>
               				<li><a href="#">1</a></li>
                			<li><a href="#">2</a></li>
                			<li><a href="#">Next</a></li>
              			</ul>
						  <br> -->
						  <br>
						  <p class="text-left">
							For more other history information. Click <a href="{{url('ahistory2')}}" style="cursor:pointer">here</b>
						  </p>
						  <a href="{{url('downloadPDF',Auth::user()->id)}}">
							<button type="button" class="btn btn-primary pull-right">
								<i class="fa fa-download"></i> Download Report
							</button>
						  </a>
					</div>
					<div class="box-footer clearfix">

					</div>
				</div>
			</section>
		</div>

	@endsection
	@section('script')
	