<div class="content-wrapper">
	<section class="content-header">
      <h1>
        Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>Admin_ctrl/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Profile</li>
      </ol>
    </section>
    
    <?php 
        $uid = $this->session->userdata('user_id');
        
        $this->db->select('uid,t_id');
        $reuslt = $this->db->get_where('users', array('uid'=>$uid))->result_array();
        $user_id = $reuslt[0]['uid'];
        $t_id = $reuslt[0]['t_id']; 
        
        $this->db->select('*');
        $t_data = $this->db->get_where('teacher', array('t_id' => $t_id))->result_array();
        ?>

    <!-- Main content -->
    <section class="content">
      <div class="row">    
        <section class="col-lg-6 connectedSortable ui-sortable">
        <div class="box box-success">
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Update Profile</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="profile_form" name="profile_form" role="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
			<div class="box-body" style="display: block;">
				
				<input type="hidden" name="id" id="id" value="<?php echo $t_data[0]['t_id'];?>" />
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Teacher Name</label>
                  <div class="col-sm-9">
                  	<input type="hidden" name="t_id" id="t_id">
                  	<input type="text" name="name" id="name" class="form-control" value="<?php echo $t_data[0]['name']; ?>" placeholder="Enter teacher name">
                  	<div id="name_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label">Gender</label>
					<div class="col-sm-9">
					<select class="form-control" name="gender" id="gender">
					<?php if(($t_data[0]['gender'])=='Male'){?>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					<?php }else{?>
						<option value="Female">Female</option>
						 <option value="Male">Male</option>
					<?php }?>
					</select>
					<div id="gender_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Email ID</label>
                  <div class="col-sm-9">
                  	<input type="text" name="email" id="email" class="form-control" value="<?php echo $t_data[0]['email']; ?>" placeholder="Enter email id" required="">
                  	<div id="email_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Permanent Address</label>
                  <div class="col-sm-9">
                  	<textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter permanent address"><?php echo $t_data[0]['address']; ?></textarea>
                  	<div id="address_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Mobile/Phone No.</label>
                  <div class="col-sm-9">
                  	<input type="text" name="phone" id="phone" class="form-control" value="<?php echo $t_data[0]['phone']; ?>" onkeypress="phoneno()" maxlength="10" placeholder="Enter contact no.">
                  	<div id="phone_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Date Of Birth</label>
					<div class="col-sm-9">
					<div class="input-group date">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
					  <input name="dob" type="text" class="form-control pull-right" id="datepicker2" value="<?php echo date("d-m-Y",strtotime($t_data[0]['dob'])); ?>">
					</div>
					<div id="dob_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Qualification</label>
                  <div class="col-sm-9">
                  	<input name="qualif" id="qualif" type="text" class="form-control" value="<?php echo $t_data[0]['qualification']; ?>" placeholder="Enter teacher name">
                  	<div id="qualif_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Designation</label>
                  <div class="col-sm-9">
                  	<input name="design" id="design" type="text" class="form-control" value="<?php echo $t_data[0]['designation']; ?>" placeholder="Enter teacher name">
                  	<div id="design_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
				<label class="col-sm-3 control-label" for="exampleInputFile">Profile Image</label>
                 
				<?php  $school = strtolower($this->session->userdata('school')); 
				$base_url = base_url(); 
				$path = $base_url."/photos/teachers/"."$school"."/";
				$target_dir  = './photos/teachers/'.$school.'/';
				?>
				<div class="col-sm-9">
				<input type="hidden" name="old_image" id="old_image" value="<?php echo $t_data[0]['photo'];?>">
           			<?php if(!empty($t_data[0]['photo']) && file_exists($target_dir.$t_data[0]['photo'])) { ?>
     					<img src="<?php echo $path.$t_data[0]['photo'];?>" style="height:100px;" width="100px;">
							<?php } else{ 
							                echo "No pic"; 
							         } ?>
				 </div>
             </div>
             
                 <div class="form-group">
                 <label class="col-sm-3 control-label" for="exampleInputFile"></label>
                  <div class="col-sm-9">
                  	<input type="file" id="userFile" name="userFile">
                  </div>
               
			</div>
			<div class="box-footer" style="display: block;">
				<button type="button" id="form_update" class="btn pull-right btn-info">Submit</button>
				<button type="reset" onclick="wintop()" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
        </section>
        

        <section class="col-lg-6 connectedSortable ui-sortable">
        <div class="box box-warning">
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Update Passwrod</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="update_pass" name="update_pass" role="form" class="form-horizontal" method="POST">
			<div class="box-body" style="display: block;">
				
				<input type="hidden" name="users_id" id="users_id" value="<?php echo $user_id; ?>" />
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Old Pass</label>
                  <div class="col-sm-9">
                  	<input type="text" name="old_pass" id="old_pass" class="form-control" placeholder="Old Pass">
                  	<div id="old_pass_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">New Password</label>
                  <div class="col-sm-9">
                  	<input type="text" name="new_pass" id="new_pass" class="form-control" placeholder="New Pass">
                  	<div id="new_pass_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">Confirm Password</label>
                  <div class="col-sm-9">
                  	<input type="text" name="confirm_pass" id="confirm_pass" class="form-control" value="<?php ?>" placeholder="confirm Pass">
                  	<div id="confirm_pass_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
			
			</div>
			<div class="box-footer" style="display: block;">
				<button type="button" id="pass_update" class="btn pull-right btn-info">Submit</button>
				<button type="reset" onclick="wintop()" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
        </section>
      </div>
    </section>
  </div>
  
 <script type="text/javascript"> 

