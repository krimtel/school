var baseUrl = $('#base_url').val();

$(document).ready(function(){
	teacher_subject_list();
});


function teacher_subject_list(){
	$.ajax({
		type: 'GET',
		url: baseUrl+'Teacher_ctrl/alloated_subjects',
		dataType: "json",
		data: {},
		beforeSend: function(){},
		success:  function (response) {
			console.log(response);
			var x = '';
			var c = 1;
			if(response.status == 200){
				$.each(response.data,function(key,value){
					x = x + '<tr>'+
	        			'<td style="width:5%;">'+ c +'</td>'+
	        			'<td style="width:10%;text-align:left;">'+ value.t_name +'</td>'+
	        			'<td style="width:7%;">'+ value.medium +'</td>'+
	        			'<td style="width:5%;">'+ value.c_name +' '+ value.sec_name +'</td>'+
	        			'<td style="width:5%;">'+ value.s_group +'</td>'+
	        			'<td style="width:30%;text-align:left;">'+ value.subjects +'</td>'+
			  			'<td style="width:10%;">'+
			  				'<a type="button" class="btn btn-warning btn-flat teacher_edit" data-medium="'+ value.medium +'" data-s_group="'+ value.s_group +'"  data-t_id="'+ value.teacher_id +'" data-c_id="'+ value.class_id +'" data-sec_id="'+ value.section_id +'" title="Edit" ><i class="fa fa-pencil"></i></a>'+
			  				'<a type="button" class="btn btn-danger btn-flat teacher_delete" data-alloc-id="'+ value.alloc_id +'" data-medium="'+ value.medium +'" data-s_group="'+ value.s_group +'" data-t_id="'+ value.teacher_id +'" data-c_id="'+ value.class_id +'" data-sec_id="'+ value.section_id +'" title="Delete"><i class="fa fa-trash-o"></i></a>'+
			  			'</td>'+
	      			'</tr>';
	      			c++;
				});
      			$('#teacher_subject_list').html(x);
			}
		}
	});
}

$(document).on('change','#class',function(){
	  var c_id = $(this).val();
	  var t_id = $('#teacher').val();
	  $.ajax({
			type: 'GET',
			url: baseUrl+'Class_ctrl/section_list/'+c_id,
			dataType: "json",
			data: {
				'c_id':c_id
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				var x = '<option value="0">Select Section</option>';
				$.each(response.data,function(key,value){
					x = x+ '<option value="'+ value.id +'">'+ value.name +'</option>';
				});
				$('#section').html(x);
			}
	  });
});

$(document).on('change','#class',function(){
	if($(this).val() > 13){
		$('#s_group_section').css('display','block');
	}
	else{
		$('#s_group_section').css('display','none');
	}
});

$(document).on('change','#section',function(){
	var sec_id = $(this).val();
	var t_id = $('#teacher').val();
	var c_id = $('#class').val();
	var medium = $('#medium').val();
	if(c_id > 13){
		var s_group = $('#s_group').val();
		$.ajax({
			type: 'POST',
			url: baseUrl+'Class_ctrl/class_subject_high_class',
			dataType: "json",
			data: {
				'c_id' : c_id,
				't_id' : t_id,
				'sec_id' : sec_id,
				'medium' : medium,
				's_group' : s_group
			},
			beforeSend: function(){
				$('#loader').modal({'show':true});	
			},
			complete: function(){
				$('#loader').modal('toggle');
			},
			success:  function (response) {
				console.log(response);
				var x = '';
				$.each(response.data.result,function(key,value){
					if(response.data.subjects.length > 0){
						
						subjects=[];
			            for (i = 0; i < response.data.subjects.length; ++i){
			            	subjects[i] =response.data.subjects[i].subject_id;
			            }
						
						if($.inArray(value.sub_id, subjects) !== -1){
							x = x + '<label class="col-sm-6">'+
					  		'<input type="checkbox" name="subject[]" class="flat-red pull-left subject_list" data-id="'+ value.sub_id +'" checked value="'+ value.sub_id +'"> &nbsp;'+
					  			'<span class="pull-left" style="margin-left:15px;">'+ value.name + '(' + value.subj_type + ')</span>' +
							'</label>';	
						}
						else{
							x = x + '<label class="col-sm-6">'+
					  		'<input type="checkbox" name="subject[]" class="flat-red pull-left subject_list" data-id="'+ value.sub_id +'" value="'+ value.sub_id +'"> &nbsp;'+
					  			'<span class="pull-left" style="margin-left:15px;">'+ value.name + '(' + value.subj_type + ')</span>' +
							'</label>';
						}
					}
					else{
						x = x + '<label class="col-sm-6">'+
				  		'<input type="checkbox" name="subject[]" class="flat-red pull-left subject_list" data-id="'+ value.sub_id +'" value="'+ value.sub_id +'"> &nbsp;'+
				  			'<span class="pull-left" style="margin-left:15px;">'+ value.name +'(' + value.subj_type + ')</span>' +
						'</label>';
					}
				});
				$('#class_subject').html(x);
			}
		});
	}
	else{
		$.ajax({
			type: 'POST',
			url: baseUrl+'Class_ctrl/class_subject',
			dataType: "json",
			data: {
				'c_id' : c_id,
				't_id' : t_id,
				'sec_id' : sec_id,
				'medium' : medium
			},
			beforeSend: function(){
				$('#loader').modal({'show':true});	
			},
			complete: function(){
				$('#loader').modal('toggle');
			},
			success:  function (response) {
				console.log(response);
				var x = '';
				$.each(response.data.result,function(key,value){
					if(response.data.subjects.length > 0){
						
						subjects=[];
			            for (i = 0; i < response.data.subjects.length; ++i){
			            	subjects[i] =response.data.subjects[i].subject_id;
			            }
						
						if($.inArray(value.sub_id, subjects) !== -1){
							x = x + '<label class="col-sm-6">'+
					  		'<input type="checkbox" name="subject[]" class="flat-red pull-left subject_list" data-id="'+ value.sub_id +'" checked value="'+ value.sub_id +'"> &nbsp;'+
					  			'<span class="pull-left" style="margin-left:15px;">'+ value.name + '(' + value.subj_type + ')</span>' +
							'</label>';	
						}
						else{
							x = x + '<label class="col-sm-6">'+
					  		'<input type="checkbox" name="subject[]" class="flat-red pull-left subject_list" data-id="'+ value.sub_id +'" value="'+ value.sub_id +'"> &nbsp;'+
					  			'<span class="pull-left" style="margin-left:15px;">'+ value.name + '(' + value.subj_type + ')</span>' +
							'</label>';
						}
					}
					else{
						x = x + '<label class="col-sm-6">'+
				  		'<input type="checkbox" name="subject[]" class="flat-red pull-left subject_list" data-id="'+ value.sub_id +'" value="'+ value.sub_id +'"> &nbsp;'+
				  			'<span class="pull-left" style="margin-left:15px;">'+ value.name +'(' + value.subj_type + ')</span>' +
						'</label>';
					}
				});
				$('#class_subject').html(x);
			}
		});	
	}
});

