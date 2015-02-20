<?php
require_once("team.php");
require_once("utility.php");
require_once("en.php");
$teams = array();
#NULL POINTER
$teams[] = array("name"=>"NULLPOINTER", "members"=>"Mehmet Can Demirel", "email"=>"can.demirel101@hacettepe.edu.tr");
$t = new Teams();
foreach($teams as $team)
{
	$pass=base64_encode(generateSalt(10));
	$t->register($team["name"], $pass, $team["email"], explode("<%#:#%>", $team["members"]));
}
?>
