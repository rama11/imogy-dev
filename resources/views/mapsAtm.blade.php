<!DOCTYPE html>
<html>
	<head>
		<title>Place Autocomplete Hotel Search</title>
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
			body {
				padding: 0 !important;
			}
			table {
				font-size: 12px;
			}
			.hotel-search {
				-webkit-box-align: center;
				-ms-flex-align: center;
				align-items: center;
				background: #fff;
				display: -webkit-box;
				display: -ms-flexbox;
				display: flex;
				left: 0;
				position: absolute;
				top: 0;
				width: 440px;
				z-index: 1;
			}
			#map {
				margin-top: 40px;
				width: 440px;
			}
			#listing {
				position: absolute;
				width: 200px;
				height: 470px;
				overflow: auto;
				left: 442px;
				top: 0px;
				cursor: pointer;
				overflow-x: hidden;
			}
			#findhotels {
				font-size: 14px;
			}
			#locationField {
				-webkit-box-flex: 1 1 190px;
				-ms-flex: 1 1 190px;
				flex: 1 1 190px;
				margin: 0 8px;
			}
			#controls {
				-webkit-box-flex: 1 1 140px;
				-ms-flex: 1 1 140px;
				flex: 1 1 140px;
			}
			#autocomplete {
				width: 100%;
			}
			#country {
				width: 100%;
			}
			.placeIcon {
				width: 20px;
				height: 34px;
				margin: 4px;
			}
			.hotelIcon {
				width: 24px;
				height: 24px;
			}
			#resultsTable {
				border-collapse: collapse;
				width: 240px;
			}
			#rating {
				font-size: 13px;
				font-family: Arial Unicode MS;
			}
			.iw_table_row {
				height: 18px;
			}
			.iw_attribute_name {
				font-weight: bold;
				text-align: right;
			}
			.iw_table_icon {
				text-align: right;
			}
		</style>
	</head>

	<body>

		<div class="hotel-search">
			<div id="findhotels">
				Find hotels in:
			</div>

			<div id="locationField">
				<input id="autocomplete" type="text" />
			</div>
		</div>

		<div id="map"></div>

		<script>

			function initMap() {
				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 10,
					center: {lat: -6.2297419, lng: 106.759478},
				});

				var marker = new google.maps.Marker({
					map: map,
					anchorPoint: new google.maps.Point(0, -29),
					draggable: true
				});

				var autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')));

				autocomplete.addListener('place_changed', function(){
					google.maps.event.trigger(map, 'resize');
					marker.setVisible(false);
					var place = autocomplete.getPlace();
					if (!place.geometry) {
						window.alert("No details available for input: " + place.name);
						return;
					}

					if (place.geometry.viewport) {
						map.fitBounds(place.geometry.viewport);
					} else {
						map.setCenter(place.geometry.location);
						map.setZoom(17);
					}
					marker.setPosition(place.geometry.location);
					marker.setVisible(true);
					console.log(place.geometry.location.lat());
					console.log(place.geometry.location.lng());
				});
				
			}
			
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places&callback=initMap"
				async defer></script>
	</body>
</html>