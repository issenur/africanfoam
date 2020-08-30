<?php
    include_once("Invoice.php");
    include_once("InvoiceModel.php");
    include_once("CostModel.php");
    include_once("PaymentModel.php");
    include_once("CustomerModel.php");
    include_once("IISalesModel.php");
    include_once("Model.php");
    include_once("Account.php");
    include_once("AccountModel.php");
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "IISales"){
        header("location:index.php");
    }
    
    if(isset($_GET['view_invoice'])){
        $customer_id = $_GET['view_invoice'];
        $_SESSION['customer_id'] = $_GET['view_invoice'];
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
             $model = new Model();
             $user_id = $model->getCurrentUserId();
             
             $iisalesModel = IISalesModel::getInstance();
             $iisales = $iisalesModel->retrieveUser($user_id);
             
             $iifirstname = $iisales->getFirst();
             $iilastname = $iisales->getLast();
                 

             

             echo $iifirstname . " " . $iilastname;
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
              <p>Manager Dashboard</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
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
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                       <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice#</th>
                                    <th>Invoice Total</th>
                                    <th>Total Paid</th>
                                    <th>Outstanding Bal.</th>
                                    <th>Sales Person</th>
                                    <th>Delete Invoice</th>                                    
                                    <th>Delete Mattresses</th>
                                    <th>Detete Payments</th>
                                    <th>Purchase Date</th>
                                </tr>
                            </thead>
                            <?php
                              $invoiceModel = InvoiceModel::getInstance();
                              $costModel = CostModel::getInstance();
                              $paymentModel = PaymentModel::getInstance(); 
                              $invoiceCollection = $invoiceModel->retrieveStoreInvoices();
                                echo "<id='example2'>";
                                echo "<tbody>";
                                if (!($invoiceCollection == null)) {
                                    
                                    while(!$invoiceCollection->isEmpty()) {
                                        $invoice = $invoiceCollection->extract();
                                        $invoice_id = $invoice->getInvoiceId();
                                        $dateTime = $invoice->getDate();
                                        $date1 = new DateTime($dateTime);
                                        $date = $date1->format('d-M-Y');
                                        $sales = $invoice->getSales();
                                        $salesFirst = $sales->getFirst();
                                        $salesLast = $sales->getLast();
                                        $hasCostCollection = false;
                                        $hasPaymentCollection = false;
                                        $costCollection = $invoice->getCostCollection();
                                        $totalCost = $costModel->getTotalCost($costCollection);
                                        $totalCostF = number_format(abs($totalCost), 2, '.', ',');
                                        $paymentCollection = $invoice->getPaymentCollection();
                                        $totalPayment = $paymentModel->getTotalPayment($paymentCollection);
                                        $totalPaymentF = number_format($totalPayment, 2, '.', ',');
                                        $grandTotal = $totalPayment + $totalCost;
                                        $grandTotalF = number_format($grandTotal, 2, '.', ',');
                                       
                                        echo "<tr>";
                                        echo "<td>" .$invoice_id. "</td>"; 
                                        echo "<td> Ksh " . $totalCostF . "</td>";
                                        echo "<td> Ksh " . $totalPaymentF . "</td>";
                                        if(($grandTotalF) < 0){
                                          echo "<td style='color:red'  > Ksh " . $grandTotalF . "</td>";
                                        }else{
                                          echo "<td style='color:green'> Ksh " . $grandTotalF . "</td>";
                                        }
                                        echo "<td>" . $salesFirst . " " . $salesLast . "</td>";
                                        if(!($costCollection->isEmpty())){
                                          $hasCostCollection = true;
                                        }
                                        
                                        if (!($paymentCollection->isEmpty())){
                                          $hasPaymentCollection = true;
                                        }
                                        if($hasCostCollection || $hasPaymentCollection){
                                          echo"<td>";
                                          echo "<a href ='#".  $invoice_id  ."'><button class='btn btn-primary disabled'>Delete Invoice</button>"."<a/>";
                                          echo "</td>";
                                        }else{
                                          echo"<td>";
                                          echo "<a href ='IISalesInvoiceDeleteView.php?view_invoice".  $invoice_id  ."'><button class='btn btn-primary'>Delete Invoice</button>"."<a/>";
                                          echo "</td>";
                                        }
                                        if(!$hasCostCollection){
                                          echo"<td>";
                                          echo "<a href ='#".  $invoice_id  ."'><button class='btn btn-primary disabled'>Delete Mattresses</button>"."<a/>";
                                          echo "</td>";
                                        }else{
                                          echo"<td>";
                                          echo "<a href ='IISalesCostDeleteView.php?view_invoice=".  $invoice_id ."'><button class='btn btn-primary'>Delete Mattresses</button>"."<a/>";
                                          echo "</td>";
                                        }
                                        if(!$hasPaymentCollection){
                                          echo"<td>";
                                          echo "<a href ='#".  $invoice_id  ."'><button class='btn btn-primary disabled'>Delete Payments</button>"."<a/>";
                                          echo "</td>";
                                        }else{
                                          echo"<td>";
                                          echo "<a href ='IISalesPaymentDeleteView.php?view_invoice=".  $invoice_id  ."'><button class='btn btn-primary'>Delete Payments</button>"."<a/>";
                                          echo "</td>";
                                        }
                                        echo "<td>" . $date . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "</tbody>";
                                    echo "</table>";
                                    echo "<h4>CUSTOMER HAS ZERO INVOICES</h4>";
                                }
                            ?>
                    </div>
                </div>
     
            </div>
            <!-- /.container-fluid -->
        </section>
    <!-- /.content -->
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
        $(".sales_form_message").load("IISalesusercontroller.php", {
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
