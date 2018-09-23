var baseUrl = $('#base_url').val();
/*Class Wise report generation*/
/*class wise pre result*/
var formvalid = true;
$(document).on('click','.classwise_pre',function(){
	var type = $(this).data('type'); 
	if($('#session').val() == 0){
		formvalid = false;
		$('#session_err').html('Please select Session.').css('display','block');
	}
	else{
		$('#session_err').css('display','none');
		formvalid = true;
	}
	
	if($('#medium').val() == 0){
		formvalid = false;
		$('#medium_err').html('Please select Medium.').css('display','block');
	}
	else{
		$('#medium_err').css('display','none');
		formvalid = true;
	}
	
	if($('#class').val() == 0){
		formvalid = false;
		$('#class_err').html('Please select class.').css('display','block');
	}
	else{
		formvalid = true;
		$('#class_err').css('display','none');
	}
	
	if($('#section').val() == 0){
		formvalid = false;
		$('#section_err').html('Please select section.').css('display','block');
	}
	else{
		formvalid = true;
		$('#section_err').css('display','none');
	}
	var fit = 0;
	if($('#class').val() == 12 || $('#class').val() == 13){
	   fit = $('#fit').val();	
	}
	else{
		fit = 0;
	}
	
	if(formvalid){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Student_ctrl/classwise_pre',
			dataType: "json",
			data: {
				'c_id' : $('#class').val(),
				'section' : $('#section').val(),
				'medium' : $('#medium').val(),
				'session' : $('#session').val(),
				'type' : type,
				'fit': fit
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				console.log(response);
			 	if(!response.data.s_list.length){
					alert('This can\'t be done. One or more of following entries are missing. \n - Attendance \n - Marks entries.');
					return false;
				}
				else{
					var subject_list = response.data.s_list[0].marks.length;
				}
				if(!response.data.s_list.length){
					alert('No Record Found.');
					return false;
				}
				var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x = '<div class="class-wise-report-section-main">'+
					'<div class="classwise-reportbox">'+
						'<table style="width:99.99%;" class="table class-wise-report-r">'+
							'<thead>'+
								'<tr>';
								if(response.data.school_id == 1){
									x  = x + '<th class="scholl-name-head" colspan="'+ parseInt(subject_list + 12) +'"><div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b></div></th>';
								}
								else{
									x  = x + '<th class="scholl-name-head" colspan="'+ parseInt(subject_list + 12) +'"><div class="header-sec-f"><b class="sv">Sharda Vidyalaya, Rishali, Bhilai, Chhattisgarh</b></div></th>';
								}
								x  = x +'</tr>'+
								'<tr>'+
								'<th style="background-color:#fff;">&nbsp;</th><th style="background-color:#ddd;" colspan="'+ parseInt(subject_list + 2) +'"><b>Marks Details of '+ type.toUpperCase() +' Assessment '+ $('#session  option:selected').text() +'</b></th><th style="background-color:#ddd;" colspan="'+ parseInt(subject_list + 2) +'"><b>Class:'+ response.data.s_list[0].cname +' '+ response.data.s_list[0].secname +' </b></th><th style="background-color:#fff;">&nbsp;</th>'+
								'</tr>'+
								'<tr>'+
									'<th colspan="7">Student info</th>'+
									'<th colspan="'+ subject_list +'">All Subjects</th>'+
									'<th>Total</th>'+
									'<th colspan="4" style="width:21%;">Final Results</th>'+
								'</tr>'+
								'<tr>'+
									'<th class="stu-info-s-no">S.No.</th>'+
									'<th class="stu-info-roll">Roll No.</th>'+
									'<th class="stu-info-adm">Adm No.</th>'+
								'<th class="stu-info">Student Name</th>'+
								'<th class="stu-info">Father Name</th>'+
								'<th class="stu-info">Mother Name</th>'+
								'<th class="stu-info-att">Att.</th>';
								$.each(response.data.s_list[0].marks,function(key,value){
										if(type == 'pre'){
											if(value.subject_name == 'FIT'){
												x = x + '<th class="stu-info"><b>'+ value.subject_name +' [40]</b></th>';
											}
											else{
												x = x + '<th class="stu-info"><b>'+ value.subject_name +' [20]</b></th>';
											}
										}
										else if(type == 'mid'){
											if(value.subject_name == 'FIT'){
												x = x + '<th class="stu-info"><b>'+ value.subject_name +' [40]</b></th>';
											}
											else{
												x = x + '<th class="stu-info"><b>'+ value.subject_name +' [80]</b></th>';
											}
										}
										else if(type == 'post_mid'){
											if(value.subject_name == 'FIT'){
												x = x + '<th class="stu-info"><b>'+ value.subject_name +' [50]</b></th>';
											}
											else{
												x = x + '<th class="stu-info"><b>'+ value.subject_name +' [50]</b></th>';
											}
										}
										else if(type == 'final'){
											if(value.subject_name == 'FIT'){
												x = x + '<th class="stu-info"><b>'+ value.subject_name +' [40]</b></th>';
											}
											else{
												x = x + '<th class="stu-info"><b>'+ value.subject_name +' [80]</b></th>';
											}
										}
									});
									x = x +
								'<th class="subject-name-f">Total</th>'+
								'<th class="class_9 subject-name-f" style="display:none;">FOIT</th>'+
								'<th class="subject-name-f">Result</th>'+
								'<th class="subject-name-f">Per(%)</th>'+
								'<th class="subject-name-f">Rank</th>'+
								'<th class="subject-name-f">Div</th>';
								if(type == 'mid' || type == "final"){
									x = x + '<th class="subject-name-f">Comp.</th>';
								}
								x = x +'</tr>'+
							'</thead>'+
							'<tbody>'+
								'<tr style="background-color:#f2f2f2;display:none;">'+
									'<td class="stu-info-t">'+
										'<div class="stu-info-s-no">S.No.</div>'+
										'<div class="stu-info-roll">Roll No.</div>'+
										'<div class="stu-info-adm">Adm No.</div>'+
										'<div class="stu-info">Student Name</div>'+
										'<div class="stu-info">Father Name</div>'+
										'<div class="stu-info">Mother Name</div>'+
										'<div class="stu-info-att">Att.</div>'+
									'</td>';
									$.each(response.data.s_list[0].marks,function(key,value){
										x = x + '<td><b>'+ value.subject_name +'</b></td>'; 
									});
									x = x +
									'<td>'+
										'<div class="subject-name-f">Total</div>'+
									'</td>'+
									'<td class="class_9" style="display:none;"><div class="subject-name-f">FOIT</div></td>'+
									'<td><div class="subject-name-f">Per(%)</div></td>'+
									'<td><div class="subject-name-f">Rank</div></td>'+
									'<td><div class="subject-name-f">Div</div></td>'+
									'<td><div class="subject-name-f">Comp.</div></td>'+
								'</tr>';
								var c = 1;
								var inner_loop = 1;
								$.each(response.data.s_list,function(key,value){
									x = x + '<tr>'+
												'<td><div class="stu-info-s-no">'+ c +'</div></td>'+
												'<td ><div class="stu-info-roll">'+ value.roll_no +'</div></td>'+
												'<td><div class="stu-info-adm">'+ value.admission_no +'</div></td>'+
												'<td><div class="stu-info">' + value.name + '</div></td>'+
												'<td><div class="stu-info">'+ value.fname +'</div></td>'+
												'<td><div class="stu-info">'+ value.mname +'</div></td>';
												if($('#class').val() != 12 || $('#class').val() != 14){
													x = x + '<td><div class="stu-info-att">'+ value.present +'</div></td>';
												}
												else{
													x = x + '<td><div class="stu-info-att">-</div></td>';
												}
												/*Result show */
												var pf_flag = 1;
												if (typeof(value.marks) == 'number') {
													pf_flag = 0;
												}
												$.each(value.marks,function(k,v){
													if(v.subject_id != 13){
														if(type == 'pre'){
															if(v.marks == 0 || v.marks == 'A' || v.marks < 7){
																pf_flag = 0;
															}
														}
														else if(type == 'mid'){
															if(v.marks == 0 || v.marks == 'A' || v.marks < 27){
																pf_flag = 0;
															}
														}
														else if(type == 'post_mid'){
															if(v.marks == 0 || v.marks == 'A' || v.marks < 17){
																pf_flag = 0;
															}
														}
														else if(type == 'final'){
															if(v.marks == 0 || v.marks == 'A' || v.marks < 27){
																pf_flag = 0;
															}
														}
													}
													if(v.marks == 'A'){
														x = x + '<td>'+
														'<div class="subject-name-f">Abst</div>'+
														'</td>';
													}
													else{
														x = x + '<td>'+
														'<div class="subject-name-f">'+ v.marks +'</div>'+
														'</td>';
													}
													
												});
												/*total section*/
												var perc = parseFloat((value.total_marks * 100)/parseInt(response.data['out_of'])).toFixed(2);
												var division = Math.floor(perc);
												x = x + '<td><div class="subject-name-f">'+ value.total_marks +'</div></td>'+
														'<td style="display:none;"><div class="subject-name-f">15</div></td>';
														var div;
														if(division > 59){
															div = '1st';
														}
														else if(division > 45 && perc < 60){
															div = '2nd';
														}
														else if(division > 33 && perc < 46){
															div = '3rd';
														}
														else{
															div = 'Fail';
														}
														
														if(pf_flag){
															x = x + '<td><div class="subject-name-f">Pass</div></td>'+
																'<td><div class="subject-name-f">'+ perc +'</div></td>'+
															'<td><div class="subject-name-f">'+ value.rank +'</div></td>'+
															'<td><div class="subject-name-f">'+ div +'</div></td>';
														}
														else{
															x = x + '<td><div class="subject-name-f">Fail</div></td>'+
																'<td><div class="subject-name-f">-</div></td>'+
															'<td><div class="subject-name-f">-</div></td>'+
															'<td><div class="subject-name-f">-</div></td>';
														}
												if(type == 'mid' || type == 'final'){
													$.each(response.data.computer,function(key,value){
														if(key+1 == c){
															if(value.mark == 5){
																grade = 'A';
															}
															else if(value.mark == 4){
																grade = 'B';
															}
															else if(value.mark == 3){
																grade = 'A';
															}
															else if(value.mark == 2){
																grade = 'B';
															}
															else if(value.mark == 1){
																grade = 'C';
															}
													x = x +'<td><div class="subject-name-f">'+ grade +'</div></td>';
														}
													});
												}
											x = x +'</tr>'; 
									c = c + 1;
								});
							x = x + '</tbody>'+
						'</table>'+
					'</div>'+
					
					'<div class="classwise-reportbox c-teacher-page-breck" style="margin-top:30px;">'+
					/*----------------------------------------*/
					'<h5 class="section-header-title page-break">Toppers at a Glance</h5>'+
						'<table class="table topper-sec-box class-wise-report-r text-center">'+
							'<thead>'+
								'<tr>'+
									'<th>S. No.</th>'+
									'<th>Roll No.</th>'+
									'<th>Name of Student</th>'+
									'<th>Total/Out of marks</th>'+
									'<th>Per(%)</th>'+
									'<th>Rank</th>'+
								'</tr>'+
							'</thead>'+
							'<tbody>';
							var c = 1;
							var number = 0;
							$.each(response.data.t_list,function(key,value){
								if(value.rank == 1 || value.rank == 2 || value.rank == 3)
								x = x + '<tr>'+
											'<td>'+ c +'.</td>'+
											'<td>'+ value.roll_no +'</td>'+
											'<td>'+ value.name +'</td>'+
											'<td>'+ value.total_marks +'/ '+ response.data['out_of'] +'</td>'+
											'<td>'+ (parseFloat(value.total_marks / response.data['out_of'] ) * 100).toFixed(2) +'</td>'+
											'<td>'+ value.rank +'</td>'+
										'</tr>';  
								c++;
							});
							x = x + '</tbody>'+
					  '</table></div>'+		
					/*----------------------------------------*/
					'<div style="margin-top:30px;width:100%;float:left;"><h5 class="section-header-title" >Class Abstract</h5>'+
					'<table class="table class-abstract-sec-box class-wise-report-r text-center"> '+
					'<thead>'+
						'<tr>'+
							'<th>S. No.</th>'+
							'<th>Teacher Name</th>'+
							'<th>Subjects</th>'+
							'<th>Total Students</th>'+
							'<th>Total App.</th>'+
							'<th>Pass</th>'+
							'<th>Pass%</th>'+
							'<th>Ist Div.</th>'+
							'<th>Per(%)</th>'+
							'<th>IInd Div.</th>'+
							'<th>III rd Div.</th>'+
							'<th>Fail</th>'+
							'<th>Highest Marks/</br>No. of Student</th>'+
							'<th>P.I.</th>'+
							'<th>Sign</th>'+
						'</tr>'+
					'</thead>'+
					'<tbody>';
					$.each(response.data.teacher_abstract ,function(key,value){
						var c = key + 1;
						x = x +'<tr>'+
									'<td>'+ c +'</td>'+
									'<td>'+ value.teacher +'</td>'+
									'<td>'+ value.subject +'</td>'+
									'<td>'+ value.total_student +'</td>'+
									'<td>'+ value.notapper +'</td>'+
									'<td>'+ value.total_pass +'</td>'+
									'<td>'+ value.pass_percent +'%</td>'+
									'<td>'+ value.first_div +'</td>'+
									'<td>'+ value.first_percent +'%</td>'+
									'<td>'+ value.second_div +'</td>'+
									'<td>'+ value.third_div +'</td>'+
									'<td>'+ value.fail +'</td>'+
									'<td>'+ value.max +'/'+ value.get_max +'</td>'+
									'<td>'+ value.pi +'</td>'+
									'<td>&nbsp;</td>'+
								'</tr>';
					});
					x = x + '</tbody>'+
				'</table></div>'+
				
					'<table class="table class-wise-footer-sign text-center"><tbody><tr><td style="vertical-align:middle;"><b>Class Teacher</b></td><td style="vertical-align:middle;"><b>I/C Incharge</b></td><td>';
						if(response.data.school_id == 2){
							x = x + '<img class="principle-sign" src="../../assest/images/sharda/PrinSign.png"><br/>'+
						'(Gajindra Bhoi) <br><b>Principal</b>';
						}
						else{
							x = x + '<img class="principle-sign" src="../../assest/images/shakuntala/PrinSign.png"><br/>'+
						'(Vipin Kumar) <br><b>Principal</b>';
						}
						x = x +
					'</td></tr></tbody></table>';
					
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
		
		
	}
});


/*classwise mid report section*/
//$(document).on('click','#classwise_mid',function(){
//	var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
//	var x = '<div class="class-wise-report-section-main">'+
//		'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:40px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>'+
//		'<div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"><b>Marks Details of Mid Assessment 2017-18</b></td><td><b>Class: IV A</b></td></tr></tbody></table></div>'+
//		'<div class="classwise-reportbox">'+
//		'<table style="width:99.99%;" class="table class-wise-report-r"><thead><tr><th style="width:46%;">Student info</th><th>English</th><th>Hindi</th><th>Maths</th><th>Total</th><th colspan="4" style="width:21%;">Final Results</th></tr></thead>'+
//		
//		'<tbody><tr style="background-color:#f2f2f2;"><td class="stu-info-t"><div class="stu-info-s-no">S.No.</div><div class="stu-info-roll">Roll No.</div><div class="stu-info-adm">Adm No.</div><div class="stu-info">Student Name</div><div class="stu-info">Father Name</div><div class="stu-info">Mother Name</div><div class="stu-info-att">Att.</div></td>'+
//		'<td><div class="subject-name-f">Mid</div></td>'+
//		'<td><div class="subject-name-f">Mid</div></td>'+
//		'<td><div class="subject-name-f">Mid</div></td>'+
//		'<td><div class="subject-name-f">Total</div></td>'+
//		'<td><div class="subject-name-f">FOIT</div><div class="subject-name-f">Result</div><div class="subject-name-f">Per(%)</div><div class="subject-name-f">Rank</div><div class="subject-name-f">Div</div><div class="subject-name-f">Comp.</div></td>'+
//		'</tr>'+
//		/*Result start student section*/
//		'<tr><td><div class="stu-info-s-no">1.</div><div class="stu-info-roll">142</div><div class="stu-info-adm">415</div><div class="stu-info">Ramesh ku Sharma</div><div class="stu-info">Mahesh Sharma</div><div class="stu-info">Sangeeta Sharma</div><div class="stu-info-att">142/115</div></td>'+
//		/*Result show */
//		'<td><div class="subject-name-f">15</div></td>'+
//		'<td><div class="subject-name-f">15</div></td>'+
//		'<td><div class="subject-name-f">15</div></td>'+
//		'<td><div class="subject-name-f">15</div></td>'+
//		
//		/*total section*/
//		'<td><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div></td>'+
//		
//		'</tr>'+
//		
//		'</tbody></table>'+
//		'</div>'+
//		
//		'<div class="classwise-reportbox">'+
//		/*----------------------------------------*/
//		'<h5 class="section-header-title">Toppers at a Glance</h5><table class="table topper-sec-box"> <thead><tr><th>S. No.</th><th>Roll No.</th><th>Name of Student</th><th>Total/Out of marks</th><th>Rank</th></tr></thead>'+
//		'<tbody>'+
//		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
//		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
//		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
//		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
//		'</tbody></table>'+		
//		/*----------------------------------------*/
//		'<h5 class="section-header-title">Class Abstract</h5><table class="table class-abstract-sec-box"> <thead><tr><th>S. No.</th><th>Teacher Name</th><th>Sub.</th><th>Total Students</th><th>Total App.</th><th>Pass</th><th>Pass%</th><th>Ist Div.</th><th>Per(%)</th><th>IInd Div.</th><th>III rd Div.</th><th>Fail</th><th>Highest Marks/No. of Student</th><th>P.I.</th><th>Sign</th></tr></thead>'+
//		'<tbody><tr><td>01.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
//		'<tr><td>01.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
//		'<tr><td>02.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
//		'<tr><td>03.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
//		'<tr><td>04.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
//		'<tr><td>05.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
//		'<tr><td>06.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
//		'</tbody></table>'+
//		
//		'<table class="table class-wise-footer-sign"><tbody><tr><td><b>Class Teacher</b></td><td><b>I/C Incharge</b></td></tr></tbody></table></div>';
//	x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
//			'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
//			'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">';
//	
//	 with(win.document){
//	      open();
//	      write(x);
//		      close();
//	    }
//});


/*Classwise post result section*/
$(document).on('click','#classwise_post',function(){
	var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
	var x = '<div class="class-wise-report-section-main">'+
		'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:40px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>'+
		'<div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"><b>Marks Details of Post Assessment 2017-18</b></td><td><b>Class: IV A</b></td></tr></tbody></table></div>'+
		'<div class="classwise-reportbox">'+
		'<table style="width:99.99%;" class="table class-wise-report-r"><thead><tr><th style="width:46%;">Student info</th><th>English</th><th>Hindi</th><th>Maths</th><th>Total</th><th colspan="4" style="width:21%;">Final Results</th></tr></thead>'+
		
		'<tbody><tr style="background-color:#f2f2f2;"><td class="stu-info-t"><div class="stu-info-s-no">S.No.</div><div class="stu-info-roll">Roll No.</div><div class="stu-info-adm">Adm No.</div><div class="stu-info">Student Name</div><div class="stu-info">Father Name</div><div class="stu-info">Mother Name</div><div class="stu-info-att">Att.</div></td>'+
		'<td><div class="subject-name-f">Post</div></td>'+
		'<td><div class="subject-name-f">Post</div></td>'+
		'<td><div class="subject-name-f">Post</div></td>'+
		'<td><div class="subject-name-f">Total</div></td>'+
		'<td><div class="subject-name-f">FOIT</div><div class="subject-name-f">Result</div><div class="subject-name-f">Per(%)</div><div class="subject-name-f">Rank</div><div class="subject-name-f">Div</div><div class="subject-name-f">Comp.</div></td>'+
		'</tr>'+
		/*Result start student section*/
		'<tr><td><div class="stu-info-s-no">1.</div><div class="stu-info-roll">142</div><div class="stu-info-adm">415</div><div class="stu-info">Ramesh ku Sharma</div><div class="stu-info">Mahesh Sharma</div><div class="stu-info">Sangeeta Sharma</div><div class="stu-info-att">142/115</div></td>'+
		/*Result show */
		'<td><div class="subject-name-f">15</div></td>'+
		'<td><div class="subject-name-f">15</div></td>'+
		'<td><div class="subject-name-f">15</div></td>'+
		'<td><div class="subject-name-f">15</div></td>'+
		
		/*total section*/
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div></td>'+
		
		'</tr>'+
		
		'</tbody></table>'+
		'</div>'+
		
		'<div class="classwise-reportbox">'+
		/*----------------------------------------*/
		'<h5 class="section-header-title">Toppers at a Glance</h5><table class="table topper-sec-box"> <thead><tr><th>S. No.</th><th>Roll No.</th><th>Name of Student</th><th>Total/Out of marks</th><th>Rank</th></tr></thead>'+
		'<tbody>'+
		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
		'</tbody></table>'+		
		/*----------------------------------------*/
		'<h5 class="section-header-title">Class Abstract</h5><table class="table class-abstract-sec-box"> <thead><tr><th>S. No.</th><th>Teacher Name</th><th>Sub.</th><th>Total Students</th><th>Total App.</th><th>Pass</th><th>Pass%</th><th>Ist Div.</th><th>Per(%)</th><th>IInd Div.</th><th>III rd Div.</th><th>Fail</th><th>Highest Marks/No. of Student</th><th>P.I.</th><th>Sign</th></tr></thead>'+
		'<tbody><tr><td>01.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>01.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>02.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>03.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>04.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>05.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>06.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'</tbody></table>'+
		
		'<table class="table class-wise-footer-sign"><tbody><tr><td><b>Class Teacher</b></td><td><b>I/C Incharge</b></td></tr></tbody></table></div>';
	x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
			'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
			'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">';
	
	 with(win.document){
	      open();
	      write(x);
		      close();
	    }
});

/*classwise Annual report section*/
$(document).on('click','#classwise_annual',function(){
	var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
	var x = '<div class="class-wise-report-section-main">'+
		'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:40px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>'+
		'<div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"><b>Marks Details of Annual Assessment 2017-18</b></td><td><b>Class: IV A</b></td></tr></tbody></table></div>'+
		'<div class="classwise-reportbox">'+
		'<table style="width:99.99%;" class="table class-wise-report-r"><thead><tr><th style="width:46%;">Student info</th><th>English</th><th>Hindi</th><th>Maths</th><th>Total</th><th colspan="4" style="width:21%;">Final Results</th></tr></thead>'+
		
		'<tbody><tr style="background-color:#f2f2f2;"><td class="stu-info-t"><div class="stu-info-s-no">S.No.</div><div class="stu-info-roll">Roll No.</div><div class="stu-info-adm">Adm No.</div><div class="stu-info">Student Name</div><div class="stu-info">Father Name</div><div class="stu-info">Mother Name</div><div class="stu-info-att">Att.</div></td>'+
		'<td><div class="subject-name-f">Annual</div></td>'+
		'<td><div class="subject-name-f">Annual</div></td>'+
		'<td><div class="subject-name-f">Annual</div></td>'+
		'<td><div class="subject-name-f">Total</div></td>'+
		'<td><div class="subject-name-f">FOIT</div><div class="subject-name-f">Result</div><div class="subject-name-f">Per(%)</div><div class="subject-name-f">Rank</div><div class="subject-name-f">Div</div><div class="subject-name-f">Comp.</div></td>'+
		'</tr>'+
		/*Result start student section*/
		'<tr><td><div class="stu-info-s-no">1.</div><div class="stu-info-roll">142</div><div class="stu-info-adm">415</div><div class="stu-info">Ramesh ku Sharma</div><div class="stu-info">Mahesh Sharma</div><div class="stu-info">Sangeeta Sharma</div><div class="stu-info-att">142/115</div></td>'+
		/*Result show */
		'<td><div class="subject-name-f">15</div></td>'+
		'<td><div class="subject-name-f">15</div></td>'+
		'<td><div class="subject-name-f">15</div></td>'+
		'<td><div class="subject-name-f">15</div></td>'+
		
		/*total section*/
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div><div class="subject-name-f">15</div></td>'+
		
		'</tr>'+
		
		'</tbody></table>'+
		'</div>'+
		
		'<div class="classwise-reportbox">'+
		/*----------------------------------------*/
		'<h5 class="section-header-title">Toppers at a Glance</h5><table class="table topper-sec-box"> <thead><tr><th>S. No.</th><th>Roll No.</th><th>Name of Student</th><th>Total/Out of marks</th><th>Rank</th></tr></thead>'+
		'<tbody>'+
		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
		'<tr><td>01.</td><td>1245</td><td>Rakesh Sharma</td><td>500/498</td><td>1st</td></tr>'+
		'</tbody></table>'+		
		/*----------------------------------------*/
		'<h5 class="section-header-title">Class Abstract</h5><table class="table class-abstract-sec-box"> <thead><tr><th>S. No.</th><th>Teacher Name</th><th>Sub.</th><th>Total Students</th><th>Total App.</th><th>Pass</th><th>Pass%</th><th>Ist Div.</th><th>Per(%)</th><th>IInd Div.</th><th>III rd Div.</th><th>Fail</th><th>Highest Marks/No. of Student</th><th>P.I.</th><th>Sign</th></tr></thead>'+
		'<tbody><tr><td>01.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>01.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>02.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>03.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>04.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>05.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'<tr><td>06.</td><td>Anita Sharma</td><td>Hindi</td><td>65</td><td>60</td><td>59</td><td>80%</td><td>10</td><td>8%</td><td>10</td><td>15</td><td>10</td><td>99/68</td><td>152</td><td>&nbsp;</td></tr>'+
		'</tbody></table>'+
		
		'<table class="table class-wise-footer-sign"><tbody><tr><td><b>Class Teacher</b></td><td><b>I/C Incharge</b></td></tr></tbody></table></div>';
	x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
			'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
			'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">';
	
	 with(win.document){
	      open();
	      write(x);
		      close();
	    }
});

$(document).on('change','#class',function(){
	c_id = $(this).val();
	if(c_id == 12 || c_id == 13){
		$('#fit_section').css('display','block');
	}
	else{
		$('#fit_section').css('display','none');
	}
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