<!DOCTYPE html>
<html>
<?php print_r($header); ?>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
  <?php print_r($topbar); ?>
  <?php //print_r($aside); ?>
  <?php print_r($page); ?>
  
  <footer class="main-footer text-center hidden-print">
    <strong>Copyright &copy; 2017-2018 <a href="#">Shakuntala Vidyalaya Ram Nagar Bhilai C.G.</a></strong> All rights
    reserved.
  </footer>
  
  <div class="control-sidebar-bg"></div>
</div>
<?php print_r($footer); ?>

<div class="modal fade" id="loader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
<div class="modal-dialog" role="document" style="width:75px;">
    <div class="modal-content">
    
      <div class="modal-body">
       <div class="loader"></div>
      </div>
     
    </div>
  </div>
</div>
<div class="no-display loader-box"><div class="loader"></div></div>
<div class="no-display fade"></div>

</body>
</html>
