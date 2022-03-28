<!DOCTYPE html>
<html>
    <head>
    <title>Eletorix - Kaiken elektroniikan kauppapaikka</title>
    <link rel="icon" href="kuvat/logo.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cuprum" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>   
    <link rel="stylesheet" href="ilmoitus.css">
    <link rel="stylesheet" href="banner.css"> 
    <link rel="stylesheet" href="viestit.css">
</head>
<body>    
    
<?php
    require_once("banner.php");  
    require_once("db-init.php"); 
    if (!isset($_SESSION['userId'])) header ("Location: index.php");
    
    $user = $_SESSION['userId'];
?>
    

<div class="viestitContainer">    
<div class="navAccount">

    <h1>Viestit</h1>

    <button class="add navBtn selected" id="saa">Saapuneet</button>
    <button class="add navBtn" id="lah">Lähetetyt</button>

    <a href="#"><img class="goUp" src="kuvat/arrow2.png" alt="Takaisin ylös"></a>
</div>
<div class="saapuneetViestit">
<div class="osio">
    <h2>Saapuneet viestit</h2>
</div>
<div class="osio">
<h3>Uudet viestit</h3>
<?php
    $stmt = $db->prepare("SELECT * FROM kayttaja WHERE nimi = '$user';");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $userID = $row['idkayttaja'];
    
    $stmt = $db->prepare("SELECT * FROM viesti WHERE idvastaanottaja = '$userID' AND luettu = 0 ORDER BY idviesti DESC;");
    $stmt->execute();
                
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['idviesti'];
        $lahID = $row['idlahettaja'];
        
        $stmt2 = $db->prepare("SELECT nimi FROM kayttaja WHERE idkayttaja = '$lahID';");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $lah = $row2['nimi'];
        
        $tuoID = $row['idtuote'];
        
        $stmt2 = $db->prepare("SELECT tuotteennimi FROM ilmoitus WHERE idilmoitukset = '$tuoID';");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC); 
        $tuo = $row2['tuotteennimi'];
        
        $sis = $row['sisalto'];
        $pvm = $row['pvm'];
        $lue = $row['luettu'];
        
        $pvm_koko = $row['pvm'];              
        $pvm = "";                                
        $pvm .= substr($pvm_koko,8,2).".";  //
        $pvm .= substr($pvm_koko,5,2).".";  //
        $pvm .= substr($pvm_koko,0,4);      //
        $pvmklo = "";
        $pvmklo .= substr($pvm_koko,10,6);
        
        $actionpage = "merkitse.php";

        echo 
        "<div class='viesti uusiViesti'>
        <form action='$actionpage' method='post'>
            <input name='idviesti' type='hidden' value='$id'>
            <input name='btn' type='submit' value='Merkitse luetuksi' class='merkitse'>
        </form>
        <p><b>Lähettäjä:</b> $lah</p>
        <p><b>Aihe:</b> Tuote: $tuo (ID:$tuoID)</p><p><b>Pvm:</b> $pvm klo $pvmklo</p> 
        <div class='viestiSis'>$sis

        <form action='uusiviesti.php' method='post'>
            <input name='idtuote' type='hidden' value='{$tuoID}'>
            <input name='vastaanottaja' type='hidden' value='{$lah}'>
            <input type='submit' value='Vastaa lähettäjälle' class='vastaaLah'>
        </form>
        </div>
        </div>
        ";
    }
    if ($stmt->rowCount() < 1) {
        echo "Ei uusia viestejä.";
    }
    ?>
