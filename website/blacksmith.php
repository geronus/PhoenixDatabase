<?php
$bs = (isset($_POST['bs']) ? (int) $_POST["bs"] : null);
if($bs){
	mysqli_query($link, "UPDATE Guild SET BlackSmith = '$bs' WHERE Guildname LIKE 'Phoenix';");
}
$q = mysqli_query($link, "SELECT BlackSmith FROM Guild WHERE Guildname LIKE 'Phoenix';");
while($row = mysqli_fetch_array($q)){
	$bs = $row["BlackSmith"];	
}
echo "<form action='admin.php?x=blacksmith' method='post'>";
echo "Blacksmith Level: <select name='bs'>";
for($i = 0; $i <= 50; $i++){
	if($i == $bs){
		echo "<option selected value='" . $i . "'>" . $i . "</option>";
	}else{
		echo "<option value='" . $i . "'>" . $i . "</option>";
	}
}
echo "</select>";
echo "<input type='submit' value='Adjust'></form>";
?>
