<?php
$lvlgoal = $_POST["lvlgoal"];
if($lvlgoal != ""){
	mysqli_query($link, "UPDATE Guild SET LvlGoal = '$lvlgoal' WHERE Guildname LIKE 'Phoenix';");
}
$q = mysqli_query($link, "SELECT LvlGoal FROM Guild WHERE Guildname LIKE 'Phoenix';");
while($row = mysqli_fetch_array($q)){
	$lvlgoal = $row["LvlGoal"];	
}
echo "<form action='admin.php?x=goaladjust' method='post'>";
echo "Level Goal <input type='text' size='1' name='lvlgoal' value='" . $lvlgoal . "'><br>";
echo "<input type='submit' value='Adjust'></form>";
?>
