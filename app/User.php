<?php
abstract class User {
  
  // Properties
  public $user_id;
  public $first;
  public $last;
  public $phone_number;
  public $acitve;
  
  // Constructor for a user object.
  function __construct($user_id, $first, $last, $phone_number, $active){
    $this->user_id = $user_id;
    $this->first = $first;
    $this->last = $last;
    $this->phone_number = $phone_number;
    $this->active = $active;
  }
  
  // Setter for user_id 
  function setUserId($user_id) {}

  // Getter for user_id
  function getUserId() {}
  
  // Setter for first name 
  function setFirst($first) {}

  // Getter for first name
  function getFirst() {}
  
  // Setter for last name 
  function setLast($last) {}

  // Getter for last name
  function getLast() {}
  
  // Setter for active name 
  function setActive($active) {}

  // Getter for last name
  function getActive() {}
  
  // Setter for phone number 
  function setPhoneNumber($phone_number) {}

  // Getter for phone number
  function getPhoneNumber() {}
  
}
?>