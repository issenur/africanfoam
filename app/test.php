<?php
include("sales.php");
include("dbconnection.php");
class test {
 
  // Constructor for a sales object.
  function __construct(){
  
  }
  
  // Adds a sales object to database 
  function addSales($salesObj) {
    
    $connection = dbconnection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $first = $salesObj->getFirst();
    $last = $salesObj->getLast();
    $phone_number = (int)$salesObj->getPhoneNumber();
    
    $sql  = " INSERT INTO";
    $sql .= "   sales(first, last, phone_number, active)";
    $sql .= " VALUES('$first', '$last', '$phone_number', 1)";
 
    
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    
    if(!$result){
                return false;
            }else{
                return true;
            }
  }

  // Retrieves a sales object from the database
  function retrieveSales($sales_id) {
    
    $connection = dbconnection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " SELECT";
    $sql .= "   first,";
    $sql .= "   last,";
    $sql .= "   phone_number,";
    $sql .= "   active";
    $sql .= " FROM sales";
    $sql .= " WHERE sales_id=?";
    
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i", $sales_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$result) {
      trigger_error('Invalid query: ' . $conn->error);
    }else{
      $first = $row['first'];
      $last = $row['last'];
      $phone_number = $row['phone_number'];
      $active = $row['active'];
      
      $salesObj = new sales($sales_id, $first, $last, $phone_number, $active);
      return $salesObj;
    }
  }
}


?>