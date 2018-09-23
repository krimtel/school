<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Compartment Marks Entry
      </h1>
      <form id="csv-form" class="form-horizontal" name="f2" method="POST" action="<?php echo base_url();?>Exam_ctrl/add_student_marks_csv">
      	<input type="file" name="userfile">
      	<button type="button" id="csv_submit" class="btn btn-default">Submit CSV</button>
		<button type="reset" class="btn btn-default btn-space">Cancel</button>
      </form>
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
								<option value="<?php echo $medium; ?>"><?php echo $medium; ?></option>
							</select>
						<?php } else { ?>
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
						<?php if(isset($classes)){ ?>
							<select class="form-control" name="class" id="class">
									<option value="0">Select Class</option>
								<?php foreach($classes as $class){ ?>
									<option value="<?php echo $class['c_id']; ?>"><?php echo $class['name']; ?></option>
								<?php } ?>
							</select>
						<?php } else {?>
							<select class="form-control" name="class" id="class">
								<option value="0">Select Class</option>
								<option value="14">XI</option>
								<option value="15">XII</option>
							</select>
						<?php } ?>
						<div id="class_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Section</label>
					<div class="col-sm-10">
						<select class="form-control" name="section" id="section">
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
						<div id="section_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group" id="subject_section">
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
					<select class="form-control" id="s_group">
						<option value="0">Select Subject Group</option>
						<option value="maths">Maths</option>
						<option value="bio">Biology</option>
						<option value="commer">Commerce</option>
						<option value="art">Arts</option>
					</select>
					<div id="s_group_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label">Subject</label>
					<div class="col-sm-10">
						<select class="form-control" id="subject">
							<option value="0"> Select Subject </option>
						</select>
						<div id="subject_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group" id="elective_section">
                    <label class="col-sm-2 control-label">Elective</label>
					<div class="col-sm-10">
					<select class="form-control" id="elective">
						<option value="0">Select Elective Subject</option>
						<option value="23">CS</option>
						<option value="26">Hindi</option>
						<option value="27">Pe</option>
						<option value="28">Maths</option>
					</select>
					<div id="elective_err" class="text-danger" style="display:none;"></div>
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
          	<span id="max_practical" style="display: none;">0</span>
          	<span id="max_academic" style="display: none;">0</span>
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
                <thead><tr>
                  <th>S.No.</th>
                   <th>Student Name</th>
				  <th>Class/Section</th>
				  <th>Addmission No.</th>
				  <th>Roll No.</th>
                  <th>Marks</th>
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

$(document).on('change','#section',function(){
	$.ajax({
		type: 'POST',
		url: baseUrl+'Subject_ctrl/subject_list_high_class',
		dataType: "json",
		data: {
			'class' : $('#class').val(),
			'section' : $('#section').val(),
			'medium' : $('#medium').val(),
			'e_type' : $('#e_type').val(),
			's_group' : $(this).val()
		},
		beforeSend: function(){
			
		},
		success:  function (response) {
			if(response.status == 200){
				if(response.data.p_marks != 0){
					$('#practical').css('display','block');
				}
				var x = '<option value="0">Select Subject</option>';
				$.each(response.data,function(key,value){
					x = x + '<option value="'+ value.id +'">'+ value.subject +'</option>'; 
				});

				$('#subject').html(x);
			}
		}
	});
});

$(document).on('change','#s_group',function(){
	var medium = $('#medium').val();
	var e_type = $('#e_type').val();
	var class_id = $('#class').val();
	var section = $('#section').val();
	var s_group = $('#s_group').val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Subject_ctrl/subject_list_high_class',
		dataType: "json",
		data: {
			'class' : class_id,
			'section' : section,
			'medium' : medium,
			'e_type' : e_type,
			's_group' : s_group
		},
		beforeSend : function(){
			
		},
		success : function (response) {
			console.log(response);
			if(response.status == 200){
				$('#subject').html('');
				if(response.data.p_marks != 0){
					$('#practical').css('display','block');
				}
				var x = '<option value="0">Select Subject</option>';
				$.each(response.data,function(key,value){
					if(value.sub_id == 13){
						x = x + '<option value="'+ value.sub_id +'">General Study('+ value.type +')</option>';
					}
					else{
						x = x + '<option value="'+ value.sub_id +'">'+ value.subject +'('+ value.type +')</option>';
					}
					 
				});

				$('#subject').html(x);
			}
		}
	});
});

