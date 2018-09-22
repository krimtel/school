var baseUrl = $('#base_url').val();
$(document).on('change','#class',function(){
	c_id = $(this).val();
	$.ajax({
		type: 'GET',
		url: baseUrl+'Class_ctrl/section_list_class_teacher/'+c_id,
		dataType: "json",
		data: {
			'c_id':c_id
		},
		beforeSend: function(){
			$('#loader').modal('show');
		},
		success:  function (response) {
			$('#loader').modal('toggle');
			if(response.status == 200){
				var x = '<option value="0" selected>Select Section</option>';
				$.each(response.data,function(key,value){	
					x = x + '<option value="'+value.id+'">'+ value.name +'</option>'; 
				});
				$('#section').html(x);
			}
		}
	});
});

$(document).on('click','#search',function(){
	var medium = $('#medium').val();
	var class_id = $('#class').val();
	var section = $('#section').val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Class_ctrl/class_subject_mark_check',
		dataType: "json",
		data: {
			'medium' : medium,
			'class' : class_id,
			'section' : section
		},
		beforeSend: function(){
			$('#loader').modal('show');
		},
		success:  function (response) {
			$('#loader').modal('toggle');
			if(response.status == 200){
				console.log(response);
				var x = '<table class="table table-hover"><tbody><thead><th>S.No.</th><th>Subjects</th><th>Marks Entry</th></thead>';
				$.each(response.data,function(key,value){
					if(value.entered){
						x = x + '<tr class="green">'+
									'<td>01.</td><td>'+ value.sub_name +'('+ value.type +')</td><th><img src="'+baseUrl+'assest/images/right.png" /></th>'+
								'</tr>';
					}
					else{
						x = x + '<tr class="red">'+
									'<td>01.</td><td>'+ value.sub_name +'('+ value.type +')</td><td><img src="'+baseUrl+'assest/images/wrong.png" /></td>'+
								'</tr>';
					}
				});
				x = x + '</tbody></table>';
				$('#subject_list').html(x);
			}
		}
	});
});
