<?php
function MoneyConvert($money){
	$plat = 0;
	$gold = 0;
	$silver = 0;
	$copper = 0;
	
	$plat = floor($money/1000000);
	if($plat >= 1){
		$money = $money - ($plat*1000000);	
	}	
	$gold = floor($money/10000);
	if($gold >= 1){
		$money = $money - ($gold*10000);	
	}	
	$silver = floor($money/100);
	if($silver >= 1){
		$money = $money - ($silver*100);	
	}	
	$copper = $money;
	$moneystr = number_format($plat, 0, ".", ",") . "p " . $gold . "g " . $silver . "s " . $copper . "c";
	return $moneystr;
}
?>
