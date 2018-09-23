<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Database Backup
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Database Backup</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Database Backup</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
				<div class="form-group col-sm-6">
                  <label class="col-sm-4 control-label">Database Name</label>
                  <div class="col-sm-8">
						<select class="form-control">
						<option>Shakuntala_vidyalaya</option>
						</select>
					</div>
                </div>
			</div>
			<div class="box-footer">
				<button style="margin-left:15px;" type="submit" class="btn pull-right btn-info">Backup Database</button> 
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