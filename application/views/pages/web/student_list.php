<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Students Reports
</h1>
 
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Students Reports</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
<!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Search Students Reports/Records</h3>
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
						<?php if(isset($medium)){ ?>
							<select class="form-control" id="medium">
								<option value="<?php echo $medium; ?>" selected><?php echo $medium; ?></option>
							</select>
						<?php } else{ ?>
						<select class="form-control" id="medium">
							<option value="0">Select Medium</option>
							<option value="Hindi">Hindi</option>
							<option value="English">English</option>
						</select>
						<?php } ?>
						<div class="text-danger" id="medium_err" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Class</label>
					<div class="col-sm-10">
						<select class="form-control" id="class">
						<option value="0">Select Class</option>
							<?php foreach($classes as $class){ ?>
								 <option value="<?php echo $class['c_id']; ?>"><?php echo $class['name']; ?></option>
							<?php } ?>
						</select>
						<div class="text-danger" id="class_err" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
					<select class="form-control" id="section">
						<option value="0">Select Section</option>
					</select>
					<div class="text-danger" id="section_err" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4" id="subject_group" style="display: none;">
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
						<select class="form-control" id="s_group">
							<option value="0" selected>Select Subject Group</option>
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
							<option value="0" selected>Select Fit</option>
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
						<option value="0">Select Elective Subject</option>
							<?php foreach($electives as $elective){ ?>
								 <option value="<?php echo $elective['sub_id']; ?>"><?php echo $elective['name']; ?></option>
							<?php } ?>
						</select>
						<div class="text-danger" id="elective_err" style="display:none;"></div>
					</div>
				</div>
			</div>
            <div class="box-footer">
				<a class="btn pull-right btn-info" id="export-to-excel">Export to Exel</a> 
				<button type="button" id="form_submit" class="btn pull-right btn-info btn-space">Search</button> 
				<button type="reset" class="btn btn-default pull-right btn-space">Clear</button>
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
          <h3 class="box-title">All Students Reports</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
		
	<div class="box-body table-responsive no-padding">
              <div class="form-group col-sm-6" style="margin-top:20px;">
                  <label class="col-sm-2 control-label">Search </label>
                  <div class="col-sm-10">
                  	<input type="text" id="search" class="form-control" placeholder="Ex. student name, roll no., admission no.">
                  </div>
                </div>
			  <table class="table table-hover table-striped student-records-list-h text-center">
                <thead><tr>
                  <th>S.No.</th>
                  <th>Edit/Del.</th>
                  <th>Image</th>
                  <th>Aadhar No</th>
                  <th>Student Name</th>
                  <th>Class/Section</th>
	              <th class="fit" style="display: none;">Fit</th>
                  <th class="sub_group" style="display: none;">Subject Group</th>
                  <th class="sub_group" style="display: none;">Elective Subject</th>
				  <th>Medium</th>
                  <th>Roll No.</th>
                  <th>Admission No.</th>
                  <th>Admission Date</th>
                  <th>Father's Name</th>
                  <th>Mother's Name</th>
                  <th>DOB</th>
                  <th>Gender</th>
                  <th>Address</th>
                  <th>Contact No.</th>
                  <th>House</th>
                  <th>Hostler</th>
                  <th>Blood Grp.</th>
                  <th>Caste</th>
                  <th>Height</th>
                  <th>Weight</th>
                  <th>Email Id</th>
                  <th>Guardian</th>
                  <th>Local Address</th>
                  <th>Medical</th>
                  <th>Tc</th>
                </tr>
                </thead>
                <tbody class="student-records-list" id="student_list"></tbody>
              </table>
            </div>
      </div>
        </section>
      </div>
    </section>
  </div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form id="student_update_form" class="form-horizontal" name="f1" method="POST" action="<?php echo base_url(); ?>Student_ctrl/student_update/">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center" id="exampleModalLabel"><b>Student Detail</b></h4>
      </div>
      <div class="modal-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Admission No.</label>
                  <div class="col-sm-10">
					<input type="hidden" id="stu_id" name="stu_id" value="">
					<input type="text" name="admission_no" id="stu_new_admission_no" class="form-control" placeholder="Enter admission no.">
					<div id="stu_admission_no_err" class="text-danger" style="display:none;"></div>
				</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Roll No.</label>
                  <div class="col-sm-10">
					<input type="text" name="roll_no" id="stu_roll_no" class="form-control" placeholder="Enter roll no.">
					<div id="stu_roll_no_err" class="text-danger" style="display:none;"></div>
				  </div>
                </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Student Name</label>
						<div class="col-sm-10">
							<input type="text" name="student_name" id="stu_student_name" class="form-control" placeholder="Enter student name">
							<div id="stu_student_name_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Medium</label>
						<div class="col-sm-10">
							<select class="form-control" name="medium" id="stu_medium">
								<option value="0">Select Medium</option>
								<option value="Hindi">Hindi</option>
								<option value="English">English</option>
							</select>
							<div id="stu_medium_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Class</label>
						<div class="col-sm-10">
							<select class="form-control" name="class" id="stu_class">
								<option value="0">Select Class</option>
								<option value="1">NURSERY</option>
								<option value="2">LKG</option>
								<option value="3">UKG</option>
								<option value="4">I</option>
								<option value="5">II</option>
								<option value="6">III</option>
								<option value="7">IV</option>
								<option value="8">V</option>
								<option value="9">VI</option>
								<option value="10">VII</option>
								<option value="11">VIII</option>
								<option value="12">IX</option>
								<option value="13">X</option>
								<option value="14">XI</option>
								<option value="15">XII</option>
							</select>
							<div id="stu_class_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
					<select class="form-control" name="section" id="stu_section">
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
					<div id="stu_section_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group" id="stu_fit_section" style="display:none;">
                    <label class="col-sm-2 control-label">FIT</label>
					<div class="col-sm-10">
					<select class="form-control" name="fit" id="stu_fit">
						<option value="0">Select FIT</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
					<div id="stu_fit_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group" id="stu_elective_section" style="display:none;">
                    <label class="col-sm-2 control-label">Elective Subject</label>
					<div class="col-sm-10">
					<select class="form-control" name="elective" id="stu_elective_subject">
						<option value="0">Select Elective Subject</option>
						<option value="23">Computer Science</option>
						<option value="26">Hindi</option>
						<option value="27">PE</option>
						<option value="28">Maths</option>
					</select>
					<div id="stu_elective_subject_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group" id="stu_sub_group_section" style="display:none;">
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
					<select class="form-control" name="subject_group" id="stu_subject_group">
						<option value="0" selected="">None</option>
						<option value="Maths">Maths</option>
						<option value="Boilogy">Boilogy</option>
						<option value="Commerce">Commerce</option>
						<option value="Arts">Arts</option>
					</select>
					<div id="stu_subject_group_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Father's Name</label>
					<div class="col-sm-10">
						<input type="text" name="father_name" id="stu_father_name" class="form-control" placeholder="Enter father's name">
						<div id="stu_father_name_err" class="text-danger" style="display:none;"></div>
					</div>
				  
                </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Mother's Name</label>
					<div class="col-sm-10">
						<input type="text" name="mother_name" id="stu_mother_name" class="form-control" placeholder="Enter mother's name">
						<div id="stu_mother_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Date Of Birth</label>
					<div class="col-sm-10">
					<div class="input-group ">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
