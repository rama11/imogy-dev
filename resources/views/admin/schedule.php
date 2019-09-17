@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')
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
</style>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Shifting Schedule
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Shifting Schedule</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">

			<!-- Panel Kiri -->
			<section class="col-lg-4 col-xs-6" id="panel_simple">
				
				<!-- Box For Chart -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Shifting Users on {{date('F')}}</h3>
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
						<ul class="nav nav-stacked">
							@foreach($users as $user)
								<li class="{{$user->on_project}}" style="display: none;">
									<a href="#" onclick="showDetail('{{$user->name}}','{{$user->id}}','{{$user->on_project}}')">{{$user->name}}
										<small class="label label-success pull-right" style="margin-right: 5px;">{{$user->shift_1}}</small>
										<small class="label label-primary pull-right" style="margin-right: 5px;">{{$user->shift_2}}</small>
										<small class="label label-warning pull-right" style="margin-right: 5px;">{{$user->shift_3}}</small>
										<small class="label label-danger pull-right"  style="margin-right: 5px;">{{$user->shift_0}}</small>
									</a>
								</li>
							@endforeach
						</ul>
						<br>
						<button class="btn btn-default" id="buttonBack">
							Back
						</button>
					</div>

					<div class="box-body" id="external" style="display: none;">
						<p id="name"></p>
						<div id="external-events">
							<p id="name2"></p>
							<div class="external-event bg-red">Pagi <span class="pull-right">07:00 - 15:00</span></div>
							<div class="external-event bg-yellow">Sore <span class="pull-right">14:00 - 22:00</span></div>
							<div class="external-event bg-blue">Malam <span class="pull-right">22:00 - 07:00</span></div>
							<div class="external-event bg-green">Libur</div>
							<br>
							<button class="btn btn-default" id="buttonBack2">
								Back
							</button>
							<button class="btn btn-primary pull-right" onclick="saveSchedule()">
								Save
							</button>
						</div>
					</div>
				</div>
			</section>

			<!-- Panel Kanan -->
			<section class="col-lg-8 col-xs-6" id="panel_simple2">
				
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
</section>
@endsection
@section('script')
<script type="text/javascript">
	function ini_events(ele) {
		ele.each(function () {

			var str = $(this).text();
			var shift = str.substr(0,str.indexOf(" "));
			// console.log(shift);
			var strip = str.indexOf("-");
			var start1 = strip - 6;
			var end1 = strip + 2;
			var start = str.substr(start1,5);
			var end = str.substr(end1,5);
			// console.log(start);
			// console.log(end);
			if(shift == "")
				shift = "Libur";
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
			console.log(idProject);
			$("#listName").fadeIn();
			$("#name").text("for " + name);
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', '/getScheduleProject/' + idProject);
			$("." + idProject).show();
			$("#buttonBack").attr("onclick","backListProject(" + idProject + ")");
		});
	};

	function showDetail(name,idUser,idProject){
		$("#listName").fadeOut(function (){
			console.log(idUser);
			$("#external").fadeIn();
			$("#name2").text("for " + name);
			// $("#calendar").fullCalendar('removeEventSource', '/getSchedule');
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', '/getScheduleSelected/' + idUser);
			$("." + idProject).show();
			$("#buttonBack2").attr("onclick","backListDetail(" + idProject + ")")
		});
	}

	function backListDetail(idProject){
		$("#external").fadeOut(function (){
			// $("." + idProject).hide();
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', '/getScheduleProject/' + idProject);
			$("#buttonBack").attr("onclick","backListProject(" + idProject + ")");
			$("#listName").fadeIn();
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


	var shift_user = [], shift_time = [], shift_date = [];
	var i = 0;
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next',
			center: 'title',
		},
		
		//Random default events
		events: '/getScheduleAll',
		editable: true,
		droppable: true, // this allows things to be dropped onto the calendar !!!
		drop: function (date, allDay) { // this function is called when something is dropped

			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			var name3 = $("#name2").text();
			// name3.length;
			console.log(name3);
			if(name3.indexOf(" ",name3.indexOf(" ") + 1) > 0){
				name3 = name3.substr(name3.indexOf(" ") + 1,name3.length - name3.indexOf(" "));
				name3 = name3.substr(name3.indexOf(" ")	,name3.length - name3.indexOf(" "));
			} else {
				name3 = " " + name3.substr(name3.indexOf(" ") + 1,name3.length - name3.indexOf(" "));
			}
			console.log(name3);
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);

			// assign it the date that was reported
			copiedEventObject.start = date
;
			// console.log(date._d);
			var waktu = date._d;
			waktu = new Date(waktu);

			var day = moment(waktu).toISOString(true);
			// console.log(waktu.getUTCSeconds());
			// console.log(waktu.getUTCMinutes());
			// console.log(waktu.getUTCHours());
			// console.log(waktu.getUTCDate());
			// console.log(waktu.getUTCMonth());
			// console.log(waktu.getUTCFullYear());
			
			// var kapan = waktu.getUTCFullYear() + "-" + waktu.getUTCMonth()+ "-" + waktu.getUTCDate()+ "T" + waktu.getUTCHours()+ ":" + waktu.getUTCMinutes()+ ":" + waktu.getUTCSeconds() + ".000";
			// console.log("Start : " + originalEventObject.startShift);
			// console.log("End : " + originalEventObject.endShift);
			// console.log("Original : " + day);

			// console.log("Mix : " + );
			// console.log(originalEventObject);

			var startShift2 = moment(waktu).format('YYYY-MM-DD') + "T" + originalEventObject.startShift + ":00.000Z";
			var endShift2 = moment(waktu).format('YYYY-MM-DD') + "T" + originalEventObject.endShift + ":00.000Z";
			
			$.ajax({
				type: "GET",
				url: "/crateSchedule",
				data:{
					title: originalEventObject.Shift + " -" +  name3,
					name:name3,
					start: startShift2,
					end: endShift2,
					shift: originalEventObject.Shift,
				},
				success: function(result){
					// console.log(result);
				},
			});

			copiedEventObject.allDay = allDay;
			copiedEventObject.backgroundColor = $(this).css("background-color");
			copiedEventObject.borderColor = $(this).css("border-color");
			copiedEventObject.id = Math.floor(Math.random() * 9) + 1;  

			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}

		},
		eventDrop: function(event, delta, revertFunc) {

			alert(event.title + " was dropped on " + event.start.format());

			if (!confirm("Are you sure about this change?")) {
				revertFunc();
			}

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
					$('#calendar').fullCalendar('removeEvents', event.id);
				}
			}
		}
	});
</script>
@endsection