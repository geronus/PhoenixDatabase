<?php
include_once('core-lib.inc.php');
$rank_num = get_ranks_by_num();

$q = "";
$updatetime = mysqli_query($link, "SELECT * FROM Guild WHERE Guildname LIKE 'Phoenix';");
while($row = mysqli_fetch_array($updatetime)){
	echo "Last Update: " . $row["LastUpdate"] . " Servertime<br>";
}
echo "<table border=1 cellspacing=0>
	<tr>
		<th". ($order == 'Name' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Name'>Name</A></th>
		<th". ($order == 'EXPT' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=EXPT'>XP</A></th>
		<th". ($order == 'Money' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Money'>Money</A></th>
		<th". ($order == 'Jade' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Jade'>Jade</A></th>
		<th". ($order == 'Gems' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Gems'>Gems</A></th>
		<th". ($order == 'Food' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Food'>Food</A></th>
		<th". ($order == 'Iron' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Iron'>Iron</A></th>
		<th". ($order == 'Stone' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Stone'>Stone</A></th>
		<th". ($order == 'Lumber' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Lumber'>Lumber</A></th>
		<!-- <th". ($order == 'Area' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Area'>Area</A></th> //-->
		<th". ($order == 'Rank' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Rank'>Rank</A></th>
		<th". ($order == 'GDPT' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=GDPT'>Guild DP</A></th>
		<th". ($order == 'GDPSpent' ? ' class="active"' : '') ."><a href='/?x=gtable&order=GDPSpent'>GDP Spent</a></th>
		<th". ($order == 'RPGained' ? ' class="active"' : '') ."><a href='/?x=gtable&order=RPGained'>RP Gained</a></th>
	</tr>";

if($order == "Name"){
	$q = mysqli_query($link, "SELECT *, (EXP + PreviousXP) AS EXPT, (GDP + GDPPrevious) AS GDPT FROM Userliste WHERE Active = '0' ORDER BY $order ASC;");
}else{
	$q = mysqli_query($link, "SELECT *, (EXP + PreviousXP) AS EXPT, (GDP + GDPPrevious) AS GDPT FROM Userliste WHERE Active = '0' ORDER BY $order DESC;");
}
while($row = mysqli_fetch_array($q)){
	echo "<tr>";
	if($row["Active"] == 1){
		echo "<td><A HREF='index.php?x=user&name=" . $row["Name"] . "'>" . $row["Name"] . "*</A></td>";
	}else{
		echo "<td><A HREF='index.php?x=user&name=" . $row["Name"] . "'>" . $row["Name"] . "</A></td>";
	}
	echo "<td>" . number_format($row["EXPT"], 0, ".", ",") . "</td>";
	echo "<td>" . MoneyConvert($row["Money"]) . "</td>";
	echo "<td>" . number_format($row["Jade"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Gems"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Food"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Iron"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Stone"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Lumber"], 0, ".", ",") . "</td>";
	echo "<!-- <td>" . $row['Area'] ."</td> //-->";
	echo "<td>" . (isset($rank_num[$row['Rank']]) ? $rank_num[$row['Rank']]['Roman'] : 0) .'</td>';
	echo "<td>" . number_format($row["GDPT"], 0, ".", ",") . "</td>";
	echo "<td>". number_format($row['GDPSpent'], 0, '.', ',') ."</td>";
	echo "<td>". number_format($row['RPGained'], 0, '.', ',') .'</td>';
	echo "</tr>";	
}
echo "</table>";
echo "<br>Ex-Member<br><br>";
echo "<table border=1 cellspacing=0>
	<tr>
		<th". ($order == 'Name' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Name'>Name</A></th>
		<th". ($order == 'EXPT' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=EXPT'>XP</A></th>
		<th". ($order == 'Money' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Money'>Money</A></th>
		<th". ($order == 'Jade' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Jade'>Jade</A></th>
		<th". ($order == 'Gems' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Gems'>Gems</A></th>
		<th". ($order == 'Food' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Food'>Food</A></th>
		<th". ($order == 'Iron' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Iron'>Iron</A></th>
		<th". ($order == 'Stone' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Stone'>Stone</A></th>
		<th". ($order == 'Lumber' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=Lumber'>Lumber</A></th>
		<th". ($order == 'GDPT' ? ' class="active"' : '') ."><A HREF='index.php?x=gtable&order=GDPT'>Guild DP</A></th>
		<th". ($order == 'GDPSpent' ? ' class="active"' : '') ."><a href='/?x=gtable&order=GDPSpent'>GDP Spent</a></th>
		<th". ($order == 'RPGained' ? ' class="active"' : '') ."><a href='/?x=gtable&order=RPGained'>RP Gained</a></th>
	</tr>
";
if($order == "Name"){
	$q = mysqli_query($link, "SELECT *, (EXP + PreviousXP) AS EXPT, (GDP + GDPPrevious) AS GDPT FROM Userliste WHERE Active = '1' ORDER BY $order ASC;");
}else{
	$q = mysqli_query($link, "SELECT *, (EXP + PreviousXP) AS EXPT, (GDP + GDPPrevious) AS GDPT FROM Userliste WHERE Active = '1' ORDER BY $order DESC;");
}
while($row = mysqli_fetch_array($q)){
	echo "<tr>";
	echo "<td><A HREF='index.php?x=user&name=" . $row["Name"] . "'>" . $row["Name"] . "</A></td>";
	echo "<td>" . number_format($row["EXPT"], 0, ".", ",") . "</td>";
	echo "<td>" . MoneyConvert($row["Money"]) . "</td>";
	echo "<td>" . number_format($row["Jade"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Gems"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Food"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Iron"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Stone"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["Lumber"], 0, ".", ",") . "</td>";
	echo "<td>" . number_format($row["GDPT"], 0, ".", ",") . "</td>";
	echo "<td>". number_format($row['GDPSpent'], 0, '.', ',') ."</td>";
	echo "<td>". number_format($row['RPGained'], 0, '.', ',') .'</td>';
	echo "</tr>";	
}
echo "</table>";
?>
