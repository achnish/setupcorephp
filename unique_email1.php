<?php
require_once "connection.php";

            $email =$_POST['email'];
			$sqlcheck = "SELECT email FROM registration WHERE email = '$email' ";
            // echo "email .$email";
			$checkResult = $conn->query($sqlcheck);

			// check if email already taken
			if($checkResult->num_rows > 0) {
                echo "false";
               
            }else{
                echo "true";
               
            }
        
     
?>