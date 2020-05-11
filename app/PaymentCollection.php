<?php
class MattressCollection extends SplHeap{

	public function compare($payment1, $payment2){
    $date1 = $payment1->getDate();
    $date2 = $payment2->getDate();
    
    if($date1 > $date2){
      return  1;
    }elseif($date1 < $date2){
      return -1;
    }else{
      return  0;
    }
	}
}

?>

