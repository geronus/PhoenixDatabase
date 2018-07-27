<?php
$name = $_POST["name"];
echo "Name: " . $name . "<br><br>";
$data = trim($_POST['data']);

$separator = (
	strpos($data, "\r\n\r\n") !== false ? "\r\n\r\n" : (
		strpos($data, "\r\n") !== false ? "\r\n" : (
			strpos($data, "\n\n") !== false ? "\n\n" : "\n"
		)
	)
);

$data = explode($separator, str_replace('[', '', str_replace(']','', $data)));

if ($data[0] == 'Equipment')
	array_shift($data);

if (strpos($data[0], 'Shortsword') === false) {
	error_log(json_encode($data), 4);
	echo "Copy paste error. try again.";
	exit;
}

$data = array_slice($data, 0, 9);

if($name != "-"){
	if(count($data) == 9){
		$w1 = explode(" ", $data[0]);
		$w1 = $w1[1];
		$w2 = explode(" ", $data[1]);
		$w2 = $w2[1];
		$a1 = explode(" ", $data[2]);
		$a1 = $a1[1];
		$a2 = explode(" ", $data[3]);
		$a2 = $a2[1];
		$a3 = explode(" ", $data[4]);
		$a3 = $a3[1];
		$a4 = explode(" ", $data[5]);
		$a4 = $a4[1];
		$a5 = explode(" ", $data[6]);
		$a5 = $a5[1];
		$a6 = explode(" ", $data[7]);
		$a6 = $a6[1];
		$a7 = explode(" ", $data[8]);
		$a7 = $a7[1];
		echo "W1: " . $w1 . "<br>";
		echo "W2: " . $w2 . "<br>";
		echo "A1: " . $a1 . "<br>";
		echo "A2: " . $a2 . "<br>";
		echo "A3: " . $a3 . "<br>";
		echo "A4: " . $a4 . "<br>";
		echo "A5: " . $a5 . "<br>";
		echo "A6: " . $a6 . "<br>";
		echo "A7: " . $a7 . "<br>";
		date_default_timezone_set("Europe/London");
		$datum = date("Y-m-d");
		$updatetime = date("Y-m-d H:i:s");
		mysqli_query($link, "INSERT INTO Equip (`Name`, `W1`, `W2`, `A1`, `A2`, `A3`, `A4`, `A5`, `A6`, `A7`, `Updates`) VALUES ('$name', '$w1', '$w2', '$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '0000-00-00 00:00:00');");
		mysqli_query($link, "UPDATE Equip SET Name = '$name', W1 = '$w1', W2 = '$w2', A1 = '$a1', A2 = '$a2', A3 = '$a3', A4 = '$a4', A5 = '$a5', A6 = '$a6', A7 = '$a7', Updates = '$updatetime' WHERE Name LIKE '$name';");
		
	}else{
		echo "Error: Wrong text copied.";
	}
}else{
	echo "Error: Choose a name.";
}
