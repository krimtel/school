<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add New User
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home </a></li>
        <li class="active">Add New User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New User</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="add_user_form" role="form" class="form-horizontal" name="f1" method="POST" action="<?php echo base_url();?>Teacher_ctrl/add_user">
			<div class="box-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Select Teacher Name</label>
					<div class="col-sm-9">
					<select class="form-control" name="teacher" id="teacher">
						<option value="0">Select teacher name</option>
						<?php foreach($teachers as $teacher){ ?>
							<option value="<?php echo $teacher['t_id']; ?>"><?php echo $teacher['name']; ?></option>
						<?php } ?> 
					</select>
					<div class="text-danger" id="teacher_err" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Login Id</label>
                  <div class="col-sm-9">
					<input type="text" class="form-control" name="uname" placeholder="Enter login id" id="uname">		
					<div class="text-danger" id="uname_err" style="display:none;"></div>
				  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Password</label>
					<div class="col-sm-9">
						<input type="text" name="password" class="form-control" placeholder="Enter password" id="password">
						<div class="text-danger" id="password_err" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label">Student Entry</label>
					<div class="col-sm-9">
						<label class="col-sm-6">
						  <input name="student_entry" id="student_entry_yes" type="radio" class="flat-red pull-left student_entry" value="1"> 
						  <span class="pull-left" style="margin-left:15px;">Enable</span>
						</label>
						<label class="col-sm-6">
						  <input name="student_entry" id="student_entry_no" type="radio" class="flat-red pull-left student_entry" value="0">
						  <span class="pull-left" style="margin-left:15px;">Disable</span>
						</label>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-3 control-label">Marks Entry / Updation</label>
					<div class="col-sm-9">
						<label class="col-sm-6">
						  <input name="marks_entry" id="marks_entry_yes" type="radio" class="flat-red pull-left" value="1"> 
						  <span class="pull-left" style="margin-left:15px;">Enable</span>
						</label>
						<label class="col-sm-6">
						  <input name="marks_entry" id="marks_entry_no" type="radio" class="flat-red pull-left" value="0">
						  <span class="pull-left" style="margin-left:15px;">Disable</span>
						</label>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="button" id="update" class="btn pull-right btn-info" style="display: none; "> Update </button>
				<button type="button" id="submit" class="btn pull-right btn-info"> Submit </button>
				<button type="reset" id="cancel" class="btn btn-default pull-right btn-space"> Cancel </button>
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
          <h3 class="box-title">All Users List</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
					<tr>
					  <th style="width:10%;">S.No.</th>
					  <th style="width:40%;">Teacher Name</th>
					  <th style="width:10%;">Login Id</th>
					  <th style="width:10%;">Password</th>
					  <th style="width:10%;">Student Entry</th>
					  <th style="width:10%;">Marks Entry</th>
					  <th style="width:10%;">Delete</th>
					</tr>
				<?php $i=1; foreach($users as $user){ ?>
					<tr>
					  <td><?php echo $i; ?>.</td>
					  <td><?php echo $user['name']; ?></td>
					  <td>
						<input type="text" class="uname_edit" data-uid="<?php echo $user['uid']; ?>" data-name="<?php echo $user['uname']; ?>" value="<?php echo $user['uname']; ?>"></td>
					  <td><input type="text" class="upass_edit" data-uid="<?php echo $user['uid']; ?>" data-pass="<?php echo $user['password']; ?>" value="<?php echo $user['password']; ?>"></td>
					  <td>
						<?php 
							$array = explode(",",$user['permission']);
							$x = $array;
							if(array_search("1",$x)){ ?>	
								<input type="checkbox" name="std_entry" data-id="<?php echo $user['uid']; ?>" class="std_entry" checked>	
							<?php }else { ?>
								<input type="checkbox" name="std_entry" data-id="<?php echo $user['uid']; ?>" class="std_entry">
							<?php } ?>
					
					  </td>
					  <td>
						<?php
							$array = explode(",",$user['permission']);
							$x = $array;
							if(array_search("2",$x)){ ?>	
								<input type="checkbox" name="marks_entry" data-id="<?php echo $user['t_id']; ?>" class="marks_entry" checked>
							<?php }else { ?>
								<input type="checkbox" name="marks_entry" data-id="<?php echo $user['t_id']; ?>" class="marks_entry">
							<?php } ?>	
					  </td>
					  <td>
							<a type="button" class="user_delete btn btn-danger btn-flat" data-uid="<?php echo $user['uid']; ?>" class="btn btn-danger btn-flat" title="Delete"><i class="fa fa-trash-o"></i></a></td>
					</tr>
				<?php $i++; } ?>
              </table>
            </div>
      </div>

        </section>
      </div>
    </section>
  </div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div id="modal_body"></body>
	</div>
