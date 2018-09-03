<?php
include_once('moneyconvert.php');

function upd_array() {
	return array(
		'Level'		=>	0,		'Quests'	=>	0, 
		'Kills'		=>	0,		'BaseStat'	=>	0,
		'BuffStat'	=>	0,		'DP'		=>	0,
		'XP'		=>	0,		'Money'		=>	0,
		'Jade'		=>	0,		'Gems'		=>	0,
		'Food'		=>	0,		'Iron'		=>	0,
		'Stone'		=>	0,		'Lumber'	=>	0,
		'GDP'		=>	0,		'Chest'		=>	0,
		'Rank'		=>	0,		'Name'		=> ''
	);
}

function get_ranks_by_roman() {
	global $link;
	$ranks = array();
	$q = mysqli_query($link, "SELECT * FROM Ranks");
	while ($r = mysqli_fetch_assoc($q)) {
		$ranks[$r['Roman']] = $r;
	}
	return $ranks;
}

function get_ranks_by_num() {
	global $link;
	$ranks = array();
	$q = mysqli_query($link, "SELECT * FROM Ranks");
	while ($r = mysqli_fetch_assoc($q)) {
		$ranks[$r['Rank']] = $r;
	}
	return $ranks;
}

function get_member_ids() {
	$ids = array();
	foreach (get_all_member_info() AS $member) {
		$ids[$member['GameID']] = $member;
	}
	return $ids;
}

function get_all_member_info() {
	global $link;
	$members = array();
	
	$q = mysqli_query($link, "SELECT * FROM Userliste");
	while ($r = mysqli_fetch_assoc($q)) {
		$members[$r['Name']] = $r;
	}
	return $members;
}

function get_one_member_info($name, $is_id = false) {
	global $link;
	$col = ($is_id ? 'GameID' : 'Name');
	$q = mysqli_query($link, "SELECT * FROM Userliste WHERE $col = '$name'") or die(mysqli_error());
	if (mysqli_num_rows($q) == 1) 
		return mysqli_fetch_assoc($q);
	
	else return array();
}

/* function get_active_member_names() {
	$names = array();
	$q = mysqli_query($link, "SELECT GameID, Name FROM Userliste WHERE Level > '0' AND Active LIKE '0' ORDER BY Name;");
	while ($r = mysqli_fetch_array($q)) {
		$names[$r['GameID']] = $r['Name'];
	}
	return $names;
} */

function get_active_member_names() {
	global $link;
	$names = array();
	$q = mysqli_query($link, "SELECT Name FROM Userliste WHERE Level > '0' AND Active LIKE '0' ORDER BY Name;");
	while ($r = mysqli_fetch_array($q)) {
		$names[$r['Name']] = true;
	}
	return $names;
}

function get_active_member_select($name = '') {
	$ret = '<select name="name">';
	foreach(get_active_member_names() AS $member) {
		$ret .= '<option'. ($name == $member ? ' SELECTED' : '') .' value="'. $member .'">'. $member .'</option>';
	}
	return $ret .= '</select>';
}

