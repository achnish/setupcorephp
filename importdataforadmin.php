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
                $address = $line[4];
                $role = $line[5];
                $active = 1;
                $email_status = 0;

                $length = 8;
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $pass = substr(str_shuffle($chars),0,$length);
                $md5pass = md5($pass);
                

                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT id FROM registration WHERE email = '".$line[2]."'";
                $prevResult = $conn->query($prevQuery);
                
                if($prevResult->num_rows > 0){
                    // Update member data in the database
                  $sql =  $conn->query("UPDATE registration SET firstname = '".$firstname."',lastname = '".$lastname."',email = '".$email."', phoneno = '".$phone."', pass = '".$md5pass."', cpass = '".$pass."',address = '".$address."',role = '".$role."', active = '".$active."',email_status = '".$email_status."', modified = NOW() WHERE email = '".$email."'");
                }else{
                    // Insert member data in the database
                 $sql =  $conn->query("INSERT INTO registration (firstname,lastname,email,phoneno,pass,cpass,address,role,active,email_status) VALUES ('".$firstname."', '".$lastname."', '".$email."','".$phone."','".$md5pass."','".$pass."','".$address."','".$role."','".$active."','".$email_status."')");
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

   require 'vendor/autoload.php';
    $mail = new PHPMailer(true); 
    $subject = 'Registration mail';
     $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                             
        $mail->Username = 'modi.himani.3110@gmail.com';     
        $mail->Password = 'himani@1234';    
         $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;   
        $mail->setFrom('modi.himani.3110@gmail.com'); 
         $subject = 'Welcome mail';
            

    $q = "SELECT * FROM registration WHERE email_status = '0' ";
    $rs = mysqli_query($conn, $q);
     if(mysqli_num_rows($rs) > 0) {
       while($x = mysqli_fetch_assoc($rs)) {
        $mail->addAddress($x['email']);
        $pass = $x['cpass'];
    }
         
 $message = 'your Registration successfully Done' .'</br>'. 'Your Email : '.$email.' ' .'</br>'. 'Your Password : '.$pass.' ';         
       
        $mail->addReplyTo('modi.himani.3110@gmail.com');
 
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
 
        $mail->send();  

 }
}
// Redirect to the listing page
header("Location: users.php".$qstring);
?>