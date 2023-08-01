<?php
// Load the database configuration file
session_start();
include_once 'connection.php';

if(isset($_POST['submit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['csv_file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $firstname   = $line[0];
                $lastname = $line[1];
                $email  = $line[2];
                $phone  = $line[3];
                $designation = $line[4];
                $address = $line[5];
                $status = 1;
                $active = 1;
                $email_status = 0;
               
                
                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT id FROM cruddetails WHERE email = '".$line[2]."'";
                $prevResult = $conn->query($prevQuery);
                
                if($prevResult->num_rows > 0){
                    // Update member data in the database
                 $sql = $conn->query("UPDATE cruddetails SET firstname = '".$firstname."',lastname = '".$lastname."',email = '".$email."', phoneno = '".$phone."',designation = '".$designation."',address = '".$address."',status = '".$status."', active = '".$active."', email_status = '".$email_status."', modified = NOW() WHERE email = '".$email."'");
                }else{
                    // Insert member data in the database
                 $sql = $conn->query("INSERT INTO cruddetails (firstname,lastname,email,phoneno,designation, address,status,active,email_status) VALUES ('".$firstname."', '".$lastname."', '".$email."','".$phone."','".$designation."','".$address."', '".$status."','".$active."','".$email_status."')");
                }
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }

// Redirect to the listing page
if($_SESSION['role'] == 'admin'){
    header("Location: emp.php".$qstring);
 } else {
   header("Location: emp_info.php".$qstring);
    }
}
?>