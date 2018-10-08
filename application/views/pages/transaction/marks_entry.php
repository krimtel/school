<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Marks Entry
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Marks Entry</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add/Update New Marks</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group">
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
						<div class="text-danger" id="medium_err" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Exam Type</label>
					<div class="col-sm-10">
						<select class="form-control" id="e_type">
							<option value="0">Select Exam Type</option>
							<?php foreach($e_types as $e_type){ ?>
								<option value="<?php echo $e_type['e_id']; ?>"><?php echo $e_type['e_name']; ?></option>
							<?php } ?>
						</select>
						<div id="e_type_err" class="text-danger" style="display:none;"></div>
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
				<div class="form-group" id="subject_section" style="display: none;">
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
					<select class="form-control" id="s_group">
						<option value="0">Select Subject Group</option>
						<option value="Maths">Maths</option>
						<option value="Boilogy">Biology</option>
						<option value="Commerce">Commerce</option>
						<option value="Arts">Arts</option>
					</select>
					</div>
				</div>
				<div class="form-group" id="fit_section" style="display: none;">
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
				<?php /* ?>
				<div class="form-group" id="elective_section" style="display: none;">
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
				<?php */ ?>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Subject</label>
					<div class="col-sm-10">
						<select class="form-control" id="subject">
							<option value="0"> Select Subject </option>
						</select>
						<div id="subject_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="button" id="fetch_student" class="btn pull-right btn-info">Search</button>
				<button type="reset" class="btn btn-default pull-right btn-space">Clear</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
         
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">

          <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Edit/Update Marks</h3>
          <div style="color:#0183f4;">
          	<span id="max_mark" style="display: none;">0</span>
          	<span id="max_notebook" style="display: none;">0</span>
          	<span id="max_enrich" style="display: none;">0</span>
          	<span id="max_practical" style="display: none;">0</span>
          	</div>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <form role="form" class="form-horizontal">
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover text-center t-input-center">
              <p id="max_marks_msg" style="color:#0183f4; padding-left: 10px;"></p>
                <thead>
	                <tr>
	                  <th>S.No.</th>
	                   <th>Student Name</th>
					  <th>Class/Section</th>
					  <th>Addmission No.</th>
					  <th>Roll No.</th>
	                  <th>Marks</th>
	                  <th class="notebook" style="display:none;">Notebook</th>
	                  <th class="notebook" style="display:none;">Subject Enrichment</th>
	                  <th class="practical" style="display:none;">Practical</th>
	                </tr>
                </thead>
                <tbody id="student_list"></tbody>
              </table>
            </div>
			<div class="box-footer">
				<button type="button" id="subject_mark"  class="buttons btn pull-right btn-info" style="display: none;">Submit</button>
				<button type="reset" class="buttons btn btn-default pull-right btn-space" style="display: none;">Cancel</button>
            </div>
		</form>
            </div>
        <!-- /.box-body -->
      </div>

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>

<script>
var baseUrl = $('#base_url').val();

var medium,subject,e_type,class_id,section;

function form_value(){
	medium = $('#medium').val();
	e_type = $('#e_type').val();
	class_id = $('#class').val();
	section = $('#section').val();
	subject = $('#subject').val();
	return true;
}

$(document).on('change','#class',function(){
	var c_id = $(this).val();
	var e_type = $('#e_type').val();
	$.ajax({
		type: 'GET',
		url: baseUrl+'Class_ctrl/section_list/'+c_id,
		dataType: "json",
		data: {
			'c_id':c_id
		},
		beforeSend: function(){},
		success:  function (response) {
			var x = '<option value="0">Select Section</option>';
			$.each(response.data,function(key,value){
				x = x+ '<option value="'+ value.id +'">'+ value.name +'</option>';
			});
			$('#section').html(x);
		}
	});

		if(c_id == 12|| c_id == 13){
			$('#fit_section').show();
			$('#s_group').val(0);
			$('#elective').val(0);
		}
		else{	
			$('#fit_section').hide();
			$('#fit').val(0);
		}
		
		if(c_id == 14|| c_id == 15){
			//$('#elective_section').show();
			$('#subject_section').show();
		}
		else{
			$('#elective_section').hide();	
			$('#subject_section').hide();
		}
});



