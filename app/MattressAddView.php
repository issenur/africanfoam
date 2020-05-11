<?php   
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "Administrator"){
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
          <a href="#" class="d-block">Administrator</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           <li class="nav-item">
            <a href="AdminView.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Admin Dashboard</p>
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
          <div class="col-md-2">
          </div>
          <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Add Mattress Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="mattress_add_form"">
                <div class="card-body">
                  <div class="form-group action="MattressAddController.php" id="mattress_add_form" method="post"">
                    <label>Type</label>
                    <input type="text"  class="form-control" id="mattress_form_type"  name="type" placeholder="XX-XXX">
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                     <input type="text"  class="form-control" id="mattress_form_description" name="description" placeholder="Mattress Name">
                  </div>
                  <div class="form-group">
                    <label>Size</label>
                     <input type="text"  class="form-control" id="mattress_form_size" name="size" placeholder="00x00">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                     <input type="text"  class="form-control" id="mattress_form_price"  name="price" placeholder="Price in KSH">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                 <button class="btn btn-info" type="submit" name="submit" id="mattress_form_submit">Submit</button>
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
          <div class="col-md-2">
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
        
        var type = $("#mattress_form_type").val();
        var description = $("#mattress_form_description").val();
        var size = $("#mattress_form_size").val();
        var price = $("#mattress_form_price").val();
        var message = $("#mattress_form_message").val();
        var submit = $("#mattress_form_submit").val();
        $(".mattress_form_message").load("MattressAddController.php", {
            type: type,
            description: description,
            size: size,
            price: price,
            message: message,
            submit: submit
          });
      });
    });
</script>
</body>
</html>
