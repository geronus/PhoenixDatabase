<?php
echo "<table border=1 cellspacing=0><tr>
	<th". ($order == 'Name' ? ' class="active"' : '') ."><A HREF='index.php?x=jtable&order=Name'>Name</A></th>
	<th". ($order == 'CHitC' ? ' class="active"' : '') ."><A HREF='index.php?x=jtable&order=CHitC'>Crit. Chance</A></th>
	<th". ($order == 'CHitD' ? ' class="active"' : '') ."><A HREF='index.php?x=jtable&order=CHitD'>Crit. Damage</A></th>
	<th". ($order == 'Hero' ? ' class="active"' : '') ."><A HREF='index.php?x=jtable&order=Hero'>Heroism</A></th>
	<th". ($order == 'Leader' ? ' class="active"' : '') ."><A HREF='index.php?x=jtable&order=Leader'>Leadership</A></th>
	<th". ($order == 'Arch' ? ' class="active"' : '') ."><A HREF='index.php?x=jtable&order=Arch'>Archaeology</A></th>
	<th". ($order == 'Craft' ? ' class="active"' : '') ."><A HREF='index.php?x=jtable&order=Craft'>Jewelcrafting</A></th>
	<th". ($order == 'Seren' ? ' class="active"' : '') ."><a href='/?x=jtable&order=Seren'>Serendipity</a></th>
	<th". ($order == 'Peen' ? ' class="active"' : '') ."><A HREF='index.php?x=jtable&order=Peen'>E-Peen</A></th>
	</tr>";
$order = (isset($_GET['order']) ? $_GET['order'] : '');
if($order == ""){
	$order = "CHitD";
}
if($order == "Name"){
	$q = mysqli_query($link, "SELECT Boosts.*, `us`.`Active` FROM Boosts Boosts LEFT JOIN Userliste `us` ON Boosts.Name = `us`.Name WHERE `us`.Active = 0 ORDER BY $order ASC;");
}elseif($order != ""){
	$q = mysqli_query($link, "SELECT Boosts.*, `us`.`Active` FROM Boosts Boosts LEFT JOIN Userliste `us` ON Boosts.Name = `us`.Name WHERE `us`.Active = 0 ORDER BY $order DESC;");
}
while($row = mysqli_fetch_array($q)){
	echo "<tr>";
	if($row["Active"] == 1){
		echo "<td><A HREF='index.php?x=user&name=" . $row["Name"] . "'>" . $row["Name"] . "*</A></td>";
	}else{
		echo "<td><A HREF='index.php?x=user&name=" . $row["Name"] . "'>" . $row["Name"] . "</A></td>";
	}
	echo "<td>" . number_format($row["CHitC"], 1, ".", ",") . "%</td>";
	echo "<td>" . number_format($row["CHitD"], 1, ".", ",") . "%</td>";
	echo "<td>" . number_format($row["Hero"], 2, ".", ",") . "%</td>";
	echo "<td>" . number_format($row["Leader"], 0, ".", ",") . "%</td>";
	echo "<td>" . number_format($row["Arch"], 0, ".", ",") . "%</td>";
	echo "<td>" . number_format($row["Craft"], 0, ".", ",") . "%</td>";
	echo "<td>". number_format($row["Seren"], 2, '.', ',') . " lvl bonus</td>";
	echo "<td>" . number_format($row["Peen"], 2, ".", ",") . " Inch</td>";
	echo "</tr>";	
}
echo "</table>";