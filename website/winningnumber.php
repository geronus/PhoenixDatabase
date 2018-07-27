<?php
$currentmonth = date("Y-m");
$drawing = $_POST['drawing'];
$winnernr = $_POST['winnernr1'];
$winnernr2 = $_POST['winnernr2'];
$winner = "";
echo "<form action='admin.php?x=winningnumber' method='post'>";
echo "<table><tr><td align=center>Drawing:</td><td>";
echo "<select name='drawing'>";
$q = mysqli_query($link, "SELECT Drawing FROM LotteryNumbers GROUP BY Drawing ORDER BY Drawing;");
while($row = mysqli_fetch_array($q)){
	if($row['Drawing'] == $currentmonth){
		echo "<option selected value='" . $row['Drawing'] . "'>" . $row['Drawing'] . "</option>";
	}else{
		echo "<option value='" . $row['Drawing'] . "'>" . $row['Drawing'] . "</option>";
	}
}
echo "</select></td></tr><tr><td>First Place Number:</td><td>";
echo "<input type='text' size='5' name='winnernr1'>";
echo "</td></tr><tr><td>Second Place Number:</td><td>";
echo "<input type='text' size='5' name='winnernr2'>";
echo "</td></tr><tr><td><input type='submit' value='Show Winner'></form></tr></table>";
if($winnernr != ""){
	$q = mysqli_query($link, "SELECT * FROM LotteryNumbers WHERE Number LIKE '$winnernr' AND Drawing LIKE '$drawing';");
	while($row = mysqli_fetch_array($q)){
		$winner = $row['Name'];
		mysqli_query($link, "INSERT INTO `LotteryDrawings` (`Drawing`, `Winner`, `WinningNumber`, `Winner2`, `WinningNumber2`) VALUES ('$drawing', '$winner', '$winnernr', '', '0');");
		echo "The first place goes to " . $winner . "!<br>";
	}
	$q = mysqli_query($link, "SELECT * FROM LotteryNumbers WHERE Number LIKE '$winnernr2' AND Drawing LIKE '$drawing';");
	while($row = mysqli_fetch_array($q)){
		$winner = $row['Name'];
		mysqli_query($link, "UPDATE `LotteryDrawings` SET Winner2 = '$winner', WinningNumber2 = '$winnernr2' WHERE Drawing LIKE '$drawing';");
		echo "The second place goes to " . $winner . "!";
	}
}
?>
