<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Annual Marksheet Generation 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Annual Marksheet Generation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Search Annual Marksheet</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Session</label>
					<div class="col-sm-10">
						<select class="form-control" id="session">
							<option value="0">Select Session</option>
							<?php foreach($sessions as $session){ ?>
								<?php if($session['status'] == 1){?>
									<option value="<?php echo $session['session_id']; ?>" selected><?php echo $session['name']; ?></option>
								<?php } else {?>
									<option value="<?php echo $session['session_id']; ?>"><?php echo $session['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div id="session_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Medium</label>
					<div class="col-sm-10">
						<?php if(isset($medium)){?>
							<select class="form-control" id="medium">
								<option value="<?php echo $medium; ?>"><?php echo $medium; ?></option>
							</select>
						<?php } else {?>
						<select class="form-control" id="medium">
							<option value="0">Select Medium</option>
							<option value="Hindi">Hindi</option>
							<option value="English">English</option>
						</select>
						<?php } ?>
						<div id="medium_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Class</label>
					<div class="col-sm-10">
						<select class="form-control" id="class">
						<option value="0">Select Class</option>
							<?php foreach($classes as $class){ ?>
								<option value="<?php echo $class['c_id']?>"><?php echo $class['name']; ?></option>
							<?php } ?>
						</select>
						<div id="class_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
					<select class="form-control" id="section">
						<option value="0">Select Section</option>
					</select>
					<div id="section_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4" id="subject_group" style="display: none;">
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
						<select class="form-control" id="s_group">
							<option value="0" selected>Select Subject group</option>
							<option value="Maths">Maths</option>
							<option value="Boilogy">Biology</option>
							<option value="Commerce">Commerce</option>
							<option value="Arts">Arts</option>
						</select>
						<div class="text-danger" id="s_group_err" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4" id="fit_section" style="display: none;">
                    <label class="col-sm-2 control-label">Foit</label>
					<div class="col-sm-10">
						<select class="form-control" id="fit">
							<option value="0" selected>Select fit</option>
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
						<div class="text-danger" id="fit_err" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4" id="elective_section" style="display: none;">
                    <label class="col-sm-2 control-label">Elective Subject</label>
					<div class="col-sm-10">
						<select class="form-control" id="elective">
						<option value="0">Select Elective subject</option>
							<?php foreach($electives as $elective){ ?>
								 <option value="<?php echo $elective['sub_id']; ?>"><?php echo $elective['name']; ?></option>
							<?php } ?>
						</select>
						<div class="text-danger" id="elective_err" style="display:none;"></div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<a class="btn pull-right btn-info" id="mid_term_marksheet">Mid Term Marksheet</a> 
				<a class="btn pull-right btn-info btn-space" id="full_multi_marksheet">Full Marksheet</a> 
				<button type="button" id="form_submit" class="btn pull-right btn-info btn-space">Search</button> 
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
          <h3 class="box-title">All Marksheet</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">  
               <div class="form-group col-sm-6" style="margin-top:20px;">
                  <label class="col-sm-2 control-label">Search </label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="search" placeholder="Ex. student name, roll no., admission no.">
                  </div>
                </div>
			   
			   <table class="table table-hover text-center">
                <thead><tr>
                  <th>S.No.</th>
                  <th style="text-align:left;">Student Name</th>
                  <th>Roll No.</th>
                  <th>Admission No.</th>
                  <th>Mid Term Marksheet</th>
                  <th>Full Marksheet</th>
                </tr></thead>
                <tbody id="student_list"></tbody>
              </table>
            </div>
      </div>
        </section>
      </div>
    </section>
  </div>
<script>
	
</script>
<script src="<?php echo base_url();?>assest/bootstrap/js/mark_sheet_genration.js"></script>