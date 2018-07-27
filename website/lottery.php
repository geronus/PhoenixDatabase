<?php
function Lottery($name){
	$highestnumber = 0;
	$drawing = date("Y-m");
	$date = date("Y-m-d");
	$first = date("Y-m-01", strtotime($date));
	$last = date("Y-m-t", strtotime($date));
	$ticketstotal = 0;
	$dptotal = 0;
	
	$q = mysqli_query($link, "SELECT Number FROM LotteryNumbers WHERE Drawing LIKE '$drawing' ORDER BY Number DESC LIMIT 1;");
	while($row = mysqli_fetch_array($q)){
		$highestnumber = $row['Number'];
	}
	
	$q = mysqli_query($link, "SELECT COUNT(Number) AS Tickets FROM LotteryNumbers WHERE Drawing LIKE '$drawing' AND Name LIKE '$name' GROUP BY '$name';");
	while($row = mysqli_fetch_array($q)){
		$ticketstotal = $row['Tickets'];
	}
	
	$q = mysqli_query($link, "SELECT SUM(GDP) AS GDP FROM Updates WHERE `Update` >= '$first' AND `Update` <= '$last' AND Name LIKE '$name';");
	while($row = mysqli_fetch_array($q)){
		$dptotal = $row['GDP'];
	}
	
	if($dptotal >= 1000){
		$tickets = floor($dptotal/100);
		$ticketsnew = $tickets - $ticketstotal;
		for($i = 1; $i <= $ticketsnew; $i++){
			$highestnumber = $highestnumber + 1;
			mysqli_query($link, "INSERT INTO LotteryNumbers (`Name`, `Number`, `Drawing`) VALUES ('$name', '$highestnumber', '$drawing');");
		}
	}
	
	return "OK";
}
?>
