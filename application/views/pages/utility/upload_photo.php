<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Upload Photo
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Upload Photo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Upload Photo Students/Teachers</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="photo_upload" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>Image_ctrl/image_upload">
			<div class="box-body">
                <div class="form-group col-sm-6">
                    <label class="col-sm-3 control-label">Photos</label>
					<div class="col-sm-9">
						<select class="form-control" name="image_for" id="image_for">
							<option value="0">Select photo</option>
							<option value="student">Students</option>
							<option value="teacher">Teachers</option>
						</select>
						<div id="image_for_err" class="text-danger" style="display:none;"></div>
					</div>
				</div> 
				<div class="form-group col-sm-6">
                  <label class="col-sm-3 control-label">Upload Photo</label>
                  	<div class="col-sm-9"><input type="file" name="userFiles[]" id="files" class="form-control" multiple></div>
                </div>
			</div>
			<div class="box-footer">
				<button type="button" id="form-submit" class="btn pull-right btn-info">Submit</button> 
				<button type="reset" class="btn btn-default pull-right btn-space">Clear</button>
            </div>
			</form>
		</div>
        </section>
      </div>
<div class="row">
<div class="col-lg-12 connectedSortable">
		<div class="box box-primary">
		<div class="box-header with-border">
			  <h3 class="box-title">Photo List Display</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
       <div id="selectedFiles"></div>
</div>
</div>
</div>
    </section>
  </div>
  <script>
  var baseUrl = $('#base_url').val();
var selDiv = "";

  document.addEventListener("DOMContentLoaded", init, false);
  
  function init() {
      document.querySelector('#files').addEventListener('change', handleFileSelect, false);
      selDiv = document.querySelector("#selectedFiles");
  }
      
  function handleFileSelect(e) {
      
      if(!e.target.files || !window.FileReader) return;

      selDiv.innerHTML = "";
      
      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var i =0;
      filesArr.forEach(function(f) {
          var f = files[i];
          if(!f.type.match("image.*")) {
              return;
          }

          var reader = new FileReader();
          reader.onload = function (e) {
              var html = '<img src="'+ e.target.result + '" width="50">' + f.name;
              selDiv.innerHTML += html;               
          }
          reader.readAsDataURL(f); 
          i++;
      });
      
  }

  $(document).on('click','#form-submit',function(){
	  $('#photo_upload').ajaxForm({
		    dataType : 'json',
		    beforeSubmit:function(e){
			    $('#loader').modal('show');
		    },
		    success:function(response){
		  	  if(response.status == 200){
		  		$('#loader').modal('toggle');
		  		alert('Photos Uploaded.');
		  	  }
		    }
	  }).submit();
  });
  
  </script>