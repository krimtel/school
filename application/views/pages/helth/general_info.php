<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        General Information
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">General Infromation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Search Marksheet</h3>
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
						<select class="form-control" id="session" name="session">
							<option value="0">Select Session</option>
						</select>
						<div class="text-danger" id="session_err" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Medium</label>
					<div class="col-sm-10">
							<select class="form-control" id="medium" name="medium">
								<option value="">Select Medium</option>
								<option value="Hindi">Hindi</option>
								<option value="English">English</option>
							</select>
						<div class="text-danger" id="medium_err" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Class</label>
					<div class="col-sm-10">
						<select class="form-control" id="class" name="class">
						<option value="0">Select Class</option>
						</select>
						<div class="text-danger" id="class_err" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
					<select class="form-control" id="section" name="section">
						<option value="0">Select Section</option>
					</select>
					<div class="text-danger" id="section_err" style="display:none;"></div>
					</div>
				</div>	
				
				<div class="form-group col-sm-4" id="s_group" style="display:none;">
                    <label class="col-sm-2 control-label">Sub Group</label>
					<div class="col-sm-10">
					<select class="form-control" id="sub_group" name="sub_group">
						<option value="">Select Subject Group</option>
						<option value="maths">Maths</option>
						<option value="bio">Biology</option>
						<option value="commer">Commerce</option>
						<option value="art">Arts</option>
					</select>
					<div class="text-danger" id="sub_group_err" style="display:none;"></div>
					</div>
				</div>	
				<div class="box-footer">
				<button type="button" id="search" name="search" class="btn pull-right btn-info btn-space">Search</button>
            	</div>
				
			</div>
			</form>
		</div>
        </section>
	</div>
    </section>
    
    
     <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Entry Primary helth report</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
				<table class="table table-hover text-center t-input-center">
					<thead>
					 <tr>
    					<th>Sr No.</th>
    					<th>Student Name</th>
    					<th>Clsss</th>
    					<th>Section</th>
    					<th>Sub_Group</th>
    					<th>Action</th>
    				</tr>
					</thead>
					<tbody id="student_record"></tbody>
				</table>
		</div>
        </section>
	</div>
    </section>
  </div>

<!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" data-toggle="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
              </div>
              <div class="modal-body">
               		<form class="form-horizontal" role="form" id="update_goods" method="post">
						<input type="hidden" id="g_id" name="g_id">
						<input type="hidden" id="session_id" name="session_id">
						<input type="hidden" id="school_id" name="school_id">
						<input type="hidden" id="mod_medium" name="mod_medium">
						<input type="hidden" id="mod_sub_group" name="mod_sub_group">
						<input type="hidden" id="s_id" name="s_id">
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Activity Date</label>
								<div class="col-sm-6">
									<input type="date" name="activity_date" id="activity_date" value="" class="form-control" placeholder="Activity Date">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Adhar card no</label>
								<div class="col-sm-6">
									<input type="text" name="adhar_no" id="adhar_no" value="" class="form-control" placeholder="Adhar Card Number">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Name</label>
								<div class="col-sm-6">
									<input type="text" name="name" id="name" value="" class="form-control" placeholder="Name">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Admmission No</label>
								<div class="col-sm-6">
									<input type="text" name="admission_no" id="admission_no" value="" class="form-control" placeholder="Admission No">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">DOB</label>
								<div class="col-sm-6">
									<input type="text" name="dob" id="dob" value="" class="form-control" placeholder="Date of Birth">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">M F T</label>
								<div class="col-sm-6">
									<input type="text" name="mft" id="mft" value="" class="form-control" placeholder="M F T">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Blood Group</label>
								<div class="col-sm-6">
									<input type="text" name="blood_group" id="blood_group" value="" class="form-control" placeholder="Bloop Group">
								</div>
							</div>
							<t4>Mother's Details</t4>
							<div class="form-group">
								<label class="col-sm-3 control-label">Mother Name</label>
								<div class="col-sm-6">
									<input type="text" name="m_name" id="m_name" value="" class="form-control" placeholder="Mother Name">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">DOB*</label>
								<div class="col-sm-6">
									<input type="date" name="m_dob" id="m_dob" value="" class="form-control" placeholder="DOB">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Weight</label>
								<div class="col-sm-6">
									<input type="text" name="m_weight" id="m_weight" value="" class="form-control" placeholder="Weight">
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Height</label>
								<div class="col-sm-6">
									<input type="text" name="m_height" id="m_height" value="" class="form-control" placeholder="Height">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Blood Group</label>
								<div class="col-sm-6">
									<input type="text" name="m_blood_group" id="m_blood_group" value="" class="form-control" placeholder="Blood group">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Adhar Number</label>
								<div class="col-sm-6">
									<input type="text" name="m_adhar" id="m_adhar" value="" class="form-control" placeholder="Adhar Number">
								</div>
							</div>

							
									<t4>Father's Details</t4>
							<div class="form-group">
								<label class="col-sm-3 control-label">Father Name</label>
								<div class="col-sm-6">
									<input type="text" name="f_name" id="f_name" value="" class="form-control" placeholder="Father Name">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">DOB*</label>
								<div class="col-sm-6">
									<input type="date" name="f_dob" id="f_dob" value="" class="form-control" placeholder="DOB">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Weight</label>
								<div class="col-sm-6">
									<input type="text" name="f_weight" id="f_weight" value="" class="form-control" placeholder="Weight">
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Height</label>
								<div class="col-sm-6">
									<input type="text" name="f_height" id="f_height" value="" class="form-control" placeholder="Height">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Blood Group</label>
								<div class="col-sm-6">
									<input type="text" name="f_blood_group" id="f_blood_group" value="" class="form-control" placeholder="Blood group">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Adhar Number</label>
								<div class="col-sm-6">
									<input type="text" name="f_adhar" id="f_adhar" value="" class="form-control" placeholder="Adhar Number">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Family Monthly Income</label>
								<div class="col-sm-6">
									<input type="text" name="month_income" id="month_income" value="" class="form-control" placeholder="Family Monthly Income">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Family Monthly Income</label>
								<div class="col-sm-6">
									<textarea rows="" cols="" id="address" name="address" class="form-control"></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Phone Number</label>
								<div class="col-sm-6">
									<input type="text" name="phone" id="phone" value="" class="form-control" placeholder="Phone Number">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Mobile Number</label>
								<div class="col-sm-6">
									<input type="text" name="mobile" id="mobile" value="" class="form-control" placeholder="Mobile Number">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">CWSN,SPECIFY</label>
								<div class="col-sm-6">
									<input type="text" name="cwsn_specify" id="cwsn_specify" value="" class="form-control" placeholder="CWSN,SPECIFY">
								</div>
							</div>
							

							<div class="form-group m-b-0">
								<div class="col-sm-offset-3 col-sm-9">
									<button type="button" name="submit" id="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
									<button type="reset" class="btn btn-default waves-effect waves-light">Reset</button>
								</div>
							</div>
						</form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        
          </div>
        </div> <!-- End of Modal -->



