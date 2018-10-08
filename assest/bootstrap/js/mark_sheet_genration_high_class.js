var baseUrl = $('#base_url').val();

/*mid results ------------------------------------------------------*/
$(document).on('click','.mid',function(){	
	var s_id = $(this).data('id');
	var class_id = $('#class').val();
	var section = $('#section').val();
	var medium = $('#medium').val();
	var s_group = $('#s_group').val();
	var elective = $('#elective').val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Admin_ctrl/new_window_high_class',
		dataType: "json",
		data: {
			'sid' : s_id,
			'class_id' : class_id,
			'section' : section,
			'medium' : medium,
			's_group' : s_group,
			'elective' : elective
		},
		beforeSend: function(){},
		success:  function (response) {
			console.log(response);
			if(response.status == 200){
			var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
			var x = '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
					'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
					'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
					'<div class="modal-content p-head-sec">';
					if(response.data.student[0].school_id == 2){
						  x = x +'<img src="../../assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
				 		}
				 		if(response.data.student[0].school_id == 1){
							  x = x +'<img src="../../assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
					 		}
				 		x = x +	'<div class="modal-header p-header">'+
									'<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="../../assest/images/sharda/cbse-logo.png" /></div>'+
									'<div class="col-md-6 p-logo-sec text-center">';
										if(response.data.student[0].school_id == 2){
											x = x + '<div class="p-school-name-sec">'+
										'<h2>SHARDA VIDYALAYA</h2>'+
										'<p>Affiliated to CBSE, New Delhi No. 3330088 | School No.: 10243<br/>'+
											'English Medium Senior Secondary School, <br/>'+
											'Risali Sector, Bhilai, Chhattisgarh'+
										'</p></div>';
										}
										else{
										x = x + '<div class="p-school-name-sec">'+
										'<h2>SHAKUNTALA VIDYALAYA</h2>'+
										'<p>Affiliated to CBSE, New Delhi No. 3330091 | School No.: 10240<br/>'+
											'English & Hindi Medium Senior Secondary School, <br/>'+
											'Ram Nagar, Bhilai, Chhattisgarh'+
										'</p></div>';
										}
										x = x +'</div>'+
									'<div class="col-md-3 p-school-logo">';
										if(response.data.student[0].school_id ==2){
												x = x + '<img class="p-logo pull-right" src="../../assest/images/sharda/logo.png" />'; }
											else{ x = x + '<img class="p-logo pull-right" src="../../assest/images/shakuntala/logo.png" />'; }
											x = x +
									'</div>'+
							'</div>'+
			  			'<div class="modal-body p-student-body">'+
							'<div class="student-Information" >'+
								'<div class="col-md-10 p-student-info">'+
									'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
										'<div class="student-per-info" >'+
											'<div class="student-per-info1">'+	
												'<table class="table" >'+
													'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ response.data.student[0].name.toUpperCase() +'</b></td><tr>'+
													'<tr><td>Mother\'s Name</td><td>: '+ response.data.student[0].mother_name.toUpperCase() +'</td><tr>'+
													'<tr><td>Father\'s Name</td><td>: '+ response.data.student[0].father_name.toUpperCase() +'</td><tr>'+
													'<tr><td>Contact No.</td><td>: '+ response.data.student[0].contact_no +'</td></tr>'+
													'<tr><td>Aadhar No.</td><td>: '+ response.data.student[0].aadhar +'</td></tr>'+
													'<tr><td>Address</td><td class="address-sec">: '+ response.data.student[0].address +'</td></tr>'+
												'</table>'+
											'</div>'+
											'<div class="student-per-info2">'+
												'<table class="table">'+
													'<tr><td>Date of Birth</td><td>: '+ response.data.student[0].dob +'</td></tr>'+
													'<tr><td>Adm. No.</td><td>: '+ response.data.student[0].admission_no +'</td></tr>'+
													'<tr><td>Roll No.</td><td>: '+ response.data.student[0].roll_no +'</td></tr>'+
													'<tr><td>Class</td><td>: '+ response.data.student[0].cname +' &#39;'+ response.data.student[0].sec_name +'&#39;</td></tr>'+
												'</table>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div class="col-md-2 p-student-photo" >';
										if(response.data.student[0].school_id ==1){
											x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/shakuntala/'+response.data.student[0].photo+'" />';
										}
										else{
											x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/sharda/'+response.data.student[0].photo+'" />';
										}
										x = x + 
									'</div>'+
								'</div>'+				
								'<div class="results-information p-results-information-a col-md-8">'+
									'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastics Areas)</b></div>'+
									'<table class="table">'+
										'<thead>'+
											'<tr>'+
												'<th style="width:18%;">Subjects</th>'+
												'<th>Pre Mid</th>'+
												'<th>Out of 5 (Pre Mid)</th>'+
												
												'<th colspan="2">Mid</th>'+
												'<th>20% of Mid</th>'+
											'</tr>'+
										'</thead>'+
										'<tbody>'+
										'<tr>'+
												'<td align="center">&nbsp;</td>'+
												'<td align="center">MM 20</td>'+
												'<td align="center">&nbsp;</td>'+
												
												'<td align="center">MM</td>'+
												'<td align="center">Marks Obt.</td>'+
												'<td align="center">&nbsp;</td>'+												
											'</tr>';
											$.each(response.data.final_marks,function(key,value){
											x = x + '<tr>'+
														'<td>'+ value.sub_name +'</td>';
														if(value.pre_mark == 'A'){
															x = x + '<td align="center">Abst</td>'+
															'<td align="center">Abst</td>';
														}
														else{
															x = x +'<td align="center">'+ value.pre_mark +'</td>'+
															'<td align="center">'+ ( (parseInt(value.pre_mark)*parseInt(5)) / parseInt(20) ).toFixed(2) +'</td>';
														}
														x =x + '<td align="center">'+ value.max_sub_marks +'</td>';
														if(value.mid_mark == 'A'){
															x = x +'<td align="center">Abst</td>'+
															'<td align="center">Abst</td>';
														}
														else{
															x = x +'<td align="center">'+ value.mid_mark +'</td>'+
															'<td align="center">'+ ((((value.mid_mark * 100)/ value.max_sub_marks) * 20) / 100).toFixed(2) +'</td>';
														}
											 x = x +'</tr>';
											});
										x = x + '</tbody>'+
									'</table>'+
								'</div>'+
								'<div class="results-information p-results-information-c col-md-4">'+
									'<div class="academic-result-t"><b>Co-Scholastics Areas</b></div>'+
										'<table class="table">'+
											'<thead>'+
												'<tr><th>Subjects</th><th>Grade</th></tr>'+
											'</thead>'+
											'<tbody>';
											$.each(response.data.co_marks,function(key,value){
//												if(value.mark == 'A'){
//													x = x +'<tr><td>'+ value.sub_name +'</td><td align="center">Abst</td></tr>';
//												}
//												else{
													x = x +'<tr><td>'+ value.sub_name +'</td><td align="center">'+ value.mark +'</td></tr>';
//												}  
											});
											x =x + '</tbody>'+
										'</table>'+
								'</div>'+
						'</div>'+
						'<div class="modal-footer p-footer-sec">'+
							'<div class="col-md-2 p-place-date">'+
								'<b>Bhilai</b> '+ response.date +
							'</div>'+
							'<div class="col-md-2 col-md-offset-2 p-techer-sign">'+
								'<b>Class Teacher </b>'+
							'</div>'+
							'<div class="col-md-2 p-exam-ic">'+
								'<b>Exam I/C </b>'+
							'</div>'+
							'<div class="col-md-2 p-school-seal">'+
								'<b>Seal of the School</b>'+
							'</div>'+
							'<div class="col-md-2 text-center p-princi-sign">';
								if(response.data.student[0].school_id == 2){
									x = x + '<img class="principle-sign" src="../../assest/images/sharda/PrinSign.png"><br/>'+
								'(Gajindra Bhoi) <br><b>Principal</b>';
								}
								else{
									x = x + '<img class="principle-sign" src="../../assest/images/shakuntala/PrinSign.png"><br/>'+
								'(Vipin Kumar) <br><b>Principal</b>';
								}
								x = x + 
							'</div>'+
						'</div>'+
					'</div>';
			 with(win.document){
			      open();
			      write(x);
				      close();
			    }
			}
			else{
				alert('If marksheet not showing, Please check attendence.');
			}
		}
	});	
});

