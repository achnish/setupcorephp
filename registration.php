
<!DOCTYPE html>
<?php 
if(isset($_SESSION['email'])) {
  header("location:registration.php");
 }
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
   <?php include "head.php"; ?>
<body>
  
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <?php  if(isset($_SESSION['status'])){  ?>
                   <div id="alert" class="alert alert-primary" role="alert"> <?php echo $_SESSION['status']; ?> </div>
                    <?php unset($_SESSION['status']); } ?>
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
            <form action="adduser.php" method="post" id="form"  enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 mb-3">

                  <div class="form-outline">
                    <label class="form-label">First Name</label>
                     <input type="text" id="firstname" name="firstname" class="form-control" maxlength="50" class="form-control form-control-lg" />
                  </div>
                </div>
                <div class="col-md-6 mb-3">

                  <div class="form-outline">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" maxlength="50" class="form-control form-control-lg" />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3 d-flex align-items-center">

                  <div class="form-outline datepicker w-100">
                    <label for="birthdayDate" class="form-label">Birthday</label>
                    <input type="date" id="birthdate" name="birthdate" class="form-control" maxlength="50" class="form-control form-control-lg"/>
                   
                  </div>

                </div>
                <div class="col-md-6 mb-3">

                  <h6 class="mb-2 pb-1">Gender: </h6>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="gender"
                      id="female"
                      value="female" checked
                    />
                    <label class="form-check-label" for="femaleGender">Female</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="gender"
                      id="male"
                      value="male"

                    />
                    <label class="form-check-label" for="maleGender">Male</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="gender"
                      id="other"
                      value="other"
                    />
                    <label class="form-check-label" for="otherGender">Other</label>
                  </div>
                   
                </div>
               
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">

                  <div class="form-outline">
                     <label class="form-label" for="emailAddress">Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="" maxlength="50" class="form-control form-control-lg" />
                    
                  </div>

                </div>
                <div class="col-md-6 mb-3">

                  <div class="form-outline">
                    <label class="form-label" for="phoneNumber">Phone Number</label>
                   <input type="text" name="phoneno" id="phoneno" class="form-control" value="" maxlength="50" class="form-control form-control-lg" />
                  
                  </div>

                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                        <label for="role" class="mb-2">Select Role</label>
                        <select name="role" id="role" class="form-control">
                             <option selected="" disable> Select Role</option>
                             <?php
                              include "connection.php"; 
                              $sql = "SELECT name From role";
                             $query_run = mysqli_query($conn,$sql);
                          while($data = mysqli_fetch_array($query_run))
                          {
                              echo "<option value='". $data['name'] ."'>" .$data['name'] ."</option>";  
                          } 
                      ?>  
                        </select>
                    
                    </div>
                  </div>
                  <div class="col-md-6">
                   <span>Select languages</span><br/>
                   <div class="row">
                    <div class="col-md-4 mt-2">
                     <input type="checkbox" class="check" name='lang[]' value="hindi" id="hindi" checked> Hindi  </div>
                    <div class="col-md-4 mt-2">
                    <input type="checkbox" class="check" name='lang[]' value="english" id="english" checked> English </div>
                    <div class="col-md-4 mt-2">
                    <input type="checkbox" class="check" name='lang[]' value="gujarati" id="gujarati" checked> Gujarati </div>
                  
                    <div class="err">Select Atleast one</div>
                  </div>
                 </div>
               </div>
                <div class="row">
                <div class="col-md-6 mt-2">

                  <div class="form-outline">
                     <label class="form-label" for="pass">Password</label>
                    <input type="Password" name="pass" id="pass" class="form-control" value="" maxlength="50" class="form-control form-control-lg"  />
                  
                  </div>
                  
                </div>
               
                 <div class="col-md-6 mt-2">

                  <div class="form-outline">
                     <label class="form-label" for="pass">Confirm Password</label>
                    <input 
                    type="Password" name="cpass" id="cpass" class="form-control" value="" maxlength="50" class="form-control form-control-lg" />
                   
                  </div>
                   
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 mt-2">
                   <label for="title">Select Country:</label>
                <select id="country" name="country" class="form-control">
                    <option value="">--- Select Country ---</option>
                    <?php
                        //require('db_config.php');
                        $sql = "SELECT * FROM country"; 
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()){
                            echo "<option value='".$row['id']."'>".$row['country_name']."</option>";
                        }
                    ?>
                </select>
                </div>
                <div class="col-md-4 mt-2">
                  <label for="title">Select State:</label>
                <select id="state" name="state" class="form-control">
                </select>
                </div>
                <div class="col-md-4 mt-2">
                  <label for="title">Select City:</label>
                <select id="city" name="city" class="form-control">
                </select>
                </div>
              </div>

               <div class="row">
                <div class="col-md-12 mt-2">
                  <label for="birthdayDate" class="form-label">Address</label>
                <div class="form-floating">
                  <textarea name="address" class="form-control" id="address"></textarea>
                  
                </div></div></div>
                <div class="mt-3 pt-4">
                <div class="row">
                <div class="col-md-8 mt-2">
                
                 <input type="submit" class="btn btn-dark" name="submit" value="submit"></div>
                 <div class="col-md-4 mt-2">
                 <a href="index.php" class="btn btn-dark">Go To Login</a>
              </div></div></div>

                </div>
              </div>
              

            </form>
          </div>
        </div>
      </div>
</section>
<style>
  .error {
    color: red;

  }
  /*.err {
    color: red;
  }*/
</style>
<script>
$(document).ready(function() {
$('#country').on('change', function() {
var country_id = this.value;
$.ajax({
url: "fetch_location.php",
type: "POST",
data: {
country_id: country_id
},
cache: false,
success: function(result){
$("#state").html(result);
$('#city').html('<option value="">Select State First</option>'); 
}
});
});    
$('#state').on('change', function() {
var state_id = this.value;
$.ajax({
url: "fetch_location.php",
type: "POST",
data: {
state_id: state_id
},
cache: false,
success: function(result){
$("#city").html(result);
}
});
});
});
</script>

<script type="text/javascript">
  $(document).ready(function () {
     $(".check").click(function(){
        if ($("input:checkbox").filter(":checked").length < 0) {
          $(".err").show();
          return false;
        } else {
          $(".err").hide();
          return true;
        }
      });
    $('#form').validate({
     
      rules: {
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
          required: true,
          email: true
        },
        phoneno: {
          required: true,
          rangelength: [10, 12],
          number: true
        },
        pass: {
          required: true,
          minlength: 6
        },
        cpass: {
          required: true,
          equalTo: "#pass"
        },
        address: {
          required: true
        }
      },
      messages: {
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
          rangelength: 'Contact should be 10 digit number.',
        },
        pass: {
          required: 'Please enter Password.',
          minlength: 'Password must be at least 6 characters long.',
        },
        cpass: {
          required: 'Please enter Confirm Password.',
          equalTo: 'Confirm Password do not match with Password.',
        },
        address: 'Please enter Address.'
      },

      submitHandler: function (form) {
        form.submit();
      }
    });
  });
     
</script>
 <script type="text/javascript">
        setTimeout(function () {
            $('#alert').alert('close');
        }, 5000);
    </script>
  </div>
</div>
</section>
</body>
</head>

</html>