<?php

if (isset($_POST['login-submit'])) {
    require 'dbh.inc.php';
    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];
    //tyhjät kentät
    
    if (empty($mailuid) || empty($password)) {
        header("Location: ../index.php?error=emptyfields");
        exit();  
    }
    if(count($_POST)>0) {
	$result = mysqli_query($conn,"SELECT * FROM kayttaja WHERE nimi='" . $mailuid . "' and salasana = '". md5($password) ."'");
	$count  = mysqli_num_rows($result);
	if($count==0) {
         header("Location: ../index.php?error=wrongpwd");
        exit();
	} else {
        session_start();
        $row = $result -> fetch_assoc();
        $_SESSION['Id'] = $row['idkayttaja'];
        $_SESSION['tyyppi'] = $row['tyyppi'];
        $_SESSION['userId'] = $row['nimi']; //session tähän lisää []
        $_SESSION['userUid'] = $row['salasana'];
         header("Location: ../../index.php?");
        exit();
	}
}
}
else  {
    header("Location: ../index.php");
    exit();   
}


?>