$(document).on('click','#fetch_student',function(){
	var medium = $('#medium').val();
	var e_type = $('#e_type').val();
	var class_id = $('#class').val();
	var section = $('#section').val();
	var s_group = $('#s_group').val();
	var elective = $('#elective').val();
	var subject = $('#subject').val();
	formvalid = true;
	if(s_group == 0){
		$('#s_group_err').html('Please select Subject Group.').css('display','block');
		formvalid = false;
	}
	else{
		$('#s_group_err').css('display','none');
	}
	if($('#subject').val() == 9 || $('#subject').val() == 10 || $('#subject').val() == 11 || $('#subject').val() == 12){
		if(elective == 0){
			$('#elective_err').html('Please select Elective Subject.').css('display','block');
			formvalid = false;
		}
		else{
			$('#elective_err').css('display','none');
		}
	}
	if(medium == 0){
		$('#medium_err').html('Please select Medium.').css('display','block');
		formvalid = false;
	}
	else{
		$('#medium_err').css('display','none');
	}
	if(e_type == 0){
		$('#e_type_err').html('Please select Exam Type.').css('display','block');
		formvalid = false;
	}
	else{
		$('#e_type_err').css('display','none');
	}
	if(class_id == 0){
		$('#class_err').html('Please select Class.').css('display','block');
		formvalid = false;
	}
	else{
		$('#class_err').css('display','none');
	}
	if(section == 0){
		$('#section_err').html('Please select section.').css('display','block');
		formvalid = false;
	}
	else{
		$('#section_err').css('display','none');
	}
	
	if($('#subject').val() == 0){
		$('#subject_err').html('Please select Subject.').css('display','block');
		formvalid = false;
	}
	else{
		$('#subject_err').css('display','none');
	}
	if(formvalid){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Student_ctrl/compart_student_list_marks_high_class',
			dataType: "json",
			data: {
				'class' : $('#class').val(),
				'section' : $('#section').val(),
				'medium' : $('#medium').val(),
				'e_type' : $('#e_type').val(),
				's_group' : s_group,
				'elective' : elective,
				'subject' : subject
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			success: function(response) {
				$('#loader').modal('toggle');
				console.log(response);
				var x = '';
				var c = 1;
				
				if(response.status == 200){
					$.each(response.data,function(key,value){
						x = x + '<tr>'+
									'<td>'+ c +'</td>'+
									'<td style="text-align:left;">'+ value.name +'</td>'+								
									'<td>'+ $("#class option:selected").text() +' / '+  $("#section option:selected").text() + '</td>'+
									'<td>'+ value.admission_no +'</td>'+
									'<td>'+ value.roll_no +'</td>';
									if (typeof value.n_marks === 'undefined') {
										x = x + '<td><input type="text" data-s_id="'+ value.s_id +'" class="s_marks" data-max="'+ response.mm +'" value="" max ="'+ response.mm +'" size="4"></td>';
									}
									else{
										x = x + '<td><input type="text" data-s_id="'+ value.s_id +'" class="s_marks" value="'+ value.n_marks +'" data-max="'+ response.mm +'" max ="'+ response.mm +'" size="4"></td>';
									}
								'</tr>'; 
						c = c + 1;
					});
					$('#student_list').html(x);
					if(response.p_marks != 0){
						$('.practical').css('display','block');	
					}
					else{
						$('.practical').css('display','none');
					}
					if($('#e_type').val() == 9){
						if($('#subject').val() == 13 || $('#subject').val() == 14 || $('#subject').val() == 15 || $('#subject').val() == 16){
							$('.academic').css('display','none');
						}
						else{ 
							$('.academic').css('display','block');
						}
					}
					else{
						$('.academic').css('display','none');
					}
					$('.buttons').show();
				}
				else{
					alert('No Record Found.');
					$('.buttons').hide();
					$('#student_list').html('No record found.');
				}
			}
		});
	}
});


