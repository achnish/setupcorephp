<?php  
 //load_data.php  
session_start();
 include_once 'connection.php';
 
 include "head.php";  
 $output = '';  
 if(isset($_POST["d_id"]))  
 {  
      if($_POST["d_id"] != '')  
      {  
           $sql = "SELECT * FROM cruddetails WHERE status = '1' AND `manager_id` = '".$_SESSION['id']."' AND `designation` = '".$_POST['d_id']."' ";  
      }  
      else  
      {  
           $sql = "SELECT * FROM cruddetails WHERE status = '1' AND `manager_id` = '".$_SESSION['id']."' ";  
      } 
      $rs = mysqli_query($conn, $sql); 
      $total_data = mysqli_num_rows($rs);
      while($row = mysqli_fetch_array($rs))  
      {  
           $output = '

<table class="table table-bordered table-striped mt-3" id="table">
  <tr>
    <th>No</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Birth Date</th>
    <th>Gender</th>
    <th>Email</th>
    <th>Mobile</th>
   <th>Designation</th>
    
  </tr>
';
$i = 1;
if($total_data > 0)
{
  foreach($rs as $row)
  {
    $output .= '
    <tr>
      <td>'.$i++.'</td>
      <td>'.$row["firstname"].'</td>
      <td>'.$row["lastname"].'</td>
      <td>'.$row["birthdate"].'</td>
      <td>'.$row["gender"].'</td>
       <td>'.$row["email"].'</td>
        <td>'.$row["phoneno"].'</td>
         <td>'.$row["designation"].'</td>
    </tr>
    ';
  }
}
else
{
  $output .= 'no record found ';
}}
      echo $output;  
 }  
 ?> 
 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
    <script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
 </head>
 <body>
 
 </body>
 </html> 
