<?php


include_once("MattressModel.php");

if (isset($_POST['submit'])) {
    
    $type= $_POST['type'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $price= $_POST['price'];
    
    
    $errorEmpty = false;
    $errorType = false;
    $errorSize = false;
    $errorDescription = false;
    $errorPrice = false;
  
    if (empty($type)  ||  empty($price) || empty($price) || empty($size)){
        echo "<span class='text-danger'>Fill in all fields please</span>";
        $errorEmpty = true;
    }
    elseif ((strlen($size) < 4 ) ||(strlen($size) > 5 ) ){
      echo "<span class='text-danger'>Size format must be 00x0 or 00x00 </span>";
        $errorSize = true;
    }
    elseif (strlen($type) > 7 ){
      echo "<span class='text-danger'>Type must be at most 6 characters long</span>";
        $errorType = true;
    }
    elseif (strlen($description) < 3 ){
      echo "<span class='text-danger'>Description must be at least 3 characters long</span>";
        $errorDescription = true;
    }
    elseif ($price < 10){
      echo "<span class='text-danger'>Mattress price must be more than 10 shillings </span>";
      $errorPrice = true;
    }
    else {
        
        
        $mattressModel = MattressModel::getInstance();
        $mattressObject = new Mattress(0, $type, $description, $size, $price, 1);
        $result = $mattressModel->addMattress($mattressObject);
        if($result > 1){
            echo "<span class='text-success'>Mattress successfully added</span>";
        }else{
            echo "<span class='text-danger'>There was an error adding Mattress</span>";
        }
    }
}
else {
    echo "There was an error!";
}
?>

<script>
    $("#mattress_form_type, #mattress_form_size, #mattress_form_description,  #mattress_form_price").removeClass("is-invalid");
    var errorType = " <?php echo $errorType; ?>";
    var errorSize = " <?php echo $errorSize; ?>";
    var errorDescription = " <?php echo $errorDescription; ?>";
    var errorEmpty = " <?php echo $errorEmpty; ?>";
    var errorPrice = " <?php echo $errorPrice; ?>";
    if(errorEmpty == true){
        $("#mattress_form_type, #mattress_form_size, #mattress_form_description, #mattress_form_price").addClass("is-invalid");
    }
    if(errorType == true){
        $("#mattress_form_type").addClass("form-control is-invalid");
    }
    if(errorSize == true){
        $("#mattress_form_size").addClass("form-control is-invalid");
    }
    if(errorDescription == true){
        $("#mattress_form_description").addClass("form-control is-invalid");
    }
    if(errorPrice == true){
        $("#mattress_form_price").addClass("form-control is-invalid");
    }
    if((errorType == false) && (errorDescription == false) && (errorPrice == false) && (errorSize == false) &&(errorEmpty == false)){
      $("#mattress_form_type, #mattress_form_description, #mattress_form_size, #mattress_form_price").val("");
    }
</script>