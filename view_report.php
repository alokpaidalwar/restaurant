<?php
  require_once('lib/session.php');
  //Intialize & push label and data for Line chart
  $lineChart_label = array();
  $lineChart_data = array();
  $lineChart = $db->getLineChartData();
  foreach($lineChart as $row) {
    array_push($lineChart_label,$row['date']);
    array_push($lineChart_data,$row['total']);
  }
  //Intialize & push label and data for Pie chart.
  $pieChart_label = array();
  $pieChart_data = array();
  $backgroundColorPie = array();
  $pieChart = $db->getPieChartData();

  foreach($pieChart as $row) {
    array_push($pieChart_label,$row['item_name']);
    array_push($pieChart_data,$row['quantity']);
    //dynamically add colors cause items count in menu can change in future
    array_push($backgroundColorPie,'#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT));
  }
  //Intialize & push label and data for Bar chart.
  $backgroundColorBar = array();
  $boarderColorBar = array();
  $barChart_label = array();
  $barChart_data = array();
  $barChart = $db->getBarChartData();

  foreach($barChart as $row) {
    array_push($barChart_label,$row['item_name']);
    array_push($barChart_data,$row['total']);
    array_push($backgroundColorBar,'rgba(255, 255, 255, 0.4)');
    array_push($boarderColorBar,'rgba(255, 255, 255, 1)');
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

    <title>View Report</title>
  </head>
  <body>
    <!--Header-->
      <?php include('header.html'); ?>
    <!--/.Header-->

    <!-- Container -->
    <div class="container-fluid mb-5 mt-2">
      <!-- Row 1 -->
      <div class="row justify-content-center">
        <!-- Line Chart-->
        <div class="col-lg-6 col-sm-12">
            <!--Modal -->
            <div class="modal-dialog cascading-modal modal-lg" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header info-color-dark white-text">
                       <h6 class="h6-responsive title"><i class="fas fa-chart-line"></i> Date wise sales </h6>
                    </div>
                    <!-- /.Header-->
                    <!--Body-->
                    <div class="modal-body mb-1">
                        <div class="card blue-gradient p-2">
                          <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                    <!--/. Body -->
                </div>
                <!--/. Content-->
            </div>
            <!--/. Modal -->            
        </div>
        <!--/. Line Chart-->
        <!-- Bar Chart-->
        <div class="col-lg-6 col-sm-12">
            <!--Modal -->
            <div class="modal-dialog cascading-modal modal-lg" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header info-color-dark white-text">
                       <h6 class="h6-responsive title"><i class="fas fa-chart-bar"></i> Product wise sales </h6>
                    </div>
                    <!-- /.Header-->
                    <!--Body-->
                    <div class="modal-body mb-1">
                        <div class="card blue-gradient p-2">
                          <canvas id="barChart"></canvas>
                        </div>
                    </div>
                    <!--/. Body -->
                </div>
                <!--/. Content-->
            </div>
            <!--/. Modal --> 
        </div>
        <!--/. Bar Chart-->
      </div>
      <!-- /. Row 1 -->
      <!-- Row 2 -->
      <div class="row justify-content-center m-3">
        <!-- Pie Chart-->
        <div class="col-lg-4 col-sm-12">
            <!--Modal -->
            <div class="modal-dialog cascading-modal modal-lg" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header info-color-dark white-text">
                       <h6 class="h6-responsive title"><i class="fas fa-chart-pie"></i> Products Sold By Quantity </h6>
                    </div>
                    <!-- /.Header-->
                    <!--Body-->
                    <div class="modal-body mb-1">
                      <canvas id="pieChart"></canvas>
                    </div>
                    <!--/. Body -->
                </div>
                <!--/. Content-->
            </div>
            <!--/. Modal --> 
        </div>
        <!--/. Pie Chart-->
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

    <script type="text/javascript">
        //line chart
        var ctxL = document.getElementById("lineChart").getContext('2d');
        var myLineChart = new Chart(ctxL, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($lineChart_label); ?>,
                datasets: [
                    {
                        label: "Date wise Sales in Rs.",
                        fillColor: "#fff",
                        backgroundColor: 'rgba(255, 255, 255, .3)',
                        borderColor: 'rgba(255, 99, 132, .7)',
                        data: <?php echo json_encode($lineChart_data);?>
                    }
                ]
            },
            options: {
                responsive: true,
                legend: {
                    labels: {
                        fontColor: "#fff",
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true,
                            color: "rgba(255,255,255,.25)"
                        },
                        ticks: {
                            fontColor: "#fff",
                        },
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            display: true,
                            color: "rgba(255,255,255,.25)"
                        },
                        ticks: {
                            fontColor: "#fff",
                        },
                    }],
                }
            }    
        });

        //pieChart
        var ctxP = document.getElementById("pieChart").getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($pieChart_label); ?>,
                datasets: [
                    {
                        data: <?php echo json_encode($pieChart_data); ?>,
                        backgroundColor: <?php echo json_encode($backgroundColorPie); ?>,
                    }
                ]
            },
            options: {
                responsive: true
            }    
        });

        //barChart
        var ctxB = document.getElementById("barChart").getContext('2d');
        var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($barChart_label); ?>,
                datasets: [{
                    label: 'Product Wise Sales in Rs',
                    data: <?php echo json_encode($barChart_data); ?>,
                    backgroundColor: <?php echo json_encode($backgroundColorBar); ?> ,
                    borderColor:  <?php echo json_encode($boarderColorBar); ?> ,
                    borderWidth: 1,

                }]
            },
            options: {
                responsive: true,
                legend: {
                    labels: {
                        fontColor: "white"
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: "white"
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontColor: "white"
                        }
                    }]
                }
            }
        });   
    </script>

  </body>
</html>  