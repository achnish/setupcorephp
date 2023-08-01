<?php
error_reporting(0);
session_start();

require_once "connection.php";
//include "emp_info.php";
if (count($_POST) > 0) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $designation = $_POST['designation'];
    $manager_id = getIDbyName($_POST['manager_id']);
    $address = $_POST['address'];
    $image = $_FILES["profile_image"]["name"];
    $profile_image_old = $_POST['profile_image_old'];

    if ($image != '') {
        $filename = $_FILES["profile_image"]["name"];
        $tempname = $_FILES["profile_image"]["tmp_name"];    
        $folder = "uploads/".$filename;     
   } else {
    $filename = $profile_image_old;
   }

   

    $sql = mysqli_query($conn, "UPDATE cruddetails set firstname='" . $firstname . "', lastname='" . $lastname . "' ,birthdate='" . $birthdate . "',gender='" . $gender . "',email='" . $email . "',phoneno='" . $phoneno . "',designation='" . $designation . "',address='" . $address . "',manager_id='" . $manager_id . "',image='" . $filename . "' WHERE id='" . $_POST['id'] . "'");
    
   // $query_run = mysqli_query($conn,$sql);
   //  if ($query_run) {
       // if (move_uploaded_file($tempname, $folder))  {
       //   $q = move_uploaded_file($tempname, $folder);
       //      $msg = "Image uploaded successfully";
       //  } 

        if($_SESSION['role'] == 'admin'){  
      $_SESSION['status'] = 'Data Successfully Updated';
    header("location: emp.php");
    } else{
      $_SESSION['status'] = 'data successfully Updated';
    header("location: emp_info.php");
    // }
} }
    foreach ($_GET as $key => $data) {
       $data2 = $_GET[$key] = base64_decode(urldecode($data));
       $decrypt = ((($data2*956783)/5678)/123456789);
      }              
    $result = mysqli_query($conn, "SELECT * FROM cruddetails WHERE id='$decrypt'");
    $row = mysqli_fetch_array($result);
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
   <?php  session_start(); 

 include "urlprevent.php";
 ?>
    <?php include "head.php"; ?>
    <?php include "nav.php"; ?>
   

