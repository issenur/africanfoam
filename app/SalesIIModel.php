<?php
include_once("UserModel.php");
include("SalesII.php");
include("SalesIIEndUser.php");
include("Connection.php");
class SalesIIModel extends UserModel {
 
  // Constructor for a sales object.
  function __construct(){
  
  }
  
  // Adds a sales object to database 
  function addUser($userObject) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $first = $userObject->getFirst();
    $last = $userObject->getLast();
    $phone_number = (int)$userObject->getPhoneNumber();
    
    $sql  = " INSERT INTO";
    $sql .= "   sales_ii(first, last, phone_number, active)";
    $sql .= " VALUES('$first', '$last', '$phone_number', 1)";
  
    $stmt=$conn->prepare($sql);
    
    if ($stmt->execute() === TRUE) {
      $user_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  
    return $user_id;
  }
  
 
  // Retrieves a sales object from the database
  function retrieveUser($user_id) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " SELECT";
    $sql .= "   first,";
    $sql .= "   last,";
    $sql .= "   phone_number,";
    $sql .= "   active";
    $sql .= " FROM sales_ii";
    $sql .= " WHERE sales_ii_id=?";
    
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
      $phone_number = $row['phone_number'];
      $active = $row['active'];
      
      $userObject = new SalesII($user_id, $first, $last, $phone_number, $active);
      return $userObject;
    }
  }
}
?>