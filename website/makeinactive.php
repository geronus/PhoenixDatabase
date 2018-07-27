<?php
if (isset($_POST['inactive'])) {
	//update names.
	$make_inactive = array();
	foreach ($_POST['inactive'] AS $name=>$value) {
		if ($value == 'accident') {
			mysqli_query($link, "
				UPDATE `Userliste` SET `Active` = '0', `PossibleInactive` = 0 WHERE Name = '$name'
			");
		}
		else 
			$make_inactive[] = $name;
	}
	if (count($make_inactive) > 0) {
		make_members_inactive($make_inactive);
	}
}

		
$query = mysqli_query($link, "
	SELECT `Name` FROM `Userliste` WHERE `PossibleInactive` = 1 AND `Active` = 0
");
$inactive = array();
while ($rs = mysqli_fetch_assoc($query)) {
	$inactive[] = $rs['Name'];
}

if (count($inactive) == 0) {
	echo "<p>There seem to be no inactive members at the moment.  If you think there should be, please update the guild first.</p>";
}
else {
	echo "
		<form action='/admin.php?x=makeinactive' method='post'>
		<table class='input' border=1 cellspacing=0>
			<tr>
				<th colspan=2>Status</th>
				<th>Name</th>

			<tr>
	";
	foreach ($inactive AS $name) {
		$name_special = htmlspecialchars($name);
		echo "<tr>
				<td><label><input type='radio' name='inactive[$name_special]' value='left' checked='checked' /> Left</label></td>
				<td><label><input type='radio' name='inactive[$name_special]' value='accident' /> Here</label></td>
				<td><a href='/?x=user&name=$name_special'>$name_special</a></td>
			</tr>";
	}
	echo "
		</table>
		<input type='submit' value='Save Changes' />
		</form>
	";
}