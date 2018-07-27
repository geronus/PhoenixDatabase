<?php
$q = "";
echo "<table border=1 cellspacing=0><tr>
	<th". ($order == 'Name' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=Name'>Name</A></th>
	<th". ($order == 'Level' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=Level'>Level</A></th>
	<th". ($order == 'Quests' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=Quests'>Quests</A></th>
	<th". ($order == 'Kills' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=Kills'>Kills</A></th>
	<th". ($order == 'BaseStat' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=BaseStat'>Base Stats</A></th>
	<th". ($order == 'BuffStat' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=BuffStat'>Buffed Stats</A></th>
	<th". ($order == 'DP' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=DP'>Personal DP</A></th>
	</tr>";

if($order == "Name"){
	$q = mysqli_query($link, "SELECT *, (EXP + PreviousXP) AS EXP FROM Userliste WHERE Active = '0' ORDER BY $order ASC;");
}else{
	$q = mysqli_query($link, "SELECT *, (EXP + PreviousXP) AS EXP FROM Userliste WHERE Active = '0' ORDER BY $order DESC;");
}
while($row = mysqli_fetch_array($q)){
	echo "<tr>";
	echo "<td><A HREF='index.php?x=user&name=" . $row["Name"] . "'>" . $row["Name"] . "</A></td>";
	echo "<td>" . number_format($row["Level"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Quests"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Kills"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["BaseStat"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["BuffStat"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["DP"], 0, ".", ",") . "</td>";
	echo "</tr>";	
}
echo "</table>";
echo "<br>Ex-Member<br><br>";
echo "<table border=1 cellspacing=0><tr>
	<th". ($order == 'Name' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=Name'>Name</A></th>
	<th". ($order == 'Level' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=Level'>Level</A></th>
	<th". ($order == 'Quests' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=Quests'>Quests</A></th>
	<th". ($order == 'Kills' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=Kills'>Kills</A></th>
	<th". ($order == 'BaseStat' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=BaseStat'>Base Stats</A></th>
	<th". ($order == 'BuffStat' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=BuffStat'>Buffed Stats</A></th>
	<th". ($order == 'DP' ? ' class="active"' : '') ."><A HREF='index.php?x=ptable&order=DP'>Personal DP</A></th>
	</tr>";

if($order == "Name"){
	$q = mysqli_query($link, "SELECT *, (EXP + PreviousXP) AS EXP FROM Userliste WHERE Active = '1' ORDER BY $order ASC;");
}else{
	$q = mysqli_query($link, "SELECT *, (EXP + PreviousXP) AS EXP FROM Userliste WHERE Active = '1' ORDER BY $order DESC;");
}
while($row = mysqli_fetch_array($q)){
	echo "<tr>";
	echo "<td><A HREF='index.php?x=user&name=" . $row["Name"] . "'>" . $row["Name"] . "</A></td>";
	echo "<td>" . number_format($row["Level"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Quests"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Kills"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["BaseStat"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["BuffStat"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["DP"], 0, ".", ",") . "</td>";
	echo "</tr>";	
}
echo "</table>";
?>
