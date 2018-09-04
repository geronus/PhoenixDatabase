<?php

$db_server = 'server_address';
$db_benutzer = 'database_server';
$db_passwort = 'database_password';
$db_name = 'database_name';

date_default_timezone_set("Europe/London");

$server_date = new DateTime();
$server_offset_minutes = $server_date->getOffset() / 60;
$offsetString = get_offsetString($server_offset_minutes);

if($link = mysqli_connect($db_server, $db_benutzer, $db_passwort)) 
{
	if(mysqli_select_db($link, $db_name)) 
	{
		mysqli_query($link, "SET time_zone = '$offsetString'") or die(mysqli_error());
		
		$q = mysqli_query($link, "SELECT NOW()");

		while ($r = mysqli_fetch_assoc($q))
		{
			$mysql_date = $r['NOW()'];
			$mysql_date = DateTime::createFromFormat('Y-m-d H:i:s', $mysql_date);
			
			$interval = date_diff($mysql_date, $server_date);
			
			$mysql_offset_minutes = $interval->h * 60 + $interval->i;
			$mysql_offset_minutes = $interval->invert === 1 ? $mysql_offset_minutes * -1 : $mysql_offset_minutes;
			
			$offsetString = get_offsetString($server_offset_minutes + $mysql_offset_minutes);

			mysqli_query($link, "SET time_zone = '$offsetString'") or die(mysqli_error());
		}
	}
	else 
	{
		echo 'some strange database error has stopped this working! like, it doesn\' exist!';
	}
}
else
{
	echo 'contact someone, as the database server seems to be down.';
}

?>
