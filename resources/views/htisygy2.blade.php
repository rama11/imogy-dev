@extends('layouts.helpdesk.hlayout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<img src="img/tisygy.png" width="12%" height="12%">
<ol class="breadcrumb">
	<li><a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Tisygy  </li>
</ol>
</section>
<section class="content">
<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab">Create</a></li>
				<li><a href="#tab_2" data-toggle="tab">Management Ticket</a></li>
				<li><a href="#tab_3" data-toggle="tab">Tracking Ticket</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
						Dropdown <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
						<li role="presentation" class="divider"></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
					</ul>
				</li>
				<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<form class="form-horizontal">
				<div class="box-body">
					<div class="form-group">
						<label for="inputNomor" class="col-sm-2 control-label">Nomor Ticket</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputticket" placeholder="enter...">
						</div>
					</div>
					<div class="form-group">
						<label for="inputDescription" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputdescription" placeholder="enter...">
						</div>
					</div>
					<div class="form-group">
						<label for="inputCreator" class="col-sm-2 control-label">User</label>
						<div class="col-sm-10">
					<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
						<option selected="selected">User1</option>
						<option>User2</option>
						<option>User3</option>
						<option>User4</option>
						<option>User5</option>
						<option>User6</option>
						<option>User7</option>
					</select>
					<!-- <span class="select2 select2-container select2-container-default select2-container-below" dir="ltr" style="width: 100%;">
					<span class="selection">
					<span class="select2-selection select2-selection-single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-m2r5-container">
					<span class="select2-selection__rendered" id="select2-m2r5-container" title="Alabama">Alabama</span>
					<span class="select2-selection__arrow" role="presentation">
					<b role="presentation"></b>
					</span>
					</span>
					</span>
					<span class="dropdown-wrapper">
					</span> -->

				</div>
						</div>
						<div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputemail" placeholder="enter...">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputContact" class="col-sm-2 control-label">Contact</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputcontact" placeholder="enter...">
                  </div>
                </div>
	<div class="form-group">
						<label for="inputPriority" class="col-sm-2 control-label">Priority</label>
						<div class="col-sm-10">
					<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
						<option selected="selected">/*Priority*/</option>
						<option>P1</option>
						<option>P2</option>
						<option>P3</option>
						<option>P4</option>
					</select>
					</div>
						</div>
					
	<div class="form-group">
						<label for="inputAgent" class="col-sm-2 control-label">Agent</label>
						<div class="col-sm-10">
							<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
						<option selected="selected">/*Agent*/</option>
						<option>Agent1</option>
						<option>Agent2</option>
						<option>Agent3</option>
						<option>Agent4</option>
					</select>
						</div>
	</div>
	<div class="form-group">
						<label for="inputStatus" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputstatus" placeholder="enter...">
						</div>
					</div>
<div class="input-group">
					<label for="inputStatus" class="col-sm-2 control-label"></label>
					<span class="input-group-addon">
					<i class="fa fa-envelope"></i></span>
					<input type="email" class="form-control" placeholder="Email">
				</div>               
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-primary pull-right">Create</button>
				</div>
					</div>
					
				<!-- /.box-footer -->
			</form>
				<!-- /.tab-pane -->
				<!-- /.tab-pane -->
			</div>
			<!-- /.tab-content -->
			
		</div>
</div>
</section>
</div>
@endsection