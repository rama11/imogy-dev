@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('content')
<div class="content-wrapper">
	<section class="content">
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
			</div>
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
			</div>
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
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Call History</h3>
						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<button class="pull-right btn-success btn-box-tool btn btn-flat btn-xs" onclick="addLog()" style="color: #fff">
									<i class="fa fa-plus"></i> Add New Log
								</button>
							</div>
						</div>
					</div>
					<div class="box-body">
						<!-- <table id="example1" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>Rendering engine</th>
								<th>Browser</th>
								<th>Platform(s)</th>
								<th>Engine version</th>
								<th>CSS grade</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 5.0
								</td>
								<td>Win 95+</td>
								<td>5</td>
								<td>C</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 5.5
								</td>
								<td>Win 95+</td>
								<td>5.5</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 6
								</td>
								<td>Win 98+</td>
								<td>6</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet Explorer 7</td>
								<td>Win XP SP2+</td>
								<td>7</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>AOL browser (AOL desktop)</td>
								<td>Win XP</td>
								<td>6</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Firefox 1.0</td>
								<td>Win 98+ / OSX.2+</td>
								<td>1.7</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Firefox 1.5</td>
								<td>Win 98+ / OSX.2+</td>
								<td>1.8</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Firefox 2.0</td>
								<td>Win 98+ / OSX.2+</td>
								<td>1.8</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Firefox 3.0</td>
								<td>Win 2k+ / OSX.3+</td>
								<td>1.9</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Camino 1.0</td>
								<td>OSX.2+</td>
								<td>1.8</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Camino 1.5</td>
								<td>OSX.3+</td>
								<td>1.8</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Netscape 7.2</td>
								<td>Win 95+ / Mac OS 8.6-9.2</td>
								<td>1.7</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Netscape Browser 8</td>
								<td>Win 98SE+</td>
								<td>1.7</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Netscape Navigator 9</td>
								<td>Win 98+ / OSX.2+</td>
								<td>1.8</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Mozilla 1.0</td>
								<td>Win 95+ / OSX.1+</td>
								<td>1</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Mozilla 1.1</td>
								<td>Win 95+ / OSX.1+</td>
								<td>1.1</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Mozilla 1.2</td>
								<td>Win 95+ / OSX.1+</td>
								<td>1.2</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Mozilla 1.3</td>
								<td>Win 95+ / OSX.1+</td>
								<td>1.3</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Mozilla 1.4</td>
								<td>Win 95+ / OSX.1+</td>
								<td>1.4</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Mozilla 1.5</td>
								<td>Win 95+ / OSX.1+</td>
								<td>1.5</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Mozilla 1.6</td>
								<td>Win 95+ / OSX.1+</td>
								<td>1.6</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Mozilla 1.7</td>
								<td>Win 98+ / OSX.1+</td>
								<td>1.7</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Mozilla 1.8</td>
								<td>Win 98+ / OSX.1+</td>
								<td>1.8</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Seamonkey 1.1</td>
								<td>Win 98+ / OSX.2+</td>
								<td>1.8</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Gecko</td>
								<td>Epiphany 2.20</td>
								<td>Gnome</td>
								<td>1.8</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Webkit</td>
								<td>Safari 1.2</td>
								<td>OSX.3</td>
								<td>125.5</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Webkit</td>
								<td>Safari 1.3</td>
								<td>OSX.3</td>
								<td>312.8</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Webkit</td>
								<td>Safari 2.0</td>
								<td>OSX.4+</td>
								<td>419.3</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Webkit</td>
								<td>Safari 3.0</td>
								<td>OSX.4+</td>
								<td>522.1</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Webkit</td>
								<td>OmniWeb 5.5</td>
								<td>OSX.4+</td>
								<td>420</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Webkit</td>
								<td>iPod Touch / iPhone</td>
								<td>iPod</td>
								<td>420.1</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Webkit</td>
								<td>S60</td>
								<td>S60</td>
								<td>413</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Opera 7.0</td>
								<td>Win 95+ / OSX.1+</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Opera 7.5</td>
								<td>Win 95+ / OSX.2+</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Opera 8.0</td>
								<td>Win 95+ / OSX.2+</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Opera 8.5</td>
								<td>Win 95+ / OSX.2+</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Opera 9.0</td>
								<td>Win 95+ / OSX.3+</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Opera 9.2</td>
								<td>Win 88+ / OSX.3+</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Opera 9.5</td>
								<td>Win 88+ / OSX.3+</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Opera for Wii</td>
								<td>Wii</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Nokia N800</td>
								<td>N800</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Presto</td>
								<td>Nintendo DS browser</td>
								<td>Nintendo DS</td>
								<td>8.5</td>
								<td>C/A<sup>1</sup></td>
							</tr>
							<tr>
								<td>KHTML</td>
								<td>Konqureror 3.1</td>
								<td>KDE 3.1</td>
								<td>3.1</td>
								<td>C</td>
							</tr>
							<tr>
								<td>KHTML</td>
								<td>Konqureror 3.3</td>
								<td>KDE 3.3</td>
								<td>3.3</td>
								<td>A</td>
							</tr>
							<tr>
								<td>KHTML</td>
								<td>Konqureror 3.5</td>
								<td>KDE 3.5</td>
								<td>3.5</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Tasman</td>
								<td>Internet Explorer 4.5</td>
								<td>Mac OS 8-9</td>
								<td>-</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Tasman</td>
								<td>Internet Explorer 5.1</td>
								<td>Mac OS 7.6-9</td>
								<td>1</td>
								<td>C</td>
							</tr>
							<tr>
								<td>Tasman</td>
								<td>Internet Explorer 5.2</td>
								<td>Mac OS 8-X</td>
								<td>1</td>
								<td>C</td>
							</tr>
							<tr>
								<td>Misc</td>
								<td>NetFront 3.1</td>
								<td>Embedded devices</td>
								<td>-</td>
								<td>C</td>
							</tr>
							<tr>
								<td>Misc</td>
								<td>NetFront 3.4</td>
								<td>Embedded devices</td>
								<td>-</td>
								<td>A</td>
							</tr>
							<tr>
								<td>Misc</td>
								<td>Dillo 0.8</td>
								<td>Embedded devices</td>
								<td>-</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Misc</td>
								<td>Links</td>
								<td>Text only</td>
								<td>-</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Misc</td>
								<td>Lynx</td>
								<td>Text only</td>
								<td>-</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Misc</td>
								<td>IE Mobile</td>
								<td>Windows Mobile 6</td>
								<td>-</td>
								<td>C</td>
							</tr>
							<tr>
								<td>Misc</td>
								<td>PSP browser</td>
								<td>PSP</td>
								<td>-</td>
								<td>C</td>
							</tr>
							<tr>
								<td>Other browsers</td>
								<td>All others</td>
								<td>-</td>
								<td>-</td>
								<td>U</td>
							</tr>
							</tbody>
							<tfoot>
							<tr>
								<th>Rendering engine</th>
								<th>Browser</th>
								<th>Platform(s)</th>
								<th>Engine version</th>
								<th>CSS grade</th>
							</tr>
							</tfoot>
						</table> -->
						<table class="table table-hover table-striped" id="tableLogPhone">
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
				</div>
			</div>
		</div>

		<div class="modal fade in" id="modal-addlog">
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
								<div class="col-md-5">
									<div class="input-group">
										<input type="text" class="form-control" name="date1" id="inputTimeAnswed1">
									</div>
								</div>
								<div class="col-md-4">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control timepicker" name="date2" id="inputTimeAnswed2">
											</div>
										</div>
									</div>
								</div>
							</div>
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

		<div class="modal fade" id="modal-default">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Default Modal</h4>
					</div>
					<div class="modal-body">
						<p>One fine body&hellip;</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
