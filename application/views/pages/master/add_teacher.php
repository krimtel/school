<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Teachers
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Teacher</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Import Teachers Record</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="csv-form" role="form" method="POST" class="form-horizontal" action="<?php echo base_url();?>Teacher_ctrl/add_teacher_csv">
				<div class="box-body">
				<div class="form-group">
                  <label class="col-sm-4 control-label" for="exampleInputFile">Import Teachers Record</label>
                  <div class="col-sm-8">
                  	<input type="file" name="userfile" id="exampleInputFile" ><span style="font-size:12px;">Only CSV File Upload.</span>
                  	<div id="csvfile" class="text-danger" style="display: none;"></div>
                  </div>
                </div>
                </div>
				<div class="box-footer">
				<button id="csv_submit" type="button" class="btn pull-right btn-info">Submit CSV</button>
				<button type="submit" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
			</div>
		<div class="box box-success">
			<div class="box-header with-border">
			  <h3 class="box-title">Add New Teacher</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="teacher_form" role="form" class="form-horizontal" name="f1" method="POST" action="<?php echo base_url();?>Teacher_ctrl/add_teacher">
			<div class="box-body">
				<div class="form-group">
                  <label class="col-sm-3 control-label">Teacher Name</label>
                  <div class="col-sm-9">
                  	<input type="hidden" name="t_id" id="t_id">
                  	<input type="text" name="name" id="name" class="form-control" placeholder="Enter teacher name">
                  	<div id="name_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label">Gender</label>
					<div class="col-sm-9">
					<select class="form-control" name="gender" id="gender">
						<option value="0">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
					<div id="gender_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Email ID</label>
                  <div class="col-sm-9">
                  	<input type="text" name="email" id="email" class="form-control" placeholder="Enter email id" required>
                  	<div id="email_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Permanent Address</label>
                  <div class="col-sm-9">
                  	<textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter permanent address"></textarea>
                  	<div id="address_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Mobile/Phone No.</label>
                  <div class="col-sm-9">
                  	<input type="text" name="phone" id="phone" class="form-control" onkeypress="phoneno()"  maxlength="10" placeholder="Enter contact no.">
                  	<div id="phone_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Date Of Birth</label>
					<div class="col-sm-9">
					<div class="input-group date">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
					  <input name="dob" type="text" class="form-control pull-right" id="datepicker2">
					</div>
					<div id="dob_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Qualification</label>
                  <div class="col-sm-9">
                  	<input name="qualif" id="qualif" type="text" class="form-control" placeholder="Enter teacher name">
                  	<div id="qualif_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Designation</label>
                  <div class="col-sm-9">
                  	<input name="design" id="design" type="text" class="form-control" placeholder="Enter teacher name">
                  	<div id="design_err" class="text-danger" style="display:none;"></div>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label" for="exampleInputFile">Profile Image</label>
                  <div class="col-sm-9">
                  	<input type="file" id="" name="userFiles[]">
                  </div>
                </div>
			</div>
			<div class="box-footer">
				<button type="button" id="form-submit" class="btn pull-right btn-info">Submit</button>
				<button type="reset" onclick="wintop()" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
         
        </section>
        
        <section class="col-lg-6 connectedSortable">

          <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">All Teachers</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              		<tr>
                		<th>S.No.</th>
                                <th>Image</th>
                  		<th>Teachers Name</th>
                  		<th>Designation</th>
                  		<th>Edit/Delete</th>
                	</tr>
                	<?php $i=1; foreach($teachers as $teacher){?>				
                	<tr>
                		<td><?php echo $i;?></td>
<td><img src="<?php echo base_url();?>photos/teachers/<?php echo strtolower($this->session->userdata('school'));?>/<?php echo $teacher['photo']; ?>" width="50"></td>
                                <td><?php echo $teacher['name']; ?></td>
				<td><?php echo $teacher['designation']; ?></td>
                  		<td>
                  			<a type="button" class="btn btn-warning btn-flat teacher_edit" data-id="<?php echo $teacher['t_id']; ?>" title="Edit" ><i class="fa fa-pencil"></i></a> 
                  			<a type="button" class="btn btn-danger btn-flat teacher_delete" data-id="<?php echo $teacher['t_id']; ?>" title="Delete"><i class="fa fa-trash-o"></i></a>
                  		</td>
                	</tr>
                	<?php $i++; } ?>
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

  <script >
  var baseUrl = $('#base_url').val();
  $(document).on('click','#form-submit',function(){

	  var formvalid = true;
	  if($('#name').val().length < 3){
		  formvalid = false;
		  $('#name_err').html('Teacher Name Should be Atleast 3 Character.').css('display','block');
	  }else{
		  $('#name_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#gender').val() == "0"){
		  formvalid = false;
		  $('#gender_err').html('Please Select Gender.').css('display','block');
	  }else{
		  $('#gender_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#email').val() == ''){
		  formvalid = false;
		  $('#email_err').html('Email-id is required.').css('display','block');
	  }
	  else{
		  $('#email_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#address').val().length == "0"){
		  formvalid = false;
		  $('#address_err').html('Please Fill-Up the Address Field.').css('display','block');
	  }else{
		  $('#address_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#phone').val().length != "10"){
		  formvalid = false;
		  $('#phone_err').html('Phone No. Not Valid.').css('display','block');
	  }else{
		  $('#phone_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#dob').val() == ""){
		  formvalid = false;
		  $('#dob_err').html('Please select Date Of Birth.').css('display','block');
	  }else{
		  $('#dob_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#qualif').val() == ""){
		  formvalid = false;
		  $('#qualif_err').html('Please Enter Teacher Qualification.').css('display','block');
	  }else{
		  $('#qualif_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#design').val() == ""){
		  formvalid = false;
		  $('#design_err').html('Please Enter Teacher Designation.').css('display','block');
	  }else{
		  $('#design_err').css('display','none');
		  formvalid = true;
	  }	  
	  if(formvalid){
		  $('#teacher_form').ajaxForm({
		    dataType : 'json',
		    beforeSubmit:function(e){
		    },
		    success:function(response){
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

  $(document).on('click','#csv_submit',function(){
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
	    beforeSubmit:function(e){
		    $('#loader').modal({'show':true});
	    },
	    complete : function(){
		    $('#loader').modal('hide');
		},
	    success:function(response){
	  	  if(response.status == 200){
	    	location.reload();
	      }
	      else{
		   // alert(response.msg);
	      }
	    }
	  }).submit();
	}
  });

  $(document).on('click','.teacher_edit',function(){
	  var t_id = $(this).data('id');
	  $.ajax({
			type: 'POST',
			url: baseUrl+'Teacher_ctrl/teacher_detail',
			dataType: "json",
			data: {
				't_id' : t_id
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			complete : function(){
				$('#loader').modal('toggle');
			},
			success:  function (response) {
				console.log(response);
				if(response.status == 200){
					$('#t_id').val(response.data[0]['t_id']);
					$('#name').val(response.data[0]['name']);
					$('#gender').val(response.data[0]['gender']);
					$('#email').val(response.data[0]['email']);
					$('#address').val(response.data[0]['address']);
					$('#phone').val(response.data[0]['phone']);
					$('#dob').val(response.data[0]['dob']);
					$('#qualif').val(response.data[0]['qualification']);
					$('#design').val(response.data[0]['designation']);
					$('#form-submit').text('Update');
					$('#name').focus();
				}
			}
	  }); 
  });

  $(document).on('click','.teacher_delete',function(){
	  var t_id = $(this).data('id');
	  var x = confirm('Are you sure..');
	  if(x){
		  $.ajax({
				type: 'POST',
				url: baseUrl+'Teacher_ctrl/teacher_delete',
				dataType: "json",
				data: {
					't_id' : t_id
				},
				beforeSend: function(){
					$('#loader').modal('show');
				},
				complete : function(){
					$('#loader').modal('toggle');
				},
				success:  function (response) {
					if(response.status == 200){
						location.reload();
					}
				}
		  });
	  }
  });
 
  function phoneno(){       
		$('#phone').keypress(function(e) {
			var a = [];
			var k = e.which;

			for (i = 48; i < 58; i++)
				a.push(i);

			if (!(a.indexOf(k)>=0))
				e.preventDefault();
		});
	}

  function wintop(){
	  $('#form-submit').html('Submit');
	  $('#name').focus();
  } 
  </script>