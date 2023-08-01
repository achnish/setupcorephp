<?php include "nav.php"; 
// session_start(); 
 include "urlprevent.php"; 
 include "head.php";
 error_reporting(0);
 //include  "connection.php"; 
?>

 <?php  
      if(isset($_SESSION['status'])){  ?>
       <div id="alert" class="alert alert-primary mt-3" role="alert"> <?php echo $_SESSION['status']; ?> </div>
 <?php unset($_SESSION['status']); } ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="row">
<div class="col-sm-4">
  <?php if($_SESSION['role'] == 'admin') {  ?>
     <div class="card text-white bg-secondary mt-3">
      <div class="card-header">Manager</div>
       <div class="card-body">
        <h5 class="card-title">Active Manager : <?php echo getmanager(); ?></h5>
          <h5 class="card-title">Deactive Manager : <?php echo get_deactive_manager(); ?></h5>
       </div> 
     </div>
     </div>
     <div class="col-sm-4">
     <div class="card text-white bg-secondary mt-3" >
      <div class="card-header">Precident</div>
       <div class="card-body">
        <h5 class="card-title">Active Precident : <?php echo getprecident(); ?></h5>
          <h5 class="card-title">Deactive Precident : <?php echo get_deactive_precident(); ?></h5>
       </div>
     </div>
   </div>
  <?php } ?>
  <div class="col-sm-4">
     <div class="card text-white bg-secondary mt-3">
      <div class="card-header">Employee</div>
       <div class="card-body">
        <?php if($_SESSION['role'] == 'admin') {  ?>
         <h5 class="card-title">Active Employee : <?php echo getemp(); ?></h5>
          <h5 class="card-title">Deactive Employee : <?php echo get_deactive_emp(); ?></h5>
        <?php } else { ?>
          <h5 class="card-title">Active Employee : <?php echo getempformanager(); ?></h5>
          <h5 class="card-title">Deactive Employee : <?php echo get_deactive_emp_formanager(); ?></h5>
        <?php } ?>
       </div>
     </div>
  </div>
</div>

	<script type="text/javascript">
        setTimeout(function () {
            $('#alert').alert('close');
        }, 5000);
    </script>

</body>
</html>