<!-- 					  <input type="text" class="form-control pull-right" id="datepicker" name="dob">  -->
							<input type="text" class="form-control pull-right" id="DOBdate" name="dob">
					</div>
					<div id="datepicker_err" class="text-danger" style="display:none;"></div> 
					</div>
					<!-- /.input group -->
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>
					<div class="col-sm-10">
					<select class="form-control" id="stu_gender" name="stu_sex">
						<option value="0">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
					 <div id="stu_gender_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Date of Admission</label>
					<div class="col-sm-10">
					<div class="input-group ">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
<!-- 					  <input type="text" class="form-control pull-right" id="datepicker2" name="admission_date"> -->
							<input type="text" class="form-control pull-right" id="ADdate" name="admission_date">
					</div>
					<div id="datepicker2_err" class="text-danger" style="display:none;"></div>
					</div>
					<!-- /.input group -->
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Caste</label>
					<div class="col-sm-10">
					<select class="form-control" name="caste" id="stu_caste">
						<option value="0">Select Caste</option>
						<option value="General">General</option>
						<option value="OBC">OBC</option>
						<option value="ST">ST</option>
						<option value="SC">SC</option>
					</select>
					<div id="stu_caste_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Blood Group</label>
					<div class="col-sm-10">
					<select class="form-control" name="blood" id="stu_blood">
						<option value="0">Select Blood Group</option>
						<option value="A+">A+</option>
						<option value="A-">A-</option>
						<option value="B+">B+</option>
						<option value="B-">B-</option>
						<option value="O+">O+</option>
						<option value="O-">O-</option>
						<option value="AB+">AB+</option>
						<option value="AB-">AB-</option>
					</select>
					<div id="stu_blood_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Aadhaar Card Number</label>
					<div class="col-sm-10">
						<input type="text" name="aadhaar" id="stu_aadhaar" class="form-control" placeholder="Enter aadhaar card no." maxlength="12">
						<div id="stu_aadhaar_err" class="text-danger" style="display:none;"></div>
					</div>
                  
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Permanent Address</label>
					<div class="col-sm-10">
						<textarea name="address" id="stu_address" class="form-control" rows="3" placeholder="Enter permanent address"></textarea>
						<div id="stu_address_err" class="text-danger" style="display:none;"></div>
					</div>
                  
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Guardian Name</label>
					<div class="col-sm-10">
						<input type="text" name="guardian" id="stu_guardian" class="form-control" placeholder="Enter guardian name">
						<div id="stu_guardian_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Local Address </label>
					<div class="col-sm-10">
						<textarea name="local_address" id="stu_local_address" class="form-control" rows="3" placeholder="Enter local address"></textarea>
						<div id="stu_local_address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Contact No.</label>
					<div class="col-sm-10">
						<input type="text" name="contact_no" id="stu_contact_no" class="form-control" onkeypress="phoneno()" maxlength="10" placeholder="Enter contact no.">
						<div id="stu_contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Email ID</label>
					<div class="col-sm-10">
						<input type="text" name="email" id="stu_email" class="form-control" placeholder="Enter email id">
						<div id="stu_email_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Medical History</label>
					<div class="col-sm-10">
						<input type="text" name="medical" id="stu_medical" class="form-control" placeholder="Enter medical history">
						<div id="stu_medical_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Height </label>
					<div class="col-sm-10">
						<input type="text" name="height" id="stu_height" class="form-control" placeholder="Enter height in Inches">
						<div id="stu_height_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Weight</label>
					<div class="col-sm-10">
						<input type="text" name="weight" id="stu_weight" class="form-control" placeholder="Enter weight in KG">
						<div id="stu_weight_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">TC Self</label>
					<div class="col-sm-10">
					<select class="form-control" name="transfer" id="stu_transfer">
						<option value="0">Select TC Self</option>
						<option value="Bonafide">Bonafide</option>
						<option value="Fresher">Fresher</option>
					</select>
					<div id="stu_transfer_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">House</label>
					<div class="col-sm-10">
					<select class="form-control" name="house" id="stu_house">
						<option value="0">Select House</option>
						<option value="Raman">Raman</option>
						<option value="Ashoka">Ashoka</option>
						<option value="Tagore">Tagore</option>
						<option value="Shivaji">Shivaji</option>
					</select>
					<div id="stu_house_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Hostler</label>
					<div class="col-sm-10">
					<select class="form-control" name="hostler" id="stu_hostler">
						<option value="0">Select Hostler</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
					<div id="stu_hostler_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="form-submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </form>
  </div>
</div>