<?php

include_once("MattressModel.php");

    if(isset($_GET['delete_mattress'])){
         $mattress_id = $_GET['delete_mattress'];
         $mattressModel = MattressModel::getInstance();
         $mattressModel->deactivateMattress($mattress_id);
         header("location:AdminMattressView.php");
    }
 
    
    if(isset($_GET['activate_mattress'])){        
         $mattress_id = $_GET['activate_mattress'];
         $mattressModel = MattressModel::getInstance();
         $mattressModel->activateMattress($mattress_id);
         header("location:AdminMattressView.php");
    }
    
  

?>