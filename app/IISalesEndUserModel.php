<?php

include_once("IISalesModel.php");
include_once("IISalesEndUser.php");
include_once("EndUserModel.php");


class IISalesEndUserModel extends EndUserModel {
  
  //Field for singleton object
  public static $instance = null;
 
  // Constructor for a sales object.
  function __construct(){
  
  }
  
  //Applying singleton pattern to Sales End User Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new IISalesEndUserModel();
      }
      return self::$instance;
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
    $sales_id = $user->getUserId();
    $user_type = $endUser->getUserType();
    
    
    $sql  = " INSERT INTO";
    $sql .= "   user(username, password, admin_id, customer_id, sales_ii_id, sales_id , user_type, active)";
    $sql .= " VALUES('$user_name', SHA1('$password'), NULL, NULL, '$sales_id', NULL, '$user_type' , 1)";
 
    $stmt=$conn->prepare($sql);
    $stmt->execute();
  
  }
  
  //Retrieve an end user object to database 
  function retrieveEndUser($sales_id) {
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
    $stmt->bind_param("i", $sales_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$result) {
      trigger_error('Invalid query: ' . $conn->error);
    }else{
      $username = $row['username'];
      $password = $row['password'];
      $sales_id = $row['sales_ii_id'];
      $salesModel = new IISalesModel();
      $salesObject = $salesModel->retrieveUser($user_id);
      $user_type = $row['user_type'];
      $active = $row['active'];
      
      $endUserObject = new IISalesEndUser($username, $password, $salesObject, $user_type, $active);
      return $endUserObject;
    }
  }
  
  //Validates enduser's credentials 
  function deactivateEndUser($username) {
    parent::deactivateEndUser($username);
  }
  
  //Invalidates enduser's credentials 
  function activateEndUser($username) {
    parent::activateEndUser($username);
  }
}
?>