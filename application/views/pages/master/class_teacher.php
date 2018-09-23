<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Class Teacher
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Class Teacher</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Class Teacher</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form method="POST" action="" role="form" class="form-horizontal">
				<div class="box-body">
					
					<div class="form-group">
	                  <label class="col-sm-3 control-label">Teacher</label>
	                  <div class="col-sm-9">
	                  	<select class="form-control" id="teacher">
	                  		<option value="0">Select Teacher</option>
	                  		<?php foreach($teachers as $teacher){?>
	                  			<option value="<?php echo $teacher['t_id'];?>"><?php echo $teacher['name']; ?></option>
	                  		<?php }?>
	                  	</select>
	                  	<div class="text-danger" id="teacher_err" style="display:none;"></div>
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label class="col-sm-3 control-label">Medium</label>
	                  <div class="col-sm-9">
	                  	<select class="form-control" id="medium" name="medium">
	                  		<option value="0">Select Medium</option>
	                  		<option value="Hindi">HINDI</option>
	                  		<option value="English">English</option>
	                  	</select>
	                  	<div class="text-danger" id="medium_err" style="display:none;"></div>
	                  </div>
	                </div>
					
	                <div class="form-group">
	                  <label class="col-sm-3 control-label">Classes</label>
	                  <div class="col-sm-9">
	                  	<select class="form-control" id="class">
	                  		<option value="0">Select Class</option>
	                  		<?php foreach($classes as $class){?>
	                  			<option value="<?php echo $class['c_id'];?>"><?php echo $class['name']; ?></option>
	                  		<?php }?>
	                  	</select>
	                  	<div class="text-danger" id="class_err" style="display:none;"></div>
	                  </div>
	                </div>
	                
	                <div class="form-group">
	                  <label class="col-sm-3 control-label">Sections</label>
	                  <div class="col-sm-9">
	                  	<select class="form-control" id="section">
	                  		<option value="0">Select Section</option>
	                  		<option value="1">A</option>
	                  		<option value="2">B</option>
	                  		<option value="3">C</option>
	                  		<option value="4">D</option>
	                  		<option value="5">E</option>
	                  		<option value="6">F</option>
	                  		<option value="7">G</option>
	                  		<option value="8">H</option>
	                  		<option value="9">I</option>
	                  		<option value="10">J</option>
	                  		<option value="11">K</option>
	                  		<option value="12">L</option>
	                  		<option value="13">M</option>
	                  	</select>
	                  	<div class="text-danger" id="section_err" style="display:none;"></div>
	                  </div>
	                </div>
				</div>
				<div class="box-footer">
					<button type="button" id="form-submit" class="btn pull-right btn-info">Submit</button>
					<button type="reset" id="form-cencel" class="btn btn-default pull-right btn-space">Cancel</button>
	            </div>
			</form>
		</div>
         
        </section>
        <section class="col-lg-6 connectedSortable">

          <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Class Teacher List</h3>
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
                  <th>Section</th>
                  <th>Medium</th>
                  <th>Teachers</th>
		<th>Edit/Delete</th>
                </tr>
                <tbody id="class_teacher_list"></tbody>
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
	 var class_id = $('#class').val();
	 var section = $('#section').val();
	 var t_id = $('#teacher').val();
	 var medium = $('#medium').val();
	 
	 $.ajax({
		type: 'POST',
		url: baseUrl+'Teacher_ctrl/class_teacher',
		dataType: "json",
		data: {
			't_id' : t_id,
			'class_id' : class_id,
			'section' : section,
			'medium' : medium 
		},
		beforeSend: function(){
			$('#loader').modal('show');
		},
		complete : function(){
			$('#loader').modal('toggle');
		},
		success:  function (response) {
			if(response.status == 200){
				$('#class_teacher_list').prepend('<tr><td>0</td>'+
										'<td>'+response.data[0].cname+'</td>'+
										'<td>'+response.data[0].sname+'</td>'+
										'<td>'+ medium +'</td>'+
										'<td>'+response.data[0].name+'</td>'+
										'<td>'+
											'<a type="button" class="teacher_edit btn btn-warning btn-flat" data-medium="'+ medium +'" data-id="'+ response.data[0].id +'"><i class="fa fa-pencil"></i></a>'+
											'<a type="button" href="#" class="teacher_delete btn btn-danger btn-flat" data-medium="'+ medium +'" data-id="'+ response.data[0].id +'"><i class="fa fa-trash"></i></a>'+
										'</td>'+
										'</tr>');
			}
			else if(response.status == 300){
				alert(response.msg);
				location.reload();
			}	
		}
	 });
 });
 
 $(document).ready(function(){
	 $.ajax({
		type: 'POST',
		url: baseUrl+'Teacher_ctrl/class_teachers',
		dataType: "json",
		data: {},
		beforeSend: function(){},
		complete : function(){},
		success:  function (response) {
			var x = '';
			var c = 1;
			$.each(response.data,function(key,value){
				x = x + '<tr>'+
							'<td>'+ c +'</td>'+
							'<td>'+ value.cname +'</td>'+
							'<td>'+ value.sname +'</td>'+
							'<td>'+ value.medium +'</td>'+
							'<td>'+ value.name +'</td>'+
							'<td>'+
							'<a href="#" class="teacher_edit btn btn-warning btn-flat" data-id="'+ value.t_id +'" data-medium="'+ value.medium +'"><i class="fa fa-pencil"></i></a>'+
							'<a href="#" class="teacher_delete btn btn-danger btn-flat" data-id="'+ value.t_id +'" data-medium="'+ value.medium +'"><i class="fa fa-trash"></i></a>'+
						'</td>'+
						'</tr>'; 
			c++;
			});
			$('#class_teacher_list').html(x);				
		}
	 });		
 });

 $(document).on('click','.teacher_delete',function(){
	 var t_id = $(this).data('id'); 
	 var that = this;
	 $.ajax({
		type: 'POST',
		url: baseUrl+'Teacher_ctrl/class_teacher_delete',
		dataType: "json",
		data: {
			't_id' : t_id
		},
		beforeSend: function(){},
		complete : function(){},
		success:  function (response){
			$(that).closest('tr').hide('slow');
		}
	 });
 });

 $(document).on('click','.teacher_edit',function(){
	 var t_id = $(this).data('id');
	 var medium = $(this).data('medium');
	 $.ajax({
			type: 'POST',
			url: baseUrl+'Teacher_ctrl/class_teacher_detail',
			dataType: "json",
			data: {
				't_id' : t_id,
				'medium' : medium 
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			complete : function(){
				$('#loader').modal('toggle');
			},
			success: function (response){
				if(response.status == 200){
					$('#class').val(response.data[0].class_id);
					$('#medium').val(medium);
					$('#teacher').val(response.data[0].teacher_id);
					$('#section').val(response.data[0].section);
					$('#form-submit').text('update');
				}
			}
	 });
 });

//  $(document).on('change','#class',function(){
// 	var c_id = $(this).val();
// 	$.ajax({
// 		type: 'POST',
// 		url: baseUrl+'Teacher_ctrl/class_detail',
// 		dataType: "json",
// 		data: {
// 			'c_id' : c_id
// 		},
// 		beforeSend: function(){
// 			$('#loader').modal('show');
// 		},
// 		complete : function(){
// 			$('#loader').modal('toggle');
// 		},
// 		success: function (response){
// 			if(response.status == 200){
// 				$('#teacher').val(response.data[0]['teacher_id']);
// 				$('#form-submit').text('Update');
// 			}
// 			else{
// 				$('#teacher').val(0);
// 				$('#form-submit').text('Submit');
// 			}
// 		}
// 	});		 
//  });

 $(document).on('change','#teacher',function(){
	 $('#teacher_err').css('display','none');
	 if($('#medium').val() == 0){
			return false;
		}
	 var t_id = $(this).val();
	 var medium = $('#medium').val();
		$.ajax({
			type: 'POST',
			url: baseUrl+'Teacher_ctrl/class_teacher_detail',
			dataType: "json",
			data: {
				't_id' : t_id,
				'medium' : medium
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			complete : function(){
				$('#loader').modal('toggle');
			},
			success: function (response){
				if(response.status == 200){
					$('#class').val(response.data[0].class_id);
					$('#section').val(response.data[0].section);
					$('#form-submit').text('Update');
				}
				else{
					$('#class').val(0);
					$('#section').val(0);
					$('#form-submit').text('Submit');
				}
			}
		}); 
 });

$(document).on('change','#medium',function(){
	if($('#teacher').val() == 0){
		$('#teacher_err').html('Please select teacher first.').css('display','block');
		return false;
	}
	
	var t_id = $('#teacher').val();
	var medium = $(this).val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Teacher_ctrl/class_teacher_detail',
		dataType: "json",
		data: {
			't_id' : t_id,
			'medium' : medium
		},
		beforeSend: function(){
			$('#loader').modal('show');
		},
		complete : function(){
			$('#loader').modal('toggle');
		},
		success: function (response){
			if(response.status == 200){
				$('#class').val(response.data[0].class_id);
				$('#section').val(response.data[0].section);
				$('#form-submit').text('Update');
			}
			else{
				$('#class').val(0);
				$('#section').val(0);
				$('#form-submit').text('Submit');
			}
		}
	}); 
});
 
 $('#form-cencel').click(function(){
	 $('#form-submit').text('Submit');
 });
  </script>
  