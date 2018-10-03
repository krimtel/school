<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Health Activity
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Health Activity</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Health Activity</h3>
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
						<?php if(isset($medium)){ ?>
							<select class="form-control" id="medium">
								<option value="<?php echo $medium; ?>"><?php echo $medium; ?></option>
							</select>
						<?php } else { ?>
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
				
				<div class="form-group col-sm-4" style="display: none;">
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
					<select class="form-control" id="s_group">
						<option value="0" selected>Select Subject Group</option>
						<option value="Maths">Maths</option>
						<option value="Boilogy">Boilogy</option>
						<option value="Commerce">Commerce</option>
						<option value="Arts">Arts</option>
					</select>
					<div class="text-danger" id="s_group_err" style="display:none;"></div>
					</div>
				</div>
				
			</div>
			<div class="box-footer">
				<button type="button" class="btn pull-right btn-info btn-space student_search" data-type="final_fard">Search</button> 
            </div>
			</form>
		</div>
        </section>
	
	
	<!-- dynamic data -->
	<section class="col-lg-12 connectedSortable">
		<div class="box box-warning" id="dynamic_data"></div>
	</section>
	</div>
    </section>
  </div>
  
  
  <!--- modal --->
  <div class="modal fade" id="helth_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Health and Activity Record</h4>
      </div>
      <div class="modal-body">
        <table border="1" width="100%">
			<tr>
				<td>Vision</td>
				<td>RE/LE</td>
				<td>
					<input type="text" name="question_1" id="question_1"> 
				</td>
			</tr>
			<tr>
				<td>Ears</td>
				<td>Left/Right</td>
				<td>
					<select id="question_2">
						<option value="0">-Select-</option>
						<option value="good">Good</option>
						<option value="bad">Bad</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Teeth Occlusion</td>
				<td>Caries/Tonsils/ Gums</td>
				<td>
					<select id="question_3">
						<option value="0">-Select-</option>
						<option value="good">Good</option>
						<option value="bad">Bad</option>
					</select>
				</td>
			</tr>
			<tr>
				<td rowspan="2">General Body measurements</td>
				<td>Height</td>
				<td><input type="text" id="question_4_1"></td>
			</tr>
			<tr>
				<td>Weight</td>
				<td><input type="text" id="question_4_2"></td>
			</tr>
			<tr>
				<td rowspan="2">Circumferences</td>
				<td>Hip</td>
				<td><input type="text" id="question_5_1"></td>
			</tr>
			<tr>
				<td>Waist</td>
				<td><input type="text" id="question_5_2"></td>
			</tr>
			<tr>
				<td rowspan="2">Health Status</td>
				<td>Pulse</td>
				<td><input type="text" id="question_6_1"></td>
			</tr>
			<tr>
				<td>Blood Pressure</td>
				<td><input type="text" id="question_6_2"></td>
			</tr>
			<tr>
				<td>Posture Evaluation</td>
				<td><p><u>If any:</u></br> 
							Head Forward/Sunken Chest/Round</br>
							Shoulders/Kyphisis/Lordosis/Adominal</br>  
							Ptosis/Body Lean/Tilted Head/ Shoulders Uneven/Scholiosis/ Flat Feet/Knock Knees/ Bow Legs</p>
				</td>
				<td><select id="question_7">
						<option value="0">-Select-</option>
						<option value="No">No</option>
						<option value="Head_Forward">Head Forward</option>
						<option value="Sunken_Chest">Sunken Chest</option>
						<option value="Round">Round</option>
						<option value="Shoulders">Shoulders</option>
						<option value="Kyphisis">Kyphisis</option>
						<option value="Lordosis">Lordosis</option>
						<option value="Adominal">Adominal</option>
						<option value="Ptosis">Ptosis</option>
						<option value="Body_Lean">Body Lean</option>
						<option value="Tilted_Head">Tilted Head</option>
						<option value="Shoulders_Uneven">Shoulders Uneven</option>
						<option value="Scholiosis">Scholiosis</option>
						<option value="Flat_Feet">Flat Feet</option>
						<option value="Knock_Knees">Knock Knees</option>
						<option value="Bow_Legs">Bow Legs</option>
					</select>
				</td>
			</tr>
			<tr>
				<td rowspan="3"><p><b>Sporting Activities(HPE)</b><br>(For details, see HPE manual available on CBSE website www.cbseacademic.in)</td>
				<td><p><u>Strand1:</u></br> 
						Any one of following:</br>
						1.	Athletics/Swimming </br>
						2.	Team Game</br>
						3.	Individual Game</br>
						4.	Adventure sports
					</p></td>
				<td>
					<select id="question_8_1">
						<option value="0">-Select-</option>
						<option value="Athletics/Swimming">Athletics/Swimming</option>
						<option value="Team_Game">Team Game</option>
						<option value="Individual_Game">Individual Game</option>
						<option value="Adventure_sports">Adventure sports</option>
					</select>
				</td>
			</tr>	
			<tr>
				<td>
					<p><u>Strand 2:</u></br> 
					<b>Health and Fitness</b>
					(Mass PT, Yoga, Dance, Calisthenics, Jogging, Cross Country Run, Working outs using weights/gym equipment, Taichi etc)
					</p>
				</td>
				<td>
					<select id="question_8_2" class="question_8_2"  multiple size="4">
						<option value="0">-Select Options-</option>
						<option value="Mass_PT">Mass PT</option>
						<option value="Yoga">Yoga</option>
						<option value="Dance">Dance</option>
						<option value="Calisthenics">Calisthenics</option>
						<option value="Jogging">Jogging</option>
						<option value="Cross_Country_Run">Cross Country Run</option>
						<option value=" Working_outs_using_weights"> Working outs using weights</option>
						<option value="gym_equipment">gym equipment</option>
						<option value="Taichi">Taichi</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<p><u>Strand 3:</u></br> 
					<b>SEWA</b>
					</p>
				</td>
				<td>
					<select id="question_8_3">
						<option value="0">-Select-</option>
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
				</td>
			</tr>
		</table>


		<table border="1" width="100%">
			<tr>
				<th>Fitness </br>Components</th>
				<th colspan="2">Fitness Parameters</th>
				<th>Test Name</th>
				<th>What does it Measure</th>
				<th>Result</th>
			</tr>
			<tr>
				<td rowspan="6">Health Components</td>
				<td>Body Composition</td>
				<td></td>
				<td>BMI</td>
				<td>Body Mass Index for Specific Age and Gender </td>
				<td>
					<select id="question_9">
						<option value="0">-Select-</option>
						<option value="Normal_Weight">Normal Weight</option>
						<option value="Normal_Weight">Under Weight</option>
						<option value="Normal_Weight">Over Weight</option>
					</select>
				</td>
			</tr>
			<tr>
				<td rowspan="2">Muscular Strength</td>
				<td>Core</td>
				<td>Partial Curl up</td>
				<td>Abdominal Muscular Endurance</td>
				<td>
					<select id="question_9_1">
						<option value="0">-Select-</option>
						<option value="pass">Pass</option>
						<option value="fail">Fail</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>Upper Body</td>
				<td>Flexed/Bent Arm Hang</td>
				<td>Muscular Endurance / Functional Strength </td>
				<td>
					<select id="question_9_2">
						<option value="0">-Select-</option>
						<option value="pass">Pass</option>
						<option value="fail">Fail</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Flexibility </td>
				<td> </td>
				<td>Sit and Reach </td>
				<td>Measures the flexibility of the lower back and hamstring muscles </td>
				<td>
					<select id="question_9_3">
						<option value="0">-Select-</option>
						<option value="pass">Pass</option>
						<option value="fail">Fail</option>
					</select>
				</td>
			</tr>	
			<tr>
				<td>Endurance  </td>
				<td> </td>
				<td>600 Mtr Run </td>
				<td>Cardiovascular Fitness/ Cardiovascular Endurance </td>
				<td>
					<select id="question_9_4">
						<option value="0">-Select-</option>
						<option value="average">Average</option>
						<option value="above_average">Above Average</option>
						<option value="above_average">Below Average</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Balance  </td>
				<td>Static Balance  </td>
				<td>Flamingo Balance Test </td>
				<td>Ability to balance successfully on a single leg </td>
				<td>
					<select id="question_9_5">
						<option value="0">-Select-</option>
						<option value="average">Average</option>
						<option value="above_average">Above Average</option>
						<option value="above_average">Below Average</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td rowspan="5">Skill Components</td>
				<td>Agility </td>
				<td></td>
				<td>Shuttle Run </td>
				<td>Test of speed and agility </td>
				<td>
					<select id="question_10">
						<option value="0">-Select-</option>
						<option value="excellent">Excellent</option>
						<option value="good">Good</option>
						<option value="above_average">Above Average</option>
						<option value="average">Average</option>
						<option value="below_average">Below Average</option>
						<option value="poor">Poor</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Speed </td>
				<td></td>
				<td>Sprint/Dash </td>
				<td>Determines acceleration and speed  </td>
				<td>
					<select id="question_10_1">
						<option value="0">-Select-</option>
						<option value="excellent">Excellent</option>
						<option value="good">Good</option>
						<option value="above_average">Above Average</option>
						<option value="average">Average</option>
						<option value="below_average">Below Average</option>
						<option value="poor">Poor</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Power </td>
				<td></td>
				<td>Standing Vertical Jump </td>
				<td>Measures the Leg Muscle Power </td>
				<td>
					<select id="question_10_2">
						<option value="0">-Select-</option>
						<option value="excellent">Excellent</option>
						<option value="good">Good</option>
						<option value="above_average">Above Average</option>
						<option value="average">Average</option>
						<option value="below_average">Below Average</option>
						<option value="poor">Poor</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Coordination</td>
				<td></td>
				<td>Plate Tapping</td>
				<td>Tests speed and coordination of limb movement</td>
				<td>
					<select id="question_10_3">
						<option value="0">-Select-</option>
						<option value="excellent">Excellent</option>
						<option value="good">Good</option>
						<option value="above_average">Above Average</option>
						<option value="average">Average</option>
						<option value="below_average">Below Average</option>
						<option value="poor">Poor</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>Alternative Hand Wall Toss Test </td>
				<td>Measures hand –eye coordination</td>
				<td>
					<select id="question_10_4">
						<option value="0">-Select-</option>
						<option value="excellent">Excellent</option>
						<option value="good">Good</option>
						<option value="above_average">Above Average</option>
						<option value="average">Average</option>
						<option value="below_average">Below Average</option>
						<option value="poor">Poor</option>
					</select>
				</td>
			</tr>
		</table>
		<input type="hidden" id="student_id_popup" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="health_record" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!---- modal close -->
  
  
<script src="<?php echo base_url();?>assest/bootstrap/js/mark_sheet_preview_high_class.js"></script>
  <script>
  var baseUrl = $('#base_url').val();
  
  $(document).on('click','.student_search',function(){
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Student_ctrl/student_list_marksheet',
			dataType: "json",
			data: {
				'medium' : $('#medium').val(),
				'class' : $('#class').val(),
				'section' : $('#section').val(),
				'fit' : 0,
				's_group' : $('s_group').val(),
				'elective' : 0
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				if(response.status == 200){
					var x = '<table class="table table-hover "><thead><tr><th>S.No.</th><th>Name</th><th>Print</th><th>Edit	</th> </tr></thead><tbody>';
					$.each(response.data,function(key,value){
						x = x + '<tr><td>'+ parseInt(key + 1) +'</td>'+
									'<td>'+ value.name +'</td>'+
									'<td>'+
										'<input type="button" value="Print" data-sid="'+ value.s_id +'" data-admission_no="'+ value.admission_no +'" class="student_activity_print btn btn-info btn-md">'+
									'</td><td>'+
										'<input type="button" value="Edit" data-sid="'+ value.s_id +'" data-admission_no="'+ value.admission_no +'" class="student_activity_edit btn btn-info btn-md">'+
									'</td>'+
								'</tr>';
					});
					x = x + '</tbody></table>';
					$('#dynamic_data').html(x);
				}
				else{
					$('#dynamic data').html('No record found.');
				}
			}
		});
  });
  
  
  $(document).on('click','.student_activity_edit',function(){
	  var student_id = $(this).data('sid');
	  var admission_no  = $(this).data('admission_no');
		$('#helth_edit').modal({'show':true,'backdrop':false});
		$('#student_id_popup').val(student_id);
  });

  
  $(document).on('click','#health_record',function(){
	  //alert( $('#student_id_popup').val());
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Helth_ctrl/health_insert',
			dataType: "json",
			data: {
				'stu_id' : $('#student_id_popup').val(),
				'session_id' : $('#session').val(),
				'medium' : $('#medium').val(),
				'class' : $('#class').val(),
				'section_id' : $('#section').val(), 
				'question_1' : $('#question_1').val(),
				'question_2' : $('#question_2').val(),
				'question_3' : $('#question_3').val(),
				'question_4_1' : $('#question_4_1').val(),
				'question_4_2' : $('#question_4_2').val(),
				'question_5_1' : $('#question_5_1').val(),
				'question_5_2' : $('#question_5_2').val(),
				'question_6_1' : $('#question_6_1').val(),
				'question_6_2' : $('#question_6_2').val(),
				'question_7' : $('#question_7').val(),
				'question_8_1' : $('#question_8_1').val(),
				'question_8_2' : $('#question_8_2').val(),
				'question_8_3' : $('#question_8_3').val(),
				'question_9' : $('#question_9').val(),
				'question_9_1' : $('#question_9_1').val(),
				'question_9_2' : $('#question_9_2').val(),
				'question_9_3' : $('#question_9_3').val(),
				'question_9_4' : $('#question_9_4').val(),
				'question_9_5' : $('#question_9_5').val(),
				'question_10' : $('#question_10').val(),
				'question_10_1' : $('#question_10_1').val(),
				'question_10_2' : $('#question_10_2').val(),
				'question_10_3' : $('#question_10_3').val(),
				'question_10_4' : $('#question_10_4').val()
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				if(response.status == 200){
					alert(response.msg);
					$('#helth_edit').modal('hide');
					
					}
			}
	  });
  });
  
