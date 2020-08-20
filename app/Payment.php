<?php

class Payment{
  // Properties
  public $amount;
  public $date;
  public $sales;
  
  // Constructor for a amount object.
  function __construct($amount, $sales, $date){
    $this->amount = $amount;
    $this->date   = $date;
    $this->sales = $sales;
  }
  
  // Setter for amount 
  function setAmount($amount) {
    $this->amount = $amount;
  }

  // Getter for amount
  function getAmount() {
    return $this->amount;
  }
  
  // Setter for sales
  function setSales($sales) {
    $this->sales = $sales;
  }
  
  // Getter for sales
  function getSales() {
    return $this->sales;
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