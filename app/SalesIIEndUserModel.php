<?php

include_once("SalesIIModel.php");
include_once("SalesIIEndUser.php");
include_once("EndUserModel.php");


class SalesIIEndUserModel extends EndUserModel {
 
  // Constructor for a sales object.
  function __construct(){
  
  }
  
  // Adds a sales user object to database 
  function addEndUser($endUser) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $user_name = $endUser->getUsername();
    $password = $endUser->getPassword();
    $user= $endUser->getUser();
    $sales_ii_id = $user->getUserId();
    $user_type = $endUser->getUserType();
    
    
    $sql  = " INSERT INTO";
    $sql .= "   user(username, password, admin_id, customer_id, sales_ii_id, sales_id , user_type, active)";
    $sql .= " VALUES('$user_name', SHA1('$password'), NULL, NULL,'$sales_ii_id', NULL, '$user_type' , 1)";
 
    $stmt=$conn->prepare($sql);
    $stmt->execute();
  
  }
  
  //Retrieve an end user object to database 
  function retrieveEndUser($sales_ii_id) {
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " SELECT";
    $sql .= "   username,";
    $sql .= "   password,";
    $sql .= "   sales_ii_id,";
    $sql .= "   user_type,";
    $sql .= "   active";
    $sql .= " FROM user";
    $sql .= " WHERE sales_ii_id=?";
    
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i", $sales_ii_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$result) {
      trigger_error('Invalid query: ' . $conn->error);
    }else{
      $username = $row['username'];
      $password = $row['password'];
      $sales_ii_id = $row['sales_ii_id'];
      $salesModel = new SalesModel();
      $salesIIObject = $salesModel->retrieveUser($user_id);
      $user_type = $row['user_type'];
      $active = $row['active'];
      
      $endUserObject = new SalesEndUser($username, $password, $salesIIObject, $user_type, $active);
      return $endUserObject;
    }
  }
}
?>