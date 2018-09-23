<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>assest/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Narayan Yadav</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="<?php echo base_url();?>Svr_ctrl/">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
          <!--<ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>-->
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>MASTER RECORDS</span>
            <span class="pull-right-container">
              <!--<span class="label label-primary pull-right">10</span>-->
			  <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>Svr_ctrl/session_create"><i class="fa fa-circle-o text-aqua"></i> Session Create</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/add_student"><i class="fa fa-circle-o text-aqua"></i> Add Students</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/add_teacher"><i class="fa fa-circle-o text-aqua"></i> Add Teachers</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/add_subject"><i class="fa fa-circle-o text-aqua"></i> Add Subjects </a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/add_exam"><i class="fa fa-circle-o text-aqua"></i> Add Exam</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/add_exam_type"><i class="fa fa-circle-o text-aqua"></i> Add Exam Type</a></li>
            <!--<li><a href="<?php //echo base_url();?>Svr_ctrl/add_class"><i class="fa fa-circle-o text-aqua"></i> Add Classes</a></li>
            <li><a href="<?php //echo base_url();?>Svr_ctrl/add_section"><i class="fa fa-circle-o text-aqua"></i> Add Section</a></li>-->
            <li><a href="<?php echo base_url();?>Svr_ctrl/add_user_role"><i class="fa fa-circle-o text-aqua"></i> Define user role</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/school_details"><i class="fa fa-circle-o text-aqua"></i> School Details</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>TRANSACTION RECORDS</span>
            <span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				<!--<span class="label label-primary pull-right">4</span>
              <small class="label pull-right bg-green">new</small>-->
            </span>
          </a>
		   <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>Svr_ctrl/student_attendance_entry"><i class="fa fa-circle-o text-green"></i> Student Attendance Entry</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/marks_entry"><i class="fa fa-circle-o text-green"></i> Marks Entry</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/compartment_marks_entry"><i class="fa fa-circle-o text-green"></i> Compartment Marks Entry</a></li>
			<li><a href="<?php echo base_url();?>Svr_ctrl/subject_allocation_entry"><i class="fa fa-circle-o text-green"></i> Subject Allocation Entry</a></li>
			<li><a href="<?php echo base_url();?>Svr_ctrl/class_upgradation"><i class="fa fa-circle-o text-green"></i> Class Upgradation</a></li>
		   </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>PRODUCTION REPORTING</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>Svr_ctrl/marks_preview"><i class="fa fa-circle-o text-yellow"></i> Marks Preview </a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/marksheet_generation"><i class="fa fa-circle-o text-yellow"></i> Marksheet Generation</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/compartment_marks_report"><i class="fa fa-circle-o text-yellow"></i> Compartment Marks Report</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/class_wise_marks_report"><i class="fa fa-circle-o text-yellow"></i> Class wise Marks Report </a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>REPORTS(Records)</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li><a href="<?php echo base_url();?>Svr_ctrl/students_report"><i class="fa fa-circle-o text-red"></i> Students Report </a></li>
			<li><a href="<?php echo base_url();?>Svr_ctrl/teachers_report"><i class="fa fa-circle-o text-red"></i> Teachers Report </a></li>
			<li><a href="<?php echo base_url();?>Svr_ctrl/teachers_abstract"><i class="fa fa-circle-o text-red"></i> Teachers Abstract </a></li>
			<li><a href="<?php echo base_url();?>Svr_ctrl/subject_allocation_report"><i class="fa fa-circle-o text-red"></i> Subject Allocation Report</a></li>
			<li><a href="<?php echo base_url();?>Svr_ctrl/log_report"><i class="fa fa-circle-o text-red"></i> Log Report</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>UTILITIES & TOOLS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>Svr_ctrl/upload_photo"><i class="fa fa-circle-o text-aqua"></i> Photo Upload</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/import_data"><i class="fa fa-circle-o text-aqua"></i> Import Data </a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/export_data"><i class="fa fa-circle-o text-aqua"></i> Export Data</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/session_update"><i class="fa fa-circle-o text-aqua"></i> Session Update</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/database_backup"><i class="fa fa-circle-o text-aqua"></i> Database Backup</a></li>
            <li><a href="<?php echo base_url();?>Svr_ctrl/change_password"><i class="fa fa-circle-o text-aqua"></i> Change Password</a></li>
          </ul>
        </li>
        
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <!--<li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>-->

        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>