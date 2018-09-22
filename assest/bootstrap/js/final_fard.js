/*classwise final report section*/
var formvalid = true;
$(document).on('click','#classwise_final',function(){
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
			url: baseUrl+'Student_ctrl/final_fard_1_8',
			dataType: "json",
			data: {
				'c_id' : $('#class').val(),
				'section' : $('#section').val(),
				'medium' : $('#medium').val(),
				'session' : $('#session').val()
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				if($('#class').val() == 12){
					ninth_final_fard(response);
					return false;
				}
				console.log(response);
				var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x = '<div class="class-wise-report-section-main">'+
					'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:25px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>'+
					'<div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"><b>Marks Details of Annual Assessment 2017-18</b></td><td><b>Class: '+ $('#class  option:selected').text() +' '+ $('#section option:selected').text() +'</b></td></tr></tbody></table></div>'+
					'<div class="classwise-reportbox">'+
					'<table style="width:99.99%;" class="table class-wise-report-r"><thead>'+
						'<tr><th colspan="5">Student info</th><th colspan="'+ response.data[0].marks.length +'" style="border-right: 1px solid #c5c5c5;border-left: 1px solid #c5c5c5;">Term I</th><th colspan="'+ response.data[0].marks.length +'" style="border-right: 1px solid #c5c5c5;">Term II</th>'+
							'<th colspan="6" >Final Results</th>'+
						'</tr></thead>'+
					'<tbody>'+
					'<tr style="background-color:#f2f2f2;">'+
					'<td style="border-right: 1px solid #c5c5c5;">S.No.</td><td style="border-right: 1px solid #c5c5c5;">Roll No.</td><td style="border-right: 1px solid #c5c5c5;">Adm No.</td><td style="border-right: 1px solid #c5c5c5;">Student Name</td><td style="border-right: 1px solid #c5c5c5;">Att.</td><!--<td style="border-right: 1px solid #c5c5c5;">Father Name</td><td style="border-right: 1px solid #c5c5c5;">Mother Name</td>-->';
					$.each(response.data[0].marks,function(key,value){
								x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ value.name +'</td>';
							});
							$.each(response.data[0].marks,function(key,value){
								x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ value.name +'</td>';
							});
							x =x ;
					x = x +
					'<td style="border-right: 1px solid #c5c5c5;">Aggr.</td><td style="border-right: 1px solid #c5c5c5;">Result</td><td style="border-right: 1px solid #c5c5c5;">Per(%)</td><td style="border-right: 1px solid #c5c5c5;">Rank</td><td style="border-right: 1px solid #c5c5c5;">Div</td><td >Comp.</td>'+
					'</tr>';
					/*Result start student section*/
					var counter = 1;
					$.each(response.data,function(key,value){
						x = x +'<tr>'+
							'<td>'+ counter +'.</td>'+
							'<td>'+ value.student[0].roll_no +'</td>'+
							'<td>'+ value.student[0].admission_no +'</td>'+
							'<td>'+ value.student[0].name +'</td>'+
							//'<td>'+ value.student[0].father_name +'</td>'+
							//'<td>'+ value.student[0].mother_name +'</td>'+
							'<td>'+ value.student[0].presentday +'</td>';
							$.each(value.marks,function(k,v){
								x = x + '<td>'+ v.term_1_total +'</td>'; 
							});
							$.each(value.marks,function(k,v){
								x = x + '<td>'+ v.term_2_total +'</td>'; 
							});
							x = x + '<td>'+ value.G_total +'</td>';
									if(typeof(value.back)!= "undefined" && value.back != null){
										var y = '';
										$.each(value.back,function(k,v){
											y = y + v.name +',';
										});
										x = x + '<td>'+ y +'</td>';
										x = x +'<td>-</td>'+
										'<td>-</td>'+
										'<td>-</td>'+
										'<td>-</td>';
									}
									else{
										x = x +'<td>'+ value.result +'</td>';
										x = x +'<td>'+ value.percent +'</td>'+
										'<td>'+ value.rank +'</td>'+
										'<td>'+ value.div +'</td>'+
										'<td>'+ value.computer +'</td>';
									}
							
						'</tr>';
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
							x = x + '<tr><td>'+ c +'.</td><td>'+ value.student[0].roll_no +'</td><td>'+ value.student[0].name +'</td><td>'+ value.G_total +'/'+ value.outoff +'</td><td>'+ value.rank +'</td></tr>';
							c++;
						}
					});
					
					$.each(response.data,function(key,value){
						if(value.rank == 2){
							x = x + '<tr><td>'+ c +'.</td><td>'+ value.student[0].roll_no +'</td><td>'+ value.student[0].name +'</td><td>'+ value.G_total +'/'+ value.outoff +'</td><td>'+ value.rank +'</td></tr>';
							c++;
						}
					});
					
					$.each(response.data,function(key,value){
						if(value.rank == 3){
							x = x + '<tr><td>'+ c +'.</td><td>'+ value.student[0].roll_no +'</td><td>'+ value.student[0].name +'</td><td>'+ value.G_total +'/'+ value.outoff +'</td><td>'+ value.rank +'</td></tr>';
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
		});
	}
});