$(document).on('click','.student_activity_print', function(){
	var student_id = $(this).data('sid');
	var medium = $('#medium').val();
	var sub_group = $('#s_group').val();

	$.ajax({
		   type:'POST',
		   url:'<?php echo base_url();?>Helth_ctrl/health_record_fetch',
		   dataType:'json',
		   data:{
			   student_id:student_id,
			   medium:medium,
			   sub_group:sub_group
			   },
		  beforeSend:function(){},
		  success:function(response){
			  console.log(response);
				if(response.status == 200){
					  var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
					  var x = '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
						'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
						'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
						'<style>.table tr td{border:1px solid #eee;}</style>'+
						  '<div class="modal-content p-head-sec-f">';
						if(response.health_activity[0].school_id == 2){
							//  x = x +'<img src="'+ baseUrl +'assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
					 		}
					 		if(response.health_activity[0].school_id == 1){
								//  x = x +'<img src="'+ baseUrl +'assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
						 		}
					      				x = x +'<div class="modal-header p-header">'+
												'<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="'+ baseUrl +'assest/images/sharda/cbse-logo.png" /></div>'+
												'<div class="col-md-6 p-logo-sec text-center">';
													if('school_id' == 2){
														x = x + '<div class="p-school-name-sec">'+
													'<h2>SHARDA VIDYALAYA</h2>'+
													'<p>Risali Sector, Bhilai, Chhattisgarh</p></div>';
													}
													else{
													x = x + '<div class="p-school-name-sec">'+
													'<h2>SHAKUNTALA VIDYALAYA</h2>'+
													'<p>Ram Nagar, Bhilai, Chhattisgarh</p></div>';
													}
													x = x +'</div>'+
												'<div class="col-md-3 p-school-logo">';
													if(response.health_activity[0].school_id == 2){
															x = x + '<img class="p-logo pull-right" src="'+ baseUrl +'assest/images/sharda/logo.png" />'; }
														else{ x = x + '<img class="p-logo pull-right" src="'+ baseUrl +'assest/images/shakuntala/logo.png" />'; }
														x = x +
												'</div>'+
										'</div>'+
										'<div class="modal-body p-student-body student-per-info">'+
										'<div class="student-per-info">'+
											'<table class="table">'+
											'<tr><td style="text-transform:uppercase;"><b>Name:</b>'+response.student[0].name+'</td><td style="text-transform:uppercase;"><b>Adm. No.:</b>'+response.student[0].admission_no+'</td></tr>'+
											'</table>'+
										'</div>'+
										'<div style="text-align:center;margin-top:5px;float:left;width:100%;"><b style=" font-size:20px;">HEALTH & ACTIVITY RECORD</b></div>'+
						  '<table class="table" style="margin-top:3px;float:left;width:100%;">'+
						  '<tbody><tr><td style="font-size:15px;"><b>Components</b></td><td style="font-size:15px;"><b>Parameters</b></td style="font-size:15px;"><td style="font-size:15px;"><b>Class:</b><span style="width:15%;text-transform:uppercase;">'+response.student[0].class_name+'</span></td></tr>'+
							'<tr><td>Vision</td><td>RE/LE</td>'+
						'<td style="text-transform:uppercase;">'+response.health_activity[0].question_1+'</td>'+
						'</tr>'+
					'<tr><td>Ears</td><td>Left/Right</td>'+
					'<td style="text-transform:uppercase;">'+response.health_activity[0].question_2+'</td>'+
					'</tr>'+
					'<tr><td>Teeth Occlusion</td><td>Caries/Tonsils/ Gums</td>'+
					'<td style="text-transform:uppercase;">'+response.health_activity[0].question_3+'</td>'+
					'</tr>'+
					'<tr><td rowspan="2">General Body measurements</td><td>Height</td><td style="text-transform:uppercase;">'+response.health_activity[0].question_4_1+'</td></tr>'+
					'<tr><td>Weight</td><td style="text-transform:uppercase;">'+response.health_activity[0].question_4_2	+'</td></tr>'+
					'<tr><td rowspan="2">Circumferences</td><td>Hip</td><td style="text-transform:uppercase;">'+response.health_activity[0].question_5_1+'</td></tr>'+
					'<tr><td>Waist</td><td style="text-transform:uppercase;">'+response.health_activity[0].question_5_2+'</td></tr>'+
					'<tr><td rowspan="2">Health Status</td><td>Pulse</td><td style="text-transform:uppercase;">'+response.health_activity[0].question_6_1+'</td></tr>'+
					'<tr><td>Blood Pressure</td><td style="text-transform:uppercase;">'+response.health_activity[0].question_6_2+'</td></tr>'+
					'<tr><td>Posture Evaluation</td><td><p><u>If any:</u></br>Head Forward/Sunken Chest/Round</br>'+
									'Shoulders/Kyphisis/Lordosis/Adominal</br>'+
									'Ptosis/Body Lean/Tilted Head/ Shoulders Uneven/Scholiosis/ Flat Feet/Knock Knees/ Bow Legs</p></td>'+
						'<td style="text-transform:uppercase;">'+response.health_activity[0].question_7+'</td></tr>'+
					'<tr><td rowspan="3"><p><b>Sporting Activities(HPE)</b><br>(For details, see HPE manual available on CBSE website www.cbseacademic.in)</td>'+
						'<td><p><u>Strand1:</u></br>'+ 
								'Any one of following:</br>'+
								'1.	Athletics/Swimming </br>'+
								'2.	Team Game</br>'+
								'3.	Individual Game</br>'+
								'4.	Adventure sports'+
							'</p></td>'+
						'<td style="text-transform:uppercase;">'+response.health_activity[0].question_8_1+'</td></tr>'+	
					'<tr><td><p><u>Strand 2:</u></br>'+ 
							'<b>Health and Fitness</b>'+
							'(Mass PT, Yoga, Dance, Calisthenics, Jogging, Cross Country Run, Working outs using weights/gym equipment, Taichi etc)</p>'+
						'</td>'+
						'<td style="text-transform:uppercase;">'+response.health_activity[0].question_8_2+'</td></tr>'+
					'<tr><td><p><u>Strand 3:</u></br> '+
							'<b>SEWA</b>'+
							'</p>'+
						'</td>'+
						'<td style="text-transform:uppercase;">'+response.health_activity[0].question_8_3+'</td></tr></tbody></table>'+
						'<table style="margin-top:0px;float:left;width:100%;" class="table">'+
							'<tbody><tr>'+
								'<td style="font-size:15px;"><b>Fitness Components</b></td>'+
								'<td style="font-size:15px;" colspan="2"><b>Fitness Parameters</b></td>'+
								'<td style="font-size:15px;"><b>Test Name</b></td>'+
								'<td style="font-size:15px;"><b>What does it Measure</b></td>'+
								'<td style="width:22%;font-size:15px;"><b>Result</b></td>'+
							'</tr>	'+
							'<tr>'+
								'<td rowspan="6">Health Components</td><td>Body Composition</td><td></td><td>BMI</td><td>Body Mass Index for Specific Age and Gender </td>'+
								'<td style="text-transform:uppercase;">'+response.health_activity[0].question_9+'</td></tr>'+
								'<tr>'+
								'<td rowspan="2">Muscular Strength</td><td>Core</td><td>Partial Curl up</td><td>Abdominal Muscular Endurance</td>'+
								'<td style="text-transform:uppercase;">'+response.health_activity[0].question_9_1+'</td></tr>'+
							'<tr><td>Upper Body</td><td>Flexed/Bent Arm Hang</td><td>Muscular Endurance / Functional Strength </td>'+
							'<td style="text-transform:uppercase;">'+response.health_activity[0].question_9_2+'</td>'+
							'</tr>'+
							'<tr><td>Flexibility </td><td> </td><td>Sit and Reach </td><td>Measures the flexibility of the lower back and hamstring muscles </td>'+
							'<td style="text-transform:uppercase;">'+response.health_activity[0].question_9_3+'</td>'+
						'</tr>'+	
						'<tr><td>Endurance  </td><td> </td><td>600 Mtr Run </td><td>Cardiovascular Fitness/ Cardiovascular Endurance </td>'+
							'<td style="text-transform:uppercase;">'+response.health_activity[0].question_9_4+'</td>'+
						'</tr>'+
						'<tr><td>Balance  </td><td>Static Balance  </td><td>Flamingo Balance Test </td><td>Ability to balance successfully on a single leg </td>'+
							'<td style="text-transform:uppercase;">'+response.health_activity[0].question_9_5+'</td>'+
						'</tr>'+
							
							'<tr><td rowspan="5">Skill Components</td><td>Agility </td><td></td><td>Shuttle Run </td><td>Test of speed and agility </td>'+
								'<td style="text-transform:uppercase;">'+response.health_activity[0].question_10+'</td>'+
							'</tr>'+
							'<tr><td>Speed </td><td></td><td>Sprint/Dash </td><td>Determines acceleration and speed  </td>'+
								'<td style="text-transform:uppercase;">'+response.health_activity[0].question_10_1+'</td></tr>'+
							'<tr><td>Power </td><td></td><td>Standing Vertical Jump </td><td>Measures the Leg Muscle Power </td>'+
								'<td style="text-transform:uppercase;">'+response.health_activity[0].question_10_2+'</td></tr>'+
							'<tr><td>Coordination</td><td></td><td>Plate Tapping</td>'+
								'<td>Tests speed and coordination of limb movement</td>'+
								'<td style="text-transform:uppercase;">'+response.health_activity[0].question_10_3+'</td></tr>'+
							'<tr><td></td><td></td><td>Alternative Hand Wall Toss Test </td>'+
								'<td>Measures hand –eye coordination</td>'+
								'<td style="text-transform:uppercase;">'+response.health_activity[0].question_10_4+'</td>'+
								'</tr></tbody>'+
						'</table></div>';
					  
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



  
  $(document).on('click','#ravi',function(){

  });
  </script>