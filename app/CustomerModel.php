<?php
include_once("Connection.php");
include_once("UserModel.php");
include_once("Customer.php");
include_once("CustomerEndUser.php");
include_once("InvoiceModel.php");

class CustomerModel extends UserModel {
  
  //Field for singleton object
  public static $instance = null;
  
  // Constructor for a customer object.
  function __construct(){
  
  }
  
  //Applying singleton pattern to Customer Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new CustomerModel();
      }
      return self::$instance;
  }
  
  // Adds a customer object to database 
  function addUser($userObject) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $first = $userObject->getFirst();
    $last = $userObject->getLast();
    $shop_name = $userObject->getShopName();
    $phone_number = (int)$userObject->getPhoneNumber();
    
    $sql  = " INSERT INTO";
    $sql .= "   customer(shop_name ,first, last, phone_number, active)";
    $sql .= " VALUES('$shop_name', '$first', '$last', '$phone_number', 1)";
  
    $stmt=$conn->prepare($sql);
    
    if ($stmt->execute() === TRUE) {
      $user_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  
    return $user_id;
  }
  
 
  // Retrieves a customer object from the database
  function retrieveUser($user_id) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " SELECT";
    $sql .= "   first,";
    $sql .= "   last,";
    $sql .= "   shop_name,";
    $sql .= "   phone_number,";
    $sql .= "   active";
    $sql .= " FROM customer";
    $sql .= " WHERE customer_id=?";
    
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$result) {
      trigger_error('Invalid query: ' . $conn->error);
    }else{
      $first = $row['first'];
      $last = $row['last'];
      $shop_name = $row['shop_name'];
      $phone_number = $row['phone_number'];
      $active = $row['active'];
      $userObject = new Customer($user_id, $shop_name, $first, $last, $phone_number, $active);
      return $userObject;
    }
  }
  
  function getAccountBalance($user_id) {
    $customerModel = CustomerModel::getInstance();
    $inv = $customerModel->retrieveInvoices($user_id);
    $invoiceCollection = clone $inv;
    $num = 0;
    while(!$invoiceCollection->isEmpty()) {
     $invoice = $invoiceCollection->extract();
     $invoiceBalance = $invoice->getInvoiceBalance();
     $num = $num + $invoiceBalance;
    }
    return $num;
  }
}

?>