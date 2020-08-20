<?php
include_once("Connection.php");
include_once("Payment.php");
include_once("PaymentCollection.php");
include_once("SalesModel.php");

class PaymentModel {
  
  //Field for singleton object
  public static $instance = null;
  
  // Constructor for a payment object.
  function __construct(){
  
  }
  
  //Applying singleton pattern to Payment Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new PaymentModel();
      }
      return self::$instance;
  }
  
  // Adds a payment object to database 
  function addPayment($paymentObject) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $amount = $paymentObject->getAmount();
    $date = $paymentObject->getDate();
  
    $sql  = " INSERT INTO";
    $sql .= "   payment_line(amount , date)";
    $sql .= " VALUES('$amount', '$date')";
  
    $stmt=$conn->prepare($sql);
    
    if ($stmt->execute() === TRUE) {
      $payment_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  
    return $payment_id;
  }
  
 
  // Retrieves a payment object from the database
  function retrievePayment($invoice_id, $amount, $sales_id, $date) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " SELECT";
    $sql .= "   * ";
    $sql .= " FROM payment_line";
    $sql .= " WHERE invoice_id=? AND amount=? AND date=?";
    
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("iis", $invoice_id, $amount, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$result) {
      trigger_error('Invalid query: ' . $conn->error);
    }else{
      $amount = $row['amount'];
      $date = $row['date'];
      $salesModel = SalesModel::getInstance();
      $sales = $salesModel->retrieveUser($sales_id);   
      $paymentObject = new Payment($amount, $sales,  $date);
      return $paymentObject;
    }
  }
  
  // Retrieves a payment object from the database
  function retrievePaymentCollection($invoice_id) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = "select * from payment_line where invoice_id = '$invoice_id'";
    $result = $conn->query($sql);   
    $paymentModel = PaymentModel::getInstance();
    $paymentCollection = new PaymentCollection();
    $paymentObject = null;
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $amount = $row['amount'];
        $date = $row['date'];
        $paymentObject = $paymentModel->retrievePayment($invoice_id, $amount, $date);
        $paymentCollection->insert($paymentObject);
      }
    }
    return $paymentCollection;
  }
  
  function getTotalPayment($pc) {
    $paymentCollection = clone $pc;
    $num = 0;
    while(!$paymentCollection->isEmpty()){
      $payment = $paymentCollection->extract();
      $amount = $payment->getAmount();
      $num = $num + $amount;
    }
    return $num;
  }
}
?>