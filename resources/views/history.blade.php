@extends('layouts.baru')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>History Absent Table</h2>

			<!-- Siple Table -->
			<div class="panel panel-default" id="panel_simple">
				<div class="panel-heading">
					<div class="panel-title">
						My Absen History
					</div>
				</div>
				<div class="panel-body">
					<p>This is your 10 last login. Check this history frequenly for futher, thanks</p>            
					<table class="table table-condensed table-hover table-striped" id="simple_table">
						<thead>
							<tr>
								<th>Time</th>
								<th>Date</th>
								<th>Where</th>
								<th>On Time</th>
							</tr>
						</thead>
						<tbody>
							@foreach($datas as $data)
							<tr>
								<td>{{$data->jam}}</td>
								<td>{{$data->tanggal}}</td>
								<td>{{$data->name}}</td>
								@if($data->late == "No")
								<td style="vertical-align: middle;">
									<span class="label label-danger" >{{$data->late}}</span>
								</td>
								@else
								<td style="vertical-align: middle;">
									<span class="label label-success" >{{$data->late}}</span>
								</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="panel-footer text-right">
					<p>For more other history information. Click <b id="detail" style="cursor:pointer">here</b></p>
				</div>
			</div>

			<!-- Detailed Table -->
			<div class="panel panel-default" id="panel_detail" style="display: none;">
				<div class="panel-heading">
					<div class="panel-title">
						My Detail Absen History
					</div>
				</div>
				<div class="panel-body">
					<p>This are all of your last login. Check this history frequenly for futher, thanks</p>            
					<table class="table table-condensed table-hover table-striped" id="detail_table">
						<thead>
							<tr>
								<th>Time</th>
								<th>Date</th>
								<th>Where</th>
								<th>On Time</th>
							</tr>
						</thead>
						<tbody>
							@foreach($datas2 as $data)
							<tr>
								<td>{{$data->jam}}</td>
								<td>{{$data->tanggal}}</td>
								<td>{{$data->name}}</td>
								@if($data->late == "No")
								<td style="vertical-align: middle;">
									<span class="label label-danger" >{{$data->late}}</span>
								</td>
								@else
								<td style="vertical-align: middle;">
									<span class="label label-success" >{{$data->late}}</span>
								</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="panel-footer text-right">
					<p>For more other history information. Click <b id="detail" style="cursor:pointer">here</b></p>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
<script src="{{ asset('js/jquery.js') }}"></script>
@section('script')
<script>
	$(document).ready(function(){
		console.log('asdfasdf');
		
		// Click to Detail
		$("#detail").click(function () {
			console.log('asdfasdf');
			$("#panel_simple").fadeOut(function () {
				$("#panel_detail").fadeIn();
			});
		});

		//Click to Simple
		$("#simpe").click(function () {
			console.log('asdfasdf');
			$("#panel_detail").fadeOut(function () {
				$("#panel_simple").fadeIn();
			});
		});
	});

	//Init for DataTable
	$('#detail_table').dataTable();
</script>
@endsection