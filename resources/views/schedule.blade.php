@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.5/fullcalendar.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.5/fullcalendar.print.css" media="print">
@endsection
@section('content')
<style>
	.loader {
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid #3498db;
		width: 120px;
		height: 120px;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
		margin: auto;
		position: absolute;
		top:0;
		bottom: 0;
		left: 0;
		right: 0;
	}

	.pagi, .Pagi {
		background-color: #dd4b39 !important;
		border-color: #dd4b39 !important;
		color: #fff !important;
	}

	.Helpdesk {
		background-color: #ca195a !important;
		border-color: #ca195a !important;
		color: #fff !important;
	}

	.sore, .Sore {
		background-color: #f39c12 !important;
		border-color: #f39c12 !important;
		color: #fff !important;
	}

	.malam, .Malam {
		background-color: #0073b7 !important;
		border-color: #0073b7 !important;
		color: #fff !important;
	}

	.libur, .Libur {
		background-color: #00a65a !important;
		border-color: #00a65a !important;
		color: #fff !important;
	}

	@-webkit-keyframes spin {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}

	.cover {
		position: fixed;
		top: 0;
		left: 0;
		background: rgba(0,0,0,0.6);
		z-index: 5000;
		width: 100%;
		height: 100%;
		display: none;
	}

	.fc-time{
	   display : none;
	}

	td.fc-day.fc-past {
		background-color: #EEEEEE;
	}
	td.fc-day.fc-today {
		background-color: #ffeaa7;
	}
</style>

<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Shifting Schedule
		</h1>
		<a href="#" class="pull-right btn-box-tool text-red pull-left" data-toggle="modal" data-target="#modal-addusershifting"><i class="fa fa-plus"></i> Modify User Shifting</a>					
		<ol class="breadcrumb">
			<li><a href="{{url('admin')}}"><i class="fa fa-dashb oard"></i> Home</a></li>
			<li class="active">Shifting Schedule</li>
		</ol>
		<br>
	</section>

	<section class="content">
		<div class="row">
			<section class="col-lg-3 col-xs-3" id="panel_simple">
				
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title" id="indicatorMonth">Shifting Users on {{date('F')}}</h3>
					</div>
					<div class="box-body no-padding" id="listProject">
						<ul class="nav nav-stacked">
							@foreach($projects as $project)
								<li>
									<a href="#" onclick="showProject('{{$project->project}}','{{$project->id}}')">{{$project->project}}</a>
								</li>
							@endforeach
						</ul>
					</div>
					<div class="box-body" id="listName" style="display: none;">
						<p id="name"></p>
						<ul class="nav nav-stacked" id="ulUser"></ul>
						<br>
						<button class="btn btn-default" id="buttonBack">Back</button>
					</div>

					<div class="box-body" id="external" style="display: none;">
						<p id="name"></p>
						<div id="external-events">
							<p id="name2"></p>
							<input type="hidden" id="nickname">
							<br>
							<div style="display: none;" class="external-event bg-red project-1">Pagi <span class="pull-right">07:00 - 15:00</span></div>
							<div style="display: none;" class="external-event bg-red project-2">Pagi <span class="pull-right">07:00 - 15:30</span></div>
							<div style="display: none;" class="external-event bg-red project-3">Pagi <span class="pull-right">07:00 - 14:00</span></div>
							<div style="display: none;" class="external-event bg-maroon-active project-3">Pagi(Helpdesk)<span class="pull-right">08:00 - 17:00</span></div>
							<div style="display: none;" class="external-event bg-yellow project-1">Sore <span class="pull-right">14:00 - 22:00</span></div>
							<div style="display: none;" class="external-event bg-yellow project-2">Sore <span class="pull-right">14:00 - 22:30</span></div>
							<div style="display: none;" class="external-event bg-yellow project-3">Sore <span class="pull-right">14:00 - 21:00</span></div>
							<div style="display: none;" class="external-event bg-blue project-1">Malam <span class="pull-right">22:00 - 07:00</span></div>
							<div style="display: none;" class="external-event bg-green project-1 project-3 	project-2">Libur </div>
							<br>
							<button class="btn btn-default" id="buttonBack2">
								Back
							</button>
						</div>
					</div>
				</div>
				<div class="box box-danger box-solid" id="deletePlace" style="display: none;">
					<div class="box-header">
						<div class="box-title">
							Drop here to delete
						</div>
					</div>
				</div>
			</section>

			<section class="col-lg-9 col-xs-9" id="panel_simple2">
				
				<div class="box box-default">
					<div class="box-body no-padding">
						<div id="calendar"></div>
					</div>
				</div>	
			</section>			
		</div>	
	</section>	
