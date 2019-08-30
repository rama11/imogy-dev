@extends('layouts.admin.layoutLight2')
@section('head')
<link rel="stylesheet" href="{{url('plugins/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}">
<link rel="stylesheet" href="{{url('plugins/datatables/dataTables.bootstrap.css')}}">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker.css')}}" />

<style>
	.dataTables_filter {display: none;}
</style>
@endsection
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Overview
			<small>All of project overview</small>
		</h1>

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
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Need Renewal</span>
						<span class="info-box-number"></span>
					</div>
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
									<th style="width: 75px;"></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="modalSettingProject">
			<div class="modal-dialog" id="modalSettingProject-default-size">
				<input type="hidden" id="SettingProjectId">
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
										<input class="form-control" type="text" id="settingProjectPID">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Name Project</label>
										<input class="form-control" type="text" id="settingProjectName">
									</div>
								</div>
							</div>
							<!-- <hr style="margin-top: 0px;">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Project Start</label>
										<input class="form-control" type="text" id="settingProjectStart" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Number of Period</label>
										<input class="form-control" type="text" id="settingProjectPeriod" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Duration Period</label>
										<input class="form-control" type="text" id="settingProjectDuration" readonly>
									</div>
								</div>
							</div> -->
							<hr style="margin-top: 0px;">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Coordinator</label>
										<select class="form-control select2" id="settingProjectCoordinator" style="width: 100%"></select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Leader</label>
										<select class="form-control select2" id="settingProjectLeader" style="width: 100%"></select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Team Member</label>
										<select class="form-control select2" id="settingProjectTeam" multiple="multiple" style="width: 100%"></select>
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
						<button class="btn btn-success saveSettingChange">Save</button>
						<!-- <button class="btn btn-success savePeriodeChange">Save</button> -->
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalSettingPeriod">
			<div class="modal-dialog modal-lg" id="modalSettingPeriod-default-size">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<div id="modalSettingPeriodTitle">
							<h4 class="modal-title"></h4>
							<p></p>
						</div>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Project Start</label>
										<input class="form-control" type="text" id="settingPeriodStart" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Number of Period</label>
										<input class="form-control" type="text" id="settingPeriodPeriod" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Duration Period</label>
										<input class="form-control" type="text" id="settingPeriodDuration" readonly>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<label>Period Schema</label>
									<table class="table table-hover table-period-schema">
										<tbody>
											<tr>
												<th>Name Event</th>
												<th class="text-center">Start</th>
												<th class="text-center">End</th>
												<th>Status</th>
												<th></th>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success savePeriodeChange">Save</button>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection 

