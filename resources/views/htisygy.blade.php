@extends('layouts.helpdesk.hlayout')
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
			<a href="{{url('helpdesk')}}"><i class="fa fa-dashboard"></i> Home</a>
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
							<li class=""><a href="#performance" data-toggle="tab" aria-expanded="false">Performance</a></li>
							<li class=""><a href="#create" data-toggle="tab" aria-expanded="false">Create</a></li>
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
									<div class="box-body">
										<div class="chart">
											<canvas id="barChart" style="height:230px;"></canvas>
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


							<div class="tab-pane" id="create">
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
											<input type="text" class="form-control" id="inputdescription" placeholder="Problem Description"></div>
									</div>
									<div class="form-group">
										<label for="inputDescription" class="col-sm-2 control-label">Subject</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputdescription" placeholder="Subject"></div>
									</div>
									<div class="form-group">
										<label for="inputCreator" class="col-sm-2 control-label">Device Type</label>
										<div class="col-sm-10">
											<select class="form-control">
							                    <option>Server</option>
							                    <option>Network</option>
							                    <option>Firewall</option>
							                    <option>Wireless</option>
							                    <option>DLL</option>
							                </select>
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail" class="col-sm-2 control-label">Name</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputemail" placeholder="User Name"></div>
									</div>
									<div class="form-group">
										<label for="inputCreator" class="col-sm-2 control-label">Company</label>
										<div class="col-sm-10">
											<select class="form-control">
							                    <option>BAF</option>
							                    <option>ICON+</option>
							                    <option>TTNI</option>
							                    <option>BPJS</option>
							                    <option>BJB</option>
							                </select>
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail" class="col-sm-2 control-label">Email</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputemail" placeholder="User Email"></div>
									</div>
									<div class="form-group">
										<label for="inputContact" class="col-sm-2 control-label">Contact</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputcontact" placeholder="Contact User"></div>
									</div>
									<div class="form-group">
										<label for="inputEmail" class="col-sm-2 control-label">Location</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputemail" placeholder="User Location"></div>
									</div>
									
									<div class="form-group">
										<label for="inputPriority" class="col-sm-2 control-label">Priority</label>
										<div class="col-sm-10">
											<select class="form-control">
							                    <option>P4</option>
							                    <option>P3</option>
							                    <option>P2</option>
							                    <option>P1</option>
							                    
							                </select>
										</div>
									</div>
									<div class="form-group">
										<label for="inputAgent" class="col-sm-2 control-label">Agent</label>
										<div class="col-sm-10">
											<select class="form-control">
							                    <option>DAUS</option>
							                    <option>RANGGA</option>
							                    <option>DICKY</option>
							                    <option>YOHANNIS</option>
							                    <option>SAIKU</option>
							                </select>
										</div>
									</div>
									<div class="form-group">
										<label for="inputPriority" class="col-sm-2 control-label">Status Case</label>
										<div class="col-sm-10">
											<select class="form-control">
							                    <option>Normal</option>
							                    <option>High</option>
							                    <option>Critical</option>
							                    
							                    
							                </select>
										</div>
									</div>


									<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Email</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-primary btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="#" method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" placeholder="Subject">
                </div>
                <div>
                  <ul class="wysihtml5-toolbar" style=""><li class="dropdown">
  <a class="btn btn-default dropdown-toggle " data-toggle="dropdown">
    
      <span class="glyphicon glyphicon-font"></span>
    
    <span class="current-font">Normal text</span>
    <b class="caret"></b>
  </a>
  <ul class="dropdown-menu">
    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="p" tabindex="-1" href="javascript:;" unselectable="on" class="wysihtml5-command-active">Normal text</a></li>
    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1" tabindex="-1" href="javascript:;" unselectable="on">Heading 1</a></li>
    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2" tabindex="-1" href="javascript:;" unselectable="on">Heading 2</a></li>
    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h3" tabindex="-1" href="javascript:;" unselectable="on">Heading 3</a></li>
    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h4" tabindex="-1" href="javascript:;" unselectable="on">Heading 4</a></li>
    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h5" tabindex="-1" href="javascript:;" unselectable="on">Heading 5</a></li>
    <li><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h6" tabindex="-1" href="javascript:;" unselectable="on">Heading 6</a></li>
  </ul>
</li>
<li>
  <div class="btn-group">
    <a class="btn btn-default" data-wysihtml5-command="bold" title="CTRL+B" tabindex="-1" href="javascript:;" unselectable="on">Bold</a>
    <a class="btn btn-default" data-wysihtml5-command="italic" title="CTRL+I" tabindex="-1" href="javascript:;" unselectable="on">Italic</a>
    <a class="btn btn-default" data-wysihtml5-command="underline" title="CTRL+U" tabindex="-1" href="javascript:;" unselectable="on">Underline</a>
    
    <a class="btn btn-default" data-wysihtml5-command="small" title="CTRL+S" tabindex="-1" href="javascript:;" unselectable="on">Small</a>
    
  </div>
