@extends((Auth::user()->role == "1") ? 'layouts.admin.layout ' : 'layouts.engineer.elayout')
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
		background-color: #dd4b39 !important; /* background color */
		border-color: #dd4b39 !important;     /* border color */
		color: #fff !important;;              /* text color */
	}

	.Helpdesk {
		background-color: #ca195a !important; /* background color */
		border-color: #ca195a !important;     /* border color */
		color: #fff !important;;              /* text color */
	}

	.sore, .Sore {
		background-color: #f39c12 !important; /* background color */
		border-color: #f39c12 !important;     /* border color */
		color: #fff !important;;              /* text color */
	}

	.malam, .Malam {
		background-color: #0073b7 !important; /* background color */
		border-color: #0073b7 !important;     /* border color */
		color: #fff !important;;              /* text color */
	}

	.libur, .Libur {
		background-color: #00a65a !important; /* background color */
		border-color: #00a65a !important;     /* border color */
		color: #fff !important;;              /* text color */
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
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Shifting Schedule
		</h1>
		<a href="#" class="pull-right btn-box-tool text-green pull-left" data-toggle="modal" data-target="#modal-addusershifting"><i class="fa fa-plus"></i> Add User Shifting</a>			
		<ol class="breadcrumb">
			<li><a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Shifting Schedule</li>
		</ol>
		<br>
	</section>

	<section class="content">
		<div class="row">
			<!-- Panel Kiri -->
			<section class="col-lg-3 col-xs-3" id="panel_simple">
				
				<!-- Box For Chart -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title" id="indicatorMounth">Shifting Users on {{date('F')}}</h3>
					</div>
					<!-- /.box-header -->
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
							<br>
							<div style="display: none;" class="external-event bg-red project-1">Pagi <span class="pull-right">07:00 - 15:00</span></div>
							<div style="display: none;" class="external-event bg-red project-2">Pagi <span class="pull-right">07:00 - 15:30</span></div>
							<div style="display: none;" class="external-event bg-red project-3">Pagi <span class="pull-right">07:00 - 14:00</span></div>
							<div style="display: none;" class="external-event bg-maroon-active project-3">Pagi(Helpdesk)<span class="pull-right">08:00 - 17:00</span></div>
							<div style="display: none;" class="external-event bg-yellow project-1">Sore <span class="pull-right">14:00 - 22:00</span></div>
							<div style="display: none;" class="external-event bg-yellow project-2">Sore <span class="pull-right">14:00 - 22:30</span></div>
							<div style="display: none;" class="external-event bg-yellow project-3">Sore <span class="pull-right">14:00 - 21:00</span></div>
							<div style="display: none;" class="external-event bg-blue project-1">Malam <span class="pull-right">22:00 - 07:00</span></div>
							<div style="display: none;" class="external-event bg-green project-1 project-3 	project-2">Libur</div>
							<br>
							<button class="btn btn-default" id="buttonBack2">
								Back
							</button>
						</div>
					</div>
				</div>
				<!-- @if(session('message'))
				<div class="alert alert-success alert-dismissible" style="margin-top: 330px;margin-right: 0px; position:fixed; top:0; left:260px; width:200px;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Success!</h4>
						{{session('message')}}
				</div>
				@endif -->

				<div class="box box-danger box-solid" id="deletePlace" style="display: none;">
					<div class="box-header">
						<div class="box-title">
							Drop here to delete
						</div>
					</div>
				</div>
			</section>

			<!-- Panel Kanan -->
			<section class="col-lg-9 col-xs-9" id="panel_simple2">
				
				<!-- Box For Information -->
				<div class="box box-default">
					<div class="box-body no-padding">
						<!-- THE CALENDAR -->
						<div id="calendar"></div>
					</div>
					
					<!-- /.box-body -->
				</div>
			</section>			
		</div>
		
	</section>

	<div class="modal fade in" id="modal-addusershifting"  tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Add User Shifting</h4>
				</div>
				<form method="POST" action="{{url('addUserShifting')}}" enctype="multipart/form-data">
					{!! csrf_field() !!}
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Nama Users</label>
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
							<button type="submit" class="btn btn-primary">Add user</button>
						</div>
				</form>
			</div>
		</div>
	</div>

</div>
@endsection
@section('script')
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
			// // console.log(start);
			// // console.log(end);
			if(shift == "")
				shift = "Libur";
			// // console.log(shift);
			var eventObject = {
				title: $.trim($(this).text()), // use the element's text as the event title
				startShift: start,
				endShift: end,
				Shift: shift,

			};

			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 1070,
				revert: true, // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});
	}

	ini_events($('#external-events div.external-event'));


	function showProject(name,idProject){
		$("#listProject").fadeOut(function (){
			// console.log(idProject);
			$("#listName").fadeIn();
			$("#name").text("for " + name);
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', '/getScheduleProject/' + idProject);
			$("." + idProject).show();
			globalProject = idProject;
			$("#buttonBack").attr("onclick","backListProject(" + idProject + ")");
		});
	};

	function showDetail(name,idUser,idProject){
		$("#listName").fadeOut(function (){
			// console.log(idUser);
			
			var external2 = ".project-" + idProject;
			// console.log(external2);
			$("#external").fadeIn(function(){
				$(external2).show();
			});
			

			$("#name2").text("for " + name);
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', '/getScheduleSelected?idUser=' + idUser + '&idProject=' + globalProject);
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
			// $("." + idProject).hide();
			$(".project-" + idProject).fadeOut();
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', '/getScheduleProject/' + idProject);
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
			$("#calendar").fullCalendar('addEventSource', '/getScheduleAll');
			$("." + idProject).hide();
			$("#listProject").fadeIn();
		});
	}

	$(".fc-next-button").click(function(){
		// console.log("asdfadf");
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
		//Random default events
		events: '/getScheduleAll',
			
		 // this allows things to be dropped onto the calendar !!!
		drop: function (date, allDay) { // this function is called when something is dropped

			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			var name3 = $("#name2").text();
			// name3.length;
			// console.log(name3);
			if(name3.indexOf(" ",name3.indexOf(" ") + 1) > 0){
				name3 = name3.substr(name3.indexOf(" ") + 1,name3.length - name3.indexOf(" "));
				name3 = name3.substr(name3.indexOf(" ")	,name3.length - name3.indexOf(" "));
			} else {
				name3 = " " + name3.substr(name3.indexOf(" ") + 1,name3.length - name3.indexOf(" "));
			}
			// console.log(name3);
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);

			// assign it the date that was reported
			copiedEventObject.start = date;
			// // console.log(date._d);
			var waktu = date._d;
			waktu = new Date(waktu);

			var day = moment(waktu).toISOString(true);
			// // console.log(waktu.getUTCSeconds());
			// // console.log(waktu.getUTCMinutes());
			// // console.log(waktu.getUTCHours());
			// // console.log(waktu.getUTCDate());
			// // console.log(waktu.getUTCMonth());
			// // console.log(waktu.getUTCFullYear());
			
			// var kapan = waktu.getUTCFullYear() + "-" + waktu.getUTCMonth()+ "-" + waktu.getUTCDate()+ "T" + waktu.getUTCHours()+ ":" + waktu.getUTCMinutes()+ ":" + waktu.getUTCSeconds() + ".000";
			// // console.log("Start : " + originalEventObject.startShift);
			// // console.log("End : " + originalEventObject.endShift);
			// // console.log("Original : " + day);

			// // console.log("Mix : " + );
			// // console.log(originalEventObject);

			var startShift2 = moment(waktu).format('YYYY-MM-DD') + "T" + originalEventObject.startShift + ":00.000Z";
			var endShift2 = moment(waktu).format('YYYY-MM-DD') + "T" + originalEventObject.endShift + ":00.000Z";
			
			var ketemu = 0;

			$.ajax({
				type:"GET",
				dataType:"json",
				url:"/getScheduleAll",
				success: function(result2){
					// // console.log(result[0].start);
					for (var i = 0; i < result2.length; i++) {
						if (startShift2 == result2[i].start) {
								// // console.log("ada yang sama");
							var str = result2[i].title;
							var str2 = result2[i].start;
							var shift = str.substr(0,str.indexOf(" "));
							// // console.log(result2[i].title);
							// // console.log(str2);
							
							// // console.log(shift);
							// console.log(originalEventObject.Shift);
							// console.log(str.substr(str.indexOf(" ") + 3, str.length));
							if(shift == originalEventObject.Shift){
								// console.log("Bener '" + shift + "' '" + originalEventObject.Shift + "'");
								// console.log("Bener2 '" + name3.substr(1,name3.length - 1) + "' '" + str.substr(str.indexOf(" ") + 3, str.length) + "'");
								if(name3.substr(1,name3.length - 1) == str.substr(str.indexOf(" ") + 3, str.length)){
									ketemu = 1;
								}
							} 
						}
					};
						// console.log(ketemu);

					if(ketemu == 1){
						alert("tanggal sama");
						// console.log("ketemu");
					} else {
						var idEvent = 0;
						// console.log("bener");

						$.ajax({
							type: "GET",
							url: "/crateSchedule",
							data:{
								title: originalEventObject.Shift +" - " +  name3,
								name:name3,
								start: startShift2,
								end: endShift2,
								shift: originalEventObject.Shift,
								id_project: globalProject

							},
							success: function(result){
								// console.log(result);
								idEvent = result;
								// console.log(idEvent + "asdfasd");
								copiedEventObject.id = idEvent;
								// console.log(copiedEventObject.id);
								refresh_calendar();
							},
						});

						// console.log(idEvent);
						// // console.log(idEvent);
						// // console.log(idEvent);
						// // console.log(idEvent);
						// // console.log(idEvent);


						// render the event on the calendar
						// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
						// $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
					}
				},
			});
			// copiedEventObject.id = 12312;
			// copiedEventObject.allDay = allDay;
			// copiedEventObject.backgroundColor = $(this).css("background-color");
			// copiedEventObject.borderColor = $(this).css("background-color");

			
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
					// console.log(event.id);
					$.ajax({
						type: "GET",
						url: "/deleteSchedule/" + event.id,
						success: function(result){
							$('#calendar').fullCalendar('removeEvents', event.id);
						},
					});
				}
			}
		},

		viewRender: function (view, element) {
			$("#indicatorMounth").text("Shifting Users on " + moment(view.intervalStart).format("MMMM"));
			// console.log( moment(view.intervalStart).format("YYYY-MM"));
			$.ajax({
				type: "GET",
				url: "changeMonth",
				data: {
					start:moment(view.intervalStart).format("YYYY-MM")
				},
				success: function(result){
					$("#ulUser").empty();
					var append = "";
					for (var i = 0; i < result.length; i++) {
					// for (var i = 0; i < 1; i++) {
						// // console.log(result[i].name);
						var showDetail = "showDetail('" + result[i].name + "','" + result[i].id + "','" + result[i].on_project + "')";
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
					// console.log("change");
				},
			});
		}
	});


	function refresh_calendar(){
		$("#calendar").fullCalendar('removeEventSources');
		$("#calendar").fullCalendar('addEventSource', '/getScheduleSelected?idUser=' + globalIdUser +'&idProject=' + globalProject);
	}
</script>
@endsection