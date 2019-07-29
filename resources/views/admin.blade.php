@extends((Auth::user()->jabatan == "5") ? 'layouts.kemendagri.layout' : ((Auth::user()->jabatan == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout'))
@section('content')
<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Dashboard
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h3>{{$data["onwork_users"]}}</h3>

						<p>Onwork Users</p>
					</div>
					<div class="icon">
						<i class="fa  fa-check"></i>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-red">
					<div class="inner">
						<h3>{{$data["offwork_users"]}}</h3>

						<p>Offwork Users</p>
					</div>
					<div class="icon">
						<i class="fa  fa-remove"></i>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-blue">
					<div class="inner">
						<h3>44</h3>

						<p>Active Ticket</p>
					</div>
					<div class="icon">
						<i class="fa fa-paper-plane"></i>
					</div>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3>100%</h3>

						<p>Attendance</p>
					</div>
					<div class="icon">
						<i class="fa fa-user"></i>
					</div>
				</div>
			</div>
			<!-- ./col -->
		</div>
		<!-- /.row -->
		<!-- Main row -->
		<div class="row">
			<!-- Left col -->
			<section class="col-lg-8 connectedSortable">
				<!-- Custom tabs (Charts with tabs)-->
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">List Users</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>Condition</th>
									<th>Position</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1 ;?>
								@foreach($users as $user)
								<tr>
									<td>{{$no}}</td>
									<td>{{$user->name}}</td>
									<td>{{$user->email}}</td>
									<td>
										@if($user->condition == "on")
										<span class="label label-primary">Onwork</span>
										@else
										<span class="label label-danger">Offwork</span>
										@endif
									</td>
									<td>
										@if($user->jabatan == 1)	
										<span class="label label-success">Admin</span>									
										@elseif($user->jabatan == 2)
										<span class="label label-success">Helpdesk</span>
										@elseif($user->jabatan == 3)
										<span class="label label-success">Engineer</span>																						
										@endif
									</td>	
								</tr>
								<?php $no++;?>
								@endforeach
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- Galery -->
				<div class="box box-success">
					<div class="box box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">Gallery</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
									<li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
									<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
									<li data-target="#carousel-example-generic" data-slide-to="2" class="active"></li>
								</ol>
								<div class="carousel-inner">
									<div class="item">
										<img src="img/Wimogy.jpg" alt="First slide">

										<div class="carousel-caption">
											First Slide
										</div>
									</div>
									<div class="item">
										<img src="img/aogy.jpg" alt="Second slide">

										<div class="carousel-caption">
											Second Slide
										</div>
									</div>
									<div class="item active">
										<img src="img/1.jpg" alt="Third slide">

										<div class="carousel-caption">
											Third Slide
										</div>
									</div>
								</div>
								<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
									<span class="fa fa-angle-left"></span>
								</a>
								<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
									<span class="fa fa-angle-right"></span>
								</a>
							</div>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<!-- /.box -->
			</section>

			<section class="col-lg-4 connectedSortable">

				<!-- solid sales graph -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">My Attendance</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-8">
								<div class="chart-responsive">
									<div class="progress vertical">
										<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="{{$persen[2]}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$persen[2]}}%">
											<span class="sr-only">{{$persen[2]}}%</span>
										</div>
									</div>
									<!-- ./col -->
									<div class="progress vertical">
										<div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="{{$persen[1]}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$persen[1]}}%">
											<span class="sr-only">{{$persen[1]}}%</span>
										</div>
									</div>
									<div class="progress vertical">
										<div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="{{$persen[0]}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$persen[0]}}%">
											<span class="sr-only">{{$persen[0]}}%</span>
										</div>
									</div>
									<!-- ./col -->
									<div class="progress vertical">
										<div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="{{$absen}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$absen}}%">
											<span class="sr-only">{{$absen}}%</span>
										</div>
									</div>
									<!-- ./col -->
								</div>
								<!-- ./chart-responsive -->
							</div>
							<!-- /.col -->
							<div class="col-md-4">
								<ul class="chart-legend clearfix">
									<li><i class="fa fa-circle-o text-green"></i> Ontime</li>
									<li><i class="fa fa-circle-o text-yellow"></i> Injury</li>
									<li><i class="fa fa-circle-o text-red"></i> Late</li>
									<li><i class="fa fa-circle-o text-blue"></i> Absent</li>


								</ul>

								<!-- /.col -->
							</div>
							<!-- /.row -->
						</div>
						<!-- /.box-body -->
						<div class="box-footer no-padding">
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Ontime ({{$count[2]}})
									<span class="pull-right text-green">{{$persen[2]}}%</span></a>
								</li>
								<li><a href="#">Injury Time ({{$count[1]}})
									<span class="pull-right text-yellow">{{$persen[1]}}%</span></a>
								</li>
								<li><a href="#">Late ({{$count[0]}})
									<span class="pull-right text-red"> {{$persen[0]}}%</span></a>
								</li>
								<li><a href="#">Absent ({{$count[4]}})
									<span class="pull-right text-blue">-{{$persen[3]}}%</span></a>
								</li>
								<li><a href="#"><b>Attendance ({{$count[3]}})</b>
									<span class="pull-right ">{{$persen[4]}}%</span></a>
								</li>

							</ul>
						</div>
						<!-- /.footer -->
					</div>

					<!-- /.box -->
				</div>
				
			</section>
			<!-- right col -->

		</div>
		<!-- /.row (main row) -->

	</section>
	<!-- /.content -->
</div>
@endsection

@section('script')

<!-- jQuery 3.1.1 -->
@endsection