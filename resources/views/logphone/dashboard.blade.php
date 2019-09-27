@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('head')

@endsection

@section('content')
<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<!-- <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Dashboard</li>
			</ol> -->
		</section>

		<!-- Main content -->
		<section class="content">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-4">
				<div class="small-box bg-yellow">
					<div class="inner">
					<h3>{{$data["allcalls"]}}</h3>

						<p>All Calls</p>
					</div>
					<div class="icon">
						<i class="fa  fa-phone"></i>
					</div>
				</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-4">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>{{$data["rejectcalls"]}}</h3>

						<p>Call Out</p>
					</div>
					<div class="icon">
						<i class="fa  fa-remove"></i>
					</div>
				</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

				<!-- fix for small devices only -->
				<div class="clearfix visible-sm-block"></div>

				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-4">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>{{$data["answere"]}}</h3>

						<p>Call In</p>
					</div>
					<div class="icon">
						<i class="fa  fa-check"></i>
					</div>
				</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Call History</h3>
							<a href="#" class="pull-right btn-box-tool text-green pull-right" data-toggle="modal" data-target="#modal-addlog"><i class="fa fa-plus"></i> Add New Log</a>
							<div class="box-tools">
								<div class="input-group input-group-sm" style="width: 150px;">

								</div>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover" id="tableLogPhone">
								<thead>
									<tr>
										<th>ID</th>
										<th>Answered</th>
										<th>Date - Time</th>
										<th>Discussion</th>
										<th>Involved</th>
										<th>Details</th>
									</tr>
								</thead>
							</table>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
			</div>
			
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<div class="modal fade in" id="modal-addlog"  tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<form method="POST" action="{{url ('/logphone/setNewLog')}}">
				{!! csrf_field() !!}
				<input type="hidden" name="id_detail_history" id="inputIdDetailHistory">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Add New Log</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<label for="answered" class="col-md-3 control-label">Answered by</label>
							<div class="col-md-9">
								<div class="form-group">
								<input type="text" class="form-control" name="answered" value="{{Auth::user()->name}}" required autofocus>                                     
								</div>
							</div>
						</div>
						<div class="row">
							<label for="date-time" class="col-md-3 control-label">Time Answerd</label>
							<div class="col-md-9">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-clock-o"></i>
									</div>
									<input type="text" class="form-control timepicker" name="date" id="inputTimeAnswed">
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<label for="involved" class="col-md-3 control-label">Caller</label>
							<div class="col-md-9">
								<div class="form-group">
								<input type="text" class="form-control" name="caller" value="" required autofocus>                                     
								</div>
							</div>
						</div>
						<div class="row">
							<label for="discussion" class="col-md-3 control-label">Discussion</label>
							<div class="col-md-9">
								<div class="form-group">
								<input type="text" class="form-control" name="discussion" value="" required autofocus>                                     
								</div>
							</div>
						</div>
						<div class="row">
							<label for="involved" class="col-md-3 control-label">Involved</label>
							<div class="col-md-9">
								<div class="form-group">
								<input type="text" class="form-control" name="involved" value="" required autofocus>                                     
								</div>
							</div>
						</div>
						<div class="row">
							<label for="details" class="col-md-3 control-label">Details</label>
							<div class="col-md-9">
								<div class="form-group">
									<select name="details" class="form-control" >
										<option value="0">Call in</option>
										<option value="1">Call out</option>
									</select>                                    
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" >Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@section('script')

<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script type="text/javascript">
	function check_log() {
		if($("#modal-addlog").is(':visible') == false){
			$.ajax({
				type:"GET",
				url:"{{url('/logphone/getLastestCall')}}",
				success: function (result){
					// console.log(result)
					// console.log(result.length)
					if(result.length !== 1) {
						$("#inputTimeAnswed").val(moment(result.history.eventtime,"YYYY-MM-DD HH:mm:ss").format('D MMMM YYYY - HH:mm'))
						$("#inputIdDetailHistory").val(result.id)
						$("#modal-addlog").show()
					}
				}
			})
		}
	}

	function repeatEvery(func, interval) {
		var now = new Date(),
			delay = interval - now % interval;

		function start() {
			func();
			setInterval(func, interval);
		}

		setTimeout(start, delay);
	}

	repeatEvery(check_log, 60000);

	// setInterval(check_log,60000)

	$("#inputReport1").timepicker({
		showInputs: false,
		minuteStep: 1,
		maxHours: 24,
		showMeridian: false,
		showSeconds:true,
	});

	$('#inputReport2').datepicker({
		autoclose: true,
		dateFormat: 'd M, y',
	});

	$("#tableLogPhone").DataTable({
		"ajax":{
			"type":"GET",
			"url":"{{url('logphone/getAllLogPhone')}}",
		},
		"columns": [
			{ "data" : "id" },
			{ "data" : "answered" },
			{ "data" : "date" },
			{ "data" : "discussion" },
			{ "data" : "involved" },
			{ "data" : "details" },
		],
		"order": [0, "DESC" ],
	});
</script>            
@endsection