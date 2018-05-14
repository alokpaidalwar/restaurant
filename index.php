<?php
    require_once("lib/db_functions.php");
    $db = new db();
    $msg="";
    // check if already login
    if(isset($_SESSION['username'])){
        $user_check=$_SESSION['username'];
        $row=$db->getOne("SELECT * FROM users_info WHERE username='$user_check'");
        $user =$row['username'];
        if(isset($user)){
                header('Location: home.php'); 
        }
    }
    if (isset($_POST['login'])) {
        // receiving the post parameters
        $username = $_POST['username'];
        $password = $_POST['password'];
        // call the method to login
        $result = $db->validateUser($username,$password);
        if(is_null($result)){
            $msg= '<p class="red-text"> Username or password is not correct. </p>';
        }else{
            header("Location: home.php");
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

        <title>Login Page</title>
  </head>
  <body>
    <!--Header-->
     <header class="stylish-color-dark text-center text-white z-depth-3">
        <h2 class="h2-responsive font-weight-bold p-3"> 
          <i class="fa fa-utensils animated fadeIn " style="color:Tomato"> </i> ABC Restaurant 
        </h2>
     </header>
    <!--/.Header-->

    <!-- Container -->
    <div class="container-fluid my-5">
      <!-- Row 1 -->
      <div class="row text-center justify-content-center ">
          <?php echo $msg; ?> 
      </div>
      <!-- /. Row 1 -->
      <!-- Row 2 -->
      <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12 mb-5">
            <!--Modal: Login -->
            <div class="modal-dialog cascading-modal" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header info-color-dark white-text">
                       <h4 class="h4-responsive title"><i class="fas fa-users"></i> Login </h4>
                    </div>
                    <!-- /.Header-->
                    <!--Body-->
                    <div class="modal-body mb-1">
                        <!-- Form  login-->
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <!-- Input username -->
                            <div class="md-form form-sm mb-5" >
                                <i class="fa fa-user prefix"></i>
                                <input type="text"  id="username" name="username" class="form-control form-control-sm validate" required>
                                <label for="username">Your username</label>
                            </div>
                            <!-- Input password -->
                            <div class="md-form form-sm mb-4">
                                <i class="fa fa-lock prefix"></i>
                                <input type="password" id="password" name="password" class="form-control form-control-sm validate" required>
                                <label for="password" >Your password</label>
                            </div>
                            <!-- Input submit -->
                            <div class="text-center mt-2">
                                <input type="submit" value="Login" name="login" class="btn blue-gradient">
                            </div>
                        </form>
                        <!-- /.Form login --> 
                    </div>
                    <!-- /.Body -->
                    <!--Footer-->
                    <div class="modal-footer">
                        <div class="text-right mt-1">
                           <p>Not a member? <a href="registration.php" class="blue-text">Sign Up</a></p>
                        </div>
                    </div>
                    <!-- /.Footer-->
                </div>
                <!--/.Content-->
            </div>
            <!--/Modal: Login-->
        </div>
      </div> 
      <!-- /. Row 2 -->
    </div>
    <!-- /. Container -->

    <!-- Footer -->
      <?php include('footer.html'); ?>
    <!--/. Footer -->

    <!-- Bootstrap js -->
    <script src="js/compiled.min.js"></script>
    <!-- FontAwesome -->
    <script defer src="js/fontawesome-all.min.js"></script>

  </body>
</html>