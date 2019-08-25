@extends('layouts.admin.layout')
@section('content')
<style type="text/css">
	.pac-container {
    background-color: #fff;
    z-index: 1070;
    position: fixed;
    display: inline-block;
    float: left;
}
.modal{
    z-index: 1060;  

.modal-backdrop{
    z-index: 1050;        
}​

</style>

<div class="content-wrapper">
		<section class="content-header">
			<h1>
				Set Absent Location
				<small>For employe who has onsite at the time</small>
			</h1>
		<a href="#" class="pull-right btn-box-tool text-green pull-left" data-toggle="modal" data-target="#modal-addNewLocation"><i class="fa fa-plus"></i> Add New Location</a>			
			<ol class="breadcrumb">
				<li><a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Set Location Absent</li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							@foreach($privileges as $privilege)
							<li>
								<a href="#{{$privilege->id}}" data-toggle="tab" aria-expanded="true">{{$privilege->privilege_name}}</a>
								
							</li>
							@endforeach
						</ul>
						<div class="tab-content">
							@foreach($privileges as $privilege)
							<div class="tab-pane" id="{{$privilege->id}}">
								<div class="post">	
									@foreach($users as $user)
										@if($user->jabatan == $privilege->id)
											<div class="user-block">
											<img class="img-circle img-bordered-sm" src="{{url($user->foto)}}" alt="user image">
												<span class="username">
													<a href="#">{{$user->name}}</a>
													<a href="#" class="pull-right btn-box-tool text-grey" data-toggle="modal" data-target="#modal-default" onclick="getLocation('{{$user->id}}')"><i class="fa fa-edit"></i>  Change Location</a>
												</span>
												<span class="description"><small class="label label-success">{{$user->location}}</small> location for this user now.</span>
										</div>
										@endif
									@endforeach
								</div>
							</div>
							@endforeach
						</div>
					</div>

					@if(session('status'))
					<div class="alert alert-success alert-dismissible" style="margin-top: 150px;margin-right: 10px; position:fixed; top:0; right:0; width:300px;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-check"></i> Success!</h4>
						{{session('status')}}
					</div>
					@endif
					<!-- /.nav-tabs-custom -->
				</div>
			</div>
			<!-- /.row -->
		</section>
		<!-- /.content -->
</div>

<!-- Modal Edit Location -->

<div class="modal fade in" id="modal-default"  tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<form method="GET" action="{{url('setLocation')}}">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Edit Location</h4>
				</div>
				<div class="modal-body">
					<p id="nameLoc"></p>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Before</label>
								<input id="beforeLoc" class="form-control" disabled type="text">
							</div>
						</div>
						<div class="col-md-6">
							<input id="userID" type="hidden" name="id" value="">
							<input id="userNAME" type="hidden" name="name" value="">
							<div class="form-group">
								<label>After</label>
								<select class="form-control" name="location" id="locationAfter">
								@foreach($location as $loc)
									<option value="{{$loc->id}}">{{$loc->name}}</option>
								@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-default" data-dismiss="modal" id="add">Add Location</button> -->
					<button type="submit" class="btn btn-primary" >Save changes</button>
				</div>
			</div>
		</form>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<!-- Modal Add Location -->
<button data-toggle="modal" data-target="#modal-default2" style="display: none;" id="showAdd"></button>
<div class="modal fade in" id="modal-addNewLocation" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<form method="GET" action="{{url('addLocation')}}">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Add Location</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<dir class="col-md-12">
							<div class="form-group">
								<label>Search Location</label>
								<input class="form-control" placeholder="Location" type="text" id="search">
							</div>
						</dir>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div id="map" style="height: 350px;width: 800px;margin:auto;display: block;background-color: #000;"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<dir class="col-md-12">
							<div class="form-group">
								<label>Name </label>
								<input class="form-control" placeholder="Yout Must Give Name This Location" type="text" name="pleace" required>
							</div>
						</dir>
					</div>
					<div class="row">
						<dir class="col-md-6">
							<div class="form-group">
								<label>Latitude</label>
								<input class="form-control" placeholder="" type="text" id="lat" name="lat">
							</div>
						</dir>
						<dir class="col-md-6">
							<div class="form-group">
								<label>Longitude</label>
								<input class="form-control" placeholder="" type="text" id="lng" name="lng">
							</div>
						</dir>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" >Add Location</button>
				</div>
			</div>
		</form>
	</div>	
</div>

@endsection

@section('script')	
<script type="text/javascript">

	$("#locationAfter").change(function(){
		$.ajax({
			type:'GET',
			url:'getLocationAfter',
			data:{
				location:this.value,
			},
			success : function(result){
				if(result != ""){
					$("#holderShifting").show();
					$("#checkShifting").html('<input type="checkbox" name="shifting" id="checkShifting"> Shifting on ' + result);
				} else {
					$("#holderShifting").hide();
					$("#checkShifting").html('<input type="checkbox" name="shifting" id="checkShifting"> Shifting on ' + result);
				}
			}
		})
	});

	var map;
	function initMap(){
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: -34.397, lng: 150.644},
			zoom: 8
		});

		var input = document.getElementById('search');
		var autocomplete = new google.maps.places.Autocomplete(input);

		autocomplete.bindTo('bounds', map);

		var marker = new google.maps.Marker({
			map: map,
			anchorPoint: new google.maps.Point(0, -29),
			draggable: true
		});

		autocomplete.addListener('place_changed', function() {
			google.maps.event.trigger(map, 'resize');
			marker.setVisible(false);
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				window.alert("No details available for input: '" + place.name + "'");
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
			$("#lat").val(place.geometry.location.lat());
			$("#lng").val(place.geometry.location.lng());
		});

		google.maps.event.addListener(marker, 'dragend', function (evt) {
		    $("#lat").val(evt.latLng.lat());
		    $("#lng").val(evt.latLng.lng());
		});
	}

	$("#add").click(function () {
		console.log('Tutup');
		$("#showAdd").click();
		google.maps.event.trigger(map, 'resize');
	});

	function getLocation(id){
		console.log(id);
		$.ajax({
			type: "GET",
			url: "getLocation/" + id,
			success: function(result){
				console.log(result[0]["id"]);
				$("#nameLoc").text("Change location for " + result[0]["name"]);
				$("#beforeLoc").attr("placeholder",result[0]["location"]);
				$("#userID").val(result[0]["id"]);
				$("#userNAME").val(result[0]["name"]);
			},
		});
	};
	
	function setLocation(){
		$.ajax({
			type: "GET",
			data:{
				id:1,
			},
			url: "setLocation",
			success: function(result){
				console.log(result);
			},
		});
	}
	$(".alert-success").delay(3000).fadeOut("slow");
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAX4arGqDKY0F0VDrxeR4c5fyAloMqEMis&libraries=places&callback=initMap" async defer></script>
@endsection