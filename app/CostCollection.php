<?php
include_once("Mattress.php");
class CostCollection extends SplHeap{

	public function compare($cost1, $cost2){
    $quantity1 = $cost1->getQuantity();
    $quantity2 = $cost2->getQuantity();
    $result = strnatcmp($quantity1, $quantity2);
		return $result;
	}
}

?>

