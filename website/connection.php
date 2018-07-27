<?php
# Zugangsdaten
$db_server = 'server_address';
$db_benutzer = 'database_server';
$db_passwort = 'database_password';
$db_name = 'database_name';
date_default_timezone_set("Europe/London");
$objDT = new DateTime();
$offset = $objDT->getOffset();
$offsetHours = round(abs($offset) / 3600);
$offsetMinutes = round((abs($offset) - $offsetHours * 3600) / 60);
$offsetString  = ($offset < 0 ? '-' : '+');
$offsetString .= (strlen($offsetHours) < 2 ? '0' : '').$offsetHours;
$offsetString .= ':';
$offsetString .= (strlen($offsetMinutes) < 2 ? '0' : '').$offsetMinutes;

# Verbindungsaufbau
if($link = mysqli_connect($db_server, $db_benutzer, $db_passwort)) {
	if(mysqli_select_db($link, $db_name)) {
		mysqli_query($link, "SET time_zone = '$offsetString'") or die(mysqli_error());
	}
	else {
		echo 'some strange database error has stopped this working! like, it doesn\' exist!';
	}
}
else {
	echo 'contact someone, as the database server seems to be down.';
}
?>