$(document).on('click','#subject_mark',function(){
	var stud_mark = [];
	
	$(".s_marks").each(function() {
		var temp = {};
		temp.val = $(this).val();
		temp.s_id = $(this).data('s_id');
	    stud_mark.push(temp);
	});
	mark_entry(stud_mark);
});

function mark_entry(stud_mark){
	var s_group = $('#s_group').val();
	var elective = $('#elective').val();
	var subject = $('#subject').val();
	
	$.ajax({
		type: 'POST',
		url: baseUrl+'Student_ctrl/compart_marks_entry_high_class',
		dataType: "json",
		data: {
			'class' : $('#class').val(),
			'section' : $('#section').val(),
			'medium' : $('#medium').val(),
			'e_type' : $('#e_type').val(),
			's_group' : s_group,
			'elective' : elective,
			'subject' : subject,
			's_marks' : stud_mark  
		},
		beforeSend: function(){
			$('#loader').modal('show');			
		},
		success: function(response) {
			$('#loader').modal('toggle');
			if(response.status == 200){
				alert('Marks Submitted successfully.');
				location.reload();
			}
		}
	});
}

$(document).on('change','#class',function(){
	var c_id = $(this).val();
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
});

$(document).on('keyup','.s_marks,.practical',function(){
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


$(document).on('blur','.s_marks,.practical',function(){
	var max = $(this).data('max');
	var val = $(this).val();
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

$(document).on('keypress','.s_marks,.p_marks',function(e){
    var keyCode = e.which ? e.which : e.keyCode;
    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode <= 65 || keyCode <= 8));
    if(!ret){
        e.preventDefault();
    }
});
$(document).on('keyup','.s_marks,.p_marks',function(){
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

$(document).on('change','#e_type',function(){
	$('#class').val(0);
	$('#section').val(0);
	$('#s_group').val(0);
	$('#elective').val(0);
	$('#subject').html('<option value="0">Select Subject</option>');
});
$(document).on('change','#medium',function(){
	$('#e_type').val(0);
	$('#class').val(0);
	$('#section').val(0);
	$('#s_group').val(0);
	$('#elective').val(0);
	$('#subject').html('<option value="0">Select Subject</option>');
});

$(document).on('change','#subject',function(){
	$('#elective').val(0);
});

$(document).on('change','#elective',function(){
	if($(this).val() == 23){
		$('#subject').val(9);
		
	}
	if($(this).val() == 26){
		$('#subject').val(11);
	}
	if($(this).val() == 27){
		$('#subject').val(10);
	}
	if($(this).val() == 28){
		$('#subject').val(12);
	}
});


$(document).on('click','#csv_submit',function(){
	  var formvalid = true;

	  if($('#exampleInputFile').val() == ''){
		  formvalid = false;
		  $('#csvfile').html('Please Select CSV file First.').css('display','block');
	  }else{
		  $('#csvfile').css('display','none');
	  }	  

	if(formvalid){
	  $('#csv-form').ajaxForm({
		    dataType : 'json',
		    beforeSubmit:function(e){
		    	$('#loader').modal('show');
		    },
		    success:function(response){
		    	$('#loader').modal('toggle');
		  	  if(response.status == 200){
		  	  alert("Your File Successfully Upload");
		    	location.reload();
		      }
		      else{
			    alert("Something Goes To Wrong Contact To Admin\n May Be This Record All Ready Submitted");
		      }
		    }
	    }).submit();
	}
});
</script>