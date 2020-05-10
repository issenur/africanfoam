<?php

include_once("CustomerModel.php");
include_once("CustomerEndUser.php");
include_once("EndUserModel.php");


class CustomerEndUserModel extends EndUserModel {
 
  // Constructor for a customer object.
  function __construct(){
  
  }
  
  // Adds a customer user object to database 
  function addEndUser($endUser) {
    
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $user_name = $endUser->getUsername();
    $password = $endUser->getPassword();
    $user= $endUser->getUser();
    $customer_id = $user->getUserId();
    $user_type = $endUser->getUserType();
    
    
    $sql  = " INSERT INTO";
    $sql .= "   user(username, password, admin_id, customer_id, sales_ii_id, sales_id , user_type, active)";
    $sql .= " VALUES('$user_name', SHA1('$password'), NULL, '$customer_id', NULL, NULL, '$user_type' , 1)";
 
    $stmt=$conn->prepare($sql);
    $stmt->execute();
  
  }
  
  //Retrieve an end user object to database 
  function retrieveEndUser($customer_id) {
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " SELECT";
    $sql .= "   username,";
    $sql .= "   password,";
    $sql .= "   customer_id,";
    $sql .= "   user_type,";
    $sql .= "   active";
    $sql .= " FROM user";
    $sql .= " WHERE customer_id=?";
    
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$result) {
      trigger_error('Invalid query: ' . $conn->error);
    }else{
      $username = $row['username'];
      $password = $row['password'];
      $customer_id = $row['customer_id'];
      $customerModel = new CustomerModel();
      $customerObject = $customerModel->retrieveUser($user_id);
      $user_type = $row['user_type'];
      $active = $row['active'];
      
      $endUserObject = new CustomerEndUser($username, $password, $customerObject, $user_type, $active);
      return $endUserObject;
    }
  }
}
?>