$(document).on('change','#section',function(){
	var c_id = $('#class').val();
	var e_type = $('#e_type').val();
	var section = $(this).val();
	
	$.ajax({
		type: 'POST',
		url: baseUrl+'Subject_ctrl/subject_list',
		dataType: "json",
		data: {
			'c_id':c_id,
			'e_type': e_type,
			'section' : section
		},
		beforeSend: function(){},
		success:  function (response) {
			var x = '<option value="0">Select Subject</option>';
			var f = 1;
			$.each(response.data,function(key,value){
				if(value.subj_type == 'Scholastic'){
					x = x+ '<option value="'+ value.sub_id +'">'+ value.name +'('+ value.subj_type +')'+'</option>';
				}
				else{
					if(f){
						x = x+ '<option value="0">-------------------------</option>';
						x = x+ '<option value="'+ value.sub_id +'">'+ value.name +'('+ value.subj_type +')'+'</option>';
						f = 0;
					}
					else{
						x = x+ '<option value="'+ value.sub_id +'">'+ value.name +'('+ value.subj_type +')'+'</option>';
					}
				}
			});
			$('#subject').html(x);
		}
	});
});

$(document).on('click','#fetch_student',function(){	
	var medium = $('#medium').val();
	var class_id = $('#class').val();
	var section = $('#section').val();
	var e_type = $('#e_type').val();
	var subject = $('#subject').val();

	var fit = $('#fit').val();
	var subject_group = $('#s_group').val();
	var elective = $('#elective').val();
	var formvalid = true;	
	if(medium == 0){
		$('#medium_err').html('Please Select Medium.').css('display','block');
		formvalid = false;
	}
	else{
		$('#medium_err').css('display','none');
	}
	if(e_type == 0){
		$('#e_type_err').html('Please Select Exam Type.').css('display','block');
		formvalid = false;
	}
	else{
		$('#e_type_err').css('display','none');
	}
	if(class_id == 0){
		$('#class_err').html('Please Select Class1.').css('display','block');
		formvalid = false;
	}
	else{
		$('#class_err').css('display','none');
	}
	
	if(section == 0){
		$('#section_err').html('Please Select Section.').css('display','block');
		formvalid = false;
	}
	else{
		$('#section_err').css('display','none');
	}
	
	if(subject == 0){
		$('#subject_err').html('Please Select Subject.').css('display','block');
		formvalid = false;
	}
	else{
		$('#subject_err').css('display','none');
	}
	
	if(formvalid){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Student_ctrl/student_list_marks',
			dataType: "json",
			data: {
				'class' : class_id,
				'medium' : medium,
				'e_type' : e_type,
				'section' : section,
				'fit' : fit,
				's_group' : subject_group,
				'elective' : elective,
				'subject' : subject 
			},
			beforeSend: function(){
                           $('#loader').modal('show');
                        },
			success: function (response) {
                    $('#loader').modal('toggle');
				    console.log(response);
					if(response.status == 200){
						$('.buttons').css('display','block');
						var x = '';
						var c = 1;
						var f = 1;
						$.each(response.data,function(key,value){	
							x = x + '<tr>'+
										'<td>'+ c +'</td>'+
										'<td  style="text-align:left;">'+ value.name +'</td>'+
										'<td>'+ value.cname +' / '+ value.secname +'</td>'+
										'<td>'+ value.admission_no +'</td>'+
										'<td>'+ value.roll_no +'</td>';
										if(response.flag){
											if (typeof value.marks != 'undefined'){	
												x = x + '<td><input type="text" class="subject_mark_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.max +'" max="'+ response.max +'" value="'+ value.marks +'" required disabled="disabled"></td>';
											}
											else{
												x = x + '<td><input type="text" class="subject_mark_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.max +'" max="'+ response.max +'" value="" required disabled="disabled"></td>';
											}
										}
										else{
											if (typeof value.marks != 'undefined'){	
												x = x + '<td><input type="text" class="subject_mark_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.max +'" max="'+ response.max +'" value="'+ value.marks +'" required></td>';
											}
											else{
												x = x + '<td><input type="text" class="subject_mark_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.max +'" max="'+ response.max +'" value="" required></td>';
											}
										}
										if(response.s_type == 'Scholastic'){

											if($('#e_type').val() == 1){
												$('#max_mark').html('Maximum Subject Mark :'+ response.max +' ').show();	
											}
											
											if($('#e_type').val() == 4 || $('#e_type').val() == 9){
												if(f){
													f = 0;
													$('#max_mark').html('Maximum Subject Mark :'+ response.max +' ').show();
													$('#max_notebook').html('Maximum Notebook Mark :'+ response.internal_marks + ' ').show();
													$('#max_enrich').html('Maximum Enrichment Mark :' + response.internal_marks + ' ').show();
												}
												if($('#e_type').val() == 9 && $('#subject').val() == 13){
													$('.practical').show();
												}
												else{
													$('.practical').hide();
												}
												
												$('.notebook').show();
												if(response.flag){
													x = x + '<td><input type="text" class="notebook_mark" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.internal_marks +'" max="'+ response.internal_marks +'" value="" required disabled="disabled"></td>'+
													'&nbsp;&nbsp;<td><input type="text" class="subj_assis" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.internal_marks +'" max="'+ response.internal_marks +'" value="" required disabled="disabled"></td>';
												}
												else{
												if (typeof value.n_marks != 'undefined'){
													if($('#e_type').val() == 9 && $('#subject').val() == 13){
														x = x + '&nbsp;&nbsp;<td><input type="text" class="practical_mark_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.p_mark +'" max="'+ response.p_mark +'" value="'+ value.p_marks +'" required></td>';
														$('#max_notebook').hide();
														$('#max_enrich').hide();
														$('.notebook').hide();
													}
													else{
														x = x + '<td><input type="text" class="notebook_mark" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.internal_marks +'" max="'+ response.internal_marks +'" value="'+ value.n_marks +'" required></td>'+
														'&nbsp;&nbsp;<td><input type="text" class="subj_assis" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.internal_marks +'" max="'+ response.internal_marks +'" value="'+ value.a_marks +'" required></td>';
													}
												}

												if($('#e_type').val() == 4 && $('#class').val() == 12 || $('#e_type').val() == 9 && $('#class').val() == 12){
													x = x + '&nbsp;&nbsp;<td><input type="text" class="practical_mark_box" min="0" data-s_id="'+ value.s_id +'" data-max="70" max="70" value="'+ value.p_marks +'" required></td>';
													$('#max_notebook').hide();
													$('#max_enrich').hide();
													$('.notebook').hide();
												}
												
												else{
													if($('#e_type').val() == 9 && $('#subject').val() == 13){
														$('#max_notebook').hide();
														$('#max_enrich').hide();
														$('.notebook').hide();
														x = x + '&nbsp;&nbsp;<td><input type="text" class="practical_mark_box" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.p_mark +'" max="'+ response.p_mark +'" value="'+ value.p_marks +'" required></td>';
													}

													
													else{
														x = x + '<td><input type="text" class="notebook_mark" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.internal_marks +'" max="'+ response.internal_marks +'" value="" required></td>'+
														'&nbsp;&nbsp;<td><input type="text" class="subj_assis" min="0" data-s_id="'+ value.s_id +'" data-max="'+ response.internal_marks +'" max="'+ response.internal_marks +'" value="" required></td>';
													}
												}
												}
											}
										}
										else{
											$('#max_mark').html('Maximum Marks :'+response.max).show();
											$('#max_notebook').hide();
											$('#max_enrich').hide();
											$('.notebook').hide();
										}
									x = x + '</tr>';  
							c++;
						});
						$('#student_list').html(x);
					}
				else{
					$('.buttons').css('display','none');
                    $('#student_list').html('<tr><td class="text-center" colspan="7"><b>No record found.</b></td></tr>');
					alert(response.msg);
				}
					
			}
		});
	}
});

