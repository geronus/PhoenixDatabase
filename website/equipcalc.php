<?php
$pw1 = 0;
$pw2 = 0;
$pa1 = 0;
$pa2 = 0;
$pa3 = 0;
$pa4 = 0;
$pa5 = 0;
$pa6 = 0;
$pa7 = 0;
$w1c = $w2c = $a1c = $a2c = $a3c = $a4c = $a5c = $a6c = $a7c = 0;
$w1g = $w2g = $a1g = $a2g = $a3g = $a4g = $a5g = $a6g = $a7g = 0;
$pw1 = $pw2 = $pa1 = $pa2 = $pa3 = $pa4 = $pa5 = $pa6 = $pa7 = 0;
if($bs == ""){
	$q = mysqli_query($link, "SELECT * FROM Guild WHERE Guildname LIKE 'Phoenix';");
	while($row = mysqli_fetch_array($q)){
		$bs = $row["BlackSmith"];	
	}
}

if (is_array($_POST) && count($_POST) > 0) {
	$w1c = $_POST["w1c"];
	$w2c = $_POST["w2c"];
	$a1c = $_POST["a1c"];
	$a2c = $_POST["a2c"];
	$a3c = $_POST["a3c"];
	$a4c = $_POST["a4c"];
	$a5c = $_POST["a5c"];
	$a6c = $_POST["a6c"];
	$a7c = $_POST["a7c"];

	$w1g = $_POST["w1g"];
	$w2g = $_POST["w2g"];
	$a1g = $_POST["a1g"];
	$a2g = $_POST["a2g"];
	$a3g = $_POST["a3g"];
	$a4g = $_POST["a4g"];
	$a5g = $_POST["a5g"];
	$a6g = $_POST["a6g"];
	$a7g = $_POST["a7g"];

	$bs2 = $_POST["bs"];
	if ($bs2 != $bs)
		$bs = $bs2;

	$bargain = (100 - $bs) /  100;

	$q = mysqli_query($link, "SELECT SUM(Cost) AS Cost FROM Equipment WHERE Level > '$w1c' AND Level <= '$w1g';");
	while($row = mysqli_fetch_array($q)){
		$pw1 = $row["Cost"] * $bargain;
	}
	$q = mysqli_query($link, "SELECT SUM(Cost) AS Cost FROM Equipment WHERE Level > '$w2c' AND Level <= '$w2g';");
	while($row = mysqli_fetch_array($q)){
		$pw2 = $row["Cost"] * $bargain;	
	}
	$q = mysqli_query($link, "SELECT SUM(Cost) AS Cost FROM Equipment WHERE Level > '$a1c' AND Level <= '$a1g';");
	while($row = mysqli_fetch_array($q)){
		$pa1 = $row["Cost"] * $bargain;	
	}
	$q = mysqli_query($link, "SELECT SUM(Cost) AS Cost FROM Equipment WHERE Level > '$a2c' AND Level <= '$a2g';");
	while($row = mysqli_fetch_array($q)){
		$pa2 = $row["Cost"] * $bargain;	
	}
	$q = mysqli_query($link, "SELECT SUM(Cost) AS Cost FROM Equipment WHERE Level > '$a3c' AND Level <= '$a3g';");
	while($row = mysqli_fetch_array($q)){
		$pa3 = $row["Cost"] * $bargain;	
	}
	$q = mysqli_query($link, "SELECT SUM(Cost) AS Cost FROM Equipment WHERE Level > '$a4c' AND Level <= '$a4g';");
	while($row = mysqli_fetch_array($q)){
		$pa4 = $row["Cost"] * $bargain;	
	}
	$q = mysqli_query($link, "SELECT SUM(Cost) AS Cost FROM Equipment WHERE Level > '$a5c' AND Level <= '$a5g';");
	while($row = mysqli_fetch_array($q)){
		$pa5 = $row["Cost"] * $bargain;	
	}
	$q = mysqli_query($link, "SELECT SUM(Cost) AS Cost FROM Equipment WHERE Level > '$a6c' AND Level <= '$a6g';");
	while($row = mysqli_fetch_array($q)){
		$pa6 = $row["Cost"] * $bargain;	
	}
	$q = mysqli_query($link, "SELECT SUM(Cost) AS Cost FROM Equipment WHERE Level > '$a7c' AND Level <= '$a7g';");
	while($row = mysqli_fetch_array($q)){
		$pa7 = $row["Cost"] * $bargain;	
	}
}

