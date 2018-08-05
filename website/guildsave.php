<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("connection.php");
include_once('core-lib.inc.php');
$curr_members = get_all_member_info();
$active_members = get_active_member_names();

echo "<A HREF='admin.php'>Back to Index</A><br><br>";

//1. strip any leading or trailing whitespace characters
$data = trim($_POST["eingabe"]);

//2. Remove any instances of the substring "ent: 0" - unclear why this is necessary
$data = str_replace("ent: 0", "", $data);

//3. Remove all commas
$data = str_replace(",", "", $data);

//4. Replace substrings containing personal tax info with "REMOVE_ME"
$data = preg_replace('/Personal Tax: [0-9]{1,3}%/', 'REMOVE_ME', $data);

//5. Designate a separator - this reflects the two newlines or carriage returns separating each member in the list
// The separator will be a double newline (LF) if found in the text, otherwise a double CRLF; assume this is
// necessary due to differences between browsers/operating systems
$separator = (strpos($data, "\n\n") !== false ? "\n\n" : "\r\n\r\n");

//6. Remove all "REMOVE_ME" substrings that are followed by a separator (which should be all of them)
// includes removing the separators - this should leave just one separator between each member in the text
$data = str_replace('REMOVE_ME' . $separator, '', $data);

//7. Since there's now an extra separator between the name and "Donations", hunt it down and kill it.
//In this case we search for a separator followed by "Donations" and replace it with just "Donations".
$data = preg_replace('/' . $separator . 'Donations/', 'Donations', $data);

//8. Explode the string into an array by separator; the result should be one member per index
$data = explode($separator, $data);

//9. Create 3 new arrays for errors, new members and updated members
$errors = $new_members = $updated = array(); 

//10. Do cool stuff - edit: nevermind, it's not cool

$i2 = count($data);

//Loop over the array
for ($i = 0; $i < $i2; $i++) { 
	
	//Generate a subarray where each index holds one line of text from a member's information block
	$values = explode("\n", $data[$i]);
	/*
	//Verify that the first line is the line containing a member's name, and if not skip this entry altogether
	//We detect this by looking for a dash
	if (strpos($values[0], '-') === false)
		continue;

	//If the second line isn't "Donations", do some unnecessarily complicated shit to try to get the
	//name of the member whose shit is fucked up and remove that member from the $active_members array
	//while also storing each unreadable line in the $errors array
	if (trim($values[1]) != 'Donations') {
		while (count($values) > 0 && trim($values[1]) != 'Donations') {
			$error = array_shift($values);
			$error = explode(' ', $error);
			$error = trim(str_replace('-', '', $error[0]));
			$errors[] = $error;
			if (isset($active_members[$error]))
				unset($active_members[$error]);
		}
		//If $values is NULL, that means we array_shift()'ed the array to death and never 
		//found the "Donations" line, so move on to the next member
		if (!$values) 
			continue;
		//This would only happen if the loop above returned an empty array, which I suppose is
		//possible. Either way, it means the same thing as above, so move on
		else if (trim($values[1]) != 'Donations')
			continue;
	}
*/
	//Break the name line into words, first word is the name + '-'
	$name = explode(' ', $values[0]);
	//Strip leading and trailing whitespace just in case
	$name = trim($name[0]);
	//Cut the last character off the end, which should be the '-'
	//Can't use str_replace because some people have a '-' in their
	//name.
	if(substr($name, -1) == '-'){
		$name = substr($name, 0, -1);
	}
	
	//Second line is "Donations", so if third line isn't "Level", there's a problem,
	//so skip this entry and log an error.
	if (strpos($values[1], 'Level: ') === false) {
		$errors[] = $name;
		if (isset($active_members[$name]))
			unset($active_members[$name]);
		
		continue;
	}


	$level = trim(str_replace('Level: ', '', $values[1]));
	$xp = trim(str_replace('Exp: ', '', $values[2]));
	$money = trim(str_replace('Money: ', '', $values[3]));
	$jade = trim(str_replace('Jade: ', '', $values[4]));
	$gem = trim(str_replace('Gems: ', '', $values[5]));
	$food = trim(str_replace('Food: ', '', $values[6]));
	$iron = trim(str_replace('Iron: ', '', $values[7]));
	$stone = trim(str_replace('Stone: ', '', $values[8]));
	$lumber = trim(str_replace('Lumber: ', '', $values[9]));
	$dp = trim(str_replace('DP: ', '', $values[10]));
	$dpspent = trim(str_replace('DP Spent: ', '', $values[11]));
	$rpgained = trim(str_replace('RP gained: ', '', strtolower($values[12]))); 
	$double = trim(str_replace('Double Donated: ', '', $values[13]));  //added double here (shows up in the list after RP Gained).
	
	//this section is all about converting the lyrania money nomenclature to numbers (from 100p 20g 55s 11c to 100205511)
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
	$doublediff = 0;  //added for monitoring double dontations.
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
	
	//calculates the difference in the various stats from the previous entry into the table for that user.
	$lvldiff = $level - $row["Level"];
	$xpdiff = $xp - $row["EXP"];
	$moneydiff = $money - $row["Money"];
	$jadediff = $jade - $row["Jade"];
	$gemdiff = $gem - $row["Gems"];
	$fooddiff = $food - $row["Food"];
	$irondiff = $iron - $row["Iron"];
	$stonediff = $stone - $row["Stone"];
	$lumberdiff = $lumber - $row["Lumber"];
	$doublediff = $double - $row["Double"]; //calculate double difference from last time.
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
	mysqli_query($link, $sql) or die(mysqli_error($link));
	$sql = "INSERT INTO Updates 
		(`GameID`,`Name`, `Level`, `Quests`, `Kills`, `BaseStat`, `BuffStat`, `DP`, 
		`XP`, `Money`, `Jade`, `Gems`, `Food`, `Iron`, `Stone`, `Lumber`, `GDP`, `GDPSpent`, `RPGained`, `Update`) 
		VALUES ('". ($profile === false ? '0' : $profile['gameid']) ."', '$name', '$lvldiff', ";  //added Double here too.
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
		'$lumberdiff', '$dpdiff', '$dpspentdiff', '$rpgaineddiff', NOW());";  //added double diff here.
	mysqli_query($link, $sql) or die(mysqli_error($link));
	/*echo "Name: " . $name . "<br>";
	echo "Level: " . $level . "(+ " . $lvldiff . ")<br>";
	echo "XP: " . $xp . "(+ " . $xpdiff . ")<br>";
	echo "Money: " . $money . "(+ " . $moneydiff . ")<br>";
	echo "Jade: " . $jade . "(+ " . $jadediff . ")<br>";
	echo "Gems: " . $gem . "(+ " . $gemdiff . ")<br>";
	echo "Food: " . $food . "(+ " . $fooddiff . ")<br>";
	echo "Iron: " . $iron . "(+ " . $irondiff . ")<br>";
	echo "Stone: " . $stone . "(+ " . $stonediff . ")<br>";
	echo "Lumber: " . $lumber . "(+ " . $lumberdiff . ")<br>";
	echo "Double: " . $double . "(+ " . $doublediff . ")<br>";  // added double / double diff here too.
	echo "Guild DP: " . $dp . "(+ " . $dpdiff . ")<br>";*/
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