<script src="{{url('plugins/datepicker/bootstrap-datepicker.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#inputTimeAnswed1').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd'
		})

		$(".timepicker").timepicker({
			maxHours: 24,
			minuteStep: 1,
		})

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

		// $("#example1").DataTable()
	})

	function check_log() {
		if($("#modal-addlog").is(':visible') == false){
			$.ajax({
				type:"GET",
				url:"{{url('/logphone/getLastestCall')}}",
				success: function (result){
					// console.log(result)
					// console.log(result.length)
					if(result.length !== 1) {
						// $("#inputTimeAnswed").val(moment(result.history.eventtime,"YYYY-MM-DD HH:mm:ss").format('D MMMM YYYY - HH:mm'))
						$("#inputTimeAnswed1").val(moment(result.history.eventtime,"YYYY-MM-DD HH:mm:ss").format('YYYY-MM-DD'))
						$("#inputTimeAnswed2").val(moment(result.history.eventtime,"YYYY-MM-DD HH:mm:ss").format('hh:mm A'))
						$("#inputIdDetailHistory").val(result.id)
						$("#modal-addlog").modal('show')
						
						// $("#modal-addlog").show()
					}
				}
			})
		}
	}

	function addLog(){
		$("#modal-addlog").modal('show')
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

	// repeatEvery(check_log, 60000);
</script>            
@endsection