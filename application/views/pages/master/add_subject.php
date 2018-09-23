<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Subjects
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>Svr_ctrl/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Subject</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
			<div class="box box-primary">
				<div class="box-header with-border">
			  		<h3 class="box-title">Add New Subject</h3>
			  		<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  		<i class="fa fa-minus"></i></button>
			  		</div>	
				</div>
				<form role="form" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
                  			<label class="col-sm-3 control-label">Subject</label>
                  			<div class="col-sm-9">
                  				<input type="text" id="subj_id" class="form-control" placeholder="Enter subject name">
                  				<input type="hidden" id="subject_id" class="form-control" value="0">
                  				<div id="subj_id_err" class="text-danger" style="display: none;"></div>
                  			</div>
                		</div>
						<div class="form-group">
	                    	<label class="col-sm-3 control-label">Subject Type</label>
							<div class="col-sm-9">
								<select class="form-control" id="s_type">
									<option value="0" selected>Select Subject Type</option>
									<option value="Scholastic">Scholastic Area</option>
									<option value="Co-Scholastic">Co-Scholastic Area</option>
									<option value="Elective">Elective</option>
									<option value="Internal_assessment">Internal Assessment</option>
								</select>
								<div id="s_type_err" class="text-danger" style="display: none;"></div>
							</div>
						</div>
					</div>
					<div class="box-footer">
                		<button type="button" id="sub_update" class="btn pull-right btn-info" style="display:none;">Update</button>
						<button type="button" id="sub_submit" class="btn pull-right btn-info">Submit</button>
						<button type="reset" id="reset" class="btn btn-default pull-right btn-space" >Cancel</button>
            		</div>
				</form>
			</div>
			<div class="box box-info">
        		<div class="box-header with-border">
          			<h3 class="box-title">Co-Scholastic Area List</h3>
          			<div class="box-tools pull-right">
            			<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              			<i class="fa fa-minus"></i></button>
          			</div>
        		</div>
				<div class="box-body table-responsive no-padding">
              		<table class="table table-hover">
                		<tr>
                  			<th>S.No.</th>
                  			<th>Subject Name</th>
                  			<th>Edit/Delete</th>
                		</tr>
                		<tbody id="co-scholastic_display">
		                	<?php $i=1;  foreach($subjects as $subject){ ?>
		                		<?php if($subject['subj_type'] == 'Co-Scholastic'){ ?>
		                		<tr>
			                  		<td><?php echo $i;?></td>
			                  		<td><?php echo $subject['name'];?></td>
			                  		<td>
			                  			<a type="button" class="sub_edit btn btn-warning btn-flat" data-sid="<?php echo $subject['sub_id']; ?>" title="Edit" ><i class="fa fa-pencil"></i></a> 
			                  			<a type="button" class="sub_delete btn btn-danger btn-flat" data-sid="<?php echo $subject['sub_id']; ?>" title="Delete"><i class="fa fa-trash-o"></i></a>
			                  		</td>
		                		</tr>	
		                	<?php } else{ continue; } $i++; } ?>
	                	</tbody>
              		</table>
            	</div>
      		</div>
	        <div class="box box-warning">
		        <div class="box-header with-border">
		        	<h3 class="box-title">Elective Subjects List</h3>
	          		<div class="box-tools pull-right">
	            		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
	              		<i class="fa fa-minus"></i></button>
	          		</div>
		        </div>
				<div class="box-body table-responsive no-padding">
	              	<table class="table table-hover">
		                <tr>
		                  	<th>S.No.</th>
	                  		<th>Subject Name</th>
	                  		<th>Edit/Delete</th>
	                	</tr>
	                	<tbody id="internal_display">
		                	<?php $i=1;  foreach($subjects as $subject){ ?>
		                		<?php if($subject['subj_type'] == 'Elective'){ ?>
		                		<tr>
			                  		<td><?php echo $i;?></td>
			                  		<td><?php echo $subject['name'];?></td>
			                  		<td>
			                  			<a type="button" class="sub_edit btn btn-warning btn-flat" data-sid="<?php echo $subject['sub_id']; ?>" title="Edit" ><i class="fa fa-pencil"></i></a> 
			                  			<a type="button" class="sub_delete btn btn-danger btn-flat" data-sid="<?php echo $subject['sub_id']; ?>" title="Delete"><i class="fa fa-trash-o"></i></a>
			                  		</td>
		                		</tr>	
		                	<?php } else{ continue; } $i++; } ?>
	                	</tbody>
	              	</table>
	            </div>
	      	</div>
       </section>
       
		<section class="col-lg-6 connectedSortable">
    		<div class="box box-danger">
        		<div class="box-header with-border">
          			<h3 class="box-title">Scholastic Area List</h3>
          			<div class="box-tools pull-right">
            			<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              			<i class="fa fa-minus"></i></button>
          			</div>
        		</div>
				<div class="box-body table-responsive no-padding">
              		<table class="table table-hover">
                		<tr>
                  			<th>S.No.</th>
                  			<th>Subject Name</th>
                  			<th>Edit/Delete</th>
                		</tr>
                		<tbody id="scholastic_display">
		                	<?php $i=1;  foreach($subjects as $subject){ ?>
		                		<?php if($subject['subj_type'] == 'Scholastic'){ ?>
		                		<tr>
			                  		<td><?php echo $i;?></td>
			                  		<td><?php echo $subject['name'];?></td>
			                  		<td>	
			                  			<a type="button" class="sub_edit btn btn-warning btn-flat" data-sid="<?php echo $subject['sub_id']; ?>" title="Edit" ><i class="fa fa-pencil"></i></a> 
			                  			<a type="button" class="sub_delete btn btn-danger btn-flat" data-sid="<?php echo $subject['sub_id']; ?>" title="Delete"><i class="fa fa-trash-o"></i></a>
			                  		</td>
		                		</tr>	
		                	<?php } else{ continue; } $i++; } ?>
	                	</tbody>
              		</table>
            	</div>
      		</div>
			<div class="box box-success">
		        <div class="box-header with-border">
	          		<h3 class="box-title">Internal Assessment Subject List</h3>
	          		<div class="box-tools pull-right">
	            		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
	              		<i class="fa fa-minus"></i></button>
	          		</div>
	        	</div>
				<div class="box-body table-responsive no-padding">
	              	<table class="table table-hover">
		                <tr>
		                  	<th>S.No.</th>
	                  		<th>Subject Name</th>
	                  		<th>Edit/Delete</th>
	                	</tr>
	                	<tbody id="internal_display">
		                	<?php $i=1;  foreach($subjects as $subject){ ?>
		                		<?php if($subject['subj_type'] == 'Internal_assessment'){ ?>
		                		<tr>
			                  		<td><?php echo $i;?></td>
			                  		<td><?php echo $subject['name'];?></td>
			                  		<td>
			                  			<a type="button" class="sub_edit btn btn-warning btn-flat" data-sid="<?php echo $subject['sub_id']; ?>" title="Edit" ><i class="fa fa-pencil"></i></a> 
			                  			<a type="button" class="sub_delete btn btn-danger btn-flat" data-sid="<?php echo $subject['sub_id']; ?>" title="Delete"><i class="fa fa-trash-o"></i></a>
			                  		</td>
		                		</tr>	
		                	<?php } else{ continue; } $i++; } ?>
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

