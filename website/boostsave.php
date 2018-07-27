<?php
$name = $_POST["name"];
echo "Name: " . $name .'<br />';
$eingabe = $_POST["eingabe"];
$eingabe = str_replace("+1%", "", $eingabe);
$eingabe = str_replace("+10%", "", $eingabe);
$eingabe = str_replace("+100%", "", $eingabe);
$eingabe = str_replace("&#39;", "'", $eingabe);
$eingabe = explode("%", $eingabe);
$gold = $eingabe[0];
$xp = $eingabe[1];
$stat = $eingabe[2];
$quest = $eingabe[3];
$global = $eingabe[4];
$health = $eingabe[5];
$attack = $eingabe[6];
$def = $eingabe[7];
$acc = $eingabe[8];
$eva = $eingabe[9];
$jade = $eingabe[10];
$dungeon = $eingabe[11];
$boss = $eingabe[12];
$rest = $eingabe[13];

$gold = explode("Gold Boost:", $gold);
$count = count($gold) - 1;
$gold = $gold[$count];
$gold = str_replace("/500", "", $gold);

$xp = explode("Experience Boost:", $xp);
$count = count($xp) - 1;
$xp = $xp[$count];
$xp = trim(str_replace("/500", "", $xp));

$stat = explode("Stat Drop Boost:", $stat);
$count = count($stat) - 1;
$stat = $stat[$count];
$stat = trim(str_replace("/500", "", $stat));

$quest = explode("Quest Boost:", $quest);
$count = count($quest) - 1;
$quest = $quest[$count];
$quest = trim(str_replace("/500", "", $quest));

$global = explode("Global Drop Boost:", $global);
$count = count($global) - 1;
$global = $global[$count];
$global = trim(str_replace("/500", "", $global));

$health = explode("Health Boost:", $health);
$count = count($health) - 1;
$health = $health[$count];
$health = trim(str_replace("/50", "", $health));

$attack = explode("Attack Boost:", $attack);
$count = count($attack) - 1;
$attack = $attack[$count];
$attack = trim(str_replace("/50", "", $attack));

$def = explode("Defence Boost:", $def);
$count = count($def) - 1;
$def = $def[$count];
$def = trim(str_replace("/50", "", $def));

$acc = explode("Accuracy Boost:", $acc);
$count = count($acc) - 1;
$acc = $acc[$count];
$acc = trim(str_replace("/25", "", $acc));

$eva = explode("Evasion Boost:", $eva);
$count = count($eva) - 1;
$eva = $eva[$count];
$eva = trim(str_replace("/25", "", $eva));

$jade = explode("Jack of All Jades:", $jade);
$count = count($jade) - 1;
$jade = $jade[$count];
$jade = trim(str_replace("/50", "", $jade));

$dungeon = explode("Dungeon Mastery:", $dungeon);
$count = count($dungeon) - 1;
$dungeon = $dungeon[$count];
$dungeon = trim(str_replace("/50", "", $dungeon));


$boss = explode("Areaboss Taxonomy'n Taxidermy:", $boss);
$count = count($boss) - 1;
$boss = $boss[$count];
$boss = trim(str_replace('/50', '', $boss));

$rest = explode("+1 for", $rest);
$auto = $rest[0];
$jewelry = $rest[1];

$auto = explode("Autos:", $auto);
$auto = trim($auto[1]);
$auto = explode(" ", $auto);
$auto = $auto[0];

$jewelry = explode("Jewellery Slots:", $jewelry);
$jewelry = trim($jewelry[1]);
$jewelry = explode("\n", $jewelry);
$jewelry = explode(" ", $jewelry[0]);
$jewelry = trim(str_replace("/10", "", $jewelry[0]));

// $tradeskill = explode("Tradeskill Slots:", $rest[2]);
// $tradeskill = trim($tradeskill[1]);

echo "Gold: " . $gold . "%<br>";
echo "XP: " . $xp . "%<br>";
echo "Stat: " . $stat . "%<br>";
echo "Quest: " . $quest . "%<br>";
echo "Global: " . $global . "%<br>";
echo "Health: " . $health . "%<br>";
echo "Attack: " . $attack . "%<br>";
echo "Defence: " . $def . "%<br>";
echo "Accuracy: " . $acc . "%<br>";
echo "Evasion: " . $eva . "%<br>";
echo "Jade: " . $jade . "%<br>";
echo "Dungeon: " . $dungeon . "%<br>";
echo "Taxidermy: ". $boss ."%<br />";
echo "Autos: " . $auto . "<br>";
echo "Jewellery " . $jewelry . "<br>";
mysqli_query($link, "
	INSERT INTO Boosts (`Gold`, XP, Stat, Quest, `Global`, Health, Attack, Def, Acc, Eva, Jade, Dungeon, Taxidermy, Auto, Jewelry, Name)
	VALUES ('$gold', '$xp', '$stat', '$quest', '$global', '$health', '$attack', '$def', '$acc', '$eva', '$jade', '$dungeon', '$boss', '$auto', '$jewelry', '$name')
	ON DUPLICATE KEY UPDATE
		`Gold`=VALUES(`Gold`),
		XP=VALUES(XP),
		Stat=VALUES(Stat),
		Quest=VALUES(Quest),
		`Global`=VALUES(`Global`),
		Health=VALUES(Health),
		Attack=VALUES(Attack),
		Def=VALUES(Def),
		Acc=VALUES(Acc),
		EVA=VALUES(Eva),
		Jade=VALUES(Jade),
		Dungeon=VALUES(Dungeon),
		Taxidermy=VALUES(Taxidermy),
		Auto=VALUES(Auto),
		Jewelry=VALUES(Jewelry)
") or die(mysqli_error($link));

/*mysqli_query($link, "UPDATE Boosts SET Gold = '$gold', XP = '$xp', Stat = '$stat', Quest = '$quest', Global = '$global', Health = '$health', Attack = '$attack', Def = '$def', 
Acc = '$acc', Eva = '$eva', Jade = '$jade', Dungeon = '$dungeon', Auto = '$auto', Jewelry = '$jewelry' WHERE Name LIKE '$name';");*/
mysqli_query($link, "UPDATE Userliste SET TokenUpdate = NOW() WHERE Name LIKE '$name';");
?>
