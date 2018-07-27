<?php
include("connection.php");
$pollid = $_GET['voteid'];
$output = "";
$users = [];
$count = 0;
echo "<select name='vuser'><option selected value='-'>-</option>";
$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Active LIKE '0' ORDER BY Name ASC;");
while($row = mysqli_fetch_array($q)){
	$users[$count] = $row["Name"];
	$count++;
}
echo "test";
$votes = mysqli_query($link, "SELECT * FROM Votes WHERE PollID LIKE '$pollid';");
while($row = mysqli_fetch_array($votes)){
	for($i = 0; $i < $count;$i++){
		if($users[$i] == $row["Name"]){
			$users[$i] = "";
		}
	}
	
}
echo "test2";
for($i = 0; $i < $count; $i++){
	if($users[$i] != ""){
		echo "<option value='" . $users[$i] . "'>" . $users[$i] . "</option>";
	}
}

echo "</select><select name='voptionid'>";
echo "<option selected value='-'>-</option>";
$options = mysqli_query($link, "SELECT * FROM PollOptions WHERE PollID LIKE '$pollid' ORDER BY OptionID ASC");
while($row = mysqli_fetch_array($options)){
	echo "<option value='" . $row["OptionID"] . "'>" . $row["Option"] . "</option>";
}
echo "test3";
echo "</select><br><input type='submit' value='Vote'>";

?>
