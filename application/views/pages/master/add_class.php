<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Class
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Class</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New Class</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Class</label>
                  <div class="col-sm-9"><input type="text" id="class_box" class="form-control" placeholder="Enter Class"></div>
                  <div class="col-sm-9"><input type="hidden" id="class_id" class="form-control" value=""></div>
                </div>
			</div>
			<div class="box-footer">
                
                <button id="class_edit" type="button" class="btn pull-right btn-info" style="display:none;">Update</button>
				<button id="class_create" type="button" class="btn pull-right btn-info">Submit</button>
				<button type="reset" class="btn btn-default pull-right btn-space">Cancel</button>
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
          <h3 class="box-title">All Class List</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Class</th>
                  <th>Edit/Delete</th>
                </tr>
                <tbody id="class_display">
                	<?php foreach($classes as $class){ ?>
                		<tr>
                  			<td><?php echo $class['name']; ?></td>
                  			<td>
                  				<a class="class_edit btn btn-info btn-flat" data-cid="<?php echo $class['c_id']; ?>" ><i class="fa fa-pencil"></i></a>
                  				<a class="class_delete btn btn-info btn-flat" data-cid="<?php echo $class['c_id']; ?>" ><i class="fa fa-trash"></i></a>
                  			</td>
                		</tr>
                	<?php } ?>
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
  
  $(document).on('click','#class_create,#class_edit',function(){
	  var c_id = $('#class_id').val();
	  var text = $('#class_box').val();
	  if($('#class_box').val() != ''){
		  $.ajax({
				type: 'POST',
				url: baseUrl+'Class_ctrl/class_create',
				dataType: "json",
				data: {
				  'text' : text,
				  'c_id' : c_id
				},
				beforeSend: function(){
				},
				success: function (response){
					if(response.status == 200){
						var x = '<tr>'+
	              					'<td>'+ response.data[0].name +'</td>'+
	              					'<td><a class="class_edit btn btn-info btn-flat" data-cid="'+ response.data[0].c_id+'" ><i class="fa fa-pencil"></i></a><a class="class_delete btn btn-info btn-flat" data-cid="'+ response.data[0].c_id+'" ><i class="fa fa-trash"></i></a></td>'+
	            				'</tr>';
	            		$('#class_box').val('');  
	            		$('#class_id').val('');        				
	    				$('#class_display').append(x);
					}
					else if(response.status == 300){
						location.reload();
					}
				},
				complete: function(){
				}
			});
	  }
	  else{
		  alert('show some error msg here');
	  }
  });

  $(document).on('click','.class_edit',function(){
	  var c_id = $(this).data('cid');
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Class_ctrl/Class_detail',
			dataType: "json",
			data: {
			  'cid' : c_id
			},
			beforeSend: function(){
			},
			success: function (response){
				$('#class_create').hide();
				$('#class_edit').show();
				$('#class_id').val(response.data[0].c_id);
				$('#class_box').val(response.data[0].name);
				
			},
			complete: function(){
			}
		});
  });

  $(document).on('click','.class_delete',function(){
	  var c_id = $(this).data('cid');
	  var that = this;
		  $.ajax({
				type: 'POST',
				url: baseUrl+'Class_ctrl/class_delete',
				dataType: "json",
				data: {
				  'cid' : c_id
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
  });
  </script>