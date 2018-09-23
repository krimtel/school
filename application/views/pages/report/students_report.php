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
		<?php if($power == 5) { ?>
		<section class="col-lg-12 connectedSortable">
			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">Search Singal Students Records by Admission No.</h3>
				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					  <i class="fa fa-minus"></i></button>
				  </div>
				</div>
				<div class="box-body">
					<div class="form-group col-sm-4">
						<input class="form-control" type="text" id="advance_search_1" name="advance_search" placeholder="Search by admission no." />
					</div>
					<div class="form-group col-sm-4">
						<input class="btn btn-info btn-space"type="submit" id="advance_search" value="Search" />
					</div>
				</div>
			</div>
		</section>
		<?php } ?>
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
  
<script>
var baseUrl = $('#base_url').val();

$(document).on('change','#class',function(){
	var c_id = $('#class').val();
	$.ajax({
		type: 'GET',
		url: baseUrl+'Class_ctrl/section_list_class_teacher/'+c_id,
		dataType: "json",
		data: {
			'c_id':c_id
		},
		beforeSend: function(){},
		success:  function (response) {
			if(response.status == 200){
				var x = '<option value="0" selected>Select Section</option>';
				$.each(response.data,function(key,value){	
					x = x + '<option value="'+value.id+'">'+ value.name +'</option>'; 
				});
				$('#section').html(x);
			}
		}
	});
	if(c_id == 14 || c_id == 15){
		$('#subject_group').show();
		$('#elective_section').show();
	}
	else{
		$('#subject_group').hide();
		$('#elective_section').hide();
	}

	if(c_id == 12 || c_id == 13){
		$('#fit_section').show();
	}
	else{
		$('#fit_section').hide();
	}
});

