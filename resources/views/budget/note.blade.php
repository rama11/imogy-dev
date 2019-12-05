@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('head')
		
		<!-- Start of head section -->
		<link rel="stylesheet" href="{{url('plugins/datepicker/datepicker3.css')}}">
		<link rel="stylesheet" href="{{url('plugins/select2/select2.min.css')}}">
		<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.1/css/rowGroup.bootstrap.min.css">
		<link rel="stylesheet" href="{{url('plugins/datatables/dataTables.bootstrap.css')}}">


		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
		<!-- <link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}"> -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="{{ url('plugins/timepicker/bootstrap-timepicker.min.css')}}">
		<!-- <link rel="stylesheet" href="{{ url('plugins/datatables/dataTables.bootstrap.css')}}"> -->
		<link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker.css')}}">
		<link rel="stylesheet" href="{{ url('plugins/morris/morris.css')}}">

		<link rel="stylesheet" href="{{ url('plugins/datepicker/datepicker3.css')}}">
		<!-- <link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}"> -->
		<style type="text/css">
			.dataTables_filter {display: none;}
			td.details-control {
				text-align: center;
				vertical-align: middle;
				cursor: pointer;
			}

			.swal2-margin {
				margin: .3125em;
			}
			.label {
			    border-radius: 0px !important;
			}
			
		</style>
		<!-- End of head section -->
