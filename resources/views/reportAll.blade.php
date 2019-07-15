<!DOCTYPE html>
<html>
<head>
	<title>Get Report Helpdesk</title>
	<style type="text/css">
		table {
			border: 1px solid;
		}
		tr {
			border: 1px solid;
		}
		td {
			border: 1px solid;
		}
	</style>
</head>
<body>
	<h1>All Time</h1>
	<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Open</th>
				<th>Close</th>
				<th>Cancel</th>
				<th>Respond</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $users)
			<tr>
				<td>{{$users[0]}}</td>
				<td>{{$users[1][3]->operator}}</td>
				<td>{{$users[1][1]->operator}}</td>
				<td>{{$users[1][0]->operator}}</td>
				<td>{{$users[2]}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@foreach($permonths as $key => $month)
	<h1>{{$key}}</h1>
	<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Open</th>
				<th>Close</th>
				<th>Cancel</th>
				<th>Respond</th>
			</tr>
		</thead>
		<tbody>
			@foreach($month as $users)
			<tr>
				<td>{{$users[0]}}</td>
				<td>{{$users[1][3]}}</td>
				<td>{{$users[1][1]}}</td>
				<td>{{$users[1][0]}}</td>
				<td>{{$users[2]}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@endforeach
	

</body>
</html>