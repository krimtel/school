<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Bus Stoppages
</h1>
 
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('school'));?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Web</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
        <section class="col-lg-12 connectedSortable">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Search Students Reports/Records</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form id="bus_form" role="form" class="form-horizonta" method="POST" action="<?php echo base_url();?>Admin_webctrl\stoppage_add">
			<div class="box-body">
				<input type="hidden" id="stoppage_id" name="stoppage_id" value="0"> 
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Stoppage Name</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" id="bus_stoppage" name="bus_stoppage" placeholder="stoppage Name">
						<div id="bus_stoppage_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
				
				<div class="form-group col-sm-4">
                    <label class="col-sm-2 control-label">Price</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" id="stoppage_amount" name="stoppage_amount" placeholder="Amount">
						<div id="stoppage_amount_err" class="text-danger" style="display: none;"></div>
					</div>
				</div>
			</div>
            <div class="box-footer">
				<button type="button" id="form_submit" class="btn pull-right btn-info btn-space">Search</button> 
				<button type="reset" class="btn btn-default pull-right btn-space">Clear</button>
            </div>
			</form>
			<!-- /.box-body -->
		</div>
        </section>
  </div>
  <div id="bus_stoppage_list_panel" style="display:none;">
  		<select name="sort" id="sort">
  			<option value="stoppege_name">Name</option>
  			<option value="price">Amount</option>
  		</select>
  		
  		<select name="direction" id="direction">
			<option value="Asc">Asc</option>
  			<option value="Desc">Desc</option>	  			
  		</select>
  		<div id="bus_stoppage_list"></div>
  </div>

</section>

<script>
var baseUrl = $('#base_url').val();

$("#stoppage_amount").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

$('#form_submit').on('click',function(){
	var form_valid = true;
	if($('#stoppage_amount').val() != ''){
		form_valid = true;
		$('#stoppage_amount_err').hide();
	}
	else{
		$('#stoppage_amount_err').html('Please enter amount').show();
		form_valid = false;
	}

	if($('#bus_stoppage').val() != ''){
		form_valid = true;
		$('#bus_stoppage_err').hide();
	}
	else{
		$('#bus_stoppage_err').html('Please enter bus stoppage').show();
		form_valid = false;
	}
	
	if(form_valid){
		$('#bus_form').ajaxForm({
		    dataType : 'json',
		    beforeSubmit:function(e){
		    },
		    success:function(response){
		    	if(response.status == 200){
		        	location.reload();
		    	}
		    }
		}).submit();
	}
});


bus_lists();
function bus_lists(){
	var sort = $('#sort').val();
	var direc = $('#direction').val();
	
	$.ajax({
		type: 'POST',
		url: baseUrl+'Admin_webctrl/bus_list/',
		dataType: "json",
		data: {
			'sort' : sort,
			'direc': direc
		},
		success:function (response) {
			console.log(response);
			if(response.status == 200){
				var x = '<table class="table">';
				var c = 1;
				$.each(response.data,function(key,value){
					x = x + '<tr>'+
								'<td>'+ c +'</td>'+
								'<td>'+ value.stoppege_name +'</td>'+
								'<td>'+ value.price +'</td>'+
								'<td><a href="javascript:void(0)" class="bus_edit" data-id="'+ value.b_id +'" data-name="'+ value.stoppege_name +'" data-price="'+ value.price +'">Edit</a> <a href="javascript:void(0)" class="bus_del" data-id="'+ value.b_id +'">Delete</a></td>'+
							'</tr>';
				c++;
				});
				x = x + '</table>';
				$('#bus_stoppage_list_panel').show();
				$('#bus_stoppage_list').html(x);
				
			}
		}
	});	
}


$(document).on('change','#sort, #direction',function(){
	bus_lists();
});

$(document).on('click','.bus_edit',function(){
	$('#form_submit').text('Edit');
	$('#bus_stoppage').val($(this).data('name')).focus();
	$('#stoppage_amount').val($(this).data('price'));
	$('#stoppage_id').val($(this).data('id'));
});

$(document).on('click','.bus_del',function(){
	var b_id = $(this).data('id');
	$.ajax({
		type: 'POST',
		url: baseUrl+'Admin_webctrl/bus_delete',
		dataType: "json",
		data: {
			'b_id' : b_id
		},
		beforeSend: function(){
		},
		success:function (response) {
			if(response.status == 200){
	        	location.reload();
	    	}
		}
	});
});

</script>
