<?php
    include_once("SalesModel.php");
    include_once("Model.php");
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "Sales"){
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>African Foam Administrator</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#">Home</a>
      </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="logout.php" class="nav-link">Log out</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="https://www.africanfoam.com" class="brand-link">
      <img src="../../dist/img/africanfoamlogo.jpg"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">African Foam</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/defaultpic.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
           <a href="#" class="d-block">
            <?php
             $model = Model::getInstance();
             $user_id = $model->getCurrentUserId();
             
             $salesModel = SalesModel::getInstance();
             $sales = $salesModel->retrieveUser($user_id);
             
             $firstname = $sales->getFirst();
             $lastname = $sales->getLast();
             
             echo $firstname . " " . $lastname;
            ?>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           <li class="nav-item">
            <a href="SalespersonView.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>SalesPerson Dashboard</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-sm-2">
          </div>
          <div class="col-sm-8">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Create Invoice Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="mattress_add_form"">
                <div class="card-body">
                  <div class="form-group action="MattressAddController.php" id="mattress_add_form" method="post"">
                    <div class= "col">
                      <div class= "row">
                        <div class= "col-sm-6">
                          <div class= "row">
                            <label>  Invoice Customer   </label>
                          </div>
                          <div class= row">
                            <div class= "form-group" data-select2-id="29">
                            <?php
                              $connection = Connection::getInstance();
                              $conn = $connection->getConn();
                              $sql = "SELECT * FROM customer ORDER by first ASC";
                              $result = $conn->query($sql);
                              
                              if ($result->num_rows > 0) {
                                echo "<select class='form-control select2bs4 select2-hidden-accessible' style='width: 100%;' data-select2-id='17' tabindex='-1' aria-hidden='true' id='customer_form2' >";
                                echo "<option value='choose'> ". "--Select Shop Name--" . "</option>";
                                while($row = $result->fetch_assoc()) {
                                  echo "<option value=" . $row['customer_id'] . ">" . $row['shop_name'] . "</option>";
                                }
                              echo "</select>";
                              } 
                            
                            ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class= "row">
                        <div class= "col-sm-12">
                          <div class= "row">
                            <div class= "col-sm-8">
                             <label>  Mattress Name   </label>
                            </div>
                            <div class= "col-sm-2">  
                             <label>  Mattress Qty   </label>
                            </div>
                            <div class= "col-sm-2">
                             <label> Discount  </label>
                            </div>
                          </div>
                       </div>
                        <div class="col-sm-1">
                        </div>
                      </div>
                      <div class= "row">
                        <div class= "col-sm-12">
                          <div class= "row">
                            <div class= "col-sm-8">
                              <div class="form-group" data-select2-id="29">
                                <?php  
                                  $sql = "SELECT * FROM mattress ORDER by description ASC";
                                  $result = $conn->query($sql);
                  
                                  if ($result->num_rows > 0) {
                                    echo "<select class='form-control select2bs4 select2-hidden-accessible' style='width: 100%;' data-select2-id='17' tabindex='-1' aria-hidden='true' id='customer_form2' >";
                                    echo "<option value='choose'> ". "--Select Mattress--" . "</option>";
                                    while($row = $result->fetch_assoc()) {
                                      echo "<option value=" . $row['mattress_id'] . ">" . $row['description'] . "</option>";
                                    }
                                    echo "</select>";
                                  } 
                                  $conn->close();
                                ?>
                              </div>
                            </div>
                            <div class= "col-sm-2">  
                              <div class="form-group">
                                <input type="text"  class="form-control" id="mattress_form_price"  name="price" placeholder="Qty">
                              </div>
                            </div>
                            <div class= "col-sm-2">
                              <div class="form-group">
                                <input type="text"  class="form-control" id="mattress_form_price"  name="price" placeholder="Percentage">
                              </div>
                            </div>
                          </div>
                       </div>
                        <div class="col-sm-1">
                        </div>
                      </div>
                      <div class= "row">
                        <div class="col-sm-6">
                        </div>
                        <div class= "col-sm-6">
                          <div class= "row">
                            <div class= "col-sm-8">  
                               <label>  Cash paid in/regard to Invoice   </label>
                            </div>
                            <div class= "col-sm-4">
                                <label>  Date   </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class= "row">
                        <div class="col-sm-6">
                        </div>
                        <div class= "col-sm-6">
                          <div class= "row">
                            <div class= "col-sm-8">  
                              <div class="form-group">
                                <input type="text"  class="form-control" id="mattress_form_price"  name="price" placeholder="K 0000.00">
                              </div>
                            </div>
                            <div class= "col-sm-4">
                              <div class="form-group">
                                <input type="text"  class="form-control" id="mattress_form_price"  name="price" placeholder="Date">
                              </div>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                      <div class= "row">
                        <div class= "col">
                           <div class= "row">
                          </div>
                          <div class= row">
                          </div>
                        </div>
                      </div>
                  </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer ">
                  <button class="btn btn-info" type="submit" name="submit" id="mattress_form_submit">Submit Invoice</button>
                  <br>
                  <br>
                  <p class="mattress_form_message" name="message" > </p>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-sm-2">
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Africanfoam App Version</b> 5.0
    </div>
    Copyright © African Foam Limited 2019
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<script>
  $(document).ready(function() {
      $("form").submit(function(event){
        event.preventDefault();
        
        var customer = $(this).find(":selected").text();
        var mattress = $(this).find(":selected").text();
        
        $(".mattress_form_message").load("MattressAddController.php", {
            customer: customer,
            mattress: mattress
          });
      });
    });
</script>
</body>
</html>
