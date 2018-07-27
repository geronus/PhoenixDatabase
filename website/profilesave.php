<?php
$name = $_POST["name"];
echo "Name: " . $name;
$data = $_POST["data"];
$data = explode(")", $data);
$zahl = count($data);

if($zahl == 11){
	$level = trim($data[0]);
	$level = explode(" ", $level);
	$level = str_replace(",", "", $level[1]);
	
	$quest = trim($data[3]);
	$quest = explode(" ", $quest);
	$quest = str_replace(",", "", $quest[2]);
	
	$kill = trim($data[5]);
	$kill = explode(" ", $kill);
	$kills = str_replace(",", "", $kill[1]);
	
	$stat = trim($data[7]);
	$stat = explode(" ", $stat);
	$bstat = str_replace(",", "", $stat[1]);
	
	$statb = trim($data[9]);
	$statb = explode(" ", $statb);
	$dp = str_replace(",", "", $statb[3]);
	$statb = str_replace(",", "", $statb[1]);
	$buffstat = trim(str_replace("DP", "", $statb));
}
if($zahl == 10){
	$level = trim($data[0]);
	$level = explode(" ", $level);
	$level = str_replace(",", "", $level[1]);
	
	$quest = trim($data[2]);
	$quest = explode(" ", $quest);
	$quest = str_replace(",", "", $quest[2]);
	
	$kill = trim($data[4]);
	$kill = explode(" ", $kill);
	$kills = str_replace(",", "", $kill[1]);
	
	$stat = trim($data[6]);
	$stat = explode(" ", $stat);
	$bstat = str_replace(",", "", $stat[1]);
	
	$statb = trim($data[8]);
	$statb = explode(" ", $statb);
	$dp = str_replace(",", "", $statb[3]);
	$statb = str_replace(",", "", $statb[1]);
	$buffstat = trim(str_replace("DP", "", $statb));
}
$lvldiff = 0;
$questdiff = 0;
$killdiff = 0;
$statdiff = 0;
$bstatdiff = 0;
$dpdiff = 0;
$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Name LIKE '$name' LIMIT 1;");
while($row = mysqli_fetch_array($q)){
	if($row["Level"] != 0){
		$lvldiff = $level - $row["Level"];
	}
	if($row["Quests"] != 0){
		$questdiff = $quest - $row["Quests"];
	}
	if($row["Kills"] != 0){
		$killdiff = $kills - $row["Kills"];
	}
	if($row["BaseStat"] != 0){
		$statdiff = $bstat - $row["BaseStat"];
		//$statdiff = ($statdiff > 0 ? $statdiff : 1);
	}
	if($row["BuffStat"] != 0){
		$bstatdiff = $buffstat - $row["BuffStat"];
	}
	if($row["DP"] != 0){
		$dpdiff = $dp - $row["DP"];
	}
}
if(($level != 0) && ($kills != 0) && ($bstat != 0) && ($buffstat != 0)){
	echo "<br><br>";
	echo "Level: " . $level . "(+" . $lvldiff . ")<br>";
	echo "Quest: " . $quest . "(+" . $questdiff . ")<br>";
	echo "Kills: " . $kills . "(+" . $killdiff . ")<br>";
	echo "Base Stat: " . $bstat . "(+" . $statdiff . " | " . number_format((($statdiff > 0 ? $killdiff/$statdiff : 0)),2) . " kills per Stat)<br>";
	echo "Buffed Stats: " . $buffstat . "(+" . $bstatdiff . ")<br>";
	echo "DP: " . $dp . "(+" . $dpdiff . ")<br>";
	date_default_timezone_set("Europe/London");
	$datum = date("Y-m-d H:i:s");
	$updatetime = date("Y-m-d H:i:s");
	echo "Date: " . $datum;
	mysqli_query($link, "INSERT INTO `Updates` (`Name`, `Level`, `Quests`, `Kills`, `BaseStat`, `BuffStat`, `DP`, `XP`, `Money`, `Jade`, `Gems`, `Food`, `Iron`, `Stone`, `Lumber`, `GDP`, `Chest`, `Update`) VALUES ('$name', '$lvldiff', '$questdiff', '$killdiff', '$statdiff', '$bstatdiff', '$dpdiff', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$datum');");
	mysqli_query($link, "UPDATE Userliste SET Level = '$level', Quests = '$quest', Kills = '$kills', BaseStat = '$bstat', BuffStat = '$buffstat', DP = '$dp', ProfileUpdate = '$updatetime' WHERE Name LIKE '$name';");
}else{
	echo "Error: Wrong text copied.";
}
?>
