<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include("core-lib.inc.php");
include("connection.php");

echo "<HTML><HEAD><TITLE>Phoenix Lab</TITLE></HEAD><link rel='stylesheet' type='text/css' href='main.css?v=6' /><BODY>";
include_once("moneyconvert.php");
//include("lottery.php");

$site = (isset($_GET["x"]) ? $_GET['x'] : 'gtable');
$order = (isset($_GET["order"]) ? $_GET['order'] : 'Name');
$data = (isset($_GET['data']) ? $_GET["data"] : null);

if (isset($_GET['id'])) {
	$user = get_one_member_info($_GET['id'], true);
	$name = $user['Name'];
}
else {
	$name = (isset($_GET['name']) ? $_GET["name"] : null);
}


echo "<table width='100%' border='0' cellspacing=0 class='holder'>";
/* echo "<tr><td colspan=2 align=center>";
if(date('w') == 5){
	echo "<b>2 days left till weekly lotto drawing. Get your tickets!</b>";
}
if(date('w') == 6){
	echo "<b>1 days left till weekly lotto drawing. Get your tickets!</b>";
}
if(date('w') == 0){
	echo "<b>Weekly lotto drawing today! Don't have tickets? Get them now!</b>";
}
$q = mysql_query("SELECT * FROM Polls WHERE Active = '0' LIMIT 1;");
while($row = mysql_fetch_array($q)){
	echo "<br><br><b>There are active <A HREF='index.php?x=votes'>Polls</A>! Have you voted yet?</b>";
}
echo "</td></tr>"; */
echo "<tr><td align='left' valign='top' width='220px' class='menu'><div class='navigation'>";
include("content.php");
echo "</div><br><br><div class='statistics'>";
include("statistics.php");
echo "</div></td><td align='center' class='content' valign='top'>";
$site = $site . ".php";
include($site);
echo "</td></tr></table>";
echo "</body>";