<script type="text/javascript">
	$.ajax({
		type:'POST',
		url:'<?php echo base_url();?>Helth_ctrl/select_box_data',
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			console.log(response);
			var x = '<option value="">Select Session</option>';
			var c = '<option value="">Select Class</option>';
			var s = '<option value="">Select Section</option>';
			
			if(response.status == 200){
					$.each(response.result.session, function(key, value){
						x = x + '<option value="'+value.session_id+'">'+value.name+'</option>';
					});
					$('#session').html(x);

					$.each(response.result.class, function(key, value){
						c = c + '<option value="'+value.c_id+'">'+value.name+'</option>';
					});
					$('#class').html(c);

					$.each(response.result.section, function(key, value){
						s = s + '<option value="'+value.id+'">'+value.name+'</option>';
					});
					$('#section').html(s);
				}
			},
		});

//----------if selected class xi and xii then show class gruoup-------------------------------
	 $('#class').on('change', function() {
	      if ( (this.value == '14') || (this.value == '15'))
	      {
	        $("#s_group").show();
	      }
	      else
	      {
	        $("#s_group").hide();
			$('#sub_group').val('');
	      }
	    });

$(document).on('click', '#search', function(){
	var session = $('#session').val();
	var medium = $('#medium').val();
	var class_id = $('#class').val();
	var section = $('#section').val();
	var sub_group = $('#sub_group').val();
	var formvalid = true;

	if(session == ''){
		$('#session_err').html('Session is required.').css('display','block');
		formvalid = false;
		}else{
			$('#session_err').css('display','none');
			formvalid = true;		
			}
	if(medium == ''){
		$('#medium_err').html('Medium is required.').css('display','block');
		formvalid = false;
		}else{
			$('#medium_err').css('display','none');
			formvalid = true;		
			}
	if(class_id == ''){
		$('#class_err').html('Class is required.').css('display','block');
		formvalid = false;
		}else{
			$('#class_err').css('display','none');
			formvalid = true;		
			}
	if(section == ''){
		$('#section_err').html('Section is required.').css('display','block');
		formvalid = false;
		}else{
			$('#section_err').css('display','none');
			formvalid = true;		
			}

	if((class_id == '14') || (class_id == '15')){
		if(sub_group == ''){
		$('#sub_group_err').html('Subject Group is required.').css('display','block');
		formvalid = false;
		}else{
			$('#sub_group_err').css('display','none');
			formvalid = true;		
			}
		}
if(formvalid){
	$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>Helth_ctrl/search_data',
			dataType:'json',
			data:{
				session : session,
				medium : medium,
				class_id : class_id, 
				section : section, 
				sub_group: sub_group
				},
			beforeSend:function(){},
			success:function(response){
				console.log(response);
				if(response.status == 200){
					var x='';
					var i = 1;
					$.each(response.result, function(key, value){
						x = x + '<tr>'+
        						'<td>'+i+'</td>'+
        				        '<td>'+value.name+'</td>'+
						        '<td>'+value.class_name+'</td>'+
						        '<td>'+value.section_name+'</td>'+
						        '<td>'+value.subject_group+'</td>'+
						        '<td><button type="button" data-s_id="'+value.s_id+'" data-admiss_no="'+value.admission_no+'" data-medium="'+value.medium+'" data-class_id="'+value.class_id+'" data-section="'+value.section+'" data-subject_group="'+value.subject_group+'" class="btn btn-primary btn-sm editbtn"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
		    					'<button type="button" data-s_id="'+value.s_id+'" data-admiss_no="'+value.admission_no+'" data-medium="'+value.medium+'" data-class_id="'+value.class_id+'" data-section="'+value.section+'" data-subject_group="'+value.subject_group+'" class="btn btn-success btn-sm print"><span class="glyphicon glyphicon-print"></span> Print </button></td>'+
						        '</tr>';
				        i++;
					});
					$('#student_record').html(x);
					}else{
						$('#student_record').html('<tr><td class="text-center" colspan="6"><b>No record found.</b></td></tr>');
						}
				},
		});
}
	
});
//--------------print section ----------------------------------------
$(document).on('click','.print', function(){
	var s_id = $(this).data('s_id');
	var admission_no = $(this).data('admiss_no');
	var class_id = $(this).data('class_id');
	var section = $(this).data('section');
	var subject_group = $(this).data('subject_group');
	var medium = $(this).data('medium');
	$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>Helth_ctrl/print_data',
			dataType:'json',
			 data:{
				   s_id : s_id,
				   admission_no : admission_no,
				   class_id : class_id,
				   section : section,
				   subject_group : subject_group,
				   medium : medium
				   },
			beforeSend:function(){},
			success:function(response){
				var win = window.open('<?php echo base_url();?>/hello', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x ='';
				if(response.status == 200){
					$.each(response.result, function(key, value){
						x = x +'<h1>HEALTH AND ACTIVITY CARD</h1>'+
						       '<h1>GENERAL INFORMATION</h1>'+
						       '<P>Aadhar Card no. of students(optional): <span>'+value.adhar_no+'</span></P>'+ 
						       '<P>NAME: <span>'+value.name+'</span></P>'+
						       '<P>ADMISSION NO: <span>'+value.admission_no+'</span> <span>DATE OF BIRTH:'+ value.dob +'</span></P>'+
						       '<P>GENEDER <span>'+value.mft+'</span><span>BLOOD GROUP:'+value.blood_group+'</span></P>'+
						       '<P><b>MOTHERS NAME:</b><span>'+value.m_name+'</span></P>'+
						       '<P>YOB:<span>'+value.m_dob+'</span>WEIGHT:<span>'+value.m_weight+'</span>HEIGHT:<span>'+value.m_height+'</span> BLOOD GROUP:<span>'+value.m_blood_group+'</span></P>'+
						       '<p>AADHAR CARD NO:<span>'+value.m_adhar+'</span></p>'+
						       '<p>FATHER NAME:<span>'+value+f_name+'</span></p>'+
						       '<P>YOB:<span>'+value.f_dob+'</span>WEIGHT:<span>'+value.f_weight+'</span>HEIGHT:<span>'+value.f_height+'</span> BLOOD GROUP:<span>'+value.f_blood_group+'</span></P>'+
						       '<p>AADHAR CARD NO:<span>'+value.f_adhar+'</span></p>'+
						       '<p>FAMILY MONTHLY INCOME:<span>'+value.month_income+'</span></p>'+
						       '<p>ADDRESS:'+value.address+'</p>'+
						       '<P>PHONE NO:<span>'+value.phone+'</span> MOBILE:'+value.mobile+'</P>'+
						       '<P>CWSN, SPECIFY:<span>'+value.cwsn_specify+'</span></P>'+
						       '<P>DATE:<span>'+value.activity_date+'</span></P>';
								});

				  with(win.document){
				      open();
				      write(x);
					  close();
				    }
				}else{
					alert(response.msg);
				}
		},
	});
});





