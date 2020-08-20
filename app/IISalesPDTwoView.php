<?php
    include_once("Invoice.php");
    include_once("InvoiceModel.php");
    include_once("CustomerModel.php");
    include_once("CostModel.php");
    include_once("PaymentModel.php");
    include_once("Model.php");
    include_once("IISalesModel.php");
    
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['role'] != "IISales"){
        header("location:index.php");
    }

    if(isset($_GET['view_invoice'])){
        
        $items = urldecode($_GET['view_invoice']);
        $Mixed = json_decode($items);
        
        $invoice_id = $Mixed[0];
        $amount = $Mixed[1];
        $sales_id = $Mixed[2];
        $date = $Mixed[3];
        $connection = Connection::getInstance();
        $conn = $connection->getConn();
        $sql = "DELETE  FROM `payment_line` WHERE `invoice_id` = '$invoice_id' AND `amount` = '$amount' AND `sales_id` ='$sales_id' AND `date` = '$date'";
        if(!mysqli_query($conn, $sql)){
            header("Location: fail.php");
        }else{
            header("Location: IISalesPaymentDeleteView.php");
        }
    }
?>

</body>
</html>

