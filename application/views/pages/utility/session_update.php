<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Session Update
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Session Update</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Upload Photo Students/Teachers</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Photos</label>
					<div class="col-sm-10">
						<select class="form-control">
						<option>Select photo</option>
						<option>Teachers</option>
						<option>Students</option>
						</select>
					</div>
				</div> 
				<div class="form-group col-sm-4">
                  <label class="col-sm-2 control-label">Upload Photo</label>
                  <div class="col-sm-10"><input type="file" class="form-control" ></div>
                </div>
			</div>
			<div class="box-footer">
				<a class="btn pull-right btn-info">Class Wise Marks</a> 
				<button type="submit" class="btn pull-right btn-info btn-space">Search</button> 
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