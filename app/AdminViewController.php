<?php
include_once("SalesEndUserModel.php");
include_once("IISalesEndUserModel.php");
include_once("CustomerEndUserModel.php");

 if(isset($_GET['delete_customer'])){
         $user_name = $_GET['delete_customer'];
         $customerEndUserModel = CustomerEndUserModel::getInstance();
         $customerEndUserModel->deactivateEndUser($user_name);
         header("location:AdminView.php");
    }
    
   if(isset($_GET['delete_sales_ii'])){
         $user_name = $_GET['delete_sales_ii'];
         $salesIIEndUserModel = IISalesEndUserModel::getInstance();
         $salesIIEndUserModel->deactivateEndUser($user_name);
         header("location:AdminView.php");
    }  
    
    if(isset($_GET['delete_sales'])){
         $user_name = $_GET['delete_sales'];
         $salesEndUserModel = SalesEndUserModel::getInstance();
         $salesEndUserModel->deactivateEndUser($user_name);
         header("location:AdminView.php");
    }
    
    if(isset($_GET['activate_customer'])){        
         $user_name = $_GET['activate_customer'];
         $customerEndUserModel = CustomerEndUserModel::getInstance();
         $customerEndUserModel->activateEndUser($user_name);
         header("location:AdminView.php");
    }
    
   if(isset($_GET['activate_sales_ii'])){
         $user_name = $_GET['activate_sales_ii'];
         $salesIIEndUserModel = IISalesEndUserModel::getInstance();
         $salesIIEndUserModel->activateEndUser($user_name);
         header("location:AdminView.php");
    }  
    
    if(isset($_GET['activate_sales'])){
         $user_name = $_GET['activate_sales'];
         $salesEndUserModel = SalesEndUserModel::getInstance();
         $salesEndUserModel->activateEndUser($user_name);
         header("location:AdminView.php");
    }  

?>