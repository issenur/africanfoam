<?php
class dbconnection {
  private $conn;
  public static $instance = null;
  
  private function __construct() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "afoam";
    $this->conn = new mysqli($servername, $username, $password, $dbname);
  }
  
  public static function getInstance(){
    if (self::$instance == null){
      self::$instance = new dbconnection();
    }
    return self::$instance;
  }
  
  // Getter for connection object
  function getConn() {
    return $this->conn;
  }
}
?>
