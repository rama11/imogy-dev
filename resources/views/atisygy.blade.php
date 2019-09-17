@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')
@section('head')
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" >
@endsection
@section('content')
<style type="text/css">
	.biru {
		color: blue;
	}
</style>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	<img src="img/tisygy.png" width="12%" height="12%">
	<ol class="breadcrumb">
		<li>
			<a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> Home</a>
		</li>
		<li class="active">Tisygy</li>
	</ol>
	</section>
	<section class="content">
			<!-- List Users (Stat box) -->
			<div class="row">
				<div class="col-md-12">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#dashboard1" data-toggle="tab" aria-expanded="true">Dashboard</a></li>
							<li class=""><a href="#create" data-toggle="tab" aria-expanded="false">Create</a></li>
							<li class=""><a href="#performance" data-toggle="tab" aria-expanded="false">Performance</a></li>
							<li class=""><a href="#management" data-toggle="tab" aria-expanded="false">Management Ticket</a></li>
							<li class=""><a href="#tracking" data-toggle="tab" aria-expanded="false">Tracking Ticket</a></li>
							<li class=""><a href="#close" data-toggle="tab" aria-expanded="false"><b>Close Ticket</b></a></li>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">History <span class="caret"></span></a>
							<ul class="dropdown-menu">
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="#">Active Ticket</a>
							</li>
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="#">Closed Ticket</a>
							</li>
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="#">All Ticket</a>
							</li>
							</li>
							</ul>
									
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="dashboard1">
								<!-- /.box -->
								<!-- BAR CHART -->
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Dashboard Ticket</h3>

										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
											</button>
											<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
										</div>
									</div>
									<div class="box-body">
										<div class="chart">
											<canvas id="barChart" style="height:230px"></canvas>
											
										</div>
					
									</div>





					
									<!-- /.box-body -->

								</div>
							</div>

									<!-- /.box-body -->



							<div class="tab-pane" id="performance">
								<div class="box box-danger">
						<div class="box-header with-border">
							<h3 class="box-title">Donut Chart</h3>

							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
								<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body">
							<canvas id="pieChart" style="height: 256px; width: 512px;" height="256" width="512"></canvas>
						</div>
						<!-- /.box-body -->
					</div>
							</div>


							<div class="tab-pane" id="create">
								<div class="box">
									<div class="box-body pad">
										<i class="btn btn-info" onclick="createIdTicket()">Create Ticket</i>
										<form class="form-horizontal" action="{{url('/atisygy')}}" method="post">
											<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
											<div class="form-group" id="nomorDiv" style="display: none;">
												<label for="inputNomor" class="col-sm-2 control-label" >Nomor Ticket</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" id="inputticket" value="" disabled></input>
												</div>
											</div>
											<div class="form-group" id="clinetDiv" style="display: none;">
												<label for="inputCreator" class="col-sm-2 control-label">Client</label>
												<div class="col-sm-10">
													<select class="form-control" id="inputClient">
														<option selected="selected">Chose the client</option>
														<option>BJBR</option>
														<option>BSBB</option>
														<option>BRKR</option>
														<option>TTNI</option>
														<option>SMPO</option>
													</select>
												</div>
											</div>
											<div class="form-group" id="inputRefrence" style="display: none;">
												<label for="inputDescription" class="col-sm-2 control-label">Refrence</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" id="inputdescription" placeholder=""></div>
											</div>
											<div class="form-group" id="picDiv" style="display: none;">
												<label for="inputDescription" class="col-sm-2 control-label">PIC</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" id="inputdescription" placeholder=""></div>
											</div>
											<div class="form-group" id="contactDiv" style="display: none;">
												<label for="inputDescription" class="col-sm-2 control-label">Contact PIC</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" id="inputdescription" placeholder=""></div>
											</div>
											<div class="form-group" id="problemDiv" style="display: none;">
												<label for="inputEmail" class="col-sm-2 control-label">Problem</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" id="inputemail" placeholder=""></div>
											</div>
											<div class="form-group" id="locationDiv" style="display: none;">
												<label for="inputEmail" class="col-sm-2 control-label">Location</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" id="inputemail" placeholder=""></div>
											</div>
											<div class="form-group" id="inputATMid" style="display: none;">
												<label for="inputEmail" class="col-sm-2 control-label">ID ATM</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" id="inputemail" placeholder=""></div>
											</div>
											<div class="form-group" id="serialDiv" style="display: none;">
												<label for="inputEmail" class="col-sm-2 control-label">Serial Number</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" id="inputemail" placeholder=""></div>
											</div>
											<div class="form-group" id="dateDiv" style="display: none;">
												<label for="inputEmail" class="col-sm-2 control-label">Date</label>
												<div class="col-sm-10">
													<input id="dateOpen" type="text" class="form-control" id="inputemail" placeholder="" disabled></div>
											</div>
										</form>
									</div>
								</div>
								<div class="box" id="boxEmail" style="display: none;">
									<div class="box-header">
										<h3 class="box-title">Email Body
											<small>for client</small>
										</h3>
									</div>
									<div class="box-body pad">
										<form>
											<textarea class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
										</form>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="management">
							<div class="box" id="panel_simple">
								<div class="box-header with-border">
				<h3 class="box-title">Ticket List</h3>			
							</div>
							<div class="box-body">
						
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th>No Ticket</th>
							<th>Descrption</th>
							<th>PIC Name</th>
							<th>Company</th>
							<th>Engineer</th>
							<th>Status</th>
							<th>Edit Ticket</th>
						</tr>

						
						<tr>
							<td>IN1271</td>
							<td>Switch Mbeledos</td>
							<td>Miuty</td>
							<td>TTNI</td>
							<td>RANGGA</td>
							<td>Proses</td>
							<td>
							<button type="button" class="btn btn-primary " style="margin-right: 5px;">
										<i class="fa fa-pencil-square-o"></i> Edit Ticket
										</button>
							</td>
					
						</tr>
						<tr>
							<td>IN1261</td>
							<td>Printer Mbeledos</td>
							<td>Miuty Again</td>
							<td>TTNI</td>
							<td>RANGGA</td>
							<td>Bodo Amat</td>
							<td>
							<button type="button" class="btn btn-primary " style="margin-right: 5px;">
										<i class="fa fa-pencil-square-o"></i> Edit Ticket
										</button>
							</td>
					
						</tr>
					
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
			<div class="box-footer clearfix">
				<p class="pull-right">For more other history information. Click <b id="detail" style="cursor:pointer">here</b></p>
			</div>
			<!-- /.box-footer-->
	
		</div>
							</div>
							<div class="tab-pane" id="close">
							
							<div class="box" id="panel_simple">
								<div class="box-header with-border">
				<h3 class="box-title">Tracking Ticket</h3>	
				<div class="box-tools">
								<div class="input-group input-group-sm" style="width: 150px;">
									<input name="table_search" class="form-control pull-right" placeholder="Search" type="text">

									<div class="input-group-btn">
										<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
									</div>
								</div>
							</div>		
							</div>
							<div class="box-body">
						
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th>No Ticket</th>
							<th>Descrption</th>
							<th>PIC Name</th>
							<th>Company</th>
							<th>Engineer</th>
							<th>Status</th>
							<th>Detail</th>
						</tr>

						
						<tr>
							<td>IN1271</td>
							<td>Switch Mbeledos</td>
							<td>Miuty</td>
							<td>TTNI</td>
							<td>RANGGA</td>
							<td>Proses</td>
							<td>
							<button type="button" class="btn btn-danger " style="margin-right: 5px;">
										<i class="fa fa-external-link"></i>Close Ticket
										</button>
							</td>

					
						</tr>
						<tr>
							<td>IN1261</td>
							<td>Printer Mbeledos</td>
							<td>Miuty is beauty</td>
							<td>TTNI</td>
							<td>RANGGA</td>
							<td>Bodo Amat</td>
							<td>
							<button type="button" class="btn btn-danger " style="margin-right: 5px;">
										<i class="fa fa-external-link"></i>Close Ticket
										</button>
							</td>

					
					
						</tr>
					
					</tbody>
				</table>
							


							
						</div>
					</div>
							</div>


							<div class="tab-pane" id="tracking">
							<div class="box" id="panel_simple">
								<div class="box-header with-border">
				<h3 class="box-title">Tracking Ticket</h3>	
				<div class="box-tools">
								<div class="input-group input-group-sm" style="width: 150px;">
									<input name="table_search" class="form-control pull-right" placeholder="Search" type="text">

									<div class="input-group-btn">
										<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
									</div>
								</div>
							</div>		
							</div>
							<div class="box-body">
						
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th>No Ticket</th>
							<th>Descrption</th>
							<th>PIC Name</th>
							<th>Company</th>
							<th>Engineer</th>
							<th>Status</th>
							<th>Detail</th>
						</tr>

						
						<tr>
							<td>IN1271</td>
							<td>Switch Mbeledos</td>
							<td>Miuty</td>
							<td>TTNI</td>
							<td>RANGGA</td>
							<td>Proses</td>
							<td>
							<button type="button" class="btn btn-primary " style="margin-right: 5px;">
										<i class="fa fa-envelope-o"></i> More Detail
										</button>
							</td>

					
						</tr>
						<tr>
							<td>IN1261</td>
							<td>Printer Mbeledos</td>
							<td>Miuty is beauty</td>
							<td>TTNI</td>
							<td>RANGGA</td>
							<td>Bodo Amat</td>
							<td>
							<button type="button" class="btn btn-primary " style="margin-right: 5px;">
										<i class="fa fa-envelope-o"></i> More Detail
										</button>
							</td>

					
					
						</tr>
					
					</tbody>
				</table>
							</div>


							
						</div>
					</div>
				</div>
			</div>
		</section>
	
