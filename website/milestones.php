<?php
function Milestones($name){
	$month = date("Y-m");
	$date = date("Y-m-d");
	$first = date("Y-m-01", strtotime($date));
	$last = date("Y-m-t", strtotime($date));
	$dptotal = 0;
	
	$q = mysqli_query($link, "SELECT SUM(GDP) AS GDP FROM Updates WHERE `Update` >= '$first' AND `Update` <= '$last' AND Name LIKE '$name';");
	while($row = mysqli_fetch_array($q)){
		$dptotal = $row['GDP'];
	}
	$milestones = array(1000, 2500, 5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000, 55000, 60000, 65000,70000, 75000, 80000, 90000, 95000, 100000, 105000, 110000, 115000, 120000, 125000, 130000, 135000, 140000, 145000, 150000, 155000, 160000, 165000, 170000, 175000, 180000, 185000, 190000, 195000, 200000, 205000, 210000, 215000, 220000, 225000, 230000, 235000, 240000, 245000, 250000);
	for($i = 0; $i < count($milestones); $i++){
		if($dptotal >= $milestones[$i]){
			$achieve = $milestones[$i];
			mysqli_query($link, "INSERT INTO DPMilestones (`Month`, `Name`, `Achievement`, `Paid`) VALUES ('$month', '$name', '$achieve', '0');");
		}
	}
	return "OK";
}
?>
