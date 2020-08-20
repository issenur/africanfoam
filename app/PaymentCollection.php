<?php
class PaymentCollection extends SplHeap{
  public $collection;
  
  // Constructor for a mattress object.
  function __construct(){
  }
	public function compare($payment1, $payment2){
   
   $int1 = $payment1->getDate();
   $int2 = $payment2->getDate();
    
    if($int1 > $int2){
      return  1;
    }elseif($int1 < $int2){
      return -1;
    }else{
      return  0;
    }
	}
}

?>

