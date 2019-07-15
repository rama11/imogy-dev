@extends('layouts.helpdesk.hlayout')

@section('content')
<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Dashboard
				
			</h1>
			
		</section>
			<!-- Main row -->


			<div class="row">
				<!-- Left col -->
				<section class="content">
					
					<!-- /.box -->
					<!-- /.nav-tabs-custom -->

					<!-- Chat box -->
					<div class="col-md-12">
					<div class="box box-success">
						<div class="box-header">
							<i class="ion ion-clipboard"></i>

							<h3 class="box-title">Announcement</h3>

							<div class="box-tools pull-right" data-toggle="tooltip" title="Status">
								<div class="btn-group" data-toggle="btn-toggle">
									<button type="button" class="btn btn-default btn-sm active">
									<i class="fa fa-square text-green"></i>
									</button>
									<button type="button" class="btn btn-default btn-sm">
									<i class="fa fa-square text-red"></i>
									</button>
								</div>
							</div>
						</div>
						<div class="box-body chat" id="chat-box">
							<!-- chat item -->
							<div class="item">
								<img src="dist/img/user4-128x128.jpg" alt="user image" class="online">

								<p class="message">
									<a href="#" class="name">
										<small class="text-muted pull-right">
										<i class="fa fa-clock-o"></i> 2:15</small>
										Mike Doe
									</a>
									I would like to meet you to discuss the latest news about
									the arrival of the new theme. They say it is going to be one the
									best themes on the market
								</p>
								<div class="attachment">
									<h4>Attachments:</h4>

									<p class="filename">
										Theme-thumbnail-image.jpg
									</p>

									<div class="pull-right">
										<button type="button" class="btn btn-primary btn-sm btn-flat">Open</button>
									</div>
								</div>
								<!-- /.attachment -->
							</div>
							<!-- /.item -->
							<!-- chat item -->
							<div class="item">
								<img src="dist/img/user3-128x128.jpg" alt="user image" class="offline">

								<p class="message">
									<a href="#" class="name">
										<small class="text-muted pull-right">
										<i class="fa fa-clock-o"></i> 5:15</small>
										Alexander Pierce
									</a>
									I would like to meet you to discuss the latest news about
									the arrival of the new theme. They say it is going to be one the
									best themes on the market
								</p>
							</div>
							<!-- /.item -->
							<!-- chat item -->
							<div class="item">
								<img src="dist/img/user2-160x160.jpg" alt="user image" class="offline">

								<p class="message">
									<a href="#" class="name">
										<small class="text-muted pull-right">
										<i class="fa fa-clock-o"></i> 5:30</small>
										Susan Doe
									</a>
									I would like to meet you to discuss the latest news about
									the arrival of the new theme. They say it is going to be one the
									best themes on the market
								</p>
							</div>
							<!-- /.item -->
						</div>
						</div>
						<!-- /.chat -->
						
							<!-- <div class="input-group">
								<input class="form-control" placeholder="Type message...">

								<div class="input-group-btn">
									<button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>
								</div> -->
							
						<!-- </div> -->
					<!-- </div> -->
					
					  <!-- Main content -->
			
			<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Write Announcement
                <!-- <small>Advanced and full of features</small> -->
              </h3>
              <!-- tools box -->
              <!-- <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div> -->
              <!-- /. tools -->
              <div class="pull-right">
										<button type="button" class="btn btn-primary btn-sm btn-flat">Post</button>
									</div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              <form>
                    <textarea id="editor1" name="editor1"  rows="10" cols="80"></textarea>
              </form>
            </div>
            </div>
            </div>
            </section>
            </div>
            </div>
            </div>
        <!-- /.col-->
      <!-- ./row -->
    <!-- /.content -->
  <!-- /.content-wrapper -->
  @endsection
  @section('script')
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
@endsection

					<!-- /.box (chat box) -->

					<!-- TO DO List -->
					<!-- <div class="box box-primary">
						<div class="box-header">
							<i class="ion ion-clipboard"></i>

							<h3 class="box-title">To Do List</h3>

							<div class="box-tools pull-right">
								<ul class="pagination pagination-sm inline">
									<li><a href="#">&laquo;</a></li>
									<li><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">&raquo;</a></li>
								</ul>
							</div>
						</div> -->
						<!-- /.box-header -->
						<!-- <div class="box-body"> -->
							<!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
							<!-- <ul class="todo-list">
								<li> -->
									<!-- drag handle -->
									<!-- <span class="handle">
												<i class="fa fa-ellipsis-v"></i>
												<i class="fa fa-ellipsis-v"></i>
											</span> -->
									<!-- checkbox -->
									<!-- <input type="checkbox" value=""> -->
									<!-- todo text -->
									<!-- <span class="text">Design a nice theme</span> -->
									<!-- Emphasis label -->
									<!-- <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> -->
									<!-- General tools such as edit or delete-->
									<!-- <div class="tools">
										<i class="fa fa-edit"></i>
										<i class="fa fa-trash-o"></i>
									</div>
								</li>
								<li>
											<span class="handle">
												<i class="fa fa-ellipsis-v"></i>
												<i class="fa fa-ellipsis-v"></i>
											</span>
									<input type="checkbox" value="">
									<span class="text">Make the theme responsive</span>
									<small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
									<div class="tools">
										<i class="fa fa-edit"></i>
										<i class="fa fa-trash-o"></i>
									</div>
								</li>
								<li>
											<span class="handle">
												<i class="fa fa-ellipsis-v"></i>
												<i class="fa fa-ellipsis-v"></i>
											</span>
									<input type="checkbox" value="">
									<span class="text">Let theme shine like a star</span>
									<small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
									<div class="tools">
										<i class="fa fa-edit"></i>
										<i class="fa fa-trash-o"></i>
									</div>
								</li>
								<li>
											<span class="handle">
												<i class="fa fa-ellipsis-v"></i>
												<i class="fa fa-ellipsis-v"></i>
											</span>
									<input type="checkbox" value="">
									<span class="text">Let theme shine like a star</span>
									<small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
									<div class="tools">
										<i class="fa fa-edit"></i>
										<i class="fa fa-trash-o"></i>
									</div>
								</li>
								<li>
											<span class="handle">
												<i class="fa fa-ellipsis-v"></i>
												<i class="fa fa-ellipsis-v"></i>
											</span>
									<input type="checkbox" value="">
									<span class="text">Check your messages and notifications</span>
									<small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
									<div class="tools">
										<i class="fa fa-edit"></i>
										<i class="fa fa-trash-o"></i>
									</div>
								</li> -->
								
					<!-- /.box -->

				
