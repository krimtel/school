<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Class Upgradation
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Class Upgradation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Class Upgradation</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Medium</label>
					<div class="col-sm-10">
						<select class="form-control">
						<option>Select Medium</option>
						<option>Hindi</option>
						<option>English</option>
						</select>
					</div>
				</div>
				<div class="form-group col-sm-4">
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
				<div class="form-group col-sm-4">
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
                
				<button type="submit" class="btn pull-right btn-info">Search</button>
				<button type="submit" class="btn pull-right btn-info btn-space">Class Upgradation</button>
				<button type="submit" class="btn pull-right btn-info btn-space">Tc Student</button>
				<button type="submit" class="btn btn-default pull-right btn-space">Clear</button>
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
          <h3 class="box-title">All Student Class Upgradation</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <form role="form" class="form-horizontal">
			  <table class="table table-hover">
                <tr>
                  <th>S.No.</th>
                  <th>Student Name</th>
                  <th>Class Section</th>
				  <th><input type="checkbox" /> Select All</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Anita</td>
                  <td>V B</td>
                  <td><input type="checkbox" /></td>
                </tr>
				<tr>
                  <td>1.</td>
                  <td>Anita</td>
                  <td>V B</td>
				  <td><input type="checkbox" /></td>
                </tr>
				<tr>
                  <td>1.</td>
                  <td>Anita</td>
                  <td>V B</td>
				  <td><input type="checkbox" /></td>
                </tr>
              </table>
			  </form>
            </div>
			<div class="box-footer">
				<button style="margin-left:15px;" type="submit" class="btn pull-right btn-info">Update</button>
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
