<?php
//last seven days unix timestamp
$seven_days = strtotime('-7 day');
$this_month = strtotime('first day of this month 00:00:00');

$q = mysqli_query($link, "SELECT SUM(Level) AS Level, SUM(XP) AS XP FROM Updates WHERE `Update` >= FROM_UNIXTIME($seven_days)");
while($row = mysqli_fetch_array($q)){
	$gainxp3 = $row["XP"] / 7;
	$gainlvl3 = $row["Level"] / 7;
}

echo "Average Gains Overall (last 7 days)<br><br>";
echo "XP contribution/day: " . number_format($gainxp3, 0, ".", ",") . "<br><br>";
echo "Member Lvl gain/day: <br>" . number_format($gainlvl3, 0, ".", ",") . "<br><br>";

/* $q = mysqli_query($link, "SELECT COUNT(Number) AS Pot FROM Weekly WHERE `Week` LIKE '$currentlottery';");
while($row = mysqli_fetch_array($q)){
	echo "Current Weekly Pot: " . $row["Pot"] . "p<br><br><br>";
}
 */
$numb = 1;
echo "Highest GDP this month<br>";
$q = "SELECT Userliste.Name, SUM(Updates.GDP) AS GDP FROM Updates LEFT JOIN Userliste ON Updates.Name = Userliste.Name WHERE Userliste.Active = 0 AND `Update` >= FROM_UNIXTIME($this_month) GROUP BY Userliste.Name ORDER BY GDP DESC LIMIT 10;";
//echo $q;
$q = mysqli_query($link, $q);
if (mysqli_num_rows($q) > 0) {
	echo "<ol>";
	while($row = mysqli_fetch_array($q)){
		echo "<li><a href='/?x=user&name=". htmlspecialchars($row["Name"]) ."'>". $row['Name'] . "</a> " . number_format($row["GDP"], 0, '.', ',') . "</li>";
		$numb = $numb +1;
	}
	echo "</ol>";
}