<div class="content-wrapper">
    <section class="content-header">
   		<h1>11th - 12th Marks Entry Check</h1>
    	<ol class="breadcrumb">
        	<li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        	<li class="active">Marksheet Preview</li>
      	</ol>
    </section>

    <section class="content">
      	<div class="row">
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
									<select class="form-control" id="session">
										<option value="0">Select Session</option>
											<?php foreach($sessions as $session){ ?>
											<?php if($current_session == $session['session_id']){ ?>
												<option value="<?php echo $session['session_id'];?>" selected><?php echo $session['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $session['session_id'];?>"><?php echo $session['name']; ?></option>
											<?php } ?>
										<?php } ?>
								</select>
								<div class="text-danger" id="session_err" style="display:none;"></div>
							</div>
						</div>				
						<div class="form-group col-sm-4">
                    		<label class="col-sm-2 control-label">Medium</label>
							<div class="col-sm-10">
								<select class="form-control" id="medium">
									<option value="0">Select Medium</option>
									<option value="Hindi">Hindi</option>
									<option value="English">English</option>
								</select>
								<div class="text-danger" id="medium_err" style="display:none;"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-4">
                    		<label class="col-sm-2 control-label">Class</label>
							<?php 
							$this->db->select('*');
							$this->db->where('c_id >=', 14);
							$class = $this->db->get_where('class', array('status'=>1))->result_array();
							?>
							<div class="col-sm-10">
								<select class="form-control" id="class">
									<option value="0">Select Class</option>
									<?php foreach($class as $cl){?>
									<option value="<?php echo $cl['c_id'];?>"><?php echo $cl['name'];?></option>
									<?php } ?>
								</select>
								<div class="text-danger" id="class_err" style="display:none;"></div>
							</div>
						</div>
						
						
						<div class="form-group col-sm-4">
                    		<label class="col-sm-2 control-label">Section</label>
                    		<?php 
                    		  $this->db->select('*');
                    		  $section = $this->db->get_where('section', array('status'=>1))->result_array();
                    		?>
							<div class="col-sm-10">
								<select class="form-control" id="section">
									<option value="0">Select Section</option>
									<?php foreach($section as $sec){?>
										<option value="<?php echo $sec['id'] ;?>"><?php echo  $sec['name'];?></option>
									<?php } ?>
								</select>
								<div class="text-danger" id="section_err" style="display:none;"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-4">
                    		<label class="col-sm-2 control-label">Subject Group</label>
							<div class="col-sm-10">
								<select class="form-control" id="s_group">
            						<option value="0">Select Subject Group</option>
            						<option value="maths">Maths</option>
            						<option value="bio">Biology</option>
            						<option value="comm">Commerce</option>
            						<option value="art">Arts</option>
            					</select>
								<div class="text-danger" id="sub_err" style="display:none;"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-4">
                    		<label class="col-sm-2 control-label">Exam Type</label>
                    		<?php 
                    		  $this->db->select('*');
                    		  $exam_type = $this->db->get_where('exam_type', array('status'=>1))->result_array();
                    		?>
							<div class="col-sm-10">
								<select class="form-control" id="exam_type">
									<option value="0">Select Exam Type</option>
									<?php foreach($exam_type as $type){?>
									<option value="<?php echo $type['e_id'];?>"><?php echo $type['e_name'];?></option>
									<?php }?>
								</select>
								<div class="text-danger" id="exam_type_err" style="display:none;"></div>
							</div>
						</div>

					</div>
					<div class="box-footer">
						<button type="button" class="btn pull-right btn-info btn-space" id="search">Search</button> 
            		</div>            
				</form>
			</div>
        </section>
		<section class="col-lg-12 connectedSortable">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Marks Entry List</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body" id="subject_list">
				
				</div>
			</div>
		</section>
	</div>
    </section>   
  </div>
 
<script type="text/javascript">
$(document).on('click','#search',function(){
	var session = $('#session').val();
	var medium = $('#medium').val();
	var class_id = $('#class').val();
	var s_group = $('#s_group').val();
	var section = $('#section').val();
	var exam_type = $('#exam_type').val();
	var formvalid = true;
	
	if(session == 0){
		$('#session_err').html('Please Select Session.').css('display','block');
		formvalid = false;
	}
	else{
		$('#session_err').css('display','none');
	}
	if(medium == 0){
		$('#medium_err').html('Please select Medium.').css('display','block');
		formvalid = false;
		}else{
		$('#medium_err').css('display','none');
	}

	if(class_id == 0){
		$('#class_err').html('Please select class.').css('display','block');
		formvalid = false;
		}else{
		$('#class_err').css('display','none');
	}

	if(class_id == 0){
		$('#sub_err').html('Please select Subject group.').css('display','block');
		formvalid = false;
		}else{
		$('#sub_err').css('display','none');
	}

	if(section == 0){
		$('#section_err').html('Please select section.').css('display','block');
		formvalid = false;
		}else{
		$('#section_err').css('display','none');
	}

	if(exam_type == 0){
		$('#exam_type_err').html('Please select Exam Type.').css('display','block');
		formvalid = false;
		}else{
		$('#exam_type_err').css('display','none');
	}

	if(formvalid){
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>Class_ctrl/marks_entry_check_heigh_class',
			dataType: "json",
			data: {
				'session' : session,
				'medium' : medium,
				's_group':s_group,
				'class' : class_id,
				'section' : section,
				'exam_type' : exam_type
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			success:  function (response) {
				$('#loader').modal('toggle');
				if(response.status == 200){
					console.log(response);
					var x = '<table class="table table-hover"><tbody><thead><th>S.No.</th><th>Subjects</th><th>Marks Entry</th></thead>';
					var i = 1;
					$.each(response.matchsub,function(key,value){
							x = x + '<tr class="green">'+
									 '<td>'+ value.subject +'('+ value.type +')</td><th><img src="'+'<?php echo base_url();?>assest/images/right.png" /></th>'+
									'</tr>';
					});
					$.each(response.notmatchsub,function(key,value){
						x = x + '<tr class="green">'+
								 '<td>'+ value.subject +'('+ value.type +')</td><th><img src="'+'<?php echo base_url();?>assest/images/wrong.png" /></th>'+
								'</tr>';
				});
					
					
					x = x + '</tbody></table>';
					$('#subject_list').html(x);
				}else{
					alert(response.msg);
				}
			}
		});

		}
});


 </script>
 
 
 
 
 
 
 
 