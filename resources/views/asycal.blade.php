@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')

@section('head')
<style type="text/css">
	.redEvent{
		background-color: #f56954;
		border-color: #f56954;
	}
	.yellowEvent{
		background-color: #f39c12;
		border-color: #f39c12;
	}
	.blueEvent{
		background-color: #0073b7;
		border-color: #0073b7;
	}
	.infoEvent{
		background-color: #00c0ef;
		border-color: #00c0ef;
	}
	.successEvent{
		background-color: #00a65a;
		border-color: #00a65a;
	}
	.primaryEvent{
		background-color: #3c8dbc;
		border-color: #3c8dbc;
	}
</style>
@endsection

@section('content')

<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<img src="img/asycal.png" width="120" height="40">
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Calendar</li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-md-3">
					<div class="box box-solid">
						<div class="box-header with-border">
							<h4 class="box-title">Draggable Events</h4>
						</div>
						<div class="box-body">
							<!-- the events -->
							<div id="external-events">
								<div class="external-event bg-green">Libur</div>
								<div class="external-event bg-yellow">Metting</div>
								<div class="external-event bg-aqua">Kumpulkan Laporan</div>
								<div class="external-event bg-light-blue">Cuti Bersama</div>
								<div class="external-event bg-red">Tangal Merah</div>
								<div class="external-event bg-black">Teraktir Mas Deny</div>
								<div class="checkbox">
									<label for="drop-remove">
										<input type="checkbox" id="drop-remove">
										remove after drop
									</label>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /. box -->
					<div class="box box-solid">
						<div class="box-header with-border">
							<h3 class="box-title" id="coba">Create Event</h3>
						</div>
						<div class="box-body">
							<div class="btn-group" style="width: 100%; margin-bottom: 10px;">
								<!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
								<ul class="fc-color-picker" id="color-chooser">
									<li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
									<li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
								</ul>
							</div>
							<!-- /btn-group -->
							<div class="input-group">
								<input id="new-event" type="text" class="form-control" placeholder="Event Title">

								<div class="input-group-btn">
									<button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
								</div>
								<!-- /btn-group -->
							</div>
							<!-- /input-group -->
						</div>
					</div>
					<div class="box box-solid bg-red text-center" id="deletePlace">
						<div class="box-body">
							<h1 style="margin-bottom: 20px">
								<i class="fa fa-remove"></i> Drop here for delete!
							</h1>
						</div>
					</div>
				</div>
				<!-- /.col -->
				<div class="col-md-9">
					<div class="box box-primary">
						<div class="box-body no-padding">
							<!-- THE CALENDAR -->
							<div id="calendar"></div>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /. box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	


@endsection

@section('script')


<script type="text/javascript">

	$(function () {

		/* initialize the external events
		 -----------------------------------------------------------------*/
		function ini_events(ele) {
			ele.each(function () {

				// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
				// it doesn't need to have a start or end
				var eventObject = {
					title: $.trim($(this).text()) // use the element's text as the event title
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

		/* initialize the calendar
		 -----------------------------------------------------------------*/
		//Date for the calendar events (dummy data)
		var date = new Date();
		var d = date.getDate(),
			m = date.getMonth(),
			y = date.getFullYear();
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			buttonText: {
				today: 'today',
				month: 'month',
				week: 'week',
				day: 'day'
			},
			//Random default events
			events: '/json',
			editable: true,
			droppable: true, // this allows things to be dropped onto the calendar !!!
			drop: function (date, allDay) { // this function is called when something is dropped

				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');

				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);

				// assign it the date that was reported
				copiedEventObject.start = date;
				console.log(date._d);
				var waktu = date._d;
				waktu = new Date(waktu);
				console.log(waktu.getUTCSeconds());
				console.log(waktu.getUTCMinutes());
				console.log(waktu.getUTCHours());
				console.log(waktu.getUTCDate());
				console.log(waktu.getUTCMonth());
				console.log(waktu.getUTCFullYear());
				
				var kapan = waktu.getUTCFullYear() + "-" + waktu.getUTCMonth()+ "-" + waktu.getUTCDate()+ "T" + waktu.getUTCHours()+ ":" + waktu.getUTCMinutes()+ ":" + waktu.getUTCSeconds() + ".000";
				console.log(kapan);
				console.log(originalEventObject);
				$.ajax({
					type: "GET",
					data:{
						title: originalEventObject.title,
						start: date,
						end: date
					},
					url: "/createAsycal",
					success: function(result){
						console.log(result);
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

		/* ADDING EVENTS */
		var currColor = "#3c8dbc"; //Red by default
		//Color chooser button
		var colorChooser = $("#color-chooser-btn");
		$("#color-chooser > li > a").click(function (e) {
			e.preventDefault();
			//Save color
			currColor = $(this).css("color");
			//Add color effect to button
			$('#add-new-event').css({"background-color": currColor, "border-color": currColor});
		});
		$("#add-new-event").click(function (e) {
			e.preventDefault();
			//Get value and make sure it is not null
			var val = $("#new-event").val();
			if (val.length == 0) {
				return;
			}

			//Create events
			var event = $("<div />");
			event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
			event.html(val);
			$('#external-events').prepend(event);

			//Add draggable funtionality
			ini_events(event);

			//Remove event from text input
			$("#new-event").val("");
		});

		$("#coba").click(function (){
			$('#calendar').fullCalendar('removeEvents');
			console.log("clear");
			
		});


	});
</script>
@endsection
