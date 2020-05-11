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
$mattressCollection = new MattressCollection();
$mattressCollection->insert(new Mattress('bz','bz','bz','bz','bz'));
$mattressCollection->insert(new Mattress('ab','ab','ab','ab','ab'));
$mattressCollection->insert(new Mattress('by','by','by','by','by'));
$mattressCollection->insert(new Mattress('aa','aa','aa','aa','aa'));
$mattressCollection->insert(new Mattress('ac','ac','ac','ac','ac'));

$extracted = $mattressCollection->extract();
$desc = $extracted->getDescription();
echo $desc . "<br>";
$extracted = $mattressCollection->extract();
$desc = $extracted->getDescription();
echo $desc . "<br>";
$extracted = $mattressCollection->extract();
$desc = $extracted->getDescription();
echo $desc . "<br>";
$extracted = $mattressCollection->extract();
$desc = $extracted->getDescription();
echo $desc . "<br>";
$extracted = $mattressCollection->extract();
$desc = $extracted->getDescription();
echo $desc . "<br>";
?>

