<div style="color: #141414;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;">
	<p id="emailOpenHeader" style="margin: 0 0 10px;box-sizing: border-box;font-size: 14px;line-height: 1.42857143;color: #555;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;font-weight: 400;">
	</p>
	<p>
		Dear All,
		<br>Karena telah update nya menjadi status finish, dengan ini periode project ini dinyatakan selesai.
		<br>Untuk detail lebih lanjut bisa dilihat lebih lanjut di bawah ini.
		<br>
		<br>
	</p>
	<table style="text-align: left;margin: 5px;">
		<tr>
			<th>Customer</th>
			<th>:</th>
			<td>{{$data["customer"]}}</td>
		</tr>
		<tr>
			<th>Nama Project</th>
			<th>:</th>
			<td>{{$data["name_project"]}}</td>
		</tr>
		<tr>
			<th>Poject ID</th>
			<th>:</th>
			<td>{{$data["project_id"]}}</td>
		</tr>
		<tr style="color: white;">
			<td>a</td>
		</tr>
		<tr>
			<th>Project Coordinator</th>
			<th>:</th>
			<td>{{$data["coordinatorName"]}}</td>
		</tr>
		<tr>
			<th>Team Lead</th>
			<th>:</th>
			<td>{{$data["teamLeadName"]}}</td>
		</tr>
		<tr style="vertical-align: top;">
			<th>Team Member</th>
			<th>:</th>
			<td>
				@foreach($data["teamMemberName"] as $value)
				{{$value}}<br>
				@endforeach
			</td>
		</tr>
		<tr style="color: white;">
			<td>a</td>
		</tr>
		<tr>
			<th>Duration</th>
			<th>:</th>
			<td>{{$data["duration"]}}</td>
		</tr>
		<tr>
			<th>Active Periode</th>
			<th>:</th>
			<td>{{$data["activePeriod"]}}</td>
		</tr>
		
		<tr style="color: white;">
			<td>a</td>
		</tr>
		<tr style="vertical-align: top;">
			<th>History Periode</th>
			<th>:</th>
			<td>
				@foreach($data["historyPeriod"] as $history)
				[{{$history['time']}} - {{$history['updater']}}] {{$history['note']}}<br>
				@endforeach
			</td>
		</tr>
		<tr style="color: white;">
			<td>a</td>
		</tr>
		<tr style="vertical-align: top;">
			<th>Finish note</th>
			<th>:</th>
			<td>
				<b>[{{$data["finish_time"]}} - {{$data["finish_updater"]}}]<br>
				{{$data["finish_note"]}}</b>
			</td>
		</tr>
		<tr style="color: white;">
			<td>a</td>
		</tr>
		<tr>
			<th>Next Periode</th>
			<th>:</th>
			<td>{{$data["nextPeriod"]}}</td>
		</tr>
	</table>
	<br>
	Sekian yang dapat saya sampaikan, bila ada pertanyaan lebih lanjut silakan untuk membalas email ini.
	<p>
		Thanks<br>
		Best Regard,
	</p>
	<h4 style="color: #3c8dbc !important;margin-bottom: 0px" class="text-light-blue" >{{$data["name"]}}</h4>
	<h5 style="color: #f39c12 !important;margin-top: 0px" class="text-yellow" ><i>Project Coordinator</i></h5>
	<p>
		----------------------------------------<br>
		PT. Sinergy Informasi Pratama (SIP)<br>
		| Inlingua Building 2nd Floor |<br>
		| Jl. Puri Raya, Blok A 2/3 No. 33-35 | Puri Indah |<br>
		| Kembangan | Jakarta 11610 – Indonesia |<br>
		| Mobile | {{$data["phone"]}} |<br>
		| Phone | 021 - 58355599 |<br>
		----------------------------------------<br>
	</p>
</div>
