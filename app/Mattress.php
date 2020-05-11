<?php

class Mattress{
  // Properties
  public $type;
  public $description;
  public $size;
  public $price;
  public $acitve;
  
  // Constructor for a mattress object.
  function __construct($type, $description, $size, $price, $active){
    $this->type = $type;
    $this->description   = $description;
    $this->size   = $size;
    $this->price   = $price;
    $this->active   = $active;
  }
  
 
  // Setter for type 
  function setType($type) {
    $this->type = $type;
  }

  // Getter for type
  function getType() {
    return $this->type;
  }
  // Setter for description
  function setDescription($description) {
    $this->description = $description;
  }

  // Getter for description
  function getDescription() {
    return $this->description;
  }
  
  // Setter for size 
  function setSize($size) {
    $this->size = $size;
  }

  // Getter for size
  function getSize() {
    return $this->size;
  }
  
  // Setter for price 
  function setPrice($price) {
    $this->price = $price;
  }

  // Getter for price
  function getPrice() {
    return $this->price;
  }
  
  // Setter for active
  function setActive($active) {
    $this->active = $active;
  }

  // Getter for active
  function getActive() {
    return $this->active;
  }
}
?>