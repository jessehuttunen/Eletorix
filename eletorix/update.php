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
echo "<div class='muokkaa'>" ;  
    echo "<div class='ilmoitus'>" ; 
$id =  $_POST['id'];

$tuotteennimi = $_POST['tuotteennimi'];
$tuotekuvaus = $_POST['tuotekuvaus'];
$hinta =  $_POST['hinta'];
$kategoria = $_POST['kategoria'];

    $kuva = $_FILES['kuva']['name'];



//image maxsize
$maxsize = 2097152;
    

$if = NULL;    
//TÄHÄN LISÄTTY v
if (isset($_FILES['kuva'])) {
   if ($_FILES['kuva']['size'] <= $maxsize) {
    $phpFileUploadErrors = array(
    0 => 'Kuvan lisäämisessä tapahtui ongelma',
    1 => 'Kuvaa ei lisätty liian suuren tiedostokoon takia. (PHP)',
    2 => 'Kuvaa ei lisätty liian suuren tiedostokoon takia. (HTML)',
    3 => 'Kuva lisättiin vain osittain.',
    4 => 'Kuvaa ei lisätty.',
    6 => 'Tilapäinen kansio puuttuu',
    7 => 'Levylle kirjoitus epäonnistui.',
    8 => 'PHP laajennus esti kuvan lisäyksen.',
    );
        
        $ext_error = false;
        
        $extensions = array('jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG');
        $file_ext = explode(".", $_FILES['kuva']['name']);
        $file_ext = end($file_ext);
       
       
       
       $uploaddir = 'kuvat/';
       $rndNumber = rand(0,999);
       $kuva = "img".$rndNumber."_".date('m-d-Y_hia').".".$file_ext;
       $uploadfile = $uploaddir . basename($kuva);
       
        
        
        if (!in_array($file_ext, $extensions)) {
            $ext_error = true;
        }
        
        if ($_FILES['kuva']['error']) {
            echo $phpFileUploadErrors[$_FILES['kuva']['error']];
        } elseif ($ext_error) {
            echo "Kuvatyyppi ei ole sallittu";
        } else {
            echo "Kuvan lataaminen onnistui.";
            $if = "kuva='$kuva',"; 
        }
        
        // siirretään kuva Images-kansioon
        move_uploaded_file($_FILES['kuva']['tmp_name'], $uploadfile);
       
       
       
    }  else  { echo "Kuvaa ei lisätty liian suuren tiedostokoon takia."; }
}
    
$sql = "UPDATE ilmoitus SET tuotteennimi='$tuotteennimi', hinta='$hinta', tuotekuvaus='$tuotekuvaus', $if kategoria_idkategoria='$kategoria' WHERE idilmoitukset='$id'";
$affected_rows = $db->exec("$sql");
    
echo "<br>Tiedot päivitetty ilmoitukseen:  ". $id;
echo "<a href='index.php'><button class='takaisin'>Takaisin</button></a> ";
echo "</div>";
    echo "</div>";
require_once("footer.html");    
?>
<script src="javas.js"></script>
</body>
</html>