<!DOCTYPE html>
<?php  include "nav.php";
      include_once 'connection.php';
      include "urlprevent.php";
  include "head.php"; 
 
  include_once 'connection.php';?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script>
      function export_emp()
    {
        if (confirm('Are You Sure to Export this Record?'))
        {
            window.location.href = 'export_fake_data.php';
        }
    }
    </script>

<body>
  <div class="container">
    <div class="container-fluid mt-4">
    <form class="d-flex">
      <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Type your search query here" />
           <span class="btn btn-dark">Search</span>
    </form>
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
<div class="col-xs-12 mt-3">
    <div id="alert" class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
</div>
<?php } ?>
    <div class="row mt-5">
      <div class="col-md-10"></div>
      <div class="col-md-2">
     <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal">import</button>
      <a href="javascript: export_emp()" class="btn btn-dark"><i class="exp"></i> Export</a>
  </div></div>
  <div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Import Data</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form role="form" id="newModalForm" method="post" action="import_dummy_data.php" enctype="multipart/form-data">
      <!-- Modal body -->
      <div class="modal-body">
         <input type="file" name="csv_file" id="csv_file" accept=".csv"/>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <p><a href="DEMO_DUMMY_RECORD.csv" download>Download Sample File</a></p>
        <input type="submit" class="btn btn-dark" name="submit" value="Import">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>
     </form>
    </div>
  </div>
</div>
  </div>
 <div class="table-responsive" id="dynamic_content">
  </div>
</div>
  </body>
</html>
<script>
  $(document).ready(function(){
    load_data(1);
    function load_data(page, query = '')
    {
      $.ajax({
        url:"f1.php",
        method:"POST",
        data:{page:page, query:query},
        success:function(data)
        {
          $('#dynamic_content').html(data);
        }
      });
    }

    $(document).on('click', '.page-link', function(){
      var page = $(this).data('page_number');
      var query = $('#search_box').val();
      load_data(page, query);
    });

    $('#search_box').keyup(function(){
      var query = $('#search_box').val();
      load_data(1, query);
    });
  $(document).on('click', '.column_sort', function(){
        var column_name = $(this).attr("id");
        var order = $(this).data("order");
        var arrow = '';
        if(order == 'desc'){
            arrow = '<span class="glyphicon glyphicon-arrow-down"></span>';
        }else{
            arrow = '<span class="glyphicon glyphicon-arrow-up"></span>';
        }  
        $.ajax({
            url:"sort.php",
            method: "POST",
            data : {column_name:column_name, order:order},
            success: function(data){
                $('#dynamic_content').html(data);
                $('#'+column_name+'').append(arrow);
            }
        })
    });
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
 <script type="text/javascript">
        setTimeout(function () {
            $('#alert').alert('close');
        }, 3000);
    </script>

