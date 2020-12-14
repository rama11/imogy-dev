@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('head')

		<!-- Start of head section -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

		<link rel="stylesheet" href="{{ url('css/jquery.emailinput.min.css') }}">
		<link rel="stylesheet" href="{{ url('plugins/timepicker/bootstrap-timepicker.min.css')}}">
		<link rel="stylesheet" href="{{ url('plugins/datepicker/datepicker3.css')}}">
		<link rel="stylesheet" href="{{ url('plugins/datatables/dataTables.bootstrap.css')}}">

		<!-- End of head section -->
@endsection
@section('content')
<!-- Start of content section -->
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<img src="{{url('img/tisygy.png')}}" width="120" height="35">
			<small >Ticketing System Sinergy</small>
		</h1>
	</section>

	<section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" id="myTab">
				<li class="active">
					<a href="#tab_1" data-toggle="tab">Per Open</a>
				</li>
				<li>
					<a href="#tab_2" data-toggle="tab">Per Close</a>
				</li>
				<li>
					<a href="#tab_3" data-toggle="tab">Respond Time</a>
				</li>
				<li>
					<a href="#tab_4" data-toggle="tab">SLA</a>
				</li>
				<li>
					<a href="#tab_5" data-toggle="tab">Handle Case</a>
				</li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">	
					<h1>Per Open</h1>
					<canvas id="chart-area"></canvas>
				</div>
				<div class="tab-pane " id="tab_2">
					<h1>Per Close</h1>
				</div>
				<div class="tab-pane " id="tab_3">
					<h1>Respond Time</h1>
				</div>
				<div class="tab-pane " id="tab_4">
					<h1>SLA</h1>
				</div>
				<div class="tab-pane " id="tab_5">
					<h1>Handle Case</h1>
				</div>
			</div>
		</div>
	</section>
</div>
<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Version</b> XXX
	</div>
	<strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
	reserved.
</footer>
<!-- End of content section -->
@endsection 
@section('script')
<!-- Start of script section -->
<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
<script type="text/javascript">
	var randomScalingFactor = function() {
		return Math.round(Math.random() * 100);
	};

	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: [
					10,
					10,
				],
				backgroundColor: [
					window.chartColors.red,
					window.chartColors.orange,
					// window.chartColors.yellow,
					// window.chartColors.green,
				],
				label: 'Dataset 1'
			},{
				data: [
					6,2,1,1,
					3,3,2,2
					// randomScalingFactor(),
					// randomScalingFactor(),
					// randomScalingFactor(),
					// randomScalingFactor(),
				],
				backgroundColor: [
					window.chartColors.red,
					window.chartColors.orange,
					window.chartColors.yellow,
					window.chartColors.green,

					window.chartColors.red,
					window.chartColors.orange,
					window.chartColors.yellow,
					window.chartColors.green,
				],
				label: 'Dataset 2'
			}],
			labels: [
				'OPEN',
				'PENDING',
				// 'CANCEL',
				// 'CLOSE',
			]
		},
		options: {
			responsive: true,
			legend: {
				position: 'top',
			},
			title: {
				display: true,
				text: 'Chart.js Doughnut Chart'
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			circumference: Math.PI,
			rotation: -Math.PI,
		}
	};

	window.onload = function() {
		var ctx = document.getElementById('chart-area').getContext('2d');
		window.myDoughnut = new Chart(ctx, config);
		// window.myDoughnut.options.circumference = Math.PI;
		// window.myDoughnut.options.rotation = -Math.PI;

		// window.myDoughnut.update();
	};

	function addDataset(){
		var colorNames = Object.keys(window.chartColors);
		var newDataset = {
			backgroundColor: [],
			data: [],
			label: 'New dataset ' + config.data.datasets.length,
		};

		for (var index = 0; index < config.data.labels.length; ++index) {
			newDataset.data.push(randomScalingFactor());

			var colorName = colorNames[index % colorNames.length];
			var newColor = window.chartColors[colorName];
			newDataset.backgroundColor.push(newColor);
		}

		config.data.datasets.push(newDataset);
		window.myDoughnut.update();
	}

	function semiCircle(){
		if (window.myDoughnut.options.circumference === Math.PI) {
			window.myDoughnut.options.circumference = 2 * Math.PI;
			window.myDoughnut.options.rotation = -Math.PI / 2;
		} else {
			window.myDoughnut.options.circumference = Math.PI;
			window.myDoughnut.options.rotation = -Math.PI;
		}

		window.myDoughnut.update();
	}

</script>
<!-- End of script section -->
@endsection
