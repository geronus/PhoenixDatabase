<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
date_default_timezone_set("Europe/London");

include("connection.php");
include_once("core-lib.inc.php");

echo "<HTML><HEAD><TITLE>Phoenix Lab - Admin Tools</TITLE></HEAD><link rel='stylesheet' type='text/css' href='/main.css?v=1' /></HEAD><BODY>";
include_once("moneyconvert.php");


$site = (isset($_GET['x']) ? $_GET['x'] : 'gtable'); //$_GET["x"];
$order = (isset($_GET['order']) ? $_GET["order"] : 'Name');
$data = (isset($_GET["data"]) ? $_GET['data'] : null);
$name = (isset($_GET['name']) ? $_GET["name"] : null);

echo "<table width='100%' border='0' cellspacing=0 class='holder'>
<tr><td align='left' valign='top' width='200px' class='menu'><div class='navigation'>";
include("contenta.php");
echo "</td></td><td align='center' class='content' valign='top'>";
$site = $site . ".php";
include($site);
echo "</td></tr></table>";
echo "</body>";