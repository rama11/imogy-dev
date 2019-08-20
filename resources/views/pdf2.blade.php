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
	<h2>
		Attendance Report on {{$data['start']}} to {{$data['end']}}
		<br>MSM Devision
	</h2>
	<table>
		<thead>
			<tr>
				<th style="width: 7px;">#</th>
				<th>Name</th>
				<th>Location</th>

				<th style="width: 50px; text-align: center;" >Ontime</th>
				<th style="width: 50px; text-align: center;" >Tolerance</th>
				<th style="width: 50px; text-align: center;" >Late</th>
				<th style="width: 50px; text-align: center;" >Absent</th>
				<th style="width: 50px; text-align: center;" >Attend</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 0;?>
			@foreach($var as $key => $val)
			<tr>
				<td>{{$no + 1}}.</td>
				<td>{{$key}}</td>
				<td>{{$val['where']}}</td>

				<td style="text-align: center;color:white;" class="ontime2"><span> {{$val['ontime']}}</span></td>
				<td style="text-align: center;color:white;" class="tolerance2"><span> {{$val['injury']}}</span></td>
				<td style="text-align: center;color:white;" class="late2"><span> {{$val['late']}}</span></td>
				<td style="text-align: center;color:white;" class="absent2"><span> {{$val['absen']}}</span></td>
				<td style="text-align: center;color:white;" class="all2"><span> {{$val['all']}}</span></td>

			</tr>
			<?php $no++;?>
			@endforeach
			<tr>
				<th colspan="3" style="text-align: center;">
					Summary
				</th>
				<td style="text-align: center; color:white;" class="ontime">{{$summary['0']}}</td>
				<td style="text-align: center; color:white;" class="tolerance">{{$summary['1']}}</td>
				<td style="text-align: center; color:white;" class="late">{{$summary['2']}}</td>
				<td style="text-align: center; color:white;" class="absent">{{$summary['3']}}</td>
				<td style="text-align: center; color:white;" class="all">{{$summary['4']}}</td>
			</tr>
		</tbody>
	</table>
	<?php $even = 0;?>
	@foreach($details as $detail)
		@if($detail[5] != NULL)
			@if($detail[6] != NULL)
				<h1 style="page-break-before: always;">{{$detail[5]}}</h1>
				<table>
					<thead>
						<tr>
							<th style="text-align: center;">#</th>
							<th style="text-align: center;">Schedule</th>
							<th style="text-align: center;">Prasent Time</th>
							<th style="text-align: center;">Date</th>
							<th style="text-align: center;">Where</th>
							<th style="text-align: center;">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;?>
						@foreach($detail[6] as $detail2)
							<tr>
								<td style="text-align: center;">{{$detail2->id}}.</td>
								<!-- <td>{{$no}}.</td> -->
								<td style="text-align: center;">{{$detail2->hadir}}</td>
								<td style="text-align: center;">{{$detail2->jam}}</td>
								<td rowspan="2" style="text-align: center;">{{$detail2->hari}}, {{$detail2->tanggal}}</td>
								<td  rowspan="2" style="text-align: center;">{{$detail2->location}}</td>
								@if($detail2->late == "On-Time")
									<td  rowspan="2" style="text-align: center;color:white;" class="ontime2"> <span>{{$detail2->late}}</span></td>
								@elseif($detail2->late == "Injury-Time")
									<td  rowspan="2" style="text-align: center;color:white;" class="tolerance2"> <span>{{$detail2->late}}</span></td>
								@elseif($detail2->late == "Late")
									<td  rowspan="2" style="text-align: center;color:white;" class="late2"> <span>{{$detail2->late}}</span></td>
								@else
									<td  rowspan="2" style="text-align: center;color:white;" class="absent2"> <span>{{$detail2->late}}</span></td>
								@endif
							</tr>
							<tr>
								<!-- <td>{{$no}}.</td> -->
								<td style="text-align: center;"><b>Return</b></td>
								@if($detail2->harus_pulang)
									<td style="text-align: center;">{{$detail2->harus_pulang}}</td>
									<td style="text-align: center;">{{$detail2->pulang}}</td>
								@else
									<td style="text-align: center;">Tidak Absen</td>
									<td style="text-align: center;">Tidak Absen</td>
								@endif
								
							</tr>
						<?php $no++;?>
						@endforeach
					</tbody>
				</table>
				<table>
					<tbody>
					<thead>
			<tr>
				<th colspan="3" style="text-align: center;">
					#
				</th>
				

				<th style="width: 50px; text-align: center;" >Ontime</th>
				<th style="width: 50px; text-align: center;" >Tolerance</th>
				<th style="width: 50px; text-align: center;" >Late</th>
				<th style="width: 50px; text-align: center;" >Absent</th>
				<th style="width: 50px; text-align: center;" >Attend</th>
			</tr>
		</thead>
						<tr>
							<th colspan="3" style="text-align: center;">
								Summary
							</th>
							<td style="text-align: center; color:white; width: 60px;" class="ontime">{{$detail[0][2]}}</td>
							<td style="text-align: center; color:white; width: 60px;" class="tolerance">{{$detail[0][1]}}</td>
							<td style="text-align: center; color:white; width: 60px;" class="late">{{$detail[0][0]}}</td>
							<td style="text-align: center; color:white; width: 60px;" class="absent">{{$detail[0][3]}}</td>
							<td style="text-align: center; color:white; width: 60px;" class="all">{{$detail[0][4]}}</td>
						</tr>
					</tbody>
				</table>
			@else
				<h1 style="page-break-before: always;">{{$detail[5]}}</h1>
				<table>
					<thead>
						<tr>
							<th style="width: 6px;">#</th>
							<th style="width: 60px; text-align: center;">Schedule</th>
							<th style="width: 90px; text-align: center;">Prasent Time</th>
							<th>Date</th>
							<th>Where</th>
							<th style="width: 100px; text-align: center;">Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="6" style="background-color: #f2f2f2;text-align: center;">
								No data yet for this user on this time.
							</td>
						</tr>
					</tbody>
				</table>
			@endif
		@endif
	@endforeach
</body>
</html>


