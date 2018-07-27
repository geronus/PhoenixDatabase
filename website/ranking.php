<?php
$time = (isset($_GET["time"]) && strlen($_GET['time']) > 0 ? $_GET['time'] : 'all');
$ranklevel = $rankdp = $rankchest = $rankxp = array(); 
$date = '';
if ($time !== 'custom') {
	$date = ($time == '7' ? strtotime('-7 day') : ($time == '14' ? strtotime('-14 day') : strtotime('-30 day')));
	$date = "u.`Update` >= DATE(FROM_UNIXTIME($date))";
}
else {
	if (isset($_GET['start']) && strlen($_GET['start']) > 0) {
		$start = strtotime($_GET['start'] .' 00:00:00');
		$date = "u.`Update` >= FROM_UNIXTIME($start)";
		
		if (isset($_GET['end']) && strlen($_GET['end']) > 0) {
			$end = strtotime($_GET['end'] .' 23:59:59');
			$date .= " AND u.`Update` <= FROM_UNIXTIME($end)";
		}
	}
	elseif (isset($_GET['end']) && strlen($_GET['end']) > 0) {
		$end = strtotime($_GET['end'] .' 23:59:59');
		$date = "u.`Update` <= FROM_UNIXTIME($end)";
	}
}

if ($date) {
	if($time == "all"){
		$q = mysqli_query($link, "SELECT Name, Level FROM Userliste WHERE Active = 0 ORDER BY Level DESC;");
		while($row = mysqli_fetch_array($q)){
			$ranklevel[] = array(
				'name'		=>		$row['Name'],
				'level'		=>		$row['Level']
			);
		}

		$q = mysqli_query($link, "SELECT Name, (EXP + PreviousXP) AS EXP FROM Userliste WHERE Active = 0 ORDER BY EXP DESC;");
		while($row = mysqli_fetch_array($q)){
			$rankxp[] = array(
				'name'		=>		$row['Name'],
				'exp'		=>		$row['EXP']
			);
		}

		$q = mysqli_query($link, "SELECT Name, (GDP + GDPPrevious) AS GDP FROM Userliste WHERE Active = 0 ORDER BY GDP DESC;");
		while($row = mysqli_fetch_array($q)){
			$rankdp[] = array(
				'name'		=>		$row['Name'],
				'gdp'		=>		$row['GDP']
			);
		}

		/* $q = mysqli_query($link, "SELECT Name, Chest FROM Userliste WHERE Active = 0 ORDER BY Chest DESC;");
		while($row = mysqli_fetch_array($q)){
			$rankchest[] = array(
				'name'		=>		$row['Name'],
				'chest'		=>		$row['Chest']
			);
		} */
	}
	else {

		$q = mysqli_query($link, "SELECT u.Name, SUM(u.Level) AS Level FROM Updates u LEFT JOIN Userliste us ON u.Name = us.Name WHERE us.Active = 0 AND $date GROUP BY us.Name ORDER BY Level DESC;");
		while($row = mysqli_fetch_array($q)){
			$ranklevel[] = array(
				'name'		=>		$row['Name'],
				'level'		=>		$row['Level']
			);
		}

		$q = mysqli_query($link, "SELECT u.Name, SUM(u.XP) AS XP FROM Updates u LEFT JOIN Userliste us ON u.Name = us.Name WHERE us.Active = 0 AND $date GROUP BY us.Name ORDER BY XP DESC;");
		while($row = mysqli_fetch_array($q)){
			$rankxp[] = array(
				'name'		=>		$row['Name'],
				'exp'		=>		$row['XP']
			);
		}

		$q = mysqli_query($link, "SELECT u.Name, SUM(u.GDP) AS GDP FROM Updates u LEFT JOIN Userliste us ON u.Name = us.Name WHERE us.Active = 0 AND $date GROUP BY us.Name ORDER BY GDP DESC;");
		while($row = mysqli_fetch_array($q)){
			$rankdp[] = array(
				'name'		=>		$row['Name'],
				'gdp'		=>		$row['GDP']
			);
		}

		/* $q = mysqli_query($link, "SELECT Name, SUM(Chest) AS Chest FROM Updates WHERE `Update` >= DATE(FROM_UNIXTIME($date)) GROUP BY Name ORDER BY Chest DESC;");
		while($row = mysqli_fetch_array($q)){
			$rankchest[] = array(
				'name'		=>		$row['Name'],
				'chest'		=>		$row['Chest']
			);
		} */
	}
}