/*---------------------------end mid results-------------------------------------*/

/*--------------------fullmarks results---------------------------------------*/
$(document).on('click','.fullmarks',function(){
	
	var class_id = $('#class').val();
	var section = $('#section').val();
	var medium = $('#medium').val();
	var s_group = $('#s_group').val();
	var elective = $('#elective').val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Admin_ctrl/new_window_high_class_final_loop',
		dataType: "json",
		data: {
			'class_id' : class_id,
			'section' : section,
			'medium' : medium,
			's_group' : s_group,
			'elective' : elective,
			'type' : 'final'
		},
		beforeSend: function(){},
		success:  function (response) {
			console.log(response);
			var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
			var x = '';
			$.each(response.data,function(key,value){
			x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
					'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
					'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
					'<div class="modal-content p-head-sec-f eleventh-r ele-height">';
					if(value.student[0].school_id == 2){
				  		x = x +'<img src="../../assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:35%;left:34%;margin:0 auto; background-size:cover; background-position:center;">';
		 			}
		 			if(value.student[0].school_id == 1){
					  	x = x +'<img src="../../assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:35%;left:34%;margin:0 auto; background-size:cover; background-position:center;">';
			 		}
					x = x +
      				'<div class="modal-header p-header">'+
							'<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="../../assest/images/sharda/cbse-logo.png" /></div>'+
							'<div class="col-md-6 p-logo-sec text-center">';
								if(value.student[0].school_id == 2){
									x = x + '<div class="p-school-name-sec">'+
								'<h2>SHARDA VIDYALAYA</h2>'+
								'<p>Affiliated to CBSE, New Delhi No. 3330088 | School No.: 10243<br/>'+
									'English Medium Senior Secondary School, <br/>'+
									'Risali Sector, Bhilai, Chhattisgarh'+
								'</p></div>';
								}
								else{
								x = x + '<div class="p-school-name-sec">'+
								'<h2>SHAKUNTALA VIDYALAYA</h2>'+
								'<p>Affiliated to CBSE, New Delhi No. 3330091 | School No.: 10240<br/>'+
									'English & Hindi Medium Senior Secondary School, <br/>'+
									'Ram Nagar, Bhilai, Chhattisgarh'+
								'</p></div>';
								}
								x = x +'</div>'+
							'<div class="col-md-3 p-school-logo">';
								if(value.student[0].school_id == 2){
										x = x + '<img class="p-logo pull-right" src="../../assest/images/sharda/logo.png" />'; }
									else{ x = x + '<img class="p-logo pull-right" src="../../assest/images/shakuntala/logo.png" />'; }
									x = x +
							'</div>'+
					'</div>'+
					
		  			'<div class="modal-body p-student-body">'+
						'<div class="student-Information" >'+
							'<div class="text-center"><h5><b>Session Ending Academic Report Card: 2017-18</h5></div>'+
							'<div class="col-md-10 p-student-info">'+
								'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
								'<div class="student-per-info">'+
								'<div class="student-per-info1">'+	
									'<table class="table" >'+
										'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ value.student[0].name +'</b></td><tr>'+
										'<tr><td>Mother\'s Name</td><td>: '+ value.student[0].mother_name +'</td><tr>'+
										'<tr><td>Father\'s Name</td><td>: '+ value.student[0].father_name +'</td><tr>'+
										'<tr><td>Contact No.</td><td>: '+ value.student[0].contact_no +'</td></tr>'+
										'<tr><td>Aadhar No.</td><td>: '+ value.student[0].aadhar +'</td></tr>'+
										'<tr><td>Address</td><td class="address-sec">: '+ value.student[0].address +'</td></tr>'+
									'</table>'+
								'</div>'+
								'<div class="student-per-info2">'+
									'<table class="table">'+
										'<tr><td>Date of Birth</td><td>: '+ value.student[0].dob +'</td></tr>'+
										'<tr><td>Adm. No.</td><td>: '+ value.student[0].admission_no +'</td></tr>'+
										'<tr><td>Roll No.</td><td>: '+ value.student[0].roll_no +'</td></tr>'+
										'<tr><td>Class/Section</td><td>: '+ value.student[0].cname +' &#39;'+ value.student[0].sec_name +'&#39;</td></tr>'+
										'<tr><td></td><td></td></tr>'+
									'</table>'+
								'</div>'+
								'</div>'+
								'</div>'+
								'<div class="col-md-2 p-student-photo" >';
									if(value.student[0].school_id == 1){
										x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/shakuntala/'+value.student[0].admission_no +'.jpg" />';
									}
									else{
										x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/sharda/'+value.student[0].admission_no +'.jpg" />';
									}
									x = x + 
								'</div>'+
							'</div>'+
						'<div class="results-information p-results-information-f-a col-md-12">'+
							'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
							'<table class="table">'+
								'<thead>'+
									'<tr><th style="width:18%;text-align:center;" rowspan="4">Subjects</th><th rowspan="4">Post Mid<br/>(50 Marks)</th><th colspan="5">Session Ending Exam</th><th rowspan="4">Pre<br/>(Out of 5 (Pre Mid) )</th><th rowspan="4">Mid <br/>(Out of 20)</th><th rowspan="4">Post Mid <br/>(Out of 5)</th><th colspan="3">Session Ending Exam <br/>(Therory + Practical) <br/>(Out of 60)</th><th rowspan="4">Academic Attention<br/>(Out of 10)</th><th rowspan="4">Grand Total 100</th><th rowspan="4">Over all Grade</th></tr>'+
									'<tr><th colspan="2">Theory</th><th colspan="2">Practical</th><th>Total</th><th rowspan="3">Th</th><th rowspan="3">Pr</th><th rowspan="3">Total</th></tr>'+
									'<tr></tr>'+
									'<tr><th>MM</th><th>Marks Obt.</th><th>MM</th><th>Marks Obt.</th><th>&nbsp;</th></tr>'+
								'</thead>'+
								'<tbody>';
									$.each(value.final_marks,function(k,v){
										if(typeof response.data.back != 'undefined'){
											if(response.data.back.category == 'Detained'){
												if(v.extra){
													x = x + '<tr><td style="text-align:left;">'+ v.subject_name +'</td><td>'+ v.post_mid_marks +'</td><td>'+ v.final_thory_marks_max +'</td><td>'+ v.final_thory_marks_obtain +'*</td><td>'+ v.final_practical_marks_max +'</td><td>'+ v.final_practical_marks_obtail +'</td><td>'+ v.annual_total +'</td><td>'+ v.pre_5 +'</td><td>'+ v.mid_20 +'</td><td>'+ v.post_5 +'</td><td>'+ v.final_thory_60 +'</td><td>'+ v.final_practical_60 +'</td><td>'+ v.final_thory_practical +'</td><td>'+ v.academic_attention +'</td><td>'+ v.grand_total +'</td><td>'+ v.grade +'</td></tr>';
												}
												else{
													x = x + '<tr><td style="text-align:left;">'+ v.subject_name +'</td><td>'+ v.post_mid_marks +'</td><td>'+ v.final_thory_marks_max +'</td><td>'+ v.final_thory_marks_obtain + value.stars +'</td><td>'+ v.final_practical_marks_max +'</td><td>'+ v.final_practical_marks_obtail + '</td><td>'+ v.annual_total +'</td><td>'+ v.pre_5 +'</td><td>'+ v.mid_20 +'</td><td>'+ v.post_5 +'</td><td>'+ v.final_thory_60 +'</td><td>'+ v.final_practical_60 +'</td><td>'+ v.final_thory_practical +'</td><td>'+ v.academic_attention +'</td><td>'+ v.grand_total +'</td><td>'+ v.grade +'</td></tr>';
												}
											}
											else{
												x = x + '<tr><td style="text-align:left;">'+ v.subject_name +'</td><td>'+ v.post_mid_marks +'</td><td>'+ v.final_thory_marks_max +'</td><td>'+ parseInt(parseInt(v.final_thory_marks_obtain)+parseInt(v.extra)) + v.stars +'</td><td>'+ v.final_practical_marks_max +'</td><td>'+ v.final_practical_marks_obtail +'</td><td>'+ v.annual_total +'</td><td>'+ v.pre_5 +'</td><td>'+ v.mid_20 +'</td><td>'+ v.post_5 +'</td><td>'+ v.final_thory_60 +'</td><td>'+ v.final_practical_60 +'</td><td>'+ v.final_thory_practical +'</td><td>'+ v.academic_attention +'</td><td>'+ v.grand_total +'</td><td>'+ v.grade +'</td></tr>';
											}
										}
										else{
											x = x + '<tr><td style="text-align:left;">'+ v.subject_name +'</td><td>'+ v.post_mid_marks +'</td><td>'+ v.final_thory_marks_max +'</td><td>'+ parseInt(parseInt(v.final_thory_marks_obtain)+parseInt(v.extra)) + v.stars +'</td><td>'+ v.final_practical_marks_max +'</td><td>'+ v.final_practical_marks_obtail +'</td><td>'+ v.annual_total +'</td><td>'+ v.pre_5 +'</td><td>'+ v.mid_20 +'</td><td>'+ v.post_5 +'</td><td>'+ v.final_thory_60 +'</td><td>'+ v.final_practical_60 +'</td><td>'+ v.final_thory_practical +'</td><td>'+ v.academic_attention +'</td><td>'+ v.grand_total +'</td><td>'+ v.grade +'</td></tr>';
										}
									});								
								x = x + '</tbody>'+
							'</table>'+
						'</div>'+
						'<div class="results-information p-results-information-f-c col-md-6">'+
							'<div class="academic-result-t" style="background-color:rgba(241,241,241,0.2)!important;"><b>Co-Scholastic Areas:[on a 5 Point (A-E) Grading Scale]</b></div>'+
								'<table class="table">'+
									'<thead>'+
										'<tr><th style="text-align:center;">Subjects</th><th>Grade MT</th><th>Grade SE</th><th colspan="2">Over all Grade</th></tr>'+
									'</thead>'+
									'<tbody>';
									$.each(value.co_marks,function(k,v){
										if(v.sub_name == 'Work Education'){
											v.sub_name = 'General Study';
										}
										if(v.sub_name == 'Art Education'){
											v.sub_name = 'Art Education (SUPW)';
										}
										x = x +'<tr><td style="text-align:left;">'+ v.sub_name +'</td><td>'+ v.mark_mid +'</td><td>'+ v.mark_final +'</td><td>'+ v.total +'</td></tr>';
									});
									x = x +'</tbody>'+
								'</table>'+
						'</div>'+
						'<div class="results-information p-results-information-f-c col-md-6">'+
						'<div class="academic-result-t" style="background-color:rgba(241,241,241,0.2)!important;"><b>Result</b></div>'+
						'<table class="table" width="50%">'+
							'<tbody>';
							if(typeof value.back != 'undefined'){
								x = x + '<tr><td>Aggregate</td><td>'+ value.total_obtail +'/500</td><td>Percentage</td><td>_</td><td>Rank</td><td>_</td></tr>';
							}
							else{
								if(value.rank < 11){
									x = x + '<tr><td>Aggregate</td><td>'+ value.total_obtail +'/500</td><td>Percentage</td><td>'+ value.percent +'</td><td>Rank</td><td>'+ value.rank +'</td></tr>';
								}else{
									x = x + '<tr><td>Aggregate</td><td>'+ value.total_obtail +'/500</td><td>Percentage</td><td>'+ value.percent +'</td><td>Rank</td><td>_</td></tr>';
								}
							}
							var category = '';
							if(typeof value.back != 'undefined'){
								if(value.back.length > 0 && value.back.length < 3){
									var y = ''; 
									$.each(value.back,function(k,v){
										y = y + v + ',';
									});
									y = y.slice(0, -1);
									category = '<td><b>Compartment in</b></td><td colspan="4"><b>'+ y +'</b></td>';
								}
								else if(value.back.length > 2){
									category = '<td colspan="5"><b>Detained</b></td>';
								}
								else{
									category = '<td colspan="5"><b>Pass</b></td>';
								}
							}
							else{
								category = '<td colspan="5"><b>Pass</b></td>';
							}
							x = x + '<tr><td>Final Result</td>'+ category +'</tr>'+
							'</tbody>'+
						'</table>'+
					'</div>'+
					'<div class="results-information p-results-information-f-c col-md-12" style="margin-top:15px;display:none;">'+	
						'<table class="table">'+
							'<thead>'+
								'<tr><th colspan="3" style="text-align:left;">Compartment Result:</th></tr>'+
								'<tr><th>S.No.</th><th>Subject</th><th>Mark OBT</th></tr>'+
							'</thead>'+
							'<tbody>'+
							'<tr><td>1.</td><td>Hindi</td><td>25</td></tr>'+
							'</tbody>'+
						'</table>'+
					'</div>'+
						
						'<div class="modal-footer p-footer-sec-f" style="padding-left:0px;margin-top:-25px;">'+
							'<div class="col-md-2 p-place-date">'+
								'Place: <b>Bhilai </b><br>Date: '+ response.date +
							'</div>'+
							'<div class="col-md-2 col-md-offset-2 p-techer-sign">'+
								'&nbsp;<br><b>Signature of Class Teacher </b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 p-school-seal">'+
								'&nbsp;<br><b>Seal of the School</b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;">';
							
								if(value.student[0].school_id == 2){
									x = x + '<img class="principle-sign" src="../../assest/images/sharda/PrinSign.png"><br/>'+
								'(Gajindra Bhoi) <br><b>Principal</b>';
								}
								else{
									x = x + '<img class="principle-sign" src="../../assest/images/shakuntala/PrinSign.png"><br/>'+
								'(Vipin Kumar) <br><b>Principal</b>';
								}
								x = x + 
							'</div>'+
							'<div class="instc-sec" style="margin-bottom:0px;padding:0;">'+
								'<h4>Instructions</h4><p><b>Grading scale for scholastic areas:</b> Grades are awarded on a 8- point grading scale as follows -</p>'+
								'<div class="col-md-4 col-md-offset-4 range-table" style="margin-left:25%;width:50%;">'+
									'<table style="font-size:11px;" class="table table-bordered"><thead><tr><th style="width:40%;">Marks Range</th><th style="width:60%;">Grade</th></tr></thead>'+
										'<tbody><tr><td>91-100</td><td>A 1</td></tr>'+
										'<tr><td>81-90</td><td>A 2</td></tr>'+
										'<tr><td>71-80</td><td>B 1</td></tr>'+
										'<tr><td>61-70</td><td>B 2</td></tr>'+
										'<tr><td>51-60</td><td>C 1</td></tr>'+
										'<tr><td>41-50</td><td>C 2</td></tr>'+
										'<tr><td>33-40</td><td>D</td></tr>'+
										'<tr><td>32 & Below</td><td>E (Failed)</td></tr>'+
										'</tbody></table>'+
								'</div>'+
							'</div>'+
'<div style="float:left;text-align:left;"><span style="float:left;width:40px;"><b>Note:</b></span><span style="float:left;">* Compartment</br>** Promoted</span></div>'+						'</div>'+
					'</div></div>';
			});
			with(win.document){
				open();
				write(x);
				close();
			}
		}
	});
	
});


