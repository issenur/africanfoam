<?php
include_once("EndUser.php");
class CustomerEndUser extends EndUser {
  
  // Properties
  public $username;
  public $password;
  public $user;
  public $user_type;
  public $acitve;
  
  // Constructor for a user object.
  function __construct( $username, $password, $user, $user_type, $active){
    $this->username   = $username;
    $this->password   = $password;
    $this->user       = $user;
    $this->user_type  = $user_type;
    $this->active     = $active;
  }
  
  // Setter for username name 
  function setUsername($username) {
    $this->username = $username;
  }

  // Getter for username name
  function getUsername() {
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
  // Setter for user object 
  function setUser($user) {
    $this->user = $user;
  }

  // Getter for user object
  function getUser() {
    return $this->user;
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