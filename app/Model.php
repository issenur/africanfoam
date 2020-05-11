<?php
class Model {
  
  //Field for singleton object
  public static $instance = null;
  private $currentuserid = 0;
  
  // Constructor for a customer object.
  function __construct(){
        if($_SESSION['role'] == "Administrator"){
           $this->currentuserid = $_SESSION['admin_id'];
        } else if($_SESSION['role'] == "Customer"){
            $this->currentuserid = $_SESSION['customer_id'];
        } else if($_SESSION['role'] == "SalesII"){
            $this->currentuserid = $_SESSION['sales_ii_id'];
        } else if($_SESSION['role'] == "Sales"){
            $this->currentuserid = $_SESSION['sales_id'];
        } else{}
  }
  
  //Applying singleton pattern to Customer Model   
  public static function getInstance(){
      if (self::$instance == null){
        self::$instance = new Model();
      }
      return self::$instance;
  }
  
  //Setter for current user id
  public function setCurrentUserId($user_id) {
    $this->currentuserid = $user_id;   
  }
  
  //Getter for current user id
  public function getCurrentUserId() {
    return($this->currentuserid);
  }
}
?>