function student_render(response){
	console.log(response);
	var x = '';
	var c = 1;
	var medium = $('#medium').val();
	var y;
	if(response.data[0]['class_id'] == 14 || response.data[0]['class_id'] == 15){
		$('.sub_group').show();
		$('.fit').hide();
	}
	else if(response.data[0]['class_id'] == 12 || response.data[0]['class_id'] == 13){
		$('.sub_group').hide();
		$('.fit').show();
	}
	else{
		$('.fit').hide();
		$('.sub_group').hide();
	}
	
	
	$.each(response.data,function(key,value){
	x = x + '<tr>'+
				'<td>'+ c +'</td>'+
				'<td style="width:85px;float:left;">'+
					'<a type="button" class="stu_edit btn btn-info btn-flat" data-sid="'+value.s_id+'" title="Edit"> <i class="fa fa-pencil"></i></a>' +
					'<a type="button" class="stu_del btn btn-danger btn-flat" data-sid="'+value.s_id+'" title="Delete"> <i class="fa fa-trash-o"></i></a>' +
				'</td>';
				 x = x + '<td><img width="30" src="'+ baseUrl +'photos/students/<?php echo strtolower($this->session->userdata('school'));?>/'+ value.photo +'"></td>';
				//'<td><input class="dynamic numaric" style="width:90px;" data-column="aadhar" data-id="'+ value.s_id +'" type="text" id="stu_aadhar" value="'+ value.aadhar +'" disabled="disabled" maxlength="12" readonly></td>'+
				x = x + '<td>'+ value.aadhar +'</td>'+
				//'<td><input class="dynamic" data-column="name" data-id="'+ value.s_id +'" type="text" id="stu_name" value="'+ value.name +'" disabled="disabled"></td>'+
				'<td>'+ value.name +'</td>'+
				'<td>'+
// 					'<select style="width:40px;" class="dynamic drop_down" data-column="class_id" data-id="'+ value.s_id +'">'+
// 						'<option value="4"'; (value.cname == 'I') ? y= 'selected' : y =''; x = x + y +'>I</option>'+
// 						'<option value="5"'; (value.cname == 'II') ? y= 'selected' : y ='';  x= x + y+ '>II</option>'+
// 						'<option value="6"'; (value.cname == 'III') ? y= 'selected' : y =''; x= x + y+ '>III</option>'+
// 						'<option value="7"'; (value.cname == 'IV') ? y= 'selected' : y =''; x= x + y+ '>IV</option>'+
// 						'<option value="8"'; (value.cname == 'V') ? y= 'selected' : y =''; x= x + y+ '>V</option>'+
// 						'<option value="9"'; (value.cname == 'VI') ? y= 'selected' : y =''; x= x + y+ '>VI</option>'+
// 						'<option value="10"'; (value.cname == 'VII') ? y= 'selected' : y =''; x= x + y+ '>VII</option>'+
// 						'<option value="11"'; (value.cname == 'VIII') ? y= 'selected' : y =''; x= x + y+ '>VIII</option>'+
// 						'<option value="12"'; (value.cname == 'IX') ? y= 'selected' : y =''; x= x + y+ '>IX</option>'+
// 						'<option value="13"'; (value.cname == 'X') ? y= 'selected' : y =''; x= x + y+ '>X</option>'+
// 						'<option value="14"'; (value.cname == 'XI') ? y= 'selected' : y =''; x= x + y+ '>XI</option>'+
// 						'<option value="15"'; (value.cname == 'XII') ? y= 'selected' : y =''; x= x + y+ '>XII</option>'+
// 						'<option value="2"'; (value.cname == 'LKG') ? y= 'selected' : y =''; x= x + y+ '>LKG</option>'+
// 						'<option value="3"'; (value.cname == 'UKG') ? y= 'selected' : y =''; x= x + y+ '>UKG</option>'+
// 						'<option value="1"'; (value.cname == 'NURSERY') ? y= 'selected' : y =''; x= x + y+ '>NURSERY</option>'+
// 					'</select>'+
					value.cname +'/'+ value.secname +
// 					'<select class="dynamic drop_down" data-column="section" data-id="'+ value.s_id +'">'+
// 						'<option value="1"'; (value.secname == 'A') ? y= 'selected' : y =''; x = x + y +'>A</option>'+
// 						'<option value="2"'; (value.secname == 'B') ? y= 'selected' : y =''; x = x + y +'>B</option>'+
// 						'<option value="3"'; (value.secname == 'C') ? y= 'selected' : y =''; x = x + y +'>C</option>'+
// 						'<option value="4"'; (value.secname == 'D') ? y= 'selected' : y =''; x = x + y +'>D</option>'+
// 						'<option value="5"'; (value.secname == 'E') ? y= 'selected' : y =''; x = x + y +'>E</option>'+
// 						'<option value="6"'; (value.secname == 'F') ? y= 'selected' : y =''; x = x + y +'>F</option>'+
// 						'<option value="7"'; (value.secname == 'G') ? y= 'selected' : y =''; x = x + y +'>G</option>'+
// 						'<option value="8"'; (value.secname == 'H') ? y= 'selected' : y =''; x = x + y +'>H</option>'+
// 						'<option value="9"'; (value.secname == 'I') ? y= 'selected' : y =''; x = x + y +'>I</option>'+
// 						'<option value="10"'; (value.secname == 'J') ? y= 'selected' : y =''; x = x + y +'>J</option>'+
// 						'<option value="11"'; (value.secname == 'K') ? y= 'selected' : y =''; x = x + y +'>K</option>'+
// 						'<option value="12"'; (value.secname == 'L') ? y= 'selected' : y =''; x = x + y +'>L</option>'+
// 						'<option value="13"'; (value.secname == 'M') ? y= 'selected' : y =''; x = x + y +'>M</option>'+
// 					'</select>'+
				'</td>';
				if(response.data[0]['class_id'] == 12 || response.data[0]['class_id'] == 13){
				 x = x + '<td><select class="dynamic drop_down" data-column="fit" data-id="'+ value.s_id +'">'+
					'<option value="1"'; (value.fit == 1)? y = 'selected' : y =''; x = x + y +'>Yes</option>'+
					'<option value="0"'; (value.fit == 0)? y = 'selected' : y =''; x = x + y +'>No</option>'+
				'</select>';
				}
				if(response.data[0]['class_id'] == 14 || response.data[0]['class_id'] == 15){
					x = x +
					'<td><select class="dynamic drop_down" data-column="subject_group drop_down" data-id="'+ value.s_id +'">'+
					'<option value="Maths"'; (value.subject_group == 'Maths') ? y= 'selected' : y =''; x = x + y +'>Maths</option>'+
					'<option value="Boilogy"'; (value.subject_group == 'Boilogy') ? y= 'selected' : y =''; x = x + y +'>Bio</option>'+
					'<option value="Commerce"'; (value.subject_group == 'Commerce') ? y= 'selected' : y =''; x = x + y +'>Commerce</option>'+
					'<option value="Arts"'; (value.subject_group == 'Arts') ? y= 'selected' : y =''; x = x + y +'>Arts</option>'+
				'</select></td>'+
					'<td><select class="dynamic drop_down" data-column="elective" data-id="'+ value.s_id +'">'+
						'<option value="23"'; (value.elective == '23') ? y= 'selected' : y =''; x = x + y +'>CS</option>'+
						'<option value="26"'; (value.elective == '26') ? y= 'selected' : y =''; x = x + y +'>Hindi</option>'+
						'<option value="27"'; (value.elective == '27') ? y= 'selected' : y =''; x = x + y +'>PE</option>'+
						'<option value="28"'; (value.elective == '28') ? y= 'selected' : y =''; x = x + y +'>Maths</option>'+
					'</select></td>';
				}
				
				if(value.medium == 'Hindi'){
					x = x + '<td><select class="dynamic drop_down" data-column="medium" data-id="'+ value.s_id +'">'+
								'<option value="Hindi" selected>Hindi</option>'+
								'<option value="English">English</option>'+
							'</select>'; 
				}
				else{
					x = x + '<td><select class="dynamic drop_down" data-column="medium" data-id="'+ value.s_id +'" readonly>'+
								'<option value="Hindi">Hindi</option>'+
								'<option value="English" selected>English</option>'+
							'</select>'; 
				}
				x = x + '</td>'+
				'<td><input style="width:40px;text-align:center;" class="dynamic" data-column="roll_no" data-id="'+ value.s_id +'" type="text" id="stu_rollno" value="'+ value.roll_no +'"></td>'+
				'<td><input style="width:40px;text-align:center;" class="dynamic" data-column="admission_no" data-id="'+ value.s_id +'" type="text" id="stu_admission_no" value="'+ value.admission_no +'"></td>'+
				'<td><input style="width:70px;text-align:center;" class="dynamic" data-column="admission_date" data-id="'+ value.s_id +'" type="text" id="stu_admission_date" value="'+ value.admission_date +'"></td>'+
				'<td><input class="dynamic" data-column="father_name" data-id="'+ value.s_id +'" type="text" id="stu_father_name1" value="'+ value.father_name +'"></td>'+
				'<td><input class="dynamic" data-column="mother_name" data-id="'+ value.s_id +'" type="text" id="stu_mother_name1" value="'+ value.mother_name +'"></td>'+
				'<td><input style="width:70px;text-align:center;" class="dynamic" data-column="dob" data-id="'+ value.s_id +'" type="text" id="stu_dob" value="'+ value.dob +'"></td>'+
				'<td>'+
				'<select class="dynamic drop_down" data-column="gender" data-id="'+ value.s_id +'">'+
					'<option value="Male"'; (value.gender == 'Male') ? y= 'selected' : y =''; x = x + y +'>Male</option>'+
					'<option value="Female"';(value.gender == 'Female') ? y= 'selected' : y =''; x = x + y +'>Female</option>'+
				'</select>'+
			'</td>'+
				'<td><input style="width:225px;" class="dynamic" data-column="address" data-id="'+ value.s_id +'" type="text" id="stu_dob" value="'+ value.address +'"></td>'+
				'<td><input style="width:75px;text-align:center;" class="dynamic numaric" data-column="contact_no" data-id="'+ value.s_id +'" type="text" id="stu_dob" value="'+ value.contact_no +'" maxlength="10"></td>'+
				'<td>'+
					'<select class="dynamic drop_down" data-column="house" data-id="'+ value.s_id +'">'+
						'<option value="Raman"'; (value.house == 'Raman') ? y= 'selected' : y =''; x = x + y +'>Raman</option>'+
						'<option value="Ashoka"';(value.house == 'Ashoka') ? y= 'selected' : y =''; x = x + y +'>Ashoka</option>'+
						'<option value="Tagore"'; (value.house == 'Tagore') ? y= 'selected' : y =''; x = x + y +'>Tagore</option>'+
						'<option value="Shivaji"'; (value.house == 'Shivaji') ? y= 'selected' : y =''; x = x + y +'>Shivaji</option>'+
					'</select>'+
				'</td>'+
				'<td>'+
					'<select class="dynamic drop_down" data-column="hostler" data-id="'+ value.s_id +'">'+
						'<option value="No"'; (value.hostler == 'No') ? y= 'selected' : y =''; x = x + y +'>No</option>'+
						'<option value="Yes"'; (value.hostler == 'Yes') ? y= 'selected' : y =''; x = x + y +'>Yes</option>'+
					'</select>'+
				'</td>'+
				'<td>'+
					'<select class="dynamic drop_down" data-column="blood_group" data-id="'+ value.s_id +'">'+
						'<option value="0"'; (value.blood_group == '') ? y= 'selected' : y =''; x = x + y +'>nill</option>'+
						'<option value="O+"'; (value.blood_group == 'O+') ? y= 'selected' : y =''; x = x + y +'>O+</option>'+
						'<option value="O-"'; (value.blood_group == 'O-') ? y= 'selected' : y =''; x = x + y +'>O-</option>'+
						'<option value="A+"'; (value.blood_group == 'A+') ? y= 'selected' : y =''; x = x + y +'>A+</option>'+
						'<option value="A-"'; (value.blood_group == 'A-') ? y= 'selected' : y =''; x = x + y +'>A-</option>'+
						'<option value="B+"'; (value.blood_group == 'B+') ? y= 'selected' : y =''; x = x + y +'>B+</option>'+
						'<option value="B-"'; (value.blood_group == 'B-') ? y= 'selected' : y =''; x = x + y +'>B-</option>'+
						'<option value="AB+"'; (value.blood_group == 'AB+') ? y= 'selected' : y =''; x = x + y +'>AB+</option>'+
						'<option value="AB-"'; (value.blood_group == 'AB-') ? y= 'selected' : y =''; x = x + y +'>AB-</option>'+
					'</select>'+
				'</td>'+
				'<td>'+
					'<select class="dynamic drop_down" data-column="cast" data-id="'+ value.s_id +'">'+
						'<option value="'+ value.cast + '">'+ value.cast + '</option>'+
						'<option value="General"'; (value.cast == 'General') ? y= 'selected' : y =''; x = x + y +'>General</option>'+
						'<option value="SC"'; (value.cast == 'SC') ? y= 'selected' : y =''; x = x + y +'>SC</option>'+
						'<option value="OBC"'; (value.cast == 'OBC') ? y= 'selected' : y =''; x = x + y +'>OBC</option>'+
						'<option value="ST"'; (value.cast == 'ST') ? y= 'selected' : y =''; x = x + y +'>ST</option>'+
					'</select>'+
				'</td>'+
				'<td><input style="width:45px;text-align:center;" class="dynamic" data-column="height" data-id="'+ value.s_id +'" type="text" id="stu_height" value="'+ value.height +'"></td>'+
				'<td><input style="width:45px;text-align:center;" class="dynamic" data-column="weight" data-id="'+ value.s_id +'" type="text" id="stu_weight" value="'+ value.weight +'"></td>'+
				'<td><input style="width:100px;" class="dynamic" data-column="email_id" data-id="'+ value.s_id +'" type="text" id="stu_email_id" value="'+ value.email_id +'"></td>'+
				'<td><input style="width:120px;" class="dynamic" data-column="guardian" data-id="'+ value.s_id +'" type="text" id="stu_guardian" value="'+ value.guardian +'"></td>'+
				'<td><input style="width:120px;" class="dynamic" data-column="local_address" data-id="'+ value.s_id +'" type="text" id="stu_local_address" value="'+ value.local_address +'"></td>'+
				'<td><input style="width:90px;" class="dynamic" data-column="medical" data-id="'+ value.s_id +'" type="text" id="stu_medical" value="'+ value.medical +'"></td>'+
				'<td>'+
				'<select class="dynamic drop_down" data-column="tc" data-id="'+ value.s_id +'">'+
					'<option value="0"'; (value.tc == '') ? y= 'selected' : y =''; x = x + y +'>Nill</option>'+
					'<option value="Bonafide"'; (value.tc == 'Bonafide') ? y= 'selected' : y =''; x = x + y +'>Bonafide</option>'+
					'<option value="Fresher"'; (value.tc == 'Fresher') ? y= 'selected' : y =''; x = x + y +'>Fresher</option>'+
				'</select>'+
			'</td>'+
			'</tr>';  
	c++;
	});
	$('#student_list').html('');
	$('#student_list').html(x);
}

