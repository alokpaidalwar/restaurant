<?php
  require_once('lib/db_functions.php');
  $db = new db();
  $msg="";
  if (isset($_POST['submit'])) {
      // receiving the post parameters
      $username = $_POST['username'];
      $password = $_POST['password'];
      $fullname = $_POST['fullname'];
      // call the method to register and show msg based on result
      $result = $db->registerUser($username,$password,$fullname);

      if(is_null($result)){
          $msg = '<p class="red-text"> User with given username already exist. Please try another username. </p>';
      }else{
          $msg = '<p class="green-text"> You are registered successfully.
                        <a href="index.php">Click here to Login </p> ';
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/compiled.min.css">

    <title>User Registration</title>
  </head>
  <body>
    <!--Header-->
    <header class="stylish-color-dark text-center text-white z-depth-3">
      <h2 class="h2-responsive font-weight-bold p-3">
        <i class="fa fa-utensils animated fadeIn " style="color:Tomato"></i> ABC Restaurant 
      </h2>
    </header>
    <!--/.Header-->

    <!-- Container -->
    <div class="container-fluid my-5">
      <!-- Row 1 -->
      <div class="row text-center justify-content-center">
          <?php echo $msg; ?> 
      </div>
      <!-- /. Row 1 -->
      <!-- Row 2 -->
      <div class="row justify-content-center">
         <div class="col-lg-6 col-sm-12 mb-5">
            <!--Modal: User registration-->
            <div class="modal-dialog cascading-modal" role="document">
              <!--Content-->
              <div class="modal-content">
                  <!-- Header-->
                  <div class="modal-header info-color-dark white-text">
                      <h4 class="h4-responsive title">
                          <i class="fas fa-user-plus"></i> User Registration
                      </h4>
                  </div>
                  <!-- /.Header-->
                  <!-- Body-->
                  <div class="modal-body">
                    <!--Form User registration-->
                    <form name="UserRegistration" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <!-- Input User fullname -->
                        <div class="md-form form-sm">
                            <i class="fas fa-user prefix"></i>
                            <input type="text" id="fullname" name="fullname"  class="form-control form-control-sm" pattern="[a-zA-Z][a-zA-Z ]*" title="Only alphabets are allowed" required>
                            <label for="fullname">Full name</label>
                        </div>
                        <!-- Input User username -->
                        <div class="md-form form-sm">
                            <i class="fas fa-id-badge prefix"></i>
                            <input type="text" id="username" name="username" class="form-control form-control-sm" pattern="[A-Za-z]{6,}" title="Username must be at least 6 characters and only alphabets are allowed.No space allowed" required>
                            <label for="username">Username</label>
                        </div>
                        <!-- Input User password -->
                        <div class="md-form form-sm">
                            <i class="fas fa-lock prefix"></i>
                            <input type="password" id="password" name="password" class="form-control form-control-sm" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$" title="Minimum six characters, at least one letter, one number and one special character" required>
                            <label for="password">Password</label>
                        </div>
                        <!-- Input User submit form --> 
                        <div class="text-center mt-4 mb-2">
                            <input type="submit" value="Signup" name="submit" class="btn blue-gradient">
                        </div>
                    </form>
                    <!--/.Form User registration-->
                  </div>
                  <!-- /.Body-->
                  <!--Footer-->
                  <div class="modal-footer">
                      <div class="text-right mt-1">
                        <p>Already a member? <a href="index.php" class="blue-text">Sign In</a></p>
                      </div>
                  </div>
                  <!-- /.Footer-->
              </div>
              <!-- /.Content-->
            </div>
            <!--/Modal: User registration-->
          </div>
      </div>
      <!-- /. Row 2 -->
    </div>  
    <!--/. Container -->

    <!-- Footer -->
     <?php include('footer.html'); ?>
    <!--/. Footer -->

    <!-- Bootstrap js -->        
    <script src="js/compiled.min.js"></script>
    <!-- FontAwesome -->
    <script defer src="js/fontawesome-all.min.js"></script>

  </body>
</html>  