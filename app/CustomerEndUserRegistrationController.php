<?php

include_once("CustomerEndUserModel.php");
include_once("Customer.php");

if (isset($_POST['submit'])) {
    
    $username= $_POST['username'];
    $password= $_POST['password'];
    $shop_name = $_POST['shop_name'];
    $user_type = "Customer";
    $first= $_POST['first'];
    $last= $_POST['last'];
    $phone_number= $_POST['phone_number'];
    
    $errorEmpty = false;
    $errorUsername = false;
    $errorShopname = false;
    $errorPassword = false;
    $errorPhoneNumber = false;
  
    if (empty($username)  ||  empty($first) || empty($last) || empty($phone_number) || empty($shop_name)){
        echo "<span class='text-danger'>Fill in all fields please</span>";
        $errorEmpty = true;
    }
    elseif (strlen($shop_name) < 2 ){
      echo "<span class='text-danger'>Shopname must be at least 2 characters long</span>";
        $errorShopname = true;
    }
    elseif (strlen($username) < 6 ){
      echo "<span class='text-danger'>Username must be at least 6 characters long</span>";
        $errorUsername = true;
    }
    elseif (strlen($password) < 8 ){
      echo "<span class='text-danger'>Password must be at least 8 characters long</span>";
        $errorPassword = true;
    }
    elseif (!($phone_number[0] == 2) || !($phone_number[1] == 5)){
        echo "<span class='text-danger'>Phone number must start with 254 | 252 | 251 </span>";
        $errorPhoneNumber = true;
    }
    elseif ((strlen($phone_number) > 12)){
      echo "<span class='text-danger'>Phone number must has too many digits</span>";
      $errorPhoneNumber = true;
    }
    elseif ((strlen($phone_number) < 12)){
      echo "<span class='text-danger'>Phone number must has too few digits</span>";
      $errorPhoneNumber = true;
    }
    else {
        $customerEndUserModel = new CustomerEndUserModel();
        $customerModel = new CustomerModel();
        
        $tempCustomerObject = new Customer(-1, $shop_name, $first, $last, $phone_number, 0);
        $customer_id = $customerModel->addUser($tempCustomerObject);
        $customerObject = $customerModel->retrieveUser($customer_id);
   
        $customerEndUserObject = new CustomerEndUser($username, $password, $customerObject, $user_type, 1);
        $customerEndUserModel->addEndUser($customerEndUserObject);
        echo "<span class='text-success'>Customer person successfully added</span>";    
    }
}
else {
    echo "There was an error!";
}
?>

<script>
    $("#sales_form_username, #sales_form_shop_name, #sales_form_password,  #sales_form_first, #sales_form_last, #sales_form_phone_number").removeClass("is-invalid");
    var errorUsername = " <?php echo $errorUsername; ?>";
    var errorShopname = " <?php echo $errorShopname; ?>";
    var errorPassword = " <?php echo $errorPassword; ?>";
    var errorEmpty = " <?php echo $errorEmpty; ?>";
    var errorPhoneNumber = " <?php echo $errorPhoneNumber; ?>";
    if(errorEmpty == true){
        $("#sales_form_username, #sales_form_shop_name, #sales_form_password, #sales_form_first, #sales_form_last, #sales_form_phone_number").addClass("is-invalid");
    }
    if(errorUsername == true){
        $("#sales_form_username").addClass("form-control is-invalid");
    }
    if(errorShopname == true){
        $("#sales_form_shop_name").addClass("form-control is-invalid");
    }
    if(errorPassword == true){
        $("#sales_form_password").addClass("form-control is-invalid");
    }
    if(errorPhoneNumber == true){
        $("#sales_form_phone_number").addClass("form-control is-invalid");
    }
    if((errorUsername == false) && (errorPassword == false) && (errorPhoneNumber == false) &&(errorEmpty == false)){
      $("#sales_form_username, #sales_form_password, #sales_form_first, #sales_form_last, #sales_form_phone_number").val("");
    }
</script>