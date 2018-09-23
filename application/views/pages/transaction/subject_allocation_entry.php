<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Teachers Subject Allocation
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Teachers Subject Allocation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add Teacher Subject Allocation</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" id="sub_alloc_form" class="form-horizontal" name="f1" method="POST" action="<?php echo base_url();?>Subject_ctrl/subject_allocation">
			<div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Teacher</label>
					<div class="col-sm-10">
						<select class="form-control" name="teacher" id="teacher">
						<option value="0">Select Teacher</option>
						<?php foreach($teachers as $teacher){ ?>
							<option value="<?php echo $teacher['t_id']; ?>"><?php echo $teacher['name']; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label">Medium</label>
					<div class="col-sm-10">
						<select class="form-control" name="medium" id="medium">
						<option value="0">Select Medium</option>
						<option value="English">English</option>
						<option value="Hindi">Hindi</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label">Class</label>
					<div class="col-sm-10">
						<select class="form-control" name="class" id="class">
						<option value="0">Select Class</option>
						<?php foreach($classes as $class){ ?>
							<option value="<?php echo $class['c_id']; ?>"><?php echo $class['name']; ?></option>
						<?php }?>
						</select>
					</div>
				</div>
				
				<div class="form-group" id="s_group_section" style="display:none;">
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
						<select class="form-control" name="s_group" id="s_group">
						<option value="0">Select Subject Group</option>
							<option value="maths">Maths</option>
							<option value="bio">Bio</option>
							<option value="comm">Commerce</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
					<select class="form-control" name="section[]" id="section" multiple>
					<option value="0">Select Section</option>
					<option value="1">A</option>
					<option value="2">B</option>
					<option value="3">C</option>
					<option value="4">D</option>
					<option value="5">E</option>
					<option value="6">F</option>
					<option value="7">G</option>
					<option value="8">H</option>
					<option value="9">I</option>
					<option value="10">J</option>
					<option value="11">K</option>
					<option value="12">L</option>
					<option value="13">M</option>
					
					</select>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Subjects</label>
					<div class="col-sm-10">
						<div class="form-group">
							<div id="class_subject"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="button" id="form-submit" class="btn pull-right btn-info">Submit</button>
				<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
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
          <h3 class="box-title">All Assign Teacher Subjects</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
				<div class="form-group asign-teacher-sec">
					<label class="col-sm-4 control-label">Assign Teacher Subjects</label>
					<div class="col-sm-8">
						<select class="form-control" id="teacher_select">
						<option value="0">Select Teacher</option>
						<?php foreach($teachers as $teacher){ ?>
							<option value="<?php echo $teacher['t_id']; ?>"><?php echo $teacher['name']; ?></option>
						<?php } ?>
						</select>
					</div>
                </div>
              <table class="table table-hover text-center">
                <tr>
                  <th style="width:5%;">S.No.</th>
                  <th style="width:10%;text-align:left;">Teacher Name</th>
                  <th style="width:7%;">Medium</th>
                  <th style="width:5%;">Class Section</th>
                  <th style="width:5%;">Sub. Groups</th>
<th style="width:30%;text-align:left;">Subjects</th>
                  <th style="width:10%;">Edit/Delete</th>
                </tr>
                <tbody id="teacher_subject_list"></tbody>
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

<script src="<?php echo base_url();?>assest/bootstrap/js/subject_alloc.js"></script>