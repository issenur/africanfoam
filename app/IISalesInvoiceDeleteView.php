<?php
    include_once("Invoice.php");
    include_once("InvoiceModel.php");
    include_once("CustomerModel.php");
    include_once("CostModel.php");
    include_once("PaymentModel.php");
    include_once("Model.php");
    include_once("IISalesModel.php");
    
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "IISales"){
        header("location:index.php");
    }

    if(isset($_GET['view_invoice'])){
        $invoice_id = $_GET['view_invoice'];
        $_SESSION['invoice_id'] = $_GET['view_invoice'];
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>African Foam Customer</title>
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
          <a href="#" class="d-block">
             <?php
             $connection = Connection::getInstance();
             $conn = $connection->getConn();
             
             $model = new Model();
             $user_id = $model->getCurrentUserId();
             
             $salesModel = IISalesModel::getInstance();
             $sales = $salesModel->retrieveUser($user_id);
             
             $firstname = $sales->getFirst();
             $lastname = $sales->getLast();
             
             echo $firstname . " " . $lastname;
            ?>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="IISalesPersonView.php" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>Sales Manager Dashboard</p>
            </a>
          </li>
        </ul>
      </nav>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="logout.php" class="nav-link" style="background-color:red;color: white">
              <i class="far fa-circle nav-icon"></i>
              <p>Log out</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="padding: 0px 0px 0px 0px" >
            <div class="container-fluid " style="padding: 0px 0px 0px 0px" >
                <div class ="row" style="padding: 20px 20px 0px 20px">
                    <div class="col">
                        <h1>Invoice#
                        <?php
                            $invoice_id = $_SESSION['invoice_id'];
                            echo (int)$invoice_id;
                        ?>
                        </h1>
                    </div>
                   <div class ="col-auto">
                        <a class="btn btn-app"  href ="IISalesInvoiceDeleteView.php?button_delete=<?php echo $invoice_id?>" style="background-color:lightblue" >
                            <i class="fas fa-edit" type ="submit" name="button_delete"  style="background-color:lightblue">Click To Confirm Deletion</i>
                        </a>
                        <?php
                            if(isset($_GET["button_delete"])){
                                $sql = "DELETE  FROM `invoice` WHERE `invoice_id` = '$invoice_id'";
                                if(!mysqli_query($conn, $sql)){
                                    header("Location: fail.php");
                                }else{
                                    header("Location: IISalesPersonView.php");
                                }
                            }
                        ?>
                   </div> 
                </div>
            </div>   
        </section>
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

