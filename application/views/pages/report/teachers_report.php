<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Teachers Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Teachers Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        		
		<section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Search Teachers</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group col-sm-8">
                  <label class="col-sm-3 control-label">Search Teacher's</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Search Teacher's"></div>
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
		<section class="col-lg-12 connectedSortable">

        <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">All Teacher's Report</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>S.No.</th>
                  <th>Teachers Name</th>
                  <th>Gender</th>
                  <th>Address</th>
                  <th>Contact No.</th>
                  <th>DOB</th>
                  <th>Qualification</th>
                  <th>Designation</th>
                  <th>Levels</th>
                  <th>Class Teacher</th>
                  <th>Added By</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>amit</td>
                  <td>male</td>
                  <td>123</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                </tr>
				<tr>
                   <td>1.</td>
                  <td>amit</td>
                  <td>123</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
                  <td>1274</td>
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