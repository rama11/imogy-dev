@extends('layouts.admin.layoutLight')
@section('head')
<link rel="stylesheet" href="{{url('plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->

<style type="text/css">
	select[readonly].select2-hidden-accessible + .select2-container {
		pointer-events: none;
		touch-action: none;
	}

	select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
		background: #eee;
		box-shadow: none;
	}

	select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow,
	select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
		display: none;
	}
	td.details-control {
		background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
		cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
	}
</style>
@endsection
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Manage
			<small>add, remove and edit project</small>
		</h1>
		<ol class="breadcrumb">
			<button type="button" class="btn btn-flat btn-success btn-xs" data-toggle="modal" data-target="#modalInputProject"
				onclick='
					document.getElementById("inputProjectForm1").style.display = "inline";
					document.getElementById("inputProjectForm2").style.display = "none";
					document.getElementById("inputProjectForm3").style.display = "none";
					document.getElementById("inputProjectForm4").style.display = "none";
					clearInputProject();
				'>Add Project</button>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">All Project</h3>

						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<table id="tableProjectManage" class="table table-hover">
							<thead>
								<tr>
									<th></th>
									<th>Customer</th>
									<th>Name Project</th>
									<th>Start</th>
									<th>Coordinator</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalInputProject">
			<div class="modal-dialog" id="modal-default-size">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Add Project</h4>
					</div>
					<div id="inputProjectForm1">
						<div class="modal-body">
							<p>Please input detail customer</p>
							<form role="form">
								<!-- <input type="hidden" class="form-control"> -->
								<div class="form-group">
									<label>Customer</label>
									<select class="form-control select2" id="inputProjectCustomer" style="width: 100%" required></select>
								</div>
								<div class="form-group">
									<label>Project Name</label>
									<input type="text" class="form-control" id="inputProjectName" required>
								</div>
								<div class="form-group">
									<label>Project ID (PID)</label>
									<input type="text" class="form-control" id="inputProjectPID" required>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="next" onclick='
								document.getElementById("inputProjectForm2").style.display = "inline";
								document.getElementById("inputProjectForm1").style.display = "none";'>Next</button>
						</div>
					</div>

					<div id="inputProjectForm2" style="display: none">
						<div class="modal-body">
							<p>Please input periode project.</p>
							<form role="form">
								<!-- <input type="hidden" class="form-control"> -->
								<div class="form-group">
									<!-- <label>Start Date</label> -->
									<!-- <input type="text" class="form-control" id="inputProjectStart" required=""> -->
									<label>Start Date</label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" class="form-control pull-right" id="inputProjectStart" required>
									</div>
									<p style="font-size: x-small;">Start date depends on contract/spk or base on BAST date.</p>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>How many Periode</label>
											<input type="number" class="form-control" id="inputProjectPeriod" required></input>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Duration Per Periode</label>
											<select class="form-control" id="inputProjectDuration" required>
												<option value="1">1 Month</option>
												<option value="2">2 Month</option>
												<option value="3">3 Month</option>
												<option value="4">4 Month</option>
												<option value="6">6 Month</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12" id="inputProjectPeriodResult">
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="back" onclick='document.getElementById("inputProjectForm1").style.display = "inline";document.getElementById("inputProjectForm2").style.display = "none";'>Back</button>
							<button type="button" class="btn btn-primary" id="next" onclick='document.getElementById("inputProjectForm3").style.display = "inline";document.getElementById("inputProjectForm2").style.display = "none";'>Next</button>
						</div>
					</div>

					<div id="inputProjectForm3" style="display: none">
						<div class="modal-body">
							<p>Please fill in the team concerned</p>
							<form role="form">
								<!-- <input type="hidden" class="form-control"> -->
								<div class="form-group">
									<label>Project Coordinator</label>
									<select class="form-control select2" id="inputProjectCoordinator" style="width: 100%" required></select>
									<!-- <input type="text" class="form-control" id="inputProjectCoordinator" required=""> -->
								</div>
								<div class="form-group">
									<label>Team Lead</label>
									<select class="form-control select2" id="inputProjectLead" style="width: 100%" required></select>
								</div>
								<div class="form-group">
									<label>Team Member</label>
									<select class="form-control select2" id="inputProjectMember" style="width: 100%" multiple="multiple" required></select>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="back" onclick='
								document.getElementById("inputProjectForm2").style.display = "inline";
								document.getElementById("inputProjectForm3").style.display = "none";'>Back</button>
							<button type="button" class="btn btn-primary" id="next" onclick='
								document.getElementById("inputProjectForm4").style.display = "inline";
								document.getElementById("inputProjectForm3").style.display = "none";
								document.getElementById("modal-default-size").classList.add("modal-lg");
								correctionInputProject();'>Next</button>
						</div>
					</div>

					<div id="inputProjectForm4" style="display: none">
						<div class="modal-body">
							<p>Please check whether it matches the data you input.</p>
							<form role="form">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Customer</label>
											<input type="text" class="form-control" id="inputProjectCustomerCorrection" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>PID</label>
											<input type="text" class="form-control" id="inputProjectPIDCorrection" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Project Name</label>
											<input type="text" class="form-control" id="inputProjectNameCorrection" readonly>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Start of Periods</label>
													<input type="text" class="form-control" id="inputProjectStartCorrection" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Duration of Periods</label>
													<input type="text" class="form-control" id="inputProjectDurationCorrection" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Number of Periods</label>
													<input type="text" class="form-control" id="inputProjectPeriodCorrection" readonly>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6" id="inputProjectPeriodResult2">
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Project Coordinator</label>
											<input type="text" class="form-control select2" id="inputProjectCoordinatorCorrention" readonly></select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Team Leader</label>
											<input type="text" class="form-control" id="inputProjectLeadCorrention" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Team Member</label>
											<select class="form-control select2" id="inputProjectMemberCorrention" style="width: 100%" multiple="multiple" readonly></select>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="back" onclick='
								document.getElementById("inputProjectForm3").style.display = "inline";
								document.getElementById("inputProjectForm4").style.display = "none";
								document.getElementById("modal-default-size").classList.remove("modal-lg");'>Back</button>
							<button type="button" class="btn btn-success" id="next" onclick='
								sendInputProject();
								document.getElementById("modal-default-size").classList.remove("modal-lg")'>Finish</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="successAddProject" class="alert alert-success alert-dismissible" style="margin-top: 150px;margin-right: 10px; position:fixed; top:0; right:0; width:300px;display: none;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4>
				<i class="icon fa fa-check"></i> Success!
			</h4>
			Change time for {{session('status')}} success.
		</div>

	</section>