$(document).on('click','#sub_submit,#sub_update',function(){
	var text = $('#subj_id').val();
	var s_type = $('#s_type').val();
	var s_id = $('#subject_id').val();

	var formvalid = true;
	if($('#subj_id').val().length < 2  || $('#subj_id').val() == ''){
		formvalid = false;
		$('#subj_id_err').html('invalid Subject.').css('display','block');
	} else {
		$('#subj_id_err').css('display','none');
	}
	
	if($('#s_type').val() == '0'){
		formvalid = false;
		$('#s_type_err').html('Please Select Subject Type.').css('display','block');
	} else {
		$('#s_type_err').css('display','none');
	}

	if(formvalid){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Subject_ctrl/subject_create',
			dataType: "json",
			data: {
			  'text' : text,
			  'type' : s_type,
			  's_id' : s_id
			},
			beforeSend: function(){
			},
			success: function (response){
				console.log(response);
				if(response.status == 200){
						var x = '<tr>'+
									'<td>0</td>'+
				                  	'<td>'+ response.data[0].name +'</td>'+
				                  	'<td>'+
				                  		'<a type="button" class="sub_edit btn btn-warning btn-flat" data-sid="'+ response.data[0].sub_id +'" title="Edit" ><i class="fa fa-pencil"></i></a>'+ 
				                  		'<a type="button" class="sub_delete btn btn-danger btn-flat" data-sid="'+ response.data[0].sub_id +'" title="Delete"><i class="fa fa-trash-o"></i></a>'+
				                  	'</td>'+
			                	'</tr>';   
			        if(response.data[0].subj_type == 'Scholastic'){  				
	    				$('#scholastic_display').prepend(x);
					 }
			        else if(response.data[0].subj_type == 'Co-Scholastic'){
			        	$('#co-scholastic_display').prepend(x);
			        }
			        else if(response.data[0].subj_type == 'Internal assessment'){
			        	$('#internal_display').prepend(x);
			        }
			        else if(response.data[0].subj_type == 'General awareness'){
			        	$('#gernal_display').prepend(x);
			        }
				}
				else if(response.status == 300){
					location.reload();
				}
			},
			complete: function(){
				$('#subject_id').val('0');
			}
		});	
	}
});

$(document).on('click','.sub_edit',function(){
	  var s_id = $(this).data('sid');
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Subject_ctrl/subject_detail',
			dataType: "json",
			data: {
			  'sid' : s_id
			},
			beforeSend: function(){
			},
			success: function (response){
				$('#sub_submit').hide();
				$('#sub_update').show();
				$('#subject_id').val(response.data[0].sub_id);
				$('#subj_id').val(response.data[0].name);
				$('#s_type').val(response.data[0].subj_type);
				$('#subj_id').focus();
			},
			complete: function(){
			}
		});
});

$(document).on('click','.sub_delete',function(){
	  var x = confirm('Are you Sure... \nIf you delete Subject means \nAll Student Record Accosiated with this Subject is also Deleted.');
	  if(x){
	  var s_id = $(this).data('sid');
	  var that = this;
		  $.ajax({
				type: 'POST',
				url: baseUrl+'Subject_ctrl/subject_delete',
				dataType: "json",
				data: {
				  'sid' : s_id
				},
				beforeSend: function(){
				},
				success: function (response){
					if(response.status == 200){
						$(that).closest('tr').hide('slow');
					}
				},
				complete: function(){
				}
			});
	  }
});

$(document).on('click','#reset',function(){
	$('#sub_update').hide();
	$('#sub_submit').show();
});

</script>