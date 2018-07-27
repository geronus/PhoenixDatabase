<?php
$content_links = array(
	array('file'=>'guild', 'text'=>'Update Guild'),
	array('file'=>'blacksmith', 'text'=>'Adjust Blacksmith Level'),
	array('file'=>'unpaidmilestones', 'text'=>'Unpaid DP Milestones'),
	array('file'=>'makeinactive', 'text'=>'Sort Inactive'),
	array('file'=>'blank', 'text'=>''),
	array('file'=>'', 'text'=>'Main')
);
$current_page = (isset($_GET['x']) ? $_GET['x'] : 'gtable');
foreach ($content_links AS $content_link) {
	if ($content_link['file'] == 'blank') {
		echo '<br>'. $content_link['text'] .'<br>';
	}
	else {
		$url = ($content_link['file'] ? 'admin.php?x='. $content_link['file'] : '');
		echo '<a href="/'. $url .'"'. ($content_link['file'] == $current_page ? ' class="active"' : '') .'>'. $content_link['text'] .'</a>';
	}
}
//echo "<A HREF='admin.php?x=guild'>Update Guild</A>";
//echo "<A HREF='admin.php?x=chest'>Add Chests</A><br>";
//echo "<A HREF='admin.php?x=goaladjust'>Adjust Guild Level Goal</A><br>";
//echo "<A HREF='admin.php?x=blacksmith'>Adjust Blacksmith Level</A>";
//echo "<A HREF='admin.php?x=winningnumber'>Enter Lottery Winning Nr</A><br>";
//echo "<A HREF='admin.php?x=unpaidmilestones'>Unpaid DP Milestones</A>";
//echo "<A HREF='admin.php?x=polls'>Manage Polls</A><br>";
//echo "<br><A HREF='admin.php?x=kicked'>Kick Member</A><br>";

?>
