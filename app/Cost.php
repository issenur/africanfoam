<?php
include_once("MattressCollection.php");
class Cost{
  // Properties
  public $mattressCollection;
  public $quantity;
  public $discount;
 
  
  // Constructor for a mattressCollection object.
  function __construct($mattressCollection, $quantity, $discount){
    $this->mattressCollection = $mattressCollection;
    $this->quantity   = $quantity;
    $this->discount   = $discount;
  }
  
 
  // Setter for mattressCollection 
  function setMattressCollection($mattressCollection) {
    $this->mattressCollection = $mattressCollection;
  }

  // Getter for mattressCollection
  function getMattressCollection() {
    return $this->mattressCollection;
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