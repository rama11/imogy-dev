<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
			border: 1px solid #141414;
			line-height: 1.42857143;
			vertical-align: top;
		}
	</style>
</head>
<body>
	<h1>
		Attendance on {{date('F')}} for {{$name}}
	</h1>

	<h2>On Time : {{$count['2']}}</h2>
	<h2>Injury : {{$count['1']}}</h2>
	<h2>Late : {{$count['0']}}</h2>
	<h2>Absent : {{$absen}}</h2>
	<h2>Attendance : {{$count['2'] + $count['1'] + $count['0']}}</h2>
	<br>
	<table class="table-bordered">
		<tr>
			<th>My Schedule</th>
			<th>My Present Time</th>
			<th>Date</th>
			<th>Where</th>
			<th style="width: 40px">Status</th>
		</tr>
		@foreach($datas as $key => $data)
		<tr>
			<td>{{$kehadiran[$key]->hadir}}</td>
			<td>{{$data->jam}}</td>
			<td>{{date("d/m/Y", strtotime($data->tanggal))}}</td>
			<td>{{$data->location}}</td>
			@if($data->late == "On-Time")
			<td style="vertical-align: middle;">
				<span>{{$data->late}}</span>
			</td>
			@elseif($data->late == "Injury-Time")
			<td style="vertical-align: middle;">
				<span>{{$data->late}}</span>
			</td>
			@else
			<td style="vertical-align: middle;">
				<span>{{$data->late}}</span>
			</td>
			@endif
		</tr>
		@endforeach
	</table>


</body>
</html>