@endsection
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Manage
			<!-- <small>finish and update all activiy of project</small> -->
		</h1>
		<ol class="breadcrumb">
			<button type="button" class="btn btn-flat btn-success btn-xs" data-toggle="modal" data-target="#modalAddNote" onclick='prepareAddNote()'>Add Note</button>
		</ol>
	</section>
	<section class="content">
		
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">All Note</h3>
						
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="box-tools pull-left">
									<div class="input-group-btn">
										<button type="button" id="btnShowEntryNote" class="btn btn-flat btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="margin-right: 5px;">
											Show 10 Entrys
											<span class="fa fa-caret-down"></span>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#" style="color: #333;" onclick="changeNumberEntries(10)">10</a></li>
											<li><a href="#" style="color: #333;" onclick="changeNumberEntries(25)">25</a></li>
											<li><a href="#" style="color: #333;" onclick="changeNumberEntries(50)">50</a></li>
											<li><a href="#" style="color: #333;" onclick="changeNumberEntries(100)">100</a></li>
										</ul>
									</div>	
									<div class="input-group-btn">
										<button type="button" id="btnShowGrouping" class="btn btn-flat btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="margin-right: 5px;">
											Group By : Account
											<span class="fa fa-caret-down"></span>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#" style="color: #333;" onclick="changeGroupingTable('PID','Account','9')">Account</a></li>
											<li><a href="#" style="color: #333;" onclick="changeGroupingTable('issuer','Issuer','3')">Issuer</a></li>
											<li><a href="#" style="color: #333;" onclick="changeGroupingTable('customer','Customer','10')">Customer</a></li>
											<li><a href="#" style="color: #333;" onclick="changeGroupingTable('month','Month','1')">Month</a></li>
										</ul>
									</div>
									<!-- <div class="input-group-btn">
										<button type="button" class="btn btn-flat btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="margin-right: 5px;">
											Filter
											<span class="fa fa-caret-down"></span>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#">Progress</a></li>
											<li><a href="#">Finish</a></li>
										</ul>
									</div> -->
									
								</div>
								<div class="box-tools pull-right">
									<input type="text" class="form-control input-sm" id="searchBarNote" placeholder="Search">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<table id="tableBudgetNote" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th></th>
											<th>Date</th>
											<th>Document</th>
											<th>Issuer</th>
											<th>Purpose</th>
											<th>Detail</th>
											<th>Nominals</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalAddNote">
			<div class="modal-dialog" id="modal-default-size">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Add Note</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">
								<label>Account</label>
								<select class="form-control select2" id="inputNotePID" style="width: 100%;">
									<option>Select Account</option>
								</select>
							</div>
							<div class="form-group">
								<label>Date</label>
								<input type="text" class="form-control" id="inputNoteDate" required>
							</div>
							<div class="form-group">
								<label>Document (Optional)</label>
								<input type="text" class="form-control" id="inputNoteDocument" required>
							</div>
							<div class="form-group">
								<label>Issuer</label>
								<select class="form-control select2" id="inputNoteIssuer" style="width: 100%;">
									<option>Select Issuer</option>
								</select>
							</div>
							<div class="form-group">
								<label>Purpose</label>
								<input type="text" class="form-control" id="inputNotePurpose" required>
							</div>
							<div class="form-group">
								<label>Describe</label>
								<input type="text" class="form-control" id="inputNoteDetail" required>
							</div>
							<div class="form-group">
								<label>Nominal</label>
								<input type="text" class="form-control" id="inputNoteNominal" required>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-flat btn-default pull-left">Cancel</button>
						<button type="button" class="btn btn-flat btn-primary" onclick="submitNote()">Submit</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalUpdateNote">
			<div class="modal-dialog" id="modal-default-size">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="margin-left: 5px;">&times;</span>
						</button>
						<div class="modal-tools pull-right" style="text-align: right";>
							<div>
								<span class="label label-info" id="updateNoteStatus" style="font-size: 15px;"></span> 
							</div>
							<div style="margin-top: 5px;">
								<span id="updateNoteDate"></span>
							</div>
						</div>
						<h4 class="modal-title">Update Note - <b id="updateNoteIssuer"></b></h4> 
						<b>Account : </b><small id="updateNoteAccount"></small>
					</div>
					<div class="modal-body">
						<form role="form">
							<input type="hidden" id="updateNoteId">
							<!-- <div class="form-group">
								<label>Account</label>
								<input type="text" class="form-control" id="updateNoteAccount" readonly>
							</div> -->
							<!-- <div class="form-group">
								<label>Date</label>
								<input type="text" class="form-control" id="updateNoteDate" readonly>
							</div> -->
							<div class="form-group">
								<label>Document (Optional)</label>
								<input type="text" class="form-control" id="updateNoteDocument" readonly>
							</div>
							<!-- <div class="form-group">
								<label>Issuer</label>
								<input type="text" class="form-control" id="updateNoteIssuer" readonly>
							</div> -->
							<div class="form-group">
								<label>Purpose</label>
								<input type="text" class="form-control" id="updateNotePurpose" readonly>
							</div>
							<div class="form-group">
								<label>Describe</label>
								<input type="text" class="form-control" id="updateNoteDescribe" readonly>
							</div>
							<div class="form-group">
								<label>Nominal</label>
								<input type="text" class="form-control" id="updateNoteNominal" readonly>
							</div>
							<hr>
							<div class="form-group">
								<label>Activity</label>
								<ul id="updateNoteActivity">
								</ul>
							</div>
							<div class="form-group">
								<label>Update</label>
								<input type="text" class="form-control" id="updateNoteUpdate">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<!-- <button type="button" class="btn btn-flat btn-default pull-left">Cancel</button> -->
						<button type="button" class="btn btn-flat btn-default updateBtn pull-left edit-btn" onclick="editNote()">Edit</button>
						<button type="button" class="btn btn-flat btn-default updateBtn pull-left cancel-btn" onclick="cancelEditNote()" style="display: none;">Cancel</button>
						<button type="button" class="btn btn-flat btn-default updateBtn pull-left save-btn" onclick="saveEditNote()"  style="display: none;">Save</button>
						<button type="button" class="btn btn-flat btn-warning updateBtn" onclick="pendingNote()">Pending</button>
						<button type="button" class="btn btn-flat btn-success updateBtn" onclick="successNote()">Succes</button>
						<button type="button" class="btn btn-flat btn-primary updateBtn" onclick="updateNote()">Update</button>
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
<!-- <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/rowgroup/1.1.1/js/dataTables.rowGroup.min.js"></script>
<script src="{{ url('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script src="{{url('js/hue-to-rgb.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>



<!-- <script src="{{url('plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{url('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{url('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script> -->

<script defer src="https://www.gstatic.com/firebasejs/6.1.1/firebase-app.js"></script>
<script defer src="https://www.gstatic.com/firebasejs/6.1.1/firebase-database.js"></script>

<script>
	var swalWithCustomClass
	$(document).ready(function(){
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
		
		initBudgetTable();

		$('#tableBudgetNote tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = $("#tableBudgetNote").DataTable().row( tr );
			if ( row.child.isShown() ) {
				row.child.hide();
				tr.removeClass('shown');
				$(this).closest('tr > td').children().attr("class","fa fa-plus");
			}
			else {
				$.ajax({
					type:"GET",
					url:"{{url('budget/note/getIndividualNote')}}",
					data:{
						id:row.data().id
					},
					success:function(result){
						row.child( format(row.data(),result)).show();
						tr.addClass('shown');
						$(this).closest('tr > td').children().attr("class","fa fa-minus");
					}
				})
				
			}
		});

		$('#tableBudgetNote tbody').on('click', '.btnUpdate', function () {
			var tr = $(this).closest('tr').prev();
			var row = $("#tableBudgetNote").DataTable().row( tr );
			$.ajax({
				type:"GET",
				url:"{{url('budget/note/getIndividualNote')}}",
				data:{
					id:row.data().id
				},
				success:function(result){
					$("#updateNoteNominal").inputmask("decimal",{
						radixPoint:",", 
						groupSeparator: ".", 
						digits: 2,
						autoGroup: true,
						prefix: 'Rp '
					});
					
					$(".updateBtn").removeClass('disabled')
					$('.updateBtn').prop("disabled", false)
					// $(".updateBtn").attr('disabled','false')

					if(result.latest.activity == "Created"){
						var status = 'Created'
						$("#updateNoteStatus").attr('class','label label-danger');
					} else if (result.latest.activity == "On Progress") {
						var status = 'On Progress'
						$("#updateNoteStatus").attr('class','label label-primary');
					} else if (result.latest.activity == "Pending") {
						var status = 'Pending'
						$("#updateNoteStatus").attr('class','label label-warning');
					} else if (result.latest.activity == "Success"){
						$(".updateBtn").addClass('disabled')
						$('.updateBtn').prop("disabled", true)
						var status = 'Done'
						$("#updateNoteStatus").attr('class','label label-success');
					}

					$("#updateNoteActivity").text('')
					$.each(result.activity,function(key,value){
						$("#updateNoteActivity").append('<li>' + moment(value.date,'YYYY-MM-DD HH:mm:ss').format("DD MMMM - HH:mm") + ' [' + value.updater + '] - ' + value.note + '</li>');
					});
					$("#updateNoteId").val(result.note.id)
					$("#updateNoteStatus").text(status)
					$("#updateNoteAccount").text(result.account.PID)
					$("#updateNoteDate").text(moment(result.note.date,'YYYY-MM-DD').format('D MMMM YYYY'))
					$("#updateNoteDocument").val(result.note.document)
					$("#updateNoteIssuer").text(result.note.issuer)
					$("#updateNotePurpose").val(result.note.purpose)
					$("#updateNoteDescribe").val(result.note.detail)
					$("#updateNoteNominal").val(result.note.nominal)
					$("#modalUpdateNote").modal('toggle')
				}
			})
			
			// console.log('click')
			// console.log(row.data().id)
			// console.log(tr)
		});

	    swalWithCustomClass = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-flat btn-primary swal2-margin',
				cancelButton: 'btn btn-flat btn-danger swal2-margin',
				popup: 'border-radius-0',
			},
			buttonsStyling: false,
		})

		$('#searchBarNote').keyup(function(){
			$("#tableBudgetNote").DataTable().search($(this).val()).draw();
		})
	})

	function updateNote(){
		$.ajax({
			type:"POST",
			url:"{{url('budget/note/updateNote')}}",
			data:{
				_token:'{{csrf_token()}}',
				note:$("#updateNoteUpdate").val(),
				id_note:$("#updateNoteId").val(),
				activity:'On Progress'
			},
			success:function(result){
				$("#modalUpdateNote").modal("toggle")
				$("#tableBudgetNote").DataTable().ajax.url("{{url('budget/note/getDataNote')}}").load()
			}
		})
	}

	function pendingNote(){
		$.ajax({
			type:"POST",
			url:"{{url('budget/note/updateNote')}}",
			data:{
				_token:'{{csrf_token()}}',
				note:'Pending : ' + $("#updateNoteUpdate").val(),
				id_note:$("#updateNoteId").val(),
				activity:'Pending'
			},
			success:function(result){
				$("#modalUpdateNote").modal("toggle")
				$("#tableBudgetNote").DataTable().ajax.url("{{url('budget/note/getDataNote')}}").load()
			}
		})
	}

	function successNote(){
		$.ajax({
			type:"POST",
			url:"{{url('budget/note/updateNote')}}",
			data:{
				_token:'{{csrf_token()}}',
				note:'Done : ' + $("#updateNoteUpdate").val(),
				id_note:$("#updateNoteId").val(),
				activity:'Success'
			},
			success:function(result){
				$("#modalUpdateNote").modal("toggle")
				$("#tableBudgetNote").DataTable().ajax.url("{{url('budget/note/getDataNote')}}").load()
			}
		})
	}

	function prepareAddNote(){
		
		$.ajax({
			type:"GET",
			url:"{{url('budget/note/getDataParameterNote')}}",
			beforeSend: function(){
				$("#inputNotePID").val("")
				$("#inputNoteDate").val("")
				$("#inputNoteDocument").val("")
				$("#inputNoteIssuer").val("")
				$("#inputNotePurpose").val("")
				$("#inputNoteDetail").val("")
				$("#inputNoteNominal").val("")

				$("#inputNoteDate").inputmask("date");
				$("#inputNoteNominal").inputmask("decimal",{
					radixPoint:",", 
					groupSeparator: ".", 
					digits: 2,
					autoGroup: true,
					prefix: 'Rp '
				});
			},
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
			}
		})
	}

	function editNote(){

		$("#updateNoteDocument").prop('readonly',false)
		$("#updateNotePurpose").prop('readonly',false)
		$("#updateNoteDescribe").prop('readonly',false)
		$("#updateNoteNominal").prop('readonly',false)
		$(".edit-btn").hide()
		$(".save-btn").show()
		$(".cancel-btn").show()
	}

	function cancelEditNote(){

		$("#updateNoteDocument").prop('readonly',true)
		$("#updateNotePurpose").prop('readonly',true)
		$("#updateNoteDescribe").prop('readonly',true)
		$("#updateNoteNominal").prop('readonly',true)
		$(".edit-btn").show()
		$(".save-btn").hide()
		$(".cancel-btn").hide()
	}

	function saveEditNote(){

		$("#updateNoteDocument").prop('readonly',true)
		$("#updateNotePurpose").prop('readonly',true)
		$("#updateNoteDescribe").prop('readonly',true)
		$("#updateNoteNominal").prop('readonly',true)
		$(".edit-btn").show()
		$(".save-btn").hide()
		$(".cancel-btn").hide()
		$("#updateNoteNominal").inputmask('remove');
		$.ajax({
			type:"POST",
			url:"{{url('budget/note/editNote')}}",
			data:{
				_token:'{{csrf_token()}}',
				id_note:$("#updateNoteId").val(),
				document:$("#updateNoteDocument").val(),
				purpose:$("#updateNotePurpose").val(),
				detail:$("#updateNoteDescribe").val(),
				nominal:$("#updateNoteNominal").val(),
			},
			success:function(result){
				$("#modalUpdateNote").modal("toggle")
				$("#tableBudgetNote").DataTable().ajax.url("{{url('budget/note/getDataNote')}}").load()
			}
		})
	}

	function initBudgetTable(){

		$("#tableBudgetNote").DataTable({
			"ajax":{
				"type":"GET",
				"url":"{{url('budget/note/getDataNote')}}",
				"dataSrc": function (json){
					

					// switch between locales
					numeral.locale('id');

					json.data.forEach(function(data,index){
						data.month = moment(data.date,'YYYY-MM-DD').format('MMMM YYYY');
						data.timestamp = moment(data.date,'YYYY-MM-DD').format('X');
						data.date = moment(data.date,'YYYY-MM-DD').format('D MMMM YYYY');
						data.nominal_formated = numeral(data.nominal).format('$0,0.00');
						data.details_controls = "<i class='fa fa-plus'></i>";
						data.PID = data.customer + " - " + data.PID;
						// data.status = "Active"
					});
					return json.data;
				}
			},
			// "rowGroup": {
	  //           "dataSrc": "PID"
	  //       },
			"columns": [
				{
					"className": 'details-control',
					"orderable": false,
					"data": "details_controls",
					"defaultContent": ''
				},
				{ 
					"data": "date",
					"className": "text-right",
					"orderData" : [ 8 ],
					"targets" : [ 1 ],
				},
				{ "data": "document" },
				{ "data": "issuer" },
				{ "data": "purpose" },
				{ "data": "detail" },
				{ 
					"data": "nominal_formated",
					"className": "text-right",
					"orderData" : [ 7 ],
					"targets" : [ 1 ],
				},
				{ 
					"data": "nominal",
					"targets": [ 7 ] ,
					"visible": false ,
					"searchable": true
				},
				{ 
					"data": "timestamp", 
					"targets": [ 8 ] ,
					"visible": false ,
					"searchable": true
				},
				{ 
					"data": "PID",
					"visible": false ,
					"searchable": true
				},
				{ 
					"data": "customer",
					"visible": false ,
					"searchable": true
				},
				{ 
					"data": "month",
					"visible": false ,
					"searchable": true
				},
			],
			"searching": true,
			"lengthChange": false,
			// "paging": false,
			"info":false,
			"scrollX": false,
		})

	}

	function changeNumberEntries(number){
		$("#btnShowEntryNote").html('Show ' + number + ' entries <span class="fa fa-caret-down"></span>')
		$("#tableBudgetNote").DataTable().page.len( number ).draw();
	}

	function changeGroupingTable(groupBy,groupBy_name,orderBy){
		$("#btnShowGrouping").html('Group By : ' + groupBy_name + ' <span class="fa fa-caret-down"></span>')
		$("#tableBudgetNote").DataTable().rowGroup().dataSrc( groupBy ).order([orderBy,'asc']).draw();
	}

	function format ( d,ajaxData ) {
		// `d` is the original data object for the row
		// console.log(d.id)
		// console.log(ajaxData)
		if(ajaxData.latest.activity == "Created"){
			var status = '<b>Status :</b> <small class="label bg-red">Created</small>'
		} else if (ajaxData.latest.activity == "On Progress") {
			var status = '<b>Status :</b> <small class="label bg-primary">On Progress</small>'
		} else if (ajaxData.latest.activity == "Pending") {
			var status = '<b>Status :</b> <small class="label bg-yellow">Pending</small>'
		} else {
			var status = '<b>Status :</b> <small class="label bg-green">Done</small>'
		}
		var result = '<div class="row">' + 
					'<div class="col-md-1 text-center">' + 
						'<button class="btn btn-flat btn-primary btn-xs btnUpdate">Update</button>'+
					'</div>' + 
					'<div class="col-md-2">' + 
						'<b>Proceed by : </b>' + ajaxData.procced +
					'</div>' + 
					'<div class="col-md-2">' + 
						'<b>Updated at : </b>' + moment(ajaxData.latest.date,"YYYY-MM-DD HH:mm:ss").format('D MMMM YYYY') +
					'</div>' + 
					'<div class="col-md-5">' + 
						'<b>Update : </b>' + ajaxData.latest.note + 
					'</div>' + 
					'<div class="col-md-2 pull-right text-right">' + 
						status + 
					'</div>' + 
				'</div>';
		return result
	}

	function submitNote(){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "Make sure there is nothing wrong to submit this note!",
			type: 'warning',
			showCancelButton: true,
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			}).then((result) => {
				if (result.value){
					Swal.fire({
						title: 'Please Wait..!',
						text: "It's submiting..",
						allowOutsideClick: false,
						allowEscapeKey: false,
						allowEnterKey: false,
						customClass: {
							popup: 'border-radius-0',
						},
						onOpen: () => {
							Swal.showLoading()
						}
					})
					$("#inputNoteNominal").inputmask('remove');
					$.ajax({
						type:"POST",
						url:"{{url('budget/note/setNote')}}",
						
						data:{
							_token: "{{ csrf_token() }}",
							PID: $("#inputNotePID").val(),
							date: moment($("#inputNoteDate").val(),'DD/MM/YYYY').format('YYYY-MM-DD'),
							issuer: $("#inputNoteIssuer").val(),
							document: $("#inputNoteDocument").val(),
							purpose: $("#inputNotePurpose").val(),
							detail: $("#inputNoteDetail").val(),
							nominal: $("#inputNoteNominal").val(),
						},
						success: function(){
							Swal.hideLoading()
							swalWithCustomClass.fire({
								title: 'Success!',
								text: "Note submited",
								type: 'success',
								confirmButtonText: 'Reload',
							}).then((result) => {
								$("#tableBudgetNote").DataTable().ajax.url("{{url('budget/note/getDataNote')}}").load()
								$("#modalAddNote").modal('toggle')
							})
						}
					})
				}
			}
		);
		
	}
</script>
@endsection