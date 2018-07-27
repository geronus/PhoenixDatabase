<?php
$showpoll = $_POST["showpoll"];
echo "<table witdth=100%>";
echo "<tr><td width=100% align='center'>Please mail your vote in game to BloodGood, whispers and chat will be ignored.<br>Voting ends when the guild level reaches 90%.<br>Since votes are manually added, there may be a delay between when I get your mail and it's posted<br>Once a vote has been recorded it cannot be changed.<br><br><br></td></tr>";
echo "<tr><td width=100% align='center'><form action='index.php?x=votes' method='post'><select name='showpoll'>";
echo "<option selected value='-'>-</option>";
$q = mysqli_query($link, "SELECT * FROM Polls WHERE PollID > '0' ORDER BY PollID DESC;");
while($row = mysqli_fetch_array($q)){
	if($row["Active"] == 0){
		echo "<option value='" . $row["PollID"] . "'>" . $row["Name"] . " (Active)</option>";
	}else{
		echo "<option value='" . $row["PollID"] . "'>" . $row["Name"] . " (Ended " . $row["Enddate"] . ")</option>";		
	}
}
echo "</select><input type='submit' value='Show Vote'></form><br><br></td></tr>";

if(($showpoll == "") || ($showpoll == "-")){
	$q = mysqli_query($link, "SELECT * FROM Polls ORDER BY PollID DESC LIMIT 1;");	
}else{
	$q = mysqli_query($link, "SELECT * FROM Polls WHERE PollID LIKE '$showpoll';");
}
while($row = mysqli_fetch_array($q)){
	echo "<table border='1'><tr><td colspan=2>" . $row["Name"] . "</td></tr>";
	$showpoll = $row["PollID"];
	$opts = mysqli_query($link, "SELECT * FROM PollOptions WHERE PollID LIKE '$showpoll';");
	while($row2 = mysqli_fetch_array($opts)){
		$option = $row2["OptionID"];
		echo "<tr><td>" . $row2["Option"] . "</td>";
		$count = 0;
		$voting = mysqli_query($link, "SELECT COUNT(Name) AS Vote FROM Votes WHERE PollID LIKE '$showpoll' AND VoteID LIKE '$option';");
		while($row3 = mysqli_fetch_array($voting)){	
			$count = $row3["Vote"];
		}
			echo "<td>" . $count . "</td></tr>";
	}
}
echo "</table>";
?>