function add_member_to_db($name, $rank = 0) {
	global $link;
	if (strlen($name) > 0) {
		$sql = "INSERT INTO `Userliste`
			(`Name`, `Level`, `Quests`, `Kills`, `BaseStat`, `BuffStat`, `DP`, `EXP`, `PreviousXP`, `Money`, `Jade`, `Gems`, `Food`, `Iron`, `Stone`, `Lumber`, `GDP`, `GDPPrevious`, `Active`,`Rank`) 
			VALUES ('$name', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$rank');
		";
		mysqli_query($link, $sql);
		return get_one_member_info($name);
	}
	else
		return false;
}

function make_members_inactive($names = array()) {
	global $link;
	if (count($names) > 0) {
		$sql ="
			UPDATE Userliste SET 
				Active = 1,
				PreviousXP = EXP + PreviousXP,
				EXP = 0,
				GDPPrevious = GDP + GDPPrevious,
				GDP = 0,
				RankPrevious = Rank,
				Rank = 0,
				PossibleInactive = 0
			WHERE Name IN('". implode("','", $names) ."')
		";
		mysqli_query($link, $sql) or die(mysqli_error());
	}
	return true;
}

function make_members_possible_inactive($names = array()) {
	global $link;
	if (count($names) > 0) {
		$sql ="
			UPDATE Userliste SET 
				PossibleInactive = 1
			WHERE Name IN('". implode("','", $names) ."')
		";
		mysqli_query($link, $sql) or die(mysqli_error());
	}
	return true;
}

function get_who($name) {
  // initialize a new curl resource
  $ch = curl_init();
  
  $fullURL = "https://lyrania.co.uk/commands.php";

  // set the url to fetch
  curl_setopt($ch, CURLOPT_URL, "$fullURL");

  // don't give me the headers just the content
  curl_setopt($ch, CURLOPT_HEADER,0);

  // return the value instead of printing the response to browser
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  // use a user agent to mimic a browser
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');

  //force gzip, if it'll accept it.
  //curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'x='. urlencode('who  '. $name));
  
  $content = curl_exec($ch);

  if ($content) {
    // remember to always close the session and free all resources
    curl_close($ch);
     return $content;

  } else {
    if (curl_error($ch)) {
	  echo 'Curl error: ' . curl_error($ch) .' - ';
	}
      curl_close($ch);
      return false;
  }
}

function response_json($data) {
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	
	echo json_encode(array(
		'status'		=>		(isset($data['error']) ? 'fail' : 'ok'),
		'data'			=>		$data
	));
}

function rank_calculator() {
	global $ranks_num, $link;
	if (!isset($ranks_num) || !$ranks_num)
		$ranks_num = get_ranks_by_num();
	
	$new_ranks = array();
	$q = mysqli_query($link, "
		SELECT Name, Rank, GDP + GDPPrevious AS GDP
		FROM Userliste WHERE Active = 0
	");
	while ($r = mysqli_fetch_assoc($q)) {
		if (isset($ranks_num[$r['Rank'] + 1])) {
			$next_rank = $ranks_num[$r['Rank'] + 1];
			$break_out = false;
			while ($r['GDP'] >= $next_rank['GDP'] && !$break_out) {
				if (!isset($new_ranks[$r['Name']]))
					$new_ranks[$r['Name']] = array(
						'Name'=>$r['Name'], 
						'gdp'=>$r['GDP'],
						'rank'=>$r['Rank'],
						'milestone'=>0,
						'num'=>0, 
						'rom'=>0, 
						'pay'=>0);
				
				$new_ranks[$r['Name']]['num'] = $next_rank['Rank'];
				$new_ranks[$r['Name']]['rom'] = $next_rank['Roman'];
				$new_ranks[$r['Name']]['pay'] += ($next_rank['Reward'] / 1000000);
				$new_ranks[$r['Name']]['milestone'] = $next_rank['GDP'];
				
				if (isset($ranks_num[$next_rank['Rank'] + 1]))
					$next_rank = $ranks_num[$next_rank['Rank'] + 1];
				else
					$break_out = true;
			}
		}
	}
	return $new_ranks;
}

function update_profile($name, $old = null, $update = true) {
	global $link;
	if (!$update)
		return false;

	$old = ($old === null ? get_one_member_info($name) : $old);
	$html = get_profile($name);
	
	$rows = explode(PHP_EOL, str_replace(',', '', $html));
	//print_r($rows);
	if (count($rows) >= 0 && strpos($rows[2], 'Level: ') !== false) {
		$level = explode(' ', $rows[2]);
		$quests = explode(' ', $rows[3]);
		$kills = explode(' ', $rows[5]);
		$stats = explode(' ', $rows[6]);
		$dp = explode(' ', $rows[7]);
		
		$gameid = explode('friend(', $html);
		if (count($gameid) > 0) {
			$gameid = explode(')', $gameid[1]);
			$gameid = $gameid[0];
		}
		else $gameid = 0;
		
		$level			=	$level[1];
		$level_diff 	=	$level - $old['Level'];
		
		$quests			=	$quests[2];
		$quests_diff	=	$quests - $old['Quests'];
		
		$kills			=	$kills[1];
		$kills_diff		=	$kills - $old['Kills'];
		
		$basestats		=	$stats[3];
		$base_diff		=	$basestats - $old['BaseStat'];
		
		$buffstats		=	$stats[7];
		$buff_diff		=	$buffstats - $old['BuffStat'];
		
		$dp				=	$dp[2];
		$dp_diff		=	$dp - $old['DP'];
		
		if ($update) {
			$sql = "
				INSERT INTO `Updates` 
					(`GameID`, `Name`, `Level`, `Quests`, `Kills`, `BaseStat`, `BuffStat`, `DP`, `Update`)
					VALUES ('$gameid', '$name', '$level_diff', '$quests_diff', '$kills_diff', '$base_diff', '$buff_diff', '$dp_diff', NOW())
			";
			
			mysqli_query($link, $sql);
			
			$sql = "
				UPDATE `Userliste` SET
					`Level`		= '$level',
					`Quests` 		= '$quests',
					`Kills` 		= '$kills',
					`BaseStat` 	= '$basestats',
					`BuffStat`	= '$buffstats',
					`DP`			= '$dp',
					`ProfileUpdate` = NOW()
				WHERE 
					`Name` = '$name'
			";
			mysqli_query($link, $sql);
		}
		
		else {
			return array(
				'level'			=>		$level,
				'level_diff'	=>		$level_diff,
				'gameid'		=>		$gameid,
				'quests'		=>		$quests,
				'quests_diff'	=>		$quests_diff,
				'kills'			=>		$kills,
				'kills_diff'	=>		$kills_diff,
				'basestats'		=>		$basestats,
				'base_diff'		=>		$base_diff,
				'buffstats'		=>		$buffstats,
				'buff_diff'		=>		$buff_diff,
				'dp'			=>		$dp,
				'dp_diff'		=>		$dp_diff
			);
		}
	}
	else
		return false;
}


function get_profile($name) {
  //TODO:  might need to change some php.ini settings incase this takes too long and causes a timeout.
  // initialize a new curl resource
  $ch = curl_init();
  
  // set the url to fetch
  curl_setopt($ch, CURLOPT_URL, "https://lyrania.co.uk/profile.php");

  // don't give me the headers just the content
  curl_setopt($ch, CURLOPT_HEADER,0);

  // return the value instead of printing the response to browser
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
  //ignore ssl
  //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  // use a user agent to mimic a browser.  not really needed, just old habbit
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');

  //this is the magic bit to get the profile page back:
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'x='. urlencode($name) . '&y=undefined&z=undefined');
  
  $content = curl_exec($ch);

  if ($content) {
    // remember to always close the session and free all resources
    curl_close($ch);
     return $content;

  } else {
   /*  if (curl_error($ch)) {
	  echo 'Curl error: ' . curl_error($ch) .' - ';
	} */
      curl_close($ch);
      return false;
  }
}
