@extends((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : ((Auth::user()->jabatan == "2") ? 'layouts.helpdesk.hlayout' : ((Auth::user()->jabatan == "3") ? 'layouts.engineer.elayout' : ((Auth::user()->jabatan == "4") ? 'layouts.projectcor.playout' : ((Auth::user()->jabatan == "5") ? 'layouts.superuser.slayout' :'layouts.engineer.elayout')))))
@section('head')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
	<style type="text/css">
		.pac-container {
			z-index: 1100 !important;
		}

		.swal2-margin {
			margin: .3125em;
		}
	</style>
	<link rel="stylesheet" href="{{ url('plugins/datatables/dataTables.bootstrap.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Set Absent Location
			<small>For employe who has onsite at the time</small>
		</h1>
		<a href="#" class="pull-right btn-box-tool text-green pull-left" data-toggle="modal" data-target="#modal-addNewLocation"><i class="fa fa-plus"></i> Add New Location</a>			
		<a href="#" class="pull-right btn-box-tool text-light-blue pull-left" data-toggle="modal" data-target="#modal-manageLocation"><i class="fa fa-gear"></i> Manage Location</a>			
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
			</div>
		</div>

		<div class="modal fade in" id="modal-default">
			<div class="modal-dialog">
				<form method="GET" action="{{url('/usermanage/setLocation')}}" role="form">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
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
										<select class="form-control select2" name="location" style="width: 100%;"  id="locationAfter"></select>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary" >Save changes</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="modal fade in" id="modal-addNewLocation">
			<div class="modal-dialog modal-lg">
				<form method="GET" action="{{url('/usermanage/addLocation')}}">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Add Location</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Search Location</label>
								<input class="form-control" placeholder="Location" type="text" id="search">
							</div>
							<div class="form-group">
								<div id="map" style="height: 350px;width: 100%;margin:auto;display: block;background-color: #000;"></div>
							</div>
							<div class="form-group">
								<label>Name </label>
								<input class="form-control" placeholder="Yout Must Give Name This Location" type="text" name="pleace" required>
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

		<div class="modal fade in" id="modal-manageLocation">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Manage Location</h4>
					</div>
					<div class="modal-body">
						<table class="table table-bordered table-striped dataTable" id="locationTable" style="width:100%">
							<thead>
								<tr>
									<th>Name</th>
									<th>Status</th>
									<th>Radius</th>
									<th>Created Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Name</th>
									<th>Status</th>
									<th>Radius</th>
									<th>Created Date</th>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>	
		</div>
	</section>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ url('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script type="text/javascript">

	var swalWithCustomClass

	swalWithCustomClass = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-flat btn-primary swal2-margin',
				cancelButton: 'btn btn-flat btn-danger swal2-margin',
				denyButton: 'btn btn-flat btn-danger swal2-margin',
				popup: 'border-radius-0',
			},
			buttonsStyling: false,
		})

	$(document).ready(function(){
		$(".select2").select2({
			data: @json($location).result
		});

		$(".select2").change(function(){
			$.ajax({
				type:'GET',
				url:'{{url("/usermanage/getLocationAfter")}}',
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
	})

	var map;
	function initMap(){
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: -6.2297419, lng: 106.759478},
			zoom: 10,
			// zoomControl: false,
			mapTypeControl: false,
			scaleControl: false,
			streetViewControl: false,
			rotateControl: false,
			fullscreenControl: false
		});

		var autocomplete = new google.maps.places.Autocomplete((document.getElementById('search')));

		 map.addListener('click', function(result) {
			console.log(result.latLng)
			marker.setVisible(false);
			marker.setPosition(result.latLng);
			marker.setVisible(true);
			$("#lat").val(result.latLng.lat());
			$("#lng").val(result.latLng.lng());
		});

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
			$("#lat").val(place.geometry.location.lat());
			$("#lng").val(place.geometry.location.lng());
		});

		google.maps.event.addListener(marker, 'dragend', function (evt) {
			$("#lat").val(evt.latLng.lat());
			$("#lng").val(evt.latLng.lng());
		});
	}

	$("#add").click(function () {
		$("#showAdd").click();
		google.maps.event.trigger(map, 'resize');
	});

	function getLocation(id){
		$.ajax({
			type: "GET",
			url: "{{url('/usermanage/getLocation/')}}/" + id,
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
			url: "{{url('/usermanage/setLocation')}}",
			success: function(result){
				console.log(result);
			},
		});
	}
	$(".alert-success").delay(3000).fadeOut("slow");

	$("#locationTable").DataTable({
		ajax:{
			url:'{{url("/usermanage/getLocationList")}}',
			dataSrc: function (json){
				json.data.forEach(function(data,idex){
					// data.action = '<button class="btn btn-warning btn-flat btn-sm" onclick="editLocation(' + data.id + ')">Edit</button> <button class="btn btn-danger btn-flat btn-sm" onclick="deleteLocation(' + data.id + ')">Delete</button>'
					data.action = '<button class="btn btn-danger btn-flat btn-sm" onclick="deleteLocation(' + data.id + ')">Delete</button>'
				})
				return json.data
			}
		},
		columns:[
			{data:'name'},
			{data:'status'},
			{data:'radius'},
			{data:'create_date'},
			{
				data:'action',
				class:'text-center'
			},
		],
	})

	function deleteLocation(id){
		swalPopUp(
			'warning',
			'Delete',
			'GET',
			'{{url("/usermanage/deleteLocation")}}',
			{
				id:id
			},
			"Make sure the location you want to delete is correct",
			function(){

			}
		)
	}

	function swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,textSwal,callback){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: textSwal,
			icon: typeAlert,
			showCancelButton: true,
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			}).then((result) => {
				if (result.value){
					$.ajax({
						type: typeAjax,
						url: urlAjax,
						data: dataAjax,
						beforeSend: function(){
							Swal.fire({
								title: 'Please Wait..!',
								text: "It's sending..",
								allowOutsideClick: false,
								allowEscapeKey: false,
								allowEnterKey: false,
								customClass: {
									popup: 'border-radius-0',
								},
								didOpen: () => {
									Swal.showLoading()
								}
							})
						},
						success: function(resultAjax){
							Swal.hideLoading()
							swalWithCustomClass.fire({
								title: 'Success!',
								text: typeActivity + " Ticket Sended.",
								icon: 'success',
								confirmButtonText: 'Reload',
							}).then((result) => {
								// console.log(resultAjax)
								callback()
								getPerformanceByClient(resultAjax.client_acronym_filter)
							})
						},
						error: function(resultAjax,errorStatus,errorMessage){
							Swal.hideLoading()
							swalWithCustomClass.fire({
								title: 'Error!',
								text: "Something went wrong, please try again!",
								icon: 'error',
								confirmButtonText: 'Try Again',
							}).then((result) => {
								$.ajax(this)
							})
						}
					});
				}
			}
		);
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places&callback=initMap" async defer></script>
@endsection