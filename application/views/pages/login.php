<!DOCTYPE html>
<html>
<?php print_r($header); ?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  	<?php if($this->uri->segment(1) == 'shakuntala') { ?>
	 	<a href=""><img alt="Shakuntala Vidyalaya" class="logo-s" src="<?php echo base_url();?>assest/images/shakuntala/login-logo.png" /></a>
	 <?php } else {?>	
	 	<a href=""><img alt="Sharda Vidyalaya" class="logo-s" src="<?php echo base_url();?>assest/images/sharda/login-logo.png" /></a>
	 <?php }?>
  </div>
  <div class="login-box-body">
    <form id="login_form" name="f1" method="POST" action="<?php echo base_url();?>Auth/login">
      <div class="form-group has-feedback">
        <input type="text" name="uname" id="uname" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
		<span class="help-block" id="uname_error"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		<span class="help-block" id="password_error"></span>
      </div>
      <div class="row">
        <div class="col-xs-offset-8 col-xs-4">
        	<input type="button" value="Log In" class="btn btn-primary btn-block btn-flat" id="form_submit">
        </div>
      </div>
    </form>
  </div>
</div>
<?php print_r($footer); ?>
<script>
$('.help-block').css('display','none');
$(document).on('click','#form_submit',function(){
	var formvalid = true;
	if($('#uname').val().length < 3){
		formvalid = false;
		$('#uname_error').closest('.form-group').addClass('has-error');
		$('#uname_error').html('user name not valid.').css('display','block');
	}else{
		$('#uname_error').closest('.form-group').removeClass('has-error');
		$('#uname_error').css('display','none');
	}
	if($('#password').val().length < 5){
		formvalid = false;
		$('#password_error').closest('.form-group').addClass('has-error');
		$('#password_error').html('password not valid.').css('display','block');
	}else{
		$('#password_error').closest('.form-group').removeClass('has-error');
		$('#password_error').css('display','none');
	}
	if(formvalid){
		var baseUrl = $('#base_url').val();
		$('#login_form').ajaxForm({
		    dataType : 'json',
		    beforeSubmit:function(e){
		    },
		    success:function(response){
		  	  if(response.status == 200){
			  	  if(response.type == 'Admin'){
		  			$('#loader').modal('show');
			  	 		load();
			  	 		location.reload();
		  			}
			  	  else{
			  		location.reload();
			  	  }
		      }
		      else{
			    alert(response.msg);
		      }
		    }
	    }).submit();
	}
});

function load(){
	var baseUrl = $('#base_url').val();
  		$.ajax({
  			type: 'GET',
  			url: baseUrl+'Admin_ctrl/db_check',
  			//dataType: "json",
  			data: {	},
  			beforeSend: function(){
  	  		},
  			success:  function (response) {
  				$('#loader').modal('toggle');
  			}
  		});
}

$('#password').keyup(function(e){
    if(e.keyCode == 13){
        $('#form_submit').trigger('click');
    }
});

</script>
</body>
</html>