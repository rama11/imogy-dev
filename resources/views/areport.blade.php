@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')

@section('content')

<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/pace/pace.min.css')}}" >

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
<div class="cover" id="cover">
	<div class="loader"></div>
</div>

<div class="content-wrapper">

	<section class="content-header" >
		<a href="{{url('absen')}}">
			<img src="img/labelaogy.png" width="120" height="40">
		</a>
		<ol class="breadcrumb" style="font-size: 15px;">
			<li><a href="{{url('ahistory')}}"><i class="fa fa-book"></i>My Attendance</a></li>
			<li><a href="{{url('ateamhistory')}}"><i class="fa fa-users"></i>My Team Attendance</a></li>
			<li><a href="{{url('areport')}}"><i class="fa fa-users"></i>Reporting</a></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">	
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">All history attendance</h3>
					</div>
					<div class="box-body">
						<p>This is all off your absent record. Check this history frequenly for futher, thanks</p>
						<div class="input-group col-md-1">
							<button type="button" class="btn btn-default pull-left" id="daterange-btn">
									<i class="fa fa-calendar"></i> Date range picker
								<span>
									<i class="fa fa-caret-down"></i>
								</span>
							</button>
						</div>
						<br>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="display: none;" id="result">
			<div class="col-lg-12 col-xs-12" id="panel_simple2">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title" id="titleResult">Table Information</h3>
						<div class="box-tools pull-right">
							<a href='' target="_blank" type='button' class='btn btn-info' id="downloadPDF">
								<i class='fa fa-download'></i> Download All
							</a>
						</div>
					</div>
					<div class="box-body no-padding">
						<table class="table table-striped" id="tableResult">
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
@section('script')
<script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ asset('AdminLTE/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('AdminLTE/plugins/pace/pace.min.js')}}"></script>
<script>
	$(function () {

		var startDonwload;
		var endDonwload;
		var startDate
		var endDate;

		// $(document).ajaxStart(function() { Pace.restart(); });

		$('#reservation').daterangepicker();
		$('#reservationtime').daterangepicker(
			{	timePicker: true, 
				timePickerIncrement: 30,
				format: 'MM/DD/YYYY h:mm A'
			});
		$('#daterange-btn').daterangepicker(
			{
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				startDate: moment().subtract(29, 'days'),
				endDate: moment()
			},
			function (start, end) {
				$('#daterange-btn span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
				var query = "SELECT * FROM `waktu_absen` WHERE `tanggal` >= '" + start.format('YYYY-MM-DD') + "' AND `tanggal` <= '" + end.format('YYYY-MM-DD') + "'";

				var startDay = start.format('YYYY-MM-DD');
				var endDay = end.format('YYYY-MM-DD');

				startDonwload = startDay;
				endDonwload = endDay;

				startDate = start.format('D MMMM YYYY');
				endDate = end.format('D MMMM YYYY');

				// console.log(query);
				$("#tableResult").empty();

				Pace.restart();
				Pace.track(function(){
					$.ajax({
						type: "GET",
						url: "getReport",
						data: {
							'start' : startDay,
							'end' : endDay,
						},
						success: function(result){
							$("#downloadPDF").attr("href",'getReport?end=' + result['end'] + '&endDate=' + result['endDate'] + '&start=' + result['start'] + '&startDate=' + result['startDate'] + '&pdf=' + result['pdf']);
							$("#result").fadeIn();
							$("#titleResult").text("Table Information for " + startDate + " to " + endDate);
							
							append = "";
							append = append + "<thead>";
							append = append + "	<tr>";
							append = append + "		<th style='width: 7px;'>#</th>";
							append = append + "		<th>Name</th><th>Location</th>";
							append = append + "		<th style='width: 70px;' class='text-center'>On Time</th>";
							append = append + "		<th style='width: 50px;' class='text-center'>Injury</th>";
							append = append + "		<th style='width: 50px;' class='text-center'>Late</th>";
							append = append + "		<th style='width: 50px;' class='text-center'>Absent</th>";
							append = append + "		<th style='width: 50px;' class='text-center'>All</th>";
							append = append + "		<th style='width: 50px;' class='text-center'>Action</th>";
							append = append + "	</tr>";
							append = append + "</thead>";
							$("#tableResult").append(append);

							var no = 0;
							link = 'getReportPerUser?end=' + result['end'] + '&endDate=' + result['endDate'] + '&pdf=' + result['pdf'] + '&start=' + result['start'] + '&startDate=' + result['startDate'];
							$("#tableResult").append("<tbody>");
							n = 0;
							for(var key in result){
								n++;
							}
							append = "";
							for(var key in result){
								no = no + 1;
								if(no < n - 4){
									append = append + "<tr>";
									append = append + "	<td>" + no + ".</td>";
									append = append + "	<td>" + key + "</td>";
									append = append + "	<td>" + result[key].where + "</td>";
									append = append + "	<td class='text-center'>";
									append = append + "		<span class='badge bg-green'>" + result[key].ontime + "</span>";
									append = append + "	</td>";
									append = append + "	<td class='text-center'>";
									append = append + "		<span class='badge bg-yellow'>" + result[key].injury + "</span>";
									append = append + "	</td>";
									append = append + "	<td class='text-center'>";
									append = append + "		<span class='badge bg-red'>" + result[key].late + "</span>";
									append = append + "	</td>";
									append = append + "	<td class='text-center'>";
									append = append + "		<span class='badge bg-default'>" + result[key].absen + "</span>";
									append = append + "	</td>";
									append = append + "	<td class='text-center'>";
									append = append + "		<span class='badge bg-blue'>" + result[key].all + "</span>";
									append = append + "	</td>";
									append = append + "	<td class='text-center'>";
									append = append + "		<a href='" + link + "&id_user=" + result[key].id + "' target='_blank' type='button' class='btn btn-info btn-xs'>";
									append = append + "			<i class='fa fa-download'></i> Download";
									append = append + "		</a>";
									append = append + "	</td>";
									append = append + "</tr>";
								}
							}
							$("#tableResult").append(append);
							$("#tableResult").append("</tbody>");
						},
					});
				});

			}
		);
	});
</script>

@endsection