$(document).on('click','.stu_del',function(){
	var sid = $(this).data('sid');
	var class_id = $('#class').val();
	var section = $('#section').val();
	var medium = $('#medium').val();
	var that = this;
	$.ajax({
		type: 'POST',
			url: baseUrl+'Admin_ctrl/stu_del_permission_check',
			dataType: "json",
			data: {
				'class_id' : class_id,
				'section' : section,
				'medium' : medium 	
			},
			beforeSend : function(){
			},
			success : function (response){
				if(response.status == 200){
						var x = confirm('Are you sure.');
						if(x){
							$.ajax({
								type: 'POST',
								url: baseUrl+'Student_ctrl/stu_del',
								dataType: "json",
								data: {
									's_id': sid
								},
								beforeSend : function(){
								},
								success : function (response){
									if(response.status == 200){
										$(that).closest('tr').hide('slow');
									}
									else{
										alert(response.msg);
									}
								}
							});
						}
				}
				else{
					alert(response.msg);
				}
			}
	});
});


$(document).on('click','#form_submit',function(){
	var form_valid = true;
	var medium = $('#medium').val();
	var classes = $('#class').val();
	var section = $('#section').val();
	var elective = $('#elective').val();
	var s_group = $('#s_group').val();
	var fit = $('#fit').val();

	if(classes == 14 || classes == 15){
		$('#fit').val(0);
	}
	else if(classes == 12){
		$('#s_group').val(0);
		$('#elective').val(0);
	}
	else{
		$('#s_group').val(0);
		$('#elective').val(0);
		$('#fit').val(0);
	}
	
	if($('#session').val() == 0){
		$('#session_err').html('Please select session.').css('display','block');
		form_valid = false;
	}
	else{
		$('#session_err').css('display','none');
	}
	
	if(medium == 0){
		$('#medium_err').html('Please select medium.').css('display','block');
		form_valid = false;
	}
	else{
		$('#medium_err').css('display','none');
	}

	if(classes == 0){
		$('#class_err').html('Please select class.').css('display','block');
		form_valid = false;
	}
	else{
		$('#class_err').css('display','none');
	}

	if(section == 0){
		$('#section_err').html('Please select section.').css('display','block');
		form_valid = false;
	}
	else{
		$('#section_err').css('display','none');
	}
	if(form_valid){
		$.ajax({
		type: 'POST',
			url: baseUrl+'Student_ctrl/student_list',
			dataType: "json",
			data: {
				'medium' : medium,
				'class' : classes,
				'section' : section,
				'elective' : elective,
				's_group' : s_group,
				'fit' : fit,
				'session' : $('#session').val() 
			},
			beforeSend : function(){
				$('#loader').modal('show');
			},
			success : function (response){
				$('#loader').modal('toggle');
				if(response.status == 200){
					student_render(response);
				}
				else{
					alert('No Students Record Found.');
					$('#student_list').html('<tr><td colspan="30"><h4 class="text-center"><b>No Students Record Found.</b></h4></td></tr>');
				}
	  		}
		});
	}
});

