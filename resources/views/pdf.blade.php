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
		<p>Ceated at : {{date('l, d F Y')}}</p>
		<p>By : {{Auth::user()->name}}</p>
	</div>
	<h2>
		Attendance on {{date('F')}} for {{$name}}
	</h2>

	
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
	<!-- <h2>On Time : {{$count['2']}}</h2>
	<h2>Injury : {{$count['1']}}</h2>
	<h2>Late : {{$count['0']}}</h2>
	<h2>Absent : {{$absen}}</h2>
	<h2>Attendance : {{$count['2'] + $count['1'] + $count['0']}}</h2>
	<br> -->


</body>
</html>


