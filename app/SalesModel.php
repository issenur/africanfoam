<?php
include_once("UserModel.php");
include_once("Sales.php");
include_once("SalesEndUser.php");
include_once("Connection.php");
class SalesModel extends UserModel {
 
  // Constructor for a sales object.
  private function __construct() {
  
  }
  
  //Field for singleton object 
  public static $instance = null;
  
  //Applying singleton pattern to Sales Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new SalesModel();
      }
      return self::$instance;
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
    $sql .= "   sales(first, last, phone_number, active)";
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
    $sql .= " FROM sales";
    $sql .= " WHERE sales_id=?";
    
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
      
      $userObject = new Sales($user_id, $first, $last, $phone_number, $active);
      return $userObject;
    }
  }
}
?>