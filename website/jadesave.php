<?php
$name = $_POST["name"];
echo "Name: " . $name . "<br>";
$eingabe = str_replace(',', '', $_POST["eingabe"]);
$eingabe = explode("%", $eingabe);

$chc = trim($eingabe[0]);
$chd = trim($eingabe[1]);
$hero = trim($eingabe[2]);
$leader = trim($eingabe[3]);
$arch = trim($eingabe[4]);
$jewel = trim($eingabe[5]);

$the_rest = explode(':', $eingabe[6]);
$seren = trim(explode(' level bonus', $the_rest[1])[0]);
$peen = trim(explode(' inches', $the_rest[2])[0]);

$chc = explode(" ", $chc);
$count = count($chc) - 1;
$chc = $chc[$count];

$chd = explode(" ", $chd);
$count = count($chd) - 1;
$chd = $chd[$count];

$hero = explode(" ", $hero);
$count = count($hero) - 1;
$hero = $hero[$count];

$leader = explode(" ", $leader);
$count = count($leader) - 1;
$leader = $leader[$count];

$arch = explode(" ", $arch);
$count = count($arch) - 1;
$arch = $arch[$count];

$jewel = explode(" ", $jewel);
$count = count($jewel) - 1;
$jewel = $jewel[$count];

echo "CHC: " . $chc . "%<br>";
echo "CHD: " . $chd . "%<br>";
echo "Hero: " . $hero . "%<br>";
echo "Leader: " . $leader . "%<br>";
echo "Arch: " . $arch . "%<br>";
echo "Jewel: " . $jewel . "%<br>";
echo "Serendipity: $seren%<br />";
echo "Peen: " . $peen . " Inches<br>";

mysqli_query($link, "
	INSERT INTO Boosts (CHitC, CHitD, Hero, Leader, Arch, Seren, Craft, Peen, Name)
	VALUES ('$chc', '$chd', '$hero', '$leader', '$arch', '$seren', '$jewel', '$peen', '$name')
	ON DUPLICATE KEY UPDATE 
		`CHitC`=VALUES(`CHitC`),
		`CHitD`=VALUES(`CHitD`),
		`Hero`=VALUES(`Hero`),
		`Leader`=VALUES(`Leader`),
		`Arch`=VALUES(`Arch`),
		`Seren`=VALUES(`Seren`),
		`Craft`=VALUES(`Craft`),
		`Peen`=VALUES(`Peen`)
");
mysqli_query($link, "UPDATE Userliste SET JadeUpdate = NOW() WHERE Name LIKE '$name';");