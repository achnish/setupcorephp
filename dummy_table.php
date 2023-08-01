
<!DOCTYPE html>
<?php  session_start(); 
  include "urlprevent.php";
  include "head.php"; 
  include "nav.php"; 
  include_once 'connection.php';?>
<html lang="en">
<head>
    <meta charset="utf-8">

<body>
  <div class="container">
    <div class="container-fluid mt-4">
    <form class="d-flex">
      <input class="form-control me-2" type="text" id="live_search" autocomplete="off" placeholder="Search" aria-label="Search">
      <span class="btn btn-dark">Search</span>
    </form>
    <div id="result"></div>
  </div>
    <div class="row">
     <div class="col-lg-12 mx-auto">
        <div class="page-header clearfix">
         <h2 class="pull-left mt-4">Users List&nbsp;&nbsp;&nbsp;&nbsp;</h2>
        </div>
        <?php 
          $num_per_page=1000;
          if (isset($_GET["page"])) {
              $page=$_GET["page"];
          }else{
            $page=1;
          }
           $start_from=($page-1)*1000;
           $result = mysqli_query($conn, "SELECT * FROM users limit $start_from,$num_per_page");
         if (mysqli_num_rows($result) > 0) { ?>
         <table class='table table-bordered table-striped mt-3'>
            <tr>
                <td>No</td>
                <td>Firstname</td>
                <td>Lastname</td>
                <td>Email id</td>
                <td>Address</td>
            </tr>
            <?php  $i = 1;
             while ($row = mysqli_fetch_array($result)) { ?>
            <tr><td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["first_name"]; ?></td>
                <td><?php echo $row["last_name"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td><?php echo $row["address"]; ?></td>
            </tr>
            <?php } ?>
         </table>
            <?php } else {
                    echo "No result found"; }  ?>
             
     </div>
    </div>
   </div>
<?php 
   $rs = mysqli_query($conn, "select * from users");
   $total_record = mysqli_num_rows($rs);
   $total_pages = ceil($total_record/$num_per_page);
   for($i=1;$i<=$total_pages;$i++) {
    echo "<a href='dummy_table.php?page=" . $i . "'>" . $i . "</a> " ;
   }
?>
</body>

<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{query:query},
   success:function(data)
   {
    $('#result').html(data);
   }
  });
 }
 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);
  }
  else
  {
   load_data();
  }
 });
});
</script>
</head>
</html>