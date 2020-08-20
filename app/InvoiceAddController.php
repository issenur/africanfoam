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
  
  $model = new Model();
  $user_id = $model->getCurrentUserId();
  
  $customer_id = $_POST['customer_id'];
  $amount = $_POST['amount'];
  $date = $_POST['date'];
  if(strlen($date) == 11){
    $year = substr($date, -4, 4);
    $monthStr = substr($date, -8, 3);
    $day = substr($date, -11, 2);
  }else{
    $year = substr($date, -4, 4);
    $monthStr = substr($date, -8, 3);
    $day = substr($date, -10, 1);
  }
  $monthStr = strtolower($monthStr);
  $month = "";
  
  switch ($monthStr) {
  case 'jan':
    $month= 1;
    break;
  case 'feb':
    $month= 2;
    break;
  case 'mar':
    $month= 3;
    break;
  case 'apr':
    $month= 4;
    break;
  case 'may':
    $month= 5;
    break;
  case 'jun':
    $month= 6;
    break;
  case 'jul':
    $month= 7;
    break;
  case 'aug':
    $month= 8;
    break;
  case 'sep':
    $month= 9;
    break;
  case 'sept':
    $month= 9;
    break;
  case 'oct':
    $month= 10;
    break;
  case 'nov':
    $month= 11;
    break;
  case 'dec':
    $month= 12;
    break;
  default:
    $month="";
  }
  $d=mktime(0, 0, 0, $month, $day, $year);
   
  $date_time = date("Y-m-d ", $d);

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
  
  $sql = "INSERT INTO `payment_line` (`invoice_id` , `amount`, `date`, `sales_id`) values('$invoice_id' , '$amount', '$date_time', '$user_id')";
  $stmt=$conn->prepare($sql);
  $result = $stmt->execute();
  
  if($result == true){
      echo 'ok';
  } else{
      echo 'not ok';
  }
} 



