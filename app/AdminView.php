<?php
    include_once("Connection.php");
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
        <a href="#" class="nav-link">Home</a>
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
            <a href="AdminView.php" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>Admin Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="SalesEndUserRegistrationView.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Register Salesperson</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="IISalesEndUserRegistrationView.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Register Manager</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="CustomerEndUserRegistrationView.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Register Customer</p>
            </a>
          </li>
           <li class="nav-item">
            <a href="MattressAddView.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Add Mattress</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="AdminMattressView.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Manage Mattresses</p>
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
        <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Active Users</h1>
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Acc Type</th>
                                    <th>ID#</th>
                                    <th>Username</th>
                                    <th>First</th>
                                    <th>Last</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <?php
                                  $connection = Connection::getInstance();
                                  $conn = $connection->getConn();
                                
                                
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                
                                $sql  = "select";
                                $sql .=     "`user`.`username` as `username`,";
                                $sql .=     "`user`.`customer_id` as `customer_id`,";                                
                                $sql .=     "`user`.`sales_ii_id` as `sales_ii_id`,";
                                $sql .=     "`user`.`sales_id` as `sales_id`,";
                                $sql .=     "`user`.`user_type` as `user_type`,";
                                $sql .=     "`customer`.`first` as `dfirst`,";
                                $sql .=     "`customer`.`last` as `dlast`,";
                                $sql .=     "`sales_ii`.`first` as `pfirst`,";
                                $sql .=     "`sales_ii`.`last` as `plast`,";
                                $sql .=     "`sales`.`first` as `cfirst`,";
                                $sql .=     "`sales`.`last` as `clast`";
                                $sql .= " from `user`";
                                $sql .= " left join `customer` on (`customer`.`customer_id` = `user`.`customer_id`)";
                                $sql .= " left join `sales_ii` on (`sales_ii`.`sales_ii_id` = `user`.`sales_ii_id`)";
                                $sql .= " left join `sales` on (`sales`.`sales_id` = `user`.`sales_id`)";
                                $sql .= " where `user`.`active` = 1";
                                $sql .= " order by `user`.`user_type` ASC";
                                $result = $conn->query($sql);
                                echo "<id='example2'>";
                                echo "<tbody>";
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        
                                        if(!($row['customer_id'] == NULL)){
                                            echo "<td>Customer</td>";
                                            echo "<td>" . $row['customer_id'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['dfirst'] . "</td>";
                                            echo "<td>" . $row['dlast'] . "</td>";
                                            echo"<td>";
                                            echo "<a href ='AdminViewController.php?delete_customer=".  $row['username'] ."'><button class='btn btn-danger'>Deactivate</button>"."<a/>";
                                            echo "</td>"; 
                                        }else if(!($row['sales_ii_id'] == NULL)){
                                            echo "<td>Sales II</td>";
                                            echo "<td>" . $row['sales_ii_id'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['pfirst'] . "</td>";
                                            echo "<td>" . $row['plast'] . "</td>";
                                            echo"<td>";
                                            echo "<a href ='AdminViewController.php?delete_sales_ii=". $row['username']."'><button class='btn btn-danger'>Deactivate</button>"."<a/>";
                                            echo "</td>"; 
                                        }else{
                                            echo "<td> Sales </td>";
                                            echo "<td>" . $row['sales_id'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['cfirst'] . "</td>";
                                            echo "<td>" . $row['clast'] . "</td>";
                                            echo"<td>";
                                            echo "<a href ='AdminViewController.php?delete_sales=".  $row['username'] ."'><button class='btn btn-danger'>Deactivate</button>"."<a/>";
                                            echo "</td>"; 
                                        } 
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "</tbody>";
                                    echo "</table>";
                                    echo "<h6>ACTIVATED USERS TABLE IS EMPTY</h6>";
                                }
                            ?>
                            
                        <h1>Inactive Users</h1>
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Acc Type</th>
                                    <th>ID#</th>
                                    <th>Username</th>
                                    <th>First</th>
                                    <th>Last</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php
                            
                                $connection = Connection::getInstance();
                                $conn = $connection->getConn();
                                
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                
                                $sql  = "select";
                                $sql .=     "`user`.`username` as `username`,";
                                $sql .=     "`user`.`customer_id` as `customer_id`,";                                
                                $sql .=     "`user`.`sales_ii_id` as `sales_ii_id`,";
                                $sql .=     "`user`.`sales_id` as `sales_id`,";
                                $sql .=     "`user`.`user_type` as `user_type`,";
                                $sql .=     "`customer`.`first` as `dfirst`,";
                                $sql .=     "`customer`.`last` as `dlast`,";
                                $sql .=     "`sales_ii`.`first` as `pfirst`,";
                                $sql .=     "`sales_ii`.`last` as `plast`,";
                                $sql .=     "`sales`.`first` as `cfirst`,";
                                $sql .=     "`sales`.`last` as `clast`";
                                $sql .= " from `user`";
                                $sql .= " left join `customer` on (`customer`.`customer_id` = `user`.`customer_id`)";
                                $sql .= " left join `sales_ii` on (`sales_ii`.`sales_ii_id` = `user`.`sales_ii_id`)";
                                $sql .= " left join `sales` on (`sales`.`sales_id` = `user`.`sales_id`)";
                                $sql .= " where `user`.`active` = 0";
                                $sql .= " order by `user`.`user_type` ASC";
                                $result = $conn->query($sql);
                                echo "<id='example2'>";
                                echo "<tbody>";
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        if(!($row['customer_id'] == NULL)){
                                            echo "<td> Customer </td>";
                                            echo "<td>" . $row['customer_id'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['dfirst'] . "</td>";
                                            echo "<td>" . $row['dlast'] . "</td>";
                                            echo"<td>";
                                            echo "<a href ='AdminViewController.php?activate_customer=".  $row['username'] ."'><button class='btn btn-success' style='width: 100px' >Activate</button>"."<a/>";
                                            echo "</td>"; 
                                        }else if(!($row['sales_ii_id'] == NULL)){
                                            echo "<td>Sales II</td>";
                                            echo "<td>" . $row['sales_ii_id'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['pfirst'] . "</td>";
                                            echo "<td>" . $row['plast'] . "</td>";
                                            echo"<td>";
                                            echo "<a href ='AdminViewController.php?activate_sales_ii=". $row['username']."'><button class='btn btn-success' style='width: 100px'>Activate</button>"."<a/>";
                                            echo "</td>"; 
                                        }else{
                                            echo "<td> Sales </td>";
                                            echo "<td>" . $row['sales_id'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['cfirst'] . "</td>";
                                            echo "<td>" . $row['clast'] . "</td>";
                                            echo"<td>";
                                            echo "<a href ='AdminViewController.php?activate_sales=".  $row['username'] ."'><button class='btn btn-success' style='width: 100px'>Activate</button>"."<a/>";
                                            echo "</td>"; 
                                        } 
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "</tbody>";
                                    echo "</table>";
                                    echo "<h6>DEACTIVATED USERS TABLE IS EMPTY</h6>";
                                }
                                $conn->close();
                            ?>
                    </div>
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
    Copyright © African Foam Limited 2020
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
        
        var username = $("#sales_form_username").val();
        var password = $("#sales_form_password").val();
        var first = $("#sales_form_first").val();
        var last = $("#sales_form_last").val();
        var phone_number = $("#sales_form_phone_number").val();
        var message = $("#sales_form_message").val();
        var submit = $("#sales_form_submit").val();
        $(".sales_form_message").load("salesusercontroller.php", {
            username: username,
            password: password,
            first: first,
            last: last,
            phone_number: phone_number,
            message: message,
            submit: submit
          });
      });
    });
</script>
</body>
</html>
