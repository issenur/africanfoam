<?php
include_once("MattressCollection.php");
class Cost{
  // Properties
  public $mattress;
  public $quantity;
  public $discount;
 
  
  // Constructor for a mattress object.
  function __construct($mattress, $quantity, $discount){
    $this->mattress = $mattress;
    $this->quantity   = $quantity;
    $this->discount   = $discount;
  }

  // Setter for mattress
  function setMattress($mattress) {
    $this->mattress = $mattress;
  }

  // Getter for mattress
  function getMattress() {
    return $this->mattress;
  }
  
  // Setter for quantity
  function setQuantity($quantity) {
    $this->quantity = $quantity;
  }

  // Getter for quantity
  function getQuantity() {
    return $this->quantity;
  }
  
   // Setter for discount
  function setDiscount($discount) {
    $this->discount = $discount;
  }

  // Getter for discount
  function getDiscount() {
    return $this->discount;
  }
}
?>