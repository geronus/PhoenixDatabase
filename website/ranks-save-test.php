<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("connection.php");
include_once('core-lib.inc.php');

foreach ($_POST['ranks'] AS $member) {
	mysqli_query($link, "
		UPDATE Userliste SET GameID = '". $member['id'] ."' 
		WHERE Name = '". $member['name'] ."'
	");
}
return response_json(array(
	'members'		=>		get_all_member_info()
));