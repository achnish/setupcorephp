<?php 
// Load the database configuration file 
include_once 'connection.php'; 
// print_r($_GET['role']);
// exit();
 
$filename = "User's_data" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 
 
// Set column headers 
$fields = array('Firstname','Lastname','Birthdate','Gender','Email','Phone','Language','Address', 'Active','Role'); 
fputcsv($f, $fields, $delimiter); 
 
// Get records from the database 
if(isset($_GET["role"]))  
 { 
    
      if($_GET["role"] == 'manager' || $_GET["role"] == 'precident' )  
      {  
        
        $sql = "SELECT * FROM registration WHERE role != 'admin' AND role = '".$_GET['role']."'  ";    
      }  
      else  
      {  
             $sql = "SELECT * FROM registration WHERE role != 'admin' ORDER BY id DESC"; 
      } 
    
 $result = mysqli_query($conn,$sql);

if($result->num_rows > 0){ 
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $result->fetch_assoc()){ 
    	if($row['active'] == 1){
    		$status = 'Active';
    	} else {
    		$status = 'deactive';
    	}
        $lineData = array($row['firstname'], $row['lastname'], $row['birthdate'], $row['gender'], $row['email'], $row['phoneno'], $row['language'], $row['address'], $status, $row['role'] ); 
        fputcsv($f, $lineData, $delimiter); 
    } 
} 
 }
// Move back to beginning of file 
fseek($f, 0); 
 
// Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
// Output all remaining data on a file pointer 
fpassthru($f); 
 
// Exit from file 
exit();