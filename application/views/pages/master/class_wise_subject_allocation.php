<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Class Wise Subject Allocation
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Class Wise Subject Allocation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Class Wise Subject Asign</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
			<div class="form-group" >
				<label class="col-sm-2 control-label">Class</label>
				<div class="col-sm-10">
					<select class="form-control" name="class" id="class">
						<option value="0">Select Class</option>
							<?php foreach($classes as $class){ ?>
								<option value="<?php echo $class['c_id']; ?>"><?php echo $class['name']; ?></option>
							<?php }?>
					</select>
					<div id="class_err" class="text-danger" style="display:none;"></div>
				</div>
			</div>
			<div class="form-group" >
				<label class="col-sm-2 control-label">Select Subjects</label>
				<div class="col-sm-10">
					<?php foreach($subjects as $subject){ ?>
						<label class="col-sm-6">
							<input type="checkbox" name="subject[]" class="flat-red pull-left subject_list" data-id="<?php echo $subject['sub_id']; ?>" value="<?php echo $subject['sub_id']; ?>"> &nbsp;
							<span class="pull-left" style="margin-left:15px;"><?php echo $subject['name']; ?> ( <?php echo $subject['subj_type']; ?> )</span>
						</label>
					<?php } ?>
				</div>
			</div>
			</div>
			<div class="box-footer">
				<button type="button" id="form_submit" class="btn pull-right btn-info">Submit</button>
				<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
		</div>
         
        </section>
        <section class="col-lg-6 connectedSortable">
          <div class="box box-warning">
			<div class="box-header with-border">
			  <h3 class="box-title">All Class Wise Subject Asign</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<div class="box-body table-responsive no-padding">
	        	<table class="table table-hover">
					<tr>
						<th>S.No.</th>
						<th>Class</th>
						<th>Subjects</th>
						<th>Edit</th>
					</tr>
					<tbody>
						<?php $i = 1; foreach($class_subjects as $class_subject){ ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $class_subject['cname']; ?></td>
								<td>
									<?php foreach($class_subject['subjects'] as $subject){ 
										//echo '<b>'.$subject['name'].'</b>('. $subject['type'].')'.',&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '; 
										echo $subject['name'].',&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
									} ?>
								</td>
								<td><a href="javascript:void(0);" class="class_subject btn btn-warning btn-flat" data-id="<?php echo $class_subject['c_id']; ?>"><i class="fa fa-pencil"></i></a></td>
							</tr>
						<?php $i++; } ?>
	            	</tbody>
	            </table>
            </div>
      </div>
        </section>
      </div>
    </section>
  </div>
  
  <script>
	var baseUrl = $('#base_url').val();

	$(document).on('click','.class_subject',function(){
		var class_id = $(this).data('id');
		$('#class').val(class_id);	
		$('input:checkbox').removeAttr('checked');
		$('#class').focus();
		$("#class").trigger("change");
	});
	
	$(document).on('change','#class',function(){
		var c_id = $(this).val();
		$('input:checkbox').removeAttr('checked');
		$.ajax({
			type: 'POST',
			url: baseUrl + 'Subject_ctrl/class_subject_fetch/',
			dataType: "json",
			data: {
				'c_id':c_id
			},
			beforeSend: function(){},
			success:  function (response){
				if(response.status == 200){
					$.each(response.data,function(key,value){
						console.log(value.subject_id);
						$(":checkbox[value="+ value.subject_id +"]").prop("checked","true");
					});
				}
			}
		});
	});
	
	
	$(document).on('click','#form_submit',function(){
		var subjects = [];
		var c_id = $('#class').val();
		$('.subject_list').each(function(){
			if($(this). prop("checked") == true){
				subjects.push($(this).val());
			}
		});
		
		$.ajax({
			type: 'POST',
			url: baseUrl + 'Class_ctrl/class_wise_subject_allocation/',
			dataType: "json",
			data: {
				'c_id':c_id,
				'subjects' : subjects
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			success:  function (response){
					if(response.status == 200){
						location.reload();
					}
					else{
						location.reload();
					}
			}
		});
	});
  </script>