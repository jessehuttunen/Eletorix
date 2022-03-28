<?php
/*
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "eletorix";
*/

$dBUsername = "L5275";
$dBPassword = "DBgh88InVPP853vKpheEsbtQMqNAUiTH";
$servername = "mysql.labranet.jamk.fi";
$dBName = "L5275_3";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}

?>