</div>
@endsection 
@section('script')
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

<script>
	$(".textarea").wysihtml5();
	function createIdTicket() {
		$.ajax({
			type:"GET",
			url:"/createIdTicket",
			success: function(result){
				$("#inputticket").val(result);
				$("#nomorDiv").show();
				$("#dateOpen").val(moment().format("DD-MMM-YY HH:mm"));
				$("#clinetDiv").show();
			},
		});
	}

	var perawan = 0;

	$("#inputClient").change(function(){
		// updateID(select option:selected);
		if(perawan == 0){
			$("#inputticket").val($("#inputticket").val() + "/" + this.value + moment().format("/MMM/YYYY"));
		} else {
			var str = $("#inputticket").val();
			str = str.substr(0,3);

			$("#inputticket").val(str + "/" + this.value + moment().format("/MMM/YYYY"));
		}

		if(this.value == "BJBR"){
			$("#inputRefrence").show();
		} else {
			$("#inputRefrence").hide();
		}
		if(this.value == "BJBR" || this.value == "BSBB" || this.value == "BRKR"){
			$("#inputATMid").show();
		} else {
			$("#inputATMid").hide();
		}

		$("#nomorDiv").show();
		$("#clinetDiv").show();
		$("#picDiv").show();
		$("#contactDiv").show();
		$("#problemDiv").show();
		$("#locationDiv").show();
		$("#dateDiv").show();
		$("#serialDiv").show();
		$("#boxEmail").show();


		perawan = 1;
		console.log(perawan);
	});




