<?php
include_once("User.php");
class Customer extends User {
  // Properties
  public $user_id;
  public $shop_name;
  public $first;
  public $last;
  public $phone_number;
  public $acitve;
  
  // Constructor for a sales object.
  function __construct($user_id, $shop_name, $first, $last, $phone_number, $active){
    $this->user_id = $user_id;
    $this->shop_name = $shop_name;
    $this->first   = $first;
    $this->last   = $last;
    $this->phone_number   = $phone_number;
    $this->active   = $active;
  }
  
  // Setter for user_id 
  function setUserId($user_id) {
    $this->user_id = $user_id;
  }

  // Getter for user_id
  function getUserId() {
    return $this->user_id;
  }
  
  // Setter for shopname 
  function setShopName($shop_name) {
    $this->shop_name = $shop_name;
  }

  // Getter for shopname
  function getShopName() {
    return $this->shop_name;
  }
  // Setter for first name 
  function setFirst($first) {
    $this->first = $first;
  }

  // Getter for first name
  function getFirst() {
    return $this->first;
  }
  
  // Setter for last name 
  function setLast($last) {
    $this->last = $last;
  }

  // Getter for last name
  function getLast() {
    return $this->last;
  }
  
  // Setter for active name 
  function setActive($active) {
    $this->active = $active;
  }

  // Getter for last name
  function getActive() {
    return $this->active;
  }
  
  // Setter for phone number 
  function setPhoneNumber($phone_number) {
    $this->phone_number = $phone_number;
  }

  // Getter for phone number
  function getPhoneNumber() {
    return $this->phone_number;
  }
}
?>