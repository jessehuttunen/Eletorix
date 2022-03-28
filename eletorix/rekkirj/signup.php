<?php
    require "header.php";
?>


<main>
    <h1>Signup</h1>
    <form action="includes/signup.inc.php" method="post">
        <input type="text" name="uid" placeholder="Käyttäjätunnus"><br>
        <input type="text" name="mail" placeholder="Sähköposti"><br>
        <input type="password" name="pwd" placeholder="Salasana"><br>
        <input type="password" name="pwd-repeat" placeholder="Toista salasana"><br>
        <input type="text" name="puhnum" placeholder="Puhelinnumero"><br>
        <input type="text" name="osoite" placeholder="Osoite"><br>
        <input type="text" name="kaupunki" placeholder="Kaupunki"><br>
        <button class ="paivita" type="submit" name="signup-submit">Signup</button><br>
    </form>
</main>


<?php
    require "footer.php";
?>
