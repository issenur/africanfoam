<?php

class Payment{
  // Properties
  public $amount;
  public $date;
  
  // Constructor for a amount object.
  function __construct($amount, $date){
    $this->amount = $amount;
    $this->date   = $date;
  }
  
  // Setter for amount 
  function setAmount($amount) {
    $this->amount = $amount;
  }

  // Getter for amount
  function getAmount() {
    return $this->amount;
  }
  // Setter for date
  function setDate($date) {
    $this->date = $date;
  }

  // Getter for date
  function getDate() {
    return $this->date;
  }
}
?>