$(document).on('blur','.subject_mark_box,.notebook_mark,.subj_assis,.practical_mark_box',function(){
//$(document).on('keyup','.subject_mark_box,.notebook_mark,.subj_assis',function(){
	var max = $(this).data('max');
  	var val = $(this).val();
//   	if(val > max){
  		if(val > max || val == ''){
  	  	$(this).css('box-shadow','0px 0px 10px red');
	  	$(this).focus();
	  	$('#subject_mark').attr('disabled',true);
	  	$('#subject_mark').attr('dis')
  	}	
  	else{
  		$('#subject_mark').attr('disabled',false);
  	  	$(this).css('box-shadow','none');
  	}
});

$(document).on('keyup','.subject_mark_box,.notebook_mark,.subj_assis,.practical_mark_box',function(){
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

$(document).on('click','#subject_mark',function(){
	  var total_marks = [];
	  var stud_mark = [];
	  var f = 1;
	  $(".subject_mark_box").each(function() {
		  	var temp = {};								//flag bit
		    temp.val = $(this).val();
		    if($(this).val() == ''){
			    $(this).addClass('marks_error');
			    f = 0;
		    }
		    temp.s_id = $(this).data('s_id');
		    stud_mark.push(temp);
		});
		
	  var notebook_mark = [];
	  var n = 1;
	  $(".notebook_mark").each(function() {
		  var temp = {};								//flag bit
		    temp.val = $(this).val();
		    if($(this).val() == ''){
			    $(this).addClass('');
			    n = 0;
		    }
		    temp.s_id = $(this).data('s_id');
		    notebook_mark.push(temp);
	  });

	  var subj_anric_mark = [];
	  var sa = 1;
	  $(".subj_assis").each(function() {
		  var temp = {};								//flag bit
		    temp.val = $(this).val();
		    if($(this).val() == ''){
			    $(this).addClass('');
			    sa = 0;
		    }
		    temp.s_id = $(this).data('s_id');
		    subj_anric_mark.push(temp);
	  });

	  var practical_mark = [];
	  var p = 1;
	  $(".practical_mark_box").each(function() {
		  var temp = {};								//flag bit
		    temp.val = $(this).val();
		    if($(this).val() == ''){
			    $(this).addClass('');
			    p = 0;
		    }
		    temp.s_id = $(this).data('s_id');
		    practical_mark.push(temp);
	  });

	  atten(stud_mark,notebook_mark,subj_anric_mark,practical_mark);
});

function atten(stud_mark,notebook_mark,subj_anric_mark,practical_mark){
	form_value();
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Subject_ctrl/marks_entry',
			dataType: "json",
			data: {
				'medium': medium,
				'class' : class_id,
				'section' : section,
				'marks' : stud_mark,
				'notebook_mark' : notebook_mark,
				'subj_anric_mark' : subj_anric_mark,
				'p_marks' : practical_mark,
				'e_type' : e_type,
				'subject' : subject
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				if(response.status == 200){
					openExcelfile(response.csv_download);
					alert('Marks Submitted Successfully.');
					//location.reload();
				}
			}
	  });
}
function openExcelfile(strFilePath){
	openExcelDocPath(baseUrl + strFilePath, false);
}

function openExcelDocPath(strLocation, boolReadOnly){
	window.location.href = strLocation;
} 




$(document).on('keypress','.subject_mark_box,.notebook_mark,.subj_assis',function(e){
    var keyCode = e.which ? e.which : e.keyCode;
    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode <= 65 || keyCode <= 8));
    if(!ret){
        e.preventDefault();
    }
});



$(document).on('change','#e_type',function(){
	$('#class').val(0);
});

$(document).on('change','#subject,#e_type,#class,#section,#medium',function(){
	form_value();
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Subject_ctrl/subject_entry_check',
			dataType: "json",
			data: {
				'medium': medium,
				'class' : class_id,
				'section' : section,
				'e_type' : e_type,
				'subject' : subject
			},
			beforeSend: function(){
				$('#loader').modal('show');		
			},
			success: function (response) {
				$('#loader').modal('toggle');
				if(response.status == 500){
					//$('#fetch_student').attr('disabled',true);
				}
				else{
					//$('#fetch_student').attr('disabled',false);
				}
			}
	  }); 
});

</script>