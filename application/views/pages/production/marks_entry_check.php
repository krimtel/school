<div class="content-wrapper">
    <section class="content-header">
   		<h1>Marks Entry Check</h1>
    	<ol class="breadcrumb">
        	<li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        	<li class="active">Marksheet Preview</li>
      	</ol>
    </section>

    <section class="content">
      	<div class="row">
        	<section class="col-lg-12 connectedSortable">
				<div class="box box-primary">
					<div class="box-header with-border">
			  			<h3 class="box-title">Search Marksheet</h3>
			  			<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  			<i class="fa fa-minus"></i></button>
			  			</div>
					</div>
					<form role="form" class="form-horizontal">
						<div class="box-body">
                			<div class="form-group col-sm-4">
                    			<label class="col-sm-2 control-label">Session</label>
								<div class="col-sm-10">
									<select class="form-control" id="session">
										<option value="0">Select Session</option>
											<?php foreach($sessions as $session){ ?>
											<?php if($current_session == $session['session_id']){ ?>
												<option value="<?php echo $session['session_id'];?>" selected><?php echo $session['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $session['session_id'];?>"><?php echo $session['name']; ?></option>
											<?php } ?>
										<?php } ?>
								</select>
								<div class="text-danger" id="session_err" style="display:none;"></div>
							</div>
						</div>				
						<div class="form-group col-sm-4">
                    		<label class="col-sm-2 control-label">Medium</label>
							<div class="col-sm-10">
								<select class="form-control" id="medium">
									<option value="0">Select Medium</option>
									<option value="Hindi">Hindi</option>
									<option value="English">English</option>
								</select>
								<div class="text-danger" id="medium_err" style="display:none;"></div>
							</div>
						</div>
						<div class="form-group col-sm-4">
                    		<label class="col-sm-2 control-label">Class</label>
							<div class="col-sm-10">
								<select class="form-control" id="class">
									<option value="0">Select Class</option>
									
									<?php
									$i = 1;
									foreach($classes as $class){ ?>
								 		<option value="<?php echo $class['c_id']; ?>"><?php echo $class['name']; ?></option>
									<?php 
									if ($i++ == 13) break;
									} ?>
								</select>
								<div class="text-danger" id="class_err" style="display:none;"></div>
							</div>
						</div>
						<div class="form-group col-sm-4">
                    		<label class="col-sm-2 control-label">Section</label>
							<div class="col-sm-10">
								<select class="form-control" id="section">
									<option value="0">Select Section</option>
								</select>
								<div class="text-danger" id="section_err" style="display:none;"></div>
							</div>
						</div>
						
						<div class="form-group col-sm-4">
                    		<label class="col-sm-2 control-label">Exam Type</label>
                    		<?php 
                    		  $this->db->select('*');
                    		  $exam_type = $this->db->get_where('exam_type', array('status'=>1))->result_array();
                    		?>
                    		
							<div class="col-sm-10">
								<select class="form-control" id="exam_type">
									<option value="0">Select Exam Type</option>
									<?php foreach($exam_type as $type){?>
									<option value="<?php echo $type['e_id'];?>"><?php echo $type['e_name'];?></option>
									<?php }?>
								</select>
								<div class="text-danger" id="exam_type_err" style="display:none;"></div>
							</div>
						</div>
						
						
					</div>
					<div class="box-footer">
						<button type="button" class="btn pull-right btn-info btn-space" id="search">Search</button> 
            		</div>            
				</form>
			</div>
        </section>
		<section class="col-lg-12 connectedSortable">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Marks Entry List</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body" id="subject_list">
				
				</div>
			</div>
		</section>
	</div>
	
    </section>
    
  </div>
 <script src="<?php echo base_url();?>assest/bootstrap/js/mark_entry_check.js"></script>