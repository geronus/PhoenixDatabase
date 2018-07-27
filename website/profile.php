<?php
echo "<table witdth=100%><tr<td><form action='index.php?x=profilesave' method='post'>";
echo "Member: <select name='name'>";
echo "<option selected value='-'>-</option>";
$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Active LIKE '0' ORDER BY Name;");
while($row = mysqli_fetch_array($q)){
	echo "<option value='" . $row["Name"] . "'>" . $row["Name"] . "</option>";
}
echo "</select><br>";
echo "<br>";
echo "<textarea name='data' cols'40' rows='10'></textarea></br>";
echo "<input type='submit' value='Senden'></form></td>";
echo "<td>How to:<br><br>1. Open Profile of User<br>2. Copy marked area (Screenshot)<br><img src='profil.png'><br>3. Choose Name from Dropdown<br>4. Insert copied text<br>5. Send</td></tr></table>";
echo "</body>";
?>
