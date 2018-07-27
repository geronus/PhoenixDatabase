<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("connection.php");
include_once('core-lib.inc.php');

if (isset($_POST['Members']) && is_array($_POST['Members'])) {
	response_json(array('error'=>'This method of updating the DB is no longer active.'));
	exit;
	
	$member_ids = get_member_ids();
	$curr_members = get_all_member_info();
	$ranks_roman = get_ranks_by_roman();
	$ranks_num = get_ranks_by_num();
	
	//do ranks first, as this is where we get GameID from!!
	$updates = array();
	$ranks = process_ranks($_POST['Ranks']);
	
	//now that $updates is populated, we can go on with ares and stats
	$areas = process_areas($_POST['Areas']);
	
	//and finally, stats!
	$stats = process_stats($_POST['Members']);

	//now that $updates is populated, let's give it a go!
	$first = true; $total = count($updates); $i = 1;
	foreach ($updates AS $game_id=>$update) {
		if ($first) {
			$first = false;
			$sql = "INSERT INTO Updates (`GameID`, `". implode("`, `", array_keys($update)) ."`, `Update`) VALUES ('";
		}
		$sql .= "$game_id', '". 
		implode("','", $update) 
		."', NOW())";
		if ($total != $i)
			$sql .= ", ('";
		$i++;
	}
	mysqli_query($link, $sql);

	mysqli_query($link, "UPDATE Guild SET LastUpdate = NOW() WHERE Guildname = 'Phoenix'");
	response_json(array(
		'inactive'	=>	implode(', ', $ranks['left']),
		'updates'	=>	$stats,
		'new'		=>	implode(', ', $ranks['new']),
		'returned'	=>	implode(', ', $ranks['returning']),
		'ranks'		=>	rank_calculator()
	));
}
else {
	response_json(array('error'=>'...'));
}

function process_areas($members) {
	global $curr_members, $updates;
	
	foreach ($members AS $member) {
		$current = $curr_members[$member['name']];
		$id = $current['GameID'];
		
		if ($current['Area'] != $member['area']) {
			$updates[$id]['Area'] = $member['area'];
			
			mysqli_query($link, "UPDATE Userliste SET `Area` = '". (int) $member['area'] ."' WHERE GameID = '". (int) $id ."'");
		}
	}
}

function process_stats($members) {
	global $curr_members, $updates;
	$return = array();
	
	foreach ($members AS $member) {
		$name = $member['name'];
		$current = $curr_members[$name];
		$id = $current['GameID'];
		
		$details = explode("\n", trim(str_replace(',', '', $member['details'])));
		$details = array_map('trim', $details);
		
		$level = str_replace('Level: ', '', $details[1]);
		$xp = str_replace('Exp: ', '', $details[2]);
		$money = str_replace('Money: ', '', $details[3]);
		$jade = str_replace('Jade: ', '', $details[4]);
		$gem = str_replace('Gems: ', '', $details[5]);
		$food = str_replace('Food: ', '', $details[6]);
		$iron = str_replace('Iron: ', '', $details[7]);
		$stone = str_replace('Stone: ', '', $details[8]);
		$lumber = str_replace('Lumber: ', '', $details[9]);
		$dp = str_replace('DP: ', '', $details[10]);

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
		
		$updates[$id]['Level'] = $lvldiff = $level - $current["Level"];
		$updates[$id]['XP'] = $xpdiff = $xp - $current["EXP"];
		$updates[$id]['Money'] = $moneydiff = $money - $current["Money"];
		$updates[$id]['Jade'] = $jadediff = $jade - $current["Jade"];
		$updates[$id]['Gems'] = $gemdiff = $gem - $current["Gems"];
		$updates[$id]['Food'] = $fooddiff = $food - $current["Food"];
		$updates[$id]['Iron'] = $irondiff = $iron - $current["Iron"];
		$updates[$id]['Stone'] = $stonediff = $stone - $current["Stone"];
		$updates[$id]['Lumber'] = $lumberdiff = $lumber - $current["Lumber"];
		$updates[$id]['GDP'] = $dpdiff = $dp - $current["GDP"];

		mysqli_query($link, "UPDATE Userliste SET Active = 0, Level = '$level', Gems = '$gem', EXP = '$xp', Money = '$money', Jade = '$jade', Food = '$food', Iron = '$iron', Stone = '$stone', Lumber = '$lumber', GDP = '$dp', Active = '0' WHERE GameID = '$id';");
		
		
		$return[] = array(
			'name'		=>		$name,
			'level'		=>		array($level, $lvldiff),
			'xp'		=>		array($xp, $xpdiff),
			'money'		=>		array($money, $moneydiff),
			'jade'		=>		array($jade, $jadediff),
			'gems'		=>		array($gem, $gemdiff),
			'food'		=>		array($food, $fooddiff),
			'iron'		=>		array($iron, $irondiff),
			'stone'		=>		array($stone, $stonediff),
			'lumber'	=>		array($lumber, $lumberdiff),
			'gdp'		=>		array($dp, $dpdiff)
		);
	}
	return $return;
}