<body>
    <section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
                <form id="form" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-5">
                      <h2> Edit Employee </h2>
                    </div>
                    <div class="col-md-7">
                      <?php if ($row["manager_id"] != '') { ?>
                        <input type="hidden" name="manager_id" value="<?php echo getmanagerByID($row["manager_id"]); ?>">
                        <?php } else { ?>
                        <label for="manager" class="mb-2">Select Role</label>
                        <select name="manager_id" id="manager_id" class="form-control">
                             <option selected="" disable> Select Manager</option>
                             <?php
                              //include "connection.php"; 
                              $sql = "SELECT firstname From registration";
                             $query_run = mysqli_query($conn,$sql);
                          while($data = mysqli_fetch_array($query_run))
                          {
                              echo "<option value='". $data['firstname'] ."'>" .$data['firstname'] ."</option>";  
                          } 
                      ?>  
                        </select>
                        <?php } ?>
                    </div>
                  </div>
                      <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                          <div class="form-outline">
                            <label class="form-label">First Name</label>
                             <input type="text" name="firstname" class="form-control" value="<?php echo $row["firstname"]; ?>" maxlength="50" required="" class="form-control form-control-lg" />
                          </div>
                        </div>
                    <div class="col-md-6 mb-3">

                  <div class="form-outline">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" class="form-control" value="<?php echo $row["lastname"]; ?>" maxlength="50" required=""class="form-control form-control-lg" />
                    
                  </div>

                </div>
              </div>
                     <div class="row">
                <div class="col-md-6 mb-3 d-flex align-items-center">
                  <div class="form-outline datepicker w-100">
                    <label for="birthdayDate" class="form-label">Birthday</label>
                    <input type="date" name="birthdate" class="form-control" value="<?php echo $row["birthdate"]; ?>" maxlength="50" required=""
                      class="form-control form-control-lg"/>
                  </div>
                </div>
                   <div class="col-md-6 mb-3">

                  <h6 class="mb-2 pb-1">Gender: </h6>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input" type="radio" name="gender" id="femalegender" value="female"
                      <?php if($row['gender']=="female"){echo "checked";}?> />
                    <label class="form-check-label" for="femaleGender">Female</label>
                  </div>
                   <div class="form-check form-check-inline">
                    <input
                      class="form-check-input" type="radio" name="gender" id="malegender" value="male"
                     <?php if($row['gender']=="male"){echo "checked";}?> />
                    <label class="form-check-label" for="maleGender">Male</label>
                  </div>
                   <div class="form-check form-check-inline">
                    <input
                      class="form-check-input" type="radio" name="gender" id="othergender" value="other"
                     <?php if($row['gender']=="other"){echo "checked";}?> />
                    <label class="form-check-label" for="maleGender">Other</label><br>
                  </div>
              </div>
          </div>

           <div class="row">
                <div class="col-md-6 mb-3">

                  <div class="form-outline">
                     <label class="form-label" for="emailAddress">Email</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $row["email"]; ?>" maxlength="50" required=""class="form-control form-control-lg" />
                   </div>
                  </div>
                   <div class="col-md-6 mb-3">

                  <div class="form-outline">
                    <label class="form-label" for="phoneNumber">Phone Number</label>
                   <input type="text" name="phoneno" class="form-control" value="<?php echo $row["phoneno"]; ?>" maxlength="50" required=""class="form-control form-control-lg" />
                  </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                        <label for="designation" class="mb-2">Select Designation</label>
                        <select name="designation" id="designation" class="form-control">
                            <option value="select">Select Designation</option>
                            <option value="teamleader" <?php echo $row["designation"] == "teamleader" ? 'selected="selected"' : '';  ?> >Team Leader</option>
                            <option value="developer" <?php echo $row["designation"] == "developer" ? 'selected="selected"' : '';  ?> >Developer</option>
                            <option value="hr" <?php echo $row["designation"] == "hr" ? 'selected="selected"' : '';  ?> >HR</option>
                            <option value="designer" <?php echo $row["designation"] == "designer" ? 'selected="selected"' : '';  ?> >Designer</option>
                        </select>
                    </div>
                  </div>
                   <?php
                    $lang = explode(",", $row["lang"]);
                    ?>
                  <div class="col-md-6">
                   <span>Select languages</span><br/>
                   <div class="row">
                    <div class="col-md-4 mt-2">
                     <input type="checkbox" name='lang[]' value="hindi" id="hindi" <?php if (in_array("hindi", $lang)) { ?> checked <?php }; ?>> Hindi  </div>
                    <div class="col-md-4 mt-2">
                    <input type="checkbox" name='lang[]' value="english" id="english" <?php if (in_array("english", $lang)) { ?> checked <?php }; ?>> English </div>
                    <div class="col-md-4 mt-2">
                    <input type="checkbox" name='lang[]' value="gujarati" id="gujarati" <?php if (in_array("gujarati", $lang)) { ?> checked <?php }; ?>> Gujarati </div></div>
                 </div>
               </div>
                   
                    <div class="row mt-3">
                <div class="col-md-12 mt-2">
                  <label for="birthdayDate" class="form-label">Address</label>
                <div class="form-floating">
                  <textarea name="address" class="form-control" id="address"><?php echo $row["address"]; ?></textarea>
                </div></div></div>
                <div class="row mt-3">
                <div class="col-md-6 mt-2">
                   <label for="birthdayDate" class="form-label">Update Image</label>
                  
                   <input type="file" name="profile_image" id="profile_image" onchange="previewFile(this);">
                   <input type="hidden" name="profile_image_old" value="<?php echo $row["image"]; ?>">
                   <div class="col-md-6 mt-2">
                   <?php 
                        if(empty($row["image"]) ){
                          
                             echo "image not uploaded";

                           echo '<img id="previewImg" style="width: 100px;" >';
                        } else {
                           echo '<img src="uploads/'.$row["image"].'" style="width: 100px;">';
                         
                        }
                    ?>
                  </div>
                   </div>
                </div>
                </div>
              </div>
                    <div class="mt-3 pt-2">
                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>" />
                 <input type="submit" class="btn btn-primary" name="save" value="submit">
                 <?php if($_SESSION['role'] == 'admin')  { ?>
                 <a href="emp.php" class="btn btn-default">All Employees</a>
                 <?php } else { ?>
                  <a href="emp_info.php" class="btn btn-default">All Employees</a>
                 <?php } ?>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<style>
  .error {
    color: red;
  }
</style>
<script type="text/javascript">
  $(document).ready(function () {
    $('#form').validate({
      rules: {
        manager_id: {
          required: true
        },
        firstname: {
          required: true
        },
        lastname: {
          required: true
        },
        birthdate: {
          required: true
        },
        gender: {
          required: true
        },
        email: {
          email: true,
          remote: {
        url: "unique_email1.php",
        type: "post",
        data: {
          email: function() {
           return $('#form :input[name="email"]').val();
          }
        }
      }
        },
        phoneno: {
          required: true,
          rangelength: [10, 12],
          number: true
        },
        address: {
          required: true
        },
        profile_image_old: {
          required: true
        }
      },
      messages: {
        manager_id: 'Please Select Manager.',
        firstname: 'Please enter FirstName.',
        lastname: 'Please enter LastName.',
        birthdate: 'Please Select birthdate.',
        gender: 'Please Select .',
        email: {
          required: 'Please enter Email Address.',
          email: 'Please enter a valid Email Address.',
        },
        phoneno: {
          required: 'Please enter Contact.',
          rangelength: 'Contact should be 10 digit number.'
        },
        address: 'Please Enter Address.',
        profile_image_old: 'Please Select Image.',
      },

      submitHandler: function (form) {
        form.submit();
      }
    });
  });
</script>
<script>
    function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }
  </script>
 
</body>
</head>
</html>