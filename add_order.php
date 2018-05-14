<?php
  require_once('lib/session.php');
  $msg="";
  $items_list=$db->getAll("SELECT * FROM menu");
  if (isset($_POST['submit'])) {
      // receiving the post parameters
      $item_id= $_POST['select_item'];
      $quantity = $_POST['itemQuantity'];
      $total = $_POST['total'];
      $user_id =  $_SESSION['user_id'];
      // call the method to add order and show msg based on result
      $result = $db->addOrder($user_id,$item_id,$quantity,$total);

      if(is_null($result)){
          $msg = '<p class="red-text mt-5"> Order not added. Please try again!</p>';
      }else{
          $msg = '<p class="green-text mt-5"> Order added successfully. </p> ';
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

    <title>Add New Order</title>
  </head>
  <body>
    <!--Header-->
    <?php include('header.html'); ?>
    <!--/.Header-->
    <!-- Container -->
    <div class="container-fluid mb-5">
      <!-- Row 1 -->
      <div class="row text-center justify-content-center mt-1">
          <?php echo $msg; ?> 
      </div>
      <!-- /. Row 1 -->
      <!-- Row 2 -->
      <div class="row justify-content-center">
          <div class="col-lg-6 col-sm-12">
            <!-- Modal: addOrder -->
            <div class="modal-dialog cascading-modal" role="document">
              <!-- Content-->
              <div class="modal-content">
                  <!-- Header-->
                  <div class="modal-header info-color-dark white-text">
                      <h4 class="h4-responsive title">
                          <i class="fas fa-plus-square"></i> New Order
                      </h4>
                  </div>
                  <!-- /.Header-->
                  <!-- Body-->
                  <div class="modal-body">
                    <!--Form addOrder -->
                    <form name="addOrder" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <!-- Select Item-->
                        <div class="md-form form-sm">
                           <select class="mdb-select colorful-select dropdown-primary" id="select_item" name="select_item" required>
                                <?php
                                    foreach($items_list as $item){
                                      echo '<option value="'.$item['item_id'].'" price="'.$item['item_price'].'">';
                                      echo  $item['item_name']. "</option>";
                                    }
                                ?>
                           </select>
                           <label>Menu Item </label>
                        </div>
                        <!-- Input quantity -->
                        <div class="md-form form-sm">
                            <input type="text"  id="itemQuantity" name="itemQuantity" class="form-control"
                             required  pattern="^[1-9]\d*$" title="Only positive quantity allowed">
                             <label for="itemQuantity">Quantity</label>
                        </div>
                        <!-- Input total -->
                        <div class="md-form form-sm">
                            <input type="text" id="total" name="total" value="0" class="form-control form-control-sm" readonly >
                            <label for="total">Total</label>
                        </div>
                        <!-- addOrder submit --> 
                        <div class="text-center mt-4 mb-2">
                            <input type="submit" value="Add Order" name="submit" class="btn blue-gradient">
                        </div>
                    </form>
                    <!--/.Form addOrder -->
                  </div>
                  <!-- /.Body-->
                  <!--Footer-->
                  <div class="modal-footer ">
                      <div class="options text-left mt-1">
                        <p id="msg" class="red-text"></p>
                      </div>
                  </div>
                  <!-- /.Footer-->
              </div>
              <!--/. Content-->
            </div>
            <!--/ Modal: addOrder -->
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
   
    <!-- Calculate total using price and quantity -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.mdb-select').material_select();

            $("input[name=itemQuantity]").keyup(function() {
                onValueChange();
            });

            $('#select_item').on('change', function() {
               $("input[name=total]").val(0);
               $("input[name=itemQuantity]").val("");
               $("#msg").text("");
            });
        });

        function onValueChange(){
            var pattern= /^[1-9]\d*$/;
            var price= $('#select_item option:selected').attr('price');
            var qty =  $("input[name=itemQuantity]").val();
            if(pattern.test(qty)){
              $("input[name=total]").val(price * qty);
              $("#msg").text("");
            }else{
              $("input[name=total]").val(0);
              $("#msg").text("Please Enter Positive Quantity.");
            } 
        }
    </script> 
  </body>
</html>  