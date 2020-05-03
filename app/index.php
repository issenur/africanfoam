<?php
    session_start();
    //include_once("Globals.php");
    //include_once("Model.php");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "afoam";
    $conn = new mysqli($servername, $username, $password, $dbname);
    $msg = "";
 
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = sha1($password);
        $userType = $_POST['userType'];
        global $conn;
        $sql = "SELECT * FROM `user` WHERE `username`=? AND `password`=? AND `user_type`=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $userType);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['user_type'];
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['customer_id'] = $row['customer_id'];
        $_SESSION['sales_ii_id'] = $row['sales_ii_id'];
        $_SESSION['sales_id'] = $row['sales_id'];
        $_SESSION['active'] = $row['active'];
      
        
        
        if($result->num_rows == 1 && $_SESSION['role'] == "admin" && $_SESSION['active'] > 0 ){
            header("location:AdminView.php");
        } else if($result->num_rows == 1 && $_SESSION['role'] == "customer" && $_SESSION['active'] > 0){
            header("location:CustomerView.php");
        } else if($result->num_rows == 1 && $_SESSION['role'] == "sales_ii_id" && $_SESSION['active'] > 0){
            header("location:SalesIIView.php");
        } else if($result->num_rows == 1 && $_SESSION['role'] == "sales_id" && $_SESSION['active'] > 0){
            header("location:Sales.php");
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
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Log in</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="../../plugins/iCheck/square/blue.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
                <input type = "radio" name= "userType" value="admin" class="custom-radio" required>&nbsp;Admin  |
                <input type = "radio" name= "userType" value="customer" class="custom-radio" required>&nbsp;Customer |
                <input type = "radio" name= "userType" value="SalesII" class="custom-radio" required>&nbsp;Sales II
                <input type = "radio" name= "userType" value="Sales" class="custom-radio" required>&nbsp;Sales
            </div>
            
            <div class="row d-flex justify-content-center">
                <!-- /.col -->
                <div class="col-xs-4 ">
                <button type="Submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
            <h5 class="text-danger text-center"><?= $msg; ?></h5>
        </form>    
    <!-- /.social-auth-links -->
    </div>
<!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
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
