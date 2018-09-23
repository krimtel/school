<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Session Create
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Session Create</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Create New Session</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
                <!-- text input -->
                <div class="form-group">
                  <label class="col-sm-3 control-label">Session</label>
                  <div class="col-sm-9">
					<input type="text" id="session_box" class="form-control" placeholder="ex- 2017-18">
					<div id="session_box_err" class="text-danger" style="display:none;"></div>
				  </div>
                </div>
			</div>
			<div class="box-footer">
				<button id="session_create" type="button" class="btn pull-right btn-info">Submit</button>
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
          <h3 class="box-title">All Session</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
	        	<table class="table table-hover">
	                	<tr>
                  			<th>Session</th>
                  			<th>Active</th>
	                	</tr>
	                	<tbody id="session_display">
	                	<?php foreach($sessions as $session){ ?>
	                		<tr>
	                  			<td><?php echo $session['name']; ?></td>
	                  			<td><?php if($session['status']){ ?>
	                  				<input class="session_status" data-sid="<?php echo $session['session_id']; ?>" type="checkbox" checked /><?php } else{ ?>
	                  				<input class="session_status" data-sid="<?php echo $session['session_id']; ?>" type="checkbox"/><?php }?> 
	                  			</td>
	                  			<td><a class="session_delete btn btn-warning btn-flat" data-sid="<?php echo $session['session_id']; ?>" ><i class="fa fa-trash"></i></a></td>
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
  
  $(document).on('click','#session_create',function(){
	  var text = $('#session_box').val();
	  if($('#session_box').val() != ''){
		  $.ajax({
				type: 'POST',
				url: baseUrl+'Session_ctrl/Session_create',
				dataType: "json",
				data: {
				  'text' : text	
				},
				beforeSend: function(){
					$('#loader').modal('show');
				},
				success: function (response){
					console.log(response);
					var x = '<tr>'+
              					'<td>'+ response.data[0].name +'</td>'+
              					'<td>'+
              						'<input class="session_status" data-sid="'+ response.data[0].session_id+'" type="checkbox"/>'+ 
              					'</td>'+
              					'<td><a class="session_delete btn btn-warning btn-flat" data-sid="'+ response.data[0].session_id+'" ><i class="fa fa-trash"></i></a></td>'+
            				'</tr>';
    				$('#session_display').append(x);
				},
				complete: function(){
					$('#loader').modal('toggle');
					$('#session_box').val('');
					$('#session_box_err').css('display','none');
				}
			});
	  }
	  else{
		 $('#session_box_err').html('Invalid Session.').css('display','block');
	  }
  });

  $(document).on('click','.session_status',function(){
	  var s_id = $(this).data('sid');
	  if($(this). prop("checked") == true){
		  var x = 1;
	  }
	  else{
		  var x = 0;
	  }
		  $.ajax({
				type: 'POST',
				url: baseUrl+'Session_ctrl/Session_status',
				dataType: "json",
				data: {
				  'sid' : s_id,
				  'val' : x	
				},
				beforeSend: function(){
					$('#loader').modal('show');
				},
				success: function (response){
					if(response.status == 200){
						location.reload();
					}
				},
				complete: function(){
					
				}
			});
  });

  $(document).on('click','.session_delete',function(){
	  var x = confirm('Are you Sure...');
	  if(x){
	  var s_id = $(this).data('sid');
	  var that = this;
		  $.ajax({
				type: 'POST',
				url: baseUrl+'Session_ctrl/Session_delete',
				dataType: "json",
				data: {
				  'sid' : s_id
				},
				beforeSend: function(){
					$('#loader').modal('show');
				},
				success: function (response){
					if(response.status == 200){
						$(that).closest('tr').hide('slow');
					}
				},
				complete: function(){
					$('#loader').modal('toggle');
				}
			});
	  }
  });
  </script>