@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))
@section('head')
<!-- Chart.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
<style type="text/css">
	.products-list .product-info {
		margin-left: 0px;
	}
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
			<div class="col-sm-3">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-hourglass-half"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Approaching End</span>
						<span class="info-box-number approching_end">2<small> Project</small></span>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="info-box">
					<span class="info-box-icon bg-yellow"><i class="fa fa-calendar-times-o"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Due this Mount</span>
						<span class="info-box-number due_this_month">5<small> Project</small></span>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-clock-o"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Occurring Project</span>
						<span class="info-box-number occurring_now">5<small> Project</small></span>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="fa fa-flag-checkered"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Finish Project</span>
						<span class="info-box-number finish_project">2<small> Project</small></span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<section class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="box">
							
							<div class="box">
								<div class="box-header with-border">
									<h3 class="box-title">Lastest Update Project</h3>

									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
											<i class="fa fa-minus"></i></button>
										<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
											<i class="fa fa-times"></i></button>
									</div>
								</div>
								<div class="box-body" style="">
									<ul class="products-list product-list-in-box" id="lastestUpdate">
									</ul>
								</div>
								<div class="box-footer" style="">
									<a>More...</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="box">
							<div class="box-header with-border">
								<h3 class="box-title">Status Project Chart</h3>

								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
										<i class="fa fa-minus"></i></button>
									<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
										<i class="fa fa-times"></i></button>
								</div>
							</div>
							<div class="box-body" style="">
								<canvas id="precentageChart" style="height:250px"></canvas>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Project With Closest Due Date</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table no-margin">
								<thead>
									<tr>
										<th>Project ID</th>
										<th>Name</th>
										<th>Lastest Act</th>
										<th>Due Date</th>
									</tr>
								</thead>
								<tbody id="resultChartTable">
									<tr>
										<td style="vertical-align:middle;"><a href="pages/examples/invoice.html">297/SOMPO/PO 228/SIP/VI/2017</a></td>
										<td>
											<a href="#">[PT. Sompo Insurance Indonesia]</a>
											<br>Renewal UPS
										</td>
										<td style="vertical-align:middle;"><span class="label label-info">Update</span></td>
										<td style="vertical-align:middle;">7 day ago</td>
									</tr>
									<tr>
										<td style="vertical-align:middle;"><a href="pages/examples/invoice.html">009/BANK RIAU/SPK 001/SIP/I/2018</a></td>
										<td>
											<a href="#">[PT. Bank Riau Kepri]</a>
											<br>Pengadaan Perangkat WAN Optimizer Sangfor PT. Bank Riau Kepri
										</td>
										<td style="vertical-align:middle;"><span class="label label-warning">Pending</span></td>
										<td style="vertical-align:middle;">7 day ago</td>
									</tr>
									<tr>
										<td style="vertical-align:middle;"><a href="pages/examples/invoice.html">076/BANK RIAU/SPK 063/SIP/VI/2018</a></td>
										<td>
											<a href="#">[PT. Bank Riau Kepri]</a>
											<br>Pengadaan jasa Maintenance WAN Router PT. Bank Riau Kepri
										</td>
										<td style="vertical-align:middle;"><span class="label label-info">Update</span></td>
										<td style="vertical-align:middle;">7 day ago</td>
									</tr>
									<tr>
										<td style="vertical-align:middle;"><a href="pages/examples/invoice.html">051/BANK RIAU/SPK 027/SIP/IV/2018</a></td>
										<td>
											<a href="#">[PT. Bank Riau Kepri]</a>
											<br>Perpanjangan Lisensi Antivirus Palo Alto
										</td>
										<td style="vertical-align:middle;"><span class="label label-warning">Pending</span></td>
										<td style="vertical-align:middle;">7 day ago</td>
									</tr>
									<tr>
										<td style="vertical-align:middle;"><a href="pages/examples/invoice.html">075/BANK RIAU/ADD SPK 059/SIP/V/2018</a></td>
										<td>
											<a href="#">[PT. Bank Riau Kepri]</a>
											<br>Pengadaan Jasa Perpanjangan Lisensi Antivirus Trend Micro PT. Bank Riau Kepri
										</td>
										<td style="vertical-align:middle;"><span class="label label-info">Update</span></td>
										<td style="vertical-align:middle;">7 day ago</td>
									</tr>
									<tr>
										<td style="vertical-align:middle;"><a href="pages/examples/invoice.html">343/BANK RIAU/SPK 128/SIP/XII/2018</a></td>
										<td>
											<a href="#">[PT. Bank Riau Kepri]</a>
											<br>Renewal OP Manager For 520 Device PT. Bank Riau Kepri
										</td>
										<td style="vertical-align:middle;"><span class="label label-info">Update</span></td>
										<td style="vertical-align:middle;">7 day ago</td>
									</tr>
									<tr>
										<td style="vertical-align:middle;"><a href="pages/examples/invoice.html">010/BANK RIAU/SPK 002/SIP/I/2018</a></td>
										<td>
											<a href="#">[PT. Bank Riau Kepri]</a>
											<br>Pengadaan Perangkat Priveleged Access Manager PT. Bank Riau Kepri
										</td>
										<td style="vertical-align:middle;"><span class="label label-warning">Pending</span></td>
										<td style="vertical-align:middle;">7 day ago</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="box-footer clearfix">
						<a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Project</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div id="alertPopUp" class="alert alert-warning alert-dismissible" style="margin-top: 150px;margin-right: 10px; position:fixed; top:0; right:0; width:300px;display: none;">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h4>
			<i class="icon fa fa-check"></i> Alert!
		</h4>
		<p></p>
	</div>
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
<!-- moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<script defer src="https://www.gstatic.com/firebasejs/6.1.1/firebase-app.js"></script>
<script defer src="https://www.gstatic.com/firebasejs/6.1.1/firebase-database.js"></script>
<!-- HumanizeDuration.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/humanize-duration/3.20.1/humanize-duration.js"></script>
<!-- <script src="{{url('js/init-firebase.js')}}"></script> -->

