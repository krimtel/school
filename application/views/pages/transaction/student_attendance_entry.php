<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Student Attendance Entry
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Student Attendance Entry</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-10 col-lg-offset-1 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add Student Attendance</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="attendance_form" role="form" class="form-horizontal" name="f1" method="POST" action="<?php echo base_url();?>Attendance_ctrl/add_attendance" enctype="multipart/form-data">
			<div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Medium</label>
					<div class="col-sm-10">
						<?php if(isset($medium)){?>
							<select class="form-control" name="medium" id="medium">
								<option value="<?php echo $medium; ?>"><?php echo $medium; ?></option>
						</select>	
						<?php } else { ?>
						<select class="form-control" name="medium" id="medium">
							<option value="0">Select Medium</option>
							<option value="Hindi">Hindi</option>
							<option value="English">English</option>
						</select>
						<?php } ?>
						<div id="medium_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Select Term</label>
					<div class="col-sm-10">
						<select class="form-control" name="term" id="term">
							<option value="0">Select Term</option>
							<option value="Mid">Mid Term</option>
							<option value="Annual">Annual</option>
						</select>
						<div id="term_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Class</label>
					<div class="col-sm-10">
						<select class="form-control" name="class" id="class">
						<option value="0">Select Class</option>
							<?php foreach($classes as $class){ ?>
								<option value="<?php echo $class['c_id']; ?>"><?php echo $class['name']; ?></option>		
							<?php } ?>
						</select>
						<div id="class_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
					<select class="form-control" name="section" id="section">
						<option value="0">Select Section</option>
					</select>
					<div id="section_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				
				<div class="form-group" id="fit_section" style="display:none;">
                    <label class="col-sm-2 control-label">Fit</label>
					<div class="col-sm-10">
					<select class="form-control" name="section" id="fit">
						<option value="0">Select fit</option>
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
					<div id="fit_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group" id="subject_group" style="display:none;">
                    <label class="col-sm-2 control-label">Subject group</label>
					<div class="col-sm-10">
					<select class="form-control" name="section" id="s_group">
						<option value="0" selected>Select Subject group</option>
						<option value="Maths">Maths</option>
						<option value="Boilogy">Biology</option>
						<option value="Commerce">Commerce</option>
						<option value="Arts">Arts</option>
					</select>
					<div id="s_group_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group" id="elective_section" style="display:none;">
                    <label class="col-sm-2 control-label">Elective Subject</label>
					<div class="col-sm-10">
					<select class="form-control" name="section" id="elective">
						<option value="0">Select Elective subject</option>
							<?php foreach($electives as $elective){ ?>
								 <option value="<?php echo $elective['sub_id']; ?>"><?php echo $elective['name']; ?></option>
							<?php } ?>
					</select>
					<div id="elective_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-2 control-label">Enter Max Present Days</label>
                  <div class="col-sm-10">
                  	<input type="number" name="working_day" id="working_day" class="form-control" placeholder="Enter max present days" disabled>
                  	<div id="working_day_err" class="text-danger" style="display: none;"></div>
                  </div>
                </div>
			</div>
			<div class="box-footer">
				<button id="form_submit" type="button" class="btn pull-right btn-info">Search</button>
				<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
         
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable" id="student_list_atten" style="display: none;">

          <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">All Student Attendance Entry/Update</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
            	<table class="table table-hover text-center t-input-center">
                	<thead><tr>
                  		<th>S.No.</th>
                  		<th>Student Name</th>
                  		<th>Addmission No.</th>
                  		<th>Roll No.</th>
                  		<th>Class/Section</th>
				  		<th>Days</th>
                		</tr></thead>
					<tbody id="student_list">
					</tbody>
				</table>
       		</div>
			<div class="box-footer">
				<button id="submit" type="button" style="display: none;" class="btn pull-right btn-info">Submit</button>
            </div>
      </div>
        </section>
      </div>

    </section>
  </div>
  
  
  <script>
  var baseUrl = $('#base_url').val();

  var medium,term,working_day,classes,section,fit,subject_group,elective;

	function form_value(){
		medium = $('#medium').val();
		term = $('#term').val();
		working_day = $('#working_day').val();
		classes = $('#class').val();
		section = $('#section').val();
		fit = $('#fit').val();
		subject_group = $('#s_group').val();
		elective = $('#elective').val();

		var formvalid = true;
		if($('#medium').val() == '0'){
			formvalid = false;
			$('#medium_err').html('Please Select Medium.').css('display','block');
		} else {
			$('#medium_err').css('display','none');
		}
		
		if($('#term').val() == '0'){
			formvalid = false;
			$('#term_err').html('Please Select Term.').css('display','block');
		} else {
			$('#term_err').css('display','none');
		}

		if($('#working_day').val() == ''){
			formvalid = false;
			$('#working_day_err').html('Please Enter Working Days.').css('display','block');
		} else {
			$('#working_day_err').css('display','none');
		}
		
		if($('#class').val() == '0'){
			formvalid = false;
			$('#class_err').html('Please Enter Class.').css('display','block');
		} else {
			$('#class_err').css('display','none');
		}

		if($('#section').val() == '0'){
			formvalid = false;
			$('#section_err').html('Please Enter Section.').css('display','block');
		} else {
			$('#section_err').css('display','none');
		}
		
		if(formvalid){
			return true;
		}
		else{
			return false;
		}
	}
	
 $(document).on('change','#section',function(){
	if(form_value()){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Attendance_ctrl/attendance_check',
			dataType: "json",
			data: {
				'medium':medium,
				'class':classes,
				'section':section 
			},
			beforeSend: function(){
				$('#form_submit').prop('disabled', false);
			},
			success:  function (response) {
				if(response.status == 500){
						//$('#form_submit').prop('disabled', true);
				}
			}
		});				
	}
 });
	
  $(document).on('click','#form_submit',function(){
		if(form_value()){
			$.ajax({
				type: 'POST',
				url: baseUrl+'Student_ctrl/student_list_attendance',
				dataType: "json",
				data: {
					'medium':medium,
					'class':classes,
					'section':section,
					'fit' :fit,
					's_group' :subject_group,
					'elective': elective,
					'term' : $('#term').val()
				},
				beforeSend: function(){
					$('#loader').modal('show');
				},
				success:  function (response) {
                    $('#loader').modal('toggle');
					console.log(response);
					var x = '';
					var c = 1;
                    if(response.status == 200) {
                        $('#submit').show();
                        $('#student_list_atten').show();
					$.each(response.data,function(key,value){
						x = x + '<tr>'+
									'<td>'+ c +'</td>'+
									'<td>'+ value.name +'</td>'+
									'<td>'+ value.admission_no +'</td>'+
									'<td>'+ value.roll_no +'</td>'+
									'<td>'+ value.cname +' / '+ value.secname +'</td>';
									if(response.flag){
										if(value.present){
										x = x + '<td><input type="number" class="attendance_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ working_day +'" max="'+ working_day +'" value="'+ value.present +'" disabled="disabled"></td>';
										}
										else{
											x = x + '<td><input type="number" class="attendance_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ working_day +'" max="'+ working_day +'" value="" disabled="disabled"></td>';
										}
									}
									else{
										if(value.present){
										x = x + '<td><input type="number" class="attendance_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ working_day +'" max="'+ working_day +'" value="'+ value.present +'"></td>';
										}
										else{
											x = x + '<td><input type="number" class="attendance_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ working_day +'" max="'+ working_day +'" value=""></td>';
										}
									}
							
								x = x + '</tr>';  
					c++;
					});
					$('#student_list').html(x);
	  			}
			        else if(response.status==500){
			        	$('#submit').hide();
			        	$('#student_list_atten').hide();
			        	$('#student_list').html('<tr><td colspan="6"><h4 class="text-center"><b>No Students Record Found.</b></h4></td></tr>');
				   		alert("No Student Record ");	
			        }
               }
			});
		}
  });


  $(document).on('change','#class',function(){
	  var c_id = $(this).val();
	  $.ajax({
			type: 'GET',
			url: baseUrl+'Class_ctrl/section_list_class_teacher/'+c_id,
			dataType: "json",
			data: {
				'c_id':c_id
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				var x = '<option value="0">Select Section</option>';
				$.each(response.data,function(key,value){
					x = x+ '<option value="'+ value.id +'">'+ value.name +'</option>';
				});
				$('#section').html(x);
			}
	  });
	  if(c_id == 14 || c_id == 15){
			//$('#subject_group').show();
			//$('#elective_section').show();
		}
		else{
			$('#subject_group').hide();
			//$('#elective_section').hide();
		}

		if(c_id == 12 || c_id == 13){
			//$('#fit_section').show();
		}
		else{
			//$('#fit_section').hide();
		}
  });

  $(document).on('blur','.attendance_box',function(){
	//$(document).on('keyup','.subject_mark_box,.notebook_mark,.subj_assis',function(){
		var max = $(this).data('max');
	  	var val = $(this).val();
//	   	if(val > max){
	  		if(val > max || val == ''){
	  	  	$(this).css('box-shadow','0px 0px 10px red');
		  	$(this).focus();
		  	//$('.attendance_box').attr('disabled',true);
	  	}	
	  	else{
	  		$('.attendance_box').attr('disabled',false);
	  	  	$(this).css('box-shadow','none');
	  	}
	});

	$(document).on('keyup','disabled',function(){
		var max = $(this).data('max');
	  	var val = $(this).val();
	  	
	  	if(val > max){
	  	  	$(this).css('box-shadow','0px 0px 10px red');
		  	$(this).focus();
	  	}	
	  	else{
	  	  	$(this).css('box-shadow','none');
	  	}
	});

  $(document).on('click','#submit',function(){
	  var attendance = [];
	  var flag = 1;
	  $(".attendance_box").each(function() {
		  	var temp = {};
		    temp.val = $(this).val();
		    if($(this).val() == ''){
			    $(this).focus();
			    flag = 0;
		    }
		    temp.s_id = $(this).data('s_id');
		    attendance.push(temp);
		});
		if(flag){
			atten(attendance);
		}
  });

  function atten(attendance){
	  console.log(attendance);
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Attendance_ctrl/add_attendance',
			dataType: "json",
			data: {
				'medium': medium,
				'class' : classes,
				'section' : section,
				'term' : term,
				'working_day' : working_day,
				 'record' : attendance
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			success:  function (response) {
				$('#loader').modal('toggle');
				alert('Student Attendance Record Submitted.');
				location.reload();
			}
	  });
  }

  $(document).on('change','#class',function(){
	  var term = $('#term').val();
	  var class_id = $('#class').val();
	  var medium = $('#medium').val();
	  $('#working_day').val('');
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Attendance_ctrl/session_attendance',
			dataType: "json",
			data: {
				'term' : term,
				'class' : class_id,
				'medium' : medium 
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			success:  function (response) {
				console.log(response);
				$('#loader').modal('toggle');
				if(response.status == 200){
					$('#working_day').val(response.data[0].days);
				}
				else{
					$('#form_submit').prop('disabled', true);
				}
			}
	  });
  });
  </script>