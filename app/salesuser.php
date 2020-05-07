<?php
class salesuser {
  // Properties
  public $username;
  public $password;
  public $sales;
  public $user_type;
  public $acitve;
  
  // Constructor for a user object.
  function __construct( $username, $password, $sales, $user_type, $active){
    $this->username   = $username;
    $this->password   = $password;
    $this->sales   = $sales;
    $this->user_type   = $user_type;
    $this->active   = $active;
  }
  
  // Setter for username name 
  function setUserName($username) {
    $this->username = $username;
  }

  // Getter for username name
  function getUserName() {
    return $this->username;
  }
  
  // Setter for password 
  function setPassword($password) {
    $this->password = $password;
  }
  
  // Getter for password
  function getPassword() {
    return $this->password;
  }
  // Setter for sales object 
  function setSales($sales) {
    $this->sales = $sales;
  }

  // Getter for sales object
  function getSales() {
    return $this->sales;
  }
  
  // Setter for active 
  function setActive($active) {
    $this->active = $active;
  }

  // Getter for active
  function getActive() {
    return $this->active;
  }
  
  // Setter for user type 
  function setUserType($user_type) {
    $this->user_type = $user_type;
  }

  // Getter for user type
  function getUserType() {
    return $this->user_type;
  }
}
?>