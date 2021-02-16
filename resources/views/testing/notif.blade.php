@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))

@section('head')
	<!-- Start of head section -->
	<!-- End of head section -->
@endsection
@section('content')
<!-- Start of content section -->
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Notification Testing
			<small>finish and update all activiy of project</small>
		</h1>
		<ol class="breadcrumb">
			<button type="button" class="btn btn-flat btn-primary btn-xs" onclick='getNotif("Data Updated")'>Get Notif</button>
			<button type="button" class="btn btn-flat btn-primary btn-xs" onclick='sendUpdate()'>Send Update</button>
		</ol>
	</section>
	<section class="content">
	</section>
</div>
<!-- End of content section -->
@endsection 

@section('script')
<script defer src="https://www.gstatic.com/firebasejs/6.1.1/firebase-app.js"></script>
<script defer src="https://www.gstatic.com/firebasejs/6.1.1/firebase-database.js"></script>
<!-- Start of script section -->
<script type="text/javascript">
	$(document).ready(function(){
		var firebaseConfig = {
			apiKey: "{{env('APIKEY')}}",
			authDomain: "{{env('AUTHDOMAIN')}}",
			databaseURL: "{{env('DATABASEURL')}}",
			projectId: "{{env('PROJECTID')}}",
			storageBucket: "{{env('STOREBUCKET')}}",
			messagingSenderId: "{{env('MESSAGINGSENDERID')}}",
			appId: "{{env('APPID')}}",
		};
		// Initialize Firebase
		firebase.initializeApp(firebaseConfig);
		firebase.database().ref('/test/').limitToLast(4).on('child_added', function(snapshot) {
			getNotif('Data Updated')
			console.log(snapshot.val())
			// updateLastest(snapshot.val())
		});
	})

	function sendUpdate(){
		$.ajax({
			type:"GET",
			url:"{{url('notif_test_store')}}",
		})
	}

	function getNotif(argument) {
		if (!("Notification" in window)) {
			alert("This browser does not support desktop notification");
		} else if (Notification.permission === "granted") {
			var notification = new Notification(argument);
		} else if (Notification.permission !== "denied") {
			Notification.requestPermission().then(function (permission) {
				if (permission === "granted") {
					var notification = new Notification("Hi there!");
				}
			});
		}

		notification.onclick = function(event) {
			event.preventDefault()
			console.log('click')
		}
	}
</script>
<!-- End of script section -->
@endsection