<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Marks Entry
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Marks Entry</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add/Update New Marks</h3>
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
                            <select class="form-control" id="medium">
								<option value="0">Select Medium</option>
                                <?php foreach($medium_list as $list){?>
                                <option value="<?php echo $list['medium_id']?>"><?php echo $list['name']?></option>
								<?php }?>
							</select>
						
						<div class="text-danger" id="medium_err" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Exam Type</label>
					<div class="col-sm-10">
						<select class="form-control" id="e_type">
							<option value="0">Select Exam Type</option>
							<?php foreach($exam_type_list as $exam_type){ ?>
								<option value="<?php echo $exam_type['exam_type_id'];?>"><?php echo $exam_type['name']; ?>, (<?php echo $exam_type['term_name']?>)</option>
							<?php } ?>
						</select>
						<div id="e_type_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Class</label>
					<div class="col-sm-10">
						<select class="form-control" name="class" id="class">
							<option value="0">Select Class</option>
							<?php foreach($class_list as $class){ ?>
								<option value="<?php echo $class['c_id']; ?>"><?php echo $class['name']; ?></option>
							<?php } ?>
						</select>
						<div id="class_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
						<select class="form-control" name="section" id="section">
							<option value="0">Select Section</option>
                            <?php foreach($section_list as $section){ ?>
								<option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
							<?php } ?>
						</select>
						<div id="section_err" class="text-danger" style="display:none;"></div>
					</div>
				</div> 
                
                
				<div class="form-group" id="subject_section">
                    <label class="col-sm-2 control-label">Select Subject</label>
					<div class="col-sm-10">
					<select class="form-control" id="s_group">
						<option value="0">Select Subject</option>
                          <?php foreach($subject_list as $subject){ ?>
								<option value="<?php echo $subject['sub_id']; ?>"><?php echo $subject['sub_name'];?>, (<?php echo $subject['sub_type']?>)</option>
							<?php } ?>
					</select>
					</div>
				</div>
			</div>

			<div class="box-footer">
				<button type="button" id="fetch_student" class="btn pull-right btn-info">Search</button>
				<button type="reset" class="btn btn-default pull-right btn-space">Clear</button>
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
          <h3 class="box-title">Edit/Update Marks</h3>
          <div style="color:#0183f4;">
          	<span id="max_mark" style="display: none;">0</span>
          	<span id="max_notebook" style="display: none;">0</span>
          	<span id="max_enrich" style="display: none;">0</span>
          	<span id="max_practical" style="display: none;">0</span>
          	</div>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <form role="form" class="form-horizontal">
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover text-center t-input-center">
                <thead>
	                <tr>
	                  <th>S.No.</th>
	                   <th>Student Name</th>
					  <th>Class/Section</th>
					  <th>Addmission No.</th>
					  <th>Roll No.</th>
	                  <th>Marks</th>
	                  <th class="notebook" style="display:none;">Notebook</th>
	                  <th class="notebook" style="display:none;">Subject Enrichment</th>
	                  <th class="practical" style="display:none;">Practical</th>
	                </tr>
                </thead>
                <tbody id="student_list"></tbody>
              </table>
            </div>
			<div class="box-footer">
				<button type="button" id="subject_mark"  class="buttons btn pull-right btn-info" style="display: none;">Submit</button>
				<button type="reset" class="buttons btn btn-default pull-right btn-space" style="display: none;">Cancel</button>
            </div>
		</form>
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