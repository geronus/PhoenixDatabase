<?php
include("connection.php");
echo "<table><tr><td>Rank</td><td>Name</td><td>Guild DP</td></tr>";
$i = 1;
$q = mysqli_query($link, "SELECT Name, GDP FROM Userliste ORDER BY GDP DESC;");
while($row = mysqli_fetch_array($q)){
	if($row["GDP"] != 0){
		echo "<tr><td>" . $i . ".</td><td>" . $row["Name"] . "</td><td>" . number_format($row["GDP"], 0, ".", ",") . "</td></tr>";
		$i = $i + 1;
	}
}
echo "</table>";
?>
