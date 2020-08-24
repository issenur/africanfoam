<?php
include_once("Cost.php");
include_once("CostCollection.php");
include_once("MattressModel.php");
include_once("Connection.php");

class CostModel { 
  //Field for singleton object
  public static $instance = null;
  
  // Constructor for a cost object.
  function __construct(){
  
  }
  
  //Applying singleton pattern to Cost Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new CostModel();
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
  function retrieveCost($invoice_id, $mattress_id, $quantity) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " SELECT ";
    $sql .= "   * ";
    $sql .= " FROM cost_line";
    $sql .= " WHERE invoice_id=? AND mattress_id=? AND quantity=?";
    
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("iii", $invoice_id, $mattress_id, $quantity);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    $invoice_id = $row['invoice_id'];
    $mattress_id = $row['mattress_id'];
    $quantity = $row['quantity'];
    $discount = $row['discount'];
    $mattressModel = MattressModel::getInstance();
    $mattress = $mattressModel->retrieveMattress($mattress_id);   
    
    
    $costObject = new Cost($mattress, $quantity, $discount);
    return $costObject;
  }
  
  // Retrieves a cost object from the database
  function retrieveCostCollection($invoice_id) {
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = "select * from cost_line where invoice_id = '$invoice_id'";
    $result = $conn->query($sql);   
    $costModel = costModel::getInstance();
    $costCollection = new CostCollection();
    $costObject = null;
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {      
        $mattress_id = $row['mattress_id'];
        $quantity = $row['quantity'];  
        $costObject = $costModel->retrieveCost($invoice_id, $mattress_id, $quantity);
        $costCollection->insert($costObject);
      }
    }
    return $costCollection;
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
    return 0-($num * 1.16);
  }
  
  
}
?>
