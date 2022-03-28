<?php
require_once("db-init.php");
if (!isset($_SESSION))
    session_start();

$username = $_SESSION['userId'];
$email = $_POST['email'];
$puhnum = $_POST['puhnum'];
$osoite = $_POST['osoite'];
$kaupunki = $_POST['kaupunki'];

$sql = "UPDATE kayttaja SET email='$email', puhnum='$puhnum', osoite='$osoite', kaupunki='$kaupunki' WHERE nimi ='$username';";
$affected_rows = $db->exec("$sql");

echo json_encode("Tiedot päivitetty onnistuneesti.");
?>