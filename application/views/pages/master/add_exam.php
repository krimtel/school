<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Exam
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Exam</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New Exam</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Exam Name</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter exam name"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Out Of Marks</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter out of marks"></div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Percentage</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Enter percentage"></div>
                </div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-info pull-right">Submit</button>
				<button type="submit" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
         
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">

          <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">All Exam List</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>S.No.</th>
                  <th>Exam Name</th>
                  <th>Out Of Marks</th>
                  <th>Percentage</th>
				  <th>Edit/Delete</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Pre Mid</td>
                  <td>100</td>
                  <td>20</td>
				  <td><a type="button" class="btn btn-warning btn-flat" title="Edit" ><i class="fa fa-pencil"></i></a> <a type="button" class="btn btn-danger btn-flat" title="Delete"><i class="fa fa-trash-o"></i></a></td>
                </tr>
				<tr>
                  <td>1.</td>
				  <td>Mid</td>
                  <td>100</td>
                  <td>20</td>
				  <td><a type="button" class="btn btn-warning btn-flat" title="Edit" ><i class="fa fa-pencil"></i></a> <a type="button" class="btn btn-danger btn-flat" title="Delete"><i class="fa fa-trash-o"></i></a></td>
                </tr>
				<tr>
                  <td>1.</td>
                  <td>Annual</td>
                  <td>100</td>
                  <td>20</td>
				  <td><a type="button" class="btn btn-warning btn-flat" title="Edit" ><i class="fa fa-pencil"></i></a> <a type="button" class="btn btn-danger btn-flat" title="Delete"><i class="fa fa-trash-o"></i></a></td>
                </tr>
              </table>
            </div>
        <!-- /.box-body -->
      </div>

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>