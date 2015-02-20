<?php
require_once("config.php");

$db = new mysqli($host, $user, $pass, $name);
if($db->connect_errno)
	die("DB Connection: ".$db->connect_error);

unset($host, $user, $pass, $name);

?>
