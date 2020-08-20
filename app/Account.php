<?php

class Account{
  // Properties
  public $customer_id;
  public $invoiceCollection;
  public $accountBalance;
  public $accountBalance1;
  public $accountBalance2;
  public $accountBalance3;
  public $accountBalance4;


  // Constructor for a customerInvoices object.
  function __construct($customer_id, $invoiceCollection, $accountBalance, $accountBalance1, $accountBalance2, $accountBalance3, $accountBalance4){
    $this->customer_id = $customer_id;
    $this->invoiceCollection = $invoiceCollection;
    $this->accountBalance = $accountBalance;
    $this->accountBalance1 = $accountBalance1;
    $this->accountBalance2 = $accountBalance2;
    $this->accountBalance3 = $accountBalance3;
    $this->accountBalance4 = $accountBalance4;
  }
  
  // Setter for customer id
  function setCustomerId($customer_id) {
    $this->customer_id = $customer_id;
  }

  // Getter for customer_id
  function getCustomerId() {
    return $this->customer_id;
  }
  
  // Setter for invoice collection 
  function setInvoiceCollection($invoiceCollection) {
    $this->invoiceCollection = $invoiceCollection;
  }

  // Getter for invoice collection
  function getInvoiceCollection() {
    return $this->invoiceCollection;
  }
  
   // Setter for account balance
  function setAccountBalance($accountBalance) {
    $this->accountBalance = $accountBalance;
  }

  // Getter for account balance
  function getAccountBalance() {
    return $this->accountBalance;
  }
  
  // Setter for account balance1
  function setAccountBalance1($accountBalance1) {
    $this->accountBalance1 = $accountBalance1;
  }

  // Getter for account balance1
  function getAccountBalance1() {
    return $this->accountBalance1;
  }
  
  // Setter for account balance2
  function setAccountBalance2($accountBalance2) {
    $this->accountBalance2 = $accountBalance2;
  }

  // Getter for account balance2
  function getAccountBalance2() {
    return $this->accountBalance2;
  }
  
  // Setter for account balance3
  function setAccountBalance3($accountBalance3) {
    $this->accountBalance3 = $accountBalance3;
  }

  // Getter for account balance3
  function getAccountBalance3() {
    return $this->accountBalance3;
  }
  
  // Setter for account balance4
  function setAccountBalanc4($accountBalance4) {
    $this->accountBalance4= $accountBalance4;
  }

  // Getter for account balance4
  function getAccountBalance4() {
    return $this->accountBalance4;
  }
  
}
?>