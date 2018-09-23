<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Teachers Subject Allocation 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Teachers Subject Allocation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Teachers Subject Allocation</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group col-sm-8">
                  <label class="col-sm-3 control-label">Teacher Name </label>
					<div class="col-sm-9">
						<select class="form-control">
						<option>Select Teacher Name</option>
						<option>Amit</option>
						<option>Am</option>
						</select>
					</div>
                </div>
			</div>
			<div class="box-footer">
				<button style="margin-left:15px;" type="submit" class="btn pull-right btn-info">Import to Exel</button> 
				<button type="submit" class="btn pull-right btn-info">Search</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
         
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">

        <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">All Teachers Class/Section/Subjects</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>S.No.</th>
                  <th>Teacher Name</th>
                  <th>Class</th>
                  <th>Section</th>
                  <th>Subject</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>amit</td>
                  <td>V</td>
                  <td>A</td>
                  <td>Hindi,</td>
                </tr>
				<tr>
                   <td>1.</td>
                  <td>amit</td>
                  <td>V</td>
                  <td>A</td>
                  <td>Hindi,</td>
                </tr>
				<tr>
                   <td>1.</td>
                  <td>amit</td>
                  <td>V</td>
                  <td>A</td>
                  <td>Hindi,</td>
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