$(document).on('keyup','#search',function(){
	var medium = $('#medium').val();
	var classes = $('#class').val();
	var section = $('#section').val();
	var elective = $('#elective').val();
	var s_group = $('#s_group').val();
	var fit = $('#fit').val();
		
	var text = $(this).val();
	if(text.length == 0){
		$("#form_submit").trigger("click");
	}
	
	$.ajax({
	type: 'POST',
		url: baseUrl+'Student_ctrl/student_list_filter',
		dataType: "json",
		data: {
			'medium':medium,
			'class':classes,
			'section':section,
			'text':text,
			'elective' : elective,
		    's_group' : s_group,
			'fit' : fit 
		},
		beforeSend: function(){},
		success:  function (response) {
			student_render(response);
  		}
	});
});

function openExcelfile(strFilePath){
	//var yourSite = "http://m.eurotechappliance.com/";
	var yourSite = "http://localhost/school/trunk/sharda/admin/students-report";
	openExcelDocPath(yourSite + strFilePath, false);
}

function openExcelDocPath(strLocation, boolReadOnly){
	window.location.href = strLocation;
} 

$(document).on('click','#export-to-excel',function(){
	var form_valid = true;
	var medium = $('#medium').val();
	var classes = $('#class').val();
	var section = $('#section').val();

	if(medium == 0){
		$('#medium_err').html('Please select medium.').css('display','block');
		form_valid = false;
	}
	else{
		$('#medium_err').css('display','none');
	}

	if(classes == 0){
		$('#class_err').html('Please select Class.').css('display','block');
		form_valid = false;
	}
	else{
		$('#class_err').css('display','none');
	}

	if(section == 0){
		$('#section_err').html('Please select Section.').css('display','block');
		form_valid = false;
	}
	else{
		$('#section_err').css('display','none');
	}
	if(form_valid){
		$.ajax({  
			url: baseUrl +'Admin_ctrl/download_to_excel',  
			type:"POST",
			dataType: "json",  
			data:{
				'medium' : medium ,
				'class' : classes ,
				'section' : section			
			},  
			success:function(response){
				console.log(response);
				var x = baseUrl;
				x = x + response.data.file_path;
				var newwindow=window.open(x,"window2","");		
			}  
		});
	}
});

