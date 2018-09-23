<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Teachers Abstract
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Teachers Abstract</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable hidden-print">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Teachers Abstract List</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
				
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Medium</label>
					<div class="col-sm-10">
						<select class="form-control" id="medium">
						<?php if(isset($medium)){ ?>
								<option value="<?php echo $medium; ?>"><?php echo $medium; ?></option>
						<?php }else{ ?>
							<option value="0">Select Medium</option>
							<option value="Hindi">Hindi</option>
							<option value="English">English</option>
						<?php } ?>
						</select>
						<div class="text-danger" id="medium_err" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Exam</label>
					<div class="col-sm-10">
						<select class="form-control" id="e_type">
							<option value="0">Select Exam type</option>
							<option value="1">Pre</option>
							<option value="4">Mid</option>
							<option value="6">Post</option>
							<option value="9">Final</option>
						</select>
						<div class="text-danger" id="e_type_err" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Teacher</label>
					<div class="col-sm-10">
					<select class="form-control" id="teacher">						
						<option value="0">Select Teacher</option>						
						<?php foreach($teachers as $teacher){ ?>
							<option value="<?php echo $teacher['t_id']; ?>"><?php echo $teacher['name']; ?></option>
						<?php } ?>
					</select>
					<div class="text-danger" id="teacher_err" style="display:none;"></div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="button" class="btn pull-right btn-info btn-space" id="teachers_abstract_result">Teachers Abstract</button> 
				 <button type="submit" class="btn btn-default pull-right btn-space">Clear</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
        </section>
<?php if($school_id == 1){ ?>
		<div class="col-lg-12 text-center visible-print"><b class="sv"><h3>Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</h3></b></div>
		<?php } else{ ?>
		<div class="col-lg-12 text-center visible-print"><b class="sv"><h3>Sharda Vidyalaya, Rishali, Bhilai, Chhattisgarh</h3></b></div>
		<?php } ?>
<section class="col-lg-12 connectedSortable">
			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title"><b><span id="t_name"></span> Abstract- </b></h3>
				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
					  <i class="fa fa-minus"></i></button>
				  </div>
				</div>
				<div class="box-body">
					<!--<div>Name: <b><span id="t_name"></span></b></div>-->
					<table id="teacher_abstract" class="table table-bordered table-responsive table-striped text-center">
						
					</table>
				</div>
			</div>
		</section>
      </div>
      
    </section>
    <!-- /.content -->
  </div>

<script>
var baseUrl = $('#base_url').val(); 
$(document).on('click','#teachers_abstract_result',function(){
	var class_id = $('#class').val();
	var medium = $('#medium').val();
	var e_type = $('#e_type').val();
	var t_id = $('#teacher').val();
	$('#t_name').html( $('#teacher option:selected').text());
	$.ajax({
		type: 'POST',
		url: baseUrl+'Teacher_ctrl/teacher_abstract_new',
		dataType: "json",
		data: {
			'class' : class_id,
			'medium' : medium,
			'e_type' : e_type,
			't_id' : t_id
		},
		beforeSend: function(){},
		success:  function (response) {
			var x = '<thead><tr><th>Class</th><th>Section</th><th>Subjects</th><th>Total Student</th><th>Total App.</th><th>Pass</th><th>Pass(%)</th><th>First Div.</th><th>First Div(%)</th><th>Second Div.</th><th>Third Div.</th><th>Fail</th><th>Max/No. of Student</th><th>Pi</th></tr></thead>';
			console.log(response);
			$.each(response.data,function(key,value){
				x = x +'<tr>'+
							'<td>'+ value[0].class_id +'</td>'+
							'<td>'+ value[0].section +'</td>'+
							'<td>'+ value[0].subject +'</td>'+
							'<td>'+ value[0].total_student +'</td>'+
							'<td>'+ value[0].notapper  +'</td>'+
							'<td>'+ value[0].total_pass +'</td>'+
							'<td>'+ value[0].pass_percent +'</td>'+
							'<td>'+ value[0].first_div +'</td>'+
							'<td>'+ value[0].first_percent +'</td>'+
							'<td>'+ value[0].second_div +'</td>'+
							'<td>'+ value[0].third_div +'</td>'+
							'<td>'+ value[0].fail +'</td>'+
							'<td>'+ value[0].max +'/'+ value[0].get_max +'</td>'+
							'<td>'+ value[0].pi +'</td>'+
					  +'</tr>'; 
			});
			$('#teacher_abstract').html(x);
		}
	});
});
</script>
  
