
<!DOCTYPE html>
<?php 
      include "nav.php";
      include_once 'connection.php';
      include "urlprevent.php"; ?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <?php   
    if($_SESSION['role'] == 'manager') {
 header("location:home_page.php");
 }
        include "head.php"; 
         ?>
</head>
<script type="text/javascript">
 function active_user(id)
 {
   if (confirm('Are You Sure to Change Activity Of this Record?'))
   {
      window.location.href = 'active.php?id=' + id;
    }
  }
  function welcome_mail(id)
 {
   if (confirm('Are You Sure Send Welcome Mail To this Record?'))
   {
      window.location.href = 'welcome_mail.php?id=' + id;
    }
  }
  function export_emp()
    {
      var role = $('#role :selected').text();
      console.log('role',role);
        if (confirm('Are You Sure to Export this Record?'))
        {
            window.location.href = 'exportdataforadmin.php?role=' + role;
        }
    }
    function resend_mail(id)
    {
        if (confirm('Are You Sure to Resend Mail To this Record?'))
        {
            window.location.href = 'resend_mail.php?id=' + id;
        }
    }
</script>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12 mx-auto">
           <?php    if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Members data has been imported successfully.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}?>
<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12">
    <div id="alert" class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
</div>
<?php } ?>
            <?php  if(isset($_SESSION['status'])){  ?>
                <div id="alert" class="alert alert-primary mt-3" role="alert"> <?php echo $_SESSION['status']; ?> </div>
                    <?php unset($_SESSION['status']); } ?>
                <div class="page-header clearfix">
                    <div class="row">
                        <div class="col-md-2">
                    <h4 class="pull-left mt-4">Users List&nbsp;&nbsp;&nbsp;&nbsp;</h4>
                    </div>
                    <div class="col-md-10 mt-4">
                         <div class="form-group">
                       <form method="post" action="javascript: export_emp()" enctype="multipart/form-data">
                         <select name="role" id="role" class="form-control">
                             <option selected=""> All</option>
                             <?php
                             
                              $sql = "SELECT name From role where name != 'admin'";
                             $query_run = mysqli_query($conn,$sql);
                          while($data = mysqli_fetch_array($query_run))
                          {
                              echo "<option id='myField' value='". $data['name'] ."'>" .$data['name'] ."</option>";  
                          }?>  
                        </select>
                    
                    </div>
                    </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-10"></div>
                  <div class="col-md-2">
                     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">import</button>
                       <input type = "submit" class="btn btn-primary" value="Export"><i class="exp"></i> </a>
                  </div>
                </div>
                </form>
                <div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Import List Of Users</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form role="form" id="newModalForm" method="post" action="importdataforadmin.php" enctype="multipart/form-data">
      <!-- Modal body -->
      <div class="modal-body">
         <input type="file" name="csv_file" id="csv_file" accept=".csv"/>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <p><a href="demosheet.csv" download>Download Sample File</a></p>
        <input type="submit" class="btn btn-dark" name="submit" value="Import">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>
     </form>
    </div>
  </div>
</div>
                    <br>
                    <!-- <a href="add_employee.php" class="btn btn-dark mb-4">Add Manager</a> -->
                </div>
                <?php
                    $result = mysqli_query($conn, "SELECT * FROM registration where role != 'admin'"); ?>
                <?php
                    if (mysqli_num_rows($result) > 0) {   ?>
                     <table class='table table-bordered table-striped' id='table'>
                       <thead>
                        <tr>
                            <th>No</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Birth Date</th>
                            <th>Gender</th>
                            <th>Email id</th>
                            <th>Mobile</th>
                            <th>Role</th>
                            <th>Address</th>
                            <th>Active</th>
                            <th>Email</th>
                        </tr>
                       </thead>
                    <?php
                        $i = 1;
                        while ($row = mysqli_fetch_array($result)) { ?>
                            <tr><td><?php echo $i++; ?></td>
                                <td><?php echo $row["firstname"]; ?></td>
                                <td><?php echo $row["lastname"]; ?></td>
                                <td><?php echo $row["birthdate"]; ?></td>
                                <td><?php echo $row["gender"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo ($row["phoneno"]) ? ($row["phoneno"]) : ('N/A'); ?></td>
                                 <td><?php echo $row["role"]; ?></td>
                                <td><?php echo $row["address"]; ?></td>
                                <?php 
                                   $encrypt = (($row["id"]*123456789*5678)/956783);
                                   $link = "update.php?id=".urlencode(base64_encode($encrypt));  ?>
                                <td>
                                  <?php if($row["active"] == 1){ ?>
                                    <a href="javascript: active_user(<?php echo $row['id']; ?>)" class="btn btn-success">Deactive</a>
                                  <?php } else { ?>
                                     <a href="javascript: active_user(<?php echo $row['id']; ?>)" class="btn btn-danger">Active</a>
                                  <?php } ?>
                                </td>
                                <td>
                                     <a href="javascript: resend_mail(<?php echo $row['id']; ?>)" class="btn btn-success">Resend Mail</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { echo "No result found"; } ?>
            </div>
        </div>
    </div>
     <script>  
 $(document).ready(function(){  
      $('#role').change(function(){  
           var role_id = $(this).val();  
           $.ajax({  
                url:"load_info.php",  
                method:"POST",  
                data:{role_id:role_id},  
                success:function(data){  
                     $('#table').html(data);  
                }  
           });  
      });  
 });  
 </script>  
<script type="text/javascript">
    setTimeout(function () {
        $('#alert').alert('close');
    }, 5000);
</script>
<script>
  $(document).ready(function() {
    $('#table').DataTable();
});
</script>
<script>
$("#newModalForm").validate({
    rules : {
        csv_file : {
            required : true,
            extension: 'csv',
            accept : 'text/csv,text/comma-separated-value,application/vnd.ms-excel,application/vnd.msexcel,application/csv'
        }
    },
    messages : {
        csv_file : {
            required : "A csv file is required.",
            accept : "The file type must be 'CSV'."
        }
    }
});
</script>
</body>
</html>