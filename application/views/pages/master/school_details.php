<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        School Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">School Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Update School Details</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <!-- text input -->
                <div class="form-group">
                  <label class="col-sm-3 control-label">School Name</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter school name"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Address</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter sddress"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Email ID</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter email id"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Phone Number 1</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter phone no. 1"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Phone Number 2</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter phone no. 2"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Fax Number</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter fax no. 2"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Mobile Number 1</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter mobile no. 2"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Mobile Number 2</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter mobile no. 2"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Web Site</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter web site"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label" for="exampleInputFile">School Logo</label>
                  <div class="col-sm-9"><input type="file" id="exampleInputFile"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label" for="exampleInputFile">Result BackGround Logo</label>
                  <div class="col-sm-9"><input type="file" id="exampleInputFile"></div>
                </div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn pull-right btn-info">Update</button>
				<button type="submit" class="btn btn-default pull-right btn-space">Cancel</button>
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