</div>

<script>
var baseUrl = $('#base_url').val();

$(document).on('click','#cancel',function(){
	$('#submit').show();
	$('#update').hide();
});

$(document).on('click','#submit',function(){
	var formvalid = true;
	if($('#teacher').val() == "0"){
		  formvalid = false;
		  $('#teacher_err').html('Please Select Teacher.').css('display','block');
	  }else{
		  $('#teacher_err').css('display','none');
	  }
	
	if($('#uname').val() == ""){
		  formvalid = false;
		  $('#uname_err').html('Please Enter User Name.').css('display','block');
	  }else{
		  $('#uname_err').css('display','none');
	  }
	
	if($('#password').val() == ""){
		  formvalid = false;
		  $('#password_err').html('Please Enter User Password.').css('display','block');
	  }else{
		  $('#password_err').css('display','none');
	  }

	if(formvalid){
		$('#add_user_form').ajaxForm({
			dataType : 'json',
			beforeSubmit:function(e){
				$('#loader').modal('show');
			},
			success:function(response){
				$('#loader').modal('toggle');
			  if(response.status == 200){
				  location.reload();
			  }
			  else{
				alert(response.msg);
			  }
			}
		}).submit();
	}
});

$(document).on('change','#teacher',function(){
	var t_id = $(this).val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Admin_ctrl/user_detail',
		dataType: "json",
		data: {
			't_id' : t_id
		},
		beforeSend: function(){},
		success:  function (response) {
			if(response.status == 200){
				$('#uname').val(response.data.userid);
				$('#password').val(response.data.password);
				if (response.data.permission.indexOf('1') > -1){ 
				  	$("#student_entry_yes").prop("checked", true);
				}
				if (response.data.permission.indexOf('2') > -1){ 
				  	$("#marks_entry_yes").prop("checked", true);
				}
			$('#submit').hide();
			$('#update').show();
			
			}				
		}
	});
});

$(document).on('click','#update',function(){
	var t_id = $('#teacher').val();
	var uname = $('#uname').val();
	var pass = $('#password').val();
	var sentry = '';
	if($('#student_entry_yes').is(':checked')){
		var sentry = 1;	
	}
	else{
		var sentry = 0;
	}
	var mentry = '';
	if($('#marks_entry_yes').is(':checked')){
		var mentry = 1;
	}
	else{
		var mentry = 0;
	}

	$.ajax({
		type: 'POST',
		url: baseUrl+'Teacher_ctrl/add_user',
		dataType: "json",
		data: {
			'student_entry' : sentry,
			'marks_entry' : mentry,
			'password' : pass,
			'uname' : uname,
			'teacher' : t_id,
		},
		beforeSend: function(){
			$('#loader').modal('show');
		},
		success:  function (response) {
			$('#loader').modal('toggle');
			alert('User updated.');
			location.reload();
		}
	});
});

$(document).on('dblclick','.uname_edit',function(){
	var name = $(this).data('name');
	var id = $(this).data('uid');

	var x = '';
	x = x + '<div class="modal-content">'+
				'<div class="modal-header">'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					'<h4 class="modal-title" id="myModalLabel">Change User Name</h4>'+
				'</div>'+
				'<div class="modal-body">'+
					'<lable>Uname: </lable>'+
					'<input type="hidden" id="userid" value="'+ id +'">'+
					'<input type="text" id="usernameedit" value="'+ name +'">'+
				'</div>'+
				'<div class="modal-footer">'+
					'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
					'<button type="button" id="uname_submit" class="btn btn-primary">Save changes</button>'+
				'</div>'+
			'</div>';
	$('#modal_body').html(x);
	$('#myModal').modal('show');
});

