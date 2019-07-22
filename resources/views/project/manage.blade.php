@extends('layouts.admin.layoutLight')
@section('head')
<link rel="stylesheet" href="{{url('plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
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
			<button type="button" class="btn btn-flat btn-success btn-xs" data-toggle="modal" data-target="#modal-default">Add Project</button>
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
						<table class="table table-hover">
							<tbody><tr>
								<th>Customer</th>
								<th>Name</th>
								<!-- <th>PID</th> -->
								<th>Start</th>
								<th>End</th>
								<th>Team Member</th>
								<th>Periode</th>
							</tr>
							<tr>
								<td>Bank DKI</td>
								<td>Pengadaan Firewall Pada Layer Internet PT. Bank DKI</td>
								<!-- <td>005/BANK DKI/650/SIP/I/2018</td> -->
								<td>7-Jun-18</td>
								<td>6-Jun-19</td>
								<td>Johan</td>
								<td>1</td>
							</tr>
							<tr>
								<td>BNI</td>
								<td>Security WEB, WAF, DBF, Bandwith Management utk Internet dan Extranet DC Slipi</td>
								<!-- <td>482/BNI/PO 444/SIP/XI/2017</td> -->
								<td>17-Jul-18</td>
								<td>16-Jul-21</td>
								<td>Siwi</td>
								<td>1</td>
							</tr>
							<tr>
								<td>BJB</td>
								<td>Pengadaan Appliance Web Application Firewall Imperva</td>
								<!-- <td>404/BANK JABAR/14/SIP/IX/2017</td> -->
								<td>22-Mar-18</td>
								<td>21-Mar-19</td>
								<td>Rangga</td>
								<td>4</td>
							</tr>
							<tr>
								<td>BJB</td>
								<td>Pekerjaan Pengadaan Next Generation Firewall Palo Alto Segmentasi E-Channel</td>
								<!-- <td>486/BANK JABAR/15/SIP/XII/2017</td> -->
								<td>27-Sep-18</td>
								<td>26-Sep-19</td>
								<td>Samsu</td>
								<td>4</td>
							</tr>
						</tbody></table>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-default">
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
									<input type="text" class="form-control" id="inputProjectName" required="">
								</div>
								<div class="form-group">
									<label>Project ID (PID)</label>
									<input type="text" class="form-control" id="inputProjectName" required="">
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
										<input type="text" class="form-control pull-right" id="inputProjectStart">
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
											<select class="form-control" id="inputProjectDuration">
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
									<select class="form-control select2" id="inputProjectCoordinator" style="width: 100%" multiple="multiple" required></select>
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
								correctionAddProject();'>Next</button>
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
											<input type="text" class="form-control" value="BNI" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>PID</label>
											<input type="text" class="form-control" value="482/BNI/PO 444/SIP/XI/2017" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Project Name</label>
											<input type="text" class="form-control" value="Security WEB, WAF, DBF, Bandwith Management utk Internet dan Extranet DC Slipi" readonly>
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
													<input type="text" class="form-control" value="1 July 2019" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Duration of Periods</label>
													<input type="text" class="form-control" value="3 Months" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Number of Periods</label>
													<input type="text" class="form-control" value="4 Periods" readonly>
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
											<input type="text" class="form-control select2" id="inputProjectCoordinatorCorrention" readonly>
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
								sendInputProject();'>Finish</button>
						</div>
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
<!-- bootstrap datepicker -->
<script src="{{url('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script>
	var append = "";

	$(document).ready(function(){

		$("#inputProjectStart").val("");
		$("#inputProjectPeriod").val("");
		$("#inputProjectDuration").val("");

		$("#inputProjectCustomer").select2({
			placeholder: "Select a customer",
			data:[
				{id:1,text:"BNI"},
				{id:2,text:"Bank DKI"},
				{id:3,text:"BPJS"},
				{id:4,text:"SOMPO"},
				{id:5,text:"OCBC Sekuritas"},
				{id:6,text:"BCA Sekuritas"},
			]
		});

		var projectCoordinator = [
			{id:1,text:"Wisnu"},
			{id:2,text:"Anggel"},
			{id:3,text:"Atha"},
			{id:4,text:"Denny"},
		];

		var teamMember = [
			{id:1,text:"Johan"},
			{id:2,text:"Dicky"},
			{id:3,text:"Zubed"},
			{id:4,text:"Yohanis"},
			{id:5,text:"Rangga"},
			{id:6,text:"Bayu"},
			{id:7,text:"Brian"},
			{id:8,text:"Ojan"},
			{id:9,text:"Vian"},
			{id:10,text:"Samsu"},
		];

		$("#inputProjectCoordinator").select2({
			data:projectCoordinator,
		});

		$("#inputProjectCoordinatorCorrention").select2({
			data:teamMember,
		});

		$("#inputProjectLead").select2({
			data:teamMember,
		});

		$("#inputProjectMember").select2({
			data:teamMember,
		});

		$("#inputProjectMemberCorrention").select2({
			data:teamMember,
		});

		//Date picker
		$('#inputProjectStart').datepicker({
			autoclose: true
		});

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

	function correctionAddProject(){
		// Correction Periode
		$("#inputProjectPeriodResult2").html("");
		$("#inputProjectPeriodResult2").append(append);

		// Correction Project Member
		var coordinators = $("#inputProjectCoordinator").select2('data');
		var leader = $("#inputProjectLead").select2('data');
		var members = $("#inputProjectMember").select2('data');
		
		var member = [];
		var coordinator = [];
		
		coordinators.forEach(function(eachCoordinator){
			coordinator.push(eachCoordinator.id);
		});
		$("#inputProjectCoordinatorCorrention").select2().val(coordinator).trigger("change");

		$("#inputProjectLeadCorrention").val(leader[0].text);

		members.forEach(function(eachMember){
			member.push(eachMember.id);
		});
		$("#inputProjectMemberCorrention").select2().val(member).trigger("change");
	};
</script>
@endsection