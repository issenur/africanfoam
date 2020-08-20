<?php
include_once("Account.php");
class AccountCollection extends SplHeap{

	public function compare($account1, $account2){
    $a1 = $account1->getAccountBalance();
    $a2 = $account2->getAccountBalance();
    
    $val = strnatcmp($a2, $a1);

    return $val;
    
	}
}

?>

