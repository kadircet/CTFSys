<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

$host = "<censored>";
$user = "<censored>";
$pass = '<censored>';
$name = "<censored>";

define('DEBUG', false);
define('LOCALE', 'EN');
if(DEBUG===true)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

?>