/*-------------------------------end fullmarks results--------------------------------------*/

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
	
	if(c_id == 14 || c_id == 15){
		$('#subject_group').show();
		$('#elective_section').show();
	}
	else{
		$('#subject_group').hide();
		$('#elective_section').hide();
	}

	if(c_id == 12 || c_id == 13){
		$('#fit_section').show();
	}
	else{
		$('#fit_section').hide();
	}
	
});

$(document).on('click','#form_submit',function(){
	var medium = $('#medium').val();
	var classes = $('#class').val();
	var section = $('#section').val();
	var s_group = $('#s_group').val();
	var elective = $('#elective').val();
	
	var form_valid = true;
	if(medium == 0){
		$('#medium_err').html('Please select Medium.').css('display','block');
		form_valid = false;
	}
	else{
		$('#medium_err').css('display','none');
	}
	if(classes == 0){
		$('#class_err').html('Please select Class.').css('display','block');
		form_valid = false;
	}
	else{
		$('#class_err').css('display','none');
	}
	if(section == 0){
		$('#section_err').html('Please select Section.').css('display','block');
		form_valid = false;
	}
	else{
		$('#section_err').css('display','none');
	}
	
	if($('#session').val() == 0){
		$('#session_err').html('Please select Session.').css('display','block');
		form_valid = false;
	}
	else{
		$('#session_err').css('display','none');
	}

	if(form_valid){
		$.ajax({
		type: 'POST',
			url: baseUrl+'Student_ctrl/student_list_marksheet',
			dataType: "json",
			data: {
				'medium':medium,
				'class':classes,
				'section':section,
				's_group' : s_group,
				'elective' : elective
			},
			beforeSend: function(){
				$('#loader').modal('show');
			},
			success:  function (response) {
				$('#loader').modal('toggle');
				console.log(response);
				if(response.status == 200){
					var x = '';
					var c = 1;
					$.each(response.data,function(key,value){
					x = x + '<tr>'+
								'<td>'+ c +'</td>'+
								'<td>'+ value.name +'</td>'+
								'<td>'+ value.roll_no +'</td>'+
								'<td>'+ value.admission_no +'</td>'+
								'<td><a class="mid btn btn-info btn-md" data-id="'+ value.s_id +'">Print</a></td>'+
								'<td><a class="final_result btn btn-info btn-md" data-id="'+ value.s_id +'">Print</a></td>';
							'</tr>';  
					c++;
					});
					$('#student_list').html(x);
				}
				else{
					alert('No Record Found.');
					$('#student_list').html('No Record Found.');
				}
	  		}
		});
	}
});

