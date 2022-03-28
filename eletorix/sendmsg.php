<html>
    <head>
    <title>Eletorix - Kaiken elektroniikan kauppapaikka</title>
    <meta charset="UTF-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="kuvat/logo.png" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <link rel="stylesheet" href="banner.css">  
    <link rel="stylesheet" href="minisivut.css">    
</head>
<body>

<?php
require_once("banner.php");  
require_once("db-init.php");
if (!isset($_SESSION['userId'])) header ("Location: index.php");

echo "<div class='muokkaa'>" ;  
echo "<div class='ilmoitus'>" ; 
    
if (isset($_POST['vastaanottaja']) && isset($_POST['lahettaja']) && isset($_POST['idtuote'])) {
    $lah = $_POST['lahettaja'];
    $vas = $_POST['vastaanottaja'];
    $tuoID = $_POST['idtuote'];

    // Haetaan lähettäjän ID
    $stmt = $db->prepare("SELECT idkayttaja FROM kayttaja WHERE nimi = '$lah';");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $lahID = $row['idkayttaja'];
    
    // Haetaan vastaanottajan ID
    $stmt = $db->prepare("SELECT idkayttaja FROM kayttaja WHERE nimi = '$vas';");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $vasID = $row['idkayttaja'];
    
    if (isset($_POST['sisalto'])) {
        
        $sis = $_POST ['sisalto'];
        //echo "sessiomuuttuja 'userId':" . $lah ." lahID: " . $lahID . "<br>vas:" .$vas . " vasID:".$vasID."<br>tuoteID: ". $tuoID."<br>";

        $sql = ("INSERT INTO viesti (idvastaanottaja, idlahettaja, idtuote, sisalto, pvm) values ($vasID, $lahID, '$tuoID', '$sis', NOW());");
        
        $db->exec("$sql");
        
        echo "Viesti lähetetty onnistuneesti.";
        
    } else {
        echo "Valitusta.";
    }
} else {
    echo "Viestin lähetys ei onnistunut.";
}
echo "<a href='./ilmoitus.php?id=$tuoID'><button class='takaisin'>Takaisin ilmoitukseen</button></a> ";
echo "</div>";
echo "</div>";    
require_once("footer.html"); 
?>
    
<script src="javas.js"></script>
</body>
</html>