</li>
<li>
  <a class="btn btn-default" data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="blockquote" data-wysihtml5-display-format-name="false" tabindex="-1" href="javascript:;" unselectable="on">
    
      <span class="glyphicon glyphicon-quote"></span>
    
  </a>
</li>
<li>
  <div class="btn-group">
    <a class="btn btn-default" data-wysihtml5-command="insertUnorderedList" title="Unordered list" tabindex="-1" href="javascript:;" unselectable="on">
    
      <span class="glyphicon glyphicon-list"></span>
    
    </a>
    <a class="btn btn-default" data-wysihtml5-command="insertOrderedList" title="Ordered list" tabindex="-1" href="javascript:;" unselectable="on">
    
      <span class="glyphicon glyphicon-th-list"></span>
    
    </a>
    <a class="btn btn-default" data-wysihtml5-command="Outdent" title="Outdent" tabindex="-1" href="javascript:;" unselectable="on">
    
      <span class="glyphicon glyphicon-indent-right"></span>
    
    </a>
    <a class="btn btn-default" data-wysihtml5-command="Indent" title="Indent" tabindex="-1" href="javascript:;" unselectable="on">
    
      <span class="glyphicon glyphicon-indent-left"></span>
    
    </a>
  </div>
</li>
<li>
  <div class="bootstrap-wysihtml5-insert-link-modal modal fade" data-wysihtml5-dialog="createLink">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Insert link</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input value="http://" class="bootstrap-wysihtml5-insert-link-url form-control" data-wysihtml5-dialog-field="href">
          </div> 
          <div class="checkbox">
            <label> 
              <input type="checkbox" class="bootstrap-wysihtml5-insert-link-target" checked="">Open link in new window
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <a class="btn btn-default" data-dismiss="modal" data-wysihtml5-dialog-action="cancel" href="#">Cancel</a>
          <a href="#" class="btn btn-primary" data-dismiss="modal" data-wysihtml5-dialog-action="save">Insert link</a>
        </div>
      </div>
    </div>
  </div>
  <a class="btn btn-default" data-wysihtml5-command="createLink" title="Insert link" tabindex="-1" href="javascript:;" unselectable="on">
    
      <span class="glyphicon glyphicon-share"></span>
    
  </a>
</li>
<li>
  <div class="bootstrap-wysihtml5-insert-image-modal modal fade" data-wysihtml5-dialog="insertImage">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Insert image</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input value="http://" class="bootstrap-wysihtml5-insert-image-url form-control" data-wysihtml5-dialog-field="src">
          </div> 
        </div>
        <div class="modal-footer">
          <a class="btn btn-default" data-dismiss="modal" data-wysihtml5-dialog-action="cancel" href="#">Cancel</a>
          <a class="btn btn-primary" data-dismiss="modal" data-wysihtml5-dialog-action="save" href="#">Insert image</a>
        </div>
      </div>
    </div>
  </div>
  <a class="btn btn-default" data-wysihtml5-command="insertImage" title="Insert image" tabindex="-1" href="javascript:;" unselectable="on">
    
      <span class="glyphicon glyphicon-picture"></span>
    
  </a>
</li>
</ul><textarea class="textarea" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;" placeholder="Message"></textarea><input type="hidden" name="_wysihtml5_mode" value="1"><iframe class="wysihtml5-sandbox" security="restricted" allowtransparency="true" frameborder="0" width="0" height="0" marginwidth="0" marginheight="0" style="display: inline-block; background-color: rgb(255, 255, 255); border-collapse: separate; border-color: rgb(221, 221, 221); border-style: solid; border-width: 1px; clear: none; float: none; margin: 0px; outline: rgb(51, 51, 51) none 0px; outline-offset: 0px; padding: 10px; position: static; top: auto; left: auto; right: auto; bottom: auto; z-index: auto; vertical-align: baseline; text-align: start; box-sizing: border-box; box-shadow: none; border-radius: 0px; width: 100%; height: 125px;"></iframe>
                </div>
              </form>
            </div>
            <div class="box-footer clearfix">
              <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>

									<div class="box-footer">
										
										<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            							<i class="fa fa-pencil-square-o"></i> Create Ticket
          								</button>
									</div>
								</div>
							</form>
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
<!-- jQuery 3.1.1 -->
<script src="../../plugins/jQuery/jquery-3.1.1.min.js"></script>

<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
@endsection