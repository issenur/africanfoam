<?php
  include_once("dbconnection.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Testing Add Sales</title>
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
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
     
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
       
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Sales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Sales Test</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
              <!-- form start -->
              <form action="test_controller.php" id="sales_add_form" method="post">
                <div class="card-body">
                  <div class="form-group col-md-12">
                    <input type="text"  class="form-control" id="sales_form_username"  name="username" placeholder="ENTER USERNAME">
                  </div>
                  <div class="form-group col-md-12">
                    <input type="password"  class="form-control" id="sales_form_password" name="password" placeholder="ENTER PASSWORD">
                  </div>
                  <div class="form-group col-md-12 " data-select2-id="29" id="sales_form_user_type" >  
                    <?php
                      $connection = dbconnection::getInstance();
                      $conn = $connection->getConn();
                      $sql = "SELECT DISTINCT user_type FROM user where user_type <> 'ADMINISTRATOR' order by user_type ASC";
                      $result = $conn->query($sql);
                     
                      if ($result->num_rows > 0) {
                        echo "<select  id='sales_form_user_type'>";
                        echo "<option value='choose'> ". "---Choose User Type---" . "</option>";
                        while($row = $result->fetch_assoc()) {
                          echo "<option value=" . $row['username'] . ">" . $row['user_type'] . "</option>";
                        }
                          echo "</select>";
                      } 
                      $conn->close();
                    ?>
                  </div>
                   <div class="form-group col-md-12">
                    <input type="text"  class="form-control" id="sales_form_first"  name="first" placeholder="ENTER FIRST NAME">
                  </div>
                  <div class="form-group col-md-12">
                    <input type="text"  class="form-control" id="sales_form_last" name="last" placeholder="ENTER LAST NAME">
                  </div>
                  <div class="form-group col-md-12">
                    <input type="text" class="form-control" id="sales_form_phone_number" name="phone_number" placeholder="ENTER PHONE NUMBER">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer col-md-12">
                  <button class="btn btn-primary" type="submit" name="submit" id="sales_form_submit">Submit</button>
                  <br>
                  <br>
                  <p class="sales_form_message" name="message" > </p>
                </div>
              </form>
            </div>
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b></b> 
    </div>
    <strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
        
        var username = $("#sales_form_username").val();
        var password = $("#sales_form_password").val();
        var user_type = $(this).find(":selected").text();
        var first = $("#sales_form_first").val();
        var last = $("#sales_form_last").val();
        var phone_number = $("#sales_form_phone_number").val();
        var message = $("#sales_form_message").val();
        var submit = $("#sales_form_submit").val();
        $(".sales_form_message").load("test_controller.php", {
            username: username,
            password: password,
            user_type: user_type,
            first: first,
            last: last,
            phone_number: phone_number,
            message: message,
            submit: submit
          });
      });
    });
</script>
</script>
</body>
</html>
