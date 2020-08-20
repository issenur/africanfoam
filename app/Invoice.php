<?php

class Invoice {
  // Properties
  public $invoice_id;
  public $costCollection;
  public $paymentCollection;
  public $sales;
  public $customer;
  public $date;
  
  // Constructor for a invoice object.
  function __construct($invoice_id, $costCollection, $paymentCollection, $sales,  $customer,  $date){
    $this->invoice_id = $invoice_id;
    $this->costCollection = $costCollection;
    $this->paymentCollection = $paymentCollection;
    $this->sales= $sales;
    $this->customer = $customer;
    $this->date = $date;
  }
  
  // Setter for invoice_id 
  function setInvoiceId($invoice_id) {
    $this->invoice_id = $invoice_id;
  }

  // Getter for invoice_id
  function getInvoiceId() {
    return $this->invoice_id;
  }
  
  // Setter for cost collection 
  function setCostCollection($costCollection) {
    $this->costCollection = $costCollection;
  }

  // Getter for cost collection
  function getCostCollection() {
    return $this->costCollection;
  }
  
  // Setter for payment collection 
  function setPaymentCollection($paymentCollection) {
    $this->paymentCollection = $paymentCollection;
  }

  // Getter for payment collection
  function getPaymentCollection() {
    return $this->paymentCollection;
  }
  
   // Setter for sales
  function setSales($sales) {
    $this->sales = $sales;
  }

  // Getter for sales
  function getSales() {
    return $this->sales;
  }
  
  // Setter for customer 
  function setCustomer($customer) {
    $this->customer = $customer;
  }

  // Getter for customer
  function getCustomer() {
    return $this->customer;
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