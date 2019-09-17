<!DOCTYPE html>
<html>
<head>
	<title>
		Report Ticket
	</title>
	<style type="text/css">
		#customers {
			font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		#customers td, #customers th {
			border: 1px solid #ddd;
			padding: 8px;
		}

		#customers tr:nth-child(even){background-color: #f2f2f2;}

		#customers tr:hover {background-color: #ddd;}

		#customers th {
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			background-color: #4CAF50;
			color: white;
		}
	</style>
</head>
<body>
	<table id="customers">
		<tr>
			<th>ID Ticket</th>
			<th>ID ATM</th>
			<th>Serial</th>
			<th>Status</th>
			<th>Number Ticket</th>
			<th>Open Ticket</th>
			<th>Problem</th>
			<th>Location</th>
			<th>PIC</th>
			<th>Engginer</th>
			<th>Close Ticket</th>
			<th>Root Couse</th>
			<th>Counter Measure</th>
			<!-- <th>ID Ticket</th> -->
		</tr>
		@foreach($result as $result)
		<tr>
			<td>{{$result->id_ticket}}</td>
			<td>{{$result->id_atm}}</td>
			<td>{{$result->serial_device}}</td>
			<td>{{$result->statu[0]}}</td>
			<td>{{$result->ticket_number_3party}}</td>
			<td>{{$result->activity['open']}}</td>
			<td>{{$result->problem}}</td>
			<td>{{$result->location}}</td>
			<td>{{$result->pic}} - {{$result->contact_pic}}</td>
			<td>{{$result->engineer}}</td>
			<td>{{$result->activity['close']}}</td>
			<td>{{$result->resolve['root_couse']}}</td>
			<td>{{$result->resolve['counter_measure']}}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>