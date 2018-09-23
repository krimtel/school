<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Log Report</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Log Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Search User Log Report</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
				<div class="box-body">
	                <div class="form-group col-sm-6">
	                  <label class="col-sm-3 control-label">User Name </label>
	                  <div class="col-sm-9">
							<select class="form-control" name="user" id="user">
							<option value="0">Select user</option>
							<?php foreach($users as $user){ ?>
								<option value="<?php echo $user['uid']; ?>"><?php echo $user['uname']; ?></option>	
							<?php } ?>
							</select>
						</div>
	                </div>
				</div>
				
				<div class="box-body">
	                <div class="form-group col-sm-6">
	                  <label class="col-sm-3 control-label">From </label>
	                  <div class="col-sm-9">
							<input type="date" name="date_from" id="date_from" class="form-control">
						</div>
	                </div>
				</div>
				
				<div class="box-body">
	                <div class="form-group col-sm-6">
	                  <label class="col-sm-3 control-label">To </label>
	                  <div class="col-sm-9">
							<input type="date" name="date_from" id="date_to" class="form-control" value="<?php echo date('Y-m-d');?>">
						</div>
	                </div>
				</div>
			
				<div class="box-footer"> 
					<button type="button" id="form_submit" class="btn pull-right btn-info">Search</button> 
	            </div>
			</form>
			<!-- /.box-body -->
		</div>
         <div class="well" id="log_report"></div>
        </section>
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  
 <script>
 	var baseUrl = $('#base_url').val();

 	$(document).on('click','#form_submit',function(){
 	 	var user_id = $('#user').val();
 	 	var from = $('#date_from').val();
 	 	var to = $('#date_to').val();
 	 	$.ajax({
			type: 'POST',
			url: baseUrl+'Log_ctrl/log_report',
			dataType: "json",
			data: {
				'user_id': user_id,
				'from' : from,
				'to' : to
			},
			beforeSend: function(){
				$('#loader').modal('show');		
			},
			success: function (response) {
				$('#loader').modal('toggle');
				var x = '<table class="table"><tr><th>Teacher</th><th>Event</th><th>School</th><th>Class</th><th>Section</th><th>Subject</th><th>Admission no</th><th>Medium</th><th>Time</th></tr>';
				if(response.status == 200){
					$.each(response.data,function(key,value){
						x = x + '<tr>'+
									'<td>'+ value.name +'</td>'+
									'<td>'+ value.event_name +'</td>'+
									'<td>'+ value.school +'</td>'+
									'<td>'+ value.cname +'</td>'+
									'<td>'+ value.secname +'</td>'+
									'<td>'+ value.sname +'('+ value.subj_type +')</td>'+
									'<td>'+ value.admission_no +'</td>'+
									'<td>'+ value.medium +'</td>'+
									'<td>'+ value.logtime +'</td>'+
								'</tr>'; 
					});
					x = x + '</table>';
					$('#log_report').html(x);
				}
			}
 	 	});
 	});
 </script>