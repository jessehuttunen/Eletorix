<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Eletorix kirjautuminen</title>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link rel="icon" href="kuvat/logo.png" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <link rel="stylesheet" href="../index.css">
<link rel="stylesheet" href="../minisivut.css">
    <link rel="stylesheet" href="kirj.css">
   <!-- ccs tähä -->
</head>
<body>
    
<header>
        <a href="../index.php"><div id="logot">
        <img src="../kuvat/logo.svg" alt="Eletorix logo" id="logo"/>        
            </div></a>
</header>
            <img src="../kuvat/otsikko.svg" alt="Eletorix otsikko" id="otsikko"/>
    <h3 id="slogan">Kaiken elektroniikan kauppapaikka</h3><br>
        <div>
            <?php 
                if (isset($_SESSION['userId'])) {
                    echo '<form action="includes/logout.inc.php" method="post">
                <button type="submit" name="logout-submit">Logout</button>
            </form>';
                }
                else {
                    echo '<form action="includes/login.inc.php" method="post">
                <input type="text" name="mailuid" placeholder="Käyttäjätunnus"><br>
                <input type="password" name="pwd" placeholder="Salasana"><br>
                <button type="submit" name="login-submit">Login</button>
            </form>
            <a href="signup.php">Signup</a>
            ';
                }
            ?>
        </div>
    
    
</body>    
    
</html>