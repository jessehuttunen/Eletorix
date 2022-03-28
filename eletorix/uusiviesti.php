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
    if (!isset($_SESSION['userId'])) header ("Location: rekkirj/index.php");
    if (!isset($_POST['vastaanottaja'])) header ("Location: index.php");
    if (!isset($_POST['idtuote'])) header ("Location: index.php");
    
    $lah = $_SESSION['userId'];
    
    if (isset($_POST['idtuote'])) {
        $tuoID = $_POST['idtuote'];
        $stmt = $db->prepare("SELECT tuotteennimi FROM ilmoitus WHERE idilmoitukset = '$tuoID';");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        $tuo = $row['tuotteennimi'];
    }
?>

<div class="viestitContainer">
<div class="lahetaUusiViesti">
<h1 class="osio">Lähetä uusi viesti</h1>
<form class="osio" method="post" action="sendmsg.php">
    <p><b>Aihe:</b> Tuote: <?php echo $tuo." (ID:".$tuoID.")"; ?></p>
    <p><b>Vastaanottaja: </b>
    <?php 
    if (isset($_POST['vastaanottaja'])) {
        $vas = $_POST['vastaanottaja'];
        echo $vas;
    }
    ?>
    </p>
    <p><textarea name="sisalto" rows="4" cols="50"></textarea></p>
    
    <input name="vastaanottaja" type="hidden" value="<?php echo $vas; ?>">
    <input name="lahettaja" type="hidden" value="<?php echo $lah; ?>" readonly>
    <input name="idtuote" type="hidden" value="<?php echo $tuoID; ?>">

    <p><input type="submit" value="Lähetä" class="vastaaLah"></p>
</form>
</div>
</div>

<?php
require_once("footer.html"); 
?>
    
<script src="javas.js"></script> 
    
</body>

</html>