/*class wise pre mid result*/
$(document).on('click','#classwise_pre_mid',function(){
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
			url: baseUrl+'Student_ctrl/term2_fard',
			dataType: "json",
			data: {
				'c_id' : $('#class').val(),
				'section' : $('#section').val(),
				'medium' : $('#medium').val(),
				'session' : $('#session').val()
			},
			beforeSend: function(){
				
			},
			success:  function (response) {
				console.log(response);
				var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x = '<div class="class-wise-report-section-main">'+
					'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:25px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>'+
					'<div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"><b>Marks Details of Annual Assessment 2017-18</b></td><td><b>Class: IV A</b></td></tr></tbody></table></div>'+
					'<div class="classwise-reportbox">'+
					'<table style="width:99.99%;" class="table class-wise-report-r"><thead>'+
						'<tr><th style="width:46%;">Student info</th>';
							$.each(response.data.s_list[0].marks,function(key,value){
								x = x + '<th>'+ value.subject_name +'</th>';
							});
							x =x +'<th colspan="4" style="width:21%;">Final Results</th>'+
						'</tr></thead>'+
					'<tbody>'+
					'<tr style="background-color:#f2f2f2;">'+
					'<td class="stu-info-t"><div class="stu-info-s-no">S.No.</div><div class="stu-info-roll">Roll No.</div><div class="stu-info-adm">Adm No.</div><div class="stu-info">Student Name</div><div class="stu-info">Father Name</div><div class="stu-info">Mother Name</div><div class="stu-info-att">Att.</div></td>';
					$.each(response.data.s_list[0].marks,function(key,value){
						x = x + '<td><div class="subject-name-f">Post</div><div class="subject-name-f">Final</div></td>';
					});
					
					x = x +'<td><div class="subject-name-f">Total</div></td>'+
					'<td><div class="subject-name-f">Result</div></td><td><div class="subject-name-f">Per(%)</div></td><td><div class="subject-name-f">Rank</div></td><td><div class="subject-name-f">Div</div></td>'+
					'</tr>';
					/*Result start student section*/
					var counter = 1;
					$.each(response.data.s_list,function(key,value){
						x = x +'<tr>'+
						'<td>'+
							'<div class="stu-info-s-no">'+ counter +'.</div>'+
							'<div class="stu-info-roll">'+ value.roll_no +'</div>'+
							'<div class="stu-info-adm">'+ value.admission_no +'</div>'+
							'<div class="stu-info">'+ value.name +'</div>'+
							'<div class="stu-info">'+ value.fname +'</div>'+
							'<div class="stu-info">'+ value.mname +'</div>'+
							'<div class="stu-info-att">'+ value.present +'</div>'+
						'</td>';
					/*Result show */
					
						var pf_flag = 1;
						if (typeof(value.marks) == 'number') {
							pf_flag = 0;
						}
						$.each(value.marks,function(k,v){
							if(v.subject_id != 13){
								 if(v.marks_post){
									if(v.marks == 0 || v.marks == 'A' || v.marks < 17){
										pf_flag = 0;
									}
								}
								else if(v.marks_final){
									if(v.marks == 0 || v.marks == 'A' || v.marks < 27){
										pf_flag = 0;
									}
								}
							}
							if(v.marks_post == 'A'){
								x =x + '<td><div class="subject-name-f">Abst</div>';
							}
							else{
								x =x + '<td><div class="subject-name-f">'+ v.marks_post +'</div>';
							}
							
							if(v.marks_final == 'A'){
								x = x + '<div class="subject-name-f">Abst</div></td>';
							}
							else{
								x =x + '<div class="subject-name-f">'+ v.marks_final +'</div></td>';
							}
						});
							
									
					/*total section*/
					x = x +'<td><div class="subject-name-f">'+ value.total_marks +'</div></td>';
							if(typeof(value.p_f) != "undefined" && value.p_f !== null){
								x = x +'<td><div class="subject-name-f">Fail</div></td>';
								x = x +'<td><div class="subject-name-f">-</div></td>'+
								'<td><div class="subject-name-f">-</div></td>';
								x = x +'<td><div class="subject-name-f">-</div></td>';
							}
							else{
								x = x +'<td><div class="subject-name-f">pass</div></td>';
								x = x +'<td><div class="subject-name-f">'+ parseFloat((value.total_marks * 100)/parseInt(value.outoff_marks)).toFixed(2) +'</div></td>'+
								'<td><div class="subject-name-f">'+ value.rank +'</div></td>';
								var perc = parseFloat((value.total_marks * 100)/parseInt(value.outoff_marks)).toFixed(2);
								if(perc >= 60){
									x = x +'<td><div class="subject-name-f">1st</div></td>';
								}
								else if(perc >= 45 && perc <= 59){
									x = x +'<td><div class="subject-name-f">2nd</div></td>';
								}
								else if(perc >= 33 && perc <= 44){
									x = x +'<td><div class="subject-name-f">3rd</div></td>';
								}
								else{
									x = x +'<td><div class="subject-name-f">Fail</div></td>';
								}
							}
						x = x + '</td>'+
					
					'</tr>';
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
					$.each(response.data.t_list,function(key,value){
						if(value.rank == 1 || value.rank == 2 || value.rank == 3)
						x = x + '<tr>'+
									'<td>'+ c +'.</td>'+
									'<td>'+ value.roll_no +'</td>'+
									'<td>'+ value.name +'</td>'+
									'<td>'+ value.total_marks +'/ '+ value.outoff_marks +'</td>'+
									'<td>'+ (parseFloat(value.total_marks / value.outoff_marks ) * 100).toFixed(2) +'</td>'+
									'<td>'+ value.rank +'</td>'+
								'</tr>';  
						c++;
					});
					x = x +'</tbody></table>'+		
					/*----------------------------------------*/
				
					
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
		});
	}
});


