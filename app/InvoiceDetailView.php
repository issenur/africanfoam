<?php
    include_once("Invoice.php");
    include_once("InvoiceModel.php");
    include_once("CustomerModel.php");
    include_once("CostModel.php");
    include_once("PaymentModel.php");
    include_once("Model.php");
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "Customer"){
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
             $model = new Model();
             $user_id = $model->getCurrentUserId();
             
             $customerModel = CustomerModel::getInstance();
             $customer = $customerModel->retrieveUser($user_id);
             
             $firstname = $customer->getFirst();
             $lastname = $customer->getLast();
             $shopName = $customer->getShopName();
             echo $firstname . " " . $lastname;
            ?>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="CustomerView.php" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>Customer Dashboard</p>
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
        <section class="content-header" style="padding: 0px 0px 0px 0px" >
            <div class="container-fluid " style="padding: 0px 0px 0px 0px" >
                <div class ="row" style="padding: 20px 20px 0px 20px">
                    <div class="col">
                        <h1>Invoice#
                        <?php
                            $invoice = $_SESSION['invoice_id'];
                            echo (int)$invoice_id;
                        ?>
                        </h1>
                    </div>
                </div>
                <div class="row pl-5" style="min-height:62vh" style="min-width:100vw" >
                    <div class= "col" style="min-height:62vh" style="min-width:100vw" >
                      <div class="row pl-5" style="min-height:46vh" style="min-width:100vw" >            
                        <table id="example4" class="table table-borderless table-hover">
                            <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>size</th>
                                    <th>Mattress Desc</th>
                                    <th>Price each</th>
                                    <th>Discount</th>
                                    <th>Before Discount</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <?php
                                $invoiceModel = InvoiceModel::getInstance();
                                $invoice = $invoiceModel->retrieveInvoice($invoice);
                                $dateTime = $invoice->getDate();
                                $date1 = new DateTime($dateTime);
                                $date = $date1->format('d-M-Y');
                                $costCollection = $invoice->getCostCollection();
                                $costModel = CostModel::getInstance();
                                $totalCost = $costModel->getTotalCost($costCollection);
                                $totalCostF = number_format( (-1 * $totalCost), 2, '.', ',');
                                

                                echo "<id='example2'>";
                                echo "<tbody>";
                                if (!($costCollection == null)) {
                                    
                                    while(!$costCollection->isEmpty()) {
                                        $cost = $costCollection->extract();
                                        
                                        $mattress = $cost->getMattress();
                                        $mattress_desc = $mattress->getDescription();
                                        $mattress_size = $mattress->getSize();
                                        $price = $mattress->getPrice();
                                        $priceF = number_format($price, 2, '.', ',');
                                        $quantity = $cost->getQuantity();
                                        $discount = $cost->getDiscount();
                                        $discountF = number_format($discount, 1, '.', '');
                                        $postTotal = $price * $quantity;
                                        $postTotalF = number_format($postTotal, 2, '.', ',');
                                        $lineTotal = $price * $quantity  * (1 - ($discount / 100));
                                        $lineTotalF = number_format($lineTotal, 2, '.', ',');
                                        


                                        echo "<tr>";
                                        echo "<td>". "  ". $quantity . ".0 </td>";
                                        echo "<td>". "  ". $mattres_size . " </td>";
                                        echo "<td>" . $mattress_desc . "</td>";
                                        echo "<td> Ksh " . $priceF . "</td>";
                                        echo "<td>" . $discountF . "%</td>";
                                        echo "<td> Ksh " . $postTotalF . "</td>";
                                        echo "<td> Ksh " . $lineTotalF . "</td>";
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
                      <div class="row pl-5" style="min-height:23vh; min-width:60vw" >
                          <div class="col-4">
                            
                          </div>
                          <div class="col-7">
                            <table id="example4" class="table table-borderless table-hover">
                              <thead>
                                  <tr>
                                      <th>Collected By</th>
                                      <th>Amount Paid</th>
                                      <th>Date of Payment</th>
                                      
                                  </tr>
                              </thead>
                              <?php
                                  $paymentCollection = $invoice->getPaymentCollection();
                                  $paymentModel = PaymentModel::getInstance();
                                  $totalPayment = $paymentModel->getTotalPayment($paymentCollection);
                                  $totalPaymentF = number_format($totalPayment, 2, '.', ',');
                                  $grandTotal = $totalCost + $totalPayment;
                                  $grandTotal1F = number_format($grandTotal, 2, '.', ',');
                                  $grandTotal2F = number_format(-1 * $grandTotal, 2, '.', ',');
                                          
                                  
                                  echo "<id='example2'>";
                                  echo "<tbody>";
                                  if (!($paymentCollection == null)) {   
                                      while(!$paymentCollection->isEmpty()) {
                                          $payment = $paymentCollection->extract();
                                          $amount = $payment->getAmount();
                                          $sales = $payment->getSales();
                                          $salesFirst = $sales->getFirst();
                                          $salesLast = $sales->getLast();
                                          $amountF = number_format($amount, 2, '.', ',');
                                          $dateTime = $payment->getDate();
                                          $date1 = new DateTime($dateTime);
                                          $datePay = $date1->format('d-M-Y');
                                          echo "<tr>";
                                          echo "<td>" . $salesFirst . " " . " $salesLast" ."</td>";
                                          echo "<td> Ksh " . $amountF . "</td>";
                                          echo "<td>" . $datePay . "</td>";
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
                           <div class="col-1">
                            
                          </div>
                    </div>
                </div>
              </div>
            </section>
                <div class="row-auto" style="min-height:14vh;  min-width:60vw">
                    <div class= "col" style="background-color:lightblue; min-height:14vh"  >
                        <?php
                            echo "<div class='row '>";
                                echo "<div class ='col '>";
                                    echo "<h3>Shop Name</h3>";
                                    echo "<h5>" . $shopName. "</h5>";
                                echo "</div>";
                                echo "<div class = 'col-auto '>";
                                    echo "<h3 >Total Invoice Cost: Ksh " . $totalCostF . "</h3>";
                                    echo "<h5>Total Paid Towards: Ksh " . $totalPaymentF . "</h5>";
                                    if($grandTotal > 0){
                                      echo "<h5>Invoice Fully Paid Credit: Ksh " .  $grandTotal1F . "</h5>";
                                    }else{
                                      echo "<h5>Remaining Balance: Ksh " .  $grandTotal2F . "</h5>";
                                    }
                                echo "</div>";
                            echo "</div>";
                        ?>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
  
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