$(function () {


	var areaChartData = {
		labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
		datasets: [
			{
				label: "Open Ticket",
				fillColor: "rgba(210, 214, 222, 1)",
				strokeColor: "rgba(210, 214, 222, 1)",
				pointColor: "rgba(210, 214, 222, 1)",
				pointStrokeColor: "#c1c7d1",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [65, 59, 80, 81, 56, 55, 40]
			},
			{
				label: "Close Ticket",
				fillColor: "rgba(52, 152, 219,1.0)",
				strokeColor: "rgba(60,141,188,0.8)",
				pointColor: "#3b8bba",
				pointStrokeColor: "rgba(60,141,188,1)",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(60,141,188,1)",
				data: [28, 48, 40, 19, 86, 27, 90]
			}
		]
	};

	var barChartCanvas = $("#barChart").get(0).getContext("2d");
	var barChart = new Chart(barChartCanvas);
	var barChartData = areaChartData;
	barChartData.datasets[1].fillColor = "rgba(52, 152, 219,1.0)";
	barChartData.datasets[1].strokeColor = "rgba(52, 152, 219,1.0)";
	barChartData.datasets[1].pointColor = "rgba(52, 152, 219,1.0)";
	var barChartOptions = {
	  //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
	  scaleBeginAtZero: true,
	  //Boolean - Whether grid lines are shown across the chart
	  scaleShowGridLines: true,
	  //String - Colour of the grid lines
	  scaleGridLineColor: "rgba(0,0,0,.05)",
	  //Number - Width of the grid lines
	  scaleGridLineWidth: 1,
	  //Boolean - Whether to show horizontal lines (except X axis)
	  scaleShowHorizontalLines: true,
	  //Boolean - Whether to show vertical lines (except Y axis)
	  scaleShowVerticalLines: true,
	  //Boolean - If there is a stroke on each bar
	  barShowStroke: true,
	  //Number - Pixel width of the bar stroke
	  barStrokeWidth: 2,
	  //Number - Spacing between each of the X value sets
	  barValueSpacing: 5,
	  //Number - Spacing between data sets within X values
	  barDatasetSpacing: 1,
	  //String - A legend template
	  legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
	  //Boolean - whether to make the chart responsive
	  responsive: true,
	  maintainAspectRatio: true
	};

	barChartOptions.datasetFill = false;
	barChart.Bar(barChartData, barChartOptions);
  });


	//-------------
		//- PIE CHART -
		//-------------
		// Get context with jQuery - using jQuery's .get() method.

		var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
		var pieChart = new Chart(pieChartCanvas);
		var PieData = [
			{
				value: 700,
				color: "#f56954",
				highlight: "#f56954",
				label: "Chrome"
			},
			{
				value: 500,
				color: "#00a65a",
				highlight: "#00a65a",
				label: "IE"
			},
			{
				value: 400,
				color: "#f39c12",
				highlight: "#f39c12",
				label: "FireFox"
			},
			{
				value: 600,
				color: "#00c0ef",
				highlight: "#00c0ef",
				label: "Safari"
			},
			{
				value: 300,
				color: "#3c8dbc",
				highlight: "#3c8dbc",
				label: "Opera"
			},
			{
				value: 100,
				color: "#d2d6de",
				highlight: "#d2d6de",
				label: "Navigator"
			}
		];
		var pieOptions = {
			//Boolean - Whether we should show a stroke on each segment
			segmentShowStroke: true,
			//String - The colour of each segment stroke
			segmentStrokeColor: "#fff",
			//Number - The width of each segment stroke
			segmentStrokeWidth: 2,
			//Number - The percentage of the chart that we cut out of the middle
			percentageInnerCutout: 50, // This is 0 for Pie charts
			//Number - Amount of animation steps
			animationSteps: 100,
			//String - Animation easing effect
			animationEasing: "easeOutBounce",
			//Boolean - Whether we animate the rotation of the Doughnut
			animateRotate: true,
			//Boolean - Whether we animate scaling the Doughnut from the centre
			animateScale: false,
			//Boolean - whether to make the chart responsive to window resizing
			responsive: true,
			// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
			maintainAspectRatio: true,
			//String - A legend template
			legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
		};
		//Create pie or douhnut chart
		// You can switch between pie and douhnut using the method below.
		pieChart.Doughnut(PieData, pieOptions);
</script>
@endsection