$(document).on('click','.teacher_edit',function(){
	var t_id = $(this).data('t_id');
	var c_id = $(this).data('c_id');
	var sec_id = $(this).data('sec_id');
	var medium = $(this).data('medium');
	if(c_id > 13){
		$('#s_group_section').css('display','block');
		$('#s_group').val($(this).data('s_group'));
	}
	else{
		$('#s_group_section').css('display','none');
	}
	$('#teacher').val(t_id);
	$('#class').val(c_id);
	$('#medium').val(medium);
	$("#class").trigger("change"); 
	
	setTimeout(function(){ 
		$('#section').val(sec_id);
		$("#section").trigger("change");
	},100);
});

$(document).on('click','.teacher_delete',function(){
	var t_id = $(this).data('t_id');
	var alloc_id = $(this).data('alloc-id');
	var medium = $(this).data('medium');
	var s_group = $(this).data('s_group');
	var sec_id = $(this).data('sec_id');
	var c_id = $(this).data('c_id');
	var that = this;
	if(confirm('Are you sure...')){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Teacher_ctrl/subject_delete',
			dataType: "json",
			data: {
				'teacher_id' : t_id,
				'alloc_id' : alloc_id,
				'medium' : medium,
				's_group' : s_group,
				'c_id' : c_id,
				'sec_id' : sec_id
			},
			beforeSend: function(){
				$('#loader').modal({'show':true});	
			},
			complete: function(){
				$('#loader').modal('toggle');
			},
			success:  function (response) {
				if(response.status == 200){
					$(that).closest('tr').hide('slow');
				}
				else{
					alert(response.msg);
				}
			}
		});
	}
});

$(document).on('change','#teacher_select',function(){
	var t_id = $(this).val();
	if(t_id == 0){
		teacher_subject_list();
	}
	else{
		$.ajax({
			type: 'POST',
			url: baseUrl+'Teacher_ctrl/teacher_alloated_subjects',
			dataType: "json",
			data: {
				'teacher_id' : t_id
			},
			beforeSend: function(){
				$('#loader').modal({'show':true});	
			},
			complete: function(){
				$('#loader').modal('toggle');
			},
			success:  function (response) {
				console.log(response);
				var x = '';
				var c = 1;
				if(response.status == 200){
					$.each(response.data,function(key,value){
						x = x + '<tr>'+
		        			'<td style="width:5%;">'+ c +'</td>'+
		        			'<td style="width:10%;text-align:left;">'+ value.t_name +'</td>'+
		        			'<td style="width:7%;">'+ value.medium +'</td>'+
		        			'<td style="width:5%;">'+ value.c_name +' '+ value.sec_name +'</td>'+
		        			'<td style="width:5%;">'+ value.s_group +'</td>'+
		        			'<td style="width:30%;text-align:left;">'+ value.subjects +'</td>'+
				  			'<td style="width:10%;">'+
				  				'<a type="button" class="btn btn-warning btn-flat teacher_edit" data-medium="'+ value.medium +'" data-s_group="'+ value.s_group +'" data-t_id="'+ value.teacher_id +'" data-c_id="'+ value.class_id +'" data-sec_id="'+ value.section_id +'" title="Edit" ><i class="fa fa-pencil"></i></a>'+
				  				'<a type="button" class="btn btn-danger btn-flat teacher_delete" data-alloc-id="'+ value.alloc_id +'" data-medium="'+ value.medium +'" data-s_group="'+ value.s_group +'" data-t_id="'+ value.teacher_id +'" data-c_id="'+ value.class_id +'" data-sec_id="'+ value.section_id +'"  title="Delete"><i class="fa fa-trash-o"></i></a>'+
				  			'</td>'+
		      			'</tr>';
		      			c++;
					});
	      			$('#teacher_subject_list').html(x);
				}
				else{
					alert(response.msg);
				}
			}
		});
	}
});


$(document).on('click','#form-submit',function(){
	$('#sub_alloc_form').ajaxForm({
	    dataType : 'json',
	    beforeSubmit:function(e){
	    	$('#loader').modal('show');
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
});