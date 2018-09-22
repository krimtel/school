var baseUrl = $('#base_url').val();

/*teacher abstract*/
$(document).on('click','#teachers_abstract_result',function(){
	var class_id = $('#class').val();
	var section_id = $('#section').val();
	var medium = $('#medium').val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Teacher_ctrl/teacher_abstract',
		dataType: "json",
		data: {
			'class' : class_id,
			'section' : section_id,
			'medium' : medium,
			'type' : 1
		},
		beforeSend: function(){},
		success:  function (response) {
			console.log(response);
			var win = window.open('', "myWindowName", "scrollbars=1,width=1200, height=600");
			var x = '<div class="class-wise-report-section-main">'+
						'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:40px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>';
						
						if(response.detail.school_id == 1){
							x  = x + '<div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"></td><td><b>Class:'+ response.detail[0].cname +' '+ response.detail[0].secname +'</b></td></tr></tbody></table></div>';
						}
						else{
							x  = x + '<div class="header-sec-f"><b class="sv">Sharda Vidyalaya, Rishali, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"></td><td><b>Class:'+ response.detail[0].cname +' '+ response.detail[0].secname +' </b></td></tr></tbody></table></div>';
						}
						
						x = x +'<div class="classwise-reportbox">'+
		/*----------------------------------------*/
						'<table class="table class-abstract-sec-box"> '+
							'<thead>'+
								'<tr>'+
									'<th>S. No.</th>'+
									'<th>Teacher Name</th>'+
									'<th>Sub.</th>'+
									'<th>Total Students</th>'+
									'<th>Total App.</th>'+
									'<th>Pass</th>'+
									'<th>Pass%</th>'+
									'<th>Ist Div.</th>'+
									'<th>Per(%)</th>'+
									'<th>IInd Div.</th>'+
									'<th>III rd Div.</th>'+
									'<th>Fail</th>'+
									'<th>Highest Marks/No. of Student</th>'+
									'<th>P.I.</th>'+
									'<th>Sign</th>'+
								'</tr>'+
							'</thead>'+
							'<tbody>';
							$.each(response.data,function(key,value){
								var c = key + 1;
								x = x +'<tr>'+
											'<td>'+ c +'</td>'+
											'<td>'+ value.teacher +'</td>'+
											'<td>'+ value.subject +'</td>'+
											'<td>'+ value.total_student +'</td>'+
											'<td>'+ value.total_student +'</td>'+
											'<td>'+ value.total_pass +'</td>'+
											'<td>'+ value.pass_percent +'%</td>'+
											'<td>'+ value.first_div +'</td>'+
											'<td>'+ value.first_percent +'%</td>'+
											'<td>'+ value.second_div +'</td>'+
											'<td>'+ value.third_div +'</td>'+
											'<td>'+ value.fail +'</td>'+
											'<td>'+ value.max +'/'+ value.total_student +'</td>'+
											'<td>'+ value.pi +'</td>'+
											'<td>&nbsp;</td>'+
										'</tr>';
							});
							x = x + '</tbody>'+
						'</table>'+	
		
						'<table class="table class-wise-footer-sign">'+
							'<tbody>'+
								'<tr>'+
									'<td><b>Class Teacher</b></td>'+
									'<td><b>I/C Incharge</b></td>'+
								'</tr>'+
							'</tbody>'+
						'</table>'+
					'</div>';
		
	x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
			'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
			'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">';
	
	 with(win.document){
	      open();
	      write(x);
		      close();
	    }
		}
	});
});

$(document).on('change','#class',function(){
	var c_id = $(this).val();
	$.ajax({
		type: 'GET',
		url: baseUrl+'Class_ctrl/section_list/'+c_id,
		dataType: "json",
		data: {
			'c_id':c_id
		},
		beforeSend: function(){},
		success:  function (response) {
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
