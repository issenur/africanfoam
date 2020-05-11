<?php
include_once("Mattress.php");
class MattressCollection extends SplHeap{

	public function compare($mattress1, $mattress2){
    $name1 = $mattress1->getDescription();
    $name2 = $mattress2->getDescription();
    $val = strnatcmp($name2, $name1);
		return $val;
	}
}

?>

