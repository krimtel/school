var baseUrl = $('#base_url').val();
  $(document).on('change','#class',function(){
	  var c_id = $(this).val();
	  if(c_id == 12){
		  $('#fit_section').css('display','block');
	  }
	  else{
		 $('#fit_section').css('display','none'); 
	  }
	  
	  if(c_id == 14 || c_id == 15){
		$('#sub_group_section').css('display','block');  
		$('#elective_section').css('display','block');
		
		$.ajax({
			type: 'GET',
			url: baseUrl+'Subject_ctrl/elective_subject',
			dataType: "json",
			data: {},
			beforeSend: function(){
				
			},
			success:  function (response) {
				if(response.status == 200){
					var x = '<option value="0" selected>Select Elective Subject</option>';
					$.each(response.data,function(key,value){	
						x = x + '<option value="'+value.sub_id+'">'+ value.name +'</option>'; 
					});
					$('#elective_subject').html(x);
				}
			}
		});
	  }
	  else{
		$('#sub_group_section').css('display','none');
		$('#elective_section').css('display','none');		
	  }

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
  
  var formvalid = true;
  $(document).on('click','#form-submit',function(){
	  if($('#admission_no').val() == ''){
		  formvalid = false;
		  //alert('admission_no');
		  $('#admission_no_err').html('Admission no can\'t be empty.').css('display','block');
	  } else {
		  $('#admission_no_err').css('display','none');
	  }

	  if($('#roll_no').val() == ''){
		  formvalid = false;
		  //alert('roll_no');
		  $('#roll_no_err').html('Please enter roll no.').css('display','block');
	  } else {
		  $('#roll_no_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#student_name').val() == '' || $('#student_name').val().length < 3){
		  formvalid = false;
		  $('#student_name_err').html('Student name not valid.').css('display','block');
	  } else {
		  $('#student_name_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#medium').val() == '0'){
		  formvalid = false;
		   //alert('medium');
		  $('#medium_err').html('Please select medium.').css('display','block');
	  } else {
		  $('#medium_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#class').val() == '0'){
		  formvalid = false;
		  //alert('class');
		  $('#class_err').html('Please select class.').css('display','block');
	  } else {
		  $('#class_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#section').val() == '0'){
		  formvalid = false;
		  //alert('section');
		  $('#section_err').html('Please select section.').css('display','block');
	  } else {
		  $('#section_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#class').val() == 14 || $('#class').val() == 15){
		  if($('#subject_group').val() == '0'){
			  formvalid = false;
			  //alert('subject_group');
			  $('#subject_group_err').html('Please select subject group.').css('display','block');
		  } else {
			  $('#subject_group_err').css('display','none');
		  formvalid = true;
		  }
	  }

	  if($('#father_name').val() == '' || $('#father_name').val().length < 3){
		  formvalid = false;
		  //alert('father_name');
		  $('#father_name_err').html('Father name not valid.').css('display','block');
	  } else {
		  $('#father_name_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#mother_name').val() == '' || $('#mother_name').val().length < 3){
		  formvalid = false;
		  //alert('mother_name');
		  $('#mother_name_err').html('Mother name not valid.').css('display','block');
	  } else {
		  $('#mother_name_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#dob').val() == ''){
		  formvalid = false;
		  //alert('datepicker');
		  $('#datepicker_err').html('Please enter date of birth.').css('display','block');
	  } else {
		  $('#datepicker_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#gender').val() == '0'){
		  formvalid = false;
		  //alert('gender');
		  $('#gender_err').html('Please select gender.').css('display','block');
	  } else {
		  $('#gender_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#admission').val() == ''){
		  formvalid = false;
		   //alert('datepicker2');
		  $('#datepicker2_err').html('Please select date of admission.').css('display','block');
	  } else {
		  $('#datepicker2_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#caste').val() == '0'){
		  formvalid = false;
		  //alert('caste');
		  $('#caste_err').html('Please select caste.').css('display','block');
	  } else {
		  $('#caste_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#blood').val() == '0'){
		  formvalid = false;
		  //alert('blood');
		  $('#blood_err').html('Please select blood group.').css('display','block');
	  } else {
		  $('#blood_err').css('display','none');
		  formvalid = true;
	  }

	  if($('#aadhaar').val() == ''){
		  formvalid = false;
		   //alert('aadhaar');
		  $('#aadhaar_err').html('Please enter student aadhaar card no.').css('display','block');
	  } else {
		  $('#aadhaar_err').css('display','none');
		  formvalid = true;
	  }
	  if($('#address').val() == ''){
		  formvalid = false;
		  //alert('address');
		  $('#address_err').html('Please enter address.').css('display','block');
	  } else {
		  $('#address_err').css('display','none');
		  formvalid = true;
	  }
	  
	  if($('#transfer').val() == '0'){
		  formvalid = false;
		  //alert('transfer');
		  $('#transfer_err').html('Please select transfer certificate.').css('display','block');
	  } else {
		  $('#transfer_err').css('display','none');
		  formvalid = true;
	  }
	  
	  if($('#house').val() == '0'){
		  formvalid = false;
		  //alert('house');
		  $('#house_err').html('Please select house.').css('display','block');
	  } else {
		  $('#house_err').css('display','none');
		  formvalid = true;
	  }
	  
	  if($('#hostler').val() == '0'){
		  formvalid = false;
		  //alert('hostler');
		  $('#hostler_err').html('Please select hostler.').css('display','block');
	  } else {
		  $('#hostler_err').css('display','none');
		  formvalid = true;
	  }
	  
	  if($('#class').val() == 12){
		  if($('#fit').val() == '0'){
			  formvalid = false;
			  $('#fit_err').html('Select student is in FIT or Not.').css('display','block');
		  } else {
			  $('#fit_err').css('display','none');
		  formvalid = true;
		  }
	  }
	  
	  if($('#class').val() == 14||$('#class').val() == 15){
		  if($('#elective_subject').val() == '0'){
			  formvalid = false;
			  $('#elective_subject_err').html('Select elective Subject.').css('display','block');
		  } else {
			  $('#elective_subject_err').css('display','none');
		  formvalid = true;
		  }
		  
		  if($('#subject_group').val() == '0'){
			  formvalid = false;
			  $('#subject_group_err').html('Select Student Subject Group.').css('display','block');
		  } else {
			  $('#subject_group_err').css('display','none');
		  formvalid = true;
		  }
	  }
	  
	if(formvalid){
		var that = this;
	  $('#student_form').ajaxForm({
		    dataType : 'json',
		    beforeSubmit:function(e){
				$('#loader').modal('show');
		    },
		    success:function(response){
		  	  if(response.status == 200){
		    	$('#loader').modal('toggle');
				$(that).closest('form').find("input[type=text], textarea").val("");
				$("select").each(function() { this.selectedIndex = 0 });
				alert(response.msg);
		  	  }
		      else{
			    alert(response.msg);
		      }
		    }
	  }).submit();
	}
  });
  
  $(document).on('keyup','#admission_no',function(){
	  var str = $(this).val();
	  $.ajax({
		type: 'POST',
		url: baseUrl+'Student_ctrl/admission_no_check',
		dataType: "json",
		data: {
			'str' : str
		},
		beforeSend: function(){},
		success: function(response) {
			console.log(response);
			if(response.status == 500){
				formvalid = false;
				$('#admission_no_err').html('Admission No already Exist.').css('display','block');
			}
			else{
				formvalid = true;
				$('#admission_no_err').css('display','none');
			}
		}
	  });
  });

  $(document).on('click','#csv_submit',function(){
	  var formvalid = true;

	  if($('#exampleInputFile').val() == ''){
		  formvalid = false;
		  $('#csvfile').html('Please Select CSV file First.').css('display','block');
	  }else{
		  $('#csvfile').css('display','none');
	  }	  

	if(formvalid){
	  $('#csv-form').ajaxForm({
		    dataType : 'json',
		    beforeSubmit:function(e){
		    	$('#loader').modal('show');
		    },
		    success:function(response){
		    	$('#loader').modal('toggle');
		  	  if(response.status == 200){
		  	  alert("Your File Successfully Upload");
		    	location.reload();
		      }
		      else{
			    alert("Something Goes To Wrong Contact To Admin\n May Be This Record All Ready Submitted");
		      }
		    }
	    }).submit();
	}
  });