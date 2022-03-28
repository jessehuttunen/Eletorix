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
$tunnus =  $_POST['pois'];
echo "Ilmoitus " . $tunnus . " poistettiin<br><br>";
$affected_rows = $db->exec("DELETE FROM ilmoitus WHERE idilmoitukset LIKE '$tunnus'");
    echo "<a href='index.php'><button class='takaisin'>Takaisin</button></a> ";
    echo "</div>";
    echo "</div>";    
    require_once("footer.html"); 
?>
<script src="javas.js"></script>
</body>
</html>