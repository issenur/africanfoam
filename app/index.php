<?php
  session_start();
  include_once("Connection.php"); 
  $msg = "";
  
  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = sha1($password);
    $userType = $_POST['userType'];
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    $sql = "SELECT * FROM user WHERE username=? AND password=? AND user_type=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $userType);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    
  
    if(isset($row['username'], $row['user_type'], $row['active'])){
      $_SESSION['username'] = $row['username'];
      $_SESSION['role'] = $row['user_type'];
      $_SESSION['active'] = $row['active'];
    }
    if(isset($row['admin_id'])){
      $_SESSION['admin_id'] = $row['admin_id'];
    }  
    if(isset($row['customer_id'])){
      $_SESSION['customer_id'] = $row['customer_id'];
    }
    if(isset($row['sales_ii_id'])){
      $_SESSION['sales_ii_id'] = $row['sales_ii_id'];
    }
    if(isset($row['sales_id'])){
      $_SESSION['sales_id'] = $row['sales_id'];
    }
    
    if($result->num_rows == 1 && $_SESSION['role'] == "Administrator" && $_SESSION['active'] > 0 ){
      header("location:AdminView.php");
    } else if($result->num_rows == 1 && $_SESSION['role'] == "Customer" && $_SESSION['active'] > 0){
      header("location:CustomerView.php");
    } else if($result->num_rows == 1 && $_SESSION['role'] == "IISales" && $_SESSION['active'] > 0){
      header("location:IISalesPersonView.php");
    } else if($result->num_rows == 1 && $_SESSION['role'] == "Sales" && $_SESSION['active'] > 0){
      header("location:SalesPersonView.php");
    } else{
      $msg = "Username or Password is Incorrect!";
    }
    session_write_close();
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  
  <title>Africanfoam Login</title>
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-box-body justify-content-center" >
    <p class="login-box-msg">USER LOGIN PAGE</p>
    <!-- Lets redirect the users to a page based on their role-->
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="USERNAME" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="PASSWORD" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group">
        <label for="UserType">I am a :</label>
        <input type = "radio" name= "userType" value="Administrator" class="custom-radio" required>&nbsp;Admin  |
        <input type = "radio" name= "userType" value="Customer" class="custom-radio" required>&nbsp;Customer |
        <input type = "radio" name= "userType" value="IISales" class="custom-radio" required>&nbsp;IISales |
        <input type = "radio" name= "userType" value="Sales" class="custom-radio" required>&nbsp;Sales
      </div>
      <div class="row d-flex justify-content-center">
        <!-- /.col -->
        <div class="col-xs-4 ">
          <button type="Submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
      <br>
      <h6 class="text-danger text-center"><?= $msg; ?></h6>
    </form>    
    <!-- /.social-auth-links -->
  </div>
<!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="dist/js/pages/dashboard2.js"></script>
<script src="../../plugins/iCheck/icheck.min.js"></script>
<script>
$(function () {
$('input').iCheck({
checkboxClass: 'icheckbox_square-blue',
radioClass: 'iradio_square-blue',
increaseArea: '20%' /* optional */
});
});
</script>
</body>
</html>
