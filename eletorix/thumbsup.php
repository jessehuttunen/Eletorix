<?php
require_once("db-init.php");

if (!isset($_SESSION)) session_start();
if (isset($_SESSION['Id'])) {
    $idkayttaja = $_SESSION['Id'];
    $idkommentti = $_POST['idkommentti'];
    
    $sql = "SELECT COUNT(*) FROM kommentti_peukut WHERE kayttaja_idkayttaja = $idkayttaja AND kommentti_idkommentti = $idkommentti;";
    $result = $db->prepare($sql);
    $result->execute();
    $count = $result->fetchColumn();
    
    if ($count == 0) {
        $sql = "INSERT INTO kommentti_peukut (kayttaja_idkayttaja, kommentti_idkommentti) VALUES ('$idkayttaja', $idkommentti)";
        $db->exec("$sql");
        echo json_encode(1);
    } else {
        $sql = "DELETE FROM kommentti_peukut WHERE kayttaja_idkayttaja = '$idkayttaja' AND kommentti_idkommentti = '$idkommentti';";
        $db->exec("$sql");
        echo json_encode(-1);
    }
} else {
    echo json_encode("notLoggedIn");
}
?>