//-----------------work on edit button--------------------------------
$(document).on('click', '.editbtn', function(){
	var s_id = $(this).data('s_id');
	var admission_no = $(this).data('admiss_no');
	var class_id = $(this).data('class_id');
	var section = $(this).data('section');
	var subject_group = $(this).data('subject_group');
	var medium = $(this).data('medium');
	
	$('#myModal').find('.modal-title').text('Edit ');
	$('#myModal').modal({'show':true, backdrop: false, keyboard: false});
	
	$.ajax({
		   type:'POST',
		   url:'<?php echo base_url();?>Helth_ctrl/editData',
		   dataType:'json',
		   data:{
			   s_id : s_id,
			   admission_no : admission_no,
			   class_id : class_id,
			   section : section,
			   subject_group : subject_group,
			   medium : medium
			   },
		   beforeSend: function(){},
			success: function (response){
				console.log(response);
			if(response.status == 200){
				$.each(response.result,function(key,value){
					   $('#g_id').val(value.g_id);
					   $('#session_id').val(value.session_id);
					   $('#school_id').val(value.school_id);
					   $('#mod_medium').val(value.medium);
					   $('#mod_sub_group').val(value.subject_group);
					   $('#s_id').val(value.s_id);
					   $('#activity_date').val(value.activity_date);
					   $('#adhar_no').val(value.adhar_no);
					   $('#name').val(value.name);
					   $('#admission_no').val(value.admission_no);
					   $('#dob').val(value.dob);
					   $('#mft').val(value.mft);
					   $('#blood_group').val(value.blood_group);
					   $('#m_name').val(value.m_name);
					   $('#m_dob').val(value.m_dob);
					   $('#m_weight').val(value.m_weight);
					   $('#m_height').val(value.m_height);
					   $('#m_blood_group').val(value.m_blood_group);
					   $('#m_adhar').val(value.m_adhar);
					   $('#f_name').val(value.f_name);
					   $('#f_dob').val(value.f_dob);
					   $('#f_weight').val(value.f_weight);
					   $('#f_height').val(value.f_height);
					   $('#f_blood_group').val(value.f_blood_group);
					   $('#f_adhar').val(value.f_adhar);
					   $('#month_income').val(value.month_income);
					   $('#address').val(value.address);
					   $('#phone').val(value.phone);
					   $('#mobile').val(value.mobile);
					   $('#cwsn_specify').val(value.cwsn_specify);
				});
			}		
		},
	});

});


