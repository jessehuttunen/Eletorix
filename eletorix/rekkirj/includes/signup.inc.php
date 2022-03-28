<?php
//sivulle pääse vain painamalla nappia
if (isset($_POST['signup-submit'])) { 
    
    require 'dbh.inc.php';
    
    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];
    $puhnum = $_POST['puhnum'];
    $osoite = $_POST['osoite'];
    $kaupunki = $_POST['kaupunki'];
  
    

    //errors onko kenttä tyhjä
    
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($osoite) || empty($puhnum) || empty($kaupunki)) {
        header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail".$email);
        exit();
    }
    
    //molemmat alla olevat
    
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invalidemailuid");
        exit();         
    }
  
    //invalid email
    
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidemail&uid=".$username);
        exit();    
    }
    
    //valid username EI SAA OLLA ÄÅÖ
    
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invaliduid&mail=".$email);
        exit();    
    }
    
    //onko salasana oikein
    
    else if ($password !== $passwordRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail".$email);
        exit();    
    }
    
    else {
        $sql = "SELECT nimi FROM kayttaja WHERE nimi=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();        
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../signup.php?error=usertaken&mail=".$email);
                exit(); 
            }
            else {
                $sql ="INSERT INTO kayttaja (nimi, email, puhnum, osoite, kaupunki, salasana) VALUES (?,?,?,?,?,?)";
                $stmt =mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup.php?error=sqlerrorrrrrrr");
                    exit();        
                    }
                else {
                   //hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    
                    mysqli_stmt_bind_param($stmt, "ssssss", $username, $email, $puhnum, $osoite, $kaupunki, md5($password)); 
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?signup=success");
                    exit();
                }
            }
            
        }
        
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}

else {
    header("Location: ../signup.php");
    exit();    
}