</div>

<div class="modal fade" id="modal-addusershifting" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Modify User Shifting</h4>
			</div>
			<form method="POST" action="{{url('addUserShifting')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Users Name</label>
									<select class="form-control" name="id_user">
										@foreach($nameUsers as $nameUser)
											<option value="{{$nameUser->id}}">{{$nameUser->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Project Name</label>
										<select class="form-control" name="on_project" >
										@foreach($projects as $project)
											<option value="{{$project->id}}">{{$project->project}}</option>
										@endforeach
										</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>						
						<button type="submit" class="btn btn-primary">Modify user</button>
					</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>

<script type="text/javascript">
	var globalIdUser = 0;
	var globalProject = 0;
	function ini_events(ele) {
		ele.each(function () {
			var str = $(this).text();
			if(str.indexOf("(") > 0){
				var shift = "Helpdesk";
			} else {
				var shift = str.substr(0,str.indexOf(" "));
			}
			var strip = str.indexOf("-");
			var start1 = strip - 6;
			var end1 = strip + 2;
			var start = str.substr(start1,5);
			var end = str.substr(end1,5);
			
			var eventObject = {
				title: $.trim($(this).text()), 
				startShift: start,
				endShift: end,
				Shift: shift,
			};

			$(this).data('eventObject', eventObject);

			$(this).draggable({
				zIndex: 1070,
				revert: true, 
				revertDuration: 0 
			});

		});
	}

	ini_events($('#external-events div.external-event'));

	function showProject(name,idProject){
		$("#listProject").fadeOut(function (){
			$("#listName").fadeIn();
			$("#name").text("for " + name);
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', "{{url('schedule/getThisProject')}}?project=" + idProject + "&month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			$("." + idProject).show();
			globalProject = idProject;
			$("#buttonBack").attr("onclick","backListProject(" + idProject + ")");
		});
	};

	function showDetail(name,nickname,idUser,idProject){
		$("#listName").fadeOut(function (){
			
			var external2 = ".project-" + idProject;
			$("#external").fadeIn(function(){
				$(external2).show();
			});

			$("#name2").text("for " + name);
			$("#nickname").val(nickname);
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', '{{url("schedule/getThisUser")}}?idUser=' + idUser + '&idProject=' + globalProject + "&month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			globalIdUser = idUser;
			$("." + idProject).show();
			$("#buttonBack2").attr("onclick","backListDetail(" + idProject + ")")
			$("#deletePlace").show();
			$("#calendar").fullCalendar('option', {
				editable: true,
				droppable: true,
			});
		});
	}

	function backListDetail(idProject){
		$("#external").fadeOut(function (){
			$(".project-" + idProject).fadeOut();
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', "{{url('schedule/getThisProject')}}?month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			$("#buttonBack").attr("onclick","backListProject(" + idProject + ")");
			globalIdUser = 0;
			$("#listName").fadeIn();
			$("#deletePlace").hide();
			$("#calendar").fullCalendar('option', {
				editable: false,
				droppable: false,
			});
		});
	}

	function backListProject(idProject){
		$("#listName").fadeOut(function (){
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', "{{url('schedule/getThisMonth')}}?month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			$("." + idProject).hide();
			$("#listProject").fadeIn();
		});
	}

	$(".fc-next-button").click(function(){
	});

	var shift_user = [], shift_time = [], shift_date = [];
	var i = 0;
	$('#calendar').fullCalendar({
		header: {
			left: '',
			center: 'title',
		},
		
		editable: false,
		droppable: false,
		events: "{{url('schedule/getThisMonth')}}?month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'),
			
		drop: function (date, allDay) { 

			var originalEventObject = $(this).data('eventObject');
			var name3 = $("#nickname").val();
			console.log(name3)
			var copiedEventObject = $.extend({}, originalEventObject);

			copiedEventObject.start = date;
			var waktu = date._d;
			waktu = new Date(waktu);

			var day = moment(waktu).toISOString(true);
			var startShift2 = moment(waktu).format('YYYY-MM-DD') + "T" + originalEventObject.startShift + ":00.000Z";
			var endShift2 = moment(waktu).format('YYYY-MM-DD') + "T" + originalEventObject.endShift + ":00.000Z";
			
			var ketemu = 0;

			$.ajax({
				type:"GET",
				dataType:"json",
				url:"{{url('schedule/getThisMonth')}}?month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'),
				success: function(result2){
					for (var i = 0; i < result2.length; i++) {
						if (startShift2 == result2[i].start) {
							var str = result2[i].title;
							var str2 = result2[i].start;
							var shift = str.substr(0,str.indexOf(" "));
							
							if(shift == originalEventObject.Shift){
								if(name3.substr(1,name3.length - 1) == str.substr(str.indexOf(" ") + 3, str.length)){
									ketemu = 1;
								}
							} 
						}
					};

					if(ketemu == 1){
						alert("tanggal sama");
					} else {
						var idEvent = 0;

						$.ajax({
							type: "GET",
							url: "{{url('schedule/crateSchedule')}}",
							data:{
								title: originalEventObject.Shift +" - " +  name3,
								name:name3,
								start: startShift2,
								end: endShift2,
								shift: originalEventObject.Shift,
								id_project: globalProject

							},
							success: function(result){
								idEvent = result;
								copiedEventObject.id = idEvent;
								refresh_calendar();
							},
						});
					}
				},
			});
		},

		eventDrop: function(event, delta, revertFunc) {
			alert(event.title + " can't move!");
			revertFunc();
		},

		eventDragStop: function(event,jsEvent) {
			var trashEl = $('#deletePlace');
			var ofs = trashEl.offset();

			var x1 = ofs.left;
			var x2 = ofs.left + trashEl.outerWidth(true);
			var y1 = ofs.top;
			var y2 = ofs.top + trashEl.outerHeight(true);

			if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
				jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
				if (confirm("Are you sure to delete this events?")) {
					$.ajax({
						type: "GET",
						url: "{{url('schedule/deleteSchedule')}}",
						data:{
							id:event.id
						},
						success: function(result){
							$('#calendar').fullCalendar('removeEvents', event.id);
						},
					});
				}
			}
		},

		viewRender: function (view, element) {
			$("#indicatorMonth").text("Shifting Users on " + moment(view.intervalStart).format("MMMM"));
			
			$.ajax({
				type: "GET",
				url: "{{url('schedule/changeMonth')}}",
				data: {
					start:moment(view.intervalStart).format("YYYY-MM")
				},
				beforeSend:function(){
					$("#calendar").fullCalendar('removeEventSources');
				},
				success: function(result){
					$("#ulUser").empty();
					var append = "";
					for (var i = 0; i < result.length; i++) {
						var showDetail = "showDetail('" + result[i].name + "','" + result[i].nickname + "','" +result[i].id + "','" + result[i].on_project + "')";
						append = append + '	<li class="' + result[i].on_project + '" style="display:none;padding-bottom:10px">';
						append = append + '		<a onclick="' + showDetail + '">' + result[i].name;
						append = append + '			<br>';
						append = append + '			<small class="label label-success pull-right" style="margin-right: 5px;">' + result[i].shift_libur + ' </small>';
						append = append + '			<small class="label label-primary pull-right" style="margin-right: 5px;">' + result[i].shift_malam + ' </small>';
						append = append + '			<small class="label label-warning pull-right" style="margin-right: 5px;">' + result[i].shift_sore + ' </small>';
						append = append + '			<small class="label label-danger pull-right" style="margin-right: 5px;">' + result[i].shift_pagi + ' </small>';
						append = append + '		</a>';
						append = append + '	</li>';
					};
					$("#ulUser").append(append);
					$("." + globalProject).show();
				},
			});
			if($("#listProject").is(":visible")){
				$("#calendar").fullCalendar('addEventSource', '{{url("schedule/getThisMonth")}}?&month=' + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			}
			if($("#listName").is(":visible")){
				$("#calendar").fullCalendar('addEventSource', '{{url("schedule/getThisProject")}}?project=' + globalProject + '&month=' + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			} else {
				$("#calendar").fullCalendar('addEventSource', '{{url("schedule/getThisUser")}}?idUser=' + globalIdUser +'&idProject=' + globalProject + "&month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			}
		}
	});


	function refresh_calendar(){
		$("#calendar").fullCalendar('removeEventSources');
		$("#calendar").fullCalendar('addEventSource', '{{url("schedule/getThisUser")}}?idUser=' + globalIdUser +'&idProject=' + globalProject + "&month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
	}
</script>
@endsection