<?php
abstract class EndUserModel {
 
  // Constructor for a sales object.
  function __construct(){}
 
  // Adds an end user object to database 
  function addEndUser($endUser) {}
  
  // Retrieve an end user object from the database
  function retrieveEndUser($username) {}
}
?>