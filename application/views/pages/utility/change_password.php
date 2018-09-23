<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Change Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Change Password</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
				 <div class="form-group">
                  <label class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-10"><input type="text" class="form-control" placeholder="Enter Username"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Old Password</label>
                  <div class="col-sm-10"><input type="password" class="form-control" placeholder="Enter old password"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">New Password</label>
                  <div class="col-sm-10"><input type="password" class="form-control" placeholder="Enter new password"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Confirm Password</label>
                  <div class="col-sm-10"><input type="password" class="form-control" placeholder="Enter confirm password"></div>
                </div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn pull-right btn-info">Change Password</button> 
				<button type="submit" class="btn btn-default pull-right btn-space">Clear</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
         
        </section>
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>