<?php 
// Load the database configuration file 
session_start();
include_once 'connection.php'; 
 
$filename = "employee's_data_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 
 
// Set column headers 
$fields = array('Firstname','Lastname','Birthdate','Gender','Email','Phone','Designation','Language','Address', 'Active','Manager'); 
fputcsv($f, $fields, $delimiter); 
 
// Get records from the database 
if($_SESSION['role'] == 'admin') {
    $result = $conn->query("SELECT * FROM cruddetails ORDER BY id DESC"); 
} else {
   $result = $conn->query("SELECT * FROM cruddetails WHERE manager_id = '$_SESSION[id]' ORDER BY id DESC");  
}
if($result->num_rows > 0){ 
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $result->fetch_assoc()){ 
    	if($row['status'] == 1){
    		$status = 'Active';
    	} else {
    		$status = 'deactive';
    	}
        $lineData = array($row['firstname'], $row['lastname'], $row['birthdate'], $row['gender'], $row['email'], $row['phoneno'], $row['designation'], $row['lang'], $row['address'], $status, getmanagerByID($row['manager_id'])); 
        fputcsv($f, $lineData, $delimiter); 
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