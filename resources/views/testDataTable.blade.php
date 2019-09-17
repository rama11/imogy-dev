<!DOCTYPE html>
<html>
<head>
	<title>Test Data Table</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
</head>
<body>
	<div id="canvas-holder" style="width:40%">
		<canvas id="chart-area"></canvas>
	</div>

	<script
		src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>
		
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.min.js"></script>
	<script>
		Chart.pluginService.register({
			beforeDraw: function (chart) {
				if (chart.config.options.elements.center) {
			//Get ctx from string
			var ctx = chart.chart.ctx;
			
					//Get options from the center object in options
			var centerConfig = chart.config.options.elements.center;
			var fontStyle = centerConfig.fontStyle || 'Arial';
					var txt = centerConfig.text;
			var color = centerConfig.color || '#000';
			var sidePadding = centerConfig.sidePadding || 20;
			var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
			//Start with a base font of 30px
			ctx.font = "30px " + fontStyle;
			
					//Get the width of the string and also the width of the element minus 10 to give it 5px side padding
			var stringWidth = ctx.measureText(txt).width;
			var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

			// Find out how much the font can grow in width.
			var widthRatio = elementWidth / stringWidth;
			var newFontSize = Math.floor(30 * widthRatio);
			var elementHeight = (chart.innerRadius * 2);

			// Pick a new font size so it will not be larger than the height of label.
			var fontSizeToUse = Math.min(newFontSize, elementHeight);

					//Set font settings to draw it correctly.
			ctx.textAlign = 'center';
			ctx.textBaseline = 'middle';
			var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
			var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
			ctx.font = fontSizeToUse+"px " + fontStyle;
			ctx.fillStyle = color;
			
			//Draw text in center
			ctx.fillText(txt, centerX, centerY);
				}
			}
		});


		var config = {
			type: 'doughnut',
			data: {
				labels: [
				  "BJBR",
				  "BSBB",
				  "BRKR",
				  "TTNI",
				],
				datasets: [{
					data: [300, 50, 100,75],
					backgroundColor: [
					  "#2ecc71",
					  "#e67e22",
					  "#c0392b",
					  "#3498db"
					],
					hoverBackgroundColor: [
					  "#2ecc71",
					  "#e67e22",
					  "#c0392b",
					  "#3498db"
					]
				}]
			},
			options: {
				elements: {
					center: {
						text: '90',
						color: '#2c3e50', // Default is #000000
						fontStyle: 'Arial', // Default is Arial
						sidePadding: 20 // Defualt is 20 (as a percentage)
					}
				},
				legend: {
					display: false,
				},
			}
		};


		var ctx = document.getElementById("chart-area").getContext("2d");
		var myChart = new Chart(ctx, config);
	</script>
</body>
</html>