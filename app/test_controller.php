<?php

include_once("test.php");
include_once("sales.php");
if (isset($_POST['submit'])) {
    $username= $_POST['username'];
    $password= $_POST['password'];
    $user_type= $_POST['user_type'];
    $first= $_POST['first'];
    $last= $_POST['last'];
    $phone_number= $_POST['phone_number'];
    
    $errorEmpty = false;
    $errorUsername = false;
    $errorPassword = false;
    $errorUserType = false;
    $errorPhoneNumber = false;
    
    if (empty($username)  ||  empty($first) || empty($last) || empty($phone_number)){
        echo "<span class='text-danger'>FILL IN ALL FIELDS</span>";
        $errorEmpty = true;
    }
    elseif (strlen($username) < 6 ){
      echo "<span class='text-danger'>Username must be at least 6 characters long</span>";
        $errorUsername = true;
    }
    elseif (strlen($password) < 8 ){
      echo "<span class='text-danger'>Password must be at least 8 characters long</span>";
        $errorPassword = true;
    }
    elseif ($user_type == "SELECT USERTYPE"){
      echo "<span class='text-danger'>Incorrect usertype selected</span>";
        $errorUserType = true;
    }
    elseif (!($phone_number[0] == 0) || (!($phone_number[1] == 7) && !($phone_number[1] == 1))){
        echo "<span class='text-danger'>Incorrect format:Phone number must start with 07 or 01 </span>";
        $errorPhoneNumber = true;
    }
    elseif ((strlen($phone_number) > 10)){
      echo "<span class='text-danger'>Phone number must has too many digits</span>";
      $errorPhoneNumber = true;
    }
    elseif ((strlen($phone_number) < 10)){
      echo "<span class='text-danger'>Phone number must has too few digits</span>";
      $errorPhoneNumber = true;
    }
    else {
        $test = new test();
        $salesObj = new sales(-1, $first, $last, $phone_number, 0);
        $test->addSales($salesObj);
        echo "<span class='text-success'>Sales person successfully added</span>";    
    }
    
}
else {
    echo "There was an error!";
}
?>

<script>
    $("#sales_form_username, #sales_form_password, #sales_form_user_type, #sales_form_first, #sales_form_last, #sales_form_phone_number").removeClass("is-invalid");
    var errorUsername = " <?php echo $errorUsername; ?>";
    var errorPassword = " <?php echo $errorPassword; ?>";
    var errorUserType = " <?php echo $errorUserType; ?>";
    var errorEmpty = " <?php echo $errorEmpty; ?>";
    var errorPhoneNumber = " <?php echo $errorPhoneNumber; ?>";
    if(errorEmpty == true){
        $("#sales_form_username, #sales_form_password, #sales_form_user_type , #sales_form_first, #sales_form_last, #sales_form_phone_number ").addClass("is-invalid");
    }
    if(errorUsername == true){
       $("#sales_form_username").addClass("form-control is-invalid");
    }
    if(errorPassword == true){
       $("#sales_form_password").addClass("form-control is-invalid");
    }
    if(errorUserType == true){
       $("#sales_form_user_type").addClass("form-control is-invalid");
    }
    if(errorPhoneNumber == true){
       $("#sales_form_phone_number").addClass("form-control is-invalid");
    } 
    
</script>