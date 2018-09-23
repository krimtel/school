<!-- jQuery UI 1.11.4 -->
<!--<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>-->
<script src="<?php echo base_url(); ?>assest/bootstrap/js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php echo base_url(); ?>assest/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url(); ?>assest/bootstrap/js/raphael-min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
<!--script src="<?php //echo base_url(); ?>assest/plugins/morris/morris.min.js"></script-->
<script src="<?php echo base_url(); ?>assest/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>assest/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>assest/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url(); ?>assest/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assest/bootstrap/js/moment.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>-->
<script src="<?php echo base_url(); ?>assest/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assest/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assest/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo base_url(); ?>assest/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assest/plugins/fastclick/fastclick.js"></script>
<script src="<?php echo base_url(); ?>assest/dist/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>assest/dist/js/pages/dashboard.js"></script>
<script src="<?php echo base_url(); ?>assest/dist/js/demo.js"></script>
<!--<script src="<?php echo base_url(); ?>assest/plugins/iCheck/icheck.min.js"></script>-->

<script>
$(function () {
//Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
//Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    });
});
</script>