$(document).on('blur','.dyn_change',function(){
	var column = $(this).data('column');
	var s_id = $(this).data('id');
	var value = $(this).val();	
	var that = this;
	$.ajax({  
		url: baseUrl +'Admin_ctrl/student_update',  
		type:"POST",
		dataType: "json",  
		data:{
		  'column':column,
		  'value' :value,
		  's_id' : s_id
		},  
		beforeSend : function(){
            $('#loader').modal('show');
        },
		success:function(response){
			$('#loader').modal('toggle');
			if(response.status == 200){
				$(that).removeClass('dyn_change');
			}
		}  
	});
});

$(document).on('dblclick','.dynamic',function(){
// 	$(this).addClass('dyn_change');
// 	$(this).removeAttr('disabled');
});

//$(document).on('change','.drop_down',function(){
//	var x = confirm('Are you sure..');
//	if(x){
//		var column = $(this).data('column');
//		var s_id = $(this).data('id');
//		var value = $(this).val();
//		var that = this;
//		$.ajax({  
//			url: baseUrl +'Admin_ctrl/student_update',  
//			type:"POST",
//			dataType: "json",  
//			data:{
//			  'column':column,
//			  'value' :value,
//			  's_id' : s_id
//			},  
//			success:function(response){
//				if(response.status == 200){
//					$(that).removeClass('dyn_change');
//				}
//			}  
//		});
//	}
//});

