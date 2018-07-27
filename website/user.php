<?php
$datum = date("r");
$datum = strtotime($datum);
$datum2 = strtotime('-7 day', $datum);
$datum2 = date("Y-m-d", $datum2);
$datum3 = strtotime('-14 day', $datum);
$datum3 = date("Y-m-d", $datum3);
$datum4 = strtotime('-30 day', $datum);
$datum4 = date("Y-m-d", $datum4);
$datum = date("Y-m-d", $datum);
$profileupdate = "";
$jadeupdate = "";
$tokenupdate = "";
update_profile($name);

$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Name LIKE '$name' LIMIT 1;");
while($row = mysqli_fetch_array($q)){
	$who = get_who($name);
	$seven = mysqli_query($link, "SELECT SUM(Level) AS Level, SUM(Quests) AS Quests, SUM(Kills) AS Kills, SUM(BaseStat) AS BaseStat, SUM(BuffStat) AS BuffStat, SUM(DP) AS DP, SUM(XP) AS XP, SUM(Money) AS Money, SUM(Jade) AS Jade, SUM(Gems) AS Gems, SUM(Food) AS Food, SUM(Iron) AS Iron, SUM(Stone) AS Stone, SUM(Lumber) AS Lumber, SUM(GDP) AS GDP, SUM(GDPSpent) AS GDPSpent, SUM(RPGained) AS RPGained FROM Updates WHERE Name LIKE '$name' AND `Update` >= '$datum2';");
	while($row2 = mysqli_fetch_array($seven)){
		$fourteen = mysqli_query($link, "SELECT SUM(Level) AS Level, SUM(Quests) AS Quests, SUM(Kills) AS Kills, SUM(BaseStat) AS BaseStat, SUM(BuffStat) AS BuffStat, SUM(DP) AS DP, SUM(XP) AS XP, SUM(Money) AS Money, SUM(Jade) AS Jade, SUM(Gems) AS Gems, SUM(Food) AS Food, SUM(Iron) AS Iron, SUM(Stone) AS Stone, SUM(Lumber) AS Lumber, SUM(GDP) AS GDP, SUM(GDPSpent) AS GDPSpent, SUM(RPGained) AS RPGained FROM Updates WHERE Name LIKE '$name' AND `Update` >= '$datum3';");
		while($row3 = mysqli_fetch_array($fourteen)){
			$thirty = mysqli_query($link, "SELECT SUM(Level) AS Level, SUM(Quests) AS Quests, SUM(Kills) AS Kills, SUM(BaseStat) AS BaseStat, SUM(BuffStat) AS BuffStat, SUM(DP) AS DP, SUM(XP) AS XP, SUM(Money) AS Money, SUM(Jade) AS Jade, SUM(Gems) AS Gems, SUM(Food) AS Food, SUM(Iron) AS Iron, SUM(Stone) AS Stone, SUM(Lumber) AS Lumber, SUM(GDP) AS GDP, SUM(GDPSpent) AS GDPSpent, SUM(RPGained) AS RPGained FROM Updates WHERE Name LIKE '$name' AND `Update` >= '$datum4';");
			while($row4 = mysqli_fetch_array($thirty)){
				$xp = $row["EXP"] + $row["PreviousXP"];
				$gdp = $row["GDP"] + $row["GDPPrevious"];
				$jadeupdate = $row["JadeUpdate"];
				$tokenupdate = $row["TokenUpdate"];
				echo "Last Profile Update: " . $row["ProfileUpdate"] . " Servertime<br>";
				echo $who .'<br>';
				echo "<table border=1 cellspacing=0>";
				echo "<tr><th>$name</th><th>Now</th><th>7 Days</th><th>14 Days</th><th>30 Days</th></tr>";
				echo "<tr><td>Level</td><td>" . number_format($row["Level"], 0, ".", ",") . "</td><td>" . number_format($row2["Level"], 0, ".", ",") . "</td><td>" . number_format($row3["Level"], 0, ".", ",") . "</td><td>" . number_format($row4["Level"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>Quests</td><td>" . number_format($row["Quests"], 0, ".", ",") . "</td><td>" . number_format($row2["Quests"], 0, ".", ",") . "</td><td>" . number_format($row3["Quests"], 0, ".", ",") . "</td><td>" . number_format($row4["Quests"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>Kills</td><td>" . number_format($row["Kills"], 0, ".", ",") . "</td><td>" . number_format($row2["Kills"], 0, ".", ",") . "</td><td>" . number_format($row3["Kills"], 0, ".", ",") . "</td><td>" . number_format($row4["Kills"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>BaseStat</td><td>" . number_format($row["BaseStat"], 0, ".", ",") . "</td><td>" . number_format($row2["BaseStat"], 0, ".", ",") . "</td><td>" . number_format($row3["BaseStat"], 0, ".", ",") . "</td><td>" . number_format($row4["BaseStat"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>BuffStat</td><td>" . number_format($row["BuffStat"], 0, ".", ",") . "</td><td colspan=3>&nbsp;</td></tr>";
				echo "<tr><td>Kills/Stat</td><td>". kills_per_stat($row['BaseStat'], $row['Kills']) .'</td><td>'. kills_per_stat($row2['BaseStat'], $row2['Kills']) .'</td><td>'. kills_per_stat($row3['BaseStat'], $row3['Kills']) .'</td><td>'. kills_per_stat($row4['BaseStat'], $row4['Kills']) .'</td></tr>';
				echo "<tr><td>Personal DP</td><td>" . number_format($row["DP"], 0, ".", ",") . "</td><td>" . number_format($row2["DP"], 0, ".", ",") . "</td><td>" . number_format($row3["DP"], 0, ".", ",") . "</td><td>" . number_format($row4["DP"], 0, ".", ",") . "</td></tr>";
				echo '<tr><th colspan=5>Guild Contributions</th></tr>';
				echo "<tr><td>XP</th><td>" . number_format($xp, 0, ".", ",") . "</td><td>" . number_format($row2["XP"], 0, ".", ",") . "</td><td>" . number_format($row3["XP"], 0, ".", ",") . "</td><td>" . number_format($row4["XP"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>Money</td><td>" . MoneyConvert($row["Money"]) . "</td><td>" . MoneyConvert($row2["Money"]) . "</td><td>" . MoneyConvert($row3["Money"]) . "</td><td>" . MoneyConvert($row4["Money"]) . "</td></tr>";
				echo "<tr><td>Jade</td><td>" . number_format($row["Jade"], 0, ".", ",") . "</td><td>" . number_format($row2["Jade"], 0, ".", ",") . "</td><td>" . number_format($row3["Jade"], 0, ".", ",") . "</td><td>" . number_format($row4["Jade"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>Gems</td><td>" . number_format($row["Gems"], 0, ".", ",") . "</td><td>" . number_format($row2["Gems"], 0, ".", ",") . "</td><td>" . number_format($row3["Gems"], 0, ".", ",") . "</td><td>" . number_format($row4["Gems"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>Food</td><td>" . number_format($row["Food"], 0, ".", ",") . "</td><td>" . number_format($row2["Food"], 0, ".", ",") . "</td><td>" . number_format($row3["Food"], 0, ".", ",") . "</td><td>" . number_format($row4["Food"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>Iron</td><td>" . number_format($row["Iron"], 0, ".", ",") . "</td><td>" . number_format($row2["Iron"], 0, ".", ",") . "</td><td>" . number_format($row3["Iron"], 0, ".", ",") . "</td><td>" . number_format($row4["Iron"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>Stone</td><td>" . number_format($row["Stone"], 0, ".", ",") . "</td><td>" . number_format($row2["Stone"], 0, ".", ",") . "</td><td>" . number_format($row3["Stone"], 0, ".", ",") . "</td><td>" . number_format($row4["Stone"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>Lumber</td><td>" . number_format($row["Lumber"], 0, ".", ",") . "</td><td>" . number_format($row2["Lumber"], 0, ".", ",") . "</td><td>" . number_format($row3["Lumber"], 0, ".", ",") . "</td><td>" . number_format($row4["Lumber"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>Guild DP</td><td>" . number_format($gdp, 0, ".", ",") . "</td><td>" . number_format($row2["GDP"], 0, ".", ",") . "</td><td>" . number_format($row3["GDP"], 0, ".", ",") . "</td><td>" . number_format($row4["GDP"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>GDP Spent</td><td>" . number_format($row['GDPSpent'], 0, ".", ",") . "</td><td>" . number_format($row2["GDPSpent"], 0, ".", ",") . "</td><td>" . number_format($row3["GDPSpent"], 0, ".", ",") . "</td><td>" . number_format($row4["GDPSpent"], 0, ".", ",") . "</td></tr>";
				echo "<tr><td>RP Gained</td><td>" . number_format($row['RP Gained'], 0, ".", ",") . "</td><td>" . number_format($row2["RPGained"], 0, ".", ",") . "</td><td>" . number_format($row3["RPGained"], 0, ".", ",") . "</td><td>" . number_format($row4["RPGained"], 0, ".", ",") . "</td></tr>";
			}
		}
	}
}

echo "</table><br>";
$q = mysqli_query($link, "SELECT * FROM Equip WHERE Name LIKE '$name';");
while($row = mysqli_fetch_array($q)){
	echo "Last Equip Update: " . $row['Updates'] . " Servertime<br>";
	echo "<table border='1' cellspacing=0><tr><th>W1</th><th>W2</th><th>A1</th><th>A2</th><th>A3</th><th>A4</th><th>A5</th><th>A6</th><th>A7</th></tr>";
	echo "<tr align='center'><td>" . $row['W1'] . "</td><td>" . $row['W2'] . "</td><td>" . $row['A1'] . "</td><td>" . $row['A2'] . "</td><td>" . $row['A3'] . "</td><td>" . $row['A4'] . "</td><td>" . $row['A5'] . "</td><td>" . $row['A6'] . "</td><td>" . $row['A7'] . "</td></tr>";
	echo "</table><br>";
}
$q = mysqli_query($link, "SELECT * FROM Boosts WHERE Name LIKE '$name';");
while($row = mysqli_fetch_array($q)){
	echo "Last Jade Skill Update: " . $jadeupdate . " Servertime<br>";
	echo "<table border='1' cellspacing=0><tr><th>C. Hit Chance</th><th>C. Hit Damage</th><th>Heroism</th><th>Leadership</th><th>Archeaology</th><th>Jewelcrafting</th><th>Serendipity</th><th>E-Peen</th></tr>";
	echo "<tr><td align='center'>" . $row["CHitC"] . "%</td><td align='center'>" . $row["CHitD"] . "%</td><td align='center'>" . $row["Hero"] . "%</td><td align='center'>" . $row["Leader"] . "%</td><td align='center'>" . $row["Arch"] . "%</td><td align='center'>" . $row["Craft"] . "%</td>
		<td align='center'>". number_format($row["Seren"], 2, '.', ',') ." lvl bonus</td><td align='center'>" . number_format($row["Peen"], 2, '.', ',') . " Inches</td></tr></table>";	
	echo "<br>Last Token Boost Update: " . $tokenupdate . " Servertime<br>";
	echo "<table border='1' cellspacing=0><tr><th>Gold Boost</th><th>XP Boost</th><th>Stat Boost</th><th>Quest Boost</th><th>Global Drop Boost</th><th>Health</th><th>Attack</th><th>Defence</th><th>Accuracy</th><th>Evasion</th><th>Jack of All Jade</th><th>Dungeon Mastery</th><th>Taxidermy</th><th>Autos</th><th>Jewelslots</th></tr>";
	echo "<tr><td align='center'>" . $row["Gold"] . "%</td><td align='center'>" . $row["XP"] . "%</td><td align='center'>" . $row["Stat"] . "%</td><td align='center'>" . $row["Quest"] . "%</td><td align='center'>" . $row["Global"] . "%</td><td align='center'>" . $row["Health"] . "%</td><td align='center'>" . $row["Attack"] . "%</td><td align='center'>" . $row["Def"] . "%</td><td align='center'>" . $row["Acc"] . "%</td><td align='center'>" . $row["Eva"] . "%</td><td align='center'>" . $row["Jade"] . "%</td><td align='center'>" . $row["Dungeon"] . "%</td><td align='center'>{$row["Taxidermy"]}%</td><td align='center'>" . $row["Auto"] . "</td><td align='center'>" . $row["Jewelry"] . "</td></tr>";
}
echo "</table>";

function kills_per_stat($base, $kills) {
	if (!$kills || !$base || $base == '0' || $kills == '0')
		return 0;
	
	$kps = (int) $kills / (int) $base;
	
	return number_format($kps, 2, '.', ',');
}