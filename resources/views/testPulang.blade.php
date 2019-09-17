<!DOCTYPE html>
<html>
<head>
	<title>Test Pulang</title>
	<style type="text/css">
		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		td, th {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}
	</style>
</head>
<body>
	<table>
		
		<tbody>
			<tr>
				<th colspan="9" style="background: #141414; color:white;">
					<h2>{{ $awal = $results[0]->tanggal }}</h2>
				</th>
			</tr>
			<tr>
				<th>ID</th>
				<th>Nickname</th>
				<th>Hadir</th>
				<th>Jam</th>
				<th>Tanggal</th>
				<th>Locaton</th>
				<th>Condition</th>
				<th>Pulang</th>
				<th>Harus Pulang</th>
			</tr>
			@foreach($results as $result)
				@if($result->tanggal == $awal)
					@if($result->pulang == "")
						<tr style="background-color: #e74c3c">
							<td>{{$result->id}}</td>
							<td>{{$result->nickname}}</td>
							<td>{{$result->hadir}}</td>
							<td>{{$result->jam}}</td>
							<td>{{$result->tanggal}}</td>
							<td>{{$result->name}}</td>
							<td>{{$result->late}}</td>
							<td>{{$result->pulang}}</td>
							<td>{{$result->harus_pulang}}</td>
						</tr>
					@else
						<tr>
							<td>{{$result->id}}</td>
							<td>{{$result->nickname}}</td>
							<td>{{$result->hadir}}</td>
							<td>{{$result->jam}}</td>
							<td>{{$result->tanggal}}</td>
							<td>{{$result->name}}</td>
							<td>{{$result->late}}</td>
							<td>{{$result->pulang}}</td>
							<td>{{$result->harus_pulang}}</td>
						</tr>
					@endif
				@else
					<tr>
						<th colspan="9" style="background: #141414; color:white;">
							<h2>{{$result->tanggal}}</h2>
						</th>
					</tr>
					<tr>
						<th>ID</th>
						<th>Nickname</th>
						<th>Hadir</th>
						<th>Jam</th>
						<th>Tanggal</th>
						<th>Locaton</th>
						<th>Condition</th>
						<th>Pulang</th>
						<th>Harus Pulang</th>
					</tr>
					<?php $awal = $result->tanggal?>
					@if($result->pulang == "")
						<tr style="background-color: #e74c3c">
							<td>{{$result->id}}</td>
							<td>{{$result->nickname}}</td>
							<td>{{$result->hadir}}</td>
							<td>{{$result->jam}}</td>
							<td>{{$result->tanggal}}</td>
							<td>{{$result->name}}</td>
							<td>{{$result->late}}</td>
							<td>{{$result->pulang}}</td>
							<td>{{$result->harus_pulang}}</td>
						</tr>
					@else
						<tr>
							<td>{{$result->id}}</td>
							<td>{{$result->nickname}}</td>
							<td>{{$result->hadir}}</td>
							<td>{{$result->jam}}</td>
							<td>{{$result->tanggal}}</td>
							<td>{{$result->name}}</td>
							<td>{{$result->late}}</td>
							<td>{{$result->pulang}}</td>
							<td>{{$result->harus_pulang}}</td>
						</tr>
					@endif
				@endif
			@endforeach
		</tbody>
	</table>
</body>
</html>
