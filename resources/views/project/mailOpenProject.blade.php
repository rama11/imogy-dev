<div style="color: #141414;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;">
	<p id="emailOpenHeader" style="margin: 0 0 10px;box-sizing: border-box;font-size: 14px;line-height: 1.42857143;color: #555;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;font-weight: 400;">
	</p>
	<p>
		Dear All,
		<br>Sehubungan dengan adanya project baru, saya sebagai project coordinator disini akan menyampaikan project yang akan kita kerjakan bersama. 
		<br>Berikut untuk detailnya :
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
			<th>Jumlah Periode</th>
			<th>:</th>
			<td>{{$data["period"]}}</td>
		</tr>
		<tr>
			<th>Durasi Periode</th>
			<th>:</th>
			<td>{{$data["duration"]}}</td>
		</tr>
		<tr style="color: white;">
			<td>a</td>
		</tr>
		<tr>
			<th colspan="3">Sekema Periode</th>
		</tr>
		<tr>
			<td colspan="3">
				<table style="text-align: left;">
					<tr>
						<th>Periode</th>
						<th colspan="2" style="text-align: center;">Start</th>
						<th colspan="2" style="text-align: center;">End</th>
					</tr>
					@foreach($data["start"] as $key => $value)
					<tr>
						<th>Periode {{($key + 1)}}</th>
						<td></td>
						<td style="text-align: right;">{{$value}}</td>
						<td style="text-align: center;"><b>-</b></td>
						<td colspan="2" style="text-align: left;">{{$data["end"][$key]}}</td>
					</tr>
					@endforeach
				</table>
			</td>
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
