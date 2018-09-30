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
			
				
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Student Name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="student_name" name="student_name" placeholder="Enter Student Name" />	
						<div class="text-danger" id="student_name_err" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Session</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="student_name" name="student_name" placeholder="Enter Student Name" />	
						<div class="text-danger" id="student_name_err" style="display:none;"></div>
					</div>
				</div>
				
			</div>
		</form>	
		</div>
        </section>
	</div>
    </section>
  </div>

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
					$.each(response.result, function(key, value){
								
					});
					}
				},
		});
}
	
});

		
</script>
  
  
  
  
  
  
  
  
  