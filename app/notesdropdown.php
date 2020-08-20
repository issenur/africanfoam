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
     

    function fill_unit_select_box($conn){
      $output = "";
      $sql = "SELECT * FROM mattress ORDER by Price DESC";
      $result = $conn->query($sql);
      while($row = $result->fetch_assoc()) {
        $price = number_format($row['price'], 2, '.', ',');
        $output .= '<option value= "'. $row['mattress_id']. '">' . $row['description'] . " Ksh" . $price .'</option>';
      }
      return $output;
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
            <a href="SalesPersonView.php" class="nav-link active">
              <i class="far fa-circle nav-icon"></i>
              <p>Salesman Dashboard</p>
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
              <form method="POST" id="invoice_add_form">
                <div class= "card-body">       
                  <div class= "row">
                    <div class="col">
                      <div class="table-fixed">
                        <span id="error"></span>
                        <table class="table table-borderless" id="invoice_table">
                        <tbody>
                           <tr>
                            <th style="width: 50%">
                              <label>Invoice Customer</label>
                            </th>
                           </tr>
                           <tr>
                           <td style="width: 50%">
                              <select id=customer_id name="customer_id" class="form-control customer_id">
                              <option value="">--Select Shop Name--</option>
                              <?php
                                $connection = Connection::getInstance();
                                $conn = $connection->getConn();
                                $sql = "SELECT * FROM customer ORDER by first ASC";
                                $result = $conn->query($sql);
                                
                                if ($result->num_rows > 0) {       
                                  
                                  while($row = $result->fetch_assoc()) {
                                    echo "<option value=" . $row['customer_id'] . ">" . $row['shop_name'] . "</option>";
                                  }   
                                }
                              ?>
                              </select>
                           </td>
                           </tr>
                          <tr>
                            <th style="width: 70%">Mattress Name</th>
                            <th style="width: 10%">Qty</th>
                            <th style="width: 15%">Discount%</th>
                            <th style="width: 25%" ><button type="button" style="width: 30px" id="mattress_line_add" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"> + </span></button></th>
                          </tr>
                          <tr>
                            <td style="width: 70%">
                              <select id=mattress_form_id0 name="mattress_id[]" class="form-control mattress_id">
                              <option value="">--Select Mattress--</option>
                              <?php
                                $connection = Connection::getInstance();
                                $conn = $connection->getConn();
                                $sql = "SELECT * FROM mattress ORDER by Price DESC";
                                $result = $conn->query($sql);
                                
                                if ($result->num_rows > 0) {       
                                  
                                  while($row = $result->fetch_assoc()) {
                                    $price = number_format($row['price'], 2, '.', ',');
                                    echo "<option value=" . $row['mattress_id'] . ">" . $row['description'] . " Ksh" . $price . "</option>";
                                  }   
                                }
                              ?>
                            </td>
                            <td style="width: 10%"><input id="mattress_form_quantity0" class="form-control quantity" type="text" name="quantity[]" placeholder="Qty"></td>
                            <td style="width: 15%"><input id="mattress_form_discount0" class="form-control discount" type="text" name="discount[]" placeholder="Percent%"></td>
                            <td style="width: 25%"><button class="btn btn-danger btn-sm remove" style="width: 30px" type="button" name="mattress_line_remove"><span class="glyphicon glyphicon-minus"> - </span></button></td>
                          </tr>
                        </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="row">
                        <div class="col-sm-4">
                        </div>
                        <div class= "col-sm-8">
                          <div class= "row">
                            <div class= "col-sm-8">  
                               <label> Payment Towards Invoice </label>
                            </div>
                            <div class= "col-sm-4">
                                <label>  Date   </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class= "row">
                        <div class="col-sm-4">
                        </div>
                        <div class= "col-sm-8">
                          <div class= "row">
                            <div class= "col-sm-8">  
                              <div class="form-group">
                                <input type="text"  class="form-control amount" id="mattress_form_amount"  name="amount" placeholder="Ksh 0000.00">
                              </div>
                            </div>
                            <div class= "col-sm-4">
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                    <input type="text" class="form-control float-right date" id="mattress_form_date" name="date" placeholder="yyyy-mm-dd">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer ">
                  <button class="btn btn-info submit" type="submit" id="mattress_form_submit" name="submit">Submit Invoice</button>
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
   $(document).on('click', '.add', function(){
  var counter = 1;
  var html = '';
      html += '<tr>';
      html += '<td>';
      html += '<select id="mattress_form_id' + counter + '" name="mattress_id[]"  class="form-control select2bs4 select2-hidden-accessible mattress_id" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true"  >';
      html += '<option value="">--Select Mattress--</option>';
      html += '<?php echo fill_unit_select_box($conn); ?>';
      html += '</td>';
      html += '<td><input type="text"  class="form-control quantity" id="mattress_form_quantity' + counter + ' "  name="quantity[]" placeholder="Qty"></td>';
      html += '<td><input type="text"  class="form-control discount" id="mattress_form_discount' + counter + ' "  name="discount[]" placeholder="Percent%"></td>';
      html += '<td><button style="width: 30px" class="btn btn-danger btn-sm remove" type="button" name="remove"><span class="glyphicon glyphicon-minus">-</span></button> </td>';
      html += '</tr>'
      $('#invoice_table').append(html);
      counter++;
  });
  
  $(document).on('click', '.remove', function(){
    $(this).closest('tr').remove();
  });
  
$('#invoice_add_form').on('click','.submit', function(event){
    event.preventDefault();
    var error = '';
    
 
    var form_data = $("#invoice_add_form").serialize();
    if(error == ''){
      $.ajax({
        url: "CostLineController.php",
        method: "POST",
        data: form_data,
        success:function(data){
          if(data == 'ok'){
            $('#invoice_table').find("tr:gt(0)").remove();
            $('#message').html("<span class='text-success'>Mattress Added Successfully "+ error + "</span>");
          }else{
            $('#message').html("<span class='text-danger'>Mattress Not Added "+ error + "</span>");
          }
        }
      });
    }else{
      $('#message').html("<span class='text-danger'> "+ error +" </span>");
    }
  });
});
</script>
</body>
</html>
-----------------------------------------------------------------------------------------------------------------------------------------------------
<?php
include_once("SalesModel.php");
include_once("Model.php");
include_once("Connection.php"); 
session_start();
  if(!isset($_SESSION['username']) || $_SESSION['role'] != "Sales"){
    header("location:index.php");
    
  }
    
  if(isset($_POST['quantity'])){
    $connections = Connection::getInstance();
    $conn = $connections->getConn();
   
    $customer_id = $_POST['customer_id'];
    $time = "00:00:00";
    $date = $_POST['date'];
    $date_time = $date;
    
    $model = Model::getInstance();
    $user_id = $model->getCurrentUserId();
  
    $sql = "INSERT INTO `invoice` (`customer_id` , `sales_id`, `is_loan`, `date`) values('$customer_id' , '$user_id', '1', '$date_time')";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    
    $sql = "SELECT MAX(`invoice_id`) from  `invoice` WHERE `customer_id` = '$customer_id' AND `sales_id` = '$user_id' ";
    $result = $conn->query($sql);
    $row = $result -> fetch_array();
    $invoice_id = (int)$row['MAX(`invoice_id`)'];
   
    $connect = new PDO("mysql:host=localhost;dbname=afoam", "root", "");
    for($count = 0; $count < count($_POST['mattress_id']); $count++){
        $sql  = " INSERT INTO";
        $sql .= " `cost_line` (`invoice_id` , `mattress_id`, `quantity`, `discount`)";
        $sql .= " VALUES ('$invoice_id' , :mattress_id, :quantity, :discount )";
        
        $stmt = $connect->prepare($sql);
        $stmt->execute(array(
        ':mattress_id' => $_POST['mattress_id'][$count],
        ':quantity'  => $_POST['quantity'][$count], 
        ':discount' => $_POST['discount'][$count] 
        )
      );
    }
    $amount = $_POST['amount'];
    
    $sql = "INSERT INTO `payment_line` (`invoice_id` , `amount`, `date`, `sales_id`) values('$invoice_id' , '$amount',  '$date_time', '$user_id')";
    $stmt=$conn->prepare($sql);
    $result = $stmt->execute();
    
    
    if(!($result == true)){
        echo 'not ok';
      } else{
        echo 'ok';
      }
  } 
?>
------------------------------------------------------------------------------------------------------------------------------------------------------------
<?php
class Model {
  
  //Field for singleton object
  public static $instance = null;
  private $currentuserid = 0;
  
  // Constructor for a customer object.
  function __construct(){
        if($_SESSION['role'] == "Administrator"){
           $this->currentuserid = $_SESSION['admin_id'];
        } else if($_SESSION['role'] == "Customer"){
            $this->currentuserid = $_SESSION['customer_id'];
        } else if($_SESSION['role'] == "SalesII"){
            $this->currentuserid = $_SESSION['sales_ii_id'];
        } else if($_SESSION['role'] == "Sales"){
            $this->currentuserid = $_SESSION['sales_id'];
        } else{}
  }
  
  //Applying singleton pattern to Customer Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new Model();
      }
      return self::$instance;
  }
  
  //Setter for current user id
  public function setCurrentUserId($user_id) {
    $this->currentuserid = $user_id;   
  }
  
  //Getter for current user id
  public function getCurrentUserId() {
    return($this->currentuserid);
  }
}
?>
-------------------------------------------------------------------------------------------------------------------------------------------------------------