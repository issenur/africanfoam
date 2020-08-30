<?php
    include_once("SalesModel.php");
    include_once("Model.php");
    include_once("Connection.php"); 
    session_start();
    
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "Sales"){
        header("location:index.php");
    }
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();  
     

    
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
             $model = new Model();
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
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Payment Form</h3>
              </div>
              <!-- /.card-header -->
              <form method="POST" id="invoice_add_form">
                <div class= "card-body">       
                  <div class= "row">
                    <div class="col">
                      <div class="table-fixed">
                        <span id="error"></span>
                        <table class="table table-borderless" id="invoice_table">
                        <tbody>
                          <tr>
                            <th style="width: 50%">Invoice</th>
                            <th style="width: 20%">Payment</th>
                            <th style="width: 25%">Date</th>
                          </tr>
                          <tr>
                            <td style="width: 50%">
                              <select id="invoice_id" name="invoice_id" class="form-control invoice_id">
                              <option value="">-------Select Invoice------</option>
                              <?php
                                $connection = Connection::getInstance();
                                $conn = $connection->getConn();
                                $sql = "SELECT * FROM invoice ORDER by invoice_id DESC";
                                $result = $conn->query($sql);
                                
                                if ($result->num_rows > 0) {       
                                  
                                  while($row = $result->fetch_assoc()) {
                                    $date1 = new DateTime($row['date']);
                                    $date = $date1->format('d-M-Y');
                                    echo "<option value=" . $row['invoice_id'] . "> Invoice#:" . $row['invoice_id'] . " Date:" . $date . "</option>";
                                  }   
                                }
                              ?>
                            </td>
                            <td style="width: 20%"><input type="text"  class="form-control amount" id="mattress_form_amount"  name="amount" placeholder="Ksh 0000.00"></td>
                            <td style="width: 25%">
                                  
                                      
                                   
                                <input type="text" class="form-control date" id="mattress_form_date" name="date" placeholder="01-JAN-2000"> </input>
                                    
                            </td>
                          </tr>
                        </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer ">
                  <button class="btn btn-primary submit" type="submit" id="mattress_form_submit" name="submit">Submit Invoice</button>
                  <br>
                  <br>
                  <p class="mattress_form_message" id="message" name="message" ></p>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
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
$(document).ready(function(){

 
  
$('#invoice_add_form').on('click','.submit', function(event){
    event.preventDefault();
    var error = '';
   
    var form_data = $("#invoice_add_form").serialize();
    var invoiceInput = $('#invoice_id').val();
    var dateInput = $('#mattress_form_date').val();
    var dateT = $('#mattress_form_date').val();
    var dateL = dateT.length;
    
    if(dateL == 11){
      var day = dateT.substring(0, 2);
      var fdash = dateT.substring(2, 3);
      var month = dateT.substring(3, 6);
      var sdash = dateT.substring(6, 7);
      var year = dateT.substring(7, 11);
    }else if(dateL == 10){
      var day = dateT.substring(0, 1);
      var fdash = dateT.substring(1, 2);
      var month = dateT.substring(2, 5);
      var sdash = dateT.substring(5, 6);
      var year = dateT.substring(6, 10); 
    }else{
      
    }
    var amountInput = $('#mattress_form_amount').val();
    if((error == '')){
     if((invoiceInput == '')|| (amountInput == '') || (dateInput == '')){
      
        $("#mattress_form_amount").addClass("form-control is-invalid");
        $("#mattress_form_date").addClass("form-control is-invalid");
        $('#message').html("<span class='text-danger'>Please Fill in all Fields</span>");
      }else if(!$.isNumeric(amountInput) || (amountInput < 0)){
        $("#mattress_form_amount").addClass("form-control is-invalid");
        $('#message').html("<span class='text-danger'>Amount must be a positive number</span>");
      }else if((10 > dateL) || (dateL > 11)){
        $("#mattress_form_date").addClass("form-control is-invalid");
        $('#message').html("<span class='text-danger'>Date format must be DD-MMM-YYYY   e.g. xx-JUN-20xx</span>");     
      }else if( (day > 31) || (day < 1) || $.isNumeric(month) ){
        $("#mattress_form_date").addClass("form-control is-invalid");
        $('#message').html("<span class='text-danger'>Day out of range</span>");
      }else if((year < 2000) || (year > 2025)){
        $("#mattress_form_date").addClass("form-control is-invalid");
        $('#message').html("<span class='text-danger'>Year out of range</span>");
      }else{
      $.ajax({
        url: "PaymentAddController.php",
        method: "POST",
        data: form_data,
        success:function(data){
            $("#invoice_id, #mattress_form_amount, #mattress_form_date").removeClass("is-invalid");
            if(data == 'ok'){
              $("#mattress_form_amount, #mattress_form_date, #invoice_id").val("");
              $('#message').html("<span class='text-success'>Payment Successfully Created</span>"); 
            }else {
              $('#message').html("<span class='text-danger'>Payment Add Unsuccessfull</span>");
            }
        }
      });
    }
    }else{
      $('#message').html("<span class='text-danger'> "+ error +" </span>");
    }
  });
});
</script>
</body>
</html>