$(document).on('keyup','#search',function(){
	var medium = $('#medium').val();
	var classes = $('#class').val();
	var section = $('#section').val();
	var session = $('#session').val();
	var s_group = $('#s_group').val();
	var elective = $('#elective').val();
	
	var text = $(this).val();
	
	$.ajax({
		type: 'POST',
			url: baseUrl+'Student_ctrl/student_list',
			dataType: "json",
			data: {
				'medium':medium,
				'class':classes,
				'section':section,
				'text' : text,
				'session': session,
				'fit' : fit,
				's_group' : s_group,
				'elective' : elective
			},
			beforeSend: function(){},
			success:  function (response) {
				console.log(response);
				var x = '';
				var c = 1;
				$.each(response.data,function(key,value){
				x = x + '<tr>'+
							'<td>'+ c +'</td>'+
							'<td>'+ value.name +'</td>'+
							'<td>'+ value.roll_no +'</td>'+
							'<td>'+ value.admission_no +'</td>'+
							'<td><a class="mid btn btn-info btn-md" data-id="'+ value.s_id +'">Print</a></td>'+
			                '<td><a class="btn btn-info btn-md" data-toggle="modal" data-target="#FinalResult">Print</a></td>'+
			                '<td><a class="btn btn-info btn-md" data-toggle="modal" data-target="#ClassWiseResult">ClassWiseResult</a></td>'+
						'</tr>';  
				c++;
				});
				$('#student_list').html(x);
			}
	});
});
/*-------------------------------------mid-term multiple results ---------------------------------------------*/
$(document).on('click','#mid_term_marksheet',function(){
	var medium = $('#medium').val();
	var classes = $('#class').val();
	var section = $('#section').val();
	var s_group = $('#s_group').val();

	var form_valid = true;
	if(medium == 0){
		$('#medium_err').html('Please select Medium.').css('display','block');
		form_valid = false;
	}
	else{
		$('#medium_err').css('display','none');
	}
	
	if(s_group == 0){
		$('#s_group_err').html('Please select Subject Group.').css('display','block');
		form_valid = false;
	}
	else{
		$('#s_group_err').css('display','none');
	}
	
	if(classes == 0){
		$('#class_err').html('Please select Class.').css('display','block');
		form_valid = false;
	}
	else{
		$('#class_err').css('display','none');
	}
	if(section == 0){
		$('#section_err').html('Please select Section.').css('display','block');
		form_valid = false;
	}
	else{
		$('#section_err').css('display','none');
	}

	if(form_valid){
		$.ajax({
		type: 'POST',
			url: baseUrl+'Student_ctrl/mid_result_high_class',
			dataType: "json",
			data: {
				'medium':medium,
				'class':classes,
				'section':section,
				's_group': s_group
			},
			beforeSend: function(){},
			success:  function (response) {
				console.log(response); 
				var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x = '';
				$.each(response.data,function(key,value){
					x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
					'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
					'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
					'<div class="modal-content p-head-sec">';
					if(value.student.school_id == 2){
						  x = x +'<img src="../../assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
				 		}
				 		if(value.student.school_id == 1){
							  x = x +'<img src="../../assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
					 		}
				 		x = x +	'<div class="modal-header p-header">'+
									'<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="../../assest/images/sharda/cbse-logo.png" /></div>'+
									'<div class="col-md-6 p-logo-sec text-center">';
										if(value.student.school_id == 2){
											x = x + '<div class="p-school-name-sec">'+
										'<h2>SHARDA VIDYALAYA</h2>'+
										'<p>Affiliated to CBSE, New Delhi No. 3330088 | School No.: 10243<br/>'+
											'English Medium Senior Secondary School, <br/>'+
											'Risali Sector, Bhilai, Chhattisgarh'+
										'</p></div>';
										}
										else{
										x = x + '<div class="p-school-name-sec">'+
										'<h2>SHAKUNTALA VIDYALAYA</h2>'+
										'<p>Affiliated to CBSE, New Delhi No. 3330091 | School No.: 10240<br/>'+
											'English & Hindi Medium Senior Secondary School, <br/>'+
											'Ram Nagar, Bhilai, Chhattisgarh'+
										'</p></div>';
										}
										x = x +'</div>'+
									'<div class="col-md-3 p-school-logo">';
										if(value.student.school_id ==2){
												x = x + '<img class="p-logo pull-right" src="../../assest/images/sharda/logo.png" />'; }
											else{ x = x + '<img class="p-logo pull-right" src="../../assest/images/shakuntala/logo.png" />'; }
											x = x +
									'</div>'+
							'</div>'+
			  			'<div class="modal-body p-student-body">'+
							'<div class="student-Information" >'+
								'<div class="col-md-10 p-student-info">'+
									'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
										'<div class="student-per-info" >'+
											'<div class="student-per-info1">'+	
												'<table class="table" >'+
													'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ value.student.name.toUpperCase() +'</b></td><tr>'+
													'<tr><td>Mother\'s Name</td><td>: '+ value.student.mother_name.toUpperCase() +'</td><tr>'+
													'<tr><td>Father\'s Name</td><td>: '+ value.student.father_name.toUpperCase() +'</td><tr>'+
													'<tr><td>Contact No.</td><td>: '+ value.student.contact_no +'</td></tr>'+
													'<tr><td>Aadhar No.</td><td>: '+ value.student.aadhar +'</td></tr>'+
													'<tr><td>Address</td><td class="address-sec">: '+ value.student.address +'</td></tr>'+
												'</table>'+
											'</div>'+
											'<div class="student-per-info2">'+
												'<table class="table">'+
													'<tr><td>Date of Birth</td><td>: '+ value.student.dob +'</td></tr>'+
													'<tr><td>Adm. No.</td><td>: '+ value.student.admission_no +'</td></tr>'+
													'<tr><td>Roll No.</td><td>: '+ value.student.roll_no +'</td></tr>'+
													'<tr><td>Class</td><td>: '+ value.student.cname +' &#39;'+ value.student.sec_name +'&#39;</td></tr>'+
													
												'</table>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div class="col-md-2 p-student-photo" >';
										if(value.student.school_id ==1){
											x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/shakuntala/'+value.student.photo+'" />';
										}
										else{
											x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/sharda/'+value.student.photo+'" />';
										}
										x = x + 
									'</div>'+
								'</div>'+				
								'<div class="results-information p-results-information-a col-md-8">'+
									'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastics Areas)</b></div>'+
									'<table class="table">'+
										'<thead>'+
											'<tr>'+
												'<th style="width:18%;">Subjects</th>'+
												'<th>Pre Mid</th>'+
												'<th>Out of 5 (Pre Mid)</th>'+
												'<th colspan="2">Mid</th>'+
												'<th>20% of Mid</th>'+
											'</tr>'+
										'</thead>'+
										'<tbody>'+
										'<tr>'+
											'<td align="center">&nbsp;</td>'+
											'<td align="center">MM 20</td>'+
											'<td align="center">&nbsp;</td>'+
											
											'<td align="center">MM</td>'+
											'<td align="center">Marks Obt.</td>'+
											'<td align="center">&nbsp;</td>'+												
										'</tr>';
											$.each(value.final_marks,function(k,v){
											x = x + '<tr>'+
														'<td>'+ v.sub_name +'</td>';
														if(v.pre_mark == 'A'){
															x = x + '<td align="center">Abst</td>'+
															'<td align="center">Abst</td>';
														}
														else{
															x = x + '<td align="center">'+ v.pre_mark +'</td>'+
															'<td align="center">'+ ( (parseInt(v.pre_mark)*parseInt(5)) / parseInt(20) ).toFixed(2) +'</td>';
															 
														}
														x = x +'<td align="center">'+ v.max_sub_marks +'</td>';
														if(v.mid_mark == 'A'){
															x = x +'<td align="center">Abst</td>'+
															'<td align="center">Abst</td>';
														}
														else{
															x = x +'<td align="center">'+ v.mid_mark +'</td>'+
															'<td align="center">'+ ((((v.mid_mark * 100)/ v.max_sub_marks) * 20) / 100).toFixed(2) +'</td>';
														}
													x =x + '</tr>';
											});
										x = x + '</tbody>'+
									'</table>'+
								'</div>'+
								'<div class="results-information p-results-information-c col-md-4">'+
									'<div class="academic-result-t"><b>Co-Scholastics Areas</b></div>'+
										'<table class="table">'+
											'<thead>'+
												'<tr><th>Subjects</th><th>Grade</th></tr>'+
											'</thead>'+
											'<tbody>';
											$.each(value.co_marks,function(k,v){
//												if(v.mark == 'A'){
//													x = x +'<tr><td>'+ v.sub_name +'</td><td align="center">Abst</td></tr>';
//												}
//												else{
													x = x +'<tr><td>'+ v.sub_name +'</td><td align="center">'+ v.mark +'</td></tr>';
												//}  
											});
											x =x + '</tbody>'+
										'</table>'+
								'</div>'+
						'</div>'+
						'<div class="modal-footer p-footer-sec">'+
							'<div class="col-md-2 p-place-date">'+
								'<b>Bhilai</b> '+ response.date +
							'</div>'+
							'<div class="col-md-2 col-md-offset-2 p-techer-sign">'+
								'<b>Class Teacher </b>'+
							'</div>'+
							'<div class="col-md-1 p-exam-ic">'+
								'<b>Exam I/C </b>'+
							'</div>'+
							'<div class="col-md-2 p-school-seal">'+
								'<b>Seal of the School</b>'+
							'</div>'+
							'<div class="col-md-2 text-center p-princi-sign">';
								if(value.student.school_id == 2){
									x = x + '<img class="principle-sign" src="../../assest/images/sharda/PrinSign.png"><br/>'+
								'(Gajindra Bhoi) <br><b>Principal</b>';
								}
								else{
									x = x + '<img class="principle-sign" src="../../assest/images/shakuntala/PrinSign.png"><br/>'+
								'(Vipin Kumar) <br><b>Principal</b>';
								}
								x = x + 
							'</div>'+
						'</div>'+
					'</div>';					
					});
				 with(win.document){
				      open();
				      write(x);
					      close();
				    }
	  		}
		});
	}
});


