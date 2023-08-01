<?php
//include "urlprevent.php";
include_once 'connection.php';
 
error_reporting(0);
  include "head.php"; 
$output = '';
$order = $_POST["order"];
if($order == 'desc'){
    $order = 'asc';
}else{
    $order = 'desc';
}
$limit = '10';
$page = 1;
if($_POST['page'] > 1)
{
  $start = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
}
else
{
  $start = 0;
}
$q .= 'LIMIT '.$start.', '.$limit.'';
$query ="SELECT * FROM users ORDER BY " .$_POST["column_name"]. " " .$_POST["order"]." ".$q."";
$result = mysqli_query($conn, $query);
$output .= '
<table class="table table-striped table-bordered">
  <tr>
    <th><a class="column_sort" id="id" data-order="'.$order.'" href="#">ID</a></th>
    <th><a class="column_sort" id="first_name" data-order="'.$order.'" href="#">First Name</a></th>
    <th><a class="column_sort" id="last_name" data-order="'.$order.'" href="#">Last Name</a></th>
    <th><a class="column_sort" id="email" data-order="'.$order.'" href="#">Email</a></th>
    <th><a class="column_sort" id="address" data-order="'.$order.'" href="#">Address</a></th>
  </tr>
';

while($row = mysqli_fetch_array($result)){
    $output .='
    <tr>
      <td>'.$row["id"].'</td>
      <td>'.$row["first_name"].'</td>
      <td>'.$row["last_name"].'</td>
      <td>'.$row["email"].'</td>
      <td>'.$row["address"].'</td>
    </tr> 
    ';
}
$output .='</table>';
echo $output;
?>