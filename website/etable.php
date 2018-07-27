<?php
$q = "";
echo "<table border=1 cellspacing=0><tr>
	<th". ($order == 'Name' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=Name'>Name</A></th>
	<th". ($order == 'W1' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=W1'>W1</A></th>
	<th". ($order == 'W2' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=W2'>W2</A></th>
	<th". ($order == 'A1' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=A1'>A1</A></th>
	<th". ($order == 'A2' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=A2'>A2</A></th>
	<th". ($order == 'A3' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=A3'>A3</A></th>
	<th". ($order == 'A4' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=A4'>A4</A></th>
	<th". ($order == 'A5' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=A5'>A5</A></th>
	<th". ($order == 'A6' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=A6'>A6</A></th>
	<th". ($order == 'A7' ? ' class="active"' : '') ."><A HREF='index.php?x=etable&order=A7'>A7</A></th>
	</tr>";

if($order == "Name"){
	$q = mysqli_query($link, "SELECT Equip.* FROM Equip Equip LEFT JOIN Userliste `us` ON Equip.Name = `us`.Name WHERE `us`.Active = 0 ORDER BY $order ASC;");
}else{
	$q = mysqli_query($link, "SELECT Equip.* FROM Equip Equip LEFT JOIN Userliste `us` ON Equip.Name = `us`.Name WHERE `us`.Active = 0 ORDER BY $order DESC;");
}
while($row = mysqli_fetch_array($q)){
	echo "<tr>";
	echo "<td><A HREF='index.php?x=user&name=" . $row["Name"] . "'>" . $row["Name"] . "</A></td>";
	echo "<td>" . $row['W1'] . "</td><td>" . $row['W2'] . "</td><td>" . $row['A1'] . "</td><td>" . $row['A2'] . "</td><td>" . $row['A3'] . "</td><td>" . $row['A4'] . "</td><td>" . $row['A5'] . "</td><td>" . $row['A6'] . "</td><td>" . $row['A7'] . "</td>";
	echo "</tr>";	
}
echo "</table>";
?>