$(document).on('click','.final_result',function(){
	var s_id = $(this).data('id');
	var class_id = $('#class').val();
	var section = $('#section').val();
	var medium = $('#medium').val();
	var s_group = $('#s_group').val();
	var elective = $('#elective').val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Admin_ctrl/new_window_high_class_final',
		dataType: "json",
		data: {
			'sid' : s_id,
			'class_id' : class_id,
			'section' : section,
			'medium' : medium,
			's_group' : s_group,
			'elective' : elective,
			'type' : 'final'
		},
		beforeSend: function(){},
		success:  function (response) {
			console.log(response);
			var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
			var x = '';
			$.each(response.data,function(key,value){
			x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
					'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
					'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
					'<div class="modal-content p-head-sec-f eleventh-r">';
					if(value.student[0].school_id == 2){
				  		x = x +'<img src="../../assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:35%;left:34%;margin:0 auto; background-size:cover; background-position:center;">';
		 			}
		 			if(value.student[0].school_id == 1){
					  	x = x +'<img src="../../assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:35%;left:34%;margin:0 auto; background-size:cover; background-position:center;">';
			 		}
					x = x +
      				'<div class="modal-header p-header">'+
							'<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="../../assest/images/sharda/cbse-logo.png" /></div>'+
							'<div class="col-md-6 p-logo-sec text-center">';
								if(value.student[0].school_id == 2){
									x = x + '<div class="p-school-name-sec">'+
								'<h2>SHARDA VIDYALAYA</h2>'+
								'<p>Affiliated to CBSE, New Delhi No. 3330088 | School No.: 10243<br/>'+
									'English Medium Senior Secondary School, <br/>'+
									'Risali Sector, Bhilai, Chhattisgarh'+
								'</p></div>';
								}
								else{
								x = x + '<div class="p-school-name-sec">'+
								'<h2>SHAKUNTALA VIDYALAYA</h2>'+
								'<p>Affiliated to CBSE, New Delhi No. 3330091 | School No.: 10240<br/>'+
									'English & Hindi Medium Senior Secondary School, <br/>'+
									'Ram Nagar, Bhilai, Chhattisgarh'+
								'</p></div>';
								}
								x = x +'</div>'+
							'<div class="col-md-3 p-school-logo">';
								if(value.student[0].school_id == 2){
										x = x + '<img class="p-logo pull-right" src="../../assest/images/sharda/logo.png" />'; }
									else{ x = x + '<img class="p-logo pull-right" src="../../assest/images/shakuntala/logo.png" />'; }
									x = x +
							'</div>'+
					'</div>'+
					
		  			'<div class="modal-body p-student-body">'+
						'<div class="student-Information" >'+
							'<div class="text-center"><h5><b>Session Ending Academic Report Card: 2017-18</h5></div>'+
							'<div class="col-md-10 p-student-info">'+
								'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
								'<div class="student-per-info">'+
								'<div class="student-per-info1">'+	
									'<table class="table" >'+
										'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ value.student[0].name +'</b></td><tr>'+
										'<tr><td>Mother\'s Name</td><td>: '+ value.student[0].mother_name +'</td><tr>'+
										'<tr><td>Father\'s Name</td><td>: '+ value.student[0].father_name +'</td><tr>'+
										'<tr><td>Contact No.</td><td>: '+ value.student[0].contact_no +'</td></tr>'+
										'<tr><td>Aadhar No.</td><td>: '+ value.student[0].aadhar +'</td></tr>'+
										'<tr><td>Address</td><td class="address-sec">: '+ value.student[0].address +'</td></tr>'+
									'</table>'+
								'</div>'+
								'<div class="student-per-info2">'+
									'<table class="table">'+
										'<tr><td>Date of Birth</td><td>: '+ value.student[0].dob +'</td></tr>'+
										'<tr><td>Adm. No.</td><td>: '+ value.student[0].admission_no +'</td></tr>'+
										'<tr><td>Roll No.</td><td>: '+ value.student[0].roll_no +'</td></tr>'+
										'<tr><td>Class/Section</td><td>: '+ value.student[0].cname +' &#39;'+ value.student[0].sec_name +'&#39;</td></tr>'+
										
									'</table>'+
								'</div>'+
							'</div>'+
								'</div>'+
								'<div class="col-md-2 p-student-photo" >';
									if(value.student[0].school_id == 1){
										x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/shakuntala/'+ value.student[0].photo +'" />';
									}
									else{
										x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/sharda/'+ value.student[0].photo +'" />';
									}
									x = x + 
								'</div>'+
							'</div>'+
						'<div class="results-information p-results-information-f-a col-md-12">'+
							'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
							'<table class="table">'+
								'<thead>'+
									'<tr><th style="width:18%;text-align:center;" rowspan="4">Subjects</th><th rowspan="4">Post Mid<br/>(50 Marks)</th><th colspan="5">Session Ending Exam</th><th rowspan="4">Pre<br/>(Out of 5)</th><th rowspan="4">Mid <br/>(Out of 20)</th><th rowspan="4">Post Mid <br/>(Out of 5)</th><th colspan="3">Session Ending Exam <br/>(Therory + Practical) <br/>(Out of 60)</th><th rowspan="4">Academic Attention<br/>(Out of 10)</th><th rowspan="4">Grand Total 100</th><th rowspan="4">Over all Grade</th></tr>'+
									'<tr><th colspan="2">Theory</th><th colspan="2">Practical</th><th>Total</th><th rowspan="3">Th</th><th rowspan="3">Pr</th><th rowspan="3">Total</th></tr>'+
									'<tr></tr>'+
									'<tr><th>MM</th><th>Marks Obt.</th><th>MM</th><th>Marks Obt.</th><th>&nbsp;</th></tr>'+
								'</thead>'+
								'<tbody>';
									$.each(value.final_marks,function(k,v){
										if(typeof response.data.back != 'undefined'){
											if(response.data.back.category == 'Detained'){
												if(v.extra){
													x = x + '<tr><td style="text-align:left;">'+ v.subject_name +'</td><td>'+ v.post_mid_marks +'</td><td>'+ v.final_thory_marks_max +'</td><td>'+ v.final_thory_marks_obtain +'*</td><td>'+ v.final_practical_marks_max +'</td><td>'+ v.final_practical_marks_obtail +'</td><td>'+ v.annual_total +'</td><td>'+ v.pre_5 +'</td><td>'+ v.mid_20 +'</td><td>'+ v.post_5 +'</td><td>'+ v.final_thory_60 +'</td><td>'+ v.final_practical_60 +'</td><td>'+ v.final_thory_practical +'</td><td>'+ v.academic_attention +'</td><td>'+ v.grand_total +'</td><td>'+ v.grade +'</td></tr>';
												}
												else{
													x = x + '<tr><td style="text-align:left;">'+ v.subject_name +'</td><td>'+ v.post_mid_marks +'</td><td>'+ v.final_thory_marks_max +'</td><td>'+ v.final_thory_marks_obtain + value.stars +'</td><td>'+ v.final_practical_marks_max +'</td><td>'+ v.final_practical_marks_obtail + '</td><td>'+ v.annual_total +'</td><td>'+ v.pre_5 +'</td><td>'+ v.mid_20 +'</td><td>'+ v.post_5 +'</td><td>'+ v.final_thory_60 +'</td><td>'+ v.final_practical_60 +'</td><td>'+ v.final_thory_practical +'</td><td>'+ v.academic_attention +'</td><td>'+ v.grand_total +'</td><td>'+ v.grade +'</td></tr>';
												}
											}
											else{
												x = x + '<tr><td style="text-align:left;">'+ v.subject_name +'</td><td>'+ v.post_mid_marks +'</td><td>'+ v.final_thory_marks_max +'</td><td>'+ parseInt(parseInt(v.final_thory_marks_obtain)+parseInt(v.extra)) + v.stars +'</td><td>'+ v.final_practical_marks_max +'</td><td>'+ v.final_practical_marks_obtail +'</td><td>'+ v.annual_total +'</td><td>'+ v.pre_5 +'</td><td>'+ v.mid_20 +'</td><td>'+ v.post_5 +'</td><td>'+ v.final_thory_60 +'</td><td>'+ v.final_practical_60 +'</td><td>'+ v.final_thory_practical +'</td><td>'+ v.academic_attention +'</td><td>'+ v.grand_total +'</td><td>'+ v.grade +'</td></tr>';
											}
										}
										else{
											x = x + '<tr><td style="text-align:left;">'+ v.subject_name +'</td><td>'+ v.post_mid_marks +'</td><td>'+ v.final_thory_marks_max +'</td><td>'+ parseInt(parseInt(v.final_thory_marks_obtain)+parseInt(v.extra)) + v.stars +'</td><td>'+ v.final_practical_marks_max +'</td><td>'+ v.final_practical_marks_obtail +'</td><td>'+ v.annual_total +'</td><td>'+ v.pre_5 +'</td><td>'+ v.mid_20 +'</td><td>'+ v.post_5 +'</td><td>'+ v.final_thory_60 +'</td><td>'+ v.final_practical_60 +'</td><td>'+ v.final_thory_practical +'</td><td>'+ v.academic_attention +'</td><td>'+ v.grand_total +'</td><td>'+ v.grade +'</td></tr>';
										}
									});								
								x = x + '</tbody>'+
							'</table>'+
						'</div>'+
						'<div class="results-information p-results-information-f-c col-md-6">'+
							'<div class="academic-result-t" style="background-color:rgba(241,241,241,0.2)!important;"><b>Co-Scholastic Areas:[on a 5 Point (A-E) Grading Scale]</b></div>'+
								'<table class="table">'+
									'<thead>'+
										'<tr><th style="text-align:center;">Subjects</th><th>Grade MT</th><th>Grade SE</th><th colspan="2">Over all Grade</th></tr>'+
									'</thead>'+
									'<tbody>';
									$.each(value.co_marks,function(k,v){
										if(v.sub_name == 'Work Education'){
											v.sub_name = 'General Study';
										}
										if(v.sub_name == 'Art Education'){
											v.sub_name = 'Art Education (SUPW)';
										}
										x = x +'<tr><td style="text-align:left;">'+ v.sub_name +'</td><td>'+ v.mark_mid +'</td><td>'+ v.mark_final +'</td><td>'+ v.total +'</td></tr>';
									});
									x = x +'</tbody>'+
								'</table>'+
						'</div>'+
						'<div class="results-information p-results-information-f-c col-md-6">'+
						'<div class="academic-result-t" style="background-color:rgba(241,241,241,0.2)!important;"><b>Result</b></div>'+
						'<table class="table" width="50%">'+
							'<tbody>';
							if(typeof value.back != 'undefined'){
								if(value.back.length > 0){
									x = x +'<tr><td>Aggregate</td><td>'+ value.total_obtail +'/500</td><td>Percentage</td><td>_</td><td>Rank</td><td>&nbsp;</td></tr>';
								}
								else{
									x = x +'<tr><td>Aggregate</td><td>'+ value.total_obtail +'/500</td><td>Percentage</td><td>'+ value.percent +'</td><td>Rank</td><td>&nbsp;</td></tr>';
								}
							}
							var category = '';
							if(typeof value.back != 'undefined'){
								if(value.back.length > 2){
									category = '<td colspan="5"><b>Detained</b></td>';
								}
								else if(value.back.length > 0 && value.back.length < 3){
									var y = '';
									$.each(value.back,function(k,v){
										y = y + v.subject_name + ',';
									});
									y = y.slice(0, -1);
									category = '<td><b>Compartment in</b></td><td colspan="4">'+ y +'</td>';
								}
								
								else if(value.back.length == 0){
									category = '<td colspan="5"><b>Pass</b></td>';
								}
								
							}
							x = x + '<tr><td>Final Result</td>'+ category +'</tr>'+
							'</tbody>'+
						'</table>'+
					'</div>'+
					'<div class="results-information p-results-information-f-c col-md-12" style="margin-top:15px;display:none;">'+	
						'<table class="table">'+
							'<thead>'+
								'<tr><th colspan="3" style="text-align:left;">Compartment Result:</th></tr>'+
								'<tr><th>S.No.</th><th>Subject</th><th>Mark OBT</th></tr>'+
							'</thead>'+
							'<tbody>'+
							'<tr><td>1.</td><td>Hindi</td><td>25</td></tr>'+
							'</tbody>'+
						'</table>'+
					'</div>'+
						
						'<div class="modal-footer p-footer-sec-f" style="padding-left:0px;margin-top:-25px;">'+
							'<div class="col-md-2 p-place-date">'+
								'Place: <b>Bhilai </b><br>Date: '+ response.date +
							'</div>'+
							'<div class="col-md-2 col-md-offset-2 p-techer-sign">'+
								'&nbsp;<br><b>Signature of Class Teacher </b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 p-school-seal">'+
								'&nbsp;<br><b>Seal of the School</b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;">';
							
								if(value.student[0].school_id == 2){
									x = x + '<img class="principle-sign" src="../../assest/images/sharda/PrinSign.png"><br/>'+
								'(Gajindra Bhoi) <br><b>Principal</b>';
								}
								else{
									x = x + '<img class="principle-sign" src="../../assest/images/shakuntala/PrinSign.png"><br/>'+
								'(Vipin Kumar) <br><b>Principal</b>';
								}
								x = x + 
							'</div>'+
							'<div class="instc-sec" style="margin-bottom:0px;padding:0;">'+
								'<h4>Instructions</h4><p><b>Grading scale for scholastic areas:</b> Grades are awarded on a 8- point grading scale as follows -</p>'+
								'<div class="col-md-4 col-md-offset-4 range-table" style="margin-left:25%;width:50%;">'+
									'<table style="font-size:11px;" class="table table-bordered"><thead><tr><th style="width:40%;">Marks Range</th><th style="width:60%;">Grade</th></tr></thead>'+
										'<tbody><tr><td>91-100</td><td>A 1</td></tr>'+
										'<tr><td>81-90</td><td>A 2</td></tr>'+
										'<tr><td>71-80</td><td>B 1</td></tr>'+
										'<tr><td>61-70</td><td>B 2</td></tr>'+
										'<tr><td>51-60</td><td>C 1</td></tr>'+
										'<tr><td>41-50</td><td>C 2</td></tr>'+
										'<tr><td>33-40</td><td>D</td></tr>'+
										'<tr><td>32 & Below</td><td>E (Failed)</td></tr>'+
										'</tbody></table>'+
								'</div>'+
							'</div>'+
							'<div style="float:left;text-align:left;"><span style="float:left;width:40px;"><b>Note:</b></span><span style="float:left;">* Compartment</br>** Promoted</span></div>'+
						'</div>'+
					'</div>';
			});
			with(win.document){
				open();
				write(x);
				close();
			}
		}
	});		
});