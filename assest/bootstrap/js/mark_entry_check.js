var baseUrl = $('#base_url').val();
$(document).on('change','#class',function(){
	c_id = $(this).val();
	$.ajax({
		type: 'GET',
		url: baseUrl+'Class_ctrl/getsection/'+c_id,
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
				$.each(response.result,function(key,value){	
					x = x + '<option value="'+value.id+'">'+ value.name +'</option>'; 
				});
				$('#section').html(x);
			}
		}
	});
});

$(document).on('click','#search',function(){
	var session = $('#session').val();
	var medium = $('#medium').val();
	var class_id = $('#class').val();
	var section = $('#section').val();
	var exam_type = $('#exam_type').val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Class_ctrl/rd_check_marks_entry',
		dataType: "json",
		data: {
			'session' : session,
			'medium' : medium,
			'class' : class_id,
			'section' : section,
			'exam_type' : exam_type
		},
		beforeSend: function(){
			$('#loader').modal('show');
		},
		success:  function (response) {
			$('#loader').modal('toggle');
			if(response.status == 200){
				console.log(response);
				var x = '<table class="table table-hover"><tbody><thead><th>S.No.</th><th>Subjects</th><th>Marks Entry</th></thead>';
				var i = 1;
				$.each(response.matchsub,function(key,value){
						x = x + '<tr class="green">'+
								 '<td>'+ value.name +'('+ value.subj_type +')</td><th><img src="'+baseUrl+'assest/images/right.png" /></th>'+
								'</tr>';
				});
				$.each(response.notmatchsub,function(key,value){
					x = x + '<tr class="green">'+
							 '<td>'+ value.name +'('+ value.subj_type +')</td><th><img src="'+baseUrl+'assest/images/wrong.png" /></th>'+
							'</tr>';
			});
				
				
				x = x + '</tbody></table>';
				$('#subject_list').html(x);
			}else{
				alert(response.msg);
			}
		}
	});
});
