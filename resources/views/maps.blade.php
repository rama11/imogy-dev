<!DOCTYPE html>
<html>
	<head>
		<title>Geolocation</title>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta charset="utf-8">
		<style>
			/* Always set the map height explicitly to define the size of the div
			 * element that contains the map. */
			#map {
				height: 100%;
			}
			/* Optional: Makes the sample page fill the window. */
			html, body {
				height: 100%;
				margin: 0;
				padding: 0;
			}
		</style>
	</head>
	<body>
		<div id="map"></div>
		<script>
			// Note: This example requires that you consent to location sharing when
			// prompted by your browser. If you see the error "The Geolocation service
			// failed.", it means you probably did not give permission for the browser to
			// locate you.
			function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: -34.397, lng: 150.644},
			zoom: 8
		});
	}
		</script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAX4arGqDKY0F0VDrxeR4c5fyAloMqEMis&callback=initMap"></script>
		<script type="text/javascript">
			
		</script>
	</body>
</html>