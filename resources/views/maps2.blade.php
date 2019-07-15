<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
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
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
  </head>
  <body>
  <button id="button">Tekan</button>
    <div id="map"></div>
    <script>

    $(document).ready(function(){
    	$("#button").click(function () {
    		 geoFindMe();
    	});
		
	});

function geoFindMe() {
  // var output = document.getElementById("out");

  if (!navigator.geolocation){
    output.innerHTML = "<p>Geolocation is not supported by your browser</p>";
    return;
  }

  function success(position) {
    var latitude  = position.coords.latitude;
    var longitude = position.coords.longitude;

    // output.innerHTML = '<p>Latitude is ' + latitude + '° <br>Longitude is ' + longitude + '°</p>';

    //var img = new Image();
    //img.src = "https://maps.googleapis.com/maps/api/staticmap?center=" + latitude + "," + longitude + "&zoom=13&size=300x300&sensor=false";
    console.log(latitude);
    console.log(longitude);
    return;
    //output.appendChild(img);
  }

  function error() {
    console.log("Unable to retrieve your location");
  }


  navigator.geolocation.getCurrentPosition(success, error);
}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAX4arGqDKY0F0VDrxeR4c5fyAloMqEMis"
    async defer></script>
  </body>
</html>