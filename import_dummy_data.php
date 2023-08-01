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
                $address = $line[3];
               
                
                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT id FROM users WHERE email = '".$line[2]."'";
                $prevResult = $conn->query($prevQuery);
                
                if($prevResult->num_rows > 0){
                    // Update member data in the database
                 $sql = $conn->query("UPDATE users SET first_name = '".$firstname."',last_name = '".$lastname."',email = '".$email."',address = '".$address."', modified = NOW() WHERE email = '".$line[2]."'");
                 
                }else{
                    // Insert member data in the database
                 $sql = $conn->query("INSERT INTO users (first_name,last_name,email,address) VALUES ('".$firstname."', '".$lastname."', '".$email."','".$address."')");
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

   header("Location: fake_record.php".$qstring);
    
}
?>