</div>
<div class="osio">
    <?php

    echo "<h3>Kaikki viestit</h3>";
    $stmt = $db->prepare("SELECT * FROM viesti WHERE idvastaanottaja = '$userID' AND luettu = 1 ORDER BY idviesti DESC;");
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['idviesti'];
        $lahID = $row['idlahettaja'];
        
        $stmt2 = $db->prepare("SELECT nimi FROM kayttaja WHERE idkayttaja = '$lahID';");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $lah = $row2['nimi'];
        
        $tuoID = $row['idtuote'];
        
        $stmt2 = $db->prepare("SELECT tuotteennimi FROM ilmoitus WHERE idilmoitukset = '$tuoID';");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC); 
        $tuo = $row2['tuotteennimi'];
        
        $sis = $row['sisalto'];
        $pvm = $row['pvm'];
        
        $pvm_koko = $row['pvm'];              
        $pvm = "";                                
        $pvm .= substr($pvm_koko,8,2).".";  //
        $pvm .= substr($pvm_koko,5,2).".";  //
        $pvm .= substr($pvm_koko,0,4);      //
        $pvmklo = "";
        $pvmklo .= substr($pvm_koko,10,6);
        
        $lue = $row['luettu'];
        
        echo 
        "<div class='viesti'>
        <p><b>Lähettäjä:</b> $lah</p>
        <p><b>Aihe:</b> Tuote: $tuo (ID:$tuoID)</p><p><b>Pvm:</b> $pvm klo $pvmklo</p> 
        <div class='viestiSis'>$sis
        
        <form action='uusiviesti.php' method='post'>
            <input name='idtuote' type='hidden' value='{$tuoID}'>
            <input name='vastaanottaja' type='hidden' value='{$lah}'>
            <input type='submit' value='Vastaa lähettäjälle' class='vastaaLah'>
        </form>
        </div>
        </div>";
    }
    ?>
</div>
</div>
<div class="lahetetytViestit">
<div class="osio">
<h2>Lähetetyt viestit</h2>
</div>
<div class="osio">
    <?php
    $stmt = $db->prepare("SELECT * FROM viesti WHERE idlahettaja = '$userID' ORDER BY idviesti DESC;");
    $stmt->execute();
            
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $vasID = $row['idvastaanottaja'];
        
        $stmt2 = $db->prepare("SELECT nimi FROM kayttaja WHERE idkayttaja = '$vasID';");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $vas = $row2['nimi'];
        
        $tuoID = $row['idtuote'];
        
        $stmt2 = $db->prepare("SELECT tuotteennimi FROM ilmoitus WHERE idilmoitukset = '$tuoID';");
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC); 
        $tuo = $row2['tuotteennimi'];
        
        $sis = $row['sisalto'];
        $lue = $row['luettu'];
        $pvm = $row['pvm'];
        
        $pvm_koko = $row['pvm'];              
        $pvm = "";                                
        $pvm .= substr($pvm_koko,8,2).".";  //
        $pvm .= substr($pvm_koko,5,2).".";  //
        $pvm .= substr($pvm_koko,0,4);      //
        $pvmklo = "";
        $pvmklo .= substr($pvm_koko,10,6);

        echo 
        "<div class='viesti'>
        <p><b>Vastaanottaja:</b> $vas</p>
        <p><b>Aihe:</b> Tuote: $tuo (ID:$tuoID)</p><p><b>Pvm:</b> $pvm klo $pvmklo</p> 
        <div class='viestiSis'>$sis</div>
        </div>";
    }
?>
</div>
</div>
</div>
<?php
require_once("footer.html"); 
?>
    
<script src="javas.js"></script> 
<script type="text/javascript">
$(document).ready(function(){  
$(window).scroll(function(){
if ($(this).scrollTop() > 100) {
    $(".goUp").show();
} else {
    $(".goUp").hide();
}
});
    
    
$(".lahetetytViestit").hide();
$(".viesti").click(function(){
    var sis = $(this).children(".viestiSis");
    if (sis.is(":hidden")) {
    sis.show();
    } else { sis.hide(); }
});
$(".merkitse").click(function() {
    $(this).closest(".uusiViesti").removeClass("uusiViesti");
});
$(".navBtn").click(function(){
    $(this).addClass("selected");
    $(this).siblings().removeClass("selected");
    var id = $(this).attr("id");
    if (id == "lah") {
        $(".saapuneetViestit").hide();
        $(".lahetetytViestit").show();
    } else {
        $(".lahetetytViestit").hide();
        $(".saapuneetViestit").show();
    }
});
});
</script>
</body>
</html>