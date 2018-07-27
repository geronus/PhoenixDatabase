<?php
include("connection.php");
function addTickets($aname, $aweek, $anr){
	$highestnumber = 0;
	$output = "";
	if($aname != "-"){
		if($anr != ""){
			$q = mysqli_query($link, "SELECT Number FROM Weekly WHERE Week LIKE '$aweek' ORDER BY Number DESC LIMIT 1;");
			while($row = mysqli_fetch_array($q)){
				$highestnumber = $row['Number'];
			}
			for($i = 1; $i <= $anr; $i++){
				$highestnumber = $highestnumber+1;
				mysqli_query($link, "INSERT INTO `Weekly` (`Week`, `Name`, `Number`) VALUES ('$aweek', '$aname', '$highestnumber');");
				$output = $output . "Added Number " . $highestnumber . " in week " . $aweek . " for " . $aname . "<br>";
			}
		}
	}
	return "". $output;
}
echo "<HTML><HEAD><TITLE>Phoenix Lab</TITLE></HEAD><link rel='stylesheet' type='text/css' href='http://necromancers.web44.net/necro.css' /><BODY>";
$currentweek = date("W");
$currentyear = date("Y");
$drawing = $_POST['drawing'];
$winnernr = $_POST['winnernr'];
$winner = "";

$tname = $_POST['tname'];
$tweek1 = $_POST['tweek1'];
$tweek2 = $_POST['tweek2'];
$tweek3 = $_POST['tweek3'];
$tweek4 = $_POST['tweek4'];
$tweek5 = $_POST['tweek5'];
$tnr1 = $_POST['tnr1'];
$tnr2 = $_POST['tnr2'];
$tnr3 = $_POST['tnr3'];
$tnr4 = $_POST['tnr4'];
$tnr5 = $_POST['tnr5'];

$output = addTickets($tname, $tweek1, $tnr1);
$output = $output . addTickets($tname, $tweek2, $tnr2);
$output = $output . addTickets($tname, $tweek3, $tnr3);
$output = $output . addTickets($tname, $tweek4, $tnr4);
$output = $output . addTickets($tname, $tweek5, $tnr5);

echo "<form action='manageweekly.php' method='post'>";
echo "<table><tr><td align=center>Assign Winning Number</td></tr>";
echo "<tr><td align=center>Drawing:</td><td>";
echo "<select name='drawing'>";

echo "<option selected value='" . $currentyear . "-" . $currentweek . "'>" . $currentyear . "-" . $currentweek . " Current" . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("-2 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("-2 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("-3 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("-3 Week")) . "</option>";


echo "</select></td></tr><tr><td>Winning Number:</td><td>";
echo "<input type='text' size='5' name='winnernr'>";
echo "</td></tr><tr><td><input type='submit' value='Show Winner'></form></tr></table>";
if($winnernr != ""){
	$q = mysqli_query($link, "SELECT * FROM Weekly WHERE Number LIKE '$winnernr' AND Week LIKE '$drawing';");
	while($row = mysqli_fetch_array($q)){
		$winner = $row['Name'];
		mysqli_query($link, "INSERT INTO `WeeklyWinners` (`Week`, `Winner`, `WinningNumber`) VALUES ('$drawing', '$winner', '$winnernr');");
		echo "<table><tr><td width='100%' align=center>And the winner is " . $winner . "!</td></tr></table>";
	}
}
echo "<br><br><br><br><br>";
echo "<form action='manageweekly.php' method='post'>";
echo "<table><tr><td colspan='2' align=center>Add tickets</td></tr>";
echo "<tr><td colspan='2' align=center>Name: <select name='tname'>";
echo "<option selected value='-'>-</option>";
$q = mysqli_query($link, "SELECT Name FROM Userliste ORDER BY Name;");
while($row = mysqli_fetch_array($q)){
	echo "<option value='" . $row['Name'] . "'>" . $row['Name'] . "</option>";
}
echo "</select></td></tr>";
echo "<tr><td>Week</td><td>Nr of Tickets</td></tr>";
echo "<tr><td><select name='tweek1'>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "</option>";
echo "<option selected value='" . $currentyear . "-" . $currentweek . "'>" . $currentyear . "-" . $currentweek . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "</option>";
echo "</select></td><td><input type='text' size='5' name='tnr1'></td></tr>";

echo "<tr><td><select name='tweek2'>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "</option>";
echo "<option selected value='" . $currentyear . "-" . $currentweek . "'>" . $currentyear . "-" . $currentweek . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "</option>";
echo "</select></td><td><input type='text' size='5' name='tnr2'></td></tr>";

echo "<tr><td><select name='tweek3'>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "</option>";
echo "<option selected value='" . $currentyear . "-" . $currentweek . "'>" . $currentyear . "-" . $currentweek . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "</option>";
echo "</select></td><td><input type='text' size='5' name='tnr3'></td></tr>";

echo "<tr><td><select name='tweek4'>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "</option>";
echo "<option selected value='" . $currentyear . "-" . $currentweek . "'>" . $currentyear . "-" . $currentweek . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "</option>";
echo "</select></td><td><input type='text' size='5' name='tnr4'></td></tr>";

echo "<tr><td><select name='tweek45>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("-1 Week")) . "</option>";
echo "<option selected value='" . $currentyear . "-" . $currentweek . "'>" . $currentyear . "-" . $currentweek . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+1 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+2 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+3 Week")) . "</option>";
echo "<option value='" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "'>" . $currentyear . "-" . date("W", strtotime("+4 Week")) . "</option>";
echo "</select></td><td><input type='text' size='5' name='tnr5'></td></tr>";
echo "<tr><td colspan='2' align=center><input type='submit' value='Add Tickets'></form></tr>";
echo "</table>";
echo "<table><tr><td width='100%' align=center>" . $output . "</td></tr></table>";



echo "</body>";
?>
