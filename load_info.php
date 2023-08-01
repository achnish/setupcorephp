<?php  
 //load_data.php  
session_start();
 include_once 'connection.php';
 
 include "head.php";

 $output = '';  

 if(isset($_POST["role_id"]))  
 {  

      if($_POST["role_id"] == 'All')  
      {  
        $sql = "SELECT * FROM registration WHERE role != 'admin'"; 
          
      }  
      else  
      {  
          $sql = "SELECT * FROM registration WHERE role != 'admin' AND role = '".$_POST['role_id']."' ";     
      } 
      // print_r($sql);
      // exit();
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
   <th>Role</th>
   <th>Address</th>
   <th>Active</th>
   <th>Email</th>
    
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
         <td>'.$row["role"].'</td>
         <td>'.$row["address"].'</td>
         <td>'; 
           if($row["active"] == 1){
             $output .= '<a href="javascript: active_user('.$row['id'].' )" class="btn btn-success">Deactive</a>';
           } else {
             $output .= '<a href="javascript: active_user('.$row['id'].' )" class="btn btn-danger">Active</a>';
           }
           $output .=  '</td>';
        
          $output .=  '<td>';
           $output .=  '<a href="javascript: resend_mail('.$row['id'].' )" class="btn btn-success">Resend Mail</a>';

        $output .= '</td> </tr>';
        
    //$output .= '</tr>';
  }
}
else
{
  $output .= 'no record found ';
}}
      echo $output;  
 } else {
   header("location: users.php");
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
<script type="text/javascript">
  // function resend_mail(id)
  //   {
  //       if (confirm('Are You Sure to Export this Record?'))
  //       {
  //           window.location.href = 'resend_mail.php?id=' + id;
  //       }
  //   }
</script>
 </head>
 <body>
 
 </body>
 </html> 
