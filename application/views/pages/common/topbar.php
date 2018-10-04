<header class="main-header">
    <nav class="navbar navbar-static-top">
		<div class="sv-logo" style="float:left;">
		
		<?php if($this->uri->segment(1) == 'shakuntala') { ?>
			<img src="<?php echo base_url();?>assest/images/shakuntala/header-logo.png" />
		<?php } else { ?>	
			<img src="<?php echo base_url();?>assest/images/sharda/header-logo.png" />
		<?php } ?>
			
		</div>

      <div class="navbar-custom-menu" style="margin-top:12px;">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             <?php 
                    $uid = $this->session->userdata('user_id');
                    
                    $this->db->select('uid,t_id');
                    $reuslt = $this->db->get_where('users', array('uid'=>$uid))->result_array();
                    $t_id = $reuslt[0]['t_id']; 
                    
                    $this->db->select('*');
                    $t_data = $this->db->get_where('teacher', array('t_id' => $t_id))->result_array();
             
                    $school = strtolower($this->session->userdata('school'));
                ?>
            
              <img src="<?php echo base_url() .'/photos/teachers/'.$school.'/'.$t_data[0]['photo'];?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('uname'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url() .'/photos/teachers/'.$school.'/'.$t_data[0]['photo'];?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo $this->session->userdata('uname'); ?>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
<a href="<?php echo base_url();?>/Admin_ctrl/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>
  <div>
  <nav class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
<a data-target="#navbarCollapse"  data-toggle="collapse" class="nav-menu-col desktop-hide">Menu</a>
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- Collection of nav links, forms, and other content for toggling -->
    <div id="navbarCollapse" class="collapse navbar-collapse">
