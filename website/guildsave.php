<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("connection.php");
include_once('core-lib.inc.php');
$curr_members = get_all_member_info();
$active_members = get_active_member_names();

echo "<A HREF='admin.php'>Back to Index</A><br><br>";
$data = trim($_POST["eingabe"]);
$data = str_replace("ent: 0", "", $data); //no idea what this even does..???

$data = str_replace(",", "", $data);
$data = preg_replace('/Personal Tax: [0-9]{1,3}%/', 'REMOVE_ME', $data);
$separator = (strpos($data, "\n\n") !== false ? "\n\n" : "\r\n\r\n");
$data = str_replace('REMOVE_ME'. $separator, '', $data);

$data = explode($separator, $data);
$errors = $new_members = $updated = array();

$i2 = count($data);
for($i = 0; $i < $i2; $i++){
	$values = explode("\n", $data[$i]);
	
	if (strpos($values[0], '-') === false)
		continue; //the first result isn't a member.. maybe they selected more text than they should have?
	
	if (trim($values[1]) != 'Donations') {
		while (count($values) > 0 && trim($values[1]) != 'Donations') {
			$error = array_shift($values);
			$error = explode(' ', $error);
			$error = trim(str_replace('-', '', $error[0]));
			$errors[] = $error;
			if (isset($active_members[$error]))
				unset($active_members[$error]);
		}
		if (!$values) 
			continue; //we've gone through all the names...
		else if (trim($values[1]) != 'Donations')
			continue; //uh.. absolutely no idea why this would happen, but just in case!
	}

	$name = explode(' ', $values[0]);
	$name = trim(str_replace('-', '', $name[0]));
	
	if (strpos($values[2], 'Level: ') === false) {
		$errors[] = $name;
		if (isset($active_members[$name]))
			unset($active_members[$name]);
		
		continue; //again, not sure why this is happening, but don't want to update the DB just in case !
	}
	$level = trim(str_replace('Level: ', '', $values[2]));
	$xp = trim(str_replace('Exp: ', '', $values[3]));
	$money = trim(str_replace('Money: ', '', $values[4]));
	$jade = trim(str_replace('Jade: ', '', $values[5]));
	$gem = trim(str_replace('Gems: ', '', $values[6]));
	$food = trim(str_replace('Food: ', '', $values[7]));
	$iron = trim(str_replace('Iron: ', '', $values[8]));
	$stone = trim(str_replace('Stone: ', '', $values[9]));
	$lumber = trim(str_replace('Lumber: ', '', $values[10]));
	$dp = trim(str_replace('DP: ', '', $values[11]));
	$dpspent = trim(str_replace('DP Spent: ', '', $values[12]));
	$rpgained = trim(str_replace('rp gained: ', '', strtolower($values[13]))); 
	
	$plat = 0;
	$gold = 0;
	$silver = 0;
	$copper = 0;
	$moneylength = strlen($money);
	$platpos = strpos($money, "p");
	if($platpos != 0){
		$plat = trim(substr($money, 0, $platpos));
	}
	$goldpos = strpos($money, "g");
	if($goldpos != 0){
		$gold = trim(substr($money, ($platpos + 1), ($moneylength - $platpos - 1 - $goldpos)));
	}
	$silverpos = strpos($money, "s");
	if($silverpos != 0){
		$silver = trim(substr($money, ($goldpos + 1), ($moneylength - $goldpos - 1 - $silverpos)));
	}
	$copperpos = strpos($money, "c");
	if($copperpos != 0){
		$copper = trim(substr($money, ($silverpos + 1), ($moneylength - $silverpos - 1 - $copperpos)));
	} 
	$money = ($plat * 1000000) + ($gold * 10000) + ($silver * 100) + $copper;

	
	$lvldiff = 0;
	$xpdiff = 0;
	$moneydiff = 0;
	$jadediff = 0;
	$gemdiff = 0;
	$fooddiff = 0;
	$irondiff = 0;
	$stonediff = 0;
	$lumberdiff = 0;
	$dpdiff = 0;
	$dpspentdiff = 0;
	$rpgaineddiff = 0;
	
	if (isset($active_members[$name]))
		unset($active_members[$name]);
	
	if (isset($curr_members[$name])) {
		$row = $curr_members[$name];
	}
	else {
		$new_members[] = $name;
		$row = add_member_to_db($name);
		if ($row === false)
			continue; //there was an error inputting, let's move on.
	}
		
	$lvldiff = $level - $row["Level"];
	$xpdiff = $xp - $row["EXP"];
	$moneydiff = $money - $row["Money"];
	$jadediff = $jade - $row["Jade"];
	$gemdiff = $gem - $row["Gems"];
	$fooddiff = $food - $row["Food"];
	$irondiff = $iron - $row["Iron"];
	$stonediff = $stone - $row["Stone"];
	$lumberdiff = $lumber - $row["Lumber"];
	$dpdiff = $dp - $row["GDP"];

	$dpspentdiff = $dpspent - $row['GDPSpent'];
	$rpgaineddiff = $rpgained - $row['RPGained'];
	
	$profile = update_profile($name, $row, false); //gets profile, but doesn't update it!

	$sql = "UPDATE `Userliste` SET 
		GameID = '". ($profile !== false ? $profile['gameid'] : 0) ."', 
		Level = '$level', EXP = '$xp', 
		Money = '$money', Jade = '$jade', 
		Food = '$food', Iron = '$iron', 
		Stone = '$stone', 
		Lumber = '$lumber', 
		GDP = '$dp', GDPSpent = '$dpspent',
		Gems = '$gem', RPGained = '$rpgained',
		Active = '0'
	";
	if ($profile !== false) {
		$sql .= ",
		Quests = '". $profile['quests'] ."',
		Kills = '". $profile['kills'] ."',
		BaseStat = '". $profile['basestats'] ."',
		BuffStat = '". $profile['buffstats'] ."',
		DP = '". $profile['dp'] ."',
		ProfileUpdate = NOW()
		";
	}
	$sql .= "WHERE Name = '$name';";
	mysqli_query($link, $sql) or die(mysqli_error());
	$sql = "INSERT INTO Updates 
		(`GameID`,`Name`, `Level`, `Quests`, `Kills`, `BaseStat`, `BuffStat`, `DP`, 
		`XP`, `Money`, `Jade`, `Gems`, `Food`, `Iron`, `Stone`, `Lumber`, `GDP`, `GDPSpent`, `RPGained`, `Update`) 
		VALUES ('". ($profile === false ? '0' : $profile['gameid']) ."', '$name', '$lvldiff', ";
	if ($profile !== false) {
		$sql .= "
			'". $profile['quests_diff'] ."',
			'". $profile['kills_diff'] ."',
			'". $profile['base_diff'] ."',
			'". $profile['buff_diff'] ."',
			'". $profile['dp_diff'] ."',
		";
	}
	else {
		$sql .= "'0', '0', '0', '0', '0',";
	}
	$sql .= "'$xpdiff', '$moneydiff', '$jadediff', '$gemdiff', '$fooddiff', '$irondiff', '$stonediff', 
		'$lumberdiff', '$dpdiff', '$dpspentdiff', '$rpgaineddiff', NOW());";
	mysqli_query($link, $sql) or die(mysqli_error($link));
	/* echo "Name: " . $name . "<br>";
	echo "Level: " . $level . "(+ " . $lvldiff . ")<br>";
	echo "XP: " . $xp . "(+ " . $xpdiff . ")<br>";
	echo "Money: " . $money . "(+ " . $moneydiff . ")<br>";
	echo "Jade: " . $jade . "(+ " . $jadediff . ")<br>";
	echo "Gems: " . $gem . "(+ " . $gemdiff . ")<br>";
	echo "Food: " . $food . "(+ " . $fooddiff . ")<br>";
	echo "Iron: " . $iron . "(+ " . $irondiff . ")<br>";
	echo "Stone: " . $stone . "(+ " . $stonediff . ")<br>";
	echo "Lumber: " . $lumber . "(+ " . $lumberdiff . ")<br>";
	echo "Guild DP: " . $dp . "(+ " . $dpdiff . ")<br>"; */
	$updated[] = $name;
	
}
mysqli_query($link, "UPDATE Guild SET LastUpdate = NOW() WHERE Guildname = 'Phoenix'");
if (count($new_members) > 0) {
	echo "<h2>New Members:</h2><p>". implode(", ", $new_members) .'</p>';
}
if (count($updated) > 0) {
	echo "<h2>Updated:</h2><p>". implode(", ", $updated) .'</p>';
}
if (count($active_members) > 0) {
	//there are actually some inactive members, let's mark them inactive:
	make_members_possible_inactive(array_keys($active_members));
	echo "<h2>Are these members no longer in the guild?:</h2><p>";
	include "makeinactive.php";
}
if (count($errors) > 0) {
	echo "<h2>Not updated (forget to open their record?):</h2><p>"
		. implode(', ', $errors) ."</p>";
}
echo "<h2>Unpaid GDP Milestones:</h2>";
include "unpaidmilestones.php";

echo "</body>";