</div>

@endsection 

@section('script')
<!-- moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<!-- bootstrap datepicker -->
<script src="{{url('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
	var append = "";
	var member = [];
	var memberNickname = [];

	$(document).ready(function(){

		$("#inputProjectStart").val("");
		$("#inputProjectPeriod").val("");
		$("#inputProjectDuration").val("");

		getAllProjectList();

		initFormInputProject();

		// Add new customer for Input Project
		$("#inputProjectCustomer").on('select2:close',function(){
			if($("#inputProjectCustomer").select2('data')[0].text == "Add New Customer"){
				var newCustomer = prompt("Enter new customer :");
				if(newCustomer !== null){
					var newOption = new Option(newCustomer, 0, false, false);
					$('#inputProjectCustomer').append(newOption).trigger('change');
				}
			}
		});

		//Date picker for Input Project
		$('#inputProjectStart').datepicker({
			autoclose: true
		});

		// Listener at project timeline for Input Project
		$("#inputProjectStart, #inputProjectPeriod, #inputProjectDuration").bind("change",function(){
			if($("#inputProjectStart").val() != "" && $("#inputProjectPeriod").val() != "" && $("#inputProjectDuration").val() != null){
				var start = $("#inputProjectStart").val();
				var periode = $("#inputProjectPeriod").val();
				var duration = $("#inputProjectDuration").val();
				append = "";
				append = append + "<table class='table'>";
				append = append + "<tr>";
				append = append + "<th>Periode</th>";
				append = append + "<th>Start</th>";
				append = append + "<th>End</th>";
				append = append + "</tr>";
				for (var i = 0; i < periode; i++) {
					append = append + "<tr>";
					append = append + "<th>Periode " + (i+1) + "</th>";
					append = append + "<td>" + moment(start,"MM/DD/YYYY").add(duration * (i+1),'month').subtract(3,'month').format('D MMMM YYYY') + "</td>";
					append = append + "<td>" + moment(start,"MM/DD/YYYY").add(duration * (i+1),'month').subtract(1,'days').format('D MMMM YYYY') + "</td>";
					append = append + "</tr>";
				}
				append = append + "</table>";

				$("#inputProjectPeriodResult").html("");
				$("#inputProjectPeriodResult").append(append);
			}
		});
	});

	function initFormInputProject(){
		// Get Customer for Input Project
		$.ajax({
			type:"GET",
			url:'{{url("project/manage/getCustomer")}}',
			success: function(result){
				var listCustomer = result;
				listCustomer.unshift({id:0,text:"Add New Customer"});

				$("#inputProjectCustomer").select2({
					placeholder: "Select a customer",
					data: result
				});
			}
		});

		// Get Member for Input Project
		$.ajax({
			type:"GET",
			url:'{{url("project/manage/getMember")}}',
			success: function(result){
				$("#inputProjectCoordinator").select2();
				$("#inputProjectLead, #inputProjectMember, #inputProjectMemberCorrention").select2();
				var listMember = result;
				listMember.forEach(function(member){
					newOption = new Option(member.text, member.id, false, false);
					if(member.position == "Coordinator"){
						$('#inputProjectCoordinator').append(newOption).trigger('change');
					} else if (member.position == "Member"){
						$("#inputProjectLead, #inputProjectMember, #inputProjectMemberCorrention").append(newOption).trigger('change');
					}
				});
			}
		});
	}

	function correctionInputProject(){
		
		// Correction Customer
		$("#inputProjectCustomerCorrection").val($("#inputProjectCustomer").select2('data')[0].text);
		$("#inputProjectPIDCorrection").val($("#inputProjectPID").val());
		$("#inputProjectNameCorrection").val($("#inputProjectName").val());

		// Correction Periode Input
		$("#inputProjectStartCorrection").val(moment($("#inputProjectStart").val(),"MM/DD/YYYY").format('DD MMMM YYYY'));
		$("#inputProjectDurationCorrection").val($("#inputProjectPeriod").val() + " Month");
		$("#inputProjectPeriodCorrection").val($("#inputProjectDuration").val() + " Periode");

		// Correction Periode View
		$("#inputProjectPeriodResult2").html("");
		$("#inputProjectPeriodResult2").append(append);

		// Correction Project Member
		var coordinator = $("#inputProjectCoordinator").select2('data');
		var leader = $("#inputProjectLead").select2('data');
		var members = $("#inputProjectMember").select2('data');
		
		

		$("#inputProjectCoordinatorCorrention").val(coordinator[0].text);
		$("#inputProjectLeadCorrention").val(leader[0].text);

		members.forEach(function(eachMember){
			member.push(eachMember.id);
			memberNickname.push(eachMember.text);
		});
		$("#inputProjectMemberCorrention").select2().val(member).trigger("change");
	};

	function sendInputProject(){
		$.ajax({
			type:"POST",
			url:"{{url('project/manage/setProjectList')}}",
			data:{
				"_token": "{{ csrf_token() }}",
				"Customer":$("#inputProjectCustomer").select2('data')[0].id,
				"CustomerName":$("#inputProjectCustomer").select2('data')[0].text,
				"PID":$("#inputProjectPIDCorrection").val(),
				"Name":$("#inputProjectNameCorrection").val(),
				"Duration":$("#inputProjectDuration").val(),
				"Period":$("#inputProjectPeriod").val(),
				"StartPeriod":moment($("#inputProjectStartCorrection").val(),"DD MMMM YYYY").format("YYYY-MM-DD"),
				"Coordinator":$("#inputProjectCoordinator").select2('data')[0].id,
				"Lead":$("#inputProjectLead").select2('data')[0].id,
				"Member":memberNickname
			},
			success : function(result){
				clearInputProject();
				// initFormInputProject();
				$("#modalInputProject").modal('hide');
				getAllProjectList()
				$("#successAddProject").show().delay(2000).fadeOut();
			},
		});
	}

	function clearInputProject(){
		$("#inputProjectCustomer").select2().val(null).trigger('change');
		$("#inputProjectCustomerCorrection").val("");
		$("#inputProjectPID").val("");
		$("#inputProjectPIDCorrection").val("");
		$("#inputProjectName").val("")
		$("#inputProjectNameCorrection").val("");

		$("#inputProjectStart").val("");
		$("#inputProjectStartCorrection").val("");
		$("#inputProjectDuration").val("");
		$("#inputProjectDurationCorrection").val("");
		$("#inputProjectPeriod").val("");
		$("#inputProjectPeriodCorrection").val("");

		$("#inputProjectCoordinator").select2().val(null).trigger('change');
		$("#inputProjectCoordinatorCorrention").val("");
		$("#inputProjectLead").select2().val(null).trigger('change');
		$("#inputProjectLeadCorrention").val("");
		$("#inputProjectMember").select2().val(null).trigger('change');
		$("#inputProjectMemberCorrention").select2().val(null).trigger('change');

		$("#inputProjectPeriodResult").html("");
		$("#inputProjectPeriodResult2").html("");
	}

	function getAllProjectList(){
		$("#tableProjectManage").DataTable({
			"ajax":"{{url('project/manage/getAllProjectList')}}",
			"columns": [
				 {
					"className": 'details-control',
					"orderable": false,
					"data": null,
					"defaultContent": ''
				},
				{ "data": "project_customer" },
				{ "data": "project_name" },
				{ "data": "project_start" },
				{ "data": "project_coordinator" },
				// { "data": "start_date" },
				// { "data": "salary" }
			],
			searching: false,
			paging: false,
			info:false,
			scrollX: false,
			order: [[1, 'asc']]
		})
	}


	function showProjectDetail( id ){
		console.log(id);
	}
	// DataTables child controll
	function format( data ) {
		return '<div class="row">' +
			'<div class="col-md-1">' +
				'<button class="btn btn-primary" onclick="showProjectDetail(' + data.id + ')">Detail</button>' +
			'</div>' +
			'<div class="col-md-3">' +
				'<label>Time to Due Date</label>' +
				'<p>20 day left</p>' +
			'</div>' +
			'<div class="col-md-6">' +
				'<label>Lastest Update</label>' +
				'<p>[22 Juli 2019] Rama : report sudah di submit, tinggal menunggu ttd</p>' +
			'</div>' +
			'<div class="col-md-2">' +
				'<label>Next Event</label>' +
				'<p> PM ' + data.project_periode_duration + 'th period</p>' +
			'</div>' +
		'</div>';
	}

	$('#tableProjectManage').on('click','td.details-control', function () {
		// console.log(tr);
		var tr = $(this).closest('tr');
		var row = $("#tableProjectManage").DataTable().row( tr );

		if ( row.child.isShown() ) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}
		else {
			// Open this row
			row.child( format(row.data()) ).show();
			tr.addClass('shown');
		}
	});

	
</script>
@endsection