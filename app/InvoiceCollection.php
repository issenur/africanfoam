<?php
include_once("Invoice.php");
class InvoiceCollection extends SplHeap{

	public function compare($invoice1, $invoice2){
    $date1 = $invoice1->getDate();
    $date2 = $invoice2->getDate();
    $val = strnatcmp($date2, $date1);
		return $val;
	}
}

?>

