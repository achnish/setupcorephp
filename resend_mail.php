<?php
include_once 'connection.php';
  
    if (isset($_GET['id'])){

    	 $active_id = $_GET['id'];
    	  $result = mysqli_query($conn, "SELECT * FROM registration where id = '$active_id'");
        $row = mysqli_fetch_array($result);
        $email=$row['email'];
        $pass=$row['cpass'];
        
      require 'vendor/autoload.php';
          $mail = new PHPMailer(true); 
          $subject = 'Registration mail';
          $message = 'your Registration successfully Done' .'</br>'. 'Your Email : '.$email.' ' .'</br>'. 'Your Password : '.$pass.' ';                           
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
 
        $mail->send();  
    } catch (Exception $e) {
     $_SESSION['result'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
     $_SESSION['status'] = 'error';
    }}
    header('location: users.php');
?>
    