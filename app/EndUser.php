<?php
abstract class EndUser {
  
  // Properties
  public $username;
  public $password;
  public $user;
  public $user_type;
  public $acitve;
  
  // Constructor for a end user object.
  function __construct( $username, $password, $user, $user_type, $active){
    $this->username   = $username;
    $this->password   = $password;
    $this->user       = $user;
    $this->user_type  = $user_type;
    $this->active     = $active;
  }
  
  // Setter for username name 
  function setUsername($username) {}

  // Getter for username name
  function getUsername() {}
  
  // Setter for password 
  function setPassword($password) {}
  
  // Getter for password
  function getPassword() {}
  
  // Setter for user object 
  function setUser($user) {}

  // Getter for user object
  function getUser() {}
  
  // Setter for active 
  function setActive($active) {}

  // Getter for active
  function getActive() {}
  
  // Setter for user type 
  function setUserType($user_type) {}

  // Getter for user type
  function getUserType() {}
}
?>