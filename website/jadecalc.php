<?php
$chcg = $_POST["chcg"];
$chdg = $_POST["chdg"];
$chdg = $chdg - 50;
$herog = $_POST["herog"];
$leaderg = $_POST["leaderg"];
$archg = $_POST["archg"];
$jewelg = $_POST["jewelg"];
$peeng = $_POST["peeng"];
$name = $_POST["name"];
$plat = $_POST["plat"];
$gold = $_POST["gold"];
$silver = $_POST["silver"];
$copper = $_POST["copper"];

$chcc = 0;
$chdc = 0;
$heroc = 0;
$leaderc = 0;
$archc = 0;
$jewelc = 0;
$peenc = 0;

$joaj = 0;

$chcglvl = $chcg * 10;
$chdglvl = $chdg * 10;
$heroglvl = $herog * 4;
$leaderglvl = $leaderg;
$archglvl = $archg;
$jewelglvl = $jewelg;
$peenglvl = $peeng * 100;

$chcclvl = 0;
$chdclvl = 0;
$heroclvl = 0;
$leaderclvl = 0;
$archclvl = 0;
$jewelclvl = 0;
$peenclvl = 0;

$chcp = 0;
$chdp = 0;
$herop = 0;
$leaderp = 0;
$archp = 0;
$jewelp = 0;
$peenp = 0;

$chcpp = 0;
$chdpp = 0;
$heropp = 0;
$leaderpp = 0;
$archpp = 0;
$jewelpp = 0;
$peenpp = 0;

if($plat == ""){
	$plat = 0;
}
if($gold == ""){
	$gold = 0;
}
if($silver == ""){
	$silver = 0;
}
if($copper == ""){
	$copper = 0;
}
$jadeprice = ($plat * 1000000) + ($gold * 10000) + ($silver * 100) + $copper;

if($name != ""){
	$q = mysqli_query($link, "SELECT * FROM Boosts WHERE Name LIKE '$name';");
	while($row = mysqli_fetch_array($q)){
		$chcc = $row["CHitC"];
		$chdc = $row["CHitD"];
		$chdc = $chdc - 50;
		$heroc = $row["Hero"];
		$leaderc = $row["Leader"];
		$archc = $row["Arch"];
		$jewelc = $row["Craft"];
		$peenc = $row["Peen"];
		$joaj = $row["Jade"];
		if(isset($_POST["cpromo"])){
			$joaj = $joaj +10;
		}
		$joaj = (100 - $joaj) / 100;
		
		$chcclvl = $chcc * 10;
		$chdclvl = $chdc * 10;
		$heroclvl = $heroc * 4;
		$leaderclvl = $leaderc;
		$archclvl = $archc;
		$jewelclvl = $jewelc;
		$peenclvl = $peenc * 100;	
	}
	
	if($chcg > $chcc){
		$chcp = round(((($chcglvl * ($chcglvl+1))/2) - (($chcclvl * ($chcclvl +1))/2)) * 5 * $joaj);
		$chcpp = $chcp * $jadeprice;
	}
	if($chdg > $chdc){
		$chdp = round(((($chdglvl * ($chdglvl+1))/2) - (($chdclvl * ($chdclvl +1))/2)) * 5 * $joaj);
		$chdpp = $chdp * $jadeprice;
	}
	if($herog > $heroc){
		$herop = round(((($heroglvl * ($heroglvl+1))/2) - (($heroclvl * ($heroclvl +1))/2)) * 5 * $joaj);
		$heropp = $herop * $jadeprice;
	}
	if($leaderg > $leaderc){
		$leaderp = round(((($leaderglvl * ($leaderglvl+1))/2) - (($leaderclvl * ($leaderclvl +1))/2)) * 5 * $joaj);
		$leaderpp = $leaderp * $jadeprice;
	}
	if($archg > $archc){
		$archp = round(((($archglvl * ($archglvl+1))/2) - (($archclvl * ($archclvl +1))/2)) * 5 * $joaj);
		$archpp = $archp * $jadeprice;
	}
	if($jewelg > $jewelc){
		$jewelp = round(((($jewelglvl * ($jewelglvl+1))/2) - (($jewelclvl * ($jewelclvl +1))/2)) * 5 * $joaj);
		$jewelpp = $jewelp * $jadeprice;
	}
	if($peeng > $peenc){
		$peenp = round(((($peenglvl * ($peenglvl+1))/2) - (($peenclvl * ($peenclvl +1))/2)) * 5 * $joaj);
		$peenpp = $peenp * $jadeprice;
	}
}
echo "
<form action='index.php?x=jadecalc' method='post'>
<table border='0' cellspacing=0 class='input'>
	<tr>
		<th colspan='2'>
			Member: <select name='name'>
