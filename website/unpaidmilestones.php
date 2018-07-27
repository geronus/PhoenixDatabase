<?php
if (isset($_POST['sorted'])) {
	//update names.
	foreach ($_POST['sorted'] AS $name=>$rank) {
		mysqli_query($link, "
			INSERT INTO `Updates` (Name, Rank, `Update`) VALUES('". $name ."', '". $rank ."', NOW())
		");
		mysqli_query($link, "
			UPDATE `Userliste` SET Rank = '$rank' WHERE Name = '$name'
		");
	}
}

		
$unpaid = rank_calculator();
$ranks = get_ranks_by_num();
if (count($unpaid) == 0) {
	echo "<p>There are no unpaid debts at the moment.  If you think there should be, please update the guild first.</p>";
}
else {
	echo "
		<form action='/admin.php?x=unpaidmilestones' method='post'>
		<table class='input' border=1 cellspacing=0>
			<tr>
				<th>Paid?</th>
				<th>Name</th>
				<th>GDP Earned</th>
				<th>Current Rank</th>
				<th>Milestone (s)</th>
				<th>New Rank</th>
				<th>Plat</th>
			<tr>
	";
	foreach ($unpaid AS $name=>$mem) {
		$old_rank = $mem['rank'];
		$old_rank_text = (isset($ranks[$old_rank]) ? $ranks[$old_rank]['Roman'] : 0);
		$name_special = htmlspecialchars($name);
		echo "<tr>
				<td><input type='checkbox' name='sorted[$name_special]' value='". $mem['num'] ."' /></td>
				<td><a href='/?x=user&name=$name'>". $mem['Name'] ."</a></td>
				<td>". $mem['gdp'] ."</td>
				<td>$old_rank ($old_rank_text)</td>
				<td>". $mem['milestone'] ."</td>
				<td>". $mem['num'] ." (". $mem['rom'] .")</td>
				<td>". $mem['pay'] ."p</td>
			</tr>";
	}
	echo "
		</table>
		<input type='submit' value='Update Ranks' />
		</form>
	";
}