<?php
	$name = "Karubo";
	$dpold = 995;
	$dpgain = 105;
	$highestnumber = 0;
	$drawing = date("Y-m");
	$ticketstotal = 0;
	$dptotal = $dpold + $dpgain;
	$q = mysqli_query($link, "SELECT Number FROM LotteryNumbers WHERE Drawing LIKE '$drawing' ORDER BY Number ASC;");
	while($row = mysqli_fetch_array($q)){
		$highestnumber = $row['Number'];
	}
	echo "Highest Number: " . $highestnumber . "<br>";
	$q = mysqli_query($link, "SELECT COUNT(Number) AS Tickets FROM LotteryNumbers WHERE Drawing LIKE '$drawing' GROUP BY '$name';");
	while($row = mysqli_fetch_array($q)){
		$ticketstotal = $row['Tickets'];
	}
	echo "Tickets Total: " . $ticketstotal . "<br>";
	if($dptotal >= 1000){
		$tickets = floor($dptotal/100);
		$ticketsnew = $tickets - $ticketstotal;
		for($i = 1; $i <= $ticketsnew; $i++){
			$highestnumber = $highestnumber + 1;
			echo "Name: " . $name . " Number: " . $highestnumber . " Drawing: " . $drawing . "<br>";
			mysqli_query($link, "INSERT INTO `DB1008786`.`LotteryNumbers` (`Name`, `Number`, `Drawing`) VALUES ('$name', '$highestnumber', '$drawing');");
		}
	}
?>
