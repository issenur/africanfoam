<?php
include_once("Account.php");
include_once("AccountModel.php");

$accountModel = AccountModel::getInstance();
$account = $accountModel->retrieveAccount(7012);

$invoiceCollection = $account->getInvoiceCollection();
$costModel = CostModel::getInstance();
$paymentModel = PaymentModel::getInstance();
while(!$invoiceCollection->isEmpty()){
  echo "------------------------------------------</br>";
  $invoice = $invoiceCollection->extract();
  
  $costCollection = $invoice->getCostCollection();
  $totalCost = $costModel->getTotalCost($costCollection);
  
  
  
  echo $totalCost . "<----Total Cost</br>";
  
  $paymentCollection = $invoice->getPaymentCollection();
  $totalPayment = $paymentModel->getTotalPayment($paymentCollection);
  
  
  
  echo $totalPayment . "<----Total Payment</br>";


  
  echo "</br>";
  
  $customer = $invoice->getCustomer();
  $shopName = $customer->getShopName();
  echo $shopName . " <---ShopName" . "</br>";

}
echo "------------------------------------------</br>";

$accountBalance = $account->getAccountBalance();
echo $accountBalance . " <---AccountBalance" . "</br>";

$accountBalance1 = $account->getAccountBalance1();
echo $accountBalance1 . " <---AccountBalance1" . "</br>";

$accountBalance2 = $account->getAccountBalance2();
echo $accountBalance2 . " <---AccountBalance2" . "</br>";

$accountBalance3 = $account->getAccountBalance3();
echo $accountBalance3 . " <---AccountBalance3" . "</br>";
  //$sql .= " DATE_FORMAT(`date`, '%d-%b-%Y') AS `date`,";
?>
