<div class="content-wrapper">
	<section class="content-header">
      <h1>
        Add Student
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>Svr_ctrl/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Student</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
<?php if($power == 5){ ?>        
<section class="col-lg-12">
			<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Import Student Record</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="csv-form" role="form" class="form-horizontal" name="f2" method="POST" action="<?php echo base_url();?>Student_ctrl/add_student_csv">
				<div class="box-body">
				<div class="form-group">
                  <label class="col-sm-4 control-label" for="exampleInputFile">Import Student Record</label>
                  <div class="col-sm-8"><input type="file" name="userfile" id="exampleInputFile"><span style="font-size:12px;">Only CSV File Upload.</span></div>
                  <div id="csvfile" class="text-danger" style="display:none;"></div>
                </div>
                </div>
				<div class="box-footer">
				<button type="button" id="csv_submit" class="btn pull-right btn-info">Submit CSV</button>
				 <button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
			</div>
		</section>
<?php } ?>
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New Student</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="student_form" role="form" class="form-horizontal" name="f1" method="POST" action="<?php echo base_url();?>Student_ctrl/add_student" enctype="multipart/form-data">
			<div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Admission No.</label>
                  <div class="col-sm-10">
					<input type="text" name="admission_no" id="admission_no" class="form-control" placeholder="Enter admission no.">
					<div id="admission_no_err" class="text-danger" style="display:none;"></div>
				</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Roll No.</label>
                  <div class="col-sm-10">
					<input type="text" name="roll_no" id="roll_no" class="form-control" placeholder="Enter roll no.">
					<div id="roll_no_err" class="text-danger" style="display:none;"></div>
				  </div>
                </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Student Name</label>
						<div class="col-sm-10">
							<input type="text" name="student_name" id="student_name" class="form-control" placeholder="Enter student name">
							<div id="student_name_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Medium</label>
						<div class="col-sm-10">
							<?php if(isset($medium)){ ?>
								<select class="form-control" id="medium">
									<option value="<?php echo $medium; ?>" selected><?php echo $medium; ?></option>
								</select>
							<?php } else{ ?>
							<select class="form-control" name="medium" id="medium">
								<option value="0">Select Medium</option>
								<option value="Hindi">Hindi</option>
								<option value="English">English</option>
							</select>
							<?php } ?>
							<div id="medium_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group" >
						<label class="col-sm-2 control-label">Class</label>
						<div class="col-sm-10">
							<select class="form-control" name="class" id="class">
								<option value="0">Select Class</option>
									<?php foreach($classes as $class){ ?>
										<option value="<?php echo $class['c_id']; ?>"><?php echo $class['name']; ?></option>
									<?php }?>
							</select>
							<div id="class_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
					<select class="form-control" name="section" id="section">
						<option value="0">Select Section</option>
					</select>
					<div id="section_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group" id="fit_section" style="display:none;">
                    <label class="col-sm-2 control-label">FIT</label>
					<div class="col-sm-10">
					<select class="form-control" name="fit" id="fit">
						<option value="0">Select FIT</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
					<div id="fit_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group" id="elective_section" style="display:none;">
                    <label class="col-sm-2 control-label">Elective Subject</label>
					<div class="col-sm-10">
					<select class="form-control" name="elective" id="elective_subject">
						<option value="0">Select Elective Subject</option>
					</select>
					<div id="elective_subject_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group" id="sub_group_section" style="display:none;">
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
					<select class="form-control" name="subject_group" id="subject_group">
						<option value="0" selected>None</option>
						<option value="Maths">Maths</option>
						<option value="Boilogy">Boilogy</option>
						<option value="Commerce">Commerce</option>
						<option value="Arts">Arts</option>
					</select>
					<div id="subject_group_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Father's Name</label>
					<div class="col-sm-10">
						<input type="text" name="father_name" id="father_name" class="form-control" placeholder="Enter father's name">
						<div id="father_name_err" class="text-danger" style="display:none;"></div>
					</div>
				  
                </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Mother's Name</label>
					<div class="col-sm-10">
						<input type="text" name="mother_name" id="mother_name" class="form-control" placeholder="Enter mother's name">
						<div id="mother_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Date Of Birth</label>
					<div class="col-sm-10">
					<div class="input-group date">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
					  <input type="text" class="form-control pull-right" id="dob" name="dob" placeholder="dd/mm/yyyy"> 
					</div>
					<div id="datepicker_err" class="text-danger" style="display:none;"></div> 
					</div>
					<!-- /.input group -->
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Gender</label>
					<div class="col-sm-10">
					<select class="form-control" id="gender" name="gender">
						<option value="0">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
					 <div id="gender_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Date of Admission</label>
					<div class="col-sm-10">
					<div class="input-group date">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
					  <input type="text" class="form-control pull-right" id="admission" name="admission_date" placeholder="dd/mm/yyyy">
					</div>
					<div id="datepicker2_err" class="text-danger" style="display:none;"></div>
					</div>
					<!-- /.input group -->
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Caste</label>
					<div class="col-sm-10">
					<select class="form-control" name="caste" id="caste">
						<option value="0">Select Caste</option>
						<option value="General">General</option>
						<option value="OBC">OBC</option>
						<option value="ST">ST</option>
						<option value="SC">SC</option>
					</select>
					<div id="caste_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Blood Group</label>
					<div class="col-sm-10">
					<select class="form-control" name="blood" id="blood">
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
					<div id="blood_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Aadhaar Card Number</label>
					<div class="col-sm-10">
						<input type="text" name="aadhaar" id="aadhaar" class="form-control" placeholder="Enter aadhaar card no." maxlength="12">
						<div id="aadhaar_err" class="text-danger" style="display:none;"></div>
					</div>
                  
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Permanent Address</label>
					<div class="col-sm-10">
						<textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter permanent address"></textarea>
						<div id="address_err" class="text-danger" style="display:none;"></div>
					</div>
                  
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Guardian Name</label>
					<div class="col-sm-10">
						<input type="text" name="guardian" id="guardian" class="form-control" placeholder="Enter guardian name">
						<div id="guardian_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Local Address </label>
					<div class="col-sm-10">
						<textarea name="local_address" id="local_address" class="form-control" rows="3" placeholder="Enter local address"></textarea>
						<div id="local_address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Contact No.</label>
					<div class="col-sm-10">
						<input type="text" name="contact_no" id="contact_no" class="form-control" onkeypress="phoneno()"  maxlength="10" placeholder="Enter contact no.">
						<div id="contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Email ID</label>
					<div class="col-sm-10">
						<input type="text" name="email" id="email" class="form-control" placeholder="Enter email id">
						<div id="email_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Medical History</label>
					<div class="col-sm-10">
						<input type="text" name="medical" id="medical" class="form-control" placeholder="Enter medical history">
						<div id="medical_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Height </label>
					<div class="col-sm-10">
						<input type="text" name="height" id="height" class="form-control" placeholder="Enter height in Inches">
						<div id="height_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Weight</label>
					<div class="col-sm-10">
						<input type="text" name="weight" id="weight" class="form-control" placeholder="Enter weight in KG">
						<div id="weight_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">TC Self</label>
					<div class="col-sm-10">
					<select class="form-control" name="transfer" id="transfer">
						<option value="0">Select TC Self</option>
						<option value="Bonafide">Bonafide</option>
						<option value="Fresher">Fresher</option>
					</select>
					<div id="transfer_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">House</label>
					<div class="col-sm-10">
					<select class="form-control" name="house" id="house">
						<option value="0">Select House</option>
						<option value="Raman">Raman</option>
						<option value="Ashoka">Ashoka</option>
						<option value="Tagore">Tagore</option>
						<option value="Shivaji">Shivaji</option>
					</select>
					<div id="house_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Hostler</label>
					<div class="col-sm-10">
					<select class="form-control" name="hostler" id="hostler">
						<option value="0">Select Hostler</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
					<div id="hostler_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-2 control-label" for="exampleInputFile">Profile Image</label>
                  <div class="col-sm-10"><input type="file" name="userFiles[]" id=""></div>
                </div>
			</div>
			
			<div class="box-footer">
				<button type="button" id="form-submit" class="btn pull-right btn-info">Submit</button>
				<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
		</div>
        </section>
      </div>
    </section>
  </div>
  <script src="<?php echo base_url();?>assest/bootstrap/js/student.js"></script>
   <script>
  function phoneno(){       
		$('#contact_no').keypress(function(e) {
			var a = [];
			var k = e.which;

			for (i = 48; i < 58; i++)
				a.push(i);

			if (!(a.indexOf(k)>=0))
				e.preventDefault();
		});
	}

  $(function(){
	    $('#datepicker,#datepicker2').datepicker({
	        format: 'dd/mm/yyyy'
	    }).on('changeDate',  function (ev) {
	        $(this).datepicker('hide');
	    }); 
	});
  
  </script>