$count = count($ranklevel);
echo "
	<script type='text/javascript' src='/js/jquery-3.1.1.min.js'></script>
	<script type='text/javascript' src='/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'></script>
	<link rel='stylesheet' href='/js/jquery-ui-1.12.1.custom/jquery-ui.min.css' />
	<script type='text/javascript' src='/js/rank-date.js'></script>
	<table width='100%' cellspacing=0>
		<tr>
			<th align='center'". ($time == 'all' ? ' class="active"' : '') ."><A HREF='index.php?x=ranking&time=all'>All Time High</A></th>
			<th align='center'". ($time == '7' ? ' class="active"' : '') ."><A HREF='index.php?x=ranking&time=7'>Last 7 days</A></th>
			<th align='center'". ($time == '14' ? ' class="active"' : '') ."><A HREF='index.php?x=ranking&time=14'>Last 14 days</A></th>
			<th align='center'". ($time == '30' ? ' class="active"' : '') ."><A HREF='index.php?x=ranking&time=30'>Last 30 days</A></th>
			<th align='center'". ($time == 'custom' ? ' class="active"' : '') ."><a href='index.php?x=ranking&time=custom'>Custom</a></th>
		</tr>
	</table>
";

if ($time == 'custom') {
	echo "
	<br />
	<form method='get' action='/index.php'>
	<input type='hidden' name='x' value='ranking' />
	<input type='hidden' name='time' value='custom' />
	<table border='0' cellspacing='0' class='input'>
		<tr>
			<th>Start</th><th>End</th><th>&nbsp;</th>
		</tr>
		<tr>
			<td><input class='datepicker' type='text' name='start' value='". (isset($_GET['start']) ? $_GET['start'] : '') ."' /></td>
			<td><input class='datepicker' type='text' name='end'   value='". (isset($_GET['end'])   ? $_GET['end']   : '') ."' /></td>
			<td><input type='submit' value='Update' /></td>
		</tr>
	</table>
	</form>
	";
}

if ($date) {
	echo "
		<table width='100%' cellspacing=0 class='content'>
			<tr>
				<td class='column'>
					<table cellspacing=0>
						<tr>
							<th colspan=3>Top Level</th>
						</tr>
	";
	$total = 0;
	foreach ($ranklevel AS $id=>$mem) {
		$rank = $id+1;
		$total += $mem['level'];
		echo "
						<tr>
							<td>" . $rank . ".</td>
							<td><a href='/?x=user&name=". $mem['name'] ."'>". $mem['name'] ."</a></td>
							<td>" . number_format($mem['level'], 0, ".", ",") . "</td>
						</tr>
		";
	}
	echo "
						<tr class='total'>
							<td colspan=2 align=right>Total:</td>
							<td>". number_format($total, 0, '.', ',') ."</td>
						</tr>
					</table>
				</td>
				<td class='column' width='50'>
					&nbsp;
				</td>
				<td class='column'>
					<table cellspacing=0>
						<tr>
							<th colspan=3>Top Guild XP</th>
						</tr>
	";
	$total = 0;
	foreach ($rankxp AS $id=>$mem) {
		$rank = $id+1;
		$total += $mem['exp'];
		echo "
						<tr>
							<td>" . $rank . ".</td>
							<td><a href='/?x=user&name=". $mem['name'] ."'>". $mem['name'] ."</a></td>
							<td>" . number_format($mem['exp'], 0, ".", ",") . "</td>
						</tr>
		";
	}
	echo "
						<tr class='total'>
							<td colspan=2 align=right>Total:</td>
							<td>". number_format($total, 0, '.', ',') ."</td>
						</tr>
					</table>
				</td>
				<td class='column' width='50'>
					&nbsp;
				</td>
				<td class='column'>
					<table cellspacing=0>
						<tr>
							<th colspan=3>Top Guild DP</th>
						</tr>
	";
	$total = 0;
	foreach($rankdp AS $id=>$mem) {
		$rank = $id+1;
		$total += $mem['gdp'];
		echo "
						<tr>
							<td>" . $rank . ".</td>
							<td><a href='/?x=user&name=". $mem['name'] ."'>". $mem['name'] ."</a></td>
							<td>" . number_format($mem['gdp'], 0, ".", ",") . "</td>
							
						</tr>
		";
	}
	echo "
						<tr class='total'>
							<td colspan=2 align=right>Total:</td>
							<td>". number_format($total, 0, '.', ',') ."</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	";
}
//echo "</td></tr>";
/*echo "</td><td width='50px'></td><td>";
/* echo "<table border='1'><tr><td colspan='3' align='center'><b>Top Chest</b></td></tr>";
for($i = 0; $i < $count; $i++){
	$rank = $i+1;
	echo "<tr><td>" . $rank . ".</td><td>" . $rankchest[$i][0] . "</td><td>" . number_format($rankchest[$i][1], 0, ".", ",") . "</td></tr>";
}
echo "</table>"; */
//echo "</table>";

?>