$(document).on('click', '#form_update', function(){
	var id = $('#id').val();
	var name = $('#name').val();
	var gender = $('#gender').val(); 
	var email = $('#email').val();
	var address = $('#address').val();
	var phone = $('#phone').val();
	var datepicker2 = $('datepicker2').val();
	var qualif = $('#qualif').val();
	var design = $('#design').val();
	var old_image = $('#old_image').val();
	var formvalid = true;

	if(name == 0){
		$('#name_err').html('Please Enter Name.').css('display','block');
		formvalid = false;
	}else{ $('#name_err').css('display','none'); }


	if(gender == 0){
		$('#gender_err').html('Please Select Gender.').css('display','block');
		formvalid = false;
	}else{ $('#gender_err').css('display','none'); }

	if(email == 0){
		$('#email_err').html('Please Enter Email Id.').css('display','block');
		formvalid = false;
	}else{ $('#email_err').css('display','none'); }

	if(address == 0){
		$('#address_err').html('Please Enter Address.').css('display','block');
		formvalid = false;
	}else{ $('#address_err').css('display','none'); }

	if(phone == 0){
		$('#phone_err').html('Please Enter Phone Number.').css('display','block');
		formvalid = false;
	}else{ $('#phone_err').css('display','none'); }

	if(datepicker2 == 0){
		$('#dob_err').html('Please Enter DOB.').css('display','block');
		formvalid = false;
	}else{ $('#dob_err').css('display','none'); }

	if(qualif == 0){
		$('#qualif_err').html('Please Enter Qualifications.').css('display','block');
		formvalid = false;
	}else{ $('#qualif_err').css('display','none'); }

	if(design == 0){
		$('#design_err').html('Please Enter Designation.').css('display','block');
		formvalid = false;
	}else{ $('#design_err').css('display','none'); }
		
	if(formvalid){
		var formdata = new FormData();
		formdata.append('id',$('#id').val());
		formdata.append('name',$('#name').val());
		formdata.append('gender',$('#gender').val());
		formdata.append('email',$('#email').val());
		formdata.append ('address',$('#address').val());
		formdata.append ('phone',$('#phone').val());
		formdata.append ('dob',$('#datepicker2').val());
		formdata.append ('qualif',$('#qualif').val());
		formdata.append ('design',$('#design').val());
		formdata.append ('old_image',$('#old_image').val());
		formdata.append('userFile',$('#userFile')[0].files[0]);

		    $.ajax({
    			type:"POST",
    			url:'<?php echo base_url();?>'+'/Teacher_ctrl/update_t_profile',
    			dataType : 'json',
    			data:formdata,
				async:false,
				beforeSend : function(){
					$('#loader').modal('show');
					},
				success : function(response){
					if(response.status == 200){
						//console.log(response);
						alert(response.msg);
						location.reload();
					}else{
						alert(response.msg);
						$('#loader').modal('hide');
						}
				},
					 cache: false,
					 contentType: false, //must, tell jQuery not to set contentType 
					 processData: false  //must, tell jQuery not to process the data
				
    			});
			}
	});


$(document).on('click', '#pass_update', function(){
	var users_id = $('#users_id').val();
	var old_pass = $('#old_pass').val();
    var new_pass = $('#new_pass').val();
    var confirm_pass = $('#confirm_pass').val();
    var password_valid = true;
   
   if (old_pass==0){
   	$('#old_pass_err').html('Please Enter Old Password').css('display', 'block');
   	password_valid = false;
   }else{
   		$('#old_pass_err').css('display','none');
   }

   if(new_pass==0){
       	$('#new_pass_err').html('Please Enter New Password').css('display','block');
       	password_valid = false;
       }else{
		$('#new_pass_err').css('display','none');
           }
   if(confirm_pass == 0){
       	$('#confirm_pass_err').html('Please Enter Confirm Password').css('display', 'block');
       	password_valid = false;
           }else if(confirm_pass != new_pass){
				$('#confirm_pass_err').html('Password Not Match').css('display','block');
				password_valid = false;
               }else{
					$('#confirm_pass_err').css('display','none');
                   }

   
	if(password_valid){

		$.ajax({
				type:"POST",
				url:'<?php echo base_url();?>'+'/Teacher_ctrl/update_t_pass',
				dataType : 'json',
				data:{
						users_id : users_id,
						old_pass : old_pass,
						confirm_pass : confirm_pass
					},
				beforeSend : function(){
					$('#loader').modal('show');
					},
				success : function(response){
					if(response.status == 200){
						//console.log(response);
						alert(response.msg);
						location.reload();
					}else{
						alert(response.msg);
						$('#loader').modal('hide');
						}
					},
				
			});
		
		}
});



 </script>
  
  
  
  
  