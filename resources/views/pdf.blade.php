<!DOCTYPE html>
<html>
<head>
@isset($tittle)
	<title>
			{{ $tittle }} 
	</title>
	@endisset
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
			border-bottom: 10px solid #fff;
		}
	</style>
</head>
<body>

	<div style="text-align: right;line-height: 0.5;">
		<p>Created at : {{date('l, d F Y')}}</p>
		<p>By : {{Auth::user()->name}}</p>
	</div>
	<br>
	<h2>
		Attendance on {{date('F')}} for {{$name}}
	</h2>

	
<table class="table table-bordered" id="table_id">
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
		<div class="row">
			<div class="col-12 d-flex jutify-content-end">

			</div>
		</div>
	</tbody>
</table>
	<!-- <h2>On Time : {{$count['2']}}</h2>
	<h2>Injury : {{$count['1']}}</h2>
	<h2>Late : {{$count['0']}}</h2>
	<h2>Absent : {{$absen}}</h2>
	<h2>Attendance : {{$count['2'] + $count['1'] + $count['0']}}</h2>
	<br> -->
</body>
</html>


