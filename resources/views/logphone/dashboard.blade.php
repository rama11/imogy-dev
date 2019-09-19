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
				<div class="col-md-4 col-sm-7 col-xs-12">
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
				<div class="col-md-4 col-sm-7 col-xs-12">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>{{$data["rejectcalls"]}}</h3>

						<p>Reject</p>
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

				<div class="col-md-4 col-sm-7 col-xs-12">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>{{$data["answere"]}}</h3>

						<p>Answere</p>
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
							<table class="table table-hover">
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
							<tbody>
								<?php $no = 1 ;?>
								@foreach($logphone as $log)
								<tr>
									<td>{{$no}}</td>
									<td>{{$log->answered}}</td>
									<td>{{$log->date}}</td>
									<td>{{$log->discussion}}</td>
									<td>{{$log->involved}}</td>
									<td>
										@if($log->details == "0")
										<span class="label label-success">Call in</span>
										@elseif($log->details == "1")
										<span class="label label-danger">Call out</span>
										@endif
									</td>
								</tr>
								<?php $no++;?>
								@endforeach
							</tbody>
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
			<form method="POST" action="{{url ('addnew')}}">
				{!! csrf_field() !!}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">Add New Log</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<label for="answered" class="col-md-3 control-label">Answered</label>
							<div class="col-md-9">
								<div class="form-group">
								<input type="text" class="form-control" name="answered" value="{{Auth::user()->name}}" required autofocus>                                     
								</div>
							</div>
						</div>
						<div class="row">
							<label for="date-time" class="col-md-3 control-label">Date Time</label>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-clock-o"></i>
									</div>
									<input type="text" class="form-control timepicker" id="inputReport1">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="inputReport2">
								</div>
							</div>
						</div>
						<br>
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
</script>            
@endsection