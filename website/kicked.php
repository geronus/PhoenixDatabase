<?php
if($_POST["name"] != ""){
	$xp = 0;
	$name = $_POST["name"];
	$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Name LIKE '$name' LIMIT 1;");
	while($row = mysqli_fetch_array($q)){
		$xp = $row["EXP"];
		$xpp = $row["PreviousXP"];
		$xp = $xp + $xpp;
		$gdp = $row["GDP"];
		$gdpp = $row["GDPPrevious"];
		$gdp = $gdp + $gdpp;
		mysqli_query($link, "UPDATE Userliste SET EXP = '0', PreviousXP = '$xp', GDP = '0', GDPPrevious = '$gdp', Active = '1' WHERE Name LIKE '$name';");
		echo "" . $name . " was set to inactive.<br><br>";
	}
}
echo "<table witdth=100%><tr><td><form action='admin.php?x=kicked' method='post'>";
echo "Member: <select name='name'>";
echo "<option selected value=''>-</option>";
$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Level > '0' AND Active = '0';");
while($row = mysqli_fetch_array($q)){
	echo "<option value='" . $row["Name"] . "'>" . $row["Name"] . "</option>";
}
echo "</select><br>";
echo "<br>";
echo "<input type='submit' value='Send'></form></td>";

?>
