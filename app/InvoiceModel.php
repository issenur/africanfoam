<?php


include_once("Connection.php");
include_once("PaymentModel.php");
include_once("CostModel.php");
include_once("CustomerModel.php");
include_once("SalesModel.php");
include_once("InvoiceCollection.php");
include_once("Invoice.php");

class InvoiceModel {
  
  //Field for singleton object
  public static $instance = null;
  
  // Constructor for a invoice object.
  function __construct(){
  
  }
  
  //Applying singleton pattern to invoice Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new InvoiceModel();
      }
      return self::$instance;
  }
  
  // Adds a cost object to database 
  function addCost($costObject) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $invoice_id = $costObject->getAmount();
    $date = $paymentObject->getDate();
  
    $sql  = " INSERT INTO";
    $sql .= "   cost_line(invoice_id , mattress_id, quantity, discount)";
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
  function retrieveInvoice($invoice_id) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " SELECT";
    $sql .= "   * ";
    $sql .= " FROM invoice";
    $sql .= " WHERE invoice_id=? ";
    
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$result) {
      trigger_error('Invalid query: ' . $conn->error);
    }else{
      
      $invoice_id = $row['invoice_id'];
      $customer_id = $row['customer_id'];
      $sales_id = $row['sales_id'];
      $is_loan = $row['is_loan'];
      $invoiceDate = $row['date'];
      
    
      $sql  = "select * from cost_line where invoice_id = '$invoice_id'";
      $result = $conn->query($sql);
      
      $costModel = CostModel::getInstance();
      $costCollection = new CostCollection();
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $mattress_id = $row['mattress_id'];
          $quantity = $row['quantity'];
          $cost = $costModel->retrieveCost($invoice_id, $mattress_id, $quantity);
          $costCollection->insert($cost);
        }
      }
      
      $sql  = "select * from payment_line where invoice_id = '$invoice_id'";
      $result = $conn->query($sql);
      
      $paymentModel = PaymentModel::getInstance();
      $paymentCollection = new PaymentCollection();
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $amount = $row['amount'];
          $date = $row['date'];
          $sales_id = $row['sales_id'];
          $payment = $paymentModel->retrievePayment($invoice_id, $amount, $sales_id, $date);
          $paymentCollection->insert($payment);
        }
      }
      $salesModel = SalesModel::getInstance();
      $sales = $salesModel->retrieveUser($sales_id);
      $customerModel = CustomerModel::getInstance();
      $customer = $customerModel->retrieveUser($customer_id);
      $invoiceObject = new Invoice($invoice_id, $costCollection, $paymentCollection, $sales,  $customer,  $invoiceDate);
      return $invoiceObject;
    }
  }
  
  
  
  function getInvoiceBalance($invoice) {
    $costModel = CostModel::getInstance();
    $paymentModel = PaymentModel::getInstance();
    $cc = $invoice->getCostCollection();
    $pc = $invoice->getPaymentCollection();
    
    $costCollection = clone $cc;
    $paymentCollection = clone $pc;
    
    $totalCost = $costModel->getTotalCost($costCollection);
    $totalPayment = $paymentModel->getTotalPayment($paymentCollection);
    
    $invoiceBalance = $totalPayment + $totalCost;
    return $invoiceBalance;
  }
  
  function retrieveStoreInvoices(){
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql  = "select * from invoice";
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
    
   return $invoiceCollection;
  }
}
?>