function ninth_final_fard(response){
	console.log(response);
	var win = window.open(baseUrl+'application/views/pages/production/mid_result', "myWindowName", "scrollbars=1,width=1200, height=600");
	var x = '<div class="class-wise-report-section-main">'+
		'<style>.class-wise-report-section-main{float:left;width:100%;font-size:12px;} .classwise-reportbox{width:100%;float:left;} .class-wise-report-r{font-size:12px;} .class-wise-report-r thead tr th{text-align:center;background-color:#f1f1f1;} .class-wise-report-r tr td{border:1px solid #eee;padding:5px 3px !important;} .header-sec-f{text-align:center;padding:15px 50px 0 50px;float:left;width:100%;} .header-sec-f .sv{font-size:18px;} .stu-info-t{width:35%;font-size:12px;} .stu-info{float:left;width:117px;font-size:11px;} .subject-name-f{float:left;width:25px;font-size:11px;} .stu-info-s-no{float:left;width:35px;font-size:11px;} .stu-info-roll,.stu-info-adm{float:left;width:44px;font-size:11px;}.stu-info-att{float:left;width:45px;font-size:11px;} .section-header-title{background-color: #f1f1f1;    padding: 10px;font-weight: 600;width: 25%;margin:0;font-size:13px;} .topper-sec-box{width:65% !important;border:1px solid #ddd;font-size:12px;} .topper-sec-box thead tr th{background-color:#eee;padding:5px!important;} .topper-sec-box tr td{padding:5px!important;} .class-abstract-sec-box{border:1px solid #ddd;font-size:12px;} .class-abstract-sec-box thead tr th{background-color:#eee;padding:5px!important;} .class-abstract-sec-box tr td{padding:5px!important;} .class-wise-footer-sign{font-size:12px;border:1px solid #ddd;}</style>'+
		'<div class="header-sec-f"><b class="sv">Shakuntala Vidyalaya, Ramnagar, Bhilai, Chhattisgarh</b><br><table class="table" style="margin-bottom:0;margin-top:10px;font-size:14px;background-color:#ddd;text-align:center;"><tbody><tr><td style="width:50%;"><b>Marks Details of Annual Assessment 2017-18</b></td><td><b>Class: '+ $('#class  option:selected').text() +' '+ $('#section option:selected').text() +'</b></td></tr></tbody></table></div>'+
		'<div class="classwise-reportbox">'+
		'<table style="width:99.99%;" class="table class-wise-report-r"><thead>'+
			'<tr><th colspan="4">Student info</th><th colspan="5" style="border-right: 1px solid #c5c5c5;border-left: 1px solid #c5c5c5;">Periodic Test</th><th colspan="5" style="border-right: 1px solid #c5c5c5;">Note Book</th><th colspan="5" style="border-right: 1px solid #c5c5c5;">Sub Enrichment</th><th colspan="6" style="border-right: 1px solid #c5c5c5;">Session Ending</th>'+
				'<th colspan="5" >Final Results</th>'+
			'</tr></thead>'+
		'<tbody>'+
		'<tr style="background-color:#f2f2f2;">'+
		'<td style="border-right: 1px solid #c5c5c5;">S.No.</td><td style="border-right: 1px solid #c5c5c5;">Roll No.</td><td style="border-right: 1px solid #c5c5c5;">Adm No.</td><td style="border-right: 1px solid #c5c5c5;">Student Name</td><!--<td style="border-right: 1px solid #c5c5c5;">Father Name</td><td style="border-right: 1px solid #c5c5c5;">Mother Name</td>-->';
			$.each(response.data[0].marks,function(key,value){
				if(value.sub_name != "FIT"){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ value.sub_name +'</td>';
				}
			});
			$.each(response.data[0].marks,function(key,value){
				if(value.sub_name != "FIT"){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ value.sub_name +'</td>';
				}
			});
			$.each(response.data[0].marks,function(key,value){
				if(value.sub_name != "FIT"){
					x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ value.sub_name +'</td>';
				}
			});
			$.each(response.data[0].marks,function(key,value){
				x = x + '<td style="border-right: 1px solid #c5c5c5;">'+ value.sub_name +'</td>';
			});
			
			x =x ;
		x = x +
		'<td style="border-right: 1px solid #c5c5c5;">Aggr.</td><td style="border-right: 1px solid #c5c5c5;">Result</td><td style="border-right: 1px solid #c5c5c5;">Per(%)</td><td style="border-right: 1px solid #c5c5c5;">Rank</td><td style="border-right: 1px solid #c5c5c5;">Div</td>'+
		'</tr>';
		/*Result start student section*/
		var counter = 1;
		$.each(response.data,function(key,value){
			x = x +'<tr>'+
				'<td>'+ counter +'.</td>'+
				'<td>'+ value.student[0].roll_no +'</td>'+
				'<td>'+ value.student[0].admission_no +'</td>'+
				'<td>'+ value.student[0].name +'</td>';
				$.each(value.marks,function(k,v){
					if(v.sub_name != "FIT"){
						x = x + '<td>'+ v.priodic +'</td>';
					}
				});
				$.each(value.marks,function(k,v){
					if(v.sub_name != "FIT"){
						x = x + '<td>'+ v.notebook +'</td>';
					}
				});
				$.each(value.marks,function(k,v){
					if(v.sub_name != "FIT"){
						x = x + '<td>'+ v.subjenrich +'</td>';
					} 
				});
				$.each(value.marks,function(k,v){
					if(v.sub_name == "FIT"){
						x = x + '<td>'+ parseInt(parseInt(v.annual_mark) + parseInt(v.extra) + parseInt(v.practical)) +'</td>';
					}
					else{
						x = x + '<td>'+ parseInt(parseInt(v.annual_mark) + parseInt(v.extra)) +'</td>';
					}
				});
				x = x + '<td>'+ value.aggrigate +'</td>';
				
				
				var category = '';
				var y = '';
				if(typeof value.back != 'undefined'){
					if(value.back.length > 0){
						$.each(value.back,function(k1,v1){
							y = y + v1 +',';
						});
						
						y = y.slice(0, -1)
						category = '<td>Compartment('+ y + ')</td>';
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
				x = x + '<tr><td>'+ c +'.</td><td>'+ value.student[0].roll_no +'</td><td>'+ value.student[0].name +'</td><td>'+ value.aggrigate +'/500</td><td>'+ value.rank +'</td></tr>';
				c++;
			}
		});
		
		$.each(response.data,function(key,value){
			if(value.rank == 2){
				x = x + '<tr><td>'+ c +'.</td><td>'+ value.student[0].roll_no +'</td><td>'+ value.student[0].name +'</td><td>'+ value.aggrigate +'/500</td><td>'+ value.rank +'</td></tr>';
				c++;
			}
		});
		
		$.each(response.data,function(key,value){
			if(value.rank == 3){
				x = x + '<tr><td>'+ c +'.</td><td>'+ value.student[0].roll_no +'</td><td>'+ value.student[0].name +'</td><td>'+ value.aggrigate +'/500</td><td>'+ value.rank +'</td></tr>';
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