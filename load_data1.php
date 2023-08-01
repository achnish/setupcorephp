<?php  
 //load_data.php  
session_start();
 include_once 'connection.php';
 
 include "head.php";  
 $output = '';  

  
                      
 if(isset($_POST["d_id"]))  
 {  
  if($_POST["d_id"] == 'All')  
      {  
        $sql = "SELECT * FROM cruddetails WHERE status = '1'"; 
      }  
      else  
      {  
          $sql = "SELECT * FROM cruddetails WHERE status = '1' AND `designation` = '".$_POST['d_id']."' ";     
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
   <th>Manager</th>
   <th>Active</th>
    
  </tr>
';
$i = 1;
if($total_data > 0)
{
  foreach($rs as $row)
  {
     $encrypt = (($row["id"]*123456789*5678)/956783);
   $link = "update.php?id=".urlencode(base64_encode($encrypt));
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
         <td>';
         if($row['manager_id'] == 0){ 
           $output .= '-'; 
           }else { 
            $output .= getmanagerByID($row['manager_id']);
             }
              $output .=  '</td>';
        
          $output .=  '<td>';
             $output .= '<a href="'.$link.'" class="btn btn-primary">Edit
                                    </a>';
           $output .= '</td> </tr>';
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
