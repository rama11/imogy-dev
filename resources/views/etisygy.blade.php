@extends('layouts.engineer.elayout') 
@section('content')
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
							<li class=""><a href="#performance" data-toggle="tab" aria-expanded="false" id="tabPerformace">Performance</a></li>
							
							<li class=""><a href="#myticket" data-toggle="tab" aria-expanded="false">My Ticket</a></li>
							<li class=""><a href="#tracking" data-toggle="tab" aria-expanded="false">Tracking Ticket</a></li>
							<li class=""><a href="#tracking" data-toggle="tab" aria-expanded="false">Close Ticket</a></li>
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
								<div class="box box-success">
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
							<div class="tab-pane active" id="dashboard1">
								<!-- /.box -->
								<!-- BAR CHART -->
								<div class="box box-success">
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
							
							<div class="tab-pane" id="myticket">
							activity4
							</div>
							<div class="tab-pane" id="tracking">
							activity5
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<!-- <section class="content">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class=""><a href="#dashboard" data-toggle="tab" aria-expanded="true">Dashboard Ticket</a></li>
			<li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Performance</a></li>
			<li class="active"><a href="#create" data-toggle="tab" aria-expanded="false">Create</a></li>
			<li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Management Ticket</a></li>
			<li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Tracking Ticket</a></li>
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
					<li role="presentation" class="divider"></li>
					<li role="presentation">
						<a role="menuitem" tabindex="-1" href="#">Separated link</a>
					</li>
				</ul>
			</li>
			<li class="pull-right">
				<a href="#" class="text-muted"><i class="fa fa-gear"></i></a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="create">

				<form class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="inputNomor" class="col-sm-2 control-label">Nomor Ticket</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputticket" placeholder="enter..."></div>
						</div>
						<div class="form-group">
							<label for="inputDescription" class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputdescription" placeholder="enter..."></div>
						</div>
						<div class="form-group">
							<label for="inputCreator" class="col-sm-2 control-label">User</label>
							<div class="col-sm-10">
								<select class="form-control">
				                    <option>option 1</option>
				                    <option>option 2</option>
				                    <option>option 3</option>
				                    <option>option 4</option>
				                    <option>option 5</option>
				                </select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputemail" placeholder="enter..."></div>
						</div>
						<div class="form-group">
							<label for="inputContact" class="col-sm-2 control-label">Contact</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputcontact" placeholder="enter..."></div>
						</div>
						<div class="form-group">
							<label for="inputPriority" class="col-sm-2 control-label">Priority</label>
							<div class="col-sm-10">
								<select class="form-control">
				                    <option>option 1</option>
				                    <option>option 2</option>
				                    <option>option 3</option>
				                    <option>option 4</option>
				                    <option>option 5</option>
				                </select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputAgent" class="col-sm-2 control-label">Agent</label>
							<div class="col-sm-10">
								<select class="form-control">
				                    <option>option 1</option>
				                    <option>option 2</option>
				                    <option>option 3</option>
				                    <option>option 4</option>
				                    <option>option 5</option>
				                </select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputStatus" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputstatus" placeholder="enter..."></div>
						</div>
						<div class="input-group">
							<label for="inputStatus" class="col-sm-2 control-label"></label>
							<span class="input-group-addon">
							<i class="fa fa-envelope"></i></span>
							<input type="email" class="form-control" placeholder="Email"></div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right">Create</button>
						</div>
					</div>
				</form>
			</div>

			<div class="tab-pane active" id="dashboard">

				<form class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="inputNomor" class="col-sm-2 control-label">Nomor Ticket</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputticket" placeholder="enter..."></div>
						</div>
						<div class="form-group">
							<label for="inputDescription" class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputdescription" placeholder="enter..."></div>
						</div>
						<div class="form-group">
							<label for="inputCreator" class="col-sm-2 control-label">User</label>
							<div class="col-sm-10">
								<select class="form-control">
				                    <option>option 1</option>
				                    <option>option 2</option>
				                    <option>option 3</option>
				                    <option>option 4</option>
				                    <option>option 5</option>
				                </select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputemail" placeholder="enter..."></div>
						</div>
						<div class="form-group">
							<label for="inputContact" class="col-sm-2 control-label">Contact</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputcontact" placeholder="enter..."></div>
						</div>
						<div class="form-group">
							<label for="inputPriority" class="col-sm-2 control-label">Priority</label>
							<div class="col-sm-10">
								<select class="form-control">
				                    <option>option 1</option>
				                    <option>option 2</option>
				                    <option>option 3</option>
				                    <option>option 4</option>
				                    <option>option 5</option>
				                </select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputAgent" class="col-sm-2 control-label">Agent</label>
							<div class="col-sm-10">
								<select class="form-control">
				                    <option>option 1</option>
				                    <option>option 2</option>
				                    <option>option 3</option>
				                    <option>option 4</option>
				                    <option>option 5</option>
				                </select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputStatus" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputstatus" placeholder="enter..."></div>
						</div>
						<div class="input-group">
							<label for="inputStatus" class="col-sm-2 control-label"></label>
							<span class="input-group-addon">
							<i class="fa fa-envelope"></i></span>
							<input type="email" class="form-control" placeholder="Email"></div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right">Create</button>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
	</section> -->
</div>
@endsection 
@section('script')

<script>
$(function () {

	var areaChartData = {
		labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
		datasets: [
			{
					label: "Electronics",
				fillColor: "rgba(210, 214, 222, 1)",
				strokeColor: "rgba(210, 214, 222, 1)",
				pointColor: "rgba(210, 214, 222, 1)",
				pointStrokeColor: "#c1c7d1",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [65, 59, 80, 81, 56, 55, 40]
			},
			{
				label: "Digital Goods",
				fillColor: "rgba(60,141,188,0.9)",
				strokeColor: "rgba(60,141,188,0.8)",
				pointColor: "#3b8bba",
				pointStrokeColor: "rgba(60,141,188,1)",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(60,141,188,1)",
				data: [28, 48, 40, 19, 86, 27, 90]
			}
		]
	};

		//-------------
		//- PIE CHART -
		//-------------
		// Get context with jQuery - using jQuery's .get() method.
		$("#tabPerformace").click(function () {
		
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
		
		});
		

//BAr chart
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[1].fillColor = "#00a65a";
    barChartData.datasets[1].strokeColor = "#00a65a";
    barChartData.datasets[1].pointColor = "#00a65a";
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
</script>
@endsection