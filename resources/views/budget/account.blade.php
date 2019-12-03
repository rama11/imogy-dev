@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('head')
<link rel="stylesheet" href="{{url('plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{url('plugins/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.1/css/rowGroup.bootstrap.min.css">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<link rel="stylesheet" href="{{ url('plugins/timepicker/bootstrap-timepicker.min.css')}}">
<link rel="stylesheet" href="{{ url('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{ url('plugins/morris/morris.css')}}">

<link rel="stylesheet" href="{{ url('plugins/datepicker/datepicker3.css')}}">
<style type="text/css">
	.dataTables_filter {display: none;}
	td.details-control {
		text-align: center;
		vertical-align: middle;
		cursor: pointer;
	}
	
</style>
@endsection
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Manage
			<!-- <small>finish and update all activiy of project</small> -->
		</h1>
		<ol class="breadcrumb">
			<button type="button" class="btn btn-flat btn-primary btn-xs" data-toggle="modal" data-target="#modalAddPID" onclick=''>Add Account</button>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">All Account</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<table id="tableBudgetAccout" class="table table-hover">
							<thead>
								<tr>
									<th></th>
									<th>Customer</th>
									<th>PID</th>
									<th>Project Name</th>
									<th>Budget</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="modalAddPID">
			<div class="modal-dialog" id="modal-default-size">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Add Account</h4>
					</div>
					<div class="modal-body">
						<!-- <p>Please input detail customer</p> -->
						<form role="form">
							<div class="form-group">
								<label>PID</label>
								<input type="text" class="form-control" id="inputAccountPID" required>
							</div>
							<div class="form-group">
								<label>Customer</label>
								<input type="text" class="form-control" id="inputAccountCustomer" required>
							</div>
							<div class="form-group">
								<label>Detail</label>
								<input type="text" class="form-control" id="inputAccountDetail" required>
							</div>
							<!-- <div class="form-group">
								<label>Start</label>
								<input type="text" class="form-control" id="inputAccountStart" required>
							</div>
							<div class="form-group">
								<label>End</label>
								<input type="text" class="form-control" id="inputAccountEnd" required>
							</div> -->
							<div class="form-group">
								<label>Total Budget</label>
								<input type="text" class="form-control" id="inputAccountNominal" required>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="setAccount()">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>

@endsection 

@section('script')
<!-- moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<!-- HumanizeDuration.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/humanize-duration/3.20.1/humanize-duration.js"></script>
<!-- bootstrap datepicker -->
<script src="{{url('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>

<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.1.1/js/dataTables.rowGroup.min.js"></script>

<script src="{{url('js/hue-to-rgb.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>


<!-- <script src="{{url('plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{url('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{url('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script> -->

<script defer src="https://www.gstatic.com/firebasejs/6.1.1/firebase-app.js"></script>
<script defer src="https://www.gstatic.com/firebasejs/6.1.1/firebase-database.js"></script>

<script>
	$(document).ready(function(){
		
		// $('#inputNoteDate').datepicker({
		// 	autoclose: true,
		// 	format: 'dd/mm/yyyy'
		// });

		$("#inputAccountStart").inputmask("date");
		$("#inputAccountEnd").inputmask("date");
		$("#inputNoteNominal").inputmask("decimal",{
			radixPoint:",", 
			groupSeparator: ".", 
			digits: 2,
			autoGroup: true,
			prefix: 'Rp '
		});
		initBudgetTable();

		$('#tableBudgetAccout tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = $("#tableBudgetAccout").DataTable().row( tr );
			if ( row.child.isShown() ) {
				row.child.hide();
				tr.removeClass('shown');
				$(this).closest('tr > td').children().attr("class","fa fa-plus");
				// $(this).closest('tr > td').children().css("background","white");
			}
			else {
				row.child( format(row.data()) ).show();
				tr.addClass('shown');
				$(this).closest('tr > td').children().attr("class","fa fa-minus");
				// $(this).closest('tr > td').children().css("background","red");
			}
		});
		// $("#inputNoteNominal").inputmask();
	})

	function prepareAddNote(){
		$.ajax({
			type:"GET",
			url:"{{url('budget/getDataParameterNote')}}",
			success: function(result){

				$("#inputNotePID").select2({
					placeholder: "Select a Account",
					data: result.account
				});
				$("#inputNoteIssuer").select2({
					placeholder: "Select a Account",
					data: result.issuer
				});

				$("#inputNoteIssuer").select2();
				console.log(result)
			}
		})
	}

	function setAccount(){
		$.ajax({
			type:"POST",
			url:"{{url('budget/account/setAccount')}}",
			data:{
				_token:'{{csrf_token()}}',
				PID:$("#inputAccountPID").val(),
				customer:$("#inputAccountCustomer").val(),
				project_name:$("#inputAccountDetail").val(),
				// start:$("#inputAccountStart").val(),
				// end:$("#inputAccountEnd").val(),
				budget:$("#inputAccountNominal").val(),
			},
			success: function(result){
				$("#tableBudgetAccout").DataTable().ajax.url("{{url('budget/account/setAccount')}}").load()
				alert('success')
			}
		})
	}

	function initBudgetTable(){

		$("#tableBudgetAccout").DataTable({
			"ajax":{
				"type":"GET",
				"url":"{{url('budget/account/getDataAccount')}}",
				"dataSrc": function (json){
					// load a locale
					numeral.register('locale', 'id', {
					    delimiters: {
					        thousands: '.',
					        decimal: ','
					    },
					    abbreviations: {
					        thousand: 'k',
					        million: 'm',
					        billion: 'b',
					        trillion: 't'
					    },
					    currency: {
					        symbol: 'Rp '
					    }
					});

					// switch between locales
					numeral.locale('id');

					json.data.forEach(function(data,index){
						data.budget_formated = numeral(data.budget).format('$0,0.00');
						data.details_controls = "<i class='fa fa-plus'></i>";
						// data.status = "Active"
					});
					return json.data;
				}
			},
			// "rowGroup": {
	  //           "dataSrc": "customer"
	  //       },
			"columns": [
				{
					"className": 'details-control',
					"orderable": false,
					"data": "details_controls",
					"defaultContent": ''
				},
				{ "data": "customer" },
				{ "data": "PID" },
				{ "data": "project_name" },
				{ 
					"data": "budget_formated",
					"orderData" : [ 5 ],
					"targets" : [ 1 ],
					"className" : "text-right"
				},
				{ 
					"data": "budget",
					"targets": [ 5 ] ,
					"visible": false ,
					"searchable": true
				},
				// { 
				// 	"data": "status",
				// 	"visible": false ,
				// 	"searchable": true
				// },
			],
			"searching": true,
			"paging": false,
			"info":false,
			"scrollX": false,
		})

	}

	function format ( d ) {
		// `d` is the original data object for the row
		return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
			'<tr>'+
				'<td>Full name:</td>'+
				'<td>Full name:</td>'+
			'</tr>'+
			'<tr>'+
				'<td>Extension number:</td>'+
				'<td>Extension number:</td>'+
			'</tr>'+
			'<tr>'+
				'<td>Extra info:</td>'+
				'<td>And any further details here (images etc)...</td>'+
			'</tr>'+
		'</table>';
	}
</script>
@endsection