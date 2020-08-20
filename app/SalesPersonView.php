<?php
    include_once("SalesModel.php");
    include_once("CustomerModel.php");
    include_once("Model.php");
    include_once("Account.php");
    include_once("AccountModel.php");

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
  <title>African Foam Sales</title>
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
             $model= new Model();
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
            <a href="SalesPersonView.php" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>Salesman Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="InvoiceAddView.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Create Invoice</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="PaymentAddView.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Apply Payment</p>
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

  <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                       <h1>Customer Accounts</h1>
                       <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Shop Name</th>
                                    <th>Action</th>
                                    <th>Customer</th>
                                    <th>Phone Number</th>
                                    <th>Account Balance</th>
                                </tr>
                            </thead>
                            <?php
                                $accountModel = AccountModel::getInstance();
                                $accountCollection = $accountModel->retrieveAccountCollection();
                                $customerModel= CustomerModel::getInstance();
                                echo "<id='example2'>";
                                echo "<tbody>";
                                if (!($accountCollection == null)) {
                                    while(!$accountCollection->isEmpty()) {
                                        $account = $accountCollection->extract();
                                        $customer_id = $account->getCustomerId();
                                        $customer = $customerModel->retrieveUser($customer_id);
                                        $shopName = $customer->getShopName();
                                        $phoneNumber = $customer->getPhoneNumber();
                                        $first = $customer->getFirst();
                                        $last = $customer->getLast();
                                        
                                        
                                        $phoneNumberF = sprintf("%s-%s-%s-%s",
                                        substr($phoneNumber, 0, 3),
                                        substr($phoneNumber, 3, 3),
                                        substr($phoneNumber, 6, 2),
                                        substr($phoneNumber, 8, 4)
                                        );

                                        $accountBalance = $account->getAccountBalance();
                                        $accountBalanceF = number_format($accountBalance, 2, '.', ',');
                                        echo "<tr>";
                                        echo "<td>" . $shopName. "</td>";
                                        echo"<td>";
                                        echo "<a href ='SalesCustomerDetailView.php?view_invoice=".  $customer_id  ."'><button class='btn btn-dark'>Account Details</button>"."<a/>";
                                        echo "</td>";
                                        echo "<td>" . $first . " " . $last . "</td>";
                                        echo "<td> +" . $phoneNumberF . "</td>";
                                        if(($accountBalance) < 0){
                                          echo "<td style='color:red'  > Ksh " . $accountBalanceF . "</td>";
                                        }else if(($accountBalance) == 0){
                                          echo "<td> Ksh " . $accountBalanceF . "</td>";
                                        }else{
                                          echo "<td style='color:green'> Ksh + " . $accountBalanceF . "</td>";
                                        }
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "</tbody>";
                                    echo "</table>";
                                    echo "<h4>CUSTOMER DATABASE IS EMPTY</h4>";
                                }
                            ?>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12">
                       <h1>+90 days past-due</h1>
                       <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Shop Name</th>
                                    <th>Customer</th>                          
                                    <th>Action</th>
                                    <th>Amount</th>
                                    
                                </tr>
                            </thead>
                            <?php
                                $accountModel = AccountModel::getInstance();
                                $accountCollection = $accountModel->retrieveAccountCollection();
                                $customerModel= CustomerModel::getInstance();
                                echo "<id='example2'>";
                                echo "<tbody>";
                                if (!($accountCollection == null)) {
                                    while(!$accountCollection->isEmpty()) {
                                        $account = $accountCollection->extract();
                                        $customer_id = $account->getCustomerId();
                                        $customer = $customerModel->retrieveUser($customer_id);
                                        $shopName = $customer->getShopName();
                                        $phoneNumber = $customer->getPhoneNumber();
                                        $first = $customer->getFirst();
                                        $last = $customer->getLast();
                                        
                                        
                                        $phoneNumberF = sprintf("%s-%s-%s-%s",
                                        substr($phoneNumber, 0, 3),
                                        substr($phoneNumber, 3, 3),
                                        substr($phoneNumber, 6, 2),
                                        substr($phoneNumber, 8, 4)
                                        );
                                        $balance90 = $account->getAccountBalance4();
                                        $balance90F = number_format($balance90, 2, '.', ',');
                                        echo "<tr>";
                                        echo "<td>" . $shopName. "</td>";
                                        echo "<td>" . $first . " " . $last . "</td>";
                                        echo"<td>";
                                        echo "<a href ='SalesCustomerDetailView.php?view_invoice=".  $customer_id  ."'><button class='btn btn-info'>Account Details</button>"."<a/>";
                                        echo "</td>";
                                        if($balance90F > 0){
                                          echo "<td style='color:red' > Ksh " . $balance90F . "</td>";
                                        }
                                        echo "<td> Ksh " . $balance90F . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "</tbody>";
                                    echo "</table>";
                                    echo "<h4>CUSTOMER DATABASE IS EMPTY</h4>";
                                }
                            ?>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12">
                       <h1> 60 - 89 days past-due</h1>
                       <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                   <th>Shop Name</th>
                                   <th>Customer</th>                                 
                                   <th>Action</th>
                                   <th>Amount</th>
                                </tr>
                            </thead>
                            <?php
                                $accountModel = AccountModel::getInstance();
                                $accountCollection = $accountModel->retrieveAccountCollection();
                                $customerModel= CustomerModel::getInstance();
                                echo "<id='example2'>";
                                echo "<tbody>";
                                if (!($accountCollection == null)) {
                                    while(!$accountCollection->isEmpty()) {
                                        $account = $accountCollection->extract();
                                        $customer_id = $account->getCustomerId();
                                        $customer = $customerModel->retrieveUser($customer_id);
                                        $shopName = $customer->getShopName();
                                        $phoneNumber = $customer->getPhoneNumber();
                                        $first = $customer->getFirst();
                                        $last = $customer->getLast();
                                        
                                        
                                        $phoneNumberF = sprintf("%s-%s-%s-%s",
                                        substr($phoneNumber, 0, 3),
                                        substr($phoneNumber, 3, 3),
                                        substr($phoneNumber, 6, 2),
                                        substr($phoneNumber, 8, 4)
                                        );
                                        $balance60 = $account->getAccountBalance3();
                                        $balance60F = number_format($balance60, 2, '.', ',');
                                        
             
                                        echo "<tr>";
                                        echo "<td>" . $shopName. "</td>";
                                        echo "<td>" . $first . " " . $last . "</td>";
                                        echo"<td>";
                                        echo "<a href ='SalesCustomerDetailView.php?view_invoice=".  $customer_id  ."'><button class='btn btn-info'>Account Details</button>"."<a/>";
                                        echo "</td>";
                                        if($balance60F > 0){
                                          echo "<td style='color:red' > Ksh " . $balance60F . "</td>";
                                        }
                                        echo "<td> Ksh " . $balance60F . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "</tbody>";
                                    echo "</table>";
                                    echo "<h4>CUSTOMER DATABASE IS EMPTY</h4>";
                                }
                            ?>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12">
                       <h1> 30-59 Days past-due</h1>
                       <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Shop Name</th>                                 
                                    <th>Customer</th>                               
                                    <th>Action</th>
                                    <th>Amount</th>
                                    
                                </tr>
                            </thead>
                            <?php
                                $accountModel = AccountModel::getInstance();
                                $accountCollection = $accountModel->retrieveAccountCollection();
                                $customerModel= CustomerModel::getInstance();
                                echo "<id='example2'>";
                                echo "<tbody>";
                                if (!($accountCollection == null)) {
                                    while(!$accountCollection->isEmpty()) {
                                        $account = $accountCollection->extract();
                                        $customer_id = $account->getCustomerId();
                                        $customer = $customerModel->retrieveUser($customer_id);
                                        $shopName = $customer->getShopName();
                                        $phoneNumber = $customer->getPhoneNumber();
                                        $first = $customer->getFirst();
                                        $last = $customer->getLast();
                                        
                                        
                                        $phoneNumberF = sprintf("%s-%s-%s-%s",
                                        substr($phoneNumber, 0, 3),
                                        substr($phoneNumber, 3, 3),
                                        substr($phoneNumber, 6, 2),
                                        substr($phoneNumber, 8, 4)
                                        );
          
                                        $balance30 = $account->getAccountBalance2();
                                        $balance30F = number_format($balance30, 2, '.', ',');
                                        echo "<tr>";
                                        echo "<td>" . $shopName. "</td>";
                                        echo "<td>" . $first . " " . $last . "</td>";
                                        echo"<td>";
                                        echo "<a href ='SalesCustomerDetailView.php?view_invoice=".  $customer_id  ."'><button class='btn btn-info'>Account Details</button>"."<a/>";
                                        echo "</td>";
                                        if($balance30F > 0){
                                          echo "<td style='color:red' > Ksh " . $balance30F . "</td>";
                                        }
                                        echo "<td> Ksh " . $balance30F . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "</tbody>";
                                    echo "</table>";
                                    echo "<h4>CUSTOMER DATABASE IS EMPTY</h4>";
                                }
                            ?>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12">
                       <h1> created 0-29 days ago</h1>
                       <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Shop Name</th>                                 
                                    <th>Customer</th>                               
                                    <th>Action</th>
                                    <th>Amount</th>
                                    
                                </tr>
                            </thead>
                            <?php
                                $accountModel = AccountModel::getInstance();
                                $accountCollection = $accountModel->retrieveAccountCollection();
                                $customerModel= CustomerModel::getInstance();
                                echo "<id='example2'>";
                                echo "<tbody>";
                                if (!($accountCollection == null)) {
                                    while(!$accountCollection->isEmpty()) {
                                        $account = $accountCollection->extract();
                                        $customer_id = $account->getCustomerId();
                                        $customer = $customerModel->retrieveUser($customer_id);
                                        $shopName = $customer->getShopName();
                                        $phoneNumber = $customer->getPhoneNumber();
                                        $first = $customer->getFirst();
                                        $last = $customer->getLast();
                                        
                                        
                                        $phoneNumberF = sprintf("%s-%s-%s-%s",
                                        substr($phoneNumber, 0, 3),
                                        substr($phoneNumber, 3, 3),
                                        substr($phoneNumber, 6, 2),
                                        substr($phoneNumber, 8, 4)
                                        );
          
                                        $balance30 = $account->getAccountBalance1();
                                        $balance30F = number_format($balance30, 2, '.', ',');
                                        echo "<tr>";
                                        echo "<td>" . $shopName. "</td>";
                                        echo "<td>" . $first . " " . $last . "</td>";
                                        echo"<td>";
                                        echo "<a href ='SalesCustomerDetailView.php?view_invoice=".  $customer_id  ."'><button class='btn btn-info'>Account Details</button>"."<a/>";
                                        echo "</td>";
                                        if($balance30F > 0){
                                          echo "<td style='color:red' > Ksh " . $balance30F . "</td>";
                                        }
                                        echo "<td> Ksh " . $balance30F . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "</tbody>";
                                    echo "</table>";
                                    echo "<h4>CUSTOMER DATABASE IS EMPTY</h4>";
                                }
                            ?>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Africanfoam App Version</b> 5.0
    </div>
     All rights
    reserved.
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
<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
</body>
</html>