$sum = $pw1 + $pw2 + $pa1 + $pa2 + $pa3 + $pa4 + $pa5 + $pa6 + $pa7;

echo "
<form action='index.php?x=equipcalc' method='post'>
<table border='0' cellspacing=0 class='input'>
	<tr>
		<th>Current Level</td>
		<th>Goal</td>
		<th>Prices</td>
	</tr>
	<tr>
		<td>W1 <input type='text' size='5' name='w1c' value='" . $w1c . "'></td>
		<td><input type='text' size='5' name='w1g' value='" . $w1g . "'></td>
		<td>" . MoneyConvert($pw1) . "</td>
	</tr>
	<tr>
		<td>W2 <input type='text' size='5' name='w2c' value='" . $w2c . "'></td>
		<td><input type='text' size='5' name='w2g' value='" . $w2g . "'></td>
		<td>" . MoneyConvert($pw2) . "</td>
	</tr>
	<tr>
		<td>A1 <input type='text' size='5' name='a1c' value='" . $a1c . "'></td>
		<td><input type='text' size='5' name='a1g' value='" . $a1g . "'></td>
		<td>" . MoneyConvert($pa1) . "</td>
	</tr>
	<tr>
		<td>A2 <input type='text' size='5' name='a2c' value='" . $a2c . "'></td>
		<td><input type='text' size='5' name='a2g' value='" . $a2g . "'></td>
		<td>" . MoneyConvert($pa2) . "</td>
	</tr>
	<tr>
		<td>A3 <input type='text' size='5' name='a3c' value='" . $a3c . "'></td>
		<td><input type='text' size='5' name='a3g' value='" . $a3g . "'></td>
		<td>" . MoneyConvert($pa3) . "</td>
	</tr>
	<tr>
		<td>A4 <input type='text' size='5' name='a4c' value='" . $a4c . "'></td>
		<td><input type='text' size='5' name='a4g' value='" . $a4g . "'></td>
		<td>" . MoneyConvert($pa4) . "</td>
	</tr>
	<tr>
		<td>A5 <input type='text' size='5' name='a5c' value='" . $a5c . "'></td>
		<td><input type='text' size='5' name='a5g' value='" . $a5g . "'></td>
		<td>" . MoneyConvert($pa5) . "</td>
	</tr>
	<tr>
		<td>A6 <input type='text' size='5' name='a6c' value='" . $a6c . "'></td>
		<td><input type='text' size='5' name='a6g' value='" . $a6g . "'></td>
		<td>" . MoneyConvert($pa6) . "</td>
	</tr>
	<tr>
		<td>A7 <input type='text' size='5' name='a7c' value='" . $a7c . "'></td>
		<td><input type='text' size='5' name='a7g' value='" . $a7g . "'></td>
		<td>" . MoneyConvert($pa7) . "</td>
	</tr>
	<tr>
		<td colspan='2'>Blacksmith Level: <select name='bs'>
";
for($i = 0; $i <= 50; $i++){
	if($i == $bs){
		echo "<option selected value='" . $i . "'>" . $i . "</option>";
	}else{
		echo "<option value='" . $i . "'>" . $i . "</option>";
	}
}
echo "
			</select>
		</td>
		<td>
			Sum: " . MoneyConvert($sum) . "
		</td>
	</tr>
	<tr>
		<td colspan='3' align='center'>
			<input type='submit' value='Send'>
			</form>
		</td>
	</tr>
</table>";