$(document).on('keypress','.numaric',function(e){
	var a = [];
	var k = e.which;

	for (i = 48; i < 58; i++)
		a.push(i);

	if (!(a.indexOf(k)>=0))
		e.preventDefault();
});

$(document).on('click','.stu_edit',function(){
	clear();
	var sid = $(this).data('sid');
	var class_id = $('#class').val();
	var section = $('#section').val();
	var medium = $('#medium').val();

	if(class_id == 12 || class_id == 13){
		$("#stu_class").trigger("change");
		$('#stu_fit_section').css('display','block');
	}
	
	if(class_id == 14 || class_id == 15){
		$('#stu_elective_section').show();
		$('#stu_sub_group_section').show();
	}
	else{
		$('#stu_elective_section').hide();
		$('#stu_sub_group_section').hide();
	}
	var that = this;
	$.ajax({
		type: 'POST',
		url: baseUrl+'Admin_ctrl/stu_del_permission_check',
		dataType: "json",
		data: {
			'class_id' : class_id,
			'section' : section,
			'medium' : medium 
		},
		beforeSend : function(){
			$('#stu_id').val('');
			$('#stu_new_admission_no').val('');
			$('#stu_roll_no').val('');
			$('#stu_student_name').val('');
			$('#stu_medium').val(0);
			$('#stu_class').val(0);
			$('#stu_section').val(0);
			$('#stu_father_name').val('');
			$('#stu_mother_name').val('');
			$('#DOBdate').val('');
			$('#stu_gender').val(0);
			$('#ADdate').val('');
			$('#stu_caste').val('');
			$('#stu_blood').val(0);
			$('#stu_aadhaar').val('');
			$('#stu_address').val('');
			$('#stu_guardian').val('');
			$('#stu_local_address').val('');
			$('#stu_contact_no').val('');
			$('#stu_email').val('');
			$('#stu_medical').val('');
			$('#stu_height').val('');
			$('#stu_weight').val('');
			$('#stu_transfer').val('');
			$('#stu_house').val(0);
			$('#stu_hostler').val(0);
			
			},
		success : function (response){
			$.ajax({  
				url: baseUrl +'Student_ctrl/student_detail',  
				type:"POST",
				dataType: "json",  
				data:{
					's_id' : sid
				},
				success : function (response){
					if(response.status == 200){
						$('#stu_id').val(sid);
						$('#stu_new_admission_no').val(response.data[0].admission_no);
						$('#stu_roll_no').val(response.data[0].roll_no);
						$('#stu_student_name').val(response.data[0].name);
						$('#stu_medium').val(response.data[0].medium);
						$('#stu_class').val(response.data[0].class_id);
						$('#stu_section').val(response.data[0].section);
						$('#stu_father_name').val(response.data[0].father_name);
						$('#stu_mother_name').val(response.data[0].mother_name);
// 						$('#datepicker').val(response.data[0].dob);
						$('#DOBdate').val(response.data[0].dob);
						$('#stu_gender').val(response.data[0].gender);
						if(response.data[0].fit == '1'){
							$('#stu_fit').val("Yes");
						}
						else{
							$('#stu_fit').val("No");
						}
						$('#ADdate').val(response.data[0].admission_date);

						$('#stu_caste').val(response.data[0].cast);
						$('#stu_blood').val(response.data[0].blood_group);
						$('#stu_aadhaar').val(response.data[0].aadhar);
						$('#stu_address').val(response.data[0].address);
						$('#stu_guardian').val(response.data[0].guardian);
						$('#stu_local_address').val(response.data[0].local_address);
						$('#stu_contact_no').val(response.data[0].contact_no);
						$('#stu_email').val(response.data[0].email_id);
						$('#stu_medical').val(response.data[0].medical);
						$('#stu_height').val(response.data[0].height);
						$('#stu_weight').val(response.data[0].weight);
						$('#stu_transfer').val(response.data[0].tc);
						$('#stu_house').val(response.data[0].house);
						$('#stu_hostler').val(response.data[0].hostler);
						$('#stu_elective_subject').val(response.data[0].elective);
						$('#stu_subject_group').val(response.data[0].subject_group);

						$('#exampleModal').modal({
							'show': true,
							'keyboard' : true,
							'backdrop': false
							});	
					}
				}
			});
		}
	});	
});

