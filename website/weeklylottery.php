<?php
$drawing = $_POST['drawing'];
$user = $_POST['user'];
$currentweek = date("Y-W");
$totaltickets = 0;
if($drawing == ""){
	$drawing = $currentweek;
}
if($user == ""){
	$user = "-";
}
echo "<form action='index.php?x=weeklylottery' method='post'>";
echo "<table><tr><td align=center>Drawing:</td><td>";
echo "<select name='drawing'>";
$q = mysqli_query($link, "SELECT Week FROM Weekly GROUP BY Week ORDER BY Week;");
while($row = mysqli_fetch_array($q)){
	if($row['Week'] == $currentweek){
		echo "<option selected value='" . $row['Week'] . "'>" . $row['Week'] . " Current" . "</option>";
	}else{
		echo "<option value='" . $row['Week'] . "'>" . $row['Week'] . "</option>";
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
$q = mysqli_query($link, "SELECT * FROM WeeklyWinners WHERE Week LIKE '$drawing';");
while($row = mysqli_fetch_array($q)){
	echo "<tr><td>Winner</td><td>" . $row['Winner'] . "</td></tr>";
	echo "<tr><td>Winning Nr</td><td>" . $row['WinningNumber'] . "</td></tr>";
	echo "<tr><td colspan=2><br></tr>";
}
$q = mysqli_query($link, "SELECT Number FROM Weekly WHERE Week LIKE '$drawing' ORDER BY Number DESC LIMIT 1;");
while($row = mysqli_fetch_array($q)){
	echo "test";
	echo "<tr><td>Pot</td><td>" . $row["Number"] . "p</td></tr>";
}
echo "<tr><td>Name</td><td>Number</td>";
if($user != "-"){
	$q = mysqli_query($link, "SELECT * FROM Weekly WHERE Week LIKE '$drawing' AND Name LIKE '$user' ORDER By Number;");
	while($row = mysqli_fetch_array($q)){
		echo "<tr><td>" . $row['Name'] . "</td><td>" . $row['Number'] . "</td></tr>";
	}
	echo "</table>";
}elseif($user == "-"){
	$q = mysqli_query($link, "SELECT * FROM Weekly WHERE Week LIKE '$drawing' ORDER By Number;");
	while($row = mysqli_fetch_array($q)){
		echo "<tr><td>" . $row['Name'] . "</td><td>" . $row['Number'] . "</td></tr>";
		$totaltickets = $totaltickets +1;
	}
	echo "</table>";
}
echo "</td><td valign='top'>";
echo "</table></td></tr></table>";
?>
