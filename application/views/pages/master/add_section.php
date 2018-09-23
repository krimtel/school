<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Section
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Section</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
        
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Create New Section</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal">
			<div class="box-body">
				<div>
        			<label>class</label>
        			<select name="class" id="class">
        				<option value="0" selected>Please select class</option>
        				<?php foreach($classes as $class){?>
        					<option value="<?php echo $class['c_id']?>"><?php echo $class['name']; ?></option>
        				<?php }?>
        			</select>
        		</div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Section</label>
                  <div class="col-sm-9"><input type="text" class="form-control" placeholder="Ex.- A,B,C"></div>
                </div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn pull-right btn-info">Submit</button>
				<button type="submit" class="btn btn-default pull-right btn-space">Cancel</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
         
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">

          <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">All Section List</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
			<div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>S.No.</th>
                  <th>Section</th>
                  <th>Edit/Delete</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>A</td>
                   <td><a type="button" class="btn btn-info btn-flat" title="Edit" ><i class="fa fa-pencil"></i></a> <a type="button" class="btn btn-info btn-flat" title="Delete"><i class="fa fa-trash-o"></i></a></td>
                </tr>
				 <tr>
                  <td>2.</td>
                  <td>B</td>
                   <td><a type="button" class="btn btn-info btn-flat" title="Edit" ><i class="fa fa-pencil"></i></a> <a type="button" class="btn btn-info btn-flat" title="Delete"><i class="fa fa-trash-o"></i></a></td>
                </tr>
              </table>
            </div>
        <!-- /.box-body -->
      </div>

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>