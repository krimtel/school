<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Student Attendance Entry
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Student Attendance Entry</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add Student Attendance</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Medium</label>
					<div class="col-sm-10">
						<select class="form-control">
						<option>Hindi</option>
						<option>English</option>
						</select>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Select Term</label>
					<div class="col-sm-10">
						<select class="form-control">
						<option>Select Term</option>
						<option>Mid Term</option>
						<option>Annual</option>
						</select>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Enter Max Present Days</label>
                  <div class="col-sm-10"><input type="text" class="form-control" placeholder="Enter max present days"></div>
                </div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Class</label>
					<div class="col-sm-10">
						<select class="form-control">
						<option>Select Class</option>
						<option>NUR</option>
						<option>UKG</option>
						<option>I</option>
						<option>II</option>
						<option>III</option>
						<option>VI</option>
						<option>V</option>
						</select>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
					<select class="form-control">
					<option>Select Section</option>
                    <option>A</option>
                    <option>B</option>
                    <option>C</option>
                    <option>D</option>
                    <option>E</option>
                    <option>F</option>
                    <option>G</option>
					</select>
					</div>
				</div>
			</div>
			<div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn pull-right btn-info">Submit</button>
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
          <h3 class="box-title">All Session</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>S.No.</th>
                  <th>Session</th>
                  <th>Active</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>2017-18</td>
                  <td><input type="checkbox" checked /></td>
                </tr>
				<tr>
                  <td>2.</td>
                  <td>2016-17</td>
                  <td><input type="checkbox" /></td>
                </tr>
				<tr>
                  <td>3.</td>
                  <td>2015-16</td>
                  <td><input type="checkbox" /></td>
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