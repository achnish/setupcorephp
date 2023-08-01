
<?php 
ob_start();
session_start(); 

 if(isset($_SESSION['email'])) {
 header("location:home_page.php");
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://www.markuptag.com/bootstrap/5/css/bootstrap.min.css">
    <?php include "head.php"; ?>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-7 offset-md-3 mt-4">
              <?php  if(isset($_SESSION['status'])){  ?>
                   <div class="alert alert-primary" id="alert" role="alert"> <?php echo $_SESSION['status']; ?> </div>
                    <?php unset($_SESSION['status']); } ?>
                <div class="login-form bg-light mt-5 p-4">
                    <form action="" method="post" class="row" id="loginForm">
                        <h4>Login </h4>
                        <div class="col-12 mt-5">
                            <label>Username</label>
                            <input id="email" type="text" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-12 mt-4">
                            <label>Password</label>
                            <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        
                        <div class="col-8 mt-5">
                            <button type="submit" name="login" value="login" class="btn btn-dark">Login</button>
                        </div>
                         <div class="col-4 mt-5">
                           <a href="registration.php" class="btn btn-dark">Register Now</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
    .btn-dark {
    color: #fff;
    background-color: #800080;
    border-color: #212529;
}
  .error {
    color: red;
  }
</style>
    <script type="text/javascript">
    $(document).ready(function(){

    $("#loginForm").validate({
        rules: {
            email: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Please Enter Email"
            },
            password: {
                required: "Please Enter Valid Password"
            }
        }
    });

});
    </script>
     <script type="text/javascript">
        setTimeout(function () {
            $('#alert').alert('close');
        }, 5000);
    </script>
</body>
</head>
</html>

<?php 

  require_once "connection.php";
  //session_start();

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password = md5($password);


 $q = mysqli_query($conn,"SELECT * FROM registration WHERE email = '$email' AND pass = '$password' ");
 $row = mysqli_fetch_array($q);
 
 if(is_array($row)){

     if($row['active'] == 0){
        $_SESSION['status'] = 'You Are Not Activate. Please Inform To Admin';
        header("location: index.php");
     } else {

  $_SESSION["role"] = $row['role'];
   $_SESSION["id"] = $row['id'];
  $_SESSION["email"] = $row['email'];
  $_SESSION["password"] = $row['pass'];
   $_SESSION['status'] = 'successfully Login';
       header("location: home_page.php");
         exit();
    }} else {
         $_SESSION['status'] = 'Please Enter valid email or password';
        header("location: index.php");
    }
}
// if(isset($_SESSION["email"])){
//   //header("Location:check.php");
// }
?>

