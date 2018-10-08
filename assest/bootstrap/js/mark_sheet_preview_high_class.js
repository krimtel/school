var baseUrl = $('#base_url').val();

var formvalid = true;
$(document).on('click','.classwise_pre',function(){
	var type = $(this).data('type');
	
	if($('#session').val() == 0){
		formvalid = false;
		$('#session_err').html('Please select Session.').css('display','block');
	}
	if($('#medium').val() == 0){
		formvalid = false;
		$('#medium_err').html('Please select Medium.').css('display','block');
	}
	if($('#class').val() == 0){
		formvalid = false;
		$('#class_err').html('Please select class.').css('display','block');
	}
	if($('#section').val() == 0){
		formvalid = false;
		$('#section_err').html('Please select section.').css('display','block');
	}
	if($('#s_group').val() == 0){
		formvalid = false;
		$('#s_group_err').html('Please select subject group.').css('display','block');
	}
	
	if(formvalid){
		$.ajax({
			type: 'POST',
			url: baseUrl+'Student_ctrl/classwise_pre_high_class',
			dataType: "json",
			data: {
				'c_id' : $('#class').val(),
				'section' : $('#section').val(),
				'medium' : $('#medium').val(),
				'session' : $('#session').val(),
				'type' : type,
				's_group': $('#s_group').val()
			},
			beforeSend: function(){
				$('#loader').modal('show');
				
			},
			success:  function (response) {
				if($('#class').val() == 14 && type == 'final_fard'){
					final_fard_11th(response);
					return false;
				}
				$('#loader').modal('toggle');
				var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x = '<div class="class-wise-report-section-main">'+
					'<div class="classwise-reportbox">'+
						
					'<table style="width:99.99%;" class="table class-wise-report-r">'+
							'<thead>'+
								'<tr>';
								if(response.data.student_with_rank[0].school_id == 1){
									x  = x + '<th class="scholl-name-head" colspan="17"><div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b></div></th>';
								}
								else{
									x  = x + '<th class="scholl-name-head" colspan="17"><div class="header-sec-f"><b class="sv">Sharda Vidyalaya, Rishali, Bhilai, Chhattisgarh</b></div></th>';
								}
								x  = x +'</tr>'+
								'<tr>'+
								'<th style="background-color:#fff;">&nbsp;</th><th style="background-color:#ddd;" colspan="7"><b>Marks Details of Assessment </b></th><th style="background-color:#ddd;" colspan="8"><b>Class:'+ response.data.student_with_rank[0].cname +' '+ response.data.student_with_rank[0].secname +' </b></th><th style="background-color:#fff;">&nbsp;</th>'+
								'</tr>'+
								'<tr>'+
									'<th colspan="7">Student info</th>'+
									'<th colspan="5">All Subjects</th>'+
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
								$.each(response.data.student_with_rank[0].marks,function(key,value){
									x = x + '<th class="stu-info"><b>'+ value.sub_name +' ['+ value.subj_marks +']</b></th>';
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
									$.each(response.data.student_with_rank[0].marks,function(key,value){
										x = x + '<td><b>'+ value.sub_name +'</b></td>'; 
									});
									x = x +								
									'<td>'+
										'<div class="subject-name-f">Total</div>'+
									'</td>'+
									'<td><div class="subject-name-f">Per(%)</div></td>'+
									'<td><div class="subject-name-f">Rank</div></td>'+
									'<td><div class="subject-name-f">Div</div></td>'+
									'<td><div class="subject-name-f">Comp.</div></td>'+
								'</tr>';
								var c = 1;
								var inner_loop = 1;
								$.each(response.data.student_with_rank,function(key,value){
									var present = value.present;
									if(present == null){
									    present = '';
									}
									x = x + '<tr>'+
												'<td><div class="stu-info-s-no">'+ c +'</div></td>'+
												'<td ><div class="stu-info-roll">'+ value.roll_no +'</div></td>'+
												'<td><div class="stu-info-adm">'+ value.admission_no +'</div></td>'+
												'<td><div class="stu-info">' + value.name.toUpperCase() + '</div></td>'+
												'<td><div class="stu-info">'+ value.father_name.toUpperCase() +'</div></td>'+
												'<td><div class="stu-info">'+ value.mother_name.toUpperCase() +'</div></td>'+
												'<td><div class="stu-info-att">'+ present +'</div></td>';
												/*Result show */
												var pf_flag = 1;
												$.each(value.marks,function(k,v){
													if(type == 'pre'){
														if(v.marks == 0 || v.marks == 'A' || v.marks < 7){
															pf_flag = 0;
														}
													}
													if(type == 'post_mid'){
														if(v.marks == 0 || v.marks == 'A' || v.marks < 17){
															pf_flag = 0;
														}
													}
													else if(type == 'mid'){
														if(value.flag == 0){
															pf_flag = 0;
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
												var perc = parseFloat((value.total * 100)/parseInt(value.out_of)).toFixed(2);
												x = x + '<td><div class="subject-name-f">'+ value.total +'</div></td>'+
														'<td style="display:none;"><div class="subject-name-f">15</div></td>';
														var div;
														if(parseFloat(perc) >= 60){
															div = '1st';
														}
														else if(parseFloat(perc) >= 45 && parseFloat(perc) <= 59){
															div = '2nd';
														}
														else if(parseFloat(perc) >= 33 && parseFloat(perc) <= 44){
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
							$.each(response.data.top_list,function(key,value){
								if(value.rank == 1 || value.rank == 2 || value.rank == 3)
								x = x + '<tr>'+
											'<td>'+ c +'.</td>'+
											'<td>'+ value.roll_no +'</td>'+
											'<td>'+ value.name +'</td>'+
											'<td>'+ value.total +'/ '+ value.out_of +'</td>'+
											'<td>'+ (parseFloat(value.total / value.out_of ) * 100).toFixed(2) +'</td>'+
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
				console.log(response);
				 with(win.document){
				      open();
				      write(x);
					      close();
				    }
			}
		});
		
		
	}
});

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


/*class wise pre mid result*/
$(document).on('click','#classwise_pre_mid',function(){
	var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
	var x = '<div class="class-wise-report-section-main">'+
		'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:40px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>'+
		'<div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"><b>Marks Details of Pre Mid Assessment 2017-18</b></td><td><b>Class: IV A</b></td></tr></tbody></table></div>'+
		'<div class="classwise-reportbox">'+
		'<table style="width:99.99%;" class="table class-wise-report-r"><thead><tr><th  style="width:46%;">Student info</th><th>English</th><th>Hindi</th><th>Maths</th><th>Total</th><th colspan="4" style="width:21%;">Final Results</th></tr></thead>'+
		
		'<tbody><tr style="background-color:#f2f2f2;"><td class="stu-info-t"><div class="stu-info-s-no">S.No.</div><div class="stu-info-roll">Roll No.</div><div class="stu-info-adm">Adm No.</div><div class="stu-info">Student Name</div><div class="stu-info">Father Name</div><div class="stu-info">Mother Name</div><div class="stu-info-att">Att.</div></td>'+
		'<td><div class="subject-name-f">Pre</div><div class="subject-name-f">Mid</div></td>'+
		'<td><div class="subject-name-f">Pre</div><div class="subject-name-f">Mid</div></td>'+
		'<td><div class="subject-name-f">Pre</div><div class="subject-name-f">Mid</div></td>'+
		'<td><div class="subject-name-f">Total</div></td>'+
		'<td><div class="subject-name-f">FOIT</div><div class="subject-name-f">Result</div><div class="subject-name-f">Per(%)</div><div class="subject-name-f">Rank</div><div class="subject-name-f">Div</div><div class="subject-name-f">Comp.</div></td>'+
		'</tr>'+
		/*Result start student section*/
		'<tr><td><div class="stu-info-s-no">1.</div><div class="stu-info-roll">142</div><div class="stu-info-adm">415</div><div class="stu-info">Ramesh ku Sharma</div><div class="stu-info">Mahesh Sharma</div><div class="stu-info">Sangeeta Sharma</div><div class="stu-info-att">142/115</div></td>'+
		/*Result show */
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">15</div></td>'+
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">15</div></td>'+
		'<td><div class="subject-name-f">15</div><div class="subject-name-f">15</div></td>'+
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
////////////////////////////////////////////////////////////////////////

function final_fard_11th(response){
	console.log(response);
	var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
	var x = '<div class="class-wise-report-section-main">'+
		'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:25px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>'+
		'<div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"><b>Marks Details of Annual Assessment 2017-18</b></td><td><b>Class: '+ $('#class  option:selected').text() +' '+ $('#section option:selected').text() +'</b></td></tr></tbody></table></div>'+
		'<div class="classwise-reportbox">'+
		'<table style="width:99.99%;" class="table class-wise-report-r"><thead>'+
			'<tr><th colspan="4">Student info</th>'+
				'<th colspan="5" style="border-right: 1px solid #c5c5c5;border-left: 1px solid #c5c5c5;">Pre(5)</th>'+
				'<th colspan="5" style="border-right: 1px solid #c5c5c5;">Mid(20)</th>'+
				'<th colspan="5" style="border-right: 1px solid #c5c5c5;">Post(5)</th>'+
				'<th colspan="5" style="border-right: 1px solid #c5c5c5;">Annual(60)</th>'+
				'<th colspan="5" style="border-right: 1px solid #c5c5c5;">Acad.  Att. (10)</th>'+
				'<th colspan="5" style="border-right: 1px solid #c5c5c5;">Grand Total</th>'+
				'<th colspan="5" >Final Results</th>'+
			'</tr></thead>'+
		'<tbody>'+
		'<tr style="background-color:#f2f2f2;">'+
		'<td style="border-right: 1px solid #c5c5c5;">S.No.</td><td style="border-right: 1px solid #c5c5c5;">Roll No.</td><td style="border-right: 1px solid #c5c5c5;">Adm No.</td><td style="border-right: 1px solid #c5c5c5;">Student Name</td><!--<td style="border-right: 1px solid #c5c5c5;">Father Name</td><td style="border-right: 1px solid #c5c5c5;">Mother Name</td>-->';
			var sub_count = 0;
			$.each(response.data[0].final_marks,function(k,v){
				if(sub_count == 1){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">(Elective)</td>';
				}
				else if(sub_count == 2){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">M/B</td>';
				}
				else{
					x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ v.subject_name +'</td>';
				}
				sub_count = sub_count + 1; 
			});
			
			var sub_count = 0;
			$.each(response.data[0].final_marks,function(k,v){
				if(sub_count == 1){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">(Elective)</td>';
				}
				else if(sub_count == 2){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">M/B</td>';
				}
				else{
					x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ v.subject_name +'</td>';
				}
				sub_count = sub_count + 1; 
			});
			
			var sub_count = 0;
			$.each(response.data[0].final_marks,function(k,v){
				if(sub_count == 1){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">(Elective)</td>';
				}
				else if(sub_count == 2){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">M/B</td>';
				}
				else{
					x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ v.subject_name +'</td>';
				}
				sub_count = sub_count + 1; 
			});
			
			var sub_count = 0;
			$.each(response.data[0].final_marks,function(k,v){
				if(sub_count == 1){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">(Elective)</td>';
				}
				else if(sub_count == 2){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">M/B</td>';
				}
				else{
					x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ v.subject_name +'</td>';
				}
				sub_count = sub_count + 1; 
			});
			
			var sub_count = 0;
			$.each(response.data[0].final_marks,function(k,v){
				if(sub_count == 1){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">(Elective)</td>';
				}
				else if(sub_count == 2){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">M/B</td>';
				}
				else{
					x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ v.subject_name +'</td>';
				}
				sub_count = sub_count + 1; 
			});
			
			var sub_count = 0;
			$.each(response.data[0].final_marks,function(k,v){
				if(sub_count == 1){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">(Elective)</td>';
				}
				else if(sub_count == 2){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">M/B</td>';
				}
				else{
					x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ v.subject_name +'</td>';
				}
				sub_count = sub_count + 1;
			});
			
		x = x +
		'<td style="border-right: 1px solid #c5c5c5;">Aggr.</td><td style="border-right: 1px solid #c5c5c5;">Result</td><td style="border-right: 1px solid #c5c5c5;">Per(%)</td><td style="border-right: 1px solid #c5c5c5;">Rank</td><td style="border-right: 1px solid #c5c5c5;">Div</td>'+
		'</tr>';
		/*Result start student section*/
		var counter = 1;
		$.each(response.data,function(key,value){
			x = x +'<tr>'+
				'<td>'+ counter +'.</td>'+
				'<td>'+ value.student.roll_no +'</td>'+
				'<td>'+ value.student.admission_no +'</td>'+
				'<td>'+ value.student.name +'</td>';
				var sub_count = 0;
				$.each(value.final_marks,function(k,v){
					if(sub_count == 1 ||sub_count == 2){
						x = x + '<td>['+v.subject_name+'] '+ v.pre_5 +'</td>';
					}else{
						x = x + '<td>'+ v.pre_5 +'</td>';
					}
					sub_count = sub_count + 1;
				});
				
				var sub_count = 0;
				$.each(value.final_marks,function(k,v){
					if(sub_count == 1||sub_count == 2){
						x = x + '<td>['+v.subject_name+'] '+ v.mid_20 +'</td>';
					}else{
						x = x + '<td>'+ v.mid_20 +'</td>';
					}
					sub_count = sub_count + 1;
				});
				
				var sub_count = 0;
				$.each(value.final_marks,function(k,v){
					if(sub_count == 1||sub_count == 2){
						x = x + '<td>['+v.subject_name+'] '+ v.post_5 +'</td>';
					}else{
						x = x + '<td>'+ v.post_5 +'</td>';
					}
					sub_count = sub_count + 1;
				});
				
				var sub_count = 0;
				$.each(value.final_marks,function(k,v){
					if(sub_count == 1||sub_count == 2){
						x = x + '<td>['+v.subject_name+'] '+ v.final_thory_60 +'</td>';
					}else{
						x = x + '<td>'+ v.final_thory_60 +'</td>';
					}
					sub_count = sub_count + 1;
				});
				
				var sub_count = 0;
				$.each(value.final_marks,function(k,v){
					if(sub_count == 1||sub_count == 2){
						x = x + '<td>['+v.subject_name+'] '+ v.academic_attention +'</td>';
					}
					else{
						x = x + '<td>'+ v.academic_attention +'</td>';
					}
					sub_count = sub_count + 1;
				});
				
				
				$.each(value.final_marks,function(k,v){
					x = x + '<td>'+ v.grand_total +'</td>';
				});
			
				x = x + '<td>'+ value.aggrigate +'</td>';
				
				
				var category = '';
				var y = '';
				if(typeof value.back != 'undefined'){
					if(value.back.length > 0 && value.back.length < 3){
						$.each(value.back,function(k1,v1){
							y = y +'</br>'+ v1 +',';
						});
						
						y = y.slice(0, -1)
						category = '<td>Comp.('+ y + ')</td>';
						x =x + category +
						'<td>-</td>'+
						'<td>-</td>'+
						'<td>-</td>';
					}
					else if(value.back.length > 2){
						category = '<td>Fail</td>';
						x =x + category +
						'<td>-</td>'+
						'<td>-</td>'+
						'<td>-</td>';
					}
					else{
						x =x + '<td>Pass</td>'+
						'<td>'+ value.percent +'</td>'+
						'<td>'+ value.rank +'</td>'+
						'<td>'+ value.div +'</td>';
					}
				}
				else{
					category = '<td><b>Pass</b></td>';
					x =x + category +
					'<td>'+ value.percent +'</td>'+
					'<td>'+ value.rank +'</td>'+
					'<td>'+ value.div +'</td>';
				}
				
			x = x + '</tr>';
		counter = counter + 1;
		});
		x = x + '</tbody></table>'+
		'</div>'+
		
		'<div class="classwise-reportbox">'+
		/*----------------------------------------*/
		'<h5 class="section-header-title">Toppers at a Glance</h5><table class="table topper-sec-box"> <thead><tr><th>S. No.</th><th>Roll No.</th><th>Name of Student</th><th>Total/Out of marks</th><th>Rank</th></tr></thead>'+
		'<tbody>';
		var c = 1;
		var number = 0;
		$.each(response.data,function(key,value){
			if(value.rank == 1){
				x = x + '<tr><td>'+ c +'.</td><td>'+ value.student.roll_no +'</td><td>'+ value.student.name +'</td><td>'+ value.aggrigate +'/500</td><td>'+ value.rank +'</td></tr>';
				c++;
			}
		});
		
		$.each(response.data,function(key,value){
			if(value.rank == 2){
				x = x + '<tr><td>'+ c +'.</td><td>'+ value.student.roll_no +'</td><td>'+ value.student.name +'</td><td>'+ value.aggrigate +'/500</td><td>'+ value.rank +'</td></tr>';
				c++;
			}
		});
		
		$.each(response.data,function(key,value){
			if(value.rank == 3){
				x = x + '<tr><td>'+ c +'.</td><td>'+ value.student.roll_no +'</td><td>'+ value.student.name +'</td><td>'+ value.aggrigate +'/500</td><td>'+ value.rank +'</td></tr>';
				c++;
			}
		});
		x = x + '</tbody></table>'+		
		
		
		'<table class="table class-wise-footer-sign"><tbody><tr><td><b>Class Teacher</b></td><td><b>I/C Incharge</b></td></tr></tbody></table></div>';
	x = x + '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/bootstrap/css/bootstrap.min.css">'+
			'<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assest/css/marksheet-result.css">'+
			'<link rel="stylesheet" type="text/css" media="print" href="'+ baseUrl +'assest/css/marksheet-result-print.css">';
	
	 with(win.document){
	      open();
	      write(x);
		      close();
	    }
}

////////////////////////////////////////////////////////////////////////
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