var baseUrl = $('#base_url').val();
/*mid results ------------------------------------------------------*/
$(document).on('click','.mid',function(){
	var s_id = $(this).data('id');
	var class_id = $('#class').val();
	var section = $('#section').val();
	var medium = $('#medium').val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Admin_ctrl/new_window',
		dataType: "json",
		data: {
			'sid' : s_id,
			'class_id' : class_id,
			'section' : section,
			'medium' : medium
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
							'<div class="student-Information 123" >'+
								'<div class="col-md-10 p-student-info">'+
										'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
										'<div class="student-per-info" >'+
											'<div class="student-per-info1">'+	
												'<table class="table" >'+
													'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ response.data.student[0].name +'</b></td><tr>'+
													'<tr><td>Mother\'s Name</td><td>: '+ response.data.student[0].mother_name +'</td><tr>'+
													'<tr><td>Father\'s Name</td><td>: '+ response.data.student[0].father_name +'</td><tr>'+
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
													'<tr><td>Attnd. Mid.Term</td><td>: '+ response.data.student[0].presentday +'/'+ response.data.student[0].working_days +'</td></tr>'+							
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
									'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
									'<table class="table">'+
										'<thead>'+
											'<tr><th style="width:18%;">Subjects</th><th>Pre Mid MM:10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Half Yearly: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>'+
										'</thead>'+
										'<tbody>';
											$.each(response.data.marks,function(key,value){
												var flag = 0;
												var pre_marks = 0;
												var n_marks = 0;
												var su_marks = 0;
												var mi_marks = 0;
											x = x + '<tr>'+
														'<td>'+ value.name +'</td>';
														if(value.pre_mark == 'A'){
															flag = 1;
															x = x +'<td align="center">Abst</td>';
															pre_marks = 0;
														}
														else{
															pre_marks = ((value.pre_mark/ 50) * 10).toFixed(2);
															x = x +'<td align="center">'+ ((value.pre_mark/ 50) * 10).toFixed(2) +'</td>';
														}
														if(value.notebook_mark == 'Abst'){
															flag = 1;
															x =x +'<td align="center">'+ value.notebook_mark +'</td>';
															n_marks = 0;
														}
														else{
															n_marks = value.notebook_mark;
															x = x +'<td align="center">'+ value.notebook_mark +'</td>';
														}
														if(value.subj_enrich == 'Abst'){
															flag = 1;
															x = x + '<td align="center">'+ value.subj_enrich +'</td>';
															su_marks = 0;
														}
														else{
															su_marks = value.subj_enrich;
															x = x + '<td align="center">'+ value.subj_enrich +'</td>';
														}
														
														mi_marks = value.mid_mark;
														if(value.mid_mark == 'Abst'){
															flag = 1;
															x = x + '<td align="center">Abst</td>';
															mi_marks = 0;
														}
														else{
															if(value.sub_id == 13){
//																var fit =  ((value.mid_mark / 80) * 100);
//																mi_marks = ((40 * fit)/100).toFixed(2);
																mi_marks = value.mid_mark * 2;
															}
															else{
																mi_marks = value.mid_mark;
															}
															x = x + '<td align"center">'+ mi_marks +'</td>';
														}
														x = x+ '<td align="center">'+ (parseFloat(parseFloat(pre_marks) + parseInt(n_marks)+parseInt(su_marks)+parseInt(mi_marks))).toFixed(2)  +'</td>';
														var number = parseFloat(parseFloat(pre_marks) + parseInt(n_marks)+parseInt(su_marks)+parseInt(mi_marks));
														
														
														if(number > 90){
													          x = x +'<td>A1</td>';
														}
														else if(number > 80){
															x = x +'<td>A2</td>';
														}
														else if(number > 70){
															x = x +'<td>B1</td>';
														}
														else if(number > 60){
															x = x +'<td>B2</td>';
														}
														
			                                            else if(number > 50){
															x = x +'<td>C1</td>';
														}
			                                            else if(number > 40){
															x = x +'<td>C2</td>';
														}
			                                            else if(number > 32){
															x = x +'<td>D</td>';
														}
			                                            else if(number > 0){
															x = x +'<td>E</td>';
														}
			                                            else{
			                                            	x = x +'<td>-</td>';
			                                            }
													x = x + '</tr>';
//											x = x + '<tr>'+
//														'<td>'+ value.subject +'</td>'+
//														'<td align="center">'+ value.pre +'</td>'+
//														'<td align="center">'+ (value.pre)* 10 / 100 +'</td>'+
//														'<td align="center">'+ (value.pre)* 10 / 100 +'</td>'+
//														'<td align="center">'+ value.mid +'</td>'+
//														'<td align="center">'+ (value.mid)* 20 / 80 +'</td>'+
//													'</tr>';
											});
										x = x + '</tbody>'+
									'</table>'+
								'</div>'+
								'<div class="results-information p-results-information-c col-md-4">'+
									'<div class="academic-result-t"><b>Co-Scholastic Areas</b></div>'+
										'<table class="table">'+
											'<thead>'+
												'<tr><th>Subjects</th><th>Grade</th></tr>'+
											'</thead>'+
											'<tbody>';
											$.each(response.data.co_marks,function(key,value){
												if(value.mark){
													x = x +'<tr><td>'+ value.name +'</td><td align="center">'+ value.mark +'</td></tr>';
												}
												else{
													x = x +'<tr><td>'+ value.name +'</td><td align="center">_</td></tr>';
												}
											});
											x =x + '</tbody>'+
										'</table>'+
								'</div>'+
						'</div>'+
						'<div class="modal-footer p-footer-sec">'+
							'<div class="col-md-2 p-place-date">'+
								'<b>Bhilai </b>'+ response.date +
							'</div>'+
							'<div class="col-md-2 col-md-offset-4 p-techer-sign">'+
								'<b>Class Teacher </b>'+
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
$(document).on('click','.final-result',function(){
	var s_id = $(this).data('id');
	var class_id = $('#class').val();
	var section = $('#section').val();
	var medium = $('#medium').val();
	$.ajax({
		type: 'POST',
		url: baseUrl+'Admin_ctrl/compart_new_window',
		dataType: "json",
		data: {
			'sid' : s_id,
			'class_id' : class_id,
			'section' : section,
			'medium' : medium,
			'type' : 'final'
		},
		beforeSend: function(){},
		success:  function (response) {
			if(class_id == 12 || class_id == 13){
				response_render(response);
				return false;
			}
			console.log(response);
			var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
			var x = '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
					'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
					'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
					'<div class="modal-content p-head-sec-f">';
					if(response.data.student[0].school_id == 2){
				  x = x +'<img src="../../assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
		 		}
		 		if(response.data.student[0].school_id == 1){
					  x = x +'<img src="../../assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
			 		}
		      				x = x +'<div class="modal-header p-header">'+
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
										if(response.data.student[0].school_id == 2){
												x = x + '<img class="p-logo pull-right" src="../../assest/images/sharda/logo.png" />'; }
											else{ x = x + '<img class="p-logo pull-right" src="../../assest/images/shakuntala/logo.png" />'; }
											x = x +
									'</div>'+
							'</div>'+
			  			'<div class="modal-body p-student-body">'+
							'<div class="student-Information" >'+
								'<div class="text-center"><h5><b>Academic Report Card: 2017-18<br></b></h5></div>'+
								'<div class="col-md-10 p-student-info">'+
										'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
										'<div class="student-per-info">'+
												'<div class="student-per-info1">'+	
													'<table class="table" >'+
													'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ response.data.student[0].name +'</b></td><tr>'+
													'<tr><td>Mother\'s Name</td><td>: '+ response.data.student[0].mother_name +'</td><tr>'+
													'<tr><td>Father\'s Name</td><td>: '+ response.data.student[0].father_name +'</td><tr>'+
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
														'<tr><td>Class/Section</td><td>: '+ response.data.student[0].cname +' &#39;'+ response.data.student[0].sec_name +'&#39;</td></tr>'+
														'<tr><td>Attnd. Mid.Term</td><td>: '+ response.data.student[0].attend +'/'+ response.data.student[0].mid_days +'</td></tr>'+
														'<tr><td>Attnd. Session End</td><td>: '+ parseInt(parseInt(response.data.student[0].presentday) - parseInt(response.data.student[0].attend)) +'/'+ parseInt(parseInt(response.data.student[0].working_days) - parseInt(response.data.student[0].mid_days)) +'</td></tr>'+
													'</table>'+
												'</div>'+
											'</div>'+
										'</div>'+
										'<div class="col-md-2 p-student-photo">';
											if(response.data.student[0].school_id ==1){
												x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/shakuntala/'+response.data.student[0].photo+'" />';
											}
											else{
												x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/sharda/'+response.data.student[0].photo+'" />';
											}
											x = x + 
										'</div>'+
									'</div>'+				
									'<div class="results-information p-results-information-f-a col-md-12">'+
										'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
										'<table class="table fullmark-term1">'+
											'<thead>'+
												'<tr><th style="border-bottom:1px solid #b1afaf;" colspan="7">Term 1</th></tr>'+
												'<tr><th style="width:21%;">Subjects</th><th>Pre Test: 10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Half Yearly: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>'+
											'</thead>'+
										'<tbody>';
										$.each(response.data.marks,function(key,value){
										x = x + '<tr>'+
													'<td style="text-align:left;">'+ value.name +'</td>'+
													'<td style="text-align:center;">'+ value.pre_mark +'</td>'+
													'<td align="center">'+ value.notebook_mark +'</td>'+
													'<td align="center">'+ value.subj_enrich +'</td>'+
													'<td align="center">'+ value.mid_mark +'</td>'+
													'<td align="center">'+ value.term_1_total +'</td>'+
													'<td align="center">'+ value.term_1_grade +'</td>'+
												    '</tr>';
										});
											
										x = x + '</tbody>'+
									'</table>';
								'</div>'+
								'<div class="results-information p-results-information-f-c col-md-6" style="display:none;">'+
									'<div class="academic-result-t"><b>Co-Scholastic Areas:Term [on a 3-point (A-C) grading scale]</b></div>'+
										'<table class="table hidden">'+
											'<thead>'+
												'<tr><th>Subjects</th><th>Grade</th></tr>'+
											'</thead>'+
											'<tbody>';
											$.each(response.data.co_marks,function(key,value){
												if(value.term_1_mark){
													x = x +'<tr><td align="center"></td><td align="center"></td></tr>';
												}
												else{
													x = x +'<tr><td align="center"></td><td align="center">_</td></tr>';
												}
											});
											x =x + '</tbody>'+
										'</table>'+
								
								
								'<table class="table fullmark-term2">'+
									'<thead>'+
										'<tr><th style="border-bottom:1px solid #b1afaf;" colspan="6">Term 2</th></tr>'+
										'<tr><th>Post Test: 10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Session Ending Exam: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>'+
									'</thead>'+
									'<tbody>';
									$.each(response.data.marks,function(key,value){
									x = x + '<tr>'+
											'<td align="center">'+ value.post_mark +'</td>'+
											'<td align="center">'+ value.final_notebook_mark +'</td>'+
											'<td align="center">'+ value.final_subj_enrich +'</td>'+
											'<td align="center">'+ value.final_mark +'</td>'+
											'<td align="center">'+ value.term_2_total +'</td>'+
											'<td align="center">'+ value.term_2_grade +'</td>'+
											'</tr>';
									});
									x = x + '</tbody>'+
								'</table>'+
							'</div>'+
							'<div class="results-information p-results-information-f-c col-md-12" style="margin-top:8px;margin-bottom:6px;">'+	
								'<div class="academic-result-t" style="background-color:rgba(241,241,241,0.0)!important;"><b>Co-Scholastic Areas</b></div>'+
									'<table style="width:50%;float:left;" class="table">'+
										'<thead>'+
											'<tr><th>Term 1 [on a 3-point (A-C) grading scale]</th><th>Grade</th></tr>'+
										'</thead>'+
										'<tbody>';
											$.each(response.data.co_marks,function(key,value){
												if(value.term_1_mark){
													x = x + '<tr><td style="text-align:left;">'+ value.name +'</td><td align="center">'+ value.term_1_mark +'</td></tr>';
												}
												else{
													x = x + '<tr><td style="text-align:left;">'+ value.name +'</td><td align="center">-</td></tr>';
												}
											});
										x = x +'</tbody>'+
									'</table>'+
							
							
							'<table style="width:50%;float:left;" class="table">'+
								'<thead>'+
									'<tr><th>Term 2 [on a 3-point (A-C) grading scale]</th><th>Grade</th></tr>'+
								'</thead>'+
								'<tbody>';
									
									$.each(response.data.co_marks,function(key,value){
										if(value.term_2_mark){
											x = x + '<tr><td style="text-align:left;">'+ value.name +'</td><td align="center">'+ value.term_2_mark +'</td></tr>';
										}
										else{
											x = x + '<tr><td style="text-align:left;">'+ value.name +'</td><td align="center">-</td></tr>';
										}
									});
								x = x +'</tbody>'+
							'</table>'+
					'</div>'+
					'<div class="results-information p-results-information-f-c col-md-12" style="margin-top:0px;margin-bottom:6px;">';
					if(response.r_status){
						x = x +'<div class="academic-result-t" style="background-color:rgba(241,241,241,0.0)!important;"><b>Compartment Result : DETAINED </b></div>';	
					}
					else{
						x = x +'<div class="academic-result-t" style="background-color:rgba(241,241,241,0.0)!important;"><b>Compartment Result : PASS</b></div>';
					}
					x = x + '<table style="width:50%;float:left;" class="table">'+
					'<thead>'+
						'<tr><th>S.No.</th><th>Subject</th><th>MM</th><th>Mark OBT.</th></tr>'+
					'</thead>'+
					'<tbody>';
							var cc = 1;
							$.each(response.compart,function(ck,cv){
								console.log(cv);
								x = x +'<tr><td>'+ cc +'.</td><td>'+ cv.s_name +'</td><td>'+ cv.mm +'</td><td>'+ cv.obtain +'</td></tr>';
								cc++;
							});
						x = x +'</tbody>'+
						'</table>'+
					
						'<table style="width:50%;margin-top:0px;" class="table teacher-remark">'+
						'<thead><tr><th colspan="2" style="text-align:left;">Result</th></tr></thead><tbody>';
						if(response.r_status){
							if(typeof(response.data.back) != "undefined" && response.data.back !== null){
								if((response.data.back.length) > 0){
									var c = 1;
									x = x + '<tr><td style="text-align:left;">Promoted to Class:</td><td><b>_</b></td></tr> <tr><td style="text-align:left;">Needs improvement :</td><td>';
									$.each(response.data.back,function(bkey,bvalue){
										x = x + '('+ c +'). <b>'+ bvalue.name +'</b> '; 
										c++; 
									});
									x = x +  '</td></tr>';
								}
							}
							else{
								if(response.data.student[0].class_id == 3){
									x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>I</b></td></tr>';				
								}
								if(response.data.student[0].class_id == 4){
									x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>II</b></td></tr>';				
								}
								if(response.data.student[0].class_id == 5){
									x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>III</b></td></tr>';				
								}
								if(response.data.student[0].class_id == 6){
									x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>IV</b></td></tr>';				
								}
								if(response.data.student[0].class_id == 7){
									x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>V</b></td></tr>';				
								}
								if(response.data.student[0].class_id == 8){
									x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>VI</b></td></tr>';				
								}
								if(response.data.student[0].class_id == 9){
									x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>VII</b></td></tr>';				
								}
								if(response.data.student[0].class_id == 10){
									x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>VIII</b></td></tr>';				
								}
								if(response.data.student[0].class_id == 11){
									x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>IX</b></td></tr>';				
								}
							}
						}
						else{
							if(response.data.student[0].class_id == 3){
								x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>I</b></td></tr>';				
							}
							if(response.data.student[0].class_id == 4){
								x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>II</b></td></tr>';				
							}
							if(response.data.student[0].class_id == 5){
								x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>III</b></td></tr>';				
							}
							if(response.data.student[0].class_id == 6){
								x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>IV</b></td></tr>';				
							}
							if(response.data.student[0].class_id == 7){
								x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>V</b></td></tr>';				
							}
							if(response.data.student[0].class_id == 8){
								x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>VI</b></td></tr>';				
							}
							if(response.data.student[0].class_id == 9){
								x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>VII</b></td></tr>';				
							}
							if(response.data.student[0].class_id == 10){
								x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>VIII</b></td></tr>';				
							}
							if(response.data.student[0].class_id == 11){
								x = x + '<tr><td style="text-align:left;">Promoted to Class: </td><td><b>IX</b></td></tr>';				
							}
						}
x = x + '</tbody></table></div>'+
						
						'<div class="modal-footer p-footer-sec-f" style="padding-left:0px;margin-top:0px;">'+
							'<div class="col-md-2 p-place-date" style="padding-left:5px;">'+
								'Place: <b>Bhilai </b><br>Date: '+ response.date +
							'</div>'+
							'<div class="col-md-2 col-md-offset-2 p-techer-sign">'+
								'&nbsp;<br><b>Signature of Class Teacher </b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 p-school-seal">'+
								'&nbsp;<br><b>Seal of the School</b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;">';
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
							'<div class="instc-sec">'+
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
'<tr><td>32 & Below</td><td>E (Needs improvement)</td></tr>'+
'</tbody></table>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>';
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
		url: baseUrl+'Class_ctrl/section_list_class_teacher/'+c_id,
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
	var fit = $('#fit').val();
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
			url: baseUrl+'Student_ctrl/compart_student_list_marksheet',
			dataType: "json",
			data: {
				'medium':medium,
				'class':classes,
				'section':section,
				'fit' : fit,
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
								'<td  style="text-align:left;">'+ value.name +'</td>'+
								'<td>'+ value.roll_no +'</td>'+
								'<td>'+ value.admission_no +'</td>'+
								'<td><a class="mid btn btn-info btn-md" data-id="'+ value.s_id +'">Print</a></td>'+
				                '<td><a class="final-result btn btn-info btn-md" data-id="'+ value.s_id +'">Print</a></td>';
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
	var fit = $('#fit').val();
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
	var fit = $('#fit').val();
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

	if(form_valid){
		$.ajax({
		type: 'POST',
			url: baseUrl+'Student_ctrl/mid_result_class',
			dataType: "json",
			data: {
				'medium':medium,
				'class':classes,
				'section':section,
				'fit' : fit
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
						'<div class="modal-content p-head-sec" style="height:493px;">';
				 		if(value.student.school_id == 2){
						  x = x +'<img src="../../assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
				 		}
				 		if(value.student.school_id == 1){
							  x = x +'<img src="../../assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
					 		}
			      			x = x + '<div class="modal-header p-header">'+
										'<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="../../assest/images/sharda/cbse-logo.png" /></div>'+
										'<div class="col-md-6 p-logo-sec text-center">';
											if(value.student.school_id == 2){
												x = x + '<div class="p-school-name-sec">'+
											'<h2>SHARDA VIDYALAYA</h2>'+
											'<p>Affiliated to CBSE, New Delhi No. 3330088 | School No.: 10243<br/>'+
												'English Medium Senior Secondary School, Risali Sector, Bhilai, Chhattisgarh'+
											'</p></div>';
											}
											else{
											x = x + '<div class="p-school-name-sec">'+
											'<h2>SHAKUNTALA VIDYALAYA</h2>'+
											'<p>Affiliated to CBSE, New Delhi No. 3330091 | School No.: 10240<br/>'+
												'English & Hindi Medium Senior Secondary School, Ram Nagar, Bhilai, Chhattisgarh'+
											'</p></div>';
											}
											x = x +'</div>'+
										'<div class="col-md-3 p-school-logo f-right">';
											if(value.student.school_id == 2){
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
														'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ value.student.name +'</b></td><tr>'+
														'<tr><td>Mother\'s Name</td><td>: '+ value.student.mother_name +'</td><tr>'+
														'<tr><td>Father\'s Name</td><td>: '+ value.student.father_name +'</td><tr>'+
														'<tr><td>Contact No.</td><td>: '+ value.student.contact_no +'</td></tr>'+
														'<tr><td>Aadhar No.</td><td>: '+ value.student.aadhar +'</td></tr>'+
														'<tr><td>Address</td><td class="address-sec" style="height:28px;">: '+ value.student.address +'</td></tr>'+
													'</table>'+
												'</div>'+
												'<div class="student-per-info2">'+
													'<table class="table">'+
														'<tr><td>Date of Birth</td><td>: '+ value.student.dob +'</td></tr>'+
														'<tr><td>Adm. No.</td><td>: '+ value.student.admission_no +'</td></tr>'+
														'<tr><td>Roll No.</td><td>: '+ value.student.roll_no +'</td></tr>'+
														'<tr><td>Class</td><td>: '+ value.student.cname +' &#39;'+ value.student.sec_name +'&#39;</td></tr>'+
														'<tr><td>Attnd. Mid.Term</td><td>: '+ value.student.presentday +'/'+ value.student.working_days +'</td></tr>'+							
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
										'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
										'<table class="table">'+
											'<thead>'+
												'<tr><th style="width:18%;">Subjects</th><th>Pre Mid MM:10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Half Yearly: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>'+
											'</thead>'+
											'<tbody>';
												$.each(value.marks,function(key,v){
													var flag = 0;
													var pre_marks = 0;
													var n_marks = 0;
													var su_marks = 0;
													var mi_marks = 0;
												x = x + '<tr>'+
															'<td style="background: rgba(241, 241, 241, 0.4 )">'+ v.name +'</td>';
															if(v.pre_mark == 'A'){
																flag = 1;
																x = x + '<td style="background: rgba(241, 241, 241, 0.4 )" align="center">Abst</td>';
																pre_marks = 0;
															}
															else{
																pre_marks = (v.pre_mark/50)*10;
																x = x + '<td style="background: rgba(241, 241, 241, 0.4 )" align="center">'+ ((v.pre_mark/50)*10).toFixed(2) +'</td>';
															}
															if(v.notebook_mark == 'Abst'){
																flag = 1;
																n_marks = 0;
															}
															else{
																n_marks = v.notebook_mark;
																x = x + '<td style="background: rgba(241, 241, 241, 0.4 )" align="center">'+ v.notebook_mark +'</td>';
															}
															if(v.subj_enrich == 'Abst'){
																flag = 1;
																su_marks = 0;
															}
															else{
																su_marks = v.subj_enrich;
																x = x + '<td style="background: rgba(241, 241, 241, 0.4 )" align="center">'+ v.subj_enrich +'</td>';
															}
															if(v.mid_mark == 'Abst'){
																flag = 1;
																x = x + '<td style="background: rgba(241, 241, 241, 0.4 )" align="center">Abst</td>';
																mi_marks = 0;
															}
															else{
																if(v.sub_id == 13){
//																	var fit =  ((v.mid_mark / 80) * 100);
//																	mi_marks = ((40 * fit)/100).toFixed(2);
																	mi_marks = v.mid_mark * 2;
																}
																else{
																	mi_marks = v.mid_mark;
																}
																x = x +'<td style="background: rgba(241, 241, 241, 0.4 )" align="center">'+ mi_marks +'</td>';
															}
															
															x = x +'<td style="background: rgba(241, 241, 241, 0.4 )" align="center">'+ (parseFloat(parseFloat(pre_marks) + parseInt(n_marks)+parseInt(su_marks)+parseInt(mi_marks))).toFixed(2)  +'</td>';
															var number = parseFloat(parseFloat(pre_marks) + parseInt(n_marks)+parseInt(su_marks)+parseInt(mi_marks));
															
										    if(number > 90){
										          x = x +'<td style="background: rgba(241, 241, 241, 0.4 )">A1</td>';
											}
											else if(number > 80){
												x = x +'<td style="background: rgba(241, 241, 241, 0.4 )">A2</td>';
											}
											else if(number > 70){
												x = x +'<td style="background: rgba(241, 241, 241, 0.4 )">B1</td>';
											}
											else if(number > 60){
												x = x +'<td style="background: rgba(241, 241, 241, 0.4 )">B2</td>';
											}
																						
                                            else if(number > 50){
												x = x +'<td style="background: rgba(241, 241, 241, 0.4 )">C1</td>';
											}
                                            else if(number > 40){
												x = x +'<td style="background: rgba(241, 241, 241, 0.4 )">C2</td>';
											}
                                            else if(number > 32){
												x = x +'<td style="background: rgba(241, 241, 241, 0.4 )">D</td>';
											}		
                                            else if(number > 0){
										        x = x +'<td style="background: rgba(241, 241, 241, 0.4 )">E</td>';
                                            }
                                            else{
                                            	x = x +'<td style="background: rgba(241, 241, 241, 0.4 )">-</td>';
                                            }
											x = x + '</tr>';
										});
											x = x + '</tbody>'+
										'</table>'+
									'</div>'+
									'<div class="results-information p-results-information-c col-md-4">'+
										'<div class="academic-result-t"><b>Co-Scholastic Areas</b></div>'+
											'<table class="table">'+
												'<thead>'+
													'<tr><th>Subjects</th><th>Grade</th></tr>'+
												'</thead>'+
												'<tbody>';
												$.each(value.co_marks,function(key,v){
if (typeof v.mark != 'undefined'){													
    x = x +'<tr><td>'+ v.name +'</td><td align="center">'+ v.mark +'</td></tr>';  
}
else{
    x = x +'<tr><td>'+ v.name +'</td><td align="center">-</td></tr>';
}
												});
												x =x + '</tbody>'+
											'</table>'+
									'</div>'+
							'</div>'+
							'<div class="modal-footer p-footer-sec">'+
								'<div class="col-md-2 p-place-date">'+
									'<b>Bhilai </b>'+ response.date +
								'</div>'+
								'<div class="col-md-2 col-md-offset-4 p-techer-sign">'+
									'<b>Class Teacher </b>'+
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
/*-----------------------------------end mid-term multiple results end----------------------------------------------*/


/*----------------------------------final result loop --------------------------------------------------------------*/
$(document).on('click','#full_multi_marksheet',function(){
	var medium = $('#medium').val();
	var classes = $('#class').val();
	var section = $('#section').val();
	var fit = $('#fit').val();
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

	if(form_valid){
		$.ajax({
		type: 'POST',
			url: baseUrl+'Student_ctrl/final_result_class',
			dataType: "json",
			data: {
				'medium':medium,
				'class':classes,
				'section':section,
				'type' : 'final',
				'fit' : fit
			},
			beforeSend: function(){},
			success:  function (response) {
				if(classes == 12){
					response_render_loop(response);
					return false;
				}
				console.log(response);
				var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x = '';
				$.each(response.data,function(key,value){
					x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
					'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
					'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
					'<div class="modal-content p-head-sec-f ms-full">';
					
					if(value.student.school_id == 2){
					  x = x +'<img src="../../assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
			 		}
			 		if(value.student.school_id == 1){
						  x = x +'<img src="../../assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
				 		}
			      				x = x +'<div class="modal-header p-header">'+
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
										'<div class="text-center"><h5><b>Academic Report Card: 2017-18<br></b></h5></div>'+
											'<div class="col-md-10 p-student-info">'+
												'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
													'<div class="student-per-info">'+
															'<div class="student-per-info1">'+	
																'<table class="table" >'+
																	'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ value.student.name +'</b></td><tr>'+
																	'<tr><td>Mother\'s Name</td><td>: '+ value.student.mother_name +'</td><tr>'+
																	'<tr><td>Father\'s Name</td><td>: '+ value.student.father_name +'</td><tr>'+
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
																	'<tr><td>Class/Section</td><td>: '+ value.student.cname +' &#39;'+ value.student.sec_name +'&#39;</td></tr>'+
																	
																	'<tr><td>Attnd. Mid.Term</td><td>: '+ value.student.attend +'/'+ value.student.mid_days +'</td></tr>'+
																	'<tr><td>Attnd. Session End</td><td>: '+ parseInt(parseInt(value.student.presentday) - parseInt(value.student.attend)) +'/'+ parseInt(parseInt(value.student.working_days) - parseInt(value.student.mid_days)) +'</td></tr>'+
																'</table>'+
															'</div>'+
														'</div>'+
													'</div>'+
													'<div class="col-md-2 p-student-photo">';
														if(value.student.school_id ==1){
															x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/shakuntala/'+value.student.photo+'" />';
														}
														else{
															x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/sharda/'+value.student.photo+'" />';
														}
														x = x + '</div>'+
												'</div>'+				
												'<div class="results-information p-results-information-f-a col-md-12">'+
													'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
														'<table class="table fullmark-term1">'+
															'<thead>'+
																'<tr><th style="border-bottom:1px solid #b1afaf;" colspan="7">Term1</th></tr>'+
																'<tr><th style="width:21%;">Subjects</th><th>Pre Test: 10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Half Yearly: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>'+
															'</thead>'+
															'<tbody>';
																$.each(value.marks,function(k,v){
																	x = x + '<tr>'+
																				'<td style="text-align:left;">'+ v.name +'</td>'+
																				'<td style="text-align:center;">'+ v.pre_mark +'</td>'+
																				'<td style="text-align:center;">'+ v.notebook_mark +'</td>'+
																				'<td align="center">'+ v.subj_enrich +'</td>'+
																				'<td align="center">'+ v.mid_mark +'</td>'+
																				'<td align="center">'+ v.term_1_total  +'</td>'+
																				'<td align="center">'+ v.term_1_grade +'</td>'+
																			'</tr>';
																		});
																x = x + '</tbody>'+
																'</table>';
															'</div>'+
															'<div class="results-information p-results-information-f-c col-md-6" style="display:none;">'+
																'<div class="academic-result-t"><b>Co-Scholastic Areas:Term [on a 3-point (A-C) grading scale]</b></div>'+
																	'<table class="table hidden">'+
																		'<thead>'+
																			'<tr><th>Subjects</th><th>Grade</th></tr>'+
																		'</thead>'+
																		'<tbody>';
																			$.each(value.co_marks,function(k,v){
																				if(v.term_1_mark){
																						x = x +'<tr><td align="center"></td><td align="center"></td></tr>';
																				}
																				else{
																						x = x +'<tr><td align="center"></td><td align="center">_</td></tr>';
																				}
																			});
																			x =x + '</tbody>'+
																	'</table>'+
									
																	'<table class="table fullmark-term2">'+
																		'<thead>'+
																			'<tr><th style="border-bottom:1px solid #b1afaf;" colspan="6">Term2</th></tr>'+
																			'<tr><th>Post Test: 10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Session Ending Exam: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>'+
																		'</thead>'+
																		'<tbody>';
																			$.each(value.marks,function(k,v){
																				x = x + '<tr>'+
																						'<td align="center">'+ v.post_mark +'</td>'+
																						'<td align="center">'+ v.final_notebook_mark +'</td>'+
																						'<td align="center">'+ v.final_subj_enrich +'</td>'+
																						'<td align="center">'+ v.final_mark +'</td>'+
																						'<td align="center">'+ v.term_2_total +'</td>'+
																						'<td align="center">'+ v.term_2_grade +'</td>'+
																						'</tr>';
																			});
																		x = x + '</tbody>'+
																	'</table>'+
																'</div>'+
																'<div class="results-information p-results-information-f-c col-md-12" style="margin-top: 8px;margin-bottom: 6px;">'+	
																	'<div class="academic-result-t" style="background-color:rgba(241,241,241,0.0)!important;"><b>Co-Scholastic Areas</b></div>'+
																		'<table style="width:50%;float:left;" class="table">'+
																			'<thead>'+
																				'<tr><th>Term 1 [on a 3-point (A-C) grading scale]</th><th>Grade</th></tr>'+
																					'</thead>'+
																						'<tbody>';
																							$.each(value.co_marks,function(k,v){
																								if(v.term_1_mark){
																									x = x + '<tr><td style="text-align:left;">'+ v.name +'</td><td align="center">'+ v.term_1_mark +'</td></tr>';
																								}
																								else{
																									x = x + '<tr><td style="text-align:left;">'+ v.name +'</td><td align="center">-</td></tr>';
																								}
																							});
																							x = x +'</tbody>'+
																							'</table>'+
																							'<table style="width:50%;float:left;" class="table">'+
																								'<thead>'+
																									'<tr><th>Term 2 [on a 3-point (A-C) grading scale]</th><th>Grade</th></tr>'+
																								'</thead>'+
																								'<tbody>';
																									$.each(value.co_marks,function(k,v){
																										if(v.term_2_mark){
																											x = x + '<tr><td style="text-align:left;">'+ v.name +'</td><td align="center">'+ v.term_2_mark +'</td></tr>';
																										}
																										else{
																											x = x + '<tr><td style="text-align:left;">'+ v.name +'</td><td align="center">-</td></tr>';
																										}
																									});
																									x = x +'</tbody>'+
																							'</table>'+
																						'</div>'+
																						'<div class="col-md-6 teacher-remark">';
																									if(typeof(value.back) != "undefined" && value.back !== null){
																										if((value.back.length) > 0){
																											var c = 1;
																											x = x + '<p><span>Result: Promoted to Class: <b>_</b></span> <span style="margin-left:50px";>Needs improvement : ';
																											$.each(value.back,function(bkey,bvalue){
																												x = x + '('+ c +'). <b>'+ bvalue.name +'</b> '; 
																												c++; 
																											});
																											x = x +  '</span></p></div>';
																										}
																									}
																									else{
																										if(value.student.class_id == 3){
																											x = x + '<p>Result: Promoted to Class: <b>I</b></p></div>';				
																										}
																										if(value.student.class_id == 4){
																											x = x + '<p>Result: Promoted to Class: <b>II</b></p></div>';				
																										}
																										if(value.student.class_id == 5){
																											x = x + '<p>Result: Promoted to Class: <b>III</b></p></div>';				
																										}
																										if(value.student.class_id == 6){
																											x = x + '<p>Result: Promoted to Class: <b>IV</b></p></div>';				
																										}
																										if(value.student.class_id == 7){
																											x = x + '<p>Result: Promoted to Class: <b>V</b></p></div>';				
																										}
																										if(value.student.class_id == 8){
																											x = x + '<p>Result: Promoted to Class: <b>VI</b></p></div>';				
																										}
																										if(value.student.class_id == 9){
																											x = x + '<p>Result: Promoted to Class: <b>VII</b></p></div>';				
																										}
																										if(value.student.class_id == 10){
																											x = x + '<p>Result: Promoted to Class: <b>VIII</b></p></div>';				
																										}
																										if(value.student.class_id == 11){
																											x = x + '<p>Result: Promoted to Class: <b>IX</b></p></div>';				
																										}
																									}																					
																						x = x +'</div>'+
																						'<div class="modal-footer p-footer-sec-f" style="padding-left:0px;margin-top:-15px;">'+
																						'<div class="col-md-2 p-place-date" style="padding-left:5px;">'+
																						'Place: <b>Bhilai </b><br>Date: '+ response.date +
																						'</div>'+
																						'<div class="col-md-2 col-md-offset-2 p-techer-sign">'+
																						'&nbsp;<br><b>Signature of Class Teacher </b>'+
																						'</div>'+
																						'<div class="col-md-2 col-md-offset-1 p-school-seal">'+
																						'&nbsp;<br><b>Seal of the School</b>'+
																						'</div>'+
																						'<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;">';
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
																								'<div class="instc-sec">'+
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
																											'<tr><td>32 & Below</td><td>E (Needs improvement)</td></tr>'+
																										'</tbody>'+
																									'</table>'+
																								'</div>'+
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
/*------------------------------------------------------------------------------------------------------------------*/
/*Class Wise report generation*/
$(document).on('click','#mark_preview',function(){
	var medium = $('#medium').val();
	var classes = $('#class').val();
	var section = $('#section').val();

//	var form_valid = true;
//	if(medium == 0){
//		$('#medium_err').html('Please select Medium.').css('display','block');
//		form_valid = false;
//	}
//	else{
//		$('#medium_err').css('display','none');
//	}
//	if(classes == 0){
//		$('#class_err').html('Please select Class.').css('display','block');
//		form_valid = false;
//	}
//	else{
//		$('#class_err').css('display','none');
//	}
//	if(section == 0){
//		$('#section_err').html('Please select Section.').css('display','block');
//		form_valid = false;
//	}
//	else{
//		$('#section_err').css('display','none');
//	}
//
//	if(form_valid){
//		$.ajax({
//			type: 'POST',
//				url: baseUrl+'Student_ctrl/mid_result_classwise',
//				dataType: "json",
//				data: {
//					'medium':medium,
//					'class':classes,
//					'section':section 
//				},
//				beforeSend: function(){},
//				success:  function (response){
//					
//				}
//		});
	var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
	var x = '<div class="">'+
		'<style>table{font-size:12px;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:10px 10px 0 10px;background-color:#f1f1f1;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:95px;font-size:11px;} .subject-name-f{float:left;width:32px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;}</style>'+
		'<div class="header-sec-f"><b class="sv">SHAKUNTALA VIDYALAYA, Ramnagar, Bhilai, Chhattisgarh</b><br><br><table class="table" style="margin-bottom:0;"><tbody><tr><td><b>CLASS WISE ACADEMIC RESULT RECORD, SESSION 2016-17</b></td><td><b>Class: IV A</b></td></tr></tbody></table></div>'+
		'<div class="">'+
		'<table class="table class-wise-report-r"><thead><tr><th>Student info</th><th>English</th><th>Hindi</th><th>Maths</th><th>EVS</th><th>Final Result</th></tr></thead>'+
		
		'<tbody><tr style="background-color:#f2f2f2;"><td class="stu-info-t" style="width:40%;"><div class="stu-info-s-no">S.No.</div><div class="stu-info-roll">Roll No.</div><div class="stu-info-adm">Adm No.</div><div class="stu-info">Student\'s Name</div><div class="stu-info">Father Name</div><div class="stu-info">Mother Name</div><div class="stu-info-att">Att.</div></td>'+
		
		'<td><div class="subject-name-f">Pre</div><div class="subject-name-f">Mid</div><div class="subject-name-f">Post</div><div class="subject-name-f">Final</div></td>'+
		'<td><div class="subject-name-f">Pre</div><div class="subject-name-f">Mid</div><div class="subject-name-f">Post</div><div class="subject-name-f">Final</div></td>'+
		'<td><div class="subject-name-f">Pre</div><div class="subject-name-f">Mid</div><div class="subject-name-f">Post</div><div class="subject-name-f">Final</div></td>'+
		'<td><div class="subject-name-f">Pre</div><div class="subject-name-f">Mid</div><div class="subject-name-f">Post</div><div class="subject-name-f">Final</div></td>'+

		'<td><div class="subject-name-f">Result</div><div class="subject-name-f">CGPA</div><div class="subject-name-f">OverAll</div><div class="subject-name-f">Remark</div></td>'+
		'</tr>'+
		/*Result start student section*/
		'<tr><td><div class="stu-info-s-no">1.</div><div class="stu-info-roll">142</div><div class="stu-info-adm">415</div><div class="stu-info">Ramesh kumar Sharma</div><div class="stu-info">Mahesh Sharma</div><div class="stu-info">Sangeeta Sharma</div><div class="stu-info-att">142/115</div></td>'+
		/*Result show */
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		
		/*final section*/
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		'</tr>'+
		
		/*Result start student section*/
		'<tr><td><div class="stu-info-s-no">1.</div><div class="stu-info-roll">142</div><div class="stu-info-adm">415</div><div class="stu-info">Ramesh kumar Sharma</div><div class="stu-info">Mahesh Sharma</div><div class="stu-info">Sangeeta Sharma</div><div class="stu-info-att">142/115</div></td>'+
		/*Result show */
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		
		
		/*final section*/
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">25</div><div class="subject-name-f">25</div><div class="subject-name-f">65</div></td>'+
		'</tr>'+
		
		'</tbody></table>'+
		'</div>'+
//		
		'<div>';
	x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
			'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
			'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">';
	
	 with(win.document){
	      open();
	      write(x);
		      close();
	    }
	//}
});





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*-----------------------------Nineth results--------------------------------------*/
$(document).on('click','#ninth',function(){
			var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
			var x = '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
					'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
					'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
					'<div class="modal-content p-head-sec-f">'+
		      				/*if(response.data.student[0].school_id == 2){
				  x = x +'<img src="../../assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
		 		}
		 		if(response.data.student[0].school_id == 1){
					  x = x +'<img src="../../assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
			 		}
		      				x = x +*/
							'<img src="../../assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">'+
							'<div class="modal-header p-header">'+
									'<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="../../assest/images/sharda/cbse-logo.png" /></div>'+
									'<div class="col-md-6 p-logo-sec text-center">';
										if(2 == 2){
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
										if(2 ==2){
												x = x + '<img class="p-logo pull-right" src="../../assest/images/sharda/logo.png" />'; }
											else{ x = x + '<img class="p-logo pull-right" src="../../assest/images/shakuntala/logo.png" />'; }
											x = x +
									'</div>'+
							'</div>'+
			  			'<div class="modal-body p-student-body">'+
							'<div class="student-Information" >'+
							'<div class="text-center"><h5><b>Academic Report Card: 2017-18<br></b></h5></div>'+
								/*'<div class="col-md-10 p-student-info">'+
									'<div class="student-per-info-f" >'+
											'<div class="student-per-info1" style="width:100%;">'+	
												'<table class="table" >'+
													'<tr><td>Roll No.</td><td>: 125452</td></tr>'+
													'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>rahuk</b></td><tr>'+
													'<tr><td>Father\'s Name</td><td>:ffff name</td><tr>'+
													'<tr><td>Date of Birth</td><td>: 22-1-2018</td></tr>'+
													'<tr><td>Class/Section</td><td>: V A</td></tr>'+
												'</table>'+
											'</div>'+
										'</div>'+
								'</div>'+	*/	
								'<div class="col-md-10 p-student-info">'+
										'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
										'<div class="student-per-info">'+
												'<div class="student-per-info1">'+	
													'<table class="table" >'+
													'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ response.data.student[0].name +'</b></td><tr>'+
													'<tr><td>Mother\'s Name</td><td>: '+ response.data.student[0].mother_name +'</td><tr>'+
													'<tr><td>Father\'s Name</td><td>: '+ response.data.student[0].father_name +'</td><tr>'+
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
														'<tr><td>Class/Section</td><td>: '+ response.data.student[0].cname +' &#39;'+ response.data.student[0].sec_name +'&#39;</td></tr>'+
														'<tr><td>Attnd. Mid.Term</td><td>: '+ response.data.student[0].presentday +'/'+ response.data.student[0].working_days +'</td></tr>'+							
													'</table>'+
												'</div>'+
											'</div>'+
										'</div>'+
										'<div class="col-md-2 p-student-photo">';
											if(response.data.student[0].school_id ==1){
												x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/shakuntala/'+response.data.student[0].photo+'" />';
											}
											else{
												x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/sharda/'+response.data.student[0].photo+'" />';
											}
											x = x + 
										'</div>'+
									'</div>'+
								'<div class="results-information p-results-information-f-a col-md-12">'+
									'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
									'<table class="table">'+
										'<thead>'+
											'<tr><th style="width:18%;">Subjects</th><th>Periodic Test: 10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Annual Examination: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>'+
										'</thead>'+
										'<tbody>'+
										'<tr><td>hindi</td><td>10</td><td>15</td><td>40</td><td>41</td><td>41</td><td>A</td></tr>'+
										'</tbody>'+
									'</table>'+
								'</div>'+
								'<div class="results-information p-results-information-f-a col-md-12" style="margin-top:15px;">'+
									'<table class="table">'+
										'<thead>'+
											'<tr><th rowspan="2" style="width:18%;">Subject</th><th colspan="3">Annual Marks</th><th>Periodic Test:</th><th>Note Book: </th><th>Sub Enrichment:</th><th>Annual Examination:</th><th>Marks Obtained:</th><th rowspan="2">Grade</th></tr>'+
											'<tr><th>Th: 60</th><th>Pr: 40</th><th>Total: 100</th><th>10</th><th>05</th><th>05</th><th>80</th><th>100</th></tr>'+
										'</thead>'+
										'<tbody>'+
										'<tr><td>FIT</td><td>33</td><td>44</td><td>55</td><td>10</td><td>15</td><td>40</td><td>41</td><td>41</td><td>A</td></tr>'+
										'</tbody>'+
									'</table>'+
								'</div>'+
								'<div class="results-information p-results-information-f-c col-md-6" style="margin-top:15px;">'+
										'<table class="table">'+
											'<thead>'+
												'<tr><th>Co-Scholastic Areas [on a 5-point (A-E) grading scale]</th><th>Grade</th></tr>'+
											'</thead>'+
											'<tbody>'+
											'<tr><td style="text-align:left;">Work Education</td><td>A</td></tr>'+
											'</tbody>'+
										'</table>'+
								'</div>'+
								'<div class="results-information p-results-information-f-c col-md-6" style="margin-top:15px;">'+	
										'<table class="table">'+
											'<thead>'+
												'<tr><th>Co-Scholastic Areas [on a 5-point (A-E) grading scale]</th><th>Grade</th></tr>'+
											'</thead>'+
											'<tbody>'+
											'<tr><td style="text-align:left;">Discipline</td><td>A</td></tr>'+
											'</tbody>'+
										'</table>'+
								'</div>'+
							
'<div class="col-md-6 teacher-remark">'+
						'<p>Promoted to Class: ...................................................</p></div>'+				
'</div>'+
						
						'<div class="modal-footer p-footer-sec-f" style="padding-left:0px;">'+
							'<div class="col-md-2 p-place-date">'+
								'Place: <b>Bhilai </b><br>Date: 12-01-2018'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-2 p-techer-sign">'+
								'&nbsp;<br><b>Signature of Class Teacher </b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 p-school-seal">'+
								'&nbsp;<br><b>Seal of the School</b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;">'+
							
								/*if(response.data.student[0].school_id == 2){
									x = x + '<img class="principle-sign" src="../../assest/images/sharda/PrinSign.png"><br/>'+
								'(Gajindra Bhoi) <br><b>Principal</b>';
								}
								else{
									x = x + '<img class="principle-sign" src="../../assest/images/shakuntala/PrinSign.png"><br/>'+
								'(Vipin Kumar) <br><b>Principal</b>';
								}
								x = x + */
								'<img class="principle-sign" src="../../assest/images/shakuntala/PrinSign.png"><br/>'+
								'(Vipin Kumar) <br><b>Principal</b>'+
							'</div>'+
							'<div class="instc-sec">'+
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
						'</div>'+
					'</div>';
			 with(win.document){
			      open();
			      write(x);
				      close();
			    }
});


function response_render(response){
	console.log(response);
	var baseUrl = $('#base_url').val();
	var aggrigate = 0;
	var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
	var x = '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
			'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
			'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
			'<div class="modal-content p-head-sec-f">';
      		if(response.data.student[0].school_id == 2){
		  		x = x +'<img src="'+ baseUrl +'/assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
 			}
 			if(response.data.student[0].school_id == 1){
			  x = x +'<img src="'+ baseUrl +'/assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:31%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
	 		}
      				
 			x = x + '<div class="modal-header p-header">'+
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
								if(response.data.student[0].school_id == 2){
										x = x + '<img class="p-logo pull-right" src="../../assest/images/sharda/logo.png" />'; 
									}
									else{ 
										x = x + '<img class="p-logo pull-right" src="../../assest/images/shakuntala/logo.png" />'; 
									}
									x = x + '</div>'+
							'</div>'+
	  						'<div class="modal-body p-student-body nine-result">'+
								'<div class="student-Information" >'+
									'<div class="text-center"><h5><b>Academic Report Card: 2017-18<br></b></h5></div>'+
'<div class="col-md-10 p-student-info">'+
										'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
										'<div class="student-per-info">'+
												'<div class="student-per-info1">'+	
													'<table class="table" >'+
													'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ response.data.student[0].name +'</b></td><tr>'+
													'<tr><td>Mother\'s Name</td><td>: '+ response.data.student[0].mother_name +'</td><tr>'+
													'<tr><td>Father\'s Name</td><td>: '+ response.data.student[0].father_name +'</td><tr>'+
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
														'<tr><td>Class/Section</td><td>: '+ response.data.student[0].cname +' &#39;'+ response.data.student[0].sec_name +'&#39;</td></tr>'+							
													'</table>'+
												'</div>'+
											'</div>'+
										'</div>'+
										'<div class="col-md-2 p-student-photo">';
											if(response.data.student[0].school_id ==1){
												x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/shakuntala/'+response.data.student[0].photo+'" />';
											}
											else{
												x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/sharda/'+response.data.student[0].photo+'" />';
											}
											x = x + 
										'</div>'+
									'</div>'+									
									'<div class="results-information p-results-information-f-a col-md-12">'+
										'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
											'<table class="table">'+
												'<thead>'+
													'<tr><th style="width:18%;text-align:left;">Subjects</th><th>Periodic Test: 10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Session Ending Exam: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>'+
												'</thead>'+
												'<tbody>';
													$.each(response.data.marks,function(key,value){
														if(value.sub_name != 'FIT'){
															if(typeof response.data.back != 'undefined'){
																if(response.data.back.category == 'Detained'){
																	if(value.extra){
																		x = x +	'<tr><td style="text-align:left;">'+ value.sub_name +'</td><td>'+ value.priodic +'</td><td>'+ value.notebook +'</td><td>'+ value.subjenrich +'</td><td>'+ value.annual_mark + '*</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																		//aggrigate = aggrigate + value.annualsub_total;
																	}
																	else{
																		x = x +	'<tr><td style="text-align:left;">'+ value.sub_name +'</td><td>'+ value.priodic +'</td><td>'+ value.notebook +'</td><td>'+ value.subjenrich +'</td><td>'+ value.annual_mark +  value.stars +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																		//aggrigate = aggrigate + value.annualsub_total;
																	}
																}
																else{
																	x = x +	'<tr><td style="text-align:left;">'+ value.sub_name +'</td><td>'+ value.priodic +'</td><td>'+ value.notebook +'</td><td>'+ value.subjenrich +'</td><td>'+ parseInt(parseInt(value.annual_mark)+parseInt(value.extra)) +  value.stars +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																	//aggrigate = aggrigate + value.annualsub_total;
																}
															}
															else{
																x = x +	'<tr><td style="text-align:left;">'+ value.sub_name +'</td><td>'+ value.priodic +'</td><td>'+ value.notebook +'</td><td>'+ value.subjenrich +'</td><td>'+ parseInt(parseInt(value.annual_mark)+parseInt(value.extra)) +  value.stars +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																//aggrigate = aggrigate + value.annualsub_total;
															}
														}
													});
												x = x + '</tbody>'+
											'</table>'+
										'</div>'+
										'<div class="results-information p-results-information-f-c col-md-6" style="margin-top:15px;padding-right:0px;">'+
											'<table class="table">'+
												'<thead>'+
													'<tr><th rowspan="3" style="width:18%;">Subject</th><th colspan="5">Session Ending Marks</th><th rowspan="3">Grade</th></tr>'+
													'<tr><th colspan="2">Theory</th><th colspan="2">Practical</th><th>Total</th></tr>'+
													'<tr><th>MM</th><th>Marks Obtained</th><th>MM</th><th>Marks Obtained</th><th>100</th></tr>'+
												'</thead>'+
												'<tbody>';
													$.each(response.data.marks,function(key,value){
														if(value.sub_name == 'FIT'){
															if(typeof response.data.back != 'undefined'){
																if(response.data.back.category == 'Detained'){
																	if(value.extra){
																		var grade_no = Math.round(parseInt(parseInt(value.thory) + parseInt(value.practical)));
																		var grade = '';
																		if(grade_no >= 91){
														                    grade = 'A1';
														                }
														                else if(grade_no >= 81 && grade_no <= 90){
														                	grade = 'A2';
														                }
														                else if(grade_no >= 71 && grade_no <= 80){
														                	grade = 'B1';
														                }
														                else if(grade_no >= 61 && grade_no <= 70){
														                	grade = 'B2';
														                }
														                else if(grade_no >= 51 && grade_no <= 60){
														                	grade = 'C1';
														                }
														                else if(grade_no >= 41 && grade_no <= 50){
														                	grade = 'C2';
														                }
														                else if(grade_no >= 33 && grade_no <= 40){
														                	grade = 'D';
														                }
														                else{
														                	grade = 'E';
														                }
																		x = x +	'<tr><td>FOIT</td><td>40</td><td>'+ parseInt(parseInt(value.thory) + parseInt(value.extra)) + value.stars +'</td><td>60</td><td>'+ value.practical +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																	}
																	else{
																		var grade_no = Math.round(parseInt(parseInt(value.thory) + parseInt(value.practical)));
																		var grade = '';
																		if(grade_no >= 91){
														                    grade = 'A1';
														                }
														                else if(grade_no >= 81 && grade_no <= 90){
														                	grade = 'A2';
														                }
														                else if(grade_no >= 71 && grade_no <= 80){
														                	grade = 'B1';
														                }
														                else if(grade_no >= 61 && grade_no <= 70){
														                	grade = 'B2';
														                }
														                else if(grade_no >= 51 && grade_no <= 60){
														                	grade = 'C1';
														                }
														                else if(grade_no >= 41 && grade_no <= 50){
														                	grade = 'C2';
														                }
														                else if(grade_no >= 33 && grade_no <= 40){
														                	grade = 'D';
														                }
														                else{
														                	grade = 'E';
														                }
																		x = x +	'<tr><td>FOIT</td><td>40</td><td>'+ parseInt(parseInt(value.thory) + parseInt(value.extra)) + value.stars +'</td><td>60</td><td>'+ value.practical +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																	}
																}
																else{
																	var grade_no = Math.round(parseInt(parseInt(parseInt(value.thory)+parseInt(value.extra)) + parseInt(value.practical)));
																	var grade = '';
																	if(grade_no >= 91){
													                    grade = 'A1';
													                }
													                else if(grade_no >= 81 && grade_no <= 90){
													                	grade = 'A2';
													                }
													                else if(grade_no >= 71 && grade_no <= 80){
													                	grade = 'B1';
													                }
													                else if(grade_no >= 61 && grade_no <= 70){
													                	grade = 'B2';
													                }
													                else if(grade_no >= 51 && grade_no <= 60){
													                	grade = 'C1';
													                }
													                else if(grade_no >= 41 && grade_no <= 50){
													                	grade = 'C2';
													                }
													                else if(grade_no >= 33 && grade_no <= 40){
													                	grade = 'D';
													                }
													                else{
													                	grade = 'E';
													                }
																	x = x +	'<tr><td>FOIT</td><td>40</td><td>'+ parseInt(parseInt(value.thory) + parseInt(value.extra)) + value.stars +'</td><td>60</td><td>'+ value.practical +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																}
															}
															else{
																var grade_no = Math.round(parseInt(parseInt(parseInt(value.thory)+parseInt(value.extra)) + parseInt(value.practical)));
																var grade = '';
																if(grade_no >= 91){
												                    grade = 'A1';
												                }
												                else if(grade_no >= 81 && grade_no <= 90){
												                	grade = 'A2';
												                }
												                else if(grade_no >= 71 && grade_no <= 80){
												                	grade = 'B1';
												                }
												                else if(grade_no >= 61 && grade_no <= 70){
												                	grade = 'B2';
												                }
												                else if(grade_no >= 51 && grade_no <= 60){
												                	grade = 'C1';
												                }
												                else if(grade_no >= 41 && grade_no <= 50){
												                	grade = 'C2';
												                }
												                else if(grade_no >= 33 && grade_no <= 40){
												                	grade = 'D';
												                }
												                else{
												                	grade = 'E';
												                }
																x = x +	'<tr><td>FOIT</td><td>40</td><td>'+ parseInt(parseInt(value.thory) + parseInt(value.extra)) + value.stars +'</td><td>60</td><td>'+ value.practical +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
															}
														}
													});
												x = x +'</tbody>'+
											'</table>'+
'<div class="teacher-remark">'+
						'<table class="table"><tbody><tr><td><b>Aggrigate</b></td><td><b>'+ response.data.aggrigate +'/500</b></td><td><b>Result:</b></td>';
							var category = '';
							var y ='';
							if(typeof response.data.back != 'undefined'){
								if(response.data.back.length > 0){
									$.each(response.data.back,function(key,value){
										y = y + value +',';
									});
									y = y.slice(0, -1)
									category = '<td><b>Compartment</b> in &nbsp;&nbsp;<b>'+ y + '</b></td>';
								}
								else{
									category = '<td><b>Pass</b></td>';	
								}
							}
							else{
								category = '<td><b>Pass</b></td>';
							}
							
						x = x + category +'</tr></tbody></table>'+
							'<table class="table" style="margin-top:5px;"><thead>';
								if(response.r_status){
									x = x + '<tr><th colspan="4" style="text-align:left;">Compartment Result : Detained </th></tr>';  
								}
								else{
									x = x + '<tr><th colspan="4" style="text-align:left;">Compartment Result : PASS </th></tr>';
								}
								x = x + '<tr><th>S.NO.</th><th>Subject</th><th>MM</th><th>Obtained</th></tr></thead>';
								var cc = 1;
								$.each(response.compart,function(ck,cv){
									x = x + '<tbody><tr><td>'+ cc +'</td><td>'+ cv.s_name +'</td><td>'+ cv.mm +'</td><td>'+ cv.obtain +'</td></tr>';
									cc++;
								});
							x = x + '</tbody></table>'+
							'</div>'+
										'</div>'+
										'<div class="results-information p-results-information-f-c col-md-6" style="margin-top:15px;margin-bottom:6px;">'+
											'<table class="table">'+
												'<thead>'+
													'<tr><th style="text-align:left;">Co-Scholastic Areas [on a 5-point (A-E) grading scale]</th><th>Grade</th></tr>'+
												'</thead>'+
												'<tbody>';
													$.each(response.data.co_marks,function(k,v){
														x = x + '<tr><td style="text-align:left;">'+ v.name +'</td><td>'+ v.mark +'</td></tr>'; 
													});
												x = x +'</tbody>'+
											'</table>'+
										'</div>'+
														
'</div>'+
						
						'<div class="modal-footer p-footer-sec-f" style="padding-left:0px;margin-top:-27px;">'+
							'<div class="col-md-2 p-place-date" style="padding-left:5px;">'+
								'Place: <b>Bhilai </b><br>Date: '+ response.date +
							'</div>'+
							'<div class="col-md-2 col-md-offset-2 p-techer-sign">'+
								'&nbsp;<br><b>Signature of Class Teacher </b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 p-school-seal">'+
								'&nbsp;<br><b>Seal of the School</b>'+
							'</div>'+
										'<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;">';
											if(response.data.student[0].school_id == 2){
												x = x + '<img class="principle-sign" src="../../assest/images/sharda/PrinSign.png"><br/>'+
													'(Gajindra Bhoi) <br><b>Principal</b>';
											}
											else{
												x = x + '<img class="principle-sign" src="../../assest/images/shakuntala/PrinSign.png"><br/>'+
													'(Vipin Kumar) <br><b>Principal</b>';
											}
											x = x +'</div>'+
										'<div class="instc-sec">'+
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
	 					with(win.document){
	      					open();
	      					write(x);
		      				close();
	    				}
					}






function response_render_loop(response){
	console.log(response);
	var baseUrl = $('#base_url').val();
	var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
	var x = '';
	
	$.each(response.data,function(kkey,vvalue){
	var aggrigate = 0;
	x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
			'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
			'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">'+
			'<div class="modal-content p-head-sec-f" style="height:1016px;">';
      		if(vvalue.student[0].school_id == 2){
		  		x = x +'<img src="'+ baseUrl +'/assest/images/sharda/result_bg_logo-w.png" style="position:absolute;top:35%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
 			}
 			if(vvalue.student[0].school_id == 1){
			  x = x +'<img src="'+ baseUrl +'/assest/images/shakuntala/result_bg_logo-w.png" style="position:absolute;top:30%;left:30%;margin:0 auto; background-size:cover; background-position:center;">';
	 		}
      				
 			x = x + '<div class="modal-header p-header">'+
							'<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="../../assest/images/sharda/cbse-logo.png" /></div>'+
							'<div class="col-md-6 p-logo-sec text-center">';
								if(vvalue.student[0].school_id == 2){
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
								if(vvalue.student[0].school_id == 2){
										x = x + '<img class="p-logo pull-right" src="../../assest/images/sharda/logo.png" />'; 
									}
									else{ 
										x = x + '<img class="p-logo pull-right" src="../../assest/images/shakuntala/logo.png" />'; 
									}
									x = x + '</div>'+
							'</div>'+
	  						'<div class="modal-body p-student-body nine-result">'+
								'<div class="student-Information" >'+
									'<div class="text-center"><h5><b>Academic Report Card: 2017-18<br></b></h5></div>'+
'<div class="col-md-10 p-student-info">'+
										'<div class="student-info-t"><b>STUDENT PARTICULARS</b></div>'+
										'<div class="student-per-info">'+
												'<div class="student-per-info1">'+	
													'<table class="table" >'+
													'<tr><td style="width:35%;">Student\'s Name</td><td>: <b>'+ vvalue.student[0].name +'</b></td><tr>'+
													'<tr><td>Mother\'s Name</td><td>: '+ vvalue.student[0].mother_name +'</td><tr>'+
													'<tr><td>Father\'s Name</td><td>: '+ vvalue.student[0].father_name +'</td><tr>'+
													'<tr><td>Contact No.</td><td>: '+ vvalue.student[0].contact_no +'</td></tr>'+
													'<tr><td>Aadhar No.</td><td>: '+ vvalue.student[0].aadhar +'</td></tr>'+
													'<tr><td>Address</td><td class="address-sec">: '+ vvalue.student[0].address +'</td></tr>'+
													'</table>'+
												'</div>'+
												'<div class="student-per-info2">'+
													'<table class="table">'+
														'<tr><td>Date of Birth</td><td>: '+ vvalue.student[0].dob +'</td></tr>'+
														'<tr><td>Adm. No.</td><td>: '+ vvalue.student[0].admission_no +'</td></tr>'+
														'<tr><td>Roll No.</td><td>: '+ vvalue.student[0].roll_no +'</td></tr>'+
														'<tr><td>Class/Section</td><td>: '+ vvalue.student[0].cname +' &#39;'+ vvalue.student[0].sec_name +'&#39;</td></tr>'+							
													'</table>'+
												'</div>'+
											'</div>'+
										'</div>'+
										'<div class="col-md-2 p-student-photo">';
											if(vvalue.student[0].school_id ==1){
												x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/shakuntala/'+vvalue.student[0].photo+'" />';
											}
											else{
												x = x + '<img class="student-photo" src="'+baseUrl+'photos/students/sharda/'+vvalue.student[0].photo+'" />';
											}
											x = x + 
										'</div>'+
									'</div>'+									
									'<div class="results-information p-results-information-f-a col-md-12">'+
										'<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>'+
											'<table class="table">'+
												'<thead>'+
													'<tr><th style="width:18%;text-align:left;">Subjects</th><th>Periodic Test: 10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Session Ending Exam: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>'+
												'</thead>'+
												'<tbody>';
													$.each(vvalue.marks,function(key,value){
														if(value.sub_name != 'FIT'){
															if(typeof vvalue.back != 'undefined'){
																if(vvalue.back.category == 'Detained'){
																	if(value.extra){
																		x = x +	'<tr><td style="text-align:left;">'+ value.sub_name +'</td><td>'+ value.priodic +'</td><td>'+ value.notebook +'</td><td>'+ value.subjenrich +'</td><td>'+ value.annual_mark + '*</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																		aggrigate = aggrigate + value.annualsub_total;
																	}
																	else{
																		x = x +	'<tr><td style="text-align:left;">'+ value.sub_name +'</td><td>'+ value.priodic +'</td><td>'+ value.notebook +'</td><td>'+ value.subjenrich +'</td><td>'+ value.annual_mark +  value.stars +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																		aggrigate = aggrigate + value.annualsub_total;
																	}
																}
																else{
																	x = x +	'<tr><td style="text-align:left;">'+ value.sub_name +'</td><td>'+ value.priodic +'</td><td>'+ value.notebook +'</td><td>'+ value.subjenrich +'</td><td>'+ parseInt(parseInt(value.annual_mark)+parseInt(value.extra)) +  value.stars +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																	aggrigate = aggrigate + value.annualsub_total;
																}
															}
															else{
																x = x +	'<tr><td style="text-align:left;">'+ value.sub_name +'</td><td>'+ value.priodic +'</td><td>'+ value.notebook +'</td><td>'+ value.subjenrich +'</td><td>'+ parseInt(parseInt(value.annual_mark)+parseInt(value.extra)) +  value.stars +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																aggrigate = aggrigate + value.annualsub_total;
															}
														}
													});
													console.log(aggrigate);
												x = x + '</tbody>'+
											'</table>'+
										'</div>'+
										'<div class="results-information p-results-information-f-c col-md-6" style="margin-top:15px;padding-right:0px;">'+
											'<table class="table">'+
												'<thead>'+
													'<tr><th rowspan="3" style="width:18%;">Subject</th><th colspan="5">Session Ending Marks</th><th rowspan="3">Grade</th></tr>'+
													'<tr><th colspan="2">Theory</th><th colspan="2">Practical</th><th>Total</th></tr>'+
													'<tr><th>MM</th><th>Marks Obtained</th><th>MM</th><th>Marks Obtained</th><th>100</th></tr>'+
												'</thead>'+
												'<tbody>';
													$.each(vvalue.marks,function(key,value){
														if(value.sub_name == 'FIT'){
															if(typeof vvalue.back != 'undefined'){
																if(vvalue.back.category == 'Detained'){
																	if(value.extra){
																		var grade_no = parseInt(parseInt(value.thory) + parseInt(value.practical));
																		var grade = '';
																		if(grade_no >= 91){
														                    grade = 'A1';
														                }
														                else if(grade_no >= 81 && grade_no <= 90){
														                	grade = 'A2';
														                }
														                else if(grade_no >= 71 && grade_no <= 80){
														                	grade = 'B1';
														                }
														                else if(grade_no >= 61 && grade_no <= 70){
														                	grade = 'B2';
														                }
														                else if(grade_no >= 51 && grade_no <= 60){
														                	grade = 'C1';
														                }
														                else if(grade_no >= 41 && grade_no <= 50){
														                	grade = 'C2';
														                }
														                else if(grade_no >= 33 && grade_no <= 40){
														                	grade = 'D';
														                }
														                else{
														                	grade = 'E';
														                }
																		x = x +	'<tr><td>FOIT</td><td>40</td><td>'+ parseInt(parseInt(value.thory) + parseInt(value.extra)) + value.stars +'</td><td>60</td><td>'+ value.practical +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																	}
																	else{
																		var grade_no = parseInt(parseInt(value.thory) + parseInt(value.practical));
																		var grade = '';
																		if(grade_no >= 91){
														                    grade = 'A1';
														                }
														                else if(grade_no >= 81 && grade_no <= 90){
														                	grade = 'A2';
														                }
														                else if(grade_no >= 71 && grade_no <= 80){
														                	grade = 'B1';
														                }
														                else if(grade_no >= 61 && grade_no <= 70){
														                	grade = 'B2';
														                }
														                else if(grade_no >= 51 && grade_no <= 60){
														                	grade = 'C1';
														                }
														                else if(grade_no >= 41 && grade_no <= 50){
														                	grade = 'C2';
														                }
														                else if(grade_no >= 33 && grade_no <= 40){
														                	grade = 'D';
														                }
														                else{
														                	grade = 'E';
														                }
																		x = x +	'<tr><td>FOIT</td><td>40</td><td>'+ parseInt(parseInt(value.thory) + parseInt(value.extra)) + value.stars +'</td><td>60</td><td>'+ value.practical +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																	}
																}
																else{
																	var grade_no = parseInt(parseInt(parseInt(value.thory)+parseInt(value.extra)) + parseInt(value.practical));
																	var grade = '';
																	if(grade_no >= 91){
													                    grade = 'A1';
													                }
													                else if(grade_no >= 81 && grade_no <= 90){
													                	grade = 'A2';
													                }
													                else if(grade_no >= 71 && grade_no <= 80){
													                	grade = 'B1';
													                }
													                else if(grade_no >= 61 && grade_no <= 70){
													                	grade = 'B2';
													                }
													                else if(grade_no >= 51 && grade_no <= 60){
													                	grade = 'C1';
													                }
													                else if(grade_no >= 41 && grade_no <= 50){
													                	grade = 'C2';
													                }
													                else if(grade_no >= 33 && grade_no <= 40){
													                	grade = 'D';
													                }
													                else{
													                	grade = 'E';
													                }
																	x = x +	'<tr><td>FOIT</td><td>40</td><td>'+ parseInt(parseInt(value.thory) + parseInt(value.extra)) + value.stars +'</td><td>60</td><td>'+ value.practical +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
																}
															}
															else{
																var grade_no = parseInt(parseInt(parseInt(value.thory)+parseInt(value.extra)) + parseInt(value.practical));
																var grade = '';
																if(grade_no >= 91){
												                    grade = 'A1';
												                }
												                else if(grade_no >= 81 && grade_no <= 90){
												                	grade = 'A2';
												                }
												                else if(grade_no >= 71 && grade_no <= 80){
												                	grade = 'B1';
												                }
												                else if(grade_no >= 61 && grade_no <= 70){
												                	grade = 'B2';
												                }
												                else if(grade_no >= 51 && grade_no <= 60){
												                	grade = 'C1';
												                }
												                else if(grade_no >= 41 && grade_no <= 50){
												                	grade = 'C2';
												                }
												                else if(grade_no >= 33 && grade_no <= 40){
												                	grade = 'D';
												                }
												                else{
												                	grade = 'E';
												                }
																x = x +	'<tr><td>FOIT</td><td>40</td><td>'+ parseInt(parseInt(value.thory) + parseInt(value.extra)) + value.stars +'</td><td>60</td><td>'+ value.practical +'</td><td>'+ value.annualsub_total +'</td><td>'+ value.grade +'</td></tr>';
															}
														}
													});
												x = x +'</tbody>'+
											'</table>'+
'<div class="teacher-remark">'+
						'<table class="table"><tbody><tr><td><b>Aggrigate</b></td><td><b>'+ vvalue.aggrigate +'/500</b></td><td><b>Result:</b></td>';
							var category = '';
							var y = '';
							if(typeof vvalue.back != 'undefined'){
								if(vvalue.back.length > 0){
									$.each(vvalue.back,function(key,value){
										y = y + value +',';
									});
									y = y.slice(0, -1)
									category = '<td><b>Compartment</b> in &nbsp;&nbsp;<b>'+ y + '</b></td>';
								}
								else{
									category = '<td><b>Pass</b></td>';	
								}
							}
							else{
								category = '<td><b>Pass</b></td>';
							}

						x = x + category +'</tr></tbody></table></div>'+
										'</div>'+
										'<div class="results-information p-results-information-f-c col-md-6" style="margin-top:15px;margin-bottom:6px;">'+
											'<table class="table">'+
												'<thead>'+
													'<tr><th style="text-align:left;">Co-Scholastic Areas [on a 5-point (A-E) grading scale]</th><th>Grade</th></tr>'+
												'</thead>'+
												'<tbody>';
													$.each(vvalue.co_marks,function(k,v){
														x = x + '<tr><td style="text-align:left;">'+ v.name +'</td><td>'+ v.mark +'</td></tr>'; 
													});
												x = x +'</tbody>'+
											'</table>'+
										'</div>'+
														
'</div>'+
						
						'<div class="modal-footer p-footer-sec-f" style="padding-left:0px;margin-top:-15px;">'+
							'<div class="col-md-2 p-place-date" style="padding-left:5px;">'+
								'Place: <b>Bhilai </b><br>Date: '+ response.date +
							'</div>'+
							'<div class="col-md-2 col-md-offset-2 p-techer-sign">'+
								'&nbsp;<br><b>Signature of Class Teacher </b>'+
							'</div>'+
							'<div class="col-md-2 col-md-offset-1 p-school-seal">'+
								'&nbsp;<br><b>Seal of the School</b>'+
							'</div>'+
										'<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;">';
												
											if(vvalue.student[0].school_id == 2){
												x = x + '<img class="principle-sign" src="../../assest/images/sharda/PrinSign.png"><br/>'+
													'(Gajindra Bhoi) <br><b>Principal</b>';
											}
											else{
												x = x + '<img class="principle-sign" src="../../assest/images/shakuntala/PrinSign.png"><br/>'+
													'(Vipin Kumar) <br><b>Principal</b>';
											}
											x = x +'</div>'+
										'<div class="instc-sec">'+
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