$(document).on('click','#uname_submit',function(){
	var id = $('#userid').val();
	var name = $('#usernameedit').val();
	$.ajax({
			type: 'POST',
			url: baseUrl+'Admin_ctrl/uname_edit',
			dataType: "json",
			data: {
				'id' : id,
				'name' : name
			},
			beforeSend: function(){},
			success:  function (response) {
				location.reload();
			}
		});
});

$(document).on('dblclick','.upass_edit',function(){
	var pass = $(this).data('pass');
	var id = $(this).data('uid');

	var x = '';
	x = x + '<div class="modal-content">'+
				'<div class="modal-header">'+
					'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					'<h4 class="modal-title" id="myModalLabel">Change User Password</h4>'+
				'</div>'+
				'<div class="modal-body">'+
					'<lable>Password: </lable>'+
					'<input type="hidden" id="userid" value="'+ id +'">'+
					'<input type="text" id="userpassedit" value="'+ pass +'">'+
				'</div>'+
				'<div class="modal-footer">'+
					'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
					'<button type="button" id="upass_submit" class="btn btn-primary">Save changes</button>'+
				'</div>'+
			'</div>';
	$('#modal_body').html(x);
	$('#myModal').modal('show');
});

$(document).on('click','#upass_submit',function(){
	var id = $('#userid').val();
	var pass = $('#userpassedit').val();
	$.ajax({
			type: 'POST',
			url: baseUrl+'Admin_ctrl/upass_edit',
			dataType: "json",
			data: {
				'id' : id,
				'pass' : pass
			},
			beforeSend: function(){},
			success:  function (response) {
				location.reload();
			}
		});
});


$(document).on('click','.std_entry',function(){
	var id = $(this).data('id');
	if($(this). prop("checked") == true){
		var x = confirm('Are you Sure.');
		if(x){
			$.ajax({
				type: 'POST',
				url: baseUrl+'Admin_ctrl/user_permission',
				dataType: "json",
				data: {
					'id' : id,
					'type' : 's_entry',
					'val' : 1
				},
				beforeSend: function(){},
				success:  function (response) {
					//location.reload();
				}
			});
		} else {
			$(this).prop('checked', false);
		}
	} 
	else {
		var x = confirm('Are you Sure.');
		if(x){
			$.ajax({
				type: 'POST',
				url: baseUrl+'Admin_ctrl/user_permission',
				dataType: "json",
				data: {
					'id' : id,
					'type' : 's_entry',
					'val' : 0
				},
				beforeSend: function(){},
				success:  function (response) {
					//location.reload();
				}
			});
		} else {
			$(this).prop('checked', true);
		}
	}
});

$(document).on('click','.marks_entry',function(){
	var id = $(this).data('id');
	if($(this). prop("checked") == true){
		var x = confirm('Are you Sure.');
		if(x){
			$.ajax({
				type: 'POST',
				url: baseUrl+'Admin_ctrl/user_permission',
				dataType: "json",
				data: {
					'id' : id,
					'type' : 'm_entry',
					'val' : 1
				},
				beforeSend: function(){},
				success:  function (response) {
					//location.reload();
				}
			});
		} else {
			$(this).prop('checked', false);
		}
	} 
	else {
		var x = confirm('Are you Sure.');
		if(x){
			$.ajax({
				type: 'POST',
				url: baseUrl+'Admin_ctrl/user_permission',
				dataType: "json",
				data: {
					'id' : id,
					'type' : 'm_entry',
					'val' : 0
				},
				beforeSend: function(){},
				success:  function (response) {
					//location.reload();
				}
			});
		} else {
			$(this).prop('checked', true);
		}
	}
});

$(document).on('click','.user_delete',function(){
	var id = $(this).data('uid');
	var that = this;
	var x = confirm('Are You Sure.');
	if(x){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Admin_ctrl/user_delete',
			dataType: "json",
			data: {
				'uid' : id
			},
			beforeSend: function(){},
			success:  function (response) {
				$(that).closest('tr').hide('slow');
			}
		});
	}
});
</script>