<ul class="nav navbar-nav menu-section1">
	<li>
		<?php if($this->uri->segment(2) == 'dashboard'){ $x = 'nav-active';}else{$x = '';} ?>
		<a class="<?php echo $x; ?>" href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"> 
		<i class="fa fa-home" aria-hidden="true"></i> HOME </a>
	</li>
	<?php if($class_teacher){ ?>
		<li class="dropdown <?php if($this->uri->segment(2) == 'master-record'){  echo 'nav-active';} ?>">
			<a href="" href="#" data-toggle="dropdown" > <i class="fa fa-files-o"></i> MASTER RECORDS <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<?php if($power == 5){ ?>
					<li>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/session">
						<i class="fa fa-circle-o text-aqua"></i> Session Create</a>
					</li>
				<?php } ?>
				<?php if($power == 3 || $power == 1 || $power == 5){ ?>
					<li>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/add-student">
						<i class="fa fa-circle-o text-aqua"></i> Add Students</a>
					</li>
				<?php } ?>
				<?php if($power == 5){ ?>
					<li>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/add-teacher">
						<i class="fa fa-circle-o text-aqua"></i> Add Teachers</a>
					</li>
				<?php } ?>
				<?php if($power == 5){ ?>
					<li>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/add-subject">
						<i class="fa fa-circle-o text-aqua"></i> Add Subjects </a>
					</li>
				<?php } ?>
				<?php if($power == 5){ ?>
					<li>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/class_subjects">
						<i class="fa fa-circle-o text-aqua"></i>Classwise Subject Allocation </a>
					</li>
				<?php } ?>
				<?php if($power == 5){ ?>
					<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/add_exam"><i class="fa fa-circle-o text-aqua"></i> Add Exam</a></li>
					<li>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/exam-type">
						<i class="fa fa-circle-o text-aqua"></i> Add Exam Type</a>
					</li>
					<li>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/add-user">
						<i class="fa fa-circle-o text-aqua"></i> Define User role</a>
					</li>
					<li>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/master-record/class-teacher">
						<i class="fa fa-circle-o text-aqua"></i> Class Teacher</a>
					</li>
					<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/school_details"><i class="fa fa-circle-o text-aqua"></i> School Details</a></li>
				<?php } ?>
			</ul>
		</li>
	<?php } ?>
	<li class="dropdown <?php if($this->uri->segment(2) == 'transaction-record'){  echo 'nav-active';} ?>">
		<a href="" href="#" data-toggle="dropdown" > <i class="fa fa-th"></i> TRANSACTION RECORDS <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<?php if($power == 5){ ?>
			<li>
				<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/attendence-entry">
				<i class="fa fa-circle-o text-green"></i>Attendance Entry</a>
			</li>
			<?php } ?>
			<?php if($class_teacher){ ?>
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/attendance">
					<i class="fa fa-circle-o text-green"></i>Student Attendance Entry</a>
				</li>
			<?php } ?>
			<?php if($power == 5 || $power == 2 || $power == 3 ){ ?>
				<?php if($entry_1_10){ ?>
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/marks_entry">
					<i class="fa fa-circle-o text-green"></i> Marks Entry</a>
				</li>
				
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/compart_marks_entry">
					<i class="fa fa-circle-o text-green"></i>Compart Marks Entry</a>
				</li>
				<?php } ?>
				<?php if($entry_11_12){ ?>
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/marks_entry_high_class">
					<i class="fa fa-circle-o text-green"></i> 11-12 Marks Entry</a>
				</li>
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/compart_marks_entry_high_class">
					<i class="fa fa-circle-o text-green"></i>Compart 11-12 Marks Entry</a>
				</li>
				<?php } ?>
			<?php } ?>
            <li style="display: none;">
				<a href="#">
				<i class="fa fa-circle-o text-green"></i> Compartment Marks Entry</a>
			</li>
			<?php if($power == 5){ ?>
			<li>
				<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/transaction-record/subject-allocation">
				<i class="fa fa-circle-o text-green"></i> Subject Allocation Entry</a>
			</li>
			<?php } ?>
			<li style="display: none;">
				<a href="<?php echo base_url();?>Svr_ctrl/class_upgradation">
				<i class="fa fa-circle-o text-green"></i> Class Upgradation</a>
			</li>
		</ul>
	</li>
	<?php if($class_teacher){ ?>
		<li class="dropdown <?php if($this->uri->segment(2) == 'production-reporting'){  echo 'nav-active';} ?>">
			<a href="" href="#" data-toggle="dropdown" > <i class="fa fa-pie-chart"></i> PRODUCTION REPORTING <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/mark-preview">
					<i class="fa fa-circle-o text-yellow"></i> Marks Preview </a>
				</li>
				
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/mark-preview-high-class">
					<i class="fa fa-circle-o text-yellow"></i>11-12 Marks Preview </a>
				</li>
				
				<?php if($power == 5){ ?>
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/marks-entry-check">
					<i class="fa fa-circle-o text-yellow"></i> Marks Entry check</a>
				</li>
				
					<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/marks-entry-check-high-class">
					<i class="fa fa-circle-o text-yellow"></i> Marks Entry check 11th-12th</a>
				</li>
				<?php } ?>
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/marksheet_generation">
					<i class="fa fa-circle-o text-yellow"></i> Marksheet Generation</a>
				</li>
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/compart_marksheet_generation">
					<i class="fa fa-circle-o text-yellow"></i>Compartment Marksheet Generation</a>
				</li>
				<?php if($entry_11_12){ ?>
				<li style="display:block;">
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/high-class-marksheet-generation">
					<i class="fa fa-circle-o text-yellow"></i> 11-12 Marksheet Generation</a>
				</li>
				<li style="display:block;">
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/production-reporting/compart_high-class-marksheet-generation">
					<i class="fa fa-circle-o text-yellow"></i> 11-12 Compartment Marksheet Generation</a>
				</li>
				<?php } ?>
				<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/compartment_marks_report"><i class="fa fa-circle-o text-yellow"></i> Compartment Marks Report</a></li>
				<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/class_wise_marks_report"><i class="fa fa-circle-o text-yellow"></i> Class wise Marks Report </a></li>
			</ul>
		</li>
	<?php } ?>
	<?php if($class_teacher){ ?>
		<li class="dropdown <?php if($this->uri->segment(2) == 'reports'){  echo 'nav-active';} ?>">
		<a href="" href="#" data-toggle="dropdown"> <i class="fa fa-laptop"></i> REPORTS(Records) <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/reports/students-record">
					<i class="fa fa-circle-o text-red"></i> Students Record </a>
				</li>
				<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/teachers_report"><i class="fa fa-circle-o text-red"></i> Teachers Record </a></li>
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/reports/teachers_abstract">
					<i class="fa fa-circle-o text-red"></i> Teachers Abstract </a>
				</li>
				<?php if($power == 5){ ?>			
					<li>
						<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/reports/log-report">
						<i class="fa fa-circle-o text-red"></i> Log Report</a>
					</li>
				<?php } ?>
			</ul>
		</li>
	<?php } ?>
	<?php if($class_teacher){ ?>
		<li class="dropdown <?php if($this->uri->segment(2) == 'utility_tool'){  echo 'nav-active';} ?>">
		<a href="" href="#" data-toggle="dropdown"> <i class="fa fa-edit"></i> UTILITIES & TOOLS <b class="caret"></b></a>
			<ul class="dropdown-menu">
	<?php if($power == 5){ ?>			
	<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/utility_tool/upload_photo">
					<i class="fa fa-circle-o text-aqua"></i> Photo Upload</a>
				</li>
	<?php } ?>
				<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/import_data"><i class="fa fa-circle-o text-aqua"></i> Import Data </a></li>
				<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/export_data"><i class="fa fa-circle-o text-aqua"></i> Export Data</a></li>
				<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/session_update"><i class="fa fa-circle-o text-aqua"></i> Session Update</a></li>
				<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/database_backup"><i class="fa fa-circle-o text-aqua"></i> Database Backup</a></li>
				<li style="display: none;"><a href="<?php echo base_url();?>Svr_ctrl/change_password"><i class="fa fa-circle-o text-aqua"></i> Change Password</a></li>
			</ul>
		</li>
	<?php } ?>
	
	<?php if($power == 5 || $power == 3){ ?>
	<li class="dropdown">
		<a href="" href="#" data-toggle="dropdown"> <i class="fa fa-"></i> Health Activity <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/health_activity">
					<i class="fa fa-circle-o text-aqua"></i>Health record</a>
				</li>			
				<li>
					<a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/general_info">
					<i class="fa fa-circle-o text-aqua"></i>General Information</a>
				</li>
			</ul>
		</li>
	<?php } ?>
	
	<li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/logout">LOGOUT</a></li>

</ul>


    </div>
</nav>
  </div>