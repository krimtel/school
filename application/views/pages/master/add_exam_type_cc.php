<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Exam Type
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Exam Type</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New Exam Type</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="e_form" method="POST" action="<?php echo base_url();?>Exam_ctrl/add_exam_type" role="form" class="form-horizontal">
			<div class="box-body">
                <!-- text input -->
                <div class="form-group">
                  <label class="col-sm-3 control-label">Exam Type Name</label>
                  <div class="col-sm-9">
                  	<input type="hidden" id="e_id" value="">
                  	<input type="text" class="form-control" name="e_name" id="e_name" placeholder="Enter exam name">
                  	<div class="text-danger" id="e_name_err" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Out Of Marks</label>
                  <div class="col-sm-9">
                  	<input type="text" class="form-control" name="e_max" id="e_max" placeholder="Enter out of marks">
                  	<div class="text-danger" id="e_max_err" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Minimum Passing Marks</label>
                  <div class="col-sm-9">
                  	<input type="text" class="form-control" name="e_min" id="e_min" placeholder="Enter minimum passing marks">
                  	<div class="text-danger" id="e_min_err" style="display:none;"></div>
                  </div>
                </div>
			</div>
			<div class="box-footer">
				<button type="button" id="form-update" class="btn pull-right btn-info" style="display:none;">Update</button>
				<button type="button" id="form-submit" class="btn pull-right btn-info">Submit</button>
				<button type="reset" id="form-cencel" class="btn btn-default pull-right btn-space">Cancel</button>
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
          <h3 class="box-title">All Exam Type List</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>S.No.</th>
                  <th>Exam Type Name</th>
                  <th>Out Of Marks</th>
                  <th>Passing Marks</th>
				  <th>Edit/Delete</th>
                </tr>
                <tbody id="e_list">
                <?php if(count($e_types)>0){
                	$i =1;
                	foreach($e_types as $e_type){ ?>
                		<tr>
                			<td><?php echo $i; ?>.</td>
                			<td><?php echo $e_type['e_name']; ?></td>
                			<td><?php echo $e_type['max']; ?></td>
                			<td><?php echo $e_type['min']; ?></td>
                			<td>
                				<a href="javascript:void(0)" class="e_edit btn btn-warning btn-flat" data-id="<?php echo $e_type['e_id']; ?>" data-name="<?php echo $e_type['e_name'];?>" data-max="<?php echo $e_type['max'];?>" data-min="<?php echo $e_type['min'];?>"><i class="fa fa-pencil"></i></a>
                				<a href="javascript:void(0)" class="e_delete btn btn-danger btn-flat" data-id="<?php echo $e_type['e_id']; ?>"><i class="fa fa-trash"></i></a>
                			</td>
                		</tr>
                <?php $i++; }
                	}?>
              </table>
            </div>
      </div>
        </section>
      </div>
    </section>
  </div>
  
  <script>
  	var baseUrl = $('#base_url').val();

  	$(document).on('click','#form-submit',function(){
  	  var formvalid = true;
  	  if($('#e_name').val() == ''){
  		  formvalid = false;
  		  $('#e_name_err').html('Exam name Can\'t be Empty.').css('display','block');
  	  } else {
  		  $('#e_name_err').css('display','none');
  	  }

  	if($('#e_max').val() == ''){
		  formvalid = false;
		  $('#e_max_err').html('Enter Exam max mark.').css('display','block');
	  } else {
		  $('#e_max_err').css('display','none');
	  }

  	if($('#e_min').val() == ''){
		  formvalid = false;
		  $('#e_min_err').html('Enter Exam min pass mark.').css('display','block');
	  } else {
		  $('#e_min_err').css('display','none');
	  }

  	  if(formvalid){
		  	$('#e_form').ajaxForm({
			    dataType : 'json',
			    beforeSubmit:function(e){
					$('#loader').modal('show');
			    },
			    success:function(response){
				    console.log(response);
			  	  if(response.status == 200){
			  		
			  		var x = '<tr>'+
			  					'<td></td>'+
			  					'<td>'+ response.data[0].e_name +'</td>'+
			  					'<td>'+ response.data[0].max +'</td>'+
			  					'<td>'+ response.data[0].min +'</td>'+
			  					'<td>'+
                					'<a href="javascript:void(0)" class="e_edit btn btn-warning btn-flat" data-id="'+ response.data[0].e_id +'" data-name="'+ response.data[0].e_name +'" data-max="'+ response.data[0].max +'" data-min="'+ response.data[0].min +'"><i class="fa fa-pencil"></i></a>'+
                					'<a href="javascript:void(0)" class="e_delete btn btn-danger btn-flat" data-id="'+ response.data[0].e_id +'"><i class="fa fa-trash"></i></a>'+
                				'</td>'+
			  					'<td></td>'+
			  				'</tr>';
	  				$('#e_list').prepend(x);
	  				$('#loader').modal('toggle');
			      }
			      else{
				    alert(response.msg);
			      }
			    }
		  }).submit();
  	  }
  });

  $(document).on('click','.e_delete',function(){
	  var x = confirm('Are You Sure..');
	  if(x){
		  var e_id = $(this).data('id');
		  var that = this;
		  $.ajax({
				type: 'POST',
				url: baseUrl+'Exam_ctrl/exam_delete',
				dataType: "json",
				data: {
					'e_id':e_id
				},
				beforeSend: function(){
					
				},
				success:  function (response) {
					if(response.status == 200){
						$(that).closest('tr').hide('slow');
					}
				}
		  });
	  }
  });

  $(document).on('click','.e_edit',function(){
		$('#e_name').val($(this).data('name'));
		$('#e_max').val($(this).data('max'));
		$('#e_min').val($(this).data('min'));
		$('#e_id').val($(this).data('id'));
		$('#form-submit').hide();
		$('#form-update').show();
  });

  $(document).on('click','#form-cencel',function(){
	  $('#form-submit').show();
		$('#form-update').hide();
  });

  $(document).on('click','#form-update',function(){
	  var formvalid = true;
  	  if($('#e_name').val() == ''){
  		  formvalid = false;
  		  $('#e_name_err').html('Exam name Can\'t be Empty.').css('display','block');
  	  } else {
  		  $('#e_name_err').css('display','none');
  	  }

  	if($('#e_max').val() == ''){
		  formvalid = false;
		  $('#e_max_err').html('Enter Exam max mark.').css('display','block');
	  } else {
		  $('#e_max_err').css('display','none');
	  }

  	if($('#e_min').val() == ''){
		  formvalid = false;
		  $('#e_min_err').html('Enter Exam min pass mark.').css('display','block');
	  } else {
		  $('#e_min_err').css('display','none');
	  }

  	  if(formvalid){
  		$.ajax({
			type: 'POST',
			url: baseUrl+'Exam_ctrl/exam_update',
			dataType: "json",
			data: {
				'e_id':$('#e_id').val(),
				'e_name':$('#e_name').val(),
				'e_max':$('#e_max').val(),
				'e_min':$('#e_min').val()
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			success:  function (response) {
				if(response.status == 200){
					location.reload();
				}
			}
	  });
  	  }
  });
  </script>