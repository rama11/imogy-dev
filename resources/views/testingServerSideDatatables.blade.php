@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('head')
		<link rel="stylesheet" href="{{ url('plugins/datatables/dataTables.bootstrap.css')}}">

@endsection
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<img src="img/tisygy.png" width="120" height="35">
			<small >Ticketing System Sinergy</small>
		</h1>
	</section>

	<section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="active">
					<a href="#tab_1" data-toggle="tab">Dashboard</a>
				</li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<!-- <table id="dataTables" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Email</th>
								<th>Created At</th>
								<th>Updated At</th>
							</tr>
						</thead>
					</table> -->
					<table class="table table-bordered table-striped" id="dataTables">
								<thead>
									<th style="width: 120px;text-align:center;vertical-align: middle;">ID Ticket</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">ID ATM*</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">Ticket Number</th>
									<th style="vertical-align: middle;">Problem</th>
									<th style="text-align: center;vertical-align: middle;">PIC</th>
									<th style="width: 100px;vertical-align: middle;">Location</th>
									
								</thead>
								<tfoot>
									<th style="width: 120px;text-align:center;vertical-align: middle;">ID Ticket</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">ID ATM*</th>
									<th style="width: 100px;text-align:center;vertical-align: middle;">Ticket Number</th>
									<th style="vertical-align: middle;">Problem</th>
									<th style="text-align: center;vertical-align: middle;">PIC</th>
									<th style="width: 100px;vertical-align: middle;">Location</th>
									
								</tfoot>
							</table>
				</div>
			</div>
		</div>
	</section>
</div>
<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Version</b> 2.4.0
	</div>
	<strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
	reserved.
</footer>
@endsection 
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="{{ url('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script>
	$(document).ready(function(argument) {
		$("#dataTables").DataTable({
				processing: true,
				serverSide: true,
				ajax:{
					type:"GET",
					url:"{{url('testingGetDataServerSide')}}",
				},
				columns:[
					{
						data:'id_ticket',
						width:"12.5%"
					},
					{ 	
						data:'id_atm',
						className:'text-center',
						width:"5%"
					},
					{
						data:'ticket_number_3party',
						className:'text-center',
						width:"5%"
					},
					{
						data:'problem',
						// width:"25%"
					},
					{ 
						data:'pic',
						className:'text-center',
						width:"10%"
					},
					{
						data:'location',
						width:"12%"
					},
					
				],
				// order: [[10, "DESC" ]],
				autoWidth:false,
				lengthChange: false,
				searching:true,
				
			})
		// $("#dataTables").DataTable({
		// 	processing: true,
		// 	serverSide: true,
		// 	ajax: "{{url('testingGetDataServerSide')}}",
		// 	columns: [
		// 		{ data: 'id', name: 'id' },
		// 		{ data: 'name', name: 'name' },
		// 		{ data: 'email', name: 'email' },
		// 		{ data: 'created_at', name: 'created_at' },
		// 		{ data: 'updated_at', name: 'updated_at' }
		// 	]
		// });
	})
</script>
@endsection
