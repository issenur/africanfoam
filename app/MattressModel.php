<?php

include_once("Mattress.php");
include_once("Connection.php");

class MattressModel {
  
  //Field for singleton object
  public static $instance = null;
  
  // Constructor for a mattress object.
  function __construct(){
  
  }
  
  //Applying singleton pattern to Mattress Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new MattressModel();
      }
      return self::$instance;
  }
  
  // Adds a mattress object to database 
  function addMattress($mattressObject) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $description = $mattressObject->getDescription();
    $size = $mattressObject->getSize();
    $type = $mattressObject->getType();
    $price = (int)$mattressObject->getPrice();
    
    $sql  = " INSERT INTO";
    $sql .= "   mattress(type , description, size, price, active)";
    $sql .= " VALUES('$type', '$description', '$size', '$price', 1)";
  
    $stmt=$conn->prepare($sql);
    
    if ($stmt->execute() === TRUE) {
      $mattress_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  
    return $mattress_id;
  }
  
 
  // Retrieves a mattress object from the database
  function retrieveMattress($mattress_id) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " SELECT";
    $sql .= "   description,";
    $sql .= "   size,";
    $sql .= "   type,";
    $sql .= "   price,";
    $sql .= "   active";
    $sql .= " FROM mattress";
    $sql .= " WHERE mattress_id=?";
    
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i", $mattress_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$result) {
      trigger_error('Invalid query: ' . $conn->error);
    }else{
      $description = $row['description'];
      $size = $row['size'];
      $type = $row['type'];
      $price = $row['price'];
      $active = $row['active'];
      
      $mattressObject = new Mattress($mattress_id, $description, $size, $type, $price, $active);
      return $mattressObject;
    }
  }
}
?>