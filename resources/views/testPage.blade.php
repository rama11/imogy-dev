<!DOCTYPE html>
<html>
<head>
	<title>Test Page</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<body>
	<div class="jumbotron text-center">
		<h1>SLA Calculator</h1>
		<button class="btn btn-success" onclick="process(99)">99%</button>
		<button class="btn btn-warning" onclick="process(99.9)">99,9%</button>
		<button class="btn btn-danger" onclick="process(99.99)">99,99%</button>
	</div>
	<div class="container">
		
		<div class="row">
			<div class="col-sm-6">
				<h2 id="month">Adjustment Table</h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<th></th>
							<th>Day</th>
							<th>Hour</th>
							<th>Minute</th>
							<th>Second<n/th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Total</th>
							<td id="1a">Day</td>
							<td id="1b">Hour</td>
							<td id="1c">Minute</td>
							<td id="1d">Second<n/td>
						</tr>
						<tr>
							<th>Down</th>
							<td id="2a">Day</td>
							<td id="2b">Hour</td>
							<td id="2c">Minute</td>
							<td id="2d">Second<n/td>
						</tr>
						<tr>
							<th>Tolerance</th>
							<td id="3a">Day</td>
							<td id="3b">Hour</td>
							<td id="3c">Minute</td>
							<td id="3d">Second<n/td>
						</tr>
					</tbody>
				</table>
				<h2>Sampe Condition</h2>
				<table class="table">
					<thead>
						<tr>
							<th>Time</th>
							<th>Detail</th>
						</tr>
					</thead>
					<tbody id="tbody">
						
					</tbody>
				</table>
			</div>
			<div class="col-sm-6">
				<h2>Calculation</h2>
				<p>Format (day hours:minute:second)</p>
				<table class="table">
					<tbody>
						<tr>
							<th>Total</th>
							<td id="total"></td>
						</tr>
						<tr>
							<th>Downtime</th>
							<td id="downtime"></td>
						</tr>
						<tr>
							<th>Up</th>
							<td id="uptime"></td>
						</tr>
					</tbody>
				</table>
				<h1>SLA is <span id="sla"></span></h1>
				<button class="btn btn-xl btn-danger" style="display: none" id="fail">
					Fail
				</button>
				<button class="btn btn-xl btn-success" style="display: none" id="success">
					Success
				</button>
			</div>
		</div>
	</div>

	<!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Moment JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- moment-duration-format plugin -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-duration-format/1.3.0/moment-duration-format.min.js"></script>
	<script>
		var max = 8;
		var min = 24;

		var random = Math.floor(Math.random() * (max - min) + min);
		var random = Math.random() * (max - min) + min;
		// var selesai = false;
		// while(selesai == false){
		// 	random = Math.floor(Math.random() * (max - min) + min);
		// 	if(random % 2 == 0)
		// 		selesai = true;
		// }
		console.log(random);


		var time = ["22 March 2018 10:00:00", "22 March 2018 10:15:00", "22 March 2018 10:45:00", "22 March 2018 10:50:00"];
		var detail = ["Device Fail","Couse Report","Resolution","Confirmation OK"];

		var append = "";
		for (var i = 0; i < time.length; i++) {
			append = append + "<tr>";
			append = append + "<th>" + time[i] + "</th>";
			append = append + "<td>" + detail[i] + "</td>";
			append = append + "</tr>";
		}

		$("#tbody").append(append);

		// Calculation Time
		var start = moment(time[0]).format("X");
		var end = moment(time[time.length - 1]).format("X");
		var final = end - start;

		console.log(start);
		console.log(end);

		console.log("time : " + moment().startOf('day').seconds(final).format("H:mm:ss"));


		function precisionRound(number, precision) {
			var factor = Math.pow(10, precision);
			return Math.round(number * factor) / factor;
		}


		function process(sla){
			console.log(sla);
			$("#month").text("Adjustment Table on " + moment().format("MMMM"));

			var day = moment().daysInMonth();
			var hour = day * 24;
			var minute = hour * 60;
			var second = minute * 60;

			$("#1a").text(day);
			$("#1b").text(hour);
			$("#1c").text(minute);
			$("#1d").text(second);

			var day2 = (day / 100) * (100 - sla);
			var hour2 = (hour / 100) * (100 - sla);
			var minute2 = (minute / 100) * (100 - sla);
			var second2 = (second / 100) * (100 - sla);

			$("#2a").text(precisionRound(day2, 2));
			$("#2b").text(precisionRound(hour2, 2));
			$("#2c").text(precisionRound(minute2, 2));
			$("#2d").text(precisionRound(second2, 2));

			var day3 = (day / 100) * sla;
			var hour3 = (hour / 100) * sla;
			var minute3 = (minute / 100) * sla;
			var second3 = (second / 100) * sla;

			$("#3a").text(precisionRound(day3, 2));
			$("#3b").text(precisionRound(hour3, 2));
			$("#3c").text(precisionRound(minute3, 2));
			$("#3d").text(precisionRound(second3, 2));

			var all = second - final;
			
			var duration = moment.duration(second ,'seconds');
			var total = duration.format('d hh:mm:ss');
			console.log(total);

			$("#total").text(total);

			var duration = moment.duration(final ,'seconds');
			var downtime = duration.format('d hh:mm:ss');
			console.log(downtime);

			$("#downtime").text(downtime);

			var duration = moment.duration(all ,'seconds');
			var uptime = duration.format('d hh:mm:ss');
			console.log(uptime);

			$("#uptime").text(uptime);

			console.log(all/second);

			var real_sla = precisionRound(all/second * 100, 3);

			$("#sla").text(real_sla + "%");
			if(real_sla >= sla){
				console.log('berhasil');
				$("#fail").hide();
				$("#success").show();
			} else {
				console.log('gagal');
				$("#fail").show();
				$("#success").hide();
			}

		}

		// console.log(moment("22 March 2018 10:50:00").format("X"));

		$(document).ready(function (){
			console.log("JQuery Ready");
			console.log(moment().format("DD MMMM YYYY"));
			console.log(moment().daysInMonth());
		});
	</script>
</body>
</html>