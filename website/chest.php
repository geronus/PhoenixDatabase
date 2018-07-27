<?php
if($_POST["name"] != ""){
	$chest = $_POST["count"];
	$name = $_POST["name"];
	$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Name LIKE '$name' LIMIT 1;");
	while($row = mysqli_fetch_array($q)){
		$chestold = $row["Chest"];
		$chests = $chestold + $chest;
		mysqli_query($link, "UPDATE Userliste SET Chest = '$chests' WHERE Name LIKE '$name';");
		echo "" . $chest . " chest(s) added to " . $name;	date_default_timezone_set("Europe/London");
		$datum = date("Y-m-d");
		mysqli_query($link, "INSERT INTO Updates (`Name`, `Level`, `Quests`, `Kills`, `BaseStat`, `BuffStat`, `DP`, `XP`, `Money`, `Jade`, `Gems`, `Food`, `Iron`, `Stone`, `Lumber`, `GDP`, `Chest`, `Update`) VALUES ('$name', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$chest', '$datum');");
	}
}
/*if($_POST["name"] != ""){
	$chest = $_POST["count"];
	$name = $_POST["name"];
	$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Name LIKE '$name' LIMIT 1;");
	while($row = mysqli_fetch_array($q)){
		$chestold = $row["Chest"];
		$chest = $chestold + $chest;
		mysqli_query($link, "UPDATE Userliste SET Chest = '$chest' WHERE Name LIKE '$name';");
		echo "" . $chest " chest(s) added to " . $name . ".";
		date_default_timezone_set("Europe/London");
		$datum = date("Y-m-d");
		mysqli_query($link, "INSERT INTO `Updates` (`Name`, `Level`, `Quests`, `Kills`, `BaseStat`, `BuffStat`, `DP`, `XP`, `Money`, `Jade`, `Gems`, `Food`, `Iron`, `Stone`, `Lumber`, `GDP`, `Chest`, `Update`) VALUES ('$name', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$datum');");
	}
}*/
echo "<table witdth=100%><tr><td><form action='admin.php?x=chest' method='post'>";
echo "Member: <select name='name'>";
echo "<option selected value=''>-</option>";
$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Level > '0' AND Active = '0';");
while($row = mysqli_fetch_array($q)){
	echo "<option value='" . $row["Name"] . "'>" . $row["Name"] . "</option>";
}
echo "</select><br>";
echo "Chests: <input type='text' size='10' name='count'><br>";
echo "<br>";
echo "<input type='submit' value='Send'></form><br><br>";
echo "Input number of gained Chests. With negative numbers you can correct wrong numbers.</td></tr></table>";

?>