function process_ranks($ranks) {
	global $member_ids, $curr_members, $updates, $ranks_roman, $ranks_num;
	$new_members = $returning_members =  array();
	$active_members = get_active_member_names();
	
	foreach ($ranks AS $member) {
		$r_upd = array();
		$rank = (isset($ranks_roman[$member['rank']]) ? $ranks_roman[$member['rank']]['Rank'] : 0);
		$updates[$member['id']] = upd_array();

		if (isset($member_ids[$member['id']])) {
			$curr = $member_ids[$member['id']];
			$updates[$member['id']]['Name'] = $member['name'];
			
			if ($rank != $curr['Rank']) {
				$updates[$member['id']]['Rank'] = $rank;
				$r_upd[] = "`Rank` = $rank";
			}
			if ($member['name'] != $curr['Name']) {
				$updates[$member['id']]['Name'] = $member['name'];
				$r_upd[] = "`Name` = '". $member['name'] ."'";
			}
			if ($curr['Active'] != '0') {
				//this is a returning member!
				$r_upd[] = "`Active` = 0";
				$returning_members[] = $member['name'];
			}
			else {
				//this is an active member, take them out of the array so that we see who isn't active at the end!
				unset($active_members[$member['id']]);
			}
			if (count($r_upd) > 0) {
				mysqli_query($link, "
					UPDATE Userliste
					SET ". implode(', ', $r_upd) ."
					WHERE GameID = ". $member['id'] ."
				");
			}
		}
		else {
			//this is a new member! 
			$name = $member['name'];
			$new_members[] = $name;
			$sql = "INSERT INTO Userliste 
				(`GameID`,`Name`, `Level`, `Quests`, `Kills`, `BaseStat`, `BuffStat`, `DP`, `EXP`, `PreviousXP`, `Money`, `Jade`, `Gems`, `Food`, `Iron`, `Stone`, `Lumber`, `GDP`, `GDPPrevious`, `Active`,`Rank`) 
				VALUES ('". $member['id'] ."', '$name', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', $rank);
			";
			mysqli_query($link, $sql) or die(mysqli_error() ."\n". $sql);
			$curr_members[$name] = get_one_member_info($name); //no real need to do another query here, but quicker on a coding perspective
		}
	}
	if (count($active_members) > 0) {
		//TODO: would be nice to keep track of previous everything (jade, lumber, etc)
		mysqli_query($link, "
			UPDATE Userliste SET 
				Active = 1,
				PreviousXP = EXP + PreviousXP,
				EXP = 0,
				GDPPrevious = GDP + GDPPrevious,
				GDP = 0,
				RankPrevious = Rank,
				Rank = 0
			WHERE GameID IN('". implode("','", array_keys($active_members)) ."')
		") or die(response_json(array('error'=>mysqli_error())));
	}
	$curr_members = get_all_member_info();
	return array('new'=>$new_members, 'returning'=>$returning_members, 'left'=>$active_members);
}
