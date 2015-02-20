<?php
exit;
require_once("db.php");

$sql = "INSERT INTO `flags` (`teamID`, `taskID`, `flag`) values (?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->bind_param("sss", $_POST['teamID'], $_POST['taskID'], $_POST['flag']);
$stmt->execute();
$stmt->close();
?>
