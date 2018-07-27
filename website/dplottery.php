<?php
$drawing = $_POST['drawing'];
$user = $_POST['user'];
$currentmonth = date("Y-m");
$totaltickets = 0;
if($drawing == ""){
	$drawing = $currentmonth;
}
if($user == ""){
	$user = "-";
}
echo "<form action='index.php?x=dplottery' method='post'>";
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
echo "</select></td><td>Member:</td><td>";
echo "<select name='user'>";
echo "<option selected value='-'>All</option>";
$q = mysqli_query($link, "SELECT Name FROM Userliste ORDER BY Name;");
while($row = mysqli_fetch_array($q)){
	echo "<option value='" . $row['Name'] . "'>" . $row['Name'] . "</option>";
}
echo "</select></td><td><input type='submit' value='Show Numbers'></form></tr></table>";
echo "<table><tr><td valign='top'>";
echo "<table border=1><tr><td colspan=2>Shown Drawing: " . $drawing . "</td></tr>";
$q = mysqli_query($link, "SELECT * FROM LotteryDrawings WHERE Drawing LIKE '$drawing';");
while($row = mysqli_fetch_array($q)){
	echo "<tr><td>Winner</td><td>" . $row['Winner'] . "</td></tr>";
	echo "<tr><td>Winning Nr</td><td>" . $row['WinningNumber'] . "</td></tr>";
	echo "<tr><td>Second Place</td><td>" . $row['Winner2'] . "</td></tr>";
	echo "<tr><td>Second Number</td><td>" . $row['WinningNumber2'] . "</td></tr>";
	echo "<tr><td colspan=2><br></tr></td>";
}
echo "<tr><td>Name</td><td>Number</td>";
if($user != "-"){
	$q = mysqli_query($link, "SELECT * FROM LotteryNumbers WHERE Drawing LIKE '$drawing' AND Name LIKE '$user' ORDER By Number;");
	while($row = mysqli_fetch_array($q)){
		echo "<tr><td>" . $row['Name'] . "</td><td>" . $row['Number'] . "</td></tr>";
	}
	echo "</table>";
}elseif($user == "-"){
	$q = mysqli_query($link, "SELECT * FROM LotteryNumbers WHERE Drawing LIKE '$drawing' ORDER By Number;");
	while($row = mysqli_fetch_array($q)){
		echo "<tr><td>" . $row['Name'] . "</td><td>" . $row['Number'] . "</td></tr>";
		$totaltickets = $totaltickets +1;
	}
	echo "</table>";
}
echo "</td><td valign='top'>";

$first = date("Y-m-01", strtotime($drawing));
$last = date("Y-m-t", strtotime($drawing));
echo "<table border=1><tr><td colspan='2'>Gained Guild DP this Drawing</td><tr>";
echo "<tr><td>Tickets</td><td>" . $totaltickets . "</td></tr>";
echo "<tr><td>Name</td><td>DP</td>";
$q = mysqli_query($link, "SELECT Name, SUM(GDP) AS GDP FROM Updates WHERE `Update` >= '$first' AND `Update` <= '$last' GROUP BY Name ORDER BY Name;");
while($row = mysqli_fetch_array($q)){
	if($row['GDP'] >= 1000){
		echo "<tr><td><font color='green'>" . $row['Name'] . "</td><td><font color='green'>" . $row['GDP'] . "</td></tr>";
	}else{
		if(($row['Name'] != "") && ($row['Name'] != "-")){
			echo "<tr><td><font color='red'>" . $row['Name'] . "</td><td><font color='red'>" . $row['GDP'] . "</td></tr>";
		}
	}
}
echo "</table></td></tr></table>";
?>