";

$q = mysqli_query($link, "SELECT * FROM Userliste WHERE Level > '0' AND Active LIKE '0' ORDER BY Name;");
while($row = mysqli_fetch_array($q)){
	if($name == $row["Name"]){
		echo "<option selected value='" . $row["Name"] . "'>" . $row["Name"] . "</option>";
	}else{
		echo "<option value='" . $row["Name"] . "'>" . $row["Name"] . "</option>";
	}
}
echo "
			</select>
		</th>
		<th colspan=3>
			Jade Price
			<input type='text' size='1' name='plat' value='" . $plat . "'>p
			<input type='text' size='1' name='gold' value='" . $gold . "'>g
			<input type='text' size='1' name='silver' value='" . $silver . "'>s
			<input type='text' size='1' name='copper' value='" . $copper . "'>c
		</th>
	</tr>
	<tr>
		<th colspan=2>Current Level</th>
		<th>Goal</th>
		<th>Jade Price</th>
		<th>Plat Price</th>
	</tr>
	<tr>
		<td>C. Hit Chance</td>
		<td>" . $chcc . "%</td>
		<td><input type='text' size='5' name='chcg' value='" . $chcg . "'>%</td>
		<td>" . number_format($chcp, 0, ".", ",") . "</td>
		<td>" . MoneyConvert($chcpp) . "</td>
	</tr>
	<tr>
		<td>C. Hit Damage</td>
		<td>" . ($chdc+50) . "%</td>
		<td><input type='text' size='5' name='chdg' value='" . ($chdg+50) . "'>%</td>
		<td>" . number_format($chdp, 0, ".", ",") . "</td>
		<td>" . MoneyConvert($chdpp) . "</td>
	</tr>
	<tr>
		<td>Heroism</td>
		<td>" . $heroc . "%</td>
		<td><input type='text' size='5' name='herog' value='" . $herog . "'>%</td>
		<td>" . number_format($herop, 0, ".", ",") . "</td>
		<td>" . MoneyConvert($heropp) . "</td>
	</tr>
	<tr>
		<td>Leadership</td>
		<td>" . $leaderc . "%</td>
		<td><input type='text' size='5' name='leaderg' value='" . $leaderg . "'>%</td>
		<td>" . number_format($leaderp, 0, ".", ",") . "</td>
		<td>" . MoneyConvert($leaderpp) . "</td>
	</tr>
	<tr>
		<td>Archeaology</td>
		<td>" . $archc . "%</td>
		<td><input type='text' size='5' name='archg' value='" . $archg . "'>%</td>
		<td>" . number_format($archp, 0, ".", ",") . "</td>
		<td>" . MoneyConvert($archpp) . "</td>
	</tr>
	<tr>
		<td>Jewelcrafting</td>
		<td>" . $jewelc . "%</td>
		<td><input type='text' size='5' name='jewelg' value='" . $jewelg . "'>%</td>
		<td>" . number_format($jewelp, 0, ".", ",") . "</td>
		<td>" . MoneyConvert($jewelpp) . "</td>
	</tr>
	<tr>
		<td>E-Peen</td>
		<td>" . $peenc . " Inches</td>
		<td><input type='text' size='5' name='peeng' value='" . $peeng . "'>Inches</td>
		<td>" . number_format($peenp, 0, ".", ",") . "</td>
		<td>" . MoneyConvert($peenpp) . "</td>
	</tr>
";
$checked = (isset($_POST['cpromo']) ? ' checked' : '');
echo "
	<tr>
		<td colspan='4' align='center'>
			Christmas Promo: <input type='checkbox' name='cpromo' value='cpromo'$checked>
		</td>
		<td align='center'>
			<input type='submit' value='Send'>
			</form>
		</td>
	</tr>
</table><br>
Current Jade Skills and Jack of All Jade-Boost will be pulled from the database.<br>
For correct numbers update your Jade Skills and Token Boosts before calculating.
";
