<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Attendance Entry
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>Svr_ctrl/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Student Attendance Entry</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title"></h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="attendance-form" method="POST" role="form" class="form-horizontal" action="<?php echo base_url();?>Attendance_ctrl/attendance_entry/">
			<div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Session<?php echo $this->session->userdata('session_id'); ?></label>
					<div class="col-sm-10">
						<select class="form-control" id="session" name="session">
							<option value="0">Select Session</option>
							<?php foreach($sessions as $session){ ?>
								<?php if($current_Session == $session['session_id']) {?>
									<option value="<?php echo $session['session_id']?>" selected><?php echo $session['name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $session['session_id']?>"><?php echo $session['name']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<div id="session_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Select Term</label>
					<div class="col-sm-10">
						<select class="form-control" id="term" name="term">
							<option value="0">Select Term</option>
							<option value="Mid">Mid Term</option>
							<option value="Final">Final</option>
						</select>
						<div id="term_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Class Category</label>
					<div class="col-sm-10">
						<select class="form-control" id="class_category" name="class_category">
							<option value="0">Select Class Category</option>
							<option value="primary">Pre-Primary</option>
							<option value="1-5">1-5</option>
							<option value="6-9">6-9</option>
							<option value="10th">10</option>
							<option value="11th">11</option>
							<option value="12th">12</option>
						</select>
						<div id="class_category_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-2 control-label">Total Attendance Days</label>
					<div class="col-sm-10">
						<input type="text" id="days" name="days" value="" class="form-control">
						<div id="days_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
			</div>
			<div class="box-footer">
                
				<button type="button" id="form-submit" class="btn pull-right btn-info">Submit</button>
				<button type="reset" id="reset" class="btn btn-default  pull-right btn-space">Cancel</button>
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
          <h3 class="box-title">All Attendance</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover text-center t-input-center">
                <thead>
				<tr>
                  <th>S.No.</th>
                  <th>Session</th>
                  <th>Class Category</th>
                  <th>Term</th>
                  <th>Days</th>
                  <th>Edit/Delete</th>
                </tr>
				</thead>
                <tbody>
                <?php $c = 1; foreach($session_days as $session_day){ ?>
                	<tr>
                		<td><?php echo $c; ?></td>
                		<td><?php echo $session_day['name']; ?></td>
                		<?php if($session_day['class_category'] == 'primary'){ ?>
                			<td>Pre-Primary</td>
                		<?php } else { ?>
                			<td><?php echo $session_day['class_category']; ?></td>
                		<?php } ?>
                		<td><?php echo $session_day['term']; ?></td>
                		<td><?php echo $session_day['days']; ?></td>
                		<td>
                			<a class="session_edit btn btn-warning btn-flat" data-id="<?php echo $session_day['id']; ?>"><i class="fa fa-pencil"></i></a>
                			<a class="session_delete btn btn-danger btn-flat" data-id="<?php echo $session_day['id']; ?>"><i class="fa fa-trash"></i></a>
                		</td>
                	</tr>
                <?php $c++; } ?>
                </tbody>
              </table>
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
 
$(document).on('click','#form-submit',function(){
	$('#attendance-form').ajaxForm({
	    dataType : 'json',
	    beforeSubmit:function(e){
			$('#loader').modal('show');
	    },
	    success:function(response){
	  	  if(response.status == 200){
	    	$('#loader').modal('toggle');
	    	alert(response.msg);
	    	location.reload();
	      }
	      else{
		    alert(response.msg);
	      }
	    }
	}).submit();
});

 $(document).on('change','#class_category',function(){
	 var c_cate = $(this).val();
	 var term = $('#term').val();
	 var session = $('#session').val();
	 $.ajax({
			type: 'POST',
			url: baseUrl+'Attendance_ctrl/session_days',
			dataType: "json",
			data: {
				'c_cat' : c_cate,
				'session' : session,
				'term' : term
			},
			beforeSend: function(){
			},
			success:  function (response) {
				if(response.status == 200){
					$('#days').val(response.data[0].days);			
				}
			}
	 });
 });

 $(document).on('change','#term',function(){
	 $('#days').val('');
	 $('#class_category').val(0);
 });


$(document).on('click','.session_edit',function(){
	var id = $(this).data('id');
	$.ajax({
		type: 'POST',
		url: baseUrl+'Attendance_ctrl/session_detail',
		dataType: "json",
		data: {
			'id' : id
		},
		beforeSend: function(){
			$('#loader').modal('show');
		},
		success:  function (response) {
			$('#session').val(response.data[0].session);
			$('#term').val(response.data[0].term);
			$('#term').val(response.data[0].term);
			$('#class_category').val(response.data[0].class_category);
			$('#days').val(response.data[0].days);
			$('#form-submit').text('Update');
			$('#loader').modal('toggle');
		}
	});
});

$(document).on('click','#reset',function(){
	$('#form-submit').text('Submit');
});


$(document).on('click','.session_delete',function(){
	var id = $(this).data('id');
	var that = this;
	$.ajax({
		type: 'POST',
		url: baseUrl+'Attendance_ctrl/session_delete',
		dataType: "json",
		data: {
			'id' : id
		},
		beforeSend: function(){
			$('#loader').modal('show');
		},
		success:  function (response) {
			$('#loader').modal('toggle');
			if(response.status == 200){
				$(that).closest('tr').hide('slow');
			}
		}
	});
 });
</script>