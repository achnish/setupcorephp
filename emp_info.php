
<!DOCTYPE html>
<?php  include "nav.php";
      include_once 'connection.php';
      include "urlprevent.php";
 ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <?php  include "head.php"; ?>
   
   </head>
     <script type="text/javascript">
    function delete_user(id)
    {
        if (confirm('Are You Sure to Delete this Record?'))
        {
            window.location.href = 'delete.php?id=' + id;
        }
    }
    function active_user(id)
 {
   if (confirm('Are You Sure to Change Activity Of this Record?'))
   {
      window.location.href = 'active_emp.php?id=' + id;
    }
  }
   function export_emp()
    {
        if (confirm('Are You Sure to Export this Record?'))
        {
            window.location.href = 'exportdata.php';
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
}
?>

<!-- Display status message -->
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
                        <div class="col-md-2 mt-5">
                    <h4 class="pull-left">Employee List&nbsp;&nbsp;&nbsp;&nbsp;</h4>
                    </div>
                    <div class="col-md-10 mt-5">
                         <div class="form-group">
                       <!--  <h5 for="role" >Select Role</h5> -->
                        <select name="designation" id="designation" class="form-control">
                            <option>Select Designation</option>
                            <option value="teamleader">Team Leader</option>
                            <option value="developer">Developer</option>
                            <option value="hr">HR</option>
                            <option value="designer">Designer</option>
                        </select>
                    
                    </div>
                    </div>
                </div>
                    <br>
                    <div class="row mt-3">
                      <div class="col-sm-10">
                    <a href="add_employee.php" class="btn btn-primary mb-4">Add Employee</a></div>
                     <div class="col-sm-2">
                     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">import</button>
                       <a href="javascript: export_emp()" class="btn btn-primary"><i class="exp"></i> Export</a>
                </div></div>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Import Employees</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form role="form" id="newModalForm" method="post" action="importdata.php" enctype="multipart/form-data">
      <!-- Modal body -->
      <div class="modal-body">
         <input type="file" name="csv_file" id="csv_file" accept=".csv"/>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <p><a href="demo.csv" download>Download Sample File</a></p>
        <input type="submit" class="btn btn-dark" name="submit" value="Import">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
     </form>
    </div>
  </div>
</div>

                <?php

                $result = mysqli_query($conn, "SELECT * FROM cruddetails where status = '1' AND `manager_id` = '".$_SESSION['id']."' ");

                ?>
                <?php
               
                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class='table table-bordered table-striped mt-3' id='table'>
                       <thead>
                        <tr>
                            <th>No</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Birth Date</th>
                            <th>Gender</th>
                            <th>Email id</th>
                            <th>Mobile</th>
                            <th>Designation</th>
                             <th>Active</th>
                            <th>Action</th>
                        </tr>
                       </thead>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr><td><?php echo $i++; ?></td>
                                <td><?php echo $row["firstname"]; ?></td>
                                <td><?php echo $row["lastname"]; ?></td>
                                <td><?php echo $row["birthdate"]; ?></td>
                                <td><?php echo $row["gender"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo ($row["phoneno"]) ? ($row["phoneno"]) : ('N/A'); ?></td>
                                <td><?php echo $row["designation"]; ?></td>
                                <?php 
                                   $encrypt = (($row["id"]*123456789*5678)/956783);
                                   $link = "update.php?id=".urlencode(base64_encode($encrypt));
                                ?>
                                 <td>
                                  <?php if($row["active"] == 1){ ?>
                                    <a href="javascript: active_user(<?php echo $row['id']; ?>)" class="btn btn-success">Deactive</a>
                                  <?php } else { ?>
                                     <a href="javascript: active_user(<?php echo $row['id']; ?>)" class="btn btn-danger">Active</a>
                                  <?php } ?>
                                </td>
                                <td>
                                    <a href="<?=$link;?>" class="btn btn-primary">Edit
                                    </a>
                                    <a href="javascript: delete_user(<?php echo $row['id']; ?>)" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                <?php
                } else {
                    echo "No result found";
                }
                ?>
             
            </div>
        </div>
    </div>
    <style>
     @media (min-width: 768px)
constructed stylesheet
.container, .container-md, .container-sm {
    max-width: 920px;
}
    </style>
    <script>  
 $(document).ready(function(){  
      $('#designation').change(function(){  
           var d_id = $(this).val();  
           $.ajax({  
                url:"load_data.php",  
                method:"POST",  
                data:{d_id:d_id},  
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
function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
        element.style.display = "block";
    }else{
        element.style.display = "none";
    }
}
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