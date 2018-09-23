<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Compartment Marks Entry
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Compartment Marks Entry</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-10 col-lg-offset-1 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Update Compartment Marks</h3>
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
						<option>Select Medium</option>
						<option>Hindi</option>
						<option>English</option>
						</select>
					</div>
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
				<div class="form-group">
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
					<select class="form-control">
						<option>Select Subject Group</option>
						<option>Maths</option>
						<option>Boilogy</option>
						<option>Commerce</option>
						<option>Arts</option>
					</select>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Elective Subjects</label>
					<div class="col-sm-10">
					<select class="form-control">
						<option>Select Elective Subject</option>
						<option>CS</option>
						<option>Hindi</option>
						<option>PE</option>
						<option>Maths</option>
					</select>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Subjects</label>
					<div class="col-sm-10">
					<select class="form-control">
						<option>Select Subject</option>
						<option>Hindi</option>
						<option>English</option>
						<option>EVS</option>
						<option>Maths</option>
					</select>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Exam Type</label>
					<div class="col-sm-10">
					<select class="form-control">
						<option>Select Exam Type</option>
						<option>Annual</option>
					</select>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Sub. Exam Type</label>
					<div class="col-sm-10">
					<select class="form-control">
						<option>Select Sub Exam Type</option>
						<option>TH</option>
						<option>PR</option>
					</select>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn pull-right btn-info">Search</button>
				<button type="submit" class="btn btn-default pull-right btn-space">Cancel</button>
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
          <h3 class="box-title">Update Compartment Marks</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
		<form role="form" class="form-horizontal">
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>S.No.</th>
                   <th>Student Name</th>
				  <th>Class/Section</th>
				  <th>Addmission No.</th>
				  <th>Roll No.</th>
                  <th>Marks</th>
                  <th>Edit/Delele</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Sunil</td>
                  <td>XI B</td>
                  <td>123</td>
                  <td>147</td>
                  <td><input type="text"  /></td>
                </tr>
				<tr>
                  <td>1.</td>
                  <td>Sunil</td>
                  <td>XI B</td>
				  <td>123</td>
                  <td>147</td>
                  <td><input type="text"  /></td>
                </tr>
				<tr>
                  <td>1.</td>
                  <td>Sunil</td>
                  <td>XI B</td>
				  <td>123</td>
                  <td>147</td>
                  <td><input type="text"  /></td>
                </tr>
              </table>
            </div>
			<div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn pull-right btn-info">Submit</button>
            </div>
		</form>
        <!-- /.box-body -->
      </div>

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>