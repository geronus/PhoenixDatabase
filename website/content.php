<?php
$links = array (
	array('file'=>'gtable', 'text'=>'Guild Contributions'),
	array('file'=>'ptable', 'text'=>'Personal Stats'),
	array('file'=>'jtable', 'text'=>'Jade Skills'),
	array('file'=>'etable', 'text'=>'Equipment Level'),
	array('file'=>'ranking', 'text'=>'Rankings'),
	array('file'=>'blank', 'text'=>'Calculate'),
	array('file'=>'equipcalc', 'text'=>'Equipment Cost'),
	array('file'=>'jadecalc', 'text'=>'Jade Upgrade Cost'),
	array('file'=>'tscalc', 'text'=>'TS Info'),
	array('file'=>'blank', 'text'=>'Update'),
	//array('file'=>'profile', 'text'=>'Profile'),
	array('file'=>'equip', 'text'=>'Equipment'),
	array('file'=>'jade', 'text'=>'Jade Skills'),
	array('file'=>'boost', 'text'=>'Token Boosts')
);

$current_page = (isset($_GET['x']) ? $_GET['x'] : 'gtable');
foreach ($links AS $tlink) {
	if ($tlink['file'] == 'blank') {
		echo '<br>'. $tlink['text'] .'<br>';
	}
	else {
		echo '<a href="/?x='. $tlink['file'] .'"'. ($tlink['file'] == $current_page ? ' class="active"' : '') .'>'. $tlink['text'] .'</a>';
	}
}
/* echo "<A HREF='index.php?x=gtable'>Show Guild Contributions</A>";
echo "<A HREF='index.php?x=ptable'>Show Personal Stats</A>";
echo "<A HREF='index.php?x=jtable'>Show Jade Skills</A>";
echo "<A HREF='index.php?x=etable'>Show Equipment Level</A>";
echo "<A HREF='index.php?x=ranking'>Rankings</A>";
//echo "<A HREF='index.php?x=dplottery'>Show Monthly Lottery</A><br>";
//echo "<A HREF='index.php?x=weeklylottery'>Show Weekly Lottery</A><br>";
//echo "<A HREF='index.php?x=currentgdp'>Current GDP this month</A><br>";
//echo "<A HREF='index.php?x=votes'>Polls</A><br>";

echo "<br><br>";
echo "<A HREF='index.php?x=equipcalc'>Calculate Equipment Cost</A>";
echo "<A HREF='index.php?x=jadecalc'>Calculate Jade Upgrade Cost</A>";

echo "<br><br>";
echo "<A HREF='index.php?x=profile'>Update Profile</A>";
echo "<A HREF='index.php?x=equip'>Update Equip</A>";
echo "<A HREF='index.php?x=jade'>Update Jade Skills</A>";
echo "<A HREF='index.php?x=boost'>Update Token Boosts</A>"; */
