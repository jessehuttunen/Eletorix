<!DOCTYPE html>
<html>
    <head>
    <title>Eletorix - Kaiken elektroniikan kauppapaikka</title>
    <link rel="icon" href="kuvat/logo.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="banner.css">  
    <link rel="stylesheet" href="ilmoitus.css">    
    <link rel="stylesheet" href="suosikit.css">   
</head>
<body>    
<?php
require_once("banner.php");  
require_once("db-init.php"); 
?>
<div class='suosikitContainer'>
<h2>Omat suosikit</h2>
<div class='suosikit'>
<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['userId'])) header ("Location: index.php");

    
if (isset($_SESSION['suosikit'])) {
for ($i=0; $i<sizeof($_SESSION['suosikit']); $i++) {       
    $idilmoitus = $_SESSION['suosikit'][$i];
    
    $stmt = $db->prepare("SELECT * FROM ilmoitus INNER JOIN kategoria ON ilmoitus.kategoria_idkategoria=kategoria.idkategoria INNER JOIN kayttaja ON ilmoitus.kayttaja_idkayttaja=kayttaja.idkayttaja WHERE idilmoitukset=:id");
    $stmt->bindValue(':id', $idilmoitus, PDO::PARAM_INT);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
    $id = $row['idilmoitukset'];
    $tuotteennimi = $row['tuotteennimi'];
    $paivays = $row['paivays'];
    $hinta = $row['hinta'];
    $tuotekuvaus = $row['tuotekuvaus'];
    $kuva = $row['kuva'];
    $kategoria = $row['idkategoria'];
    $kategorianimi = $row['kategorianimi'];
    $nimi = $row['nimi'];
    $email = $row['email'];
    $puhnum = $row['puhnum'];
    $osoite = $row['osoite'];
    $kaupunki = $row['kaupunki'];
    $ref = $_SERVER['PHP_SELF'];
        
    echo "  
            <div class='suosikki'>
            <form action='ilmoitus.php?id=$id' method='post'>
            <input type='hidden' name='id' value=" . $id . " />
            
            <button class='tyyliton' type='submit'></form>
            <div class='ilmoitus_banner'>";
            
            //<form action='addsuosikki.php' method='post'>
            //    <input type='hidden' name='pois' value=" . $id . " />
            //    <input type='hidden' name='referer' value='$ref'>
            //    <input type='hidden' name='idsuosikki' value=" . $id . " />
            //    <input value='Poista' type='image' src='kuvat/sydan.png' class='rasti'>
            //</form>   
    echo "

            
            <form action='delsuosikki2.php' method='post'>
                <input type='hidden' name='idsuosikki' value=" . $id . " />
                <input value='Poista' type='image' src='kuvat/pois_sydan.png' class='rasti'>
            </form> 
            
            </div>
    
            <img class='tuotekuva' src='kuvat/{$kuva}' alt='Ilmoituksen kuva'>
            <p class='otsikko'>{$tuotteennimi}</p>
            <p class='tuotehinta'>{$hinta} €</p>
            <p class='otsikko'>{$kategorianimi}</p>
            <p class='otsikko'>{$kaupunki}</p>
            </button>
            </div>
        ";
    }
    }  
} else { echo "Sinulla ei ole vielä suosikkeja. Lisää suosikkeja painamalla sydäntä ilmoituksen yläreunassa"; }
if (isset($_SESSION['suosikit'])) {
    if (sizeof($_SESSION['suosikit']) < 1) {
        echo "Lisää suosikkeja painamalla sydäntä ilmoituksen yläreunassa.";
    }
}
?>
</div>
</div>
<?php
require_once("footer.html");
?>
    
<script src="javas.js"></script> 
</body>
</html>