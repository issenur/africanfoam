<?php
include_once("Connection.php");
include_once("InvoiceModel.php");
include_once("Account.php");
include_once("AccountCollection.php");

class AccountModel {
  
  //Field for singleton object
  public static $instance = null;
  
  // Constructor for a invoice object.
  function __construct(){
  
  }
  
  //Applying singleton pattern to account Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new AccountModel();
      }
      return self::$instance;
  }

  function retrieveAccount($customer_id){
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql  = "select * from invoice where customer_id = '$customer_id'";
    $result = $conn->query($sql);
      
    $invoiceModel = InvoiceModel::getInstance();
    $invoiceCollection = new InvoiceCollection();
    
    $balance = 0;
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $invoice_id = $row['invoice_id'];
        $invoice = $invoiceModel->retrieveInvoice($invoice_id);
        $invoiceBalance = $invoiceModel->getInvoiceBalance($invoice);
        $balance = $invoiceBalance + $balance;
        $invoiceCollection->insert($invoice);
      }
    }
    
    $sql  = "select * from invoice where customer_id = '$customer_id' AND date < DATE_ADD(NOW(), INTERVAL 0 DAY) AND date > DATE_ADD(NOW(), INTERVAL -30 DAY)";
    $result = $conn->query($sql);
      
  
    
    $balance1 = 0;
    
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $invoice_id = $row['invoice_id'];
        $invoice = $invoiceModel->retrieveInvoice($invoice_id);
        $invoiceBalance1 = $invoiceModel->getInvoiceBalance($invoice);
        if($invoiceBalance1 < 1){
          $balance1 = $invoiceBalance1 + $balance1;
        }
      }
    }
    
    $sql  = "select * from invoice where customer_id = '$customer_id' AND date < DATE_ADD(NOW(), INTERVAL -30 DAY) AND date > DATE_ADD(NOW(), INTERVAL -60 DAY)";
    $result = $conn->query($sql);
      
  
    
    $balance2 = 0;
    
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $invoice_id = $row['invoice_id'];
        $invoice = $invoiceModel->retrieveInvoice($invoice_id);
        $invoiceBalance2 = $invoiceModel->getInvoiceBalance($invoice);
        if($invoiceBalance2 < 1){
            $balance2 = $invoiceBalance2 + $balance2;
        }
      }
    }
    
   $sql  = "select * from invoice where customer_id = '$customer_id' AND date < DATE_ADD(NOW(), INTERVAL -60 DAY) AND date > DATE_ADD(NOW(), INTERVAL -90 DAY)";
   $result = $conn->query($sql);
      
  
    
    $balance3 = 0;
    
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $invoice_id = $row['invoice_id'];
        $invoice = $invoiceModel->retrieveInvoice($invoice_id);
        $invoiceBalance3 = $invoiceModel->getInvoiceBalance($invoice);
        if($invoiceBalance3 < 1){
            $balance3 = $invoiceBalance3 + $balance3;
        }
      }
    }
    
   $sql  = "select * from invoice where customer_id = '$customer_id' AND date < DATE_ADD(NOW(), INTERVAL -90 DAY) ";
   $result = $conn->query($sql);
      
  
    
    $balance4 = 0;
    
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $invoice_id = $row['invoice_id'];
        $invoice = $invoiceModel->retrieveInvoice($invoice_id);
        $invoiceBalance4 = $invoiceModel->getInvoiceBalance($invoice);
        if($invoiceBalance4 < 1){
            $balance4 = $invoiceBalance4 + $balance4;
        }
      }
    } 
    
   $account = new Account($customer_id, $invoiceCollection, $balance, $balance1, $balance2, $balance3, $balance4);
   return $account;
    
  }
  
  // Retrieves an account collection from the database
  function retrieveAccountCollection() {
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = "select * from customer";
    $result = $conn->query($sql);   
    $accountModel = accountModel::getInstance();
    $accountCollection = new AccountCollection();
    $accountObject = null;
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {      
        $customer_id = $row['customer_id'];
        
        $accountObject = $accountModel->retrieveAccount($customer_id);
        $accountCollection->insert($accountObject);
      }
    }
    return $accountCollection;
  }
  
  function getTotalCost($cc) {
    $costCollection = clone $cc;
    $num = 0;
    while(!$costCollection->isEmpty()){
      $cost = $costCollection->extract();
      $mattress = $cost->getMattress();
      $price = $mattress->getPrice();
      $quantity = $cost->getQuantity();
      $percent = $cost->getDiscount();
      $discount =  1 - ($percent / 100);
      $costNum = ($price * $discount) * $quantity;
      $num = $num + $costNum;
    }
    return 0-$num;
  }
  
  
}
?>