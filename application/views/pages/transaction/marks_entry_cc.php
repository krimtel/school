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
       <section class="col-lg-12" id="csv_block" style="display:none">            
			<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Import Student Marks</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="csv-form" method="post" action="<?php echo base_url() ?>Marks_entry_cc/search_csv" enctype="multipart/form-data">
             	
				<div class="box-body">
				<div class="form-group">
                  <label class="col-sm-4 control-label" for="exampleInputFile">Import Student Marks</label>
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
                            <select class="form-control" id="medium" name="medium">
								<option value="0">Select Medium</option>
                                <?php foreach($medium_list as $list){?>
                                <option value="<?php echo $list['medium_id'] ;?>"><?php echo $list['m_name']?></option>
								<?php }?>
							</select>
						
						<div class="text-danger" id="medium_err" style="display: none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Exam Type</label>
					<div class="col-sm-10">
						<select class="form-control" id="e_type" name="e_type">
							<option value="0">Select Exam Type</option>
							<?php foreach($exam_type_list as $exam_type){ ?>
								<option value="<?php echo $exam_type['exam_type_id'];?>"><?php echo $exam_type['et_name']; ?>, (<?php echo $exam_type['term_name']?>)</option>
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
							<?php foreach($class_list as $class){ ?>
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
                            <?php foreach($section_list as $section){ ?>
								<option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
							<?php } ?>
						</select>
						<div id="section_err" class="text-danger" style="display:none;"></div>
					</div>
				</div> 
   
				<div class="form-group" id="subject_section">
                    <label class="col-sm-2 control-label">Select Subject</label>
					<div class="col-sm-10">
					<select class="form-control" id="subject" name="subject">
						<option value="0">Select Subject</option>
                          <?php foreach($subject_list as $subject){ ?>
								<option value="<?php echo $subject['sub_id']; ?>"><?php echo $subject['sub_name'];?>, (<?php echo $subject['sub_type']?>)</option>
							<?php } ?>
					</select>
                    <div id="subject_arr" class="text-danger" style="display:none;"></div>

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
              <form role="form" class="form-horizontal" id="marks_entry_form">
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover text-center t-input-center">
                <thead>
	                <tr>
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

<script type="text/javascript">
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


$(document).ready(function() {
	
	$(document).on('change', '#class', function() {
	  var medium_id=$('#medium').val();
	  var classID = $(this).val();
						$.ajax({
								type:"POST",
								url: baseUrl+'Marks_entry_cc/select_box',
								dataType: "json",
								data:{'class_id':classID,
									   'medium_id':medium_id	
									},
								success: function(data){	
									var x = '';
									x = '<option value="0">Select Subject</option>';
									$.each(data.data,function(key,value){
	x = x + '<option value="'+value.sub_id+'">'+ value.sub_name+" ("+value.sub_type+")"+'</option>';
									});
									$('#subject').html(x);
								},
						}); 
	});
		

	$(document).on('click','#csv_submit',function(){
		form_value();
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
			    data:{
        				'medium'  : medium,
        				'e_type'  : e_type,
        				'class'   : class_id,
        				'section' : section,
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
					$.each(response.data,function(key,value){
						x = x + '<tr>'+
									'<td>'+ c +'</td>'+
									'<td  style="text-align:left;">'+ value.name +'</td>'+
									'<td>'+ value.cname +' / '+ value.secname +'</td>'+
									'<td>'+ value.admission_no +'</td>'+
									'<td>'+ value.roll_no +'</td>';
									
									if (typeof value.marks != 'undefined'){	
									x = x + '<td><input type="text" class="subject_mark_box" data-max="'+response.max+'" data-s_id="'+ value.s_id +'" value="'+value.marks+'" required></td>';
										}
										else{
									x = x + '<td><input type="text" class="subject_mark_box" data-max="'+response.max+'" data-s_id="'+ value.s_id +'" value="" required></td>';
										}
										
								x = x + '</tr>';  
						c++;
					});
					$('#student_list').html(x);
				}
				else{
				//$('.buttons').css('display','none');
                //$('#student_list').html('<tr><td class="text-center" colspan="7"><b>CSV file miss match.</b></td></tr>');
				alert(response.msg);
			}
				
		}
		    }).submit();
		}
	  });


	 

    $(document).on('click','#fetch_student',function(){
   
	var medium = $('#medium').val();
	var class_id = $('#class').val();
	var section = $('#section').val();
	var e_type = $('#e_type').val();
	var subject = $('#subject').val();
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
		$('#class_err').html('Please Select Class.').css('display','block');
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
		$('#subject_arr').html('Please Select Subject.').css('display','block');
		formvalid = false;
	}
	else{
		$('#subject_arr').css('display','none');
	}
	
	if(formvalid){
		$('#csv_block').css('display','block');

		$.ajax({
			type: 'POST',
			url: baseUrl+'Marks_entry_cc/search_list',
			dataType: "json",
			data: {
				'class' : class_id,
				'medium' : medium,
				'e_type' : e_type,
				'section' : section,
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
						$.each(response.data,function(key,value){
							x = x + '<tr>'+
										'<td>'+ c +'</td>'+
										'<td  style="text-align:left;">'+ value.name +'</td>'+
										'<td>'+ value.cname +' / '+ value.secname +'</td>'+
										'<td>'+ value.admission_no +'</td>'+
										'<td>'+ value.roll_no +'</td>';
										
										if (typeof value.marks != 'undefined'){	
										x = x + '<td><input type="text" class="subject_mark_box" data-max="'+response.max+'" data-s_id="'+ value.s_id +'" value="'+value.marks+'" required></td>';
											}
											else{
										x = x + '<td><input type="text" class="subject_mark_box" data-max="'+response.max+'" data-s_id="'+ value.s_id +'" value="" required></td>';
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



$(document).on('keypress','.subject_mark_box',function(e){
    var keyCode = e.which ? e.which : e.keyCode;
    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode <= 65 || keyCode <= 8));
    if(!ret){
        e.preventDefault();
    }
});

$(document).on('keyup','.subject_mark_box',function(){
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

$(document).on('blur','.subject_mark_box',function(){
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


$(document).on('click','#subject_mark',function(){
	  var total_marks = [];
	  var stud_mark = [];
	  
	  var allentry = true;
	
	var reqlength = $('.subject_mark_box').length;
    console.log(reqlength);
    var value = $('.subject_mark_box').filter(function () {
        return this.value != '';
    });

    if (value.length>=0 && (value.length !== reqlength)) {
		alert('Please fill out all marks fields.');
		allentry = false;
		
    } else {
  
	  var f = 1;
	  $(".subject_mark_box").each(function() {
		  	var temp = {};						//flag bit
		    temp.val = $(this).val();
		    if($(this).val() == ''){
			    $(this).addClass('marks_error');
			    f = 0;
		    }
		    temp.s_id = $(this).data('s_id');
			stud_mark.push(temp);
		});

atten(stud_mark);
	}
});


function atten(stud_mark){

	form_value();	
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Marks_entry_cc/marks_entry',
			dataType: "json",
			data: {
				'medium': medium,
				'class' : class_id,
				'section' : section,
				'e_type' : e_type,
				'subject' : subject,
				'marks' : stud_mark
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				if(response.status == 200){
					alert('Marks Submitted Successfully.');
					location.reload();
				}else{
					 alert('Somthing went wrong.');
					}
			}
	  });
	  
}


});
</script>