function clear(){
	$('#stu_admission_no_err').css('display','none');
	$('#stu_roll_no_err').css('display','none');
	$('#stu_student_name_err').css('display','none');
	$('#stu_subject_group_err').css('display','none');
	$('#stu_medium_err').css('display','none');
	$('#stu_class_err').css('display','none');
	$('#stu_section_err').css('display','none');
	$('#stu_elective_subject_err').css('display','none');
	$('#stu_fit_err').css('display','none');
	$('#stu_house_err').css('display','none');
	$('#stu_transfer_err').css('display','none');
	$('#stu_address_err').css('display','none');
	$('#stu_aadhaar_err').css('display','none');
	$('#stu_blood_err').css('display','none');
	$('#mother_name_err').css('display','none');
	$('#stu_father_name_err').css('display','none');
}

$(document).on('click','#form-submit',function(){
	$("body.modal-open").removeAttr("style");
	clear();
	if($('#stu_new_admission_no').val() == ''){
		  formvalid = false;
		  //alert('admission_no');
		  $('#stu_admission_no_err').html('Admission no. can\'t be empty.').css('display','block');
	  } else {
		  $('#stu_admission_no_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#stu_roll_no').val() == ''){
		  formvalid = false;
		  //alert('roll_no');
		  $('#stu_roll_no_err').html('Please enter roll no.').css('display','block');
	  } else {
		  $('#stu_roll_no_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#stu_student_name').val() == '' || $('#stu_student_name').val().length < 3){
		  formvalid = false;
		  $('#stu_student_name_err').html('Student name not valid.').css('display','block');
	  } else {
		  $('#stu_student_name_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#stu_medium').val() == '0'){
		  formvalid = false;
		  $('#stu_medium_err').html('Please select medium.').css('display','block');
	  } else {
		  $('#stu_medium_err').css('display','none');
	  }

	  if($('#stu_class').val() == '0'){
		  formvalid = false;
		  $('#stu_class_err').html('Please select class.').css('display','block');
	  } else {
		  $('#stu_class_err').css('display','none');
	  }

	  if($('#stu_section').val() == '0'){
		  formvalid = false;
		  $('#stu_section_err').html('Please select section.').css('display','block');
	  } else {
		  $('#stu_section_err').css('display','none');
	  }

	  if($('#stu_class').val() == 14 || $('#stu_class').val() == 15){
		  if($('#stu_subject_group').val() == '0'){
			  formvalid = false;
			  $('#stu_subject_group_err').html('Please select subject group.').css('display','block');
		  } else {
			  $('#stu_subject_group_err').css('display','none');
		  }
	  }

	  if($('#stu_father_name').val() == '' || $('#stu_father_name').val().length < 3){
		  formvalid = false;
		  $('#stu_father_name_err').html('Father name not valid.').css('display','block');
	  } else {
		  $('#stu_father_name_err').css('display','none');
	  }
	  if($('#stu_mother_name').val() == '' || $('#stu_mother_name').val().length < 3){
		  formvalid = false;
		  $('#stu_mother_name_err').html('Mother name not valid.').css('display','block');
	  } else {
		  $('#mother_name_err').css('display','none');
	  }

	  if($('#DOBdate').val() == ''){
		  formvalid = false;
		  $('#datepicker_err').html('Please enter date of birth.').css('display','block');
	  } else {
		  $('#datepicker_err').css('display','none');
	  }

	  if($('#stu_gender').val() == '0'){
		  formvalid = false;
		  $('#stu_gender_err').html('Please select gender.').css('display','block');
	  } else {
		  $('#stu_gender_err').css('display','none');
	  }

	  if($('#ADdate').val() == ''){
		  formvalid = false;
		  $('#datepicker2_err').html('Please select date of admission.').css('display','block');
	  } else {
		  $('#datepicker2_err').css('display','none');
	  }

	  if($('#stu_caste').val() == '0'){
		  formvalid = false;
		  $('#stu_caste_err').html('Please select caste.').css('display','block');
	  } else {
		  $('#stu_caste_err').css('display','none');
	  }

	  if($('#stu_blood').val() == '0'){
		  formvalid = false;
		  $('#stu_blood_err').html('Please select blood group.').css('display','block');
	  } else {
		  $('#stu_blood_err').css('display','none');
	  }

	  if($('#stu_aadhaar').val() == ''){
		  formvalid = false;
		  $('#stu_aadhaar_err').html('Please enter student aadhaar card no.').css('display','block');
	  } else {
		  $('#stu_aadhaar_err').css('display','none');
	  }
	  if($('#stu_address').val() == ''){
		  formvalid = false;
		  $('#stu_address_err').html('Please enter address.').css('display','block');
	  } else {
		  $('#stu_address_err').css('display','none');
	  }
	  
	  if($('#stu_transfer').val() == '0'){
		  formvalid = false;
		  $('#stu_transfer_err').html('Please select transfer certificate.').css('display','block');
	  } else {
		  $('#stu_transfer_err').css('display','none');
	  }
	  
	  if($('#stu_house').val() == '0'){
		  formvalid = false;
		  $('#stu_house_err').html('Please select house.').css('display','block');
	  } else {
		  $('#stu_house_err').css('display','none');
	  }
	  
	  if($('#stu_hostler').val() == '0'){
		  formvalid = false;
		  $('#stu_hostler_err').html('Please select hostler.').css('display','block');
	  } else {
		  $('#stu_hostler_err').css('display','none');
	  }
	  
	  if($('#stu_class').val() == 12 || $('#stu_class').val() == 13){
		  if($('#stu_fit').val() == '0'){
			  formvalid = false;
			  $('#stu_fit_err').html('Select student is in FIT or Not.').css('display','block');
		  } else {
			  $('#stu_fit_err').css('display','none');
		  }
	  }
	  
	  if($('#stu_class').val() == 14||$('#stu_class').val() == 15){
		  if($('#stu_elective_subject').val() == '0'){
			  formvalid = false;
			  $('#stu_elective_subject_err').html('Select elective subject.').css('display','block');
		  } else {
			  $('#stu_elective_subject_err').css('display','none');
		  }
		  
		  if($('#stu_subject_group').val() == '0'){
			  formvalid = false;
			  $('#stu_subject_group_err').html('Select student subject group.').css('display','block');
		  } else {
			  $('#stu_subject_group_err').css('display','none');
		  }
	  }  
	  
	if(formvalid){
		$('#student_update_form').ajaxForm({
			dataType : 'json',
			beforeSubmit:function(e){
				$('#loader').modal('show');
			},
			success:function(response){
			  if(response.status == 200){
				$('#loader').modal('toggle');
				$('#exampleModal').modal('toggle');
				
				var medium = $('#medium').val();
				var classes = $('#class').val();
				var section = $('#section').val();
				var elective = $('#elective').val();
				var s_group = $('#s_group').val();
				var fit = $('#fit').val();
				
				$.ajax({
					type: 'POST',
						url: baseUrl+'Student_ctrl/student_list',
						dataType: "json",
						data: {
							'medium' : medium,
							'class' : classes,
							'section' : section,
							'elective' : elective,
							's_group' : s_group,
							'fit' : fit,
							'session' : $('#session').val() 
						},
						beforeSend: function(){},
						success:  function (response) {
							student_render(response);
				  		}
					});				

			  }
			  else{
				alert(response.msg);
			  }
			}
	  }).submit();
	}
 });
  
  $(document).on('change','#stu_class',function(){
	  var c_id = $('#stu_class').val();
	  if(c_id == 12 || c_id == 13){
		  $('#stu_fit_section').css('display','block');
	  }
	  else{
		 $('#stu_fit_section').css('display','none'); 
	  }
	  
	  if(c_id == 14 || c_id == 15){
		$('#stu_sub_group_section').css('display','block');  
		$('#stu_elective_section').css('display','block');
		
		$.ajax({
			type: 'GET',
			url: baseUrl+'Subject_ctrl/elective_subject',
			dataType: "json",
			data: {},
			beforeSend: function(){
				
			},
			success:  function (response) {
				if(response.status == 200){
					var x = '<option value="0" selected>Select Elective Subject</option>';
					$.each(response.data,function(key,value){	
						x = x + '<option value="'+value.sub_id+'">'+ value.name +'</option>'; 
					});
					$('#stu_elective_subject').html(x);
				}
			}
		});
	  }
	  else{
		$('#stu_sub_group_section').css('display','none');
		$('#stu_elective_section').css('display','none');		
	  }

	  $.ajax({
			type: 'GET',
			url: baseUrl+'Class_ctrl/section_list/'+c_id,
			dataType: "json",
			data: {
				'c_id':c_id
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				if(response.status == 200){
					var x = '<option value="0" selected>Select Section</option>';
					$.each(response.data,function(key,value){	
						x = x + '<option value="'+value.id+'">'+ value.name +'</option>'; 
					});
					//$('#stu_section').html(x);
				}
			}
	  });
  });

  $(document).on('click','#advance_search',function(){
	  var string = $('#advance_search_1').val();
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Student_ctrl/advance_search',
			dataType: "json",
			data: {
				'string' : string
			},
			beforeSend: function(){},
			success:  function (response) {
				if(response.status == 200){
					student_render(response);
				}
				else{
					alert('no record found');
				}
			}
	  });
  });

  $(function(){
	    $('#datepicker,#datepicker2').datepicker({
	        format: 'dd/mm/yyyy'
	    }).on('changeDate',  function (ev) {
	        $(this).datepicker('hide');
	    }); 
	});
</script>