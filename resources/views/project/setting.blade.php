<<<<<<< HEAD
@extends('layouts.admin.layoutLight2')
@section('head')
<link rel="stylesheet" href="{{url('plugins/datatables/dataTables.bootstrap.css')}}">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<style>
	.dataTables_filter {display: none;}
</style>
@endsection
=======
@extends('layouts.admin.layoutLight')
>>>>>>> 3d4ab6fcbea0d9dc6d8140c9dd680333a4f5d45c
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Overview
			<small>All of project overview</small>
		</h1>
<<<<<<< HEAD
=======
		<!-- <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i></a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Blank page</li>
		</ol> -->
>>>>>>> 3d4ab6fcbea0d9dc6d8140c9dd680333a4f5d45c
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">This Month [July]</span>
						<span class="info-box-number">90<small>%</small></span>
					</div>
<<<<<<< HEAD
				</div>
			</div>
=======
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
>>>>>>> 3d4ab6fcbea0d9dc6d8140c9dd680333a4f5d45c
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Need Renewal</span>
						<span class="info-box-number"></span>
					</div>
<<<<<<< HEAD
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Title</h3>
						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" id="searchBar" class="form-control pull-right" placeholder="Search">

								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body table-responsive no-padding">
						<table id="tableProjectSetting" class="table table-hover">
							<thead>
								<tr>
									<!-- <th></th> -->
									<th>Customer</th>
									<th>Name Project</th>
									<th>Time to Due Date</th>
									<th>Time to Due Date</th>
									<th>Coordinator</th>
									<th></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="modalSettingProject">
			<div class="modal-dialog" id="modal-default-size">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modalSettingProjectTitle"></h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Customer</label>
										<input class="form-control" type="text" id="settingProjectCustomer" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Project ID</label>
										<input class="form-control" type="text" id="settingProjectPID" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Name Project</label>
										<input class="form-control" type="text" id="settingProjectName" readonly>
									</div>
								</div>
							</div>
							<hr style="margin-top: 0px;">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Project Start</label>
										<input class="form-control" type="text" id="settingProjectName" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Number of Period</label>
										<input class="form-control" type="text" id="settingProjectName" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Duration Period</label>
										<input class="form-control" type="text" id="settingProjectName" readonly>
									</div>
								</div>
							</div>
							<hr style="margin-top: 0px;">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Coordinator</label>
										<input class="form-control" type="text" id="settingProjectName" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Leader</label>
										<input class="form-control" type="text" id="settingProjectName" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Team Member</label>
										<input class="form-control" type="text" id="settingProjectName" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Get Reminder</label>
										<input class="form-control" type="checkbox" checked data-toggle="toggle">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Remaind All</label>
										<input class="form-control" type="checkbox" checked data-toggle="toggle">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Remaind All</label>
										<input class="form-control" type="checkbox" checked data-toggle="toggle">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>
	</section>
=======
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
		</div>
	<!-- Default box -->
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Title</h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
					<i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
					<i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body" style="">
			Start creating your amazing application!
		</div>
		<!-- /.box-body -->
		<div class="box-footer" style="">
			Footer
		</div>
		<!-- /.box-footer-->
	</div>
	<!-- /.box -->

</section>
>>>>>>> 3d4ab6fcbea0d9dc6d8140c9dd680333a4f5d45c
</div>
@endsection 

@section('script')
<<<<<<< HEAD
<!-- moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<!-- HumanizeDuration.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/humanize-duration/3.20.1/humanize-duration.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap Toggle -->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
Custom Color Converter
<script src="{{url('js/hue-to-rgb.js')}}"></script>
<script>
	$(document).ready(function(){
		getAllProjectList();
	});

	function getAllProjectList(){
		$("#tableProjectSetting").DataTable({
			"ajax":{
				"type":"GET",
				"url":"{{url('project/manage/getAllProjectList')}}",
				"dataSrc": function (json){
					var i = 120 / (json.data.length - 1);
					var x = 0;
					var v = 95;
					var s = 90;
					json.data.forEach(function(data,index){
						var color = hsvToRgb(i * x,s,v)[0] + "," + hsvToRgb(i * x,s,v)[1] + "," + hsvToRgb(i * x,s,v)[2];
						fontColor = "#333;";
						if(data.project_start < 0){
							data.project_start = "<span class='label' style='background-color:rgb(" + color + ");color:" + fontColor + "'> " + humanizeDuration(moment.duration(data.project_start,'days').asMilliseconds(),{ units: ['y','mo','d'], round: true, }) + " ago </span>";
						} else {
							data.project_start = "<span class='label' style='background-color:rgb(" + color + ");color:" + fontColor + "'> in " + humanizeDuration(moment.duration(data.project_start,'days').asMilliseconds(),{ units: ['y','mo','d'], round: true, }) + "</span>";
						}
						x++;
					});
					return json.data;
				}
			},
			"columns": [
				{ "data" : "project_customer" },
				{ "data" : "project_name" },
				{ "data" : "project_start" , "orderData":[ 4 ] , "targets": [ 1 ]},
				{ "data" : "project_start2" , "targets": [ 4 ] , "visible": false , "searchable": false},
				{ "data" : "project_coordinator" },
				{ 
					"data": null,
					"defaultContent" : "<button class='btn btn-primary btn-xs'>Edit</button>",
					"orderable" : false,
					"className" : "edit-td",
					// "targets" : -1
				},
			],
			"order": [[ 4, "asc" ]],
			searching: true,
			paging: false,
			info:false,
			scrollX: false,
			order: [[1, 'asc']]
		})
	};

	$('#searchBar').keyup(function(){
		$("#tableProjectSetting").DataTable().search($(this).val()).draw();
		console.log($(this).val());
	});

	$('#tableProjectSetting').on('click','td.edit-td', function () {
		var tr = $(this).closest('tr');
		var row = $("#tableProjectSetting").DataTable().row( tr );
		// console.log(row.data().id);
		editProject(row.data().id);
	});

	function editProject(id){
		$.ajax({
			type:"GET",
			url:"{{url('project/setting/getSettingProject')}}",
			data:{
				id:id
			},
			success:function(result){
				// console.log(id);
				$("#modalSettingProjectTitle").text('Setting for Project');
				$("#modalSettingProject").modal('show');
			}
		});
	};
=======
<script>
	$(document).ready(function(){
	}
>>>>>>> 3d4ab6fcbea0d9dc6d8140c9dd680333a4f5d45c
</script>
@endsection