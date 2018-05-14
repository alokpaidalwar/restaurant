<?php
   require_once('lib/session.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/compiled.min.css">

        <title>Home Page</title>
  </head>
  <body>
    <!--Header-->
      <?php include('header.html'); ?>
    <!--/.Header-->

    <!-- Container -->
    <div class="container-fluid my-5">
      <!-- Row 1 -->
      <div class="row text-center justify-content-center m-5">
          <h2 class="h2-responsive font-weight-bold deep-orange-text"> Welcome <?php echo $_SESSION['username'] ; ?> !!!  </h2>  
      </div>
      <!-- /. Row 1 -->
      <!-- Row 2-->
      <div class="row text-center justify-content-center">
        <div class="col mb-5">
            <a class="btn info-color-dark btn-lg text-lg" href="add_order.php">
              <i class="fas fa-plus-square fa-10x m-3" aria-hidden="true"></i><br> Add New Order
            </a>
            <a class="btn info-color-dark btn-lg text-lg" href="view_report.php">
              <i class="fas fa-chart-line fa-10x m-3" aria-hidden="true"></i><br> View Report
            </a>
        </div>
      </div> 
      <!-- /. Row 2-->
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