@section('script')
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<!-- moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<!-- HumanizeDuration.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/humanize-duration/3.20.1/humanize-duration.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap Toggle -->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- Date Range Picker -->
<script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
Custom Color Converter
<script src="{{url('js/hue-to-rgb.js')}}"></script>
<script>
	$(document).ready(function(){
		getAllProjectList();

		// Get Member for Input Project
		$.ajax({
			type:"GET",
			url:'{{url("project/manage/getMember")}}',
			success: function(result){
				$("#settingProjectCoordinator").select2({
					placeholder: "Select a Coordinator",
					data: result.coordinator
				});
				$("#settingProjectLeader").select2({
					placeholder: "Select a Project Lead",
					data: result.all
				});

				$("#settingProjectTeam").select2({
					closeOnSelect: false,
					placeholder: "Select Member",
					data: result.all
				});
			}
		});

		// editProject(25);
	});

	var tempPeriodeChange = []

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
				{ "data" : "project_start" , "orderData":[ 3 ] , "targets": [ 1 ]},
				{ "data" : "project_start2" , "targets": [ 3 ] , "visible": false , "searchable": false},
				{ "data" : "project_coordinator" },
				{ 
					"data": null,
					"defaultContent" : "<button class='btn btn-primary btn-xs edit-project'>Edit</button> <button class='btn btn-primary btn-xs edit-period'>Period</button>",
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

	$(document).on('click','.edit-project',function(){
		var row = $("#tableProjectSetting").DataTable().row( $(this).closest('tr') );
		console.log(row.data().id)
		editProject(row.data().id);
	})

	$(document).on('click','.edit-period',function(){
		var row = $("#tableProjectSetting").DataTable().row( $(this).closest('tr') );
		console.log(row.data().id)
		editPeriod(row.data().id);
	})

	$(document).on('click','p.btn-primary.btn-xs',function(){
		var idRowPeriod =  $(this).closest('tr').find(".idRowPeriod").text();
		// console.log(idRowPeriod)
		$(".updatePeriodTd" + idRowPeriod).toggle()
		$(".startPeriod" + idRowPeriod).toggle()
		$(".endPeriod" + idRowPeriod).toggle()
		// editPeriod(row.data().id);
	})

	$(document).on('click','.savePeriodeChange',function(){
		savePeriodeChange()
	})

	$(document).on('click','.saveSettingChange',function(){
		saveSettingChange()
	})

	// $('#tableProjectSetting').on('click','td.edit-td', function () {
	// 	var tr = $(this).closest('tr');
	// 	$("#tableProjectSetting").DataTable().row( tr );
	// 	// console.log(row.data().id);
	// 	editProject(row.data().id);
	// });



	function editProject(id){
		
		$("#SettingProjectId").val('');
		$("#SettingProjectId").val(id);
		$.ajax({
			type:"GET",
			url:"{{url('project/setting/getSettingProject')}}",
			data:{
				id:id
			},
			success:function(result){
				// console.log(id);
				var project = result[0]
				$("#modalSettingProjectTitle").text('Setting for Project ' + project.project_name);
				$("#settingProjectCustomer").val(project.project_customer)
				$("#settingProjectPID").val(project.project_pid)
				$("#settingProjectName").val(project.project_name)

				$("#settingProjectCoordinator").val(project.project_coordinator).trigger('change')
				$("#settingProjectLeader").val(project.project_leader).trigger('change')
				$("#settingProjectTeam").val(project.team).trigger('change')

				// $("#settingProjectLeader").val(project.project_leader)
				// $("#settingProjectTeam").val(project.project_name)

				$("#modalSettingProject").modal('show');
			}
		});
	};

	function saveSettingChange(){
		$.ajax({
			type:"GET",
			url:"{{url('project/setting/setSettingProject')}}",
			data:{
				id:$("#SettingProjectId").val(),
				ProjectPID:$("#settingProjectPID").val(),
				ProjectName:$("#settingProjectName").val(),
				ProjectCoordinator:$("#settingProjectCoordinator").val(),
				ProjectLeader:$("#settingProjectLeader").val(),
				ProjectTeam:$("#settingProjectTeam").val(),
			},
			success: function(result){
				$("#modalSettingProject").modal('hide')
			}
		})
		// console.log($("#settingProjectPID").val())
		// console.log($("#settingProjectName").val())
		// console.log($("#settingProjectCoordinator").val())
		// console.log($("#settingProjectLeader").val())
		// console.log($("#settingProjectTeam").val())
	}

	function editPeriod(id){
		var periods = []
		$.ajax({
			type:"GET",
			url:"{{url('project/setting/getSettingPeriod')}}",
			data:{
				id:id
			},
			success:function(result){
				// console.log(id);
				periods = result[1]
				result = result[0]
				$(".table-period-schema tbody").html('')
				$("#modalSettingPeriodTitle").html('<h4 class="modal-title">Period Setting for ' + result.project_name + '</h4><p>' + result.project_pid + '</p>');
				$("#settingPeriodStart").val(moment(result.project_start).format("D MMMM YYYY"))
				$("#settingPeriodPeriod").val(result.project_periode + ' Periods')
				$("#settingPeriodDuration").val(result.project_periode_duration + ' Month')
				periods.forEach(function(period){
					var append = '';
					tempPeriodeChange = []
					if(period.status == "Active"){
						period.status = '<span class="label label-primary"> ' + period.status + ' </span>'
					} else if (period.status == "On Going"){
						period.status = '<span class="label label-danger"> ' + period.status + ' </span>'
					} else {
						period.status = '<span class="label bg-gray"> ' + period.status + ' </span>'
					}

					var valuePeriod = moment(period.note.split("-")[0],"D MMMM YYYY ").format("D MMMM YYYY") + " - " + moment(period.note.split("-")[1]," D MMMM YYYY").format("D MMMM YYYY")

					append += '<tr class="updatePeriod' + period.id + '">'
					append += '<td style="display:none" class="idRowPeriod">' + period.id + '</td>'
					append += '<td>' + period.name + '</td>'
					append += '<td style="display:none" class="updatePeriodTd' + period.id + '" colspan="2">'
					append += '	<input type="text" class="form-control pull-right updatePeriodPicker' + period.id + '" style="text-align:center;">'
					append += '</td>'
					append += '<td class="text-center startPeriod' + period.id + '">' + moment(period.note.split("-")[0],"D MMMM YYYY ").format("D MMMM YYYY") + '</td>'
					append += '<td class="text-center endPeriod' + period.id + '">' + moment(period.note.split("-")[1]," D MMMM YYYY").format("D MMMM YYYY") + '</td>'
					append += '<td>' + period.status + '</td>'
					append += '<td><p class="btn btn-primary btn-xs">Edit</p></td>'
					append += '</tr>'

					$(".table-period-schema tbody").append(append)

					$(".updatePeriod" + period.id).daterangepicker({
						opens: 'center',
						drops: "down",
						startDate: moment(period.note.split("-")[0],"D MMMM YYYY ").format("DD/MM/YYYY"),
					    endDate: moment(period.note.split("-")[0],"D MMMM YYYY ").format("DD/MM/YYYY"),
						locale: {
							format:"DD/MM/YYYY",
						}
					},function(start, end, label){
						// console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
						var datePickerSelector = ".updatePeriodPicker" + period.id;
						$(datePickerSelector).val(start.format('D MMMM YYYY') + ' to ' + end.format('D MMMM YYYY'))
						// console.log(datePickerSelector)

						tempPeriodeChange.push({
							"id_event":period.id,
							"start_date":start.format('YYYY-MM-DD'),
							"due_date":end.format('YYYY-MM-DD')})
					})

					$(".updatePeriod" + period.id).on('show.daterangepicker', function (ev, picker) {
						if (picker.element.offset().top - $(window).scrollTop() + picker.container.outerHeight() > $(window).height()) {
							picker.drops = 'up';
						} else {
							picker.drops = 'down';
						}
						picker.move();
					});

				})
				$("#modalSettingPeriod").modal('show');
			}
		});
	};

	function savePeriodeChange(){
		tempPeriodeChange.forEach(function(period,index){
			var note = moment(period.start_date,"YYYY-MM-DD").format("D MMMM YYYY") + " - " + moment(period.due_date,"YYYY-MM-DD").format("D MMMM YYYY");
			tempPeriodeChange[index].note = note
		})
		if(tempPeriodeChange.length != 0){
			$.ajax({
				type:"GET",
				url:"{{url('project/setting/setSettingPeriod')}}",
				data:{
					periods:tempPeriodeChange
				}
			});
		}
		
	}

</script>
@endsection