$(document).on('click','#submit',function(){
	var formdata = new FormData();
	formdata.append('g_id',$('#g_id').val());
	formdata.append('session_id',$('#session_id').val());
	formdata.append('subject_group',$('#mod_sub_group').val());
	formdata.append('school_id',$('#school_id').val());
	formdata.append('medium',$('#medium').val());
	formdata.append('student_student_id',$('#s_id').val());
	formdata.append('student_admission_no',$('#admission_no').val());
	formdata.append('student_name',$('#name').val());
	formdata.append('student_aadhar_card_no',$('#adhar_no').val());
	formdata.append('student_dob',$('#dob').val());
	formdata.append('student_sex',$('#mft').val());
	formdata.append('student_blood_group',$('#blood_group').val());
	formdata.append('mother_name',$('#m_name').val());
	formdata.append('mother_dob',$('#m_dob').val());
	formdata.append('mother_weight',$('#m_weight').val());
	formdata.append('mother_height',$('#m_height').val());
	formdata.append('mother_blood_group',$('#m_blood_group').val());
	formdata.append('mother_aadhar_card_no',$('#m_adhar').val());
	formdata.append('father_name',$('#f_name').val());
	formdata.append('father_dob',$('#f_dob').val());
	formdata.append('father_weight',$('#f_weight').val());
	formdata.append('father_height',$('#f_height').val());
	formdata.append('father_blood_group',$('#f_blood_group').val());
	formdata.append('father_aadhar_card_no',$('#f_adhar').val());
	formdata.append('monthly_income',$('#month_income').val());
	formdata.append('address',$('#address').val());
	formdata.append('phone_no',$('#phone').val());
	formdata.append('mobile_no',$('#mobile').val());
	formdata.append('children_special_needs',$('#cwsn_specify').val());

	$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>Helth_ctrl/general_activity',
			dataType:'json',
			data:formdata,
			beforeSend:function(){},
			success:function(response){
					if(response.status == 200){
						alert(response.msg);
						//location.reload();
						}else{
							alert("Process Failed.!");
							}
				},
				cache: false,
				contentType: false,
				processData: false,	
		});


	
});

</script>
  
  
  
  
  
  
  
  
  