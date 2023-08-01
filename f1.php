<?php
error_reporting(0);
include_once 'connection.php';
include_once "head.php";

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

$query = "
SELECT * FROM users 
";

if($_POST['query'] != '')
{
  $query .= '
  WHERE first_name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" 
     OR last_name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" 
     OR email LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" 
     OR address LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" 
  ';
}
$query .= 'ORDER BY id ASC ';
$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';
$rs = mysqli_query($conn,$query);
$total_data = mysqli_num_rows($rs);
$rs = mysqli_query($conn,$filter_query);
$total_filter_data = mysqli_num_rows($rs);

$output = '
<h4>Total Records - '.$total_data.'</h4>
<table class="table table-striped table-bordered">
  <tr>
    <th><a class="column_sort" id="id" data-order="desc" href="#">ID</a></th>
    <th><a class="column_sort" id="first_name" data-order="desc" href="#">First Name</a></th>
    <th><a class="column_sort" id="last_name" data-order="desc" href="#">Last Name</a></th>
    <th><a class="column_sort" id="email" data-order="desc" href="#">Email</a></th>
    <th><a class="column_sort" id="address" data-order="desc" href="#">Address</a></th>
  </tr>
';
if($total_data > 0)
{
  foreach($rs as $row)
  {
    $output .= '
    <tr>
      <td>'.$row["id"].'</td>
      <td>'.$row["first_name"].'</td>
      <td>'.$row["last_name"].'</td>
      <td>'.$row["email"].'</td>
      <td>'.$row["address"].'</td>
    </tr>
    ';
  }
}
else
{
  $output .= '
  <tr>
    <td colspan="6" align="center">No Data Found</td>
  </tr>
  ';
}

$output .= '
</table>
<br />
<div align="center">
  <ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

if($total_links > 4)
{
  if($page < 10)
  {
    for($count = 1; $count <= 10; $count++)
    {
      $page_array[] = $count;
    }
    $page_array[] = '..';
    $page_array[] = $total_links;
  }
  else
  {
    $end_limit = $total_links - 10;
    if($page > $end_limit)
    {
      $page_array[] = 1;
      $page_array[] = '..';
      for($count = $end_limit; $count <= $total_links; $count++)
      {
        $page_array[] = $count;
      }
    }
    else
    {
      $page_array[] = 1;
      $page_array[] = '..';
      for($count = $page - 1; $count <= $page + 1; $count++)
      {
        $page_array[] = $count;
      }
      $page_array[] = '..';
      $page_array[] = $total_links;
    }
  }
}
else
{
  for($count = 1; $count <= $total_links; $count++)
  {
    $page_array[] = $count;
  }
}

for($count = 0; $count < count($page_array); $count++)
{
  if($page == $page_array[$count])
  {
    $page_link .= '
    <li class="page-item active">
      <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
    </li>
    ';

    $previous_id = $page_array[$count] - 1;
    if($previous_id > 0)
    {
      $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
    }
    else
    {
      $previous_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Previous</a>
      </li>
      ';
    }
    $next_id = $page_array[$count] + 1;
    if($next_id >= $total_links)
    {
      $next_link = '
      <li class="page-item disabled">
        <a class="page-link" href="#">Next</a>
      </li>
        ';
    }
    else
    {
      $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
    }
  }
  else
  {
    if($page_array[$count] == '..')
    {
      $page_link .= '
      <li class="page-item disabled">
          <a class="page-link" href="#">..</a>
      </li>
      ';
    }
    else
    {
      $page_link .= '
      <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
      ';
    }
  }
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
  </ul>

</div>
';

echo $output;

?>