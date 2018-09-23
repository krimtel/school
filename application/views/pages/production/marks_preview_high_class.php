<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Marksheet Preview
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Marksheet Preview</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
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
						<?php if(isset($medium)){ ?>
							<select class="form-control" id="medium">
								<option value="<?php echo $medium; ?>"><?php echo $medium; ?></option>
							</select>
						<?php } else { ?>
						<select class="form-control" id="medium">
							<option value="0">Select Medium</option>
							<option value="Hindi">Hindi</option>
							<option value="English">English</option>
						</select>
						<?php } ?>
						<div class="text-danger" id="medium_err" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Class</label>
					<div class="col-sm-10">
						<select class="form-control" id="class">
						<option value="0">Select Class</option>
							<?php foreach($classes as $class){ ?>
								 <option value="<?php echo $class['c_id']; ?>"><?php echo $class['name']; ?></option>
							<?php } ?>
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
                    <label class="col-sm-2 control-label">Subject Group</label>
					<div class="col-sm-10">
					<select class="form-control" id="s_group">
						<option value="0" selected>Select Subject Group</option>
						<option value="Maths">Maths</option>
						<option value="Boilogy">Boilogy</option>
						<option value="Commerce">Commerce</option>
						<option value="Arts">Arts</option>
					</select>
					<div class="text-danger" id="s_group_err" style="display:none;"></div>
					</div>
				</div>
				
			</div>
			<div class="box-footer">
				<button type="button" class="btn pull-right btn-info btn-space classwise_pre" data-type="final_fard">Classwise Final Report</button> 
			<!--  <button type="submit" class="btn pull-right btn-info btn-space" id="classwise_pre_mid">Classwise Pre + Mid Report</button> -->
				<button type="button" class="btn pull-right btn-info btn-space classwise_pre" data-type="final">Classwise Annual Report</button> 
				<button type="button" class="btn pull-right btn-info btn-space classwise_pre" data-type="post_mid">Classwise Post Report</button> 
				<button type="button" class="btn pull-right btn-info btn-space classwise_pre" data-type="mid">Classwise Mid Report</button> 
				<button type="button" class="btn pull-right btn-info btn-space classwise_pre" data-type="pre">Classwise Pre Report</button>
            </div>
			</form>
		</div>
        </section>
	</div>
    </section>
  </div>
<script src="<?php echo base_url();?>assest/bootstrap/js/mark_sheet_preview_high_class.js"></script>