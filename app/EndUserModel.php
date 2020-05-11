<?php
include_once("Connection.php");
abstract class EndUserModel {
 
  // Constructor for a sales object.
  function __construct(){}
 
  // Adds an end user object to database 
  function addEndUser($endUser) {}
  
  // Retrieve an end user object from the database
  function retrieveEndUser($username) {}
  
  
  //Validates enduser's credentials 
  function activateEndUser($username) {
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " UPDATE";
    $sql .= "   user";
    $sql .= " SET active = 1";
    $sql .= " WHERE username = '$username'";
 
    $stmt=$conn->prepare($sql);
    $stmt->execute();
   
  }
  
  //Invalidates enduser's credentials 
  function deactivateEndUser($user_name) {
    $connection = Connection::getInstance();
    $conn = $connection->getConn();
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql  = " UPDATE";
    $sql .= "   user";
    $sql .= " SET active = 0";
    $sql .= " WHERE username = '$user_name'";
 
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    
  }
}
?>