<?php
include_once 'connection.php';
session_start();
  
    if (isset($_GET['id'])){

        $active_id = $_GET['id'];
        $q = mysqli_query($conn,"SELECT * FROM cruddetails where id = '$active_id'");
         $row = mysqli_fetch_array($q);

         $id = $row['manager_id'];
        $email = getemailByID($id);

        $emp_mail = $row['email'];

      require 'vendor/autoload.php';
          $mail = new PHPMailer(true); 
          $subject = 'Registration mail of employee';
          $message = 'Below Employee are successfully imported' .'</br>'. 'thrir Email : '.$emp_mail.' ' .'</br>'. '';                           
    try {
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
 
        $mail->addAddress($email);              
        $mail->addReplyTo('modi.himani.3110@gmail.com');
 
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
 
        //$mail->send(); 
        if($mail->send())
    {
        $q = mysqli_query($conn,"UPDATE cruddetails SET email_status = 1 where id = '$active_id'" );
        mysqli_query($conn,$q);
         $_SESSION['status'] = 'Mail Successfully Sent';
        header("location: emp.php");
    }
    else{
        $_SESSION['status'] = "failure due to the google security";
         header("location: emp.php");
    } 
    } catch (Exception $e) {
     $_SESSION['result'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
     $_SESSION['status'] = 'Please Assign Manager To Employee';
    }}

    header('location: emp.php');
?>