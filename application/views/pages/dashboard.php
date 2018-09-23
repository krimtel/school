<div class="content-wrapper dashboard-content">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="border-bottom:1px solid #ddd;padding-bottom:20px;">
      <h1>Dashboard Section</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
<!------------------------------------------------------------------------------------->	
<div class="col-md-12" id="exTab3" style="margin-top:30px;">	
	<ul class="nav nav-pills">
		<li class="active master"><a href="#1b" data-toggle="tab">MASTER RECORDS</a></li>
		<li class="trans"><a href="#2b" data-toggle="tab">TRANSACTION RECORDS</a></li>
		<li class="prod"><a href="#3b" data-toggle="tab">PRODUCTION REPORTING</a></li>
		<li class="repor"><a href="#4b" data-toggle="tab">REPORTS(Records)</a></li>
		<li class="tool"><a href="#5b" data-toggle="tab"> UTILITIES & TOOLS</a></li>
	</ul>

<div class="tab-content clearfix">
	<div class="tab-pane active content" id="1b">
		<div class="row">
			<?php if($power == 5){ ?>
				<div class="col-lg-3 col-xs-6">
					<div class="small-box bg-red">
						<div class="inner">
							<h3>2</h3>
							<h4>Session</h4>
						</div>
						<div class="icon">
							<img src="<?php echo base_url();?>assest/images/dash/session-icon.png" />
						</div>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/session" class="small-box-footer"><h4>Session Create <i class="fa fa-arrow-circle-right"></i></h4> </a>
					</div>
				</div>
			<?php } ?>

			<?php if($power == 3 || $power == 1 || $power == 5){ ?>
				<div class="col-lg-3 col-xs-6">
					<div class="small-box bg-red">
						<div class="inner">
							<h3>1100</h3>
							<h4>Students</h4>
						</div>
						<div class="icon">
							<img src="<?php echo base_url();?>assest/images/dash/student-icon.png" />
						</div>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/add-student" class="small-box-footer"><h4>Add Students <i class="fa fa-arrow-circle-right"></i></h4></a>
					</div>
				</div>
			<?php } ?>

			<?php if($power == 5){ ?>
				<div class="col-lg-3 col-xs-6">
					<div class="small-box bg-red">
						<div class="inner">
							<h3>80</h3>
							<h4>Teachers</h4>
						</div>
						<div class="icon">
							<img src="<?php echo base_url();?>assest/images/dash/teacher-icon.png" />
						</div>
							<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/add-teacher" class="small-box-footer"><h4>Add Teachers <i class="fa fa-arrow-circle-right"></i></h4></a>
					</div>
				</div>
			<?php } ?>

			<?php if($power == 5){ ?>
				<div class="col-lg-3 col-xs-6">
					<div class="small-box bg-red">
						<div class="inner">
							<h3>10</h3>
							<h4>Subjects</h4>
						</div>
						<div class="icon">
							<img src="<?php echo base_url();?>assest/images/dash/sub-icon.png" />
						</div>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/add-subject" class="small-box-footer"><h4>Add Subjects <i class="fa fa-arrow-circle-right"></i></h4></a>
					</div>
				</div>
			<?php } ?>
		</div>
		
		<?php if($power == 5){ ?>
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>12</h3>
						<h4>Subject Allocation</h4>
					</div>
					<div class="icon">
						<img src="<?php echo base_url();?>assest/images/dash/exam-icon.png" />
					</div>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/class_subjects" class="small-box-footer"><h4>Classwise Subject Allocation<i class="fa fa-arrow-circle-right"></i></h4> </a>
				</div>
			</div>
			
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>4</h3>
						<h4>Exams</h4>
					</div>
					<div class="icon">
						<img src="<?php echo base_url();?>assest/images/dash/exam-icon.png" />
					</div>
					<a href="<?php echo base_url();?>Svr_ctrl/add_exam" class="small-box-footer"><h4>Add Exam <i class="fa fa-arrow-circle-right"></i></h4> </a>
				</div>
			</div> 
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>3</h3>
						<h4>Exam Type</h4>
					</div>
					<div class="icon">
						<img src="<?php echo base_url();?>assest/images/dash/exam-type-icon.png" />
					</div>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/exam-type" class="small-box-footer"><h4>Add Exam Type <i class="fa fa-arrow-circle-right"></i></h4></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>70</h3>
						<h4>Users Role</h4>
					</div>
					<div class="icon">
						<img src="<?php echo base_url();?>assest/images/dash/user-role-icon.png" />
					</div>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/add-user" class="small-box-footer"><h4>Define user role <i class="fa fa-arrow-circle-right"></i></h4></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6 hidden">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>2</h3>
						<h4>School</h4>
					</div>
					<div class="icon">
						<img src="<?php echo base_url();?>assest/images/dash/school-icon.png" />
					</div>
					<a href="<?php echo base_url();?>Svr_ctrl/school_details" class="small-box-footer"><h4>School Details <i class="fa fa-arrow-circle-right"></i></h4></a>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if($power == 5){ ?>
		<div class="row">
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>50</h3>
						<h4>Class Teacher</h4>
					</div>
					<div class="icon">
						<img src="<?php echo base_url();?>assest/images/dash/exam-icon.png" />
					</div>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/class-teacher" class="small-box-footer"><h4>Class Teacher<i class="fa fa-arrow-circle-right"></i></h4> </a>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
<div class="tab-pane content" id="2b">
<?php if($power == 3 || $power == 1 || $power == 5){ ?> 
<div class="row">
        <?php if($power == 5){ ?>
		<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>4 Terms</h3>
              <h4>Attendance Entry</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/student-att-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/attendence-entry" class="small-box-footer"><h4>All Terms Attendance Entry <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		<?php } ?>
		<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>150 Days</h3>
              <h4>Attendance</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/student-att-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/attendance" class="small-box-footer"><h4>Student Attendance Entry <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <?php if($power == 5 || $power == 2 || $power == 3){ ?>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>50<sup style="font-size: 20px">%</sup></h3>
              <h4>Marks</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/student-marks-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/marks_entry" class="small-box-footer"><h4>Marks Entry  <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>50<sup style="font-size: 20px">%</sup></h3>
              <h4>Marks</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/student-marks-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/marks_entry_high_class" class="small-box-footer"><h4>11-12 Marks Entry  <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <?php } ?>
        <?php if($power == 5){ ?>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>20</h3>
              <h4>Subject Allocation</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/sub-alloc-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/subject-allocation" class="small-box-footer"><h4>Subject Allocation Entry <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <?php } ?>
        <?php /* ?>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>0<sup style="font-size: 20px">%</sup></h3>
              <h4>Compartment Marks</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/student-marks-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/compartment_marks_entry" class="small-box-footer"><h4>Compartment Marks Entry <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <?php */ ?>
      </div>
      
	  <div class="row">
	  	<?php /* ?>
		<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>0<sup style="font-size: 20px">%</sup></h3>
              <h4>Class Upgradation</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/class-update-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/class_upgradation" class="small-box-footer"><h4>Class Upgradation <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <?php */ ?>
	  </div>
	  
<?php } ?>
	</div>
<div class="tab-pane content" id="3b">

<div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>150</h3>
              <h4>Marks Preview</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/marks-gene-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/mark-preview" class="small-box-footer"><h4>Marks Preview <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>53</h3>
              <h4>Marksheet Generation</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/marks-gene-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/marksheet_generation" class="small-box-footer"><h4>Marksheet Generation <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		<?php if($entry_11_12){ ?>
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
            <div class="inner">
              <h3>150</h3>
              <h4>11-12 Marks Preview</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/marks-gene-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/mark-preview" class="small-box-footer"><h4>11-12 Marks Preview <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>150</h3>
              <h4>11-12 Marksheet Generation</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/marks-gene-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/high-class-marksheet-generation" class="small-box-footer"><h4>11-12 Marksheet Generation <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		<?php } ?>
	</div>
	<div class="row">
	<?php if($power == 5){ ?>
		<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>50%</h3>
              <h4>Marks Entry Check</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/marks-gene-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/marks-entry-check" class="small-box-footer"><h4>Marks Entry Check <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		<?php } ?>
<?php if($power == 3 || $power == 1 || $power == 5){ ?> 
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>
              <h4>Compartment Marks Report</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/marks-gene-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/compartment_marks_report" class="small-box-footer"><h4>Compartment Marks Report <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>53</h3>
              <h4>Class wise Marks Report</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/marks-gene-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/class_wise_marks_report" class="small-box-footer"><h4>Class wise Marks Report <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
<?php } ?>
      </div>

</div>
<div class="tab-pane content" id="4b">

 <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroonm">
            <div class="inner">
              <h3>1100</h3>

              <h4>Students Records</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/student-search-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/reports/students-record" class="small-box-footer"><h4>Students Records <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
<?php if($power == 5){ ?> 
        <!-- ./col -->
		<div class="col-lg-3 col-xs-6">
           <div class="small-box bg-maroonm">
            <div class="inner">
              <h3>65</h3>
              <h4>Teacher Abstract Records</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/teacher-abst-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/reports/teachers_abstract" class="small-box-footer"><h4>Teacher Abstract Records <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <?php if($power == 5){ ?>	
		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroonm">
            <div class="inner">
              <h3>44</h3>

              <h4>Log Report</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/log-report-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/log_report" class="small-box-footer"><h4>Log Report <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		<?php } ?>
        <!-- ./col -->
        <?php /* <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroonm">
            <div class="inner">
              <h3>80</h3>
              <h4>Teachers Records</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/teacher-search-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/teachers_report" class="small-box-footer"><h4>Teachers Records  <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-maroonm">
            <div class="inner">
              <h3>65</h3>
              <h4>Subject Allocation Records</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/sub-alloc-re-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/subject_allocation_report" class="small-box-footer"><h4>Subject Allocation Records <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div> */ ?>
<?php } ?>
      </div>

	</div>
	<div class="tab-pane content" id="5b">
<?php if($power == 5){ ?> 
<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>1100</h3>

              <h4>Photos</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/upload-photo-icon.png" />
            </div>
            <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/utility_tool/upload_photo" class="small-box-footer"><h4>Photo Upload <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>53</h3>

              <h4>Import Data(Student & Teacher)</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/data-import-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/import_data" class="small-box-footer"><h4>Import Data <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>44</h3>

              <h4>Export Data</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/export-data-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/export_data" class="small-box-footer"><h4>Export Data <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>65</h3>

              <h4>Session Update</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/session-up-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/session_update" class="small-box-footer"><h4>Session Update  <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
	  <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <h4>Database Backup</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/db-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/database_backup" class="small-box-footer"><h4>Database Backup <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <h4>Change Password</h4>
            </div>
            <div class="icon">
              <img src="<?php echo base_url();?>assest/images/dash/change-pass-icon.png" />
            </div>
            <a href="<?php echo base_url();?>Svr_ctrl/change_password" class="small-box-footer"><h4>Change Password <i class="fa fa-arrow-circle-right"></i></h4></a>
          </div>
        </div>
        <!-- ./col -->
		</div>
	</div>
<?php } ?>
</div>
</div>
<!------------------------------------------------------------------------------------->	
  </div>