<script>
	

	$(document).ready(function(){

		var firebaseConfig = {
			apiKey: "{{env('APIKEY')}}",
			authDomain: "{{env('AUTHDOMAIN')}}",
			databaseURL: "{{env('DATABASEURL')}}",
			projectId: "{{env('PROJECTID')}}",
			storageBucket: "{{env('STOREBUCKET')}}",
			messagingSenderId: "{{env('MESSAGINGSENDERID')}}",
			appId: "{{env('APPID')}}",
		};
		// Initialize Firebase
		firebase.initializeApp(firebaseConfig);

		var ref = firebase.database().ref('project/project_history/').limitToLast(4);
		ref.on('child_added', function(snapshot) {
			// console.log(snapshot.val());
			updateLastest(snapshot.val())
		});


		buildDashboard();
	})

	function buildDashboard(){

		$.ajax({
			type:"GET",
			url:"{{url('project/getDashboardProject')}}",
			success: function(result){
				$(".approching_end").html(result.approching_end.count + '<small> Project</small>')
				$(".due_this_month").html(result.due_this_month.count + '<small> Project</small>')
				$(".occurring_now").html(result.occurring_now.count + '<small> Project</small>')
				$(".finish_project").html(result.finish_project.count + '<small> Project</small>')
				
				// var sourceData = [20,5,2,1,1];
				// console.log(result.chart_data.normal.count)
				var sourceData = [
					result.chart_data.normal.count,
					result.chart_data.warning.count,
					result.chart_data.minor.count,
					result.chart_data.major.count,
					result.chart_data.critical.count
				]
				var data = {
					datasets: [{
						data: sourceData,
						backgroundColor: [
							"#009432",
							"#A3CB38",
							"#FFC312",
							"#F79F1F",
							"#EA2027",
						],
						borderWidth :[ 0, 0, 0, 0, 0]
					}],

					// These labels appear in the legend and in the tooltips when hovering different arcs
					labels: [
						"Normal",
						"Warning",
						"Minor",
						"Major",
						"Critical",
					]
				};

				var ctx = $("#precentageChart");
				var precentageChart = new Chart(ctx, {
					type: 'doughnut',
					data: data,
					options: {
						animation:{
							animateRotate : false,
						},
						legend: {
							position:'right',
						},
						onClick: function(event,item){
							$.ajax({
								type:"GET",
								url:"{{url('project/getProjectByUrgency')}}",
								data:{
									category:item[0]._model.label
								},
								success: function(result){
									$("#resultChartTable").empty()
									
									var day_to_due_date = result.day_to_due_date
									var append = ""
									result[0].forEach(function(d,i){
										console.log(d.latest_history_project.length)
										if(d.latest_history_project.length != 0){
											console.log(d.latest_history_project[0])
											if(d.latest_history_project[0].type == "Update") {
												if(d.latest_history_project[0].note == "Open New Period"){
													var type = "Open"
													var label = "danger"
													var icon = "fa-exclamation"
												} else {
													var type = "Update"
													var label = "info"
													var icon = "fa-info-circle"
												}
											} else if(d.latest_history_project[0].type == "Submit") {
												var type = "Submit"
												var label = "warning"
												var icon = "fa-heart"
											} else if(d.latest_history_project[0].type == "Finish") {
												var type = "Finish"
												var label = "success"
												var icon = "fa-flag-checkered"
											}
										} else {
											var type = "N/A"
											var label = "default"
										} console.log(type + " " + label)

										append = append +
										'<tr>' +
											'<td style="vertical-align:middle;"><a href="pages/examples/invoice.html">' + d.project_pid + '</a></td>' +
											'<td>' +
												'<a href="#">[' + d.customer_project.name + ']</a>' +
												'<br>' + d.project_name +
											'</td>' +
											'<td style="vertical-align:middle;"><span class="label label-' + label + '">' + type + '</span></td>' +
											'<td style="vertical-align:middle;">' + humanizeDuration(moment.duration(day_to_due_date[i],'days').asMilliseconds(),{ units: ['y','mo','d'], round: true, }) + '</td>' +
										'</tr>';
									})
									$("#resultChartTable").append(append);
									// console.log(result)
								}
							})
							// console.log(item[0]._model.label)
						}
					},

				});
			}
		})

	}

	function alertPopUp(data){
		$("#alertPopUp").removeClass();
		$("#alertPopUp").addClass("alert alert-" + data.alert + " alert-dismissible");
		$("#alertPopUp h4").html('<i class="icon fa ' + data.icon + '"></i>' + data.type);
		$("#alertPopUp p").html(data.note);
		$("#alertPopUp").show().delay(4000).fadeOut();
	}

	function updateLastest(data){
		if(data.type == "Update") {
			if(data.note == "Open New Period"){
				var type = "Open"
				var label = "danger"
				var icon = "fa-exclamation"
			} else {
				var type = "Update"
				var label = "info"
				var icon = "fa-info-circle"
			}
		} else if(data.type == "Submit") {
			var type = "Submit"
			var label = "warning"
			var icon = "fa-heart"
		} else if(data.type == "Finish") {
			var type = "Finish"
			var label = "success"
			var icon = "fa-flag-checkered"
		}
		var append = ""
		+ "<li class='item'>"
			+ "<div class='product-info'>"
				+ "<a href='javascript:void(0)' class='product-title'>" + data.project
					+ "<span class='label label-" + label + " pull-right'>" + type + "</span>"
				+ "</a>"
				+ "<span class='product-description'>"
					+ "[" + data.updater + "] " + data.note
				+ "</span>"
			+ "</div>"
		+ "</li>";
		$("#lastestUpdate").append(append);
		var data = {
			alert:label,
			icon:icon,
			type:type,
			note:data.note,
		}